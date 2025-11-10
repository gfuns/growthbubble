<?php
namespace App\Exports;

use App\Models\Invoice;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportInvoice implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $rowCount = 0;

    public function __construct()
    {
        //
    }

    public function collection()
    {
        return Invoice::orderBy("id", "desc")->get();

    }

    /**
     * Map the data for export.
     *
     * @param mixed $payment
     * @return array
     */
    public function map($inv): array
    {
        $this->rowCount++;

        return [
            $inv->name() . " Invoice",
            $inv->invoice_number,
            $inv->customer->last_name . ', ' . $inv->customer->other_names,
            date_format(new DateTime($inv->due_date), 'jS M, Y'),
            number_format($inv->amount, 2),
            ucwords($inv->status),
        ];
    }

    public function headings(): array
    {
        // Specify the headings for the columns
        return [
            'Invoice Name',
            'Invoice Number',
            'Client',
            'Issue Date',
            'Amount',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font style to the headings row
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
