<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\TokenResponse;
use App\Models\Workspace;
use Illuminate\Database\DatabaseManager;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use Sprout\Attributes\CurrentTenant;
use Throwable;

final readonly class LoginController
{
    public function __construct(
        #[CurrentTenant]
        private Workspace $workspace,
        private DatabaseManager $database,
    ) {}

    /**
     * @throws ValidationException|Throwable
     */
    public function __invoke(LoginRequest $request): TokenResponse
    {
        $request->authenticate(
            workspaceId: $this->workspace->id,
        );

        /** @var NewAccessToken $token */
        $token = $this->database->transaction(
            callback: fn() => $request->user()?->createToken(
                name: $request->header('X-Integration-Name'),
                abilities: [$this->workspace->identifier . ':*'],
            ),
            attempts: 3,
        );

        return new TokenResponse(
            token: $token->plainTextToken,
        );
    }
}
