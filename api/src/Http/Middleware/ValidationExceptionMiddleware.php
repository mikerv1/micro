<?php

declare(strict_types=1);

namespace Api\Http\Middleware;

use Api\Http\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Symfony\Component\VarDumper\VarDumper;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            //VarDumper::dump($handler); exit();
            return $handler->handle($request);
            //VarDumper::dump($handler); exit();
        } catch (ValidationException $e) {
            return new JsonResponse([
                'errors' => $e->getErrors()->toArray(),
            ], 400);
        }
    }
}
