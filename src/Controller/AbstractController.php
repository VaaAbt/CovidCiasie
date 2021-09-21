<?php

namespace App\Controller;

use DI\Container;

abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}