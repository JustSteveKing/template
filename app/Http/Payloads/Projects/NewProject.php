<?php

declare(strict_types=1);

namespace App\Http\Payloads\Projects;

final readonly class NewProject
{
    public function __construct(
        public string $name,
        public string $description,
    ) {}

    /** @return array{name:string,description:string} */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
