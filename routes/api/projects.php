<?php

declare(strict_types=1);

use App\Http\Controllers\Projects;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::tenanted(static function (Router $router): void {
//    $router->get('/',)->name('index');
    $router->post('/', Projects\StoreController::class)->name('store');
});
