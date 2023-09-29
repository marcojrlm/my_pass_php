<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Requests\CardsRequest;
use App\Models\Card;
use App\Services\CredentialsService;
use App\Utils\Utils;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    private CredentialsService $credentialsService;
    private Utils $utils;
    private Card $model;

    public function __construct()
    {
        $this->credentialsService = new CredentialsService();
        $this->utils = new Utils();
        $this->model = new Card;
    }

    /**
     * @throws ConflictException
     * @throws UnprocessableEntityException
     */
    public function CreateCardCredential(CardsRequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $key = 'name';
        $body = $request->only(['name', 'cvv', 'number', 'password']);
        $this->credentialsService->isUniqueCredential($this->model, $key, $body['name']);
        $user = $request->get('user');
        $this->credentialsService->createCredential($this->model, $body, $user);
        return response('Created', 201);
    }

    /**
     * @throws UnprocessableEntityException
     */
    public function ListCardsCredentials(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $cards = $this->credentialsService->listCredentials($this->model);
        return response($cards, 201);
    }

    /**
     * @throws NotFoundException
     */
    public function GetCardCredential(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $id = intval($request->route('id'));
        $card = $this->credentialsService->getCredential($this->model, $id);
        return response($card, 200);
    }

    /**
     * @throws NotFoundException
     */
    public function DeleteCardCredential(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $id = $request->route('id');
        $this->credentialsService->deleteCredential($this->model, $id);
        return response('Deleted', 200);
    }
}
