<?php

namespace Api\Test\Unit\Http\Action;

use Api\Http\Action\HomeAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HomeActionTest extends TestCase
{
    public function testSuccess(): void
    {
        /**
         * @var Psr\Container\ContainerInterface $container
         */
        $container = require 'config/container.php';
        
        $action = new HomeAction($container);
        
        $response = $action->handle(new ServerRequest());
        
        self::assertEquals(200, $response->getStatusCode());
        
        self::assertJson($content = $response->getBody()->getContents());
        
        $data = json_decode($content, true);
        
        self::assertEquals([
            'name' => 'App API',
            'version' => '1.0',
        ], $data);
    }
}
