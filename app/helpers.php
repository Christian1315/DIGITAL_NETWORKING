<?php

use App\Models\Agency;
use App\Models\Master;
use App\Models\Pos;
use App\Models\Right;
use App\Models\User;

function userCount() {
    return count(User::all()) + 1;
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
    $rights = Right::with(["action", "profil","rang"])->where(["rang" => $rangId, "profil" => $profilId])->get();
    return $rights;
}

##======== CE HELPER PERMET DE RECUPERER TOUTS LES DROITS PAR DEFAUT ==========## 
function All_Rights()
{ #
    $allrights = Right::with(["action", "profil","rang"])->get();
    return $allrights;
}
