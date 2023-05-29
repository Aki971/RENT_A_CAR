<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use App\Request\User\User as UserRequest;
use App\Request\User\LoginUser as LoginUserRequest;
use App\Request\User\UserByEmail;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class UserController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private readonly UserService $userService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->userService->getAll());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->userService->get($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(UserRequest $request): JsonResponse
    {
        try {
            $guid = $this->userService->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, UserRequest $request): JsonResponse
    {
        try {
            $this->userService->updateByGuid($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(string $guid): JsonResponse
    {
        try {
            $this->userService->deleteByGuid($guid);

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            return $this->jsonResponse($this->userService->login($request->params()));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function getByEmail(UserByEmail $request): JsonResponse
    {
        try {
            return $this->jsonResponse($this->userService->getByEmail($request->params()));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }
}
