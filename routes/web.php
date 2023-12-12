<?php

use App\Http\Controllers\Api\V1\Notifications;
use App\Http\Controllers\Api\V1\PdfController;
use App\Http\Controllers\Api\V1\StoreProduitController;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
// use PDF;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sendMail', function () {
    $details = [
        "subject" => "Activation de compte sur FRIK-SMS",
        "message" => "Hello bro",
    ];
    Mail::to("gogochristian009@gmail.com")->send(new SendEmail($details));
    dd("MESSAGE ENVOYE AVEC SUCCèS");
});

Route::get('pdf', [PdfController::class, 'getPdf']);

Route::get('/documentation', function () {
    return view('documentation');
});
Route::get("user/{id?}", function ($id = null) {
    return 'User ' . $id;
});

Route::get('send-mail', [Notifications::class, 'testMail']);

Route::get("ticket", function () {
    return view("ticket");
});

Route::get("facture", function () {
    return view("facture-html");
});

Route::get("products/export", [StoreProduitController::class, "ExportProducts"]);
