<?php

declare(strict_types=1);

namespace PittacusW\Excel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Excel as LaravelExcel;

class ExcelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Excel::class, function (Application $app): Excel {
            return new Excel($app->make(LaravelExcel::class));
        });

        $this->app->alias(Excel::class, 'pittacusw.excel');
    }
}
