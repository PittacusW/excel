<?php

declare(strict_types=1);

namespace PittacusW\Excel\Tests;

use Maatwebsite\Excel\ExcelServiceProvider as LaravelExcelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use PittacusW\Excel\ExcelServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelExcelServiceProvider::class,
            ExcelServiceProvider::class,
        ];
    }
}
