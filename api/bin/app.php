#!/usr/bin/env php
<?php

declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;
//use Symfony\Component\VarDumper\VarDumper;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}
//
/**
 * @var \Psr\Container\ContainerInterface $container

 */
$container = require 'config/container.php';

$cli = new Application('Application console');
//
$entityManager = $container->get(EntityManagerInterface::class);

$connection = $entityManager->getConnection();

$configuration = new Doctrine\Migrations\Configuration\Configuration($connection);

$configuration->setMigrationsDirectory('src/Data/Migration');

$configuration->setMigrationsNamespace('Api\Data\Migration');

$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');

$cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');

Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

Doctrine\Migrations\Tools\Console\ConsoleRunner::addCommands($cli);

//VarDumper::dump($container->get('dot')); exit();

$commands = $container->get('config')['console']['commands'];

foreach ($commands as $command) {
    $cli->add($container->get($command));
}
$cli->run();
