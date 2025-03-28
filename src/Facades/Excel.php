<?php

namespace PittacusW\Excel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PittacusW\Excel\Excel
 */
class Excel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \PittacusW\Excel\Excel::class;
    }
}
