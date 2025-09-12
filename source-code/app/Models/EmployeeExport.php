<?php


namespace App\Models;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeExport implements FromCollection, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;

    private $data;

    public function __construct($data)
    {

        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'E'   => NumberFormat::FORMAT_TEXT,
            'F'   => NumberFormat::FORMAT_TEXT,
            'L'   => NumberFormat::FORMAT_TEXT,
        ];
    }
}
