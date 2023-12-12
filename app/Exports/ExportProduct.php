<?php

namespace App\Exports;

use App\Models\StoreProduit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportProduct implements FromCollection, WithStrictNullComparison, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return StoreProduit::all([
            "name", "price", "description"
        ]);
    }

    function headings(): array
    {
        return [
            "NAME",
            "PRICE",
            "DESCRIPTION"
        ];
    }
}
