<?php

use Jrs\DI\Container;
use Jrs\Tests\Controller\TestController;
use Jrs\Tests\Service\SecondTestService;
use Jrs\Tests\Service\ServiceInterface;
use Jrs\Tests\Service\TestService;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$container->get(TestController::class, [ServiceInterface::class => ['class' => TestService::class]])->index();
echo '<br />';
$container->get(TestController::class, [ServiceInterface::class => ['class' => SecondTestService::class]])->index();
