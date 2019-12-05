<?php

/*
 * This file is part of HGGAPP.com
 *
 * (c) High Grade Gypsum LLC - 2019
 *     Eric Zhivalyuk (eric@gypsumresources.com)
 *     Brandon Lis (brandon@gypsumresources.com)
 *
 *     DO NOT COPY OR REDISTRIBUTE!
 */

namespace KnightAR\Laravel\Config\Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../build/bootstrap.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
