<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Document implements FromCollection, WithHeadings
{
    use Exportable;

    protected $collect;
    protected $header;

    public function __construct($collects, $headers)
    {
        $this->collect = $collects;
        $this->header  = $headers;
    }

    public function collection()
    {
        return collect($this->collect);
    }

    public function headings(): array
    {
        return $this->header;
    }

}
