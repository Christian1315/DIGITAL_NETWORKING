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
    ##======== REGISTER VALIDATION =======##
    static function register_rules(): array
    {
        return [
            'username' => ['required', Rule::unique('users')],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required'],
            'gender' => ['required'],
            'country' => ['required'],
            'phone' => ['required', Rule::unique('users')],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'rang_id' => ['required'],
            // 'parent_id' => ['required'],
        ];
    }

    static function register_messages(): array
    {
        return [
            'username.required' => 'Le champ username est réquis!',
            'email.required' => 'Le champ Email est réquis!',
            'password.required' => 'Le champ password est réquis!',
            'gender.required' => 'Le champ gender est réquis!',
            'country.required' => 'Le champ country est réquis!',
            'phone.required' => 'Le champ phone est réquis!',
            'phone.unique' => 'Ce phone existe déjà!',
            'firstname.required' => 'Le champ firstname est réquis!',
            'lastname.required' => 'Le champ lastname est réquis!',
            'rang_id.required' => 'Le champ rang_id est réquis!',
        ];
    }

    static function Register_Validator($formDatas)
    {
        $rules = self::register_rules();
        $messages = self::register_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createUser($formData)
    {
        return request()->user()->id;
        $rang = Rang::where('id', $formData['rang_id'])->get();
        if (count($rang) == 0) {
            return self::sendError("Ce Rang n'existe pas!", 404);
        }

        $formData['password'] = Hash::make($formData['password']); #Hashing du password
        $formData['parent_id'] = request()->user()->id; #Recuperation de l'ID du parent

        $user = User::create($formData); #ENREGISTREMENT DU USER DANS LA DB
        $user['rang'] = $user->rang();
        $user['profil'] = $user->profil();
        $user['rights'] = $user->rights;

        return self::sendResponse($user, 'User crée avec succès!!');
    }

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

    ##======== ATTACH PROFIL VALIDATION =======##
    static function attach_Profil_rules(): array
    {
        return [
            'user_id' => 'required',
            'profil_id' => 'required',
        ];
    }

    static function attach_Profil_messages(): array
    {
        return [
            'user_id.required' => 'Le champ user_id est réquis!',
            'profil_id.required' => 'Le champ profil_id est réquis!',
        ];
    }

    static function Attach_Profil_Validator($formDatas)
    {
        #
        $rules = self::attach_Profil_rules();
        $messages = self::attach_Profil_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== ATTACH RANG VALIDATION =======##
    static function attach_Rang_rules(): array
    {
        return [
            'user_id' => 'required',
            'rang_id' => 'required',
        ];
    }

    static function attach_Rang_messages(): array
    {
        return [
            'user_id.required' => 'Le champ user_id est réquis!',
            'rang_id.required' => 'Le champ profil_id est réquis!',
        ];
    }

    static function Attach_Rang_Validator($formDatas)
    {
        #
        $rules = self::attach_Rang_rules();
        $messages = self::attach_Rang_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== ATTACH RIGHT VALIDATION =======##
    static function attach_Right_rules(): array
    {
        return [
            'user_id' => 'required',
            'right_id' => 'required',
        ];
    }

    static function attach_Right_messages(): array
    {
        return [
            'user_id.required' => 'Le champ user_id est réquis!',
            'right_id.required' => 'Le champ right_id est réquis!',
        ];
    }

    static function Attach_Right_Validator($formDatas)
    {
        #
        $rules = self::attach_Right_rules();
        $messages = self::attach_Right_messages();

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
            $user['rang'] = $user->rang();
            $user['profil'] = $user->profil();
            $user['rights'] = $user->rights;
            $user['token'] = $token;

            #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
            return self::sendResponse($user, 'Vous etes connecté(e) avec succès!!');
        }

        #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER
        return self::sendError('Connexion échouée! Vérifiez vos données puis réessayez à nouveau!', 500);
    }

    static function getUsers()
    {
        $users =  User::with(['rang', 'profil', 'rights'])->latest()->get();
        return self::sendResponse($users, 'Tous les utilisatreurs récupérés avec succès!!');
    }

    static function _updateUser($formData, $id)
    {
        $user = User::with(['rang', 'profil', 'rights'])->where('id', $id)->get();
        if (count($user) == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
        };
        $user = User::with(['rang', 'profil', 'rights'])->find($id);
        $user->update($formData);
        return self::sendResponse($user, 'Ce utilisateur a été modifié avec succès!');
    }

    static function retrieveUsers($id)
    {
        $user = User::with(['rang', 'profil', 'rights'])->where('id', $id)->get();
        if ($user->count() == 0) {
            return self::sendError("Ce utilisateur n'existe pas!", 404);
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
