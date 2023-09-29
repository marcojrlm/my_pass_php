<?php

namespace App\Services;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnprocessableEntityException;
use App\Utils\Utils;
use Illuminate\Database\Eloquent\Model;

class CredentialsService
{
    public function isUniqueCredential($model, string $key, string $access): void
    {
        $credential = $model::where($key, $access)->first();
        if ($credential) {
            throw new ConflictException("You already have a credential called $access");
        }
    }

    public function createCredential(Model $model, $body, $user): void
    {
        try {
            $util = new Utils();
            $body['password'] = $util->encryptPassword($body['password']);
            $user->cards()->create($body);
        } catch (\Exception $e) {
            dd($e);
            throw new UnprocessableEntityException("Error when saving");
        }
    }

    public function listCredentials(Model $model, $user): \Illuminate\Database\Eloquent\Collection
    {
        try {
            $credentials = $user->$model::all();
            $util = new Utils();
            foreach ($credentials as $credential) {
                $credential['password'] = $util->decryptPassword($credential['password']);
            }
            return $credentials;
        } catch (\Exception $e) {
            throw new UnprocessableEntityException("Unable to get data");
        }
    }

    public function getCredential(Model $model, int $id)
    {
        $util = new Utils();

        $credential = $model::where('id', $id)->first();
        $credential['password'] = $util->decryptPassword($credential['password']);

        if (!$credential) {
            throw new NotFoundException("Credential $id not found");
        }
        return $credential;
    }

    public function deleteCredential(Model $model, int $id): void
    {
        $credential = $model::where('id', $id)->first();
        if (!$credential) {
            throw new NotFoundException("Credential $id not found");
        }
        $model::where('id', $id)->delete();
    }
}
