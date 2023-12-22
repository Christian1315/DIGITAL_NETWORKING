<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Right;
use App\Models\User;
use App\Models\UserRight;
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
                $user["session_active"] = Do_I_HAVE_AN_ACTIVE_SESSION($user->id);
                $user['rang'] = $user->rang;
                $user['profil'] = $user->profil;
                $user['rights'] = $user->rights;
                $user['token'] = $token;
                $user['sold'] = $user->sold;
                $user["stores"] = $user->stores;
                $user["poss"] = $user->poss;
                $user["agents"] = $user->agents;
                $user["agencies"] = $user->agencies;

                $user["AGENT"]  = AGENT(request()->user()->id);
                $user["AGENCY"]  = AGENCY(request()->user()->id);
                $user["MASTER"]  = MASTER(request()->user()->id);


                #renvoie des droits du user 
                ##les admins prennent tout les droits, même si on leur affecte des droits specifiques
                $user['rights'] = All_Rights();

                #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
                return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
            } else {
                #On verifie d'abord si son password est egal à son password par defaut
                $is_password_equalTo_default_password =   Hash::check($user[0]->pass_default, $user[0]->password);
                if ($is_password_equalTo_default_password) { #Son password par defaut existe. Il n'est donc pas authorisé à se connecter
                    return self::sendResponse(
                        [
                            "id" => $user[0]->id,
                        ],
                        "Vous n'etes pas autorisé à vous connecter avec votre password par defaut! Veuillez changer votre mot de passe "
                    );
                } else { #Il peut se connecter donc parce que son password n'est plus égal à son password par defaut
                    if (Auth::attempt($credentials)) { #SI LE USER EST AUTHENTIFIE
                        $user = Auth::user();
                        $token = $user->createToken('MyToken', ['api-access'])->accessToken;
                        $user["session_active"] = Do_I_HAVE_AN_ACTIVE_SESSION($user->id);
                        $user['rang'] = $user->rang;
                        $user['profil'] = $user->profil;
                        $user['rights'] = $user->rights;
                        $user['token'] = $token;
                        $user['sold'] = $user->sold;
                        $user["stores"] = $user->stores;
                        $user["poss"] = $user->poss;
                        // $user["agents"] = $user->agents;
                        // $user["agencies"] = $user->agencies;

                        // $user["AGENT"]  = AGENT(request()->user()->id);
                        // $user["AGENCY"]  = AGENCY(request()->user()->id);
                        $user["MASTER"]  = MASTER(request()->user()->id);

                        #renvoie des droits du user 
                        $attached_rights = $user->affected_rights; #affected_rights represente les droits associés au user par relation #Les droits attachés

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
        $user = request()->user();
        $users = [];
        if ($user->is_admin) {
            $users = User::with(["sessions", 'rang', 'profil'])->orderBy("id", "desc")->get();
        } else {
            $users = myUsers($user->id);
        }

        if ($users) {
            foreach ($users as $user) {
                #renvoie des droits du user 
                $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
                // return $attached_rights;

                if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
                    if (Is_User_AN_ADMIN($user->id)) { #s'il est un admin
                        $user['rights'] = All_Rights();
                    } else {
                        $user['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
                    }
                } else {
                    $user['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
                }
            }
        }
        return self::sendResponse($users, 'Tous les utilisatreurs récupérés avec succès!!');
    }

    static function _updateUser($formData, $id)
    {
        $user = User::with(['owner', 'rang', 'profil'])->where(['id' => $id, 'visible' => 1])->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::with(['owner', 'rang', 'profil'])->find($id);
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
        $user = User::with(["sessions", "owner", 'rang', 'profil', "stores", "masters", "agents", "agencies", "poss"])->where(['id' => $id, 'visible' => 1])->get();
        if ($user->count() == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        }
        $user = $user[0];

        // return $user->owner();
        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés

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
        $User = User::where(['id' => $id, 'visible' => 1, 'owner' => request()->user()->id])->get();
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
        $current_user = request()->user();
        if ($current_user->is_admin) {
            $user = User::where(['id' => $formData['user_id']])->get();
        } else {
            $user = User::where(['id' => $formData['user_id'], 'owner' => $current_user->id])->get();
        }
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $right = Right::where('id', $formData['right_id'])->get();
        if (count($right) == 0) {
            return self::sendError("Ce right n'existe pas!", 404);
        };

        // $user = User::find($formData['user_id']);
        // $right = Right::find($formData['right_id']);

        $is_this_attach_existe = UserRight::where(["user_id" => $formData['user_id'], "right_id" => $formData['right_id']])->first();

        if ($is_this_attach_existe) {
            return self::sendError("Ce user dispose déjà de ce droit!", 505);
        }
        ##__

        $user_right = new UserRight();
        $user_right->user_id = $formData['user_id'];
        $user_right->right_id = $formData['right_id'];
        $user_right->save();

        // $right->user_id = $user->id;
        // $right->save();

        return self::sendResponse([], "User attaché au right avec succès!!");
    }

    static function rightDesAttach($formData)
    {
        $current_user = request()->user();

        // return $current_user->affected_rights;
        if ($current_user->is_admin) {
            $user = User::where(['id' => $formData['user_id']])->get();
        } else {
            $user = User::where(['id' => $formData['user_id'], 'owner' => $current_user->id])->get();
        }
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };

        $right = Right::where('id', $formData['right_id'])->get();
        if (count($right) == 0) {
            return self::sendError("Ce right n'existe pas!", 404);
        };

        ###___retrait du droit qui lui a été affecté par defaut
        $user_right = UserRight::where(["user_id" => $formData['user_id'], "right_id" => $formData['user_id']])->first();
        if (!$user_right) {
            return self::sendError("Ce user ne dispose pas de ce droit!", 505);
        }

        $user_right->delete();
        return self::sendResponse([], "User Dettaché du right avec succès!!");
    }

    static function _demandReinitializePassword($request)
    {
        if (!$request->get("email")) {
            return self::sendError("Le Champ email est réquis!", 404);
        }
        $email = $request->get("email");
        $user = User::where(['email' => $email])->get();

        if (count($user) == 0) {
            return self::sendError("Ce compte n'existe pas!", 404);
        };

        #
        $user = $user[0];
        $pass_code = Get_passCode($user, "PASS");
        $user->pass_code = $pass_code;
        $user->pass_code_active = 1;
        $user->save();

        $message = "Demande de réinitialisation éffectuée avec succès! sur FRIK SMS! Voici vos informations de réinitialisation de password ::" . $pass_code;

        #=====ENVOIE DE MAIL =======~####
        try {
            Send_Notification(
                $user,
                "DEMANDE DE REEINITIALISATION SUR DIGITAL NETWORKING",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        return self::sendResponse($user, "Demande de réinitialisation éffectuée avec succès! Veuillez vous connecter avec le code qui vous a été envoyé par phone et par mail");
    }

    static function _reinitializePassword($request)
    {

        $pass_code = $request->get("pass_code");

        if (!$pass_code) {
            return self::sendError("Ce Champ pass_code est réquis!", 404);
        }

        $new_password = $request->get("new_password");

        if (!$new_password) {
            return self::sendError("Ce Champ new_password est réquis!", 404);
        }

        $user = User::where(['pass_code' => $pass_code])->get();

        if (count($user) == 0) {
            return self::sendError("Ce code n'est pas correct!", 404);
        };

        $user = $user[0];
        #Voyons si le passs_code envoyé par le user est actif

        if ($user->pass_code_active == 0) {
            return self::sendError("Ce Code a déjà été utilisé une fois! Veuillez faire une autre demande de réinitialisation", 404);
        }

        #UPDATE DU PASSWORD
        $user->update(['password' => $new_password]);

        #SIGNALONS QUE CE pass_code EST D2J0 UTILISE
        $user->pass_code_active = 0;
        $user->save();


        #===== ENVOIE D'SMS =======~####

        $message = "Réinitialisation de password éffectuée avec succès sur FRIK-SMS!";


        #=====ENVOIE DE MAIL =======~####
        try {
            Send_Notification(
                $user,
                "REEINITIALISATION EFFECTUEE SUR DIGITAL NETWORKING",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        return self::sendResponse($user, "Réinitialisation éffectuée avec succès!");
    }
}
