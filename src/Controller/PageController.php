<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use App\Request\Page\Page as PageRequest;
use App\Service\PageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class PageController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private readonly PageService $pageService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->pageService->getAll());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->pageService->get($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(PageRequest $request): JsonResponse
    {
        try {
            $guid = $this->pageService->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, PageRequest $request): JsonResponse
    {
        try {
            $this->pageService->updateByGuid($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(string $guid): JsonResponse
    {
        try {
            $this->pageService->deleteByGuid($guid);

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }
}
