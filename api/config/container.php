<?php

declare(strict_types=1);

use \DI\ContainerBuilder;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;
//use Symfony\Component\VarDumper\VarDumper;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/' . (getenv('API_ENV') ?: 'prod') . '/*.php'),
]);

$config = $aggregator->getMergedConfig();
//VarDumper::dump($config); exit();
$builder = new ContainerBuilder();
$builder->addDefinitions($config);
$container = $builder->build();
//VarDumper::dump($container->get('config')['doctrine']); exit();
return $container;
