<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Rang;
use App\Models\Right;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class USER_HELPER extends BASE_HELPER
{
    ##======== LOGIN VALIDATION =======##
    static function login_rules(): array
    {
        return [
            'account' => 'required',
            'password' => 'required',
        ];
    }

    static function login_messages(): array
    {
        return [
            'account.required' => 'Veuillez renseigner soit votre username,votre phone ou soit votre email',
            'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function Login_Validator($formDatas)
    {
        #
        $rules = self::login_rules();
        $messages = self::login_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function userAuthentification($request)
    {
        if (is_numeric($request->get('account'))) {
            $credentials  =  ['phone' => $request->get('account'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('account'), FILTER_VALIDATE_EMAIL)) {
            $credentials  =  ['email' => $request->get('account'), 'password' => $request->get('password')];
        } else {
            $credentials  =  ['username' => $request->get('account'), 'password' => $request->get('password')];
        }
        
        
        if (Auth::attempt($credentials)) { #SI LE USER EST AUTHENTIFIE
            $user = Auth::user();
            $token = $user->createToken('MyToken', ['api-access'])->accessToken;
            $user['rang'] = $user->rang;
            $user['profil'] = $user->profil;
            $user['rights'] = $user->rights;
            $user['token'] = $token;
            
            #renvoie des droits du user 
            if (Is_User_An_Admin($user->id)) { #s'il est un admin
                $user['rights'] = All_Rights();
                // return $user['rights'][0];
            } else {
                $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
            }

            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
            return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
        }

        #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
        return self::sendError('Connexion échouée! Vérifiez vos données puis réessayez à nouveau!', 500);
    }

    static function getUsers()
    {
        $users =  User::with(['rang', 'profil'])->latest()->get();
        return self::sendResponse($users, 'Tous les utilisatreurs récupérés avec succès!!');
    }

    static function _updateUser($formData, $id)
    {
        $user = User::with(['rang', 'profil'])->where('id', $id)->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::with(['rang', 'profil'])->find($id);
        // return $user;
        $user->update($formData);
        return self::sendResponse($user, 'Ce utilisateur a été modifié avec succès!');
    }

    static function retrieveUsers($id)
    {
        $user = User::with(['rang', 'profil'])->where('id', $id)->get();
        if ($user->count() == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        }
        $user = $user[0];
        #renvoie des droits du user 
        if (Is_User_An_Admin($user->id)) { #s'il est un admin
            $user['rights'] = All_Rights();
        } else {
            $user['rights'] = User_Rights($user->rang->id, $user->profil->id);
        }
        return self::sendResponse($user, "Utilisateur récupéré(e) avec succès:!!");
    }

    static function userLogout($request)
    {
        $request->user()->token()->revoke();
        // DELETING ALL TOKENS REMOVED
        // Artisan::call('passport:purge');
        return self::sendResponse([], 'Vous etes déconnecté(e) avec succès!');
    }

    static function userDelete($id)
    {
        $user = User::with(['profil'])->where('id', $id)->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::find($id);
        $user->delete();
        return self::sendResponse($user, 'Ce utilisateur a été supprimé avec succès!');
    }

    static function profilAttach($formData)
    {
        $user = User::where('id', $formData['user_id'])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $profil = User::where('id', $formData['profil_id'])->get();
        if (count($profil) == 0) {
            return self::sendError("Ce profil n'existe pas!", 404);
        };

        $user = User::find($formData['user_id']);

        $user['profil_id'] = $formData['profil_id'];
        $user->save();
        $user['profil'] = $user->profil;
        return self::sendResponse($user, "User attaché au profil avec succès!!");
    }

    static function rangAttach($formData)
    {
        $user = User::where('id', $formData['user_id'])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $rang = Rang::where('id', $formData['rang_id'])->get();
        if (count($rang) == 0) {
            return self::sendError("Ce rang n'existe pas!", 404);
        };

        $user = User::find($formData['user_id']);

        $user['rang_id'] = $formData['rang_id'];
        $user->save();
        $user['rang'] = $user->rang;
        $user['profil'] = $user->profil;
        return self::sendResponse($user, "User attaché au rang avec succès!!");
    }

    static function rightAttach($formData)
    {
        $user = User::where('id', $formData['user_id'])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $right = Right::where('id', $formData['right_id'])->get();
        if (count($right) == 0) {
            return self::sendError("Ce right n'existe pas!", 404);
        };

        $user = User::find($formData['user_id']);

        $user['right_id'] = $formData['right_id'];
        $user->save();
        $user['right'] = $user->right;
        $user['right'] = $user->right;
        return self::sendResponse($user, "User attaché au right avec succès!!");
    }
}
