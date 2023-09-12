<?php

namespace App\Imports;

use App\Models\Card;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CardImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $card)
    {
        return Card::create([
            'card_id'    => $card['card_id'],
            'card_num'     => $card['card_num'],
            'expire_date'    => $card['expire_date'],
            'type'    => $card['type'],
            'status'    => $card['type'],
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
