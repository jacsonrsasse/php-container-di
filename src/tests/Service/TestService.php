<?php

namespace Jrs\Tests\Service;

class TestService implements ServiceInterface
{
    public function execute(): mixed
    {
        echo 'Deu boa';
        return true;
    }
}
