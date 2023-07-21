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
                'name' => 'add_user',
                'description' => 'Ajout d\'utilisateur',
                'visible' => true
            ],
            [
                'name' => 'global_stats',
                'description' => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc.",
                'visible' => true
            ],
            [
                'name' => 'list_agency',
                'description' => 'Liste des distributeurs',
                'visible' => true
            ],
            [
                'name' => 'update_agency',
                'description' => 'Editer distribibuteur',
                'visible' => true
            ],
            [
                'name' => 'send_msg_to_distributor',
                'description' => 'Envoyer de message aux distributeur',
                'visible' => true
            ],
            [
                'name' => 'delete_agency',
                'description' => 'Supprimer distributeur',
                'visible' => true
            ],
            [
                'name' => 'add_user_right',
                'description' => 'Ajout de droit',
                'visible' => true
            ],
            [
                'name' => 'admin',
                'description' => 'Administration',
                'visible' => true
            ],
            [
                'name' => 'activate_card',
                'description' => 'Activation de carte',
                'visible' => true
            ],
            [
                'name' => 'admin_agency',
                'description' => 'Administration pour distributeur',
                'visible' => true
            ],
            [
                'name' => 'recharge_card',
                'description' => 'recharge de compte',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajout de carte',
                'visible' => true
            ],
            [
                'name' => 'add_agency',
                'description' => 'Ajouter distributeur',
                'visible' => true
            ],
            [
                'name' => 'add_pos',
                'description' => 'Ajouter Point de Service, agence pour les distributeur',
                'visible' => true
            ],
            [
                'name' => 'list_pos',
                'description' => 'Voir la liste des points de vente',
                'visible' => true
            ],
            [
                'name' => 'list_card',
                'description' => 'Lister les cartes',
                'visible' => true
            ],
            [
                'name' => 'add_agency',
                'description' => 'Ajouter une agence',
                'visible' => true
            ],
            [
                'name' => 'credit_agency',
                'description' => 'Créditer une agence',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajouter une carte',
                'visible' => true
            ],
            [
                'name' => 'list_agent',
                'description' => 'Lister des agents commerciaux',
                'visible' => true
            ],
            [
                'name' => 'add_agent',
                'description' => 'Ajouter agent commercial',
                'visible' => true
            ],
            [
                'name' => 'list_rechargement',
                'description' => 'Lister les rechargements',
                'visible' => true
            ],
            [
                'name' => 'validate_card_load',
                'description' => 'Valider rechargement de carte',
                'visible' => true
            ],
            [
                'name' => 'list_master',
                'description' => 'Lister des masters',
                'visible' => true
            ],
            [
                'name' => 'add_master',
                'description' => 'Ajouter des masters',
                'visible' => true
            ],
            [
                'name' => 'update_card',
                'description' => 'Ajouter des masters',
                'visible' => true
            ],
            [
                'name' => 'credit_my_account',
                'description' => 'Créditer mon compte',
                'visible' => true
            ],
            [
                'name' => 'add_card',
                'description' => 'Ajouter une carte',
                'visible' => true
            ],
            [
                'name' => 'debit_agency',
                'description' => 'Débiter une agence',
                'visible' => true
            ],
            [
                'name' => 'delete_card',
                'description' => 'Supprimer carte',
                'visible' => true
            ],
            [
                'name' => 'stats',
                'description' => 'Statistiques',
                'visible' => true
            ],
            [
                'name' => 'canal_renew',
                'description' => 'Ajouter renouvellement',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_renew',
                'description' => 'Valider réabonnement',
                'visible' => true
            ],
            [
                'name' => 'add_decodeur',
                'description' => 'Ajouter décodeur',
                'visible' => true
            ],
            [
                'name' => 'credit_decodeur',
                'description' => 'Créditer le stock de décodeur pour un partenaire',
                'visible' => true
            ],
            [
                'name' => 'sell_decodeur',
                'description' => 'Vendre décodeur',
                'visible' => true
            ],
            [
                'name' => 'migrate_decodeur',
                'description' => 'Faire la migration de décodeur',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_enroll',
                'description' => 'Valider les recrutements (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'debit_decodeur',
                'description' => 'Débiter décodeur',
                'visible' => true
            ],
            [
                'name' => 'canal_validate_migration',
                'description' => 'Valider les recrutements (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'list_decodeur',
                'description' => 'Liste décodeurs (recrutement)',
                'visible' => true
            ],
            [
                'name' => 'canal_renew',
                'description' => 'Réabonnement',
                'visible' => true
            ],
            [
                'name' => 'sell_decodeur',
                'description' => 'Recrutement (vente de décodeur)',
                'visible' => true
            ],
            [
                'name' => 'migrate_decodeur',
                'description' => 'Migration de décodeur',
                'visible' => true
            ],
            [
                'name' => 'credit_accessoires',
                'description' => 'Créditer accessoires',
                'visible' => true
            ],
            [
                'name' => 'credit_parabole',
                'description' => 'Créditer parabole',
                'visible' => true
            ],
            [
                'name' => 'debit_accessoires',
                'description' => 'Débiter accessoires',
                'visible' => true
            ],
            [
                'name' => 'end_operation',
                'description' => 'Finir une Opération',
                'visible' => true
            ],
            [
                'name' => 'canal_update',
                'description' => 'Modification abonnement canal',
                'visible' => true
            ],
            [
                'name' => 'canal_enroll',
                'description' => 'Recrutement canal',
                'visible' => true
            ],
            [
                'name' => 'list_enroll',
                'description' => 'Liste des recrutements',
                'visible' => true
            ],
            [
                'name' => 'credit_materiel',
                'description' => 'Créditer un matériel',
                'visible' => true
            ],
            [
                'name' => 'list_migration',
                'description' => 'Liste des miigration',
                'visible' => true
            ],
            [
                'name' => 'canal_migration',
                'description' => 'Faire des migrations',
                'visible' => true
            ],
            [
                'name' => 'add_stock',
                'description' => 'Ajouter stock',
                'visible' => true
            ],
            [
                'name' => 'list_renew',
                'description' => 'Liste des reabonnements',
                'visible' => true
            ],
            [
                'name' => 'list_reactivation',
                'description' => 'Lister les réactivations',
                'visible' => true
            ],
            [
                'name' => 'canal_reactivation',
                'description' => 'Réactivation',
                'visible' => true
            ],
            [
                'name' => 'delete_user_right',
                'description' => 'Retirer droit à un utilisateur',
                'visible' => true
            ],
            [
                'name' => 'deliver_card',
                'description' => 'Délivrer une carte',
                'visible' => true
            ],
            [
                'name' => 'card_validate_activation',
                'description' => 'Valider activation de carte',
                'visible' => true
            ],
            [
                'name' => 'deepsearch',
                'description' => 'Recherche approfondie',
                'visible' => true
            ],
            [
                'name' => 'list_deepsearch',
                'description' => 'Liste recherches approfondies',
                'visible' => true
            ],
            [
                'name' => 'set_deepsearch',
                'description' => 'Répondre recherches approfondies',
                'visible' => true
            ],
            [
                'name' => 'see_commission',
                'description' => 'Voir commission',
                'visible' => true
            ],
            [
                'name' => 'see_balance',
                'description' => 'Voir solde',
                'visible' => true
            ],
            [
                'name' => 'reset_user_pass',
                'description' => 'Réinitialiser mot de passe',
                'visible' => true
            ],
            [
                'name' => 'list_deposit',
                'description' => 'Liste des dépôts',
                'visible' => true
            ],
            [
                'name' => 'add_deposit',
                'description' => 'Ajouter des dépôts',
                'visible' => true
            ],
            [
                'name' => 'set_deposit',
                'description' => 'Valider des dépôts',
                'visible' => true
            ],
            [
                'name' => 'view_statement',
                'description' => 'Voir relevé de compte',
                'visible' => true
            ],
            [
                'name' => 'assurance_new',
                'description' => 'Ajouter assurance',
                'visible' => true
            ],
            [
                'name' => 'list_assurance',
                'description' => 'Lister assurance',
                'visible' => true
            ],
            [
                'name' => 'process_assurance',
                'description' => 'Dévis assurance',
                'visible' => true
            ],
            [
                'name' => 'approve_assurance',
                'description' => 'Approuver devis',
                'visible' => true
            ],
            [
                'name' => 'list_assurance',
                'description' => 'Liste assurance',
                'visible' => true
            ],
            [
                'name' => 'authorize_commission_withdrawal',
                'description' => 'Autoriser reversement de commission',
                'visible' => true
            ],
            [
                'name' => 'list_cardload',
                'description' => 'Liste rechargement carte',
                'visible' => true
            ],
            [
                'name' => 'facture_new',
                'description' => 'Emettre des factures',
                'visible' => true
            ],
            [
                'name' => 'list_facture',
                'description' => 'Liste des factures',
                'visible' => true
            ],
            [
                'name' => 'validate_facture',
                'description' => 'Valider des factures',
                'visible' => true
            ]
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
                "name" => "Technicien",
                "description" => "Un Technicien de votre structure ou de FRIKLABEL",
            ],
            [
                "name" => "Employe",
                "description" => "Un Employe de votre structure",
            ],
            [
                "name" => "Agency",
                "description" => "Un Distributeur de votre structure",
            ],
            [
                "name" => "Master",
                "description" => "Master distributeur",
            ],
            [
                "name" => "Agent",
                "description" => "Agent commercial",
            ],
            [
                "name" => "Client",
                "description" => "Client",
            ],
            [
                "name" => "Admin",
                "description" => "L'administrateur",
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
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$CI5P59ICr/HOihqlnYUrLeKwCajgMKd34HB66.JsJBrIOQY9fazrG', #admin
                'phone' => "61765590",
                "firstname" => "Christian",
                "lastname" => "GOGO",
                "country" => "Bénin",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
                "complement" => "L'admin 1 de tout le système"
            ],

            [
                'username' => 'ppjjoel',
                'email' => 'ppjjoel@gmail.com',
                'password' => '$2y$10$ZT2msbcfYEUWGUucpnrHwekWMBDe1H0zGrvB.pzQGpepF8zoaGIMC', #ppjjoel
                'phone' => "61765590",
                "firstname" => "ppjjoel",
                "lastname" => "ppjjoel",
                "country" => "Bénin",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
                "complement" => "L'admin 2 de tout le système"
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::factory()->create($user);
        }

        #======== CREATION DES TYPES D'AGENT PAR DEFAUT =========#
        $agentTypes = [
            [
                "name" => "AgentComMaster",
                "description" => "Agent commercial d'un master",
            ],
            [
                "name" => "AgentComDistributeur",
                "description" => "Agent commercial d'un distributeur",
            ],
        ];
        foreach ($agentTypes as $type) {
            \App\Models\AgentType::factory()->create($type);
        }

        #======== CREATION DES TYPES D'AGENCE PAR DEFAUT =========#
        $agencyTypes = [
            [
                "name" => "PARTNER",
                "description" => "Partenaire",
            ],
            [
                "name" => "POP",
                "description" => "Point de présence",
            ],
        ];

        foreach ($agencyTypes as $type) {
            \App\Models\AgencyType::factory()->create($type);
        }

        #======== CREATION DES PIECES PAR DEFAUT =========#
        $pieces = [
            [
                "name" => "CIN",
                "description" => "Carte d'Identité Nationale - National Card ID",
            ],
            [
                "name" => "LEPI",
                "description" => "Carte de la Liste Eletorale Permanente Informatisé...",
            ],
            [
                "name" => "Passeport",
                "description" => "Passeport",
            ],
        ];

        foreach ($pieces as $piece) {
            \App\Models\Piece::factory()->create($piece);
        }

        #======== CREATION DES DOMAINES D'ACTIVITE  PAR DEFAUT =========#
        $domaines_activites = [
            [
                "libele" => "Agroalimentaire",
            ],
            [
                "libele" => "Banque / Assurance",
            ],
            [
                "libele" => "Bois / Papier / Carton / Imprimerie",
            ],

            [
                "libele" => "BTP / Matériaux de construction",
            ],
            [
                "libele" => "Chimie / Parachimie  Commerce / Négoce / Distribut.",
            ],
            [
                "libele" => "Édition / Communication / Multimédia",
            ],
            [
                "libele" => "Électronique / Électricité",
            ],

            [
                "libele" => "Études et conseils",
            ],
            [
                "libele" => "Industrie pharmaceutique",
            ],
            [
                "libele" => "Informatique / Télécoms",
            ],
            [
                "libele" => "Machines et équipements / Automobile",
            ],
            [
                "libele" => "Métallurgie / Travail du métal",
            ],
            [
                "libele" => "Plastique / Caoutchouc",
            ],
            [
                "libele" => "Services aux entreprises",
            ],
            [
                "libele" => "Textile / Habillement / Chaussure",
            ],
            [
                "libele" => "Transports / Logistique",
            ],
        ];

        foreach ($domaines_activites as $domaines_activite) {
            \App\Models\ActivityDomain::factory()->create($domaines_activite);
        }

        #======== CREATION DES RIGHTS  PAR DEFAUT =========#

        $rights = [
            ##### add_user
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout d'utilisateur"
            ],
            [
                "action" => \App\Models\Action::find(1),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout d'utilisateur"
            ],
            
            
            ######## global_stats

            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],
            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],
            [
                "action" => \App\Models\Action::find(2),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc."
            ],

            ######## list_agency

            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(7),
                "description" => "Liste des distributeurs"
            ],
            [
                "action" => \App\Models\Action::find(3),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des distributeurs"
            ],

            ######## update_agency

            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Editer distribibuteur"
            ],
            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Editer distribibuteur"
            ],
            [
                "action" => \App\Models\Action::find(4),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Editer distribibuteur"
            ],

            ######## send_msg_to_distributor

            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Envoyer de message aux distributeur"
            ],
            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Envoyer de message aux distributeur"
            ],
            [
                "action" => \App\Models\Action::find(5),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Envoyer de message aux distributeur"
            ],

            ######## delete_agency

            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Supprimer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Supprimer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(6),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Supprimer distributeur"
            ],

            ######## add_user_right

            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout de droit"
            ],
            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout de droit"
            ],
            [
                "action" => \App\Models\Action::find(7),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajout de droit"
            ],

            ######## admin

            [
                "action" => \App\Models\Action::find(8),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Administration"
            ],
            [
                "action" => \App\Models\Action::find(8),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Administration"
            ],

            ######## activate_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Activation de compte"
            ],

            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Activation de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de compte"
            ],


            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Activation de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Activer compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(9),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(7),
                "description" => "Activer compte"
            ],



            ######## recharge_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "recharge de compte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(11),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "recharge de compte"
            ],

            ######## add_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(12),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajout de carte"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(12),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter. compte carte prépayée"
            ],

            ######## add_agency

            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(13),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Ajouter distributeur"
            ],

            ######## add_pos

            [
                "action" => \App\Models\Action::find(14),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Ajouter Point de Service, agence pour les distributeur"
            ],

            ######## list_pos

            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Voir la liste des points de vente"
            ],
            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des points de service"
            ],
            [
                "action" => \App\Models\Action::find(15),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des points de service"
            ],


            ######## list_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(2),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(4),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste des comptes (cartes)"
            ],
            [
                "module" => 1,
                "action" => \App\Models\Action::find(16),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des cartes"
            ],


            ######## add_agency

            [
                "action" => \App\Models\Action::find(17),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter distributeur"
            ],
            [
                "action" => \App\Models\Action::find(17),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter distributeur"
            ],


            ######## credit_agency

            [
                "action" => \App\Models\Action::find(18),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer distributeur"
            ],
            [
                "action" => \App\Models\Action::find(18),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer distributeur"
            ],


            ######## add_card

            [
                "module" => 1,
                "action" => \App\Models\Action::find(19),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout de carte"
            ],

            ######## list_agent

            [
                "action" => \App\Models\Action::find(20),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste des agents commerciaux"
            ],

            ######## add_agent

            [
                "action" => \App\Models\Action::find(21),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter agent commercial"
            ],


            ######## list_rechargement

            [
                "module"=>2,
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Liste les rechargements"
            ],
            [
                "action" => \App\Models\Action::find(22),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Liste les rechargements"
            ],

            ######## validate_card_load

            [
                "module"=>1,
                "action" => \App\Models\Action::find(23),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider rechargement de carte"
            ],
            [
                "module"=>1,
                "action" => \App\Models\Action::find(23),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider rechargement"
            ],


            ######## list_master

            [
                "action" => \App\Models\Action::find(24),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "List des masters"
            ],

            ######## add_master

            [
                "action" => \App\Models\Action::find(25),
                "rang" => \App\Models\Rang::find(1),
                "profil" => \App\Models\Profil::find(3),
                "description" => "Ajout de master"
            ],

            ######## update_card

            [
                "module"=>1,
                "action" => \App\Models\Action::find(26),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Modifier compte"
            ],


            ######## credit_my_account

            [
                "action" => \App\Models\Action::find(27),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer mon compte"
            ],

            ######## add_card

            [
                "action" => \App\Models\Action::find(28),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajout de cartes"
            ],

            ######## debit_agency

            [
                "action" => \App\Models\Action::find(29),
                "rang" => \App\Models\Rang::find(3),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter une agence"
            ],
            [
                "action" => \App\Models\Action::find(29),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter une agence"
            ],



            ######## delete_card

            [
                "module"=>1,
                "action" => \App\Models\Action::find(30),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Supprimer carte"
            ],

            ######## stats

            [
                "action" => \App\Models\Action::find(31),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Statistiques"
            ],

            ######## canal_renew

            [
                "module"=>2,
                "action" => \App\Models\Action::find(32),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Ajouter renouvellement"
            ],

            ######## canal_validate_renew

            [
                "module"=>2,
                "action" => \App\Models\Action::find(33),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider réabonnement"
            ],

            ######## add_decodeur

            [
                "module"=>2,
                "action" => \App\Models\Action::find(34),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Ajouter décodeur"
            ],
            
            ######## credit_decodeur

            [
                "module"=>2,
                "action" => \App\Models\Action::find(35),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Créditer le stock de décodeur pour un partenaire"
            ],

            ######## sell_decodeur

            [
                "module"=>2,
                "action" => \App\Models\Action::find(36),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Vendre décodeur"
            ],

            ######## migrate_decodeur

            [
                "module"=>2,
                "action" => \App\Models\Action::find(37),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(5),
                "description" => "Faire la migration de décodeur"
            ],

            ######## canal_validate_enroll

            [
                "module"=>2,
                "action" => \App\Models\Action::find(38),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider les recrutements (vente de décodeur)"
            ],

            ######## debit_decodeur

            [
                "module"=>2,
                "action" => \App\Models\Action::find(39),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Débiter décodeur"
            ],

            ######## canal_validate_migration

            [
                "module"=>2,
                "action" => \App\Models\Action::find(40),
                "rang" => \App\Models\Rang::find(2),
                "profil" => \App\Models\Profil::find(6),
                "description" => "Valider les recrutements (vente de décodeur)"
            ],
            ####### NB::::: JE ME SUIS ARRETER ICI AU DROIT 104 DE LA DB DE MR JOEL
        ];

        foreach ($rights as $right) {
            \App\Models\Right::factory()->create($right);
        }
    }
}
