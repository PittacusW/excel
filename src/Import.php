<?php

declare(strict_types=1);

namespace PittacusW\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Import implements ToCollection, WithHeadingRow
{
    use Importable;

    /** @var Collection<int, mixed> */
    private Collection $rows;

    public function __construct(
        private readonly int $headingRow = 1,
    ) {
        $this->rows = collect();
    }

    /**
     * @param  Collection<int, mixed>  $collection
     */
    public function collection(Collection $collection): void
    {
        $this->rows = $collection;
    }

    public function headingRow(): int
    {
        return max(1, $this->headingRow);
    }

    /**
     * @return Collection<int, mixed>
     */
    public function rows(): Collection
    {
        return $this->rows;
    }
}
