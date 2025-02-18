<?php

declare(strict_types=1);

namespace App\Http\Requests\Projects;

use App\Http\Payloads\Projects\NewProject;
use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    /** @return array<string,list<string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function payload(): NewProject
    {
        return new NewProject(
            name: $this->string('name')->toString(),
            description: $this->string('description')->toString(),
        );
    }
}
