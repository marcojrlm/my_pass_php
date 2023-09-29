<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PHPUnit\Exception;


class JwtValidator
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws UnauthorizedException
     */

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken('Authorization');
        if (!$token) throw new UnauthorizedException('Token não enviado');
        $key = env('JWT_SECRET');

        try {
            $response = JWT::decode($token, new Key($key, 'HS256'));
            $user = $this->getUserById($response->userId);
            $request->attributes->add(['user' => $user]);
            return $next($request);
        } catch (\Exception $e) {
            throw new UnauthorizedException('Token inválido');
        }
    }

    public function getUserById(int $userId)
    {
        $users = new User();
        $user = $users::where('id', $userId)->first();
        if(!$user) throw new UnauthorizedException();
        return $user;
    }
}
