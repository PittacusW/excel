<?php

declare(strict_types=1);

use PittacusW\Excel\Export;

it('appends an xlsx extension when needed', function () {
    $export = new Export([], fileName: 'report');

    expect($export->fileName())->toBe('report.xlsx');
});

it('keeps the xlsx extension when it is already present', function () {
    $export = new Export([], fileName: 'report.xlsx');

    expect($export->fileName())->toBe('report.xlsx');
});

it('derives headings from associative rows', function () {
    $export = new Export([
        ['name' => 'Ada', 'email' => 'ada@example.com'],
        ['name' => 'Grace', 'email' => 'grace@example.com'],
    ]);

    expect($export->headings())->toBe(['name', 'email'])
        ->and($export->collection()->all())->toBe([
            ['Ada', 'ada@example.com'],
            ['Grace', 'grace@example.com'],
        ]);
});

it('preserves custom headings without remapping row values', function () {
    $export = new Export(
        rows: [
            ['Ada', 'ada@example.com'],
        ],
        headings: ['Name', 'Email'],
    );

    expect($export->headings())->toBe(['Name', 'Email'])
        ->and($export->collection()->all())->toBe([
            ['Ada', 'ada@example.com'],
        ]);
});
