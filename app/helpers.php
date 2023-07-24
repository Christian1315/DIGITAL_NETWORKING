<?php

use App\Models\Master;
use App\Models\Right;
use App\Models\User;

function Admin_Add_Number($user,$label)
{
    // $username = $user->username;
    $created_date = $user->created_at;
    $timestamp = strtotime(now());#ON RECUPERE LE TIMESTAMP

    // $prefix = str_split($username, 3)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $middle = substr($year, -2);
    $userId = $user->id;
    $suffix = substr($timestamp, -2); ##RECUPERATION DES DEUX DERNIERS CHIFFRES DU TIMESTAMP;

    $number = "ADM" .$userId. $label . $middle . $suffix;

    return $number;
}

function Master_Add_Number($user,$label)
{
    $created_date = $user->created_at;
    $timestamp = strtotime(now());#ON RECUPERE LE TIMESTAMP

    $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $middle = substr($year, -2);
    $userId = $user->id;
    $suffix = substr($timestamp, -2); ##RECUPERATION DES DEUX DERNIERS CHIFFRES DU TIMESTAMP;

    $number = "MAST".$userId. $label. $middle . $suffix;

    return $number;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN MASTER OU PAS ==========## 
function Is_User_A_Master($userId){ #
    $master = Master::where('user_id',$userId)->get();
    if (count($master)==0) {
        return false;
    }
    return count($master)==0?false:true;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN ADMIN OU PAS ==========## 
function Is_User_An_Admin($userId){ #
    $user = User::find($userId);

    if ($user->rang['id']==1) {
        return true;
    }
    return false;
}

##======== CE HELPER PERMET DE RECUPERER LES DROITS D'UN UTILISATEUR ==========## 
function User_Rights($rangId,$profilId){ #
    $rights = Right::where(["rang"=>$rangId,"profil"=>$profilId])->get();
    return $rights;
}

##======== CE HELPER PERMET DE RECUPERER TOUTS LES DROITS PAR DEFAUT ==========## 
function All_Rights(){ #
    $rights = Right::with(["action","profil"])->get();
    return $rights;
}