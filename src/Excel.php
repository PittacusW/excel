<?php

declare(strict_types=1);

namespace PittacusW\Excel;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel as LaravelExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Excel
{
    public function __construct(
        private readonly LaravelExcel $excel,
    ) {}

    /**
     * @param  iterable<int, mixed>  $rows
     * @param  array<int, string>  $headings
     * @param  array<string, string>  $headers
     */
    public function download(
        iterable $rows,
        array $headings = [],
        ?string $fileName = null,
        ?string $writerType = null,
        array $headers = [],
    ): BinaryFileResponse {
        $export = new Export($rows, $headings, $fileName);

        /** @var BinaryFileResponse $response */
        $response = $this->excel->download($export, $export->fileName(), $writerType, $headers);

        return $response;
    }

    /**
     * @param  iterable<int, mixed>  $rows
     * @param  array<int, string>  $headings
     * @param  array<string, mixed>|string  $diskOptions
     */
    public function store(
        iterable $rows,
        string $filePath,
        array $headings = [],
        ?string $disk = null,
        ?string $writerType = null,
        array|string $diskOptions = [],
    ): bool {
        return $this->excel->store(
            new Export($rows, $headings),
            $filePath,
            $disk,
            $writerType,
            $diskOptions,
        );
    }

    /**
     * @param  iterable<int, mixed>  $rows
     * @param  array<int, string>  $headings
     */
    public function raw(
        iterable $rows,
        array $headings = [],
        ?string $writerType = null,
    ): string {
        return $this->excel->raw(new Export($rows, $headings), $writerType);
    }

    /**
     * @return Collection<int, mixed>
     */
    public function import(
        string|UploadedFile $file,
        int $headingRow = 1,
        ?string $disk = null,
        ?string $readerType = null,
    ): Collection {
        $import = new Import($headingRow);

        $this->excel->import($import, $file, $disk, $readerType);

        return $import->rows();
    }

    /**
     * @param  iterable<int, mixed>  $rows
     * @param  array<int, string>  $headings
     */
    public function makeExport(iterable $rows, array $headings = [], ?string $fileName = null): Export
    {
        return new Export($rows, $headings, $fileName);
    }

    public function makeImport(int $headingRow = 1): Import
    {
        return new Import($headingRow);
    }
}
