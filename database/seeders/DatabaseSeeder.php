<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Workspace;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $workspace = Workspace::factory()->create([
            'name' => 'JustSteveKing',
            'description' => 'This is my workspace, hands off',
            'identifier' => 'juststeveking',
        ]);

        User::factory()->create([
            'name' => 'Steve McDougall',
            'email' => 'juststevemcd@gmail.com',
            'workspace_id' => $workspace->id,
        ]);

        Workspace::factory()->create();
    }
}
