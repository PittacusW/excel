<?php

declare(strict_types=1);

use Maatwebsite\Excel\Excel as LaravelExcel;
use PittacusW\Excel\Excel;
use PittacusW\Excel\Export;
use PittacusW\Excel\Facades\Excel as ExcelFacade;
use PittacusW\Excel\Import;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

it('registers the excel service in the container', function () {
    expect(app(Excel::class))->toBeInstanceOf(Excel::class)
        ->and(app('pittacusw.excel'))->toBeInstanceOf(Excel::class);
});

it('downloads rows through the underlying laravel excel service', function () {
    $rows = collect([
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ]);

    $response = Mockery::mock(BinaryFileResponse::class);
    $laravelExcel = Mockery::mock(LaravelExcel::class);

    $laravelExcel
        ->shouldReceive('download')
        ->once()
        ->withArgs(function (Export $export, string $fileName, ?string $writerType, array $headers) {
            expect($fileName)->toBe('users.xlsx')
                ->and($writerType)->toBeNull()
                ->and($headers)->toBe(['X-Test' => '1'])
                ->and($export->headings())->toBe(['name', 'email'])
                ->and($export->collection()->all())->toBe([['Ada', 'ada@example.com']]);

            return true;
        })
        ->andReturn($response);

    $service = new Excel($laravelExcel);

    expect($service->download($rows, fileName: 'users', headers: ['X-Test' => '1']))->toBe($response);
});

it('imports rows through the facade', function () {
    $laravelExcel = Mockery::mock(LaravelExcel::class);

    $laravelExcel
        ->shouldReceive('import')
        ->once()
        ->withArgs(function (Import $import, string $file, ?string $disk, ?string $readerType) {
            expect($file)->toBe('users.xlsx')
                ->and($disk)->toBe('local')
                ->and($readerType)->toBeNull()
                ->and($import->headingRow())->toBe(2);

            $import->collection(collect([
                ['name' => 'Ada', 'email' => 'ada@example.com'],
            ]));

            return true;
        });

    app()->instance(LaravelExcel::class, $laravelExcel);
    app()->forgetInstance(Excel::class);
    app()->forgetInstance('pittacusw.excel');

    $rows = ExcelFacade::import('users.xlsx', 2, 'local');

    expect($rows->all())->toBe([
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ]);
});
