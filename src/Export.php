<?php

declare(strict_types=1);

namespace PittacusW\Excel;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromCollection, WithHeadings
{
    use Exportable;

    /** @var Collection<int, mixed> */
    private readonly Collection $rows;

    /** @var array<int, string> */
    private readonly array $headings;

    private readonly string $fileName;

    /**
     * @param  iterable<int, mixed>  $rows
     * @param  array<int, string>  $headings
     */
    public function __construct(iterable $rows, array $headings = [], ?string $fileName = null)
    {
        $normalizedRows = $this->normalizeRows($rows);
        $resolvedHeadings = $headings !== []
            ? array_values($headings)
            : $this->resolveHeadings($normalizedRows);

        $this->rows = $headings === []
            ? $this->normalizeAssociativeRows($normalizedRows, $resolvedHeadings)
            : $normalizedRows;
        $this->headings = $resolvedHeadings;
        $this->fileName = $this->normalizeFileName($fileName);
    }

    /**
     * @return Collection<int, mixed>
     */
    public function collection(): Collection
    {
        return $this->rows;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return $this->headings;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param  iterable<int, mixed>  $rows
     * @return Collection<int, mixed>
     */
    private function normalizeRows(iterable $rows): Collection
    {
        return collect($rows)->map(function (mixed $row): mixed {
            if ($row instanceof Arrayable) {
                return $row->toArray();
            }

            if (is_object($row) && method_exists($row, 'toArray')) {
                return $row->toArray();
            }

            if (is_object($row)) {
                return get_object_vars($row);
            }

            return $row;
        })->values();
    }

    /**
     * @param  Collection<int, mixed>  $rows
     * @return array<int, string>
     */
    private function resolveHeadings(Collection $rows): array
    {
        $firstRow = $rows->first();

        if (! is_array($firstRow) || array_is_list($firstRow)) {
            return [];
        }

        return array_keys($firstRow);
    }

    /**
     * @param  Collection<int, mixed>  $rows
     * @param  array<int, string>  $headings
     * @return Collection<int, mixed>
     */
    private function normalizeAssociativeRows(Collection $rows, array $headings): Collection
    {
        if ($headings === []) {
            return $rows;
        }

        return $rows->map(function (mixed $row) use ($headings): mixed {
            if (! is_array($row) || array_is_list($row)) {
                return $row;
            }

            return array_map(
                static fn (string $heading): mixed => $row[$heading] ?? null,
                $headings,
            );
        });
    }

    private function normalizeFileName(?string $fileName): string
    {
        $name = trim($fileName ?? 'export');

        if ($name === '') {
            $name = 'export';
        }

        if (str_ends_with(strtolower($name), '.xlsx')) {
            return $name;
        }

        return "{$name}.xlsx";
    }
}
