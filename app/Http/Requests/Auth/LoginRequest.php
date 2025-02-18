<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class LoginRequest extends FormRequest
{
    /** @return array<string,ValidationRule|list<string>|string> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /** @throws ValidationException */
    public function authenticate(string $workspaceId): void
    {
        $this->ensureIsNotRateLimited($workspaceId);

        if ( ! Auth::attempt($this->only('email', 'password'))) {
            RateLimiter::hit($this->throttleKey($workspaceId));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($workspaceId));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(string $workspaceId): void
    {
        if ( ! RateLimiter::tooManyAttempts($this->throttleKey($workspaceId), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey($workspaceId));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(string $workspaceId): string
    {
        return Str::transliterate(
            string: Str::lower(
                value: $this->string('email')->toString(),
            ) . '|' . $workspaceId,
        );
    }
}
