<?php

use App\Mail\SendEmail;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\Master;
use App\Models\Pos;
use App\Models\ProductCommand;
use App\Models\Right;
use App\Models\Sold;
use App\Models\User;
use App\Models\UserSession;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

function userCount()
{
    return count(User::all()) + 1;
}

function Custom_Timestamp()
{
    $date = new DateTimeImmutable();
    $micro = (int)$date->format('Uu'); // Timestamp in microseconds
    return $micro;
}

##Ce Helper permet de creér le passCode de réinitialisation de mot de passe
function Get_passCode($user, $type)
{
    $created_date = $user->created_at;

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $an = substr($year, -2);
    $timestamp = substr(Custom_Timestamp(), -3);

    $passcode =  $timestamp . $type . $an . userCount();
    return $passcode;
}

function Add_Number($user, $type)
{
    $created_date = $user->created_at;

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $an = substr($year, -2);

    $number = "DGT" . $type . $an . userCount();
    return $number;
}

####____quantite d'un produit en commande
function PRODUCT_QTY($commanId, $produtId)
{
    $product = ProductCommand::where(["product_id" => $produtId, "command_id" => $commanId])->first();
    return $product->qty;
}


function Is_THIS_ADMIN_PPJJOEL()
{ #
    $user = request()->user();
    if ($user->id == 2) {
        return true; #il est PPJJOEL
    }
    return false; #il n'est pas PPJJOEL
}


##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN ADMIN OU PAS ==========## 
function Is_User_An_Admin($userId)
{ #
    $user = User::find($userId);

    if ($user->rang['id'] == 1) {
        return true;
    }
    return false;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN MASTER OU PAS ==========## 
function Is_User_A_Master($userId)
{ #
    $master = Master::where('user_id', $userId)->get();
    if (count($master) == 0) {
        return false;
    }
    return true; #Sil est un Master
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN MASTER OU UN ADMIN==========## 
function Is_User_A_Master_Or_Admin($userId)
{ #
    $master = Master::where('user_id', $userId)->get();
    if (count($master) == 0) { #S'il n'est pas un Master
        if (Is_User_An_Admin($userId)) { #On verifie S'il est admin
            return true;
        }
        return false; #S'il n'est ni Master ni Admin
    }
    return true; #Sil est un Master
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN POS OU UN ADMIN==========## 
function Is_User_A_Pos_Or_Admin($userId)
{ #
    $pos = Pos::where('user_id', $userId)->get();
    if (count($pos) == 0) { #S'il n'est pas un Pos
        if (Is_User_An_Admin($userId)) { #On verifie S'il est admin
            return true;
        }
        return false; #S'il n'est ni Pos ni Admin
    }
    return true; #Sil est un POS
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN POS =========## 
function Is_User_A_Pos($userId)
{
    $pos = Pos::where('user_id', $userId)->get();
    if (count($pos) == 0) { #S'il n'est pas un Pos
        return false;
    }
    return true; #Sil est un POS
}


##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UNE AGENCE OU PAS ==========## 
function Is_User_An_Agency($userId)
{ #
    $agency = Agency::where('user_id', $userId)->get();
    if (count($agency) == 0) { #S'il n'est pas une Agence
        return false; #S'il n'est ni Agence ni Admin
    }
    return true;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN AGENT OU PAS ==========## 
function Is_User_An_Agent($userId)
{ #
    $agent = Agent::where('user_id', $userId)->get();
    if (count($agent) == 0) { #S'il n'est pas une Agence
        return false; #S'il n'est ni Agence ni Admin
    }
    return true;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UNE AGENCE OU UN ADMIN ==========## 
function Is_User_An_Agency_Or_Admin($userId)
{ #
    $agency = Agency::where('user_id', $userId)->get();
    if (count($agency) == 0) { #S'il n'est pas une Agence
        if (Is_User_An_Admin($userId)) { #On verifie S'il est admin
            return true;
        }
        return false; #S'il n'est ni Agence ni Admin
    }
    return true;
}

##======== CE HELPER PERMET DE RECUPERER LES DROITS D'UN UTILISATEUR ==========## 
function User_Rights($rangId, $profilId)
{ #
    $rights = Right::with(["action", "profil", "rang"])->where(["rang" => $rangId, "profil" => $profilId])->get();
    return $rights;
}

##======== CE HELPER PERMET DE RECUPERER TOUTS LES DROITS PAR DEFAUT ==========## 
function All_Rights()
{ #
    $allrights = Right::with(["action", "profil", "rang"])->get();
    return $allrights;
}

##======== CE HELPER PERMET D'ENVOYER DES SMS VIA PHONE ==========## 

function Login_To_Frik_SMS()
{
    $response = Http::post(env("SEND_SMS_API_URL") . "/api/v1/login", [
        "account" => "admin",
        "password" => "gogo@1315",
    ]);

    return $response;
}

function Send_SMS($phone, $message, $token)
{

    $response = Http::withHeaders([
        'Authorization' => "Bearer " . $token,
    ])->post(env("SEND_SMS_API_URL") . "/api/v1/sms/send", [
        "phone" => $phone,
        "message" => $message,
        "expediteur" => env("EXPEDITEUR"),
    ]);

    $response->getBody()->rewind();
}

##======== CE HELPER PERMET DE RECUPERER L'AGENT DAD D'UNE AGENCE ==========## 

function Agent_Dad($agent_dad_id)
{
    $agent_dad = Agent::where("id", $agent_dad_id)->get();
    return $agent_dad;
}

##======== CE HELPER PERMET DE DECREDITER LE SOLDE D'USER ==========## 
function Decredite_User_Account($userId, $formData)
{

    $solde = Sold::where(['owner' => $userId, 'visible' => 1])->get();

    #####______GESTION DU SOLDE DE L'AGENCE

    ##~~l'ancien solde pour l'agence
    $old_solde = $solde[0];
    $old_solde->visible = 0;
    $old_solde->decredited_at = now();
    $old_solde->save();

    ##~~le nouveau solde pour l'agence
    $new_solde = new Sold();
    $new_solde->amount = $old_solde->amount - $formData["amount"]; ##decreditation du compte
    $new_solde->module = $old_solde->module;
    $new_solde->comments = $formData["comments"];
    $new_solde->agency = $old_solde->agency;
    $new_solde->status = 2;
    $new_solde->owner = $userId;
    $new_solde->credited_at = now();
    $new_solde->save();
}

function CreditateSoldForPos($formData)
{
    $user = request()->user();
    $session = GetSession($user->id);
    #####______GESTION DU SOLDE DU POS
    $pos_solde = Sold::where(['pos' => $formData["pos"], 'visible' => 1])->get();

    ##~~l'ancien solde DU POS
    $pos_old_solde = $pos_solde[0];
    $pos_old_solde->visible = 0;
    $pos_old_solde->pos = $formData["pos"];
    $pos_old_solde->status = null;
    $pos_old_solde->decredited_at = now();
    $pos_old_solde->save();

    ##~~le nouveau solde DU POS
    $pos_solde = new Sold();
    $pos_solde->amount = $pos_old_solde->amount + $formData["amount"]; ##decreditation du compte
    $pos_solde->module = $formData["module_type"];
    $pos_solde->comments = "Solde crédité par l'agence " . request()->user()->username;
    $pos_solde->pos = $formData["pos"];
    $pos_solde->status = 2;
    $pos_solde->credited_at = now();
    // $pos_solde->session = $session->id;
    $pos_solde->save();
}

function Decredite_Pos_Account($formData)
{

    $pos_solde = Sold::where(['pos' => $formData["pos"], 'visible' => 1])->get();

    ##~~l'ancien solde DU POS
    $pos_old_solde = $pos_solde[0];
    $pos_old_solde->visible = 0;
    $pos_old_solde->pos = $formData["pos"];
    $pos_old_solde->status = null;
    $pos_old_solde->decredited_at = now();
    $pos_old_solde->save();

    ##~~le nouveau solde DU POS
    $pos_solde = new Sold();
    $pos_solde->amount = $pos_old_solde->amount - $formData["amount"]; ##decreditation du compte
    $pos_solde->module = $formData["module_type"];
    $pos_solde->comments = $formData["comments"];
    $pos_solde->pos = $formData["pos"];
    $pos_solde->status = 2;
    $pos_solde->credited_at = now();
    $pos_solde->save();
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER DISPOSE D'UN COMPTE SUFFISANT OU PAS ==========## 
function Is_User_Account_Enough($userId, $amount)
{
    ####___________
    $solde = Sold::where(['owner' => $userId, 'visible' => 1])->get();
    if (count($solde) == 0) {
        return false; ##IL NE DISPOSE MEME PAS DE COMPTE
    }
    ###Il DISPOSE D'UN COMPTE
    $solde = $solde[0];

    if ($solde->amount >= $amount) {
        return true; #Son solde est suffisant!
    }
    return false; #Son solde est insuffisant
}

function Is_Pos_Account_Enough($posId, $amount)
{
    ####___________
    $solde = Sold::where(['pos' => $posId, 'visible' => 1])->get();
    if (count($solde) == 0) {
        return false; ##IL NE DISPOSE MEME PAS DE COMPTE
    }
    ###Il DISPOSE D'UN COMPTE
    $solde = $solde[0];
    if ($solde->amount >= $amount) {
        return true; #Son solde est suffisant!
    }
    return false; #Son solde est insuffisant
}

##====== ENVOIE DE MAIL
function Send_Email($email, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];
    Mail::to($email)->send(new SendEmail($data));
}

function Send_Notification($receiver, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];
    Notification::send($receiver, new SendNotification($data));
}

##======== CE HELPER PERMET DE RECUPERER LES INFORMATIONS D'UN AGENT DEPUIS LA TABLE **agents**  ==========## 

function AGENT($user_id)
{
    $agent = Agent::with(["pos", "stores", "agency"])->where("user_id", $user_id)->first();
    return $agent;
}

##======== CE HELPER PERMET DE RECUPERER LES INFORMATIONS D'UNE AGENCY DEPUIS LA TABLE **agencies**  ==========## 

function AGENCY($user_id)
{
    $agency = Agency::with(["poss", "stores", "agents"])->where("user_id", $user_id)->first();
    return $agency;
}

##======== CE HELPER PERMET DE RECUPERER LES INFORMATIONS D'UN MASTER DEPUIS LA TABLE **masters**  ==========## 

function MASTER($user_id)
{
    $MASTER = Master::where("user_id", $user_id)->first();
    return $MASTER;
}

##======== CE HELPER PERMET DE RECUPERER LES USERS CREES PAR UN USER  ==========## 

function myUsers($user_id)
{
    $users = User::with(["sessions", 'rang', 'profil'])->where("owner", $user_id)->get();
    return $users;
}

##======== CE HELPER PERMET DE SAVOIR SI LE USER A UNE SESSION ==========## 

function CheckIfUserHasASession($user_id)
{
    $session = UserSession::where(["user" => $user_id])->get();
    if ($session->count() == 0) {
        return false; #IL N'A PAS DE SESSION
    }
    return true; #IL A UNE SESSION
}

##======== CE HELPER PERMET DE SAVOIR SI LE USER A UNE SESSION ACTIVE==========## 

function CheckIfUserHasAnActiveSession($user_id)
{
    $sessionActive = UserSession::where(["user" => $user_id, "active" => 1])->get();
    if ($sessionActive->count() == 0) {
        return false; #IL N'A PAS DE SESSION ACTIVE
    }
    return true; #IL A UNE SESSION ACTIVE
}

##======== CE HELPER PERMET DE RECUPERER LA SESSION D'UN USER ==========## 

function GetSession($user_id)
{
    $session = UserSession::where(["user" => $user_id, "active" => 1])->get();
    if ($session->count() != 0) {
        return $session[0];
    }
    return null;
}


function Do_I_HAVE_AN_ACTIVE_SESSION($user_id)
{
    $session = UserSession::where(["user" => $user_id, "active" => 1])->first();
    if (!$session) {
        return false;
    }
    return true;
}
