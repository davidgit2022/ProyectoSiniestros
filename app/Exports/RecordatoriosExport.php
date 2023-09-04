<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class RecordatoriosExport implements FromCollection, WithHeadings,ShouldAutoSize, WithColumnFormatting
{

    use Exportable;
    
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function collection(): Collection
    {
        return $this->query;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,

        ];
    }

    public function headings(): array
    {
        return [
            'Fecha de envío',
            'Siniestro',
            'Placa',
            'Fecha entrega estimada',
            'Fecha / Hora respuesta',
            
        ];
    }
}
