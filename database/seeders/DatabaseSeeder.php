<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        #======== CREATION DES ACTIONS PAR DEFAUT=========#
        $actions = [
            [
                'name' => 'deliver_card',
                'description' => 'Délivrer une carte',
                'visible' => true
            ],
            [
                'name' => 'end_operation',
                'description' => 'Finir une Opération',
                'visible' => true
            ],
            [
                'name' => 'list_card',
                'description' => 'Lister les cartes',
                'visible' => true
            ],
            [
                'name' => 'list_enroll',
                'description' => 'Lister les enrollés',
                'visible' => true
            ],
            [
                'name' => 'list_migration',
                'description' => 'Lister les migrations',
                'visible' => true
            ],
            [
                'name' => 'list_reactivation',
                'description' => 'Lister les réactivations',
                'visible' => true
            ],
            [
                'name' => 'list_rechargement',
                'description' => 'Lister les rechargements',
                'visible' => true
            ],
            [
                'name' => 'list_renew',
                'description' => 'Lister les nouveautés',
                'visible' => true
            ],
            [
                'name' => 'validate_card_load',
                'description' => 'Valider le téléchargement des Cards',
                'visible' => true
            ],
            [
                'name' => 'add_agency',
                'description' => 'Ajouter une agence',
                'visible' => true
            ],
            [
                'name' => 'list_agency',
                'description' => 'Lister les agences',
                'visible' => true
            ],
            [
                'name' => 'card_validate_activation',
                'description' => 'Activation de la validation d\'une carte',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajouter une carte',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_reactivation',
                'description' => 'Réactivation de la validation d\'un canal',
                'visible' => true
            ],
            [
                'name' => 'credit_accessoires',
                'description' => 'Créditer des accessoires',
                'visible' => true
            ],
            [
                'name' => 'credit_agency',
                'description' => 'Créditer une agence',
                'visible' => true
            ],
            [
                'name' => 'credit_materiel',
                'description' => 'Créditer un matériel',
                'visible' => true
            ],
            [
                'name' => 'credit_parabole',
                'description' => 'Créditer une parabole',
                'visible' => true
            ],
            [
                'name' => 'debit_accessoires',
                'description' => 'Débiter des accessoires',
                'visible' => true
            ],
            [
                'name' => 'debit_agency',
                'description' => 'Débiter une agence',
                'visible' => true
            ],
            [
                'name' => 'credit_materiel',
                'description' => 'Débiter un matériel',
                'visible' => true
            ],
            [
                'name' => 'debi_parabole',
                'description' => 'Débiter une parabole',
                'visible' => true
            ],
        ];

        foreach ($actions as $action) {
            \App\Models\Action::factory()->create($action);
        }

        #======== CREATION DES PROFILS PAR DEFAUT=========#
        $profils = [
            [
                "name" => "Système",
                "description" => "Gestionnaire du Système",
            ],
            [
                "name" => "Responsable",
                "description" => "Le Responsable du compte",
            ],
            [
                "name" => "Master",
                "description" => "Le Master du compte",
            ],
            [
                "name" => "Agence",
                "description" => "Une Agence",
            ],
            [
                "name" => "Agent",
                "description" => "Un Agent",
            ],
            [
                "name" => "Client",
                "description" => "Ici il est question d'un client",
            ],
        ];

        foreach ($profils as $profil) {
            \App\Models\Profil::factory()->create($profil);
        }

        #======== CREATION DES RANGS PAR DEFAUT=========#

        $rangs = [
            [
                "name" => "admin",
                "description" => "L'administrateur général du networking",
            ],
            [
                "name" => "moderator",
                "description" => "Le modérateur du compte",
            ],
            [
                "name" => "user",
                "description" => "Un simple utilisateur du compte",
            ],
        ];

        foreach ($rangs as $rang) {
            \App\Models\Rang::factory()->create($rang);
        }

        #======== CREATION DES UTILISATEURS =========#
        \App\Models\User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$CI5P59ICr/HOihqlnYUrLeKwCajgMKd34HB66.JsJBrIOQY9fazrG', #admin
            'phone' => "61765590",
            "firstname"=> "Christian",
            "lastname"=> "GOGO",
            "country"=> "Bénin",
            "complement"=>"L'admin de tout le système"
        ]);
    }
}
