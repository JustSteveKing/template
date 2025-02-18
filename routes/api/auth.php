<?php

declare(strict_types=1);

use App\Http\Controllers\Auth;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router): void {
    $router->post('login', Auth\LoginController::class);
});
