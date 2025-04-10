<?php

namespace PittacusW\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromCollection, WithHeadings
{
    use Exportable;

    private $fileName;

    private $data;

    private $headings;

    public function __construct(Collection $data, array $headings, string $fileName = null)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->fileName = ($fileName ?? 'File').'.xlsx';
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
