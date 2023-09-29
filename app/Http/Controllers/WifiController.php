<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Requests\WifiRquest;
use App\Models\Wifi;
use App\Services\CredentialsService;
use Illuminate\Http\Request;

class WifiController extends Controller
{

    private CredentialsService $credentialsService;
    private Wifi $model;

    public function __construct()
    {
        $this->credentialsService = new CredentialsService();
        $this->model = new Wifi;
    }

    /**
     * @throws ConflictException
     * @throws UnprocessableEntityException
     */
    public function CreateWifiCredential(WifiRquest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $key = 'name';
        $body = $request->only(['name', 'password']);
        $this->credentialsService->isUniqueCredential($this->model, $key, $body['name']);
        $this->credentialsService->createCredential($this->model, $body);
        return response('Created', 201);
    }

    /**
     * @throws UnprocessableEntityException
     */
    public function ListWifiCredentials(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $websites = $this->credentialsService->listCredentials($this->model);
        return response($websites, 201);
    }

    /**
     * @throws UnprocessableEntityException
     */
    public function getWifiCredential(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $id = intval($request->route('id'));
        $websites = $this->credentialsService->getCredential($this->model, $id);
        return response($websites, 200);
    }

    /**
     * @throws NotFoundException
     */
    public function deleteWifiCredential(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $id = $request->route('id');
        $websites = $this->credentialsService->deleteCredential($this->model, $id);
        return response($websites, 200);
    }
}
