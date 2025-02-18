<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Workspace;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Workspace> */
final class WorkspaceFactory extends Factory
{
    /** @var class-string<Workspace> */
    protected $model = Workspace::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->realText(),
            'identifier' => $this->faker->unique()->userName(),
            'resource_key' => $this->faker->uuid(),
        ];
    }
}
