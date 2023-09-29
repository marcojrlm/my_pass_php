<?php

namespace App\Services;

use App\Exceptions\ConflictException;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthService
{
    /**
     * @throws ConflictException
     */

    public function ThrowConflictIfUserExist(string $email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            throw new ConflictException('The user already access');
        }
        return $user;
    }

    /**
     * @throws UnauthorizedException
     */
    public function ThrowUnauthorizedIfUserNotExist(string $email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw new UnauthorizedException('Usuário ou senha inválidos');
        }
        return $user;
    }

    public function EncryptPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @throws UnauthorizedException
     */
    public function ThrowUnauthorizedIfInvalidPassword(string $password, string $hashedPassword): string
    {
        if (Hash::check($password, $hashedPassword)) {
            return true;
        } else {
            throw new UnauthorizedException('Usuário ou senha inválidos');
        }
    }

    public function createUser($user): void
    {
        User::create([
            'userName' => $user['userName'],
            'email' => $user['email'],
            'password' => $user['password'],
            'picture' => $user['picture'],
        ]);
    }

    public function generateJwtToken(int $userId): string
    {
        $key = env('JWT_SECRET');
        $payload = [
            'userId' => $userId,
            'iss' => env('app_url'),
            'aud' => env('app_url'),
            'iat' => 1356999524,
            'nbf' => 1357000000
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

}
