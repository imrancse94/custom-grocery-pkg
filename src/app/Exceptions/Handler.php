<?php

namespace Imrancse94\Grocery\app\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;
class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ThrottleRequestsException $exception, $request) {
            $try_after = $exception->getHeaders()['Retry-After'] ?? null;
            return response()->json([
                'error' => 'rate_limit',
                'message' => "You have exceeded the number of allowed requests. Please try after $try_after seconds later.",
                'retry_after' => $try_after." seconds",
            ], 429);
        });
    }
}
