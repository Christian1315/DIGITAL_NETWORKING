<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ClientExport implements FromCollection, WithStrictNullComparison, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Client::all([
            "firstname", "lastname", "phone"
        ]);
    }

    function headings(): array
    {
        return [
            "Prénom",
            "Nom",
            "Téléphone"
        ];
    }
}
