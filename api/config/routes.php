<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Api\Http\Action;
use Slim\App;
use Api\Http\Middleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app, ContainerInterface $container) {
    
    $app->add(Middleware\BodyParamsMiddleware::class);
    $app->add(Middleware\DomainExceptionMiddleware::class);
    $app->add(Middleware\ValidationExceptionMiddleware::class);
    
    $auth = $container->get(Middleware\ResourceServerMiddleware::class);
    
    $app->get('/', Action\HomeAction::class . ':handle');
    
    $app->post('/auth/signup', Action\Auth\SignUp\RequestAction::class . ':handle');
    
    $app->post('/auth/signup/confirm', Action\Auth\SignUp\ConfirmAction::class . ':handle');
    
    $app->post('/oauth/auth', Action\Auth\OAuthAction::class . ':handle');
    
    $app->group('/profile', function (RouteCollectorProxy $group) {
        $group->get('', Action\Profile\ShowAction::class . ':handle');
    })->add($auth);
};
