<?php

namespace Jrs\Tests\Service;

class SecondTestService implements ServiceInterface
{
    public function execute(): mixed
    {
        echo 'Deu boa 2';
        return true;
    }
}
