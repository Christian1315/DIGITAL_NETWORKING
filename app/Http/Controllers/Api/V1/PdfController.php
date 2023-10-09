<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StoreCommand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use PDF;

class PdfController extends BASE_HELPER
{
    public function getPdf()
    {
        // L'instance PDF avec la vue resources/views/posts/show.blade.php
        $data = [
            'id' => 1,
            'nom' => 'GOGO',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis, molestiae. Sunt suscipit magnam in, iusto illum laboriosam provident, aliquam minus vitae ducimus dicta inventore doloribus earum omnis tempora beatae perspiciatis.',
        ];

        // $users = User::all();
        // $users = User::all();
        $client = User::find(1);
        $reference = Custom_Timestamp();
        $commands = StoreCommand::where(["owner" => 10])->orderBy("id", "desc")->get();
        $command_amounts = [];
        foreach ($commands as $command) {
            array_push($command_amounts, $command->amount);
        }
        $total = array_sum($command_amounts);
        // return $total;
        // return self::sendResponse($commands, "success");


        // $formData["commands"] = $commands;
        // return $commands;
        $pdf = PDF::loadView('facture', compact(["client", "reference", "commands","total"]));
        $pdf->save(public_path("factures/" . $reference . ".pdf"));

        // return $users;
        // $pdf = PDF::loadView('pdf', compact('users'));
        // $pdf = PDF::loadView('pdf',$users)->stream();

        // return $pdf->download(Str::slug($data['nom']).'facture.pdf');

        // return view("facture", compact(["commands", "client", "reference"]));
        return $pdf->stream();
    }
}
