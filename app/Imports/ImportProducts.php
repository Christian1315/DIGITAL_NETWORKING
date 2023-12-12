<?php

namespace App\Imports;

use App\Models\StoreProduit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class ImportProducts implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param Collection $collection
     */
    public function model(array $product)
    {
        return StoreProduit::create([
            "name" => $product["name"],
            "price" => $product["price"],
            "description" => $product["description"],
            "product_type" => 1,
            // "category" => $product["category"],
            "owner" => request()->user()->id,
            "product_classe" => 1,
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
