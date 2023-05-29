<?php

namespace App\Infrastructure\Symfony\EventListener;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class Violation implements EventSubscriberInterface
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleValidationErrors', 0]
            ]
        ];
    }

    public function handleValidationErrors(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse($exception->getMessage(), JsonResponse::HTTP_NOT_FOUND);

        if ($exception instanceof ValidationException) {
            $response = new JsonResponse($exception->errors(), Response::HTTP_BAD_REQUEST);
        }

        $event->setResponse($response);
    }
}
