<?php

namespace Jrs\Tests\Controller;

use Jrs\Tests\Service\ServiceInterface;

class TestController
{
    public function __construct(
        private ServiceInterface $service
    ) {
    }

    public function index()
    {
        return $this->service->execute();
    }
}
