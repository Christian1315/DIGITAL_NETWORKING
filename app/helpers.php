<?php

use App\Models\Master;

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

    $number = "ADM" . $label . $middle .$userId. $suffix;

    return $number;
}

function Master_Add_Number($user,$label)
{
    // $created_date = $user->created_at;
    $timestamp = strtotime(now());#ON RECUPERE LE TIMESTAMP

    // $year = explode("-", $created_date)[0]; ##RECUPERATION DES TROIS PREMIERS LETTRES DU USERNAME
    $userId = $user->id;
    $suffix = substr($timestamp, -2); ##RECUPERATION DES DEUX DERNIERS CHIFFRES DU TIMESTAMP;

    $number = "MAST". $label.$userId. $suffix;

    return $number;
}

##======== CE HELPER PERMET DE VERIFIER SI LE USER EST UN MASTER OU PAS ==========## 
function Is_User_A_Master($userId){ #
    $master = Master::where('user_id',$userId)->get();
    if (count($master)==0) {
        return false;
    }
    return true;
}