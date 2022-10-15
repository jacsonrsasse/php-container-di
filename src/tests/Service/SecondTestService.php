<?php

namespace Jrs\Tests\Service;

use Jrs\Tests\Entity\TestEntity;

class SecondTestService implements ServiceInterface
{
    public function __construct(private TestEntity $entity)
    {
        echo 'Injetou a classe automaticamente!';
    }

    public function execute(): mixed
    {
        echo 'Deu boa 2';
        return true;
    }
}
