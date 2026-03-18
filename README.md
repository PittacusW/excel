# PittacusW Excel

Lightweight collection-first helpers for importing and exporting spreadsheets in Laravel.

This package wraps `maatwebsite/excel` with a smaller API for the common cases:

- export collections or arrays with optional headings
- auto-derive headings from associative rows
- import spreadsheets directly into an `Illuminate\Support\Collection`
- work cleanly across Laravel 9, 10, 11, 12, and 13

## Compatibility

| Laravel | Testbench | PHP |
| --- | --- | --- |
| 9.x | 7.x | 8.1+ |
| 10.x | 8.x | 8.1+ |
| 11.x | 9.x | 8.2+ |
| 12.x | 10.x | 8.2+ |
| 13.x | 11.x | 8.3+ |

## Installation

```bash
composer require pittacusw/excel
```

## Usage

Inject the service:

```php
use PittacusW\Excel\Excel;

class ExportUsersController
{
    public function __invoke(Excel $excel)
    {
        return $excel->download(
            rows: [
                ['name' => 'Ada', 'email' => 'ada@example.com'],
                ['name' => 'Grace', 'email' => 'grace@example.com'],
            ],
            fileName: 'users',
        );
    }
}
```

Use the facade explicitly:

```php
use PittacusW\Excel\Facades\Excel;

$rows = Excel::import(
    file: $request->file('users.xlsx'),
    headingRow: 1,
);
```

### Export API

```php
use PittacusW\Excel\Excel;

$excel->download(
    rows: [
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ],
    headings: ['Name', 'Email'],
    fileName: 'users',
);

$excel->store(
    rows: [
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ],
    filePath: 'exports/users.xlsx',
);

$contents = $excel->raw(
    rows: [
        ['name' => 'Ada', 'email' => 'ada@example.com'],
    ],
);
```

### Import API

```php
use PittacusW\Excel\Excel;

$rows = $excel->import(
    file: storage_path('app/imports/users.xlsx'),
    headingRow: 1,
);
```

Imported rows are returned as an `Illuminate\Support\Collection`.

## Public API

```php
download(iterable $rows, array $headings = [], ?string $fileName = null, ?string $writerType = null, array $headers = [])
store(iterable $rows, string $filePath, array $headings = [], ?string $disk = null, ?string $writerType = null, array|string $diskOptions = [])
raw(iterable $rows, array $headings = [], ?string $writerType = null)
import(string|\Illuminate\Http\UploadedFile $file, int $headingRow = 1, ?string $disk = null, ?string $readerType = null)
makeExport(iterable $rows, array $headings = [], ?string $fileName = null)
makeImport(int $headingRow = 1)
```

## Upgrade Notes

- The package now ships a real `PittacusW\Excel\Excel` service behind the facade.
- The automatic global `Excel` alias was removed to avoid collisions with `Maatwebsite\Excel\Facades\Excel`.
- Exports now normalize associative rows and can infer headings automatically.
- Imports now keep the imported collection available after execution.

## Testing

```bash
composer test
```
