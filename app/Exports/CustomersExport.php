<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::orderBy('id', 'asc')->get();
    }

    public function map($customer):array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->codigo,
            $customer->clienteType->name,
            $customer->created_at->format('d-m-Y H:i:s'),
            $customer->state == 1 ? 'Activo' : 'Inactivo',
        ];
    }

    public function headings():array{
        return[
            'ID',
            'Nombre',
            'Codigo',
            'Tipos de cliente',
            'Fecha',
            'Estado'
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(8);   // ID
        $sheet->getColumnDimension('B')->setWidth(30);  // Nombre
        $sheet->getColumnDimension('C')->setWidth(15);  // Costo
        $sheet->getColumnDimension('D')->setWidth(15);  // Fecha
        $sheet->getColumnDimension('E')->setWidth(25);  // Estado
        $sheet->getColumnDimension('F')->setWidth(10);  // Estado
        
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],  
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);

        $sheet->getStyle('A2:E' . ($sheet->getHighestRow()))->applyFromArray([

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);

        return [];
    }
}
