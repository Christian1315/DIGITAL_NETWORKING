<?php

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Master;
use App\Models\Pos;
use App\Models\Right;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\Http;

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
function Add_Number($user, $type)
{
    $created_date = $user->created_at;

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $an = substr($year, -2);

    $number = "JNP" . $type . $an . userCount();
    return $number;
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
    return true; #Sil est un Master
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
        "username" => "admin",
        "password" => "admin",
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

    // return $response;
}

##======== CE HELPER PERMET DE RECUPERER L'AGENT DAD D'UNE AGENCE ==========## 

function Agent_Dad($agent_dad_id)
{
    $agent_dad = Agent::where("id", $agent_dad_id)->get();
    return $agent_dad;
}


##======== CE HELPER PERMET DE RECUPERER LES INFORMATIONS D'UN AGENT DEPUIS LA TABLE **agents**  ==========## 

function AGENT($user_id)
{
    $agent = Agent::with(["pos", "stores", "agency"])->where("user_id", $user_id)->get();
    return $agent;
}

##======== CE HELPER PERMET DE RECUPERER LES INFORMATIONS D'UNE AGENCY DEPUIS LA TABLE **agencies**  ==========## 

function AGENCY($user_id)
{
    $agency = Agency::with(["poss", "stores", "agents"])->where("user_id", $user_id)->get();
    return $agency;
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
    return UserSession::where(["user" => $user_id,"active" => 1])->get()[0];
}
