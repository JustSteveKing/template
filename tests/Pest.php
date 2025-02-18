<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

// Set up Team Management for testing.
pest()->project()->github('juststeveking/template');

pest()
    ->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in(-__DIR__);

function snactum(array $abilities = ['*']): HasApiTokens|Authenticatable
{
    return Sanctum::actingAs(
        user: User::factory()->create(),
        abilities: $abilities,
    );
}
