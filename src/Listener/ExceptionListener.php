<?php

namespace App\Listener;

use App\Exception\UserInterfaceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!in_array('application/json', $event->getRequest()->getAcceptableContentTypes())) {
            return;
        }

        $code = $exception instanceof UserInterfaceException ? 400 : 500;

        $responseData = [
            'code' => $code,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
        ];

        $event->setResponse(new JsonResponse($responseData, $code));
    }
}
