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

    ##======== ATTACH VALIDATION =======##
    static function ATTACH_rules(): array
    {
        return [
            'user_id' => 'required',
            'right_id' => 'required',
        ];
    }

    static function ATTACH_messages(): array
    {
        return [
            // 'user_id.required' => 'Veuillez renseigner soit votre username,votre phone ou soit votre email',
            // 'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function ATTACH_Validator($formDatas)
    {
        #
        $rules = self::ATTACH_rules();
        $messages = self::ATTACH_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== NEW PASSWORD VALIDATION =======##
    static function NEW_PASSWORD_rules(): array
    {
        return [
            'new_password' => 'required',
        ];
    }

    static function NEW_PASSWORD_messages(): array
    {
        return [
            // 'new_password.required' => 'Veuillez renseigner soit votre username,votre phone ou soit votre email',
            // 'password.required' => 'Le champ Password est réquis!',
        ];
    }

    static function NEW_PASSWORD_Validator($formDatas)
    {
        #
        $rules = self::NEW_PASSWORD_rules();
        $messages = self::NEW_PASSWORD_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function userAuthentification($request)
    {
        if (is_numeric($request->get('account'))) {
            $credentials  =  ['phone' => $request->get('account'), 'password' => $request->get('password')];
            $user = User::where(["phone" => $request->get('account')])->get();
        } elseif (filter_var($request->get('account'), FILTER_VALIDATE_EMAIL)) {
            $credentials  =  ['email' => $request->get('account'), 'password' => $request->get('password')];
            $user = User::where(["email" => $request->get('account')])->get();
        } else {
            $credentials  =  ['username' => $request->get('account'), 'password' => $request->get('password')];
            $user = User::where(["username" => $request->get('account')])->get();
        }


        if (Auth::attempt($credentials)) { #SI LE USER EST AUTHENTIFIE
            if ($user[0]->is_admin) { #IL peut se connecter avec son password default s'il est un admin
                $user = Auth::user();
                $token = $user->createToken('MyToken', ['api-access'])->accessToken;
                $user['rang'] = $user->rang;
                $user['profil'] = $user->profil;
                $user['rights'] = $user->rights;
                $user['token'] = $token;

                #renvoie des droits du user 
                $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
                // return $attached_rights;

                if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
                    if (Is_User_An_Admin($user->id)) { #s'il est un admin
                        $user['rights'] = All_Rights();
                    } else {
                        $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
                    }
                } else {
                    $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
                }

                #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
                return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
            } else {
                #On verifie d'abord si son password est egal à son password par defaut
                $is_password_equalTo_default_password =   Hash::check($user[0]->pass_default, $user[0]->password);

                if ($is_password_equalTo_default_password) { #Son password par defaut existe. Il n'est donc pas authorisé à se connecter
                    return self::sendError("Vous n'etes pas autorisé à vous connecter avec votre password par defaut! Veuillez changer votre mot de passe en clicquant ici:" . env("BASE_URL") . "/api/v1/user/" . $user[0]->id . "/update", 404);
                } else { #Il peut se connecter donc parce que son password n'est plus égal à son password par defaut
                    if (Auth::attempt($credentials)) { #SI LE USER EST AUTHENTIFIE
                        $user = Auth::user();
                        $token = $user->createToken('MyToken', ['api-access'])->accessToken;
                        $user['rang'] = $user->rang;
                        $user['profil'] = $user->profil;
                        $user['rights'] = $user->rights;
                        $user['token'] = $token;

                        #renvoie des droits du user 
                        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
                        // return $attached_rights;

                        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
                            if (Is_User_An_Admin($user->id)) { #s'il est un admin
                                $user['rights'] = All_Rights();
                            } else {
                                $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
                            }
                        } else {
                            $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
                        }


                        #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
                        return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
                    }
                }
            }
        } else {
            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
            return self::sendError('Connexion échouée! Vérifiez vos données puis réessayez à nouveau!', 500);
        }
    }

    static function getUsers()
    {
        $users =  User::with(['rang', 'profil', "drts","masters","agents"])->where(['visible' => 1])->get();
        return self::sendResponse($users, 'Tous les utilisatreurs récupérés avec succès!!');
    }

    static function _updateUser($formData, $id)
    {
        $user = User::with(['rang', 'profil'])->where(['id' => $id, 'visible' => 1])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::with(['rang', 'profil'])->find($id);
        // return $user;
        $user->update($formData);
        return self::sendResponse($user, 'Ce utilisateur a été modifié avec succès!');
    }

    static function _updatePassword($formData, $id)
    {
        $user = User::with(['rang', 'profil'])->where(['id' => $id, 'visible' => 1])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::with(['rang', 'profil'])->find($id);
        // return $user;
        $user->update(["password" => $formData["new_password"]]);
        return self::sendResponse($user, 'Mot de passe modifié avec succès!');
    }

    static function retrieveUsers($id)
    {
        $user = User::with(['rang', 'profil'])->where(['id' => $id, 'visible' => 1])->get();
        if ($user->count() == 0) {

            return self::sendError("Ce utilisateur n'existe pas!", 404);
        }
        $user = $user[0];
        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
        // return $attached_rights;

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            if (Is_User_An_Admin($user->id)) { #s'il est un admin
                $user['rights'] = All_Rights();
            } else {
                $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
            }
        } else {
            $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
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

        $User = User::where(['id' => $id, 'visible' => 1])->get();
        if (count($User) == 0) {
            return self::sendError("Ce User n'existe pas!", 404);
        };

        $User = User::find($id);
        $User->delete_at = now();
        $User->visible = false;
        $User->save();
        return self::sendResponse($User, 'Ce User a été supprimé avec succès!');
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
        $right = Right::find($formData['right_id']);

        $right->user_id = $user->id;
        $right->save();

        return self::sendResponse([], "User attaché au right avec succès!!");
    }

    static function rightDesAttach($formData)
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
        $right = Right::find($formData['right_id']);

        $right->user_id = null;
        $right->save();

        return self::sendResponse([], "User Dettaché du right avec succès!!");
    }
}
