<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param Collection $collection
     */

    public function model(array $client)
    {
        return Client::create([
            "firstname" => $client["nom"],
            "lastname" => $client["prenom"],
            "phone" => $client["phone"],
            "owner" => request()->user()->id,
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
