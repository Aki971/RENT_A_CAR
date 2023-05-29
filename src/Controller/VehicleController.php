<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use App\Request\Vehicle\Vehicle as VehicleRequest;
use App\Service\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class VehicleController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private readonly VehicleService $vehicleService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->vehicleService->getAll());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->vehicleService->get($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(VehicleRequest $request): JsonResponse
    {
        try {
            $guid = $this->vehicleService->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, VehicleRequest $request): JsonResponse
    {
        try {
            $this->vehicleService->updateByGuid($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(string $guid): JsonResponse
    {
        try {
            $this->vehicleService->deleteByGuid($guid);

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }
}
