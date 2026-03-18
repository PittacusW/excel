<?php

declare(strict_types=1);

use PittacusW\Excel\Import;

it('stores imported rows for later access', function () {
    $import = new Import;
    $rows = collect([
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ]);

    $import->collection($rows);

    expect($import->rows())->toBe($rows);
});

it('uses the configured heading row', function () {
    $thirdHeadingRowImport = new Import(3);
    $fallbackHeadingRowImport = new Import(0);

    expect($thirdHeadingRowImport->headingRow())->toBe(3)
        ->and($fallbackHeadingRowImport->headingRow())->toBe(1);
});
