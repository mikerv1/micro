<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Api\Http\Action;
use Slim\App;
use Api\Http\Middleware;
//use Api\Infrastructure\Framework\Middleware\CallableMiddlewareAdapter as CM;

return function (App $app, ContainerInterface $container) {
    
    $app->add(Middleware\BodyParamsMiddleware::class);
    $app->add(Middleware\DomainExceptionMiddleware::class);
    $app->add(Middleware\ValidationExceptionMiddleware::class);
    
    $app->get('/', Action\HomeAction::class . ':handle');
    
    $app->post('/auth/signup', Action\Auth\SignUp\RequestAction::class . ':handle');
    
    $app->post('/auth/signup/confirm', Action\Auth\SignUp\ConfirmAction::class . ':handle');
};
