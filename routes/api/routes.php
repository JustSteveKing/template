<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router): void {
    // Authentication Routes
    $router->middleware(['identifier'])->as('auth:')->prefix('auth')->group(base_path(
        path: 'routes/api/auth.php',
    ));

    $router->middleware(['auth:sanctum'])->group(static function () use ($router): void {
        // User Resource Routes
        $router->as('users:')->prefix('users')->group(base_path(
            path: 'routes/api/users.php',
        ));

        // Project Resource Routes
        $router->as('projects:')->prefix('projects')->middleware(['throttle:30,1'])->group(base_path(
            path: 'routes/api/projects.php',
        ));
    });
});
