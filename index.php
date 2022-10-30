<?php

use Jrs\DI\Container;
use Jrs\Example\SimpleClass;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
$simpleClass = $container->get(SimpleClass::class);
echo $simpleClass->print();
