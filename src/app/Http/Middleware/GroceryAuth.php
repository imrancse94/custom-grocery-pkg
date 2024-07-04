<?php

namespace Imrancse94\Grocery\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Imrancse94\Grocery\app\Exceptions\GroceryTokenExpiredException;
use Imrancse94\Grocery\app\Exceptions\MissingGroceryToken;
use Imrancse94\Grocery\libs\JwtHelper;
use Symfony\Component\HttpFoundation\Response;

class GroceryAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        try {

            $token = $request->bearerToken();

            if (empty($token)) {
                throw new MissingGroceryToken('Bearer token is missing');
            }

            JwtHelper::validateToken('access_token', $token);

        } catch (MissingGroceryToken $ex) {
            return response()->json([
                'type' => 'missing_token',
                'error' => $ex->getMessage()
            ], 422);
        } catch (GroceryTokenExpiredException $ex) {
            return response()->json([
                'type' => 'token_expired',
                'error' => $ex->getMessage()
            ], 401);
        } catch (\Exception $ex) {
            return response()->json([
                'type' => 'unauthenticated',
                'error' => 'Token is invalid'
            ], 401);
        }

        return $next($request);
    }
}
