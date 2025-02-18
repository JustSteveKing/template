<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

final class IntegrationNameHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->hasHeader('X-Integration-Name')) {
            throw new InvalidArgumentException(
                message: 'The request must contain the X-Integration-Name header.',
                code: Response::HTTP_BAD_REQUEST,
            );
        }

        return $next($request);
    }
}
