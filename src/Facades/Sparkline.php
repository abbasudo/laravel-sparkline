<?php

namespace Llabbasmkhll\LaravelSparkline\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @mixin \Llabbasmkhll\LaravelSparkline\Sparkline
 *
 * @package Llabbasmkhll\LaravelSparkline\Facades
 */
class Sparkline extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Sparkline';
    }
}
