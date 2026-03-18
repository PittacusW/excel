<?php

declare(strict_types=1);

namespace PittacusW\Excel\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @method static BinaryFileResponse download(iterable<int, mixed> $rows, array<int, string> $headings = [], ?string $fileName = null, ?string $writerType = null, array<string, string> $headers = [])
 * @method static bool store(iterable<int, mixed> $rows, string $filePath, array<int, string> $headings = [], ?string $disk = null, ?string $writerType = null, array<string, mixed>|string $diskOptions = [])
 * @method static string raw(iterable<int, mixed> $rows, array<int, string> $headings = [], ?string $writerType = null)
 * @method static Collection<int, mixed> import(string|UploadedFile $file, int $headingRow = 1, ?string $disk = null, ?string $readerType = null)
 * @method static \PittacusW\Excel\Export makeExport(iterable<int, mixed> $rows, array<int, string> $headings = [], ?string $fileName = null)
 * @method static \PittacusW\Excel\Import makeImport(int $headingRow = 1)
 *
 * @see \PittacusW\Excel\Excel
 */
class Excel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'pittacusw.excel';
    }
}
