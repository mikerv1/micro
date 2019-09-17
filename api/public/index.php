<?php

declare(strict_types=1);

error_reporting(E_ALL);

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;
//use Symfony\Component\VarDumper\VarDumper;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}

(function () {
    $container = require 'config/container.php';
    
    //var_dump ($container); exit();
    
    AppFactory::setContainer($container);

    $app = AppFactory::create();
    
    //VarDumper::dump($container); exit();
    
    (require 'config/routes.php')($app, $container);
    
    $app->run();
})();
