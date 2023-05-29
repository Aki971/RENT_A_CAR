<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use App\Request\BookingHistory\BookingHistory as BookingHistoryRequest;
use App\Service\BookingHistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class BookingHistoryController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private readonly BookingHistoryService $bookingHistoryService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->bookingHistoryService->getAll());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->bookingHistoryService->get($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(BookingHistoryRequest $request): JsonResponse
    {
        try {
            $guid = $this->bookingHistoryService->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, BookingHistoryRequest $request): JsonResponse
    {
        try {
            $this->bookingHistoryService->updateByGuid($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(string $guid): JsonResponse
    {
        try {
            $this->bookingHistoryService->deleteByGuid($guid);

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function getHistoryByUser(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->bookingHistoryService->getHistoryByUser($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }
}
