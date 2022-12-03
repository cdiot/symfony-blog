<?php

namespace App\EventListener;

use App\Service\Database;
use Doctrine\DBAL\Exception\ConnectionException;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{
    public function __construct(
        private Database $database,
        private RouterInterface $router
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ConnectionException || $exception instanceof TableNotFoundException) {
            $this->database->createDatabase();
            $response = new RedirectResponse($this->router->generate('welcome'));
            $event->setResponse($response);
        }
    }
}
