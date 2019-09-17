<?php

declare(strict_types=1);

namespace Api\Http\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response\JsonResponse;

class HomeAction implements RequestHandlerInterface
{
    //protected $conteiner;
    
    public function __construct()
    {
        //$this->container = $container;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //$myName = $this->container->get('name');
        
        return new JsonResponse([
            'name' => 'App API',
            'version' => '1.0',
        ]);
    }
}
