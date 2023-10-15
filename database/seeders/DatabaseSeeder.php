<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Sold;
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
                'name' => "list_contact",
                'description' => "Lister les contacts",
                'visible' => true
            ],
            [
                'name' => "add_contact",
                'description' => "Ajouter un contact",
                'visible' => true
            ],
            [
                'name' => "update_contact",
                'description' => "Mettre à jour un contact",
                'visible' => true
            ],
            [
                'name' => "delete_contact",
                'description' => "Supprimer un contact",
                'visible' => true
            ],
            [
                'name' => "view_contact",
                'description' => "Détail d'un contact",
                'visible' => true
            ],
            [
                'name' => "list_contactGroup",
                'description' => "Lister les groupe de cintact",
                'visible' => true
            ],
            [
                "name" => "add_contactGroup",
                "description" => "Ajouter un groupe de cintact",
                'visible' => true,
            ],
            [
                "name" => "update_contactGroup",
                "description" => "Mettre à jour un groupe de cintact",
                'visible' => true,
            ],
            [
                "name" => "delete_contactGroup",
                "description" => "Supprimer un groupe de cintact",
                'visible' => true,
            ],
            [
                "name" => "view_contactGroup",
                "description" => "Détail d'un groupe de contact",
                'visible' => true,
            ],
            [
                "name" => "list_expeditor",
                "description" => "Lister les expeditors",
                'visible' => true,
            ],
            [
                "name" => "add_expeditor",
                "description" => "Ajouter un expeditor",
                'visible' => true,
            ],
            [
                "name" => "update_expeditor",
                "description" => "Mettre à jour un expeditor",
                'visible' => true,
            ],
            [
                "name" => "delete_expeditor",
                "description" => "Supprimer un expeditor",
                'visible' => true,
            ],
            [
                "name" => "view_expeditor",
                "description" => "Détail d'un expeditor",
                'visible' => true,
            ],
            [
                "name" => "list_sms",
                "description" => "Lister les sms",
                'visible' => true,
            ],
            [
                "name" => "add_sms",
                "description" => "Ajouter un sms",
                'visible' => true,
            ],
            [
                "name" => "update_sms",
                "description" => "Mettre à jour un sms",
                'visible' => true,
            ],
            [
                "name" => "delete_sms",
                "description" => "Supprimer un sms",
                'visible' => true,
            ],
            [
                "name" => "view_sms",
                "description" => "Détail d'un sms",
                'visible' => true,
            ],
            [
                "name" => "list_campaign",
                "description" => "Lister les campagnes",
                'visible' => true,
            ],
            [
                "name" => "add_campaign",
                "description" => "Ajouter une campagne",
                'visible' => true,
            ],
            [
                "name" => "update_campaign",
                "description" => "Mettre à jour une campagne",
                'visible' => true,
            ],
            [
                "name" => "delete_campaign",
                "description" => "Supprimer une campagne",
                'visible' => true,
            ],
            [
                "name" => "stop_campaign",
                "description" => "Stoper une campagne",
                'visible' => true,
            ],
            [
                "name" => "initiate_campaign",
                "description" => "Initier une campagne",
                'visible' => true,
            ],
            [
                "name" => "view_campaign",
                "description" => "Détail d'une campagne",
                'visible' => true,
            ],
            [
                "name" => "list_user",
                "description" => "Lister les users",
                'visible' => true,
            ],
            [
                "name" => "update_user",
                "description" => "Mettre à jour un user",
                'visible' => true,
            ],
            [
                "name" => "delete_user",
                "description" => "Supprimer un user",
                'visible' => true,
            ],
            [
                "name" => "view_user",
                "description" => "Détail d'un user",
                'visible' => true,
            ],
            [
                "name" => "list_right",
                "description" => "Lister les rights",
                'visible' => true,
            ],
            [
                "name" => "add_right",
                "description" => "Ajouter un right",
                'visible' => true,
            ],
            [
                "name" => "update_right",
                "description" => "Mettre à jour un right",
                'visible' => true,
            ],
            [
                "name" => "delete_right",
                "description" => "Supprimer un right",
                'visible' => true,
            ],
            [
                "name" => "view_right",
                "description" => "Détail d'un right",
                'visible' => true,
            ],
            [
                "name" => "list_profil",
                "description" => "Lister les profils",
                'visible' => true,
            ],
            [
                "name" => "add_profil",
                "description" => "Ajouter un profil",
                'visible' => true,
            ],
            [
                "name" => "update_profil",
                "description" => "Mettre à jour un profil",
                'visible' => true,
            ],
            [
                "name" => "delete_profil",
                "description" => "Supprimer un profil",
                'visible' => true,
            ],
            [
                "name" => "view_profil",
                "description" => "Détail d'un profil",
                'visible' => true,
            ],
            [
                "name" => "list_rang",
                "description" => "Lister les rangs",
                'visible' => true,
            ],
            [
                "name" => "add_rang",
                "description" => "Ajouter un rang",
                'visible' => true,
            ],
            [
                "name" => "update_rang",
                "description" => "Mettre à jour un rang",
                'visible' => true,
            ],
            [
                "name" => "delete_rang",
                "description" => "Supprimer un rang",
                'visible' => true,
            ],
            [
                "name" => "view_rang",
                "description" => "Détail d'un rang",
                'visible' => true,
            ],
            [
                "name" => "list_action",
                "description" => "Lister les action",
                'visible' => true,
            ],
            [
                "name" => "add_action",
                "description" => "Ajouter un action",
                'visible' => true,
            ],
            [
                "name" => "update_action",
                "description" => "Mettre à jour un action",
                'visible' => true,
            ],
            [
                "name" => "delete_action",
                "description" => "Supprimer un action",
                'visible' => true,
            ],
            [
                "name" => "view_action",
                "description" => "Détail d'une action",
                'visible' => true,
            ],
            [
                "name" => "affect_right",
                "description" => "Affecter un droit",
                'visible' => true,
            ],
            [
                "name" => "desattach_right",
                "description" => "Retirer un droit à un utilisateur",
                'visible' => true,
            ],
            [
                "name" => "credit_sold",
                "description" => "Crediter un compte",
                'visible' => true
            ],
            [
                "name" => "add_user",
                "description" => "Ajout d'utilisateur",
                'visible' => true,
            ],
            [
                "name" => "global_stats",
                "description" => "Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc.",
                'visible' => true
            ],
            [
                "name" => "list_agency",
                "description" => "Liste des distributeurs",
                'visible' => true,
            ],
            [
                "name" => "update_agency",
                "description" => "Editer distribibuteur",
                'visible' => true,
            ],
            [
                "name" => "send_msg_to_distributor",
                "description" => "Envoyer de message aux distributeur",
                'visible' => true,
            ],
            [
                "name" => "delete_agency",
                "description" => "Supprimer distributeur",
                'visible' => true,
            ],
            [
                "name" => "add_user_right",
                "description" => "Ajout de droit",
                'visible' => true,
            ],
            [
                "name" => "admin",
                "description" => "Administration",
                'visible' => true,
            ],
            [
                "name" => "activate_card",
                "description" => "Activation de carte",
                'visible' => true
            ],
            [
                "name" => "admin_agency",
                "description" => "Administration pour distributeur",
                'visible' => true,
            ],
            [
                "name" => "recharge_card",
                "description" => "recharge de compte",
                'visible' => true,
            ],
            [
                "name" => "add_card",
                "description" => "Ajout de carte",
                'visible' => true,
            ],
            [
                "name" => "add_agency",
                "description" => "Ajouter distributeur",
                'visible' => true,
            ],
            [
                "name" => "add_pos",
                "description" => "Ajouter Point de Service, agence pour les distributeur",
                'visible' => true,
            ],
            [
                "name" => "list_pos",
                "description" => "Voir la liste des points de vente",
                'visible' => true,
            ],
            [
                "name" => "list_card",
                "description" => "Lister les cartes",
                'visible' => true,
            ],
            [
                "name" => "add_agency",
                "description" => "Ajouter une agence",
                'visible' => true,
            ],
            [
                "name" => "credit_agency",
                "description" => "Créditer une agence",
                'visible' => true,
            ],
            [
                "name" => "add_card",
                "description" => "Ajouter une carte",
                'visible' => true,
            ],
            [
                "name" => "list_agent",
                "description" => "Lister des agents commerciaux",
                'visible' => true,
            ],
            [
                "name" => "add_agent",
                "description" => "Ajouter agent commercial",
                'visible' => true,
            ],
            [
                "name" => "list_rechargement",
                "description" => "Lister les rechargements",
                'visible' => true,
            ],
            [
                "name" => "validate_card_load",
                "description" => "Valider rechargement de carte",
                'visible' => true,
            ],
            [
                "name" => "list_master",
                "description" => "Lister des masters",
                'visible' => true,
            ],
            [
                "name" => "add_master",
                "description" => "Ajouter des masters",
                'visible' => true,
            ],
            [
                "name" => "update_card",
                "description" => "Ajouter des masters",
                'visible' => true,
            ],
            [
                "name" => "credit_my_account",
                "description" => "Créditer mon compte",
                'visible' => true,
            ],
            [
                "name" => "add_card",
                "description" => "Ajouter une carte",
                'visible' => true,
            ],
            [
                "name" => "debit_agency",
                "description" => "Débiter une agence",
                'visible' => true,
            ],
            [
                "name" => "delete_card",
                "description" => "Supprimer carte",
                'visible' => true,
            ],
            [
                "name" => "stats",
                "description" => "Statistiques",
                'visible' => true,
            ],
            [
                "name" => "canal_renew",
                "description" => "Ajouter renouvellement",
                'visible' => true,
            ],
            [
                "name" => "canal_validate_renew",
                "description" => "Valider réabonnement",
                'visible' => true,
            ],
            [
                "name" => "add_decodeur",
                "description" => "Ajouter décodeur",
                'visible' => true,
            ],
            [
                "name" => "credit_decodeur",
                "description" => "Créditer le stock de décodeur pour un partenaire",
                'visible' => true,
            ],
            [
                "name" => "sell_decodeur",
                "description" => "Vendre décodeur",
                'visible' => true,
            ],
            [
                "name" => "migrate_decodeur",
                "description" => "Faire la migration de décodeur",
                'visible' => true,
            ],
            [
                "name" => "canal_validate_enroll",
                "description" => "Valider les recrutements (vente de décodeur)",
                'visible' => true,
            ],
            [
                "name" => "debit_decodeur",
                "description" => "Débiter décodeur",
                'visible' => true,
            ],
            [
                "name" => "canal_validate_migration",
                "description" => "Valider les recrutements (vente de décodeur)",
                'visible' => true,
            ],
            [
                "name" => "list_decodeur",
                "description" => "Liste décodeurs (recrutement)",
                'visible' => true,
            ],
            [
                "name" => "canal_renew",
                "description" => "Réabonnement",
                'visible' => true,
            ],
            [
                "name" => "sell_decodeur",
                "description" => "Recrutement (vente de décodeur)",
                'visible' => true,
            ],
            [
                "name" => "migrate_decodeur",
                "description" => "Migration de décodeur",
                'visible' => true,
            ],
            [
                "name" => "credit_accessoires",
                "description" => "Créditer accessoires",
                'visible' => true,
            ],
            [
                "name" => "credit_parabole",
                "description" => "Créditer parabole",
                'visible' => true,
            ],
            [
                "name" => "debit_accessoires",
                "description" => "Débiter accessoires",
                'visible' => true,
            ],
            [
                "name" => "end_operation",
                "description" => "Finir une Opération",
                'visible' => true,
            ],
            [
                "name" => "canal_update",
                "description" => "Modification abonnement canal",
                'visible' => true,
            ],
            [
                "name" => "canal_enroll",
                "description" => "Recrutement canal",
                'visible' => true,
            ],
            [
                "name" => "list_enroll",
                "description" => "Liste des recrutements",
                'visible' => true,
            ],
            [
                "name" => "credit_materiel",
                "description" => "Créditer un matériel",
                'visible' => true,
            ],
            [
                "name" => "list_migration",
                "description" => "Liste des miigration",
                'visible' => true,
            ],
            [
                "name" => "canal_migration",
                "description" => "Faire des migrations",
                'visible' => true,
            ],
            [
                "name" => "add_stock",
                "description" => "Ajouter stock",
                'visible' => true,
            ],
            [
                "name" => "list_renew",
                "description" => "Liste des reabonnements",
                'visible' => true,
            ],
            [
                "name" => "list_reactivation",
                "description" => "Lister les réactivations",
                'visible' => true,
            ],
            [
                "name" => "canal_reactivation",
                "description" => "Réactivation",
                'visible' => true,
            ],
            [
                "name" => "delete_user_right",
                "description" => "Retirer droit à un utilisateur",
                'visible' => true,
            ],
            [
                "name" => "deliver_card",
                "description" => "Délivrer une carte",
                'visible' => true,
            ],
            [
                "name" => "card_validate_activation",
                "description" => "Valider activation de carte",
                'visible' => true,
            ],
            [
                "name" => "deepsearch",
                "description" => "Recherche approfondie",
                'visible' => true,
            ],
            [
                "name" => "list_deepsearch",
                "description" => "Liste recherches approfondies",
                'visible' => true,
            ],
            [
                "name" => "set_deepsearch",
                "description" => "Répondre recherches approfondies",
                'visible' => true,
            ],
            [
                "name" => "see_commission",
                "description" => "Voir commission",
                'visible' => true,
            ],
            [
                "name" => "see_balance",
                "description" => "Voir solde",
                'visible' => true,
            ],
            [
                "name" => "reset_user_pass",
                "description" => "Réinitialiser mot de passe",
                'visible' => true,
            ],
            [
                "name" => "list_deposit",
                "description" => "Liste des dépôts",
                'visible' => true,
            ],
            [
                "name" => "add_deposit",
                "description" => "Ajouter des dépôts",
                'visible' => true,
            ],
            [
                "name" => "set_deposit",
                "description" => "Valider des dépôts",
                'visible' => true,
            ],
            [
                "name" => "view_statement",
                "description" => "Voir relevé de compte",
                'visible' => true,
            ],
            [
                "name" => "assurance_new",
                "description" => "Ajouter assurance",
                'visible' => true,
            ],
            [
                "name" => "list_assurance",
                "description" => "Lister assurance",
                'visible' => true,
            ],
            [
                "name" => "process_assurance",
                "description" => "Dévis assurance",
                'visible' => true,
            ],
            [
                "name" => "approve_assurance",
                "description" => "Approuver devis",
                'visible' => true,
            ],
            [
                "name" => "list_assurance",
                "description" => "Liste assurance",
                'visible' => true,
            ],
            [
                "name" => "authorize_commission_withdrawal",
                "description" => "Autoriser reversement de commission",
                'visible' => true,
            ],
            [
                "name" => "list_cardload",
                "description" => "Liste rechargement carte",
                'visible' => true,
            ],
            [
                "name" => "facture_new",
                "description" => "Emettre des factures",
                'visible' => true,
            ],
            [
                "name" => "list_facture",
                "description" => "Liste des factures",
                'visible' => true,
            ],
            [
                "name" => "validate_facture",
                "description" => "Valider des factures",
                'visible' => true,
            ],
            [
                "name" => "list_master",
                "description" => "Lister les masters",
                'visible' => true,
            ],
            [
                "name" => "add_master",
                "description" => "Ajouter un master",
                'visible' => true,
            ],
            [
                "name" => "update_master",
                "description" => "Mettre à jour un master",
                'visible' => true,
            ],
            [
                "name" => "delete_master",
                "description" => "Supprimer un master",
                'visible' => true,
            ],
            [
                "name" => "list_agency",
                "description" => "Lister les agencies",
                'visible' => true,
            ],
            [
                "name" => "add_agency",
                "description" => "Ajouter un agency",
                'visible' => true,
            ],
            [
                "name" => "update_agency",
                "description" => "Mettre à jour un agency",
                'visible' => true,
            ],
            [
                "name" => "delete_agency",
                "description" => "Supprimer un agency",
                'visible' => true,
            ],
            [
                "name" => "list_agent",
                "description" => "Lister les agents",
                'visible' => true,
            ],
            [
                "name" => "add_agent",
                "description" => "Ajouter un agent",
                'visible' => true,
            ],
            [
                "name" => "update_agent",
                "description" => "Mettre à jour un agent",
                'visible' => true,
            ],
            [
                "name" => "delete_agent",
                "description" => "Supprimer un agent",
                'visible' => true,
            ],
            [
                "name" => "list_pos",
                "description" => "Lister les pos",
                'visible' => true,
            ],
            [
                "name" => "add_pos",
                "description" => "Ajouter un pos",
                'visible' => true,
            ],
            [
                "name" => "update_pos",
                "description" => "Mettre à jour un pos",
                'visible' => true,
            ],
            [
                "name" => "delete_pos",
                "description" => "Supprimer un pos",
                'visible' => true,
            ],
            [
                "name" => "list_table",
                "description" => "Lister les tables",
                'visible' => true,
            ],
            [
                "name" => "add_table",
                "description" => "Ajouter une table",
                'visible' => true,
            ],
            [
                "name" => "update_table",
                "description" => "Mettre à jour une table",
                'visible' => true,
            ],
            [
                "name" => "delete_table",
                "description" => "Supprimer une table",
                'visible' => true,
            ],
            [
                "name" => "list_product",
                "description" => "Lister les products",
                'visible' => true,
            ],
            [
                "name" => "add_product",
                "description" => "Ajouter un product",
                'visible' => true,
            ],
            [
                "name" => "update_product",
                "description" => "Mettre à jour un product",
                'visible' => true,
            ],
            [
                "name" => "delete_product",
                "description" => "Supprimer un product",
                'visible' => true,
            ],
            [
                "name" => "list_order",
                "description" => "Lister les orders",
                'visible' => true,
            ],
            [
                "name" => "add_order",
                "description" => "Ajouter un order",
                'visible' => true,
            ],
            [
                "name" => "update_order",
                "description" => "Mettre à jour un order",
                'visible' => true,
            ],
            [
                "name" => "delete_order",
                "description" => "Supprimer un order",
                'visible' => true,
            ],
            [
                "name" => "list_product_category",
                "description" => "Lister les product_categories",
                'visible' => true,
            ],
            [
                "name" => "add_product_category",
                "description" => "Ajouter un product_category",
                'visible' => true,
            ],
            [
                "name" => "update_product_category",
                "description" => "Mettre à jour un product_category",
                'visible' => true,
            ],
            [
                "name" => "delete_product_category",
                "description" => "Supprimer un product_category",
                'visible' => true,
            ],
            [
                "name" => "list_store",
                "description" => "Lister les stores",
                'visible' => true,
            ],
            [
                "name" => "add_store",
                "description" => "Ajouter un store",
                'visible' => true,
            ],
            [
                "name" => "update_store",
                "description" => "Mettre à jour un store",
                'visible' => true,
            ],
            [
                "name" => "delete_store",
                "description" => "Supprimer un store",
                'visible' => true,
            ],
            [
                "name" => "list_user",
                "description" => "Lister les users",
                'visible' => true,
            ],
            [
                "id" => 173,
                "name" => "update_user",
                "description" => "Mettre à jour un user",
                'visible' => true,
            ],
            [
                "name" => "delete_user",
                "description" => "Supprimer un user",
                'visible' => true,
            ],
            [
                "name" => "list_right",
                "description" => "Lister les rights",
                'visible' => true,
            ],
            [
                "name" => "add_right",
                "description" => "Ajouter un right",
                'visible' => true,
            ],
            [
                "name" => "update_right",
                "description" => "Mettre à jour un right",
                'visible' => true,
            ],
            [
                "name" => "delete_right",
                "description" => "Supprimer un right",
                'visible' => true,
            ],
            [
                "name" => "list_profil",
                "description" => "Lister les profils",
                'visible' => true,
            ],
            [
                "name" => "add_profil",
                "description" => "Ajouter un profil",
                'visible' => true,
            ],
            [
                "name" => "update_profil",
                "description" => "Mettre à jour un profil",
                'visible' => true,
            ],
            [
                "name" => "delete_profil",
                "description" => "Supprimer un profil",
                'visible' => true,
            ],
            [
                "name" => "list_rang",
                "description" => "Lister les rangs",
                'visible' => true,
            ],
            [
                "name" => "add_rang",
                "description" => "Ajouter un rang",
                'visible' => true,
            ],
            [
                "name" => "update_rang",
                "description" => "Mettre à jour un rang",
                'visible' => true,
            ],
            [
                "name" => "delete_rang",
                "description" => "Supprimer un rang",
                'visible' => true,
            ],
            [
                "name" => "list_action",
                "description" => "Lister les action",
                'visible' => true,
            ],
            [
                "name" => "add_action",
                "description" => "Ajouter un action",
                'visible' => true,
            ],
            [
                "name" => "update_action",
                "description" => "Mettre à jour un action",
                'visible' => true,
            ],
            [
                "name" => "delete_action",
                "description" => "Supprimer un action",
                'visible' => true,
            ],
            [
                "name" => "affect_right",
                "description" => "Affecter un droit",
                'visible' => true,
            ],
            [
                "name" => "initiate_sold",
                "description" => "Initier un solde",
                'visible' => true,
            ],
            [
                "name" => "initiate_session",
                "description" => "Initier une session",
                'visible' => true,
            ],
            [
                "name" => "creditate_pos_sold",
                "description" => "Crediter le solde d'un pos",
                'visible' => true,
            ],
            [
                "name" => "affect_agent_to_pos",
                "description" => "Affecter un agent à un pos",
                'visible' => true,
            ],
            [
                "name" => "affect_store_to_pos",
                "description" => "Affecter un store à un POS",
                'visible' => true,
            ],
            [
                "name" => "affect_pos_to_agency",
                "description" => "Affecter un pos à une agence",
                'visible' => true,
            ],
            [
                "name" => "validate_sold",
                "description" => "Valider la créditation de sold d'une agence",
                'visible' => true,
            ],
            [
                "name" => "validate_pos_sold",
                "description" => "Valider la demande de credit d'un pos",
                'visible' => true,
            ],
            [
                "name" => "add_facture",
                "description" => "Ajouter une facture",
                'visible' => true,
            ],
            [
                "name" => "update_facture",
                "description" => "Modifier une facture",
                'visible' => true,
            ],
            [
                "name" => "delete_facture",
                "description" => "Supprimer une facture",
                'visible' => true,
            ],
            [
                "name" => "generate_facture",
                "description" => "Generer une facture",
                'visible' => true,
            ],
            [
                "name" => "download_facture",
                "description" => "Télecharger une facture",
                'visible' => true,
            ],
            [
                "name" => "add_supply",
                "description" => "Ajouter un approvisionnement",
                'visible' => true,
            ],
            [
                "name" => "list_supply",
                "description" => "Lister les approvisionnements",
                'visible' => true,
            ],
            [
                "name" => "update_supply",
                "description" => "Modifier un approvisionnement",
                'visible' => true,
            ],
            [
                "name" => "delete_supply",
                "description" => "Supprimer un approvisionnement",
                'visible' => true,
            ],
            [
                "name" => "supply_product",
                "description" => "Approvisonner un produit",
                'visible' => true,
            ],
            [
                "name" => "affect_agent_to_store",
                "description" => "Affecter un agent à un store",
                'visible' => true,
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
                ##$2y$10$zudZOjzoVES/IgmL2mwk3.ZnSpZeH2lIDx8HvjXz4tftB2kDYbQO6 _____kevine14________~######PASSwORD DE KEVINE. ___hountonpanchy75@gmail.com ______ mail kevine
                ## lagraceparle98@gmail.com _______mail de abdias____
                'pass_default' => 'admin', #admin
                'is_admin' => true,
                'phone' => "22961765590",
                "firstname" => "Admin 1",
                "lastname" => "Admin",
                "country" => "Bénin",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
                "complement" => "L'admin 1 de tout le système"
            ],

            [
                'username' => 'ppjjoel',
                'email' => 'ppjjoel@gmail.com',
                'password' => '$2y$10$ZT2msbcfYEUWGUucpnrHwekWMBDe1H0zGrvB.pzQGpepF8zoaGIMC', #ppjjoel
                'pass_default' => 'ppjjoel', #ppjjoel
                'is_admin' => true,
                'phone' => "22997555619",
                "firstname" => "PPJ",
                "lastname" => "Joel",
                "country" => "Bénin",
                "rang_id" => \App\Models\Rang::find(1),
                "profil_id" => \App\Models\Profil::find(9),
                "complement" => "L'admin 2 de tout le système"
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::factory()->create($user);
        }

        #======== CREATION DES STATUS DE SOLDE PAR DEFAUT =========#
        $soldStatus = [
            [
                "name" => "initié",
                "description" => "Ce sold est en phase d'initiation",
            ],
            [
                "name" => "Validé",
                "description" => "Ce sold est validé!",
            ],
        ];
        foreach ($soldStatus as $status) {
            \App\Models\SoldStatus::factory()->create($status);
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
            ###____Droits d'un utilisaateur
            ["action" => \App\Models\Action::find(27),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Détail d'une campagne    "],
            ["action" => \App\Models\Action::find(26),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Initier une campagne    "],
            ["action" => \App\Models\Action::find(25),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Stoper une campagne    "],
            ["action" => \App\Models\Action::find(24),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Supprimer une campagne    "],
            ["action" => \App\Models\Action::find(23),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Mettre à jour une campagne    "],
            ["action" => \App\Models\Action::find(22),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Ajouter une campagne    "],
            ["action" => \App\Models\Action::find(21),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Lister les campagnes    "],
            ["action" => \App\Models\Action::find(20),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Détail d'un sms    "],
            ["action" => \App\Models\Action::find(19),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Supprimer un sms    "],
            ["action" => \App\Models\Action::find(18),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Mettre à jour un sms    "],
            ["action" => \App\Models\Action::find(17),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Ajouter un sms    "],
            ["action" => \App\Models\Action::find(16),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Lister les sms    "],
            ["action" => \App\Models\Action::find(15),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Détail d'un expediteur    "],
            ["action" => \App\Models\Action::find(14),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Supprimer un expediteur    "],
            ["action" => \App\Models\Action::find(13),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Mettre à jour un expediteur    "],
            ["action" => \App\Models\Action::find(12),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Ajouter un expediteur    "],
            ["action" => \App\Models\Action::find(11),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Lister les expediteurs    "],
            ["action" => \App\Models\Action::find(10),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Détail d'un groupe de contact    "],
            ["action" => \App\Models\Action::find(9),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Supprimer un groupe de contact    "],
            ["action" => \App\Models\Action::find(8),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Mettre à jour un groupe de contact    "],
            ["action" => \App\Models\Action::find(7),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Ajouter un groupe de contact    "],
            ["action" => \App\Models\Action::find(6),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Lister les groupe de contact    "],
            ["action" => \App\Models\Action::find(5),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Détail d'un contact    "],
            ["action" => \App\Models\Action::find(4),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Supprimer un contact    "],
            ["action" => \App\Models\Action::find(3),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Mettre à jour un contact    "],
            ["action" => \App\Models\Action::find(2),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Ajouter un contact    "],
            ["action" => \App\Models\Action::find(1),         "rang" => \App\Models\Rang::find(2),         "profil" => \App\Models\Profil::find(6),         "description" => "Droit: Lister les contacts "],
            ["action" => \App\Models\Action::find(191),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Affecter un droit    "],
            ["action" => \App\Models\Action::find(190),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un action    "],
            ["action" => \App\Models\Action::find(189),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un action    "],
            ["action" => \App\Models\Action::find(188),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un action    "],
            ["action" => \App\Models\Action::find(187),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les action    "],
            ["action" => \App\Models\Action::find(186),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un rang    "],
            ["action" => \App\Models\Action::find(185),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un rang    "],
            ["action" => \App\Models\Action::find(184),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un rang    "],
            ["action" => \App\Models\Action::find(183),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rangs    "],
            ["action" => \App\Models\Action::find(182),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un profil    "],
            ["action" => \App\Models\Action::find(181),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un profil    "],
            ["action" => \App\Models\Action::find(180),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un profil    "],
            ["action" => \App\Models\Action::find(179),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les profils    "],
            ["action" => \App\Models\Action::find(178),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un right    "],
            ["action" => \App\Models\Action::find(177),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un right    "],
            ["action" => \App\Models\Action::find(176),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un right    "],
            ["action" => \App\Models\Action::find(175),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rights    "],
            ["action" => \App\Models\Action::find(174),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un user    "],
            ["action" => \App\Models\Action::find(173),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un user    "],
            ["action" => \App\Models\Action::find(172),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les users    "],
            ["action" => \App\Models\Action::find(171),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un store    "],
            ["action" => \App\Models\Action::find(170),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un store    "],
            ["action" => \App\Models\Action::find(169),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un store    "],
            ["action" => \App\Models\Action::find(168),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les stores    "],
            ["action" => \App\Models\Action::find(167),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un product_category    "],
            ["action" => \App\Models\Action::find(166),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un product_category    "],
            ["action" => \App\Models\Action::find(165),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un product_category    "],
            ["action" => \App\Models\Action::find(164),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les product_categories    "],
            ["action" => \App\Models\Action::find(163),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un order    "],
            ["action" => \App\Models\Action::find(162),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un order    "],
            ["action" => \App\Models\Action::find(161),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un order    "],
            ["action" => \App\Models\Action::find(160),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les orders    "],
            ["action" => \App\Models\Action::find(159),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un product    "],
            ["action" => \App\Models\Action::find(158),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un product    "],
            ["action" => \App\Models\Action::find(157),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un product    "],
            ["action" => \App\Models\Action::find(156),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les products    "],
            ["action" => \App\Models\Action::find(155),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer une table    "],
            ["action" => \App\Models\Action::find(154),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour une table    "],
            ["action" => \App\Models\Action::find(153),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une table    "],
            ["action" => \App\Models\Action::find(152),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les tables    "],
            ["action" => \App\Models\Action::find(151),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un pos    "],
            ["action" => \App\Models\Action::find(150),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un pos    "],
            ["action" => \App\Models\Action::find(149),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un pos    "],
            ["action" => \App\Models\Action::find(148),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les pos    "],
            ["action" => \App\Models\Action::find(147),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un agent    "],
            ["action" => \App\Models\Action::find(146),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un agent    "],
            ["action" => \App\Models\Action::find(145),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un agent    "],
            ["action" => \App\Models\Action::find(144),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les agents    "],
            ["action" => \App\Models\Action::find(143),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un agency    "],
            ["action" => \App\Models\Action::find(142),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un agency    "],
            ["action" => \App\Models\Action::find(141),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un agency    "],
            ["action" => \App\Models\Action::find(140),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les agencies    "],
            ["action" => \App\Models\Action::find(139),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un master    "],
            ["action" => \App\Models\Action::find(138),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un master    "],
            ["action" => \App\Models\Action::find(137),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un master    "],
            ["action" => \App\Models\Action::find(136),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les masters    "],
            ["action" => \App\Models\Action::find(135),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider des factures    "],
            ["action" => \App\Models\Action::find(134),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des factures    "],
            ["action" => \App\Models\Action::find(133),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Emettre des factures    "],
            ["action" => \App\Models\Action::find(132),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste rechargement carte    "],
            ["action" => \App\Models\Action::find(131),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Autoriser reversement de commission    "],
            ["action" => \App\Models\Action::find(130),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste assurance    "],
            ["action" => \App\Models\Action::find(129),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Approuver devis    "],
            ["action" => \App\Models\Action::find(128),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Dévis assurance    "],
            ["action" => \App\Models\Action::find(127),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister assurance    "],
            ["action" => \App\Models\Action::find(126),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter assurance    "],
            ["action" => \App\Models\Action::find(125),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir relevé de compte    "],
            ["action" => \App\Models\Action::find(124),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider des dépôts    "],
            ["action" => \App\Models\Action::find(123),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des dépôts    "],
            ["action" => \App\Models\Action::find(122),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des dépôts    "],
            ["action" => \App\Models\Action::find(121),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réinitialiser mot de passe    "],
            ["action" => \App\Models\Action::find(120),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir solde    "],
            ["action" => \App\Models\Action::find(119),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir commission    "],
            ["action" => \App\Models\Action::find(118),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Répondre recherches approfondies    "],
            ["action" => \App\Models\Action::find(117),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste recherches approfondies    "],
            ["action" => \App\Models\Action::find(116),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recherche approfondie    "],
            ["action" => \App\Models\Action::find(115),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider activation de carte    "],
            ["action" => \App\Models\Action::find(114),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Délivrer une carte    "],
            ["action" => \App\Models\Action::find(113),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Retirer droit à un utilisateur    "],
            ["action" => \App\Models\Action::find(112),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réactivation    "],
            ["action" => \App\Models\Action::find(111),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les réactivations    "],
            ["action" => \App\Models\Action::find(110),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des reabonnements    "],
            ["action" => \App\Models\Action::find(109),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter stock    "],
            ["action" => \App\Models\Action::find(108),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Faire des migrations    "],
            ["action" => \App\Models\Action::find(107),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des miigration    "],
            ["action" => \App\Models\Action::find(106),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer un matériel    "],
            ["action" => \App\Models\Action::find(105),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des recrutements    "],
            ["action" => \App\Models\Action::find(104),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recrutement canal    "],
            ["action" => \App\Models\Action::find(103),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Modification abonnement canal    "],
            ["action" => \App\Models\Action::find(102),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Finir une Opération    "],
            ["action" => \App\Models\Action::find(101),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter accessoires    "],
            ["action" => \App\Models\Action::find(100),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer parabole    "],
            ["action" => \App\Models\Action::find(99),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer accessoires    "],
            ["action" => \App\Models\Action::find(98),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Migration de décodeur    "],
            ["action" => \App\Models\Action::find(97),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recrutement (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(96),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réabonnement    "],
            ["action" => \App\Models\Action::find(95),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste décodeurs (recrutement)    "],
            ["action" => \App\Models\Action::find(94),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider les recrutements (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(93),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter décodeur    "],
            ["action" => \App\Models\Action::find(92),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider les recrutements (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(91),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Faire la migration de décodeur    "],
            ["action" => \App\Models\Action::find(90),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Vendre décodeur    "],
            ["action" => \App\Models\Action::find(89),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer le stock de décodeur pour un partenaire    "],
            ["action" => \App\Models\Action::find(88),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter décodeur    "],
            ["action" => \App\Models\Action::find(87),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider réabonnement    "],
            ["action" => \App\Models\Action::find(86),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter renouvellement    "],
            ["action" => \App\Models\Action::find(85),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Statistiques    "],
            ["action" => \App\Models\Action::find(84),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer carte    "],
            ["action" => \App\Models\Action::find(83),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter une agence    "],
            ["action" => \App\Models\Action::find(82),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une carte    "],
            ["action" => \App\Models\Action::find(81),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer mon compte    "],
            ["action" => \App\Models\Action::find(80),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des masters    "],
            ["action" => \App\Models\Action::find(79),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des masters    "],
            ["action" => \App\Models\Action::find(78),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister des masters    "],
            ["action" => \App\Models\Action::find(77),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider rechargement de carte    "],
            ["action" => \App\Models\Action::find(76),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rechargements    "],
            ["action" => \App\Models\Action::find(75),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter agent commercial    "],
            ["action" => \App\Models\Action::find(74),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister des agents commerciaux    "],
            ["action" => \App\Models\Action::find(73),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une carte    "],
            ["action" => \App\Models\Action::find(72),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer une agence    "],
            ["action" => \App\Models\Action::find(71),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une agence    "],
            ["action" => \App\Models\Action::find(70),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les cartes    "],
            ["action" => \App\Models\Action::find(99),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir la liste des points de vente    "],
            ["action" => \App\Models\Action::find(98),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter Point de Service, agence pour les distributeur    "],
            ["action" => \App\Models\Action::find(97),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter distributeur    "],
            ["action" => \App\Models\Action::find(96),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout de carte    "],
            ["action" => \App\Models\Action::find(95),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: recharge de compte    "],
            ["action" => \App\Models\Action::find(94),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Administration pour distributeur    "],
            ["action" => \App\Models\Action::find(93),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Activation de carte    "],
            ["action" => \App\Models\Action::find(92),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Administration    "],
            ["action" => \App\Models\Action::find(91),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout de droit    "],
            ["action" => \App\Models\Action::find(90),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer distributeur    "],
            ["action" => \App\Models\Action::find(59),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Envoyer de message aux distributeur    "],
            ["action" => \App\Models\Action::find(58),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Editer distribibuteur    "],
            ["action" => \App\Models\Action::find(57),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des distributeurs    "],
            ["action" => \App\Models\Action::find(56),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc.    "],
            ["action" => \App\Models\Action::find(55),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout d'utilisateur    "],
            ["action" => \App\Models\Action::find(54),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Crediter un compte    "],
            ["action" => \App\Models\Action::find(53),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Retirer un droit à un utilisateur    "],
            ["action" => \App\Models\Action::find(52),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Affecter un droit    "],
            ["action" => \App\Models\Action::find(51),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'une action    "],
            ["action" => \App\Models\Action::find(50),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un action    "],
            ["action" => \App\Models\Action::find(49),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un action    "],
            ["action" => \App\Models\Action::find(48),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un action    "],
            ["action" => \App\Models\Action::find(47),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les action    "],
            ["action" => \App\Models\Action::find(46),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un rang    "],
            ["action" => \App\Models\Action::find(45),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un rang    "],
            ["action" => \App\Models\Action::find(44),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un rang    "],
            ["action" => \App\Models\Action::find(43),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un rang    "],
            ["action" => \App\Models\Action::find(42),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rangs    "],
            ["action" => \App\Models\Action::find(41),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un profil    "],
            ["action" => \App\Models\Action::find(40),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un profil    "],
            ["action" => \App\Models\Action::find(39),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un profil    "],
            ["action" => \App\Models\Action::find(38),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un profil    "],
            ["action" => \App\Models\Action::find(37),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les profils    "],
            ["action" => \App\Models\Action::find(36),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un right    "],
            ["action" => \App\Models\Action::find(35),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un right    "],
            ["action" => \App\Models\Action::find(34),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un right    "],
            ["action" => \App\Models\Action::find(33),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un right    "],
            ["action" => \App\Models\Action::find(32),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rights    "],
            ["action" => \App\Models\Action::find(31),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un user    "],
            ["action" => \App\Models\Action::find(30),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un user    "],
            ["action" => \App\Models\Action::find(19),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un user    "],
            ["action" => \App\Models\Action::find(18),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les users    "],
            ["action" => \App\Models\Action::find(17),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'une campagne    "],
            ["action" => \App\Models\Action::find(16),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Initier une campagne    "],
            ["action" => \App\Models\Action::find(15),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Stoper une campagne    "],
            ["action" => \App\Models\Action::find(14),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer une campagne    "],
            ["action" => \App\Models\Action::find(13),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour une campagne    "],
            ["action" => \App\Models\Action::find(12),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une campagne    "],
            ["action" => \App\Models\Action::find(11),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les campagnes    "],
            ["action" => \App\Models\Action::find(10),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un sms    "],
            ["action" => \App\Models\Action::find(19),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un sms    "],
            ["action" => \App\Models\Action::find(18),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un sms    "],
            ["action" => \App\Models\Action::find(17),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un sms    "],
            ["action" => \App\Models\Action::find(16),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les sms    "],
            ["action" => \App\Models\Action::find(15),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un expeditor    "],
            ["action" => \App\Models\Action::find(14),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un expeditor    "],
            ["action" => \App\Models\Action::find(13),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un expeditor    "],
            ["action" => \App\Models\Action::find(12),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un expeditor    "],
            ["action" => \App\Models\Action::find(11),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les expeditors    "],
            ["action" => \App\Models\Action::find(10),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un groupe de contact    "],
            ["action" => \App\Models\Action::find(9),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un groupe de cintact    "],
            ["action" => \App\Models\Action::find(8),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un groupe de cintact    "],
            ["action" => \App\Models\Action::find(7),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un groupe de cintact    "],
            ["action" => \App\Models\Action::find(9),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les groupe de cintact    "],
            ["action" => \App\Models\Action::find(5),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un contact    "],
            ["action" => \App\Models\Action::find(4),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un contact    "],
            ["action" => \App\Models\Action::find(3),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un contact    "],
            ["action" => \App\Models\Action::find(1),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un contact    "],
            ["action" => \App\Models\Action::find(1),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les contacts "],

            ###____Droits d'un admin
            ["action" => \App\Models\Action::find(191),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Affecter un droit    "],
            ["action" => \App\Models\Action::find(190),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un action    "],
            ["action" => \App\Models\Action::find(189),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un action    "],
            ["action" => \App\Models\Action::find(188),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un action    "],
            ["action" => \App\Models\Action::find(187),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les action    "],
            ["action" => \App\Models\Action::find(186),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un rang    "],
            ["action" => \App\Models\Action::find(185),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un rang    "],
            ["action" => \App\Models\Action::find(184),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un rang    "],
            ["action" => \App\Models\Action::find(183),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rangs    "],
            ["action" => \App\Models\Action::find(182),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un profil    "],
            ["action" => \App\Models\Action::find(181),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un profil    "],
            ["action" => \App\Models\Action::find(180),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un profil    "],
            ["action" => \App\Models\Action::find(179),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les profils    "],
            ["action" => \App\Models\Action::find(178),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un right    "],
            ["action" => \App\Models\Action::find(177),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un right    "],
            ["action" => \App\Models\Action::find(176),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un right    "],
            ["action" => \App\Models\Action::find(175),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rights    "],
            ["action" => \App\Models\Action::find(174),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un user    "],
            ["action" => \App\Models\Action::find(173),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un user    "],
            ["action" => \App\Models\Action::find(172),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les users    "],
            ["action" => \App\Models\Action::find(171),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un store    "],
            ["action" => \App\Models\Action::find(170),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un store    "],
            ["action" => \App\Models\Action::find(169),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un store    "],
            ["action" => \App\Models\Action::find(168),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les stores    "],
            ["action" => \App\Models\Action::find(167),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un product_category    "],
            ["action" => \App\Models\Action::find(166),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un product_category    "],
            ["action" => \App\Models\Action::find(165),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un product_category    "],
            ["action" => \App\Models\Action::find(164),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les product_categories    "],
            ["action" => \App\Models\Action::find(163),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un order    "],
            ["action" => \App\Models\Action::find(162),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un order    "],
            ["action" => \App\Models\Action::find(161),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un order    "],
            ["action" => \App\Models\Action::find(160),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les orders    "],
            ["action" => \App\Models\Action::find(159),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un product    "],
            ["action" => \App\Models\Action::find(158),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un product    "],
            ["action" => \App\Models\Action::find(157),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un product    "],
            ["action" => \App\Models\Action::find(156),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les products    "],
            ["action" => \App\Models\Action::find(155),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer une table    "],
            ["action" => \App\Models\Action::find(154),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour une table    "],
            ["action" => \App\Models\Action::find(153),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une table    "],
            ["action" => \App\Models\Action::find(152),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les tables    "],
            ["action" => \App\Models\Action::find(151),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un pos    "],
            ["action" => \App\Models\Action::find(150),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un pos    "],
            ["action" => \App\Models\Action::find(149),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un pos    "],
            ["action" => \App\Models\Action::find(148),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les pos    "],
            ["action" => \App\Models\Action::find(147),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un agent    "],
            ["action" => \App\Models\Action::find(146),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un agent    "],
            ["action" => \App\Models\Action::find(145),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un agent    "],
            ["action" => \App\Models\Action::find(144),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les agents    "],
            ["action" => \App\Models\Action::find(143),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un agency    "],
            ["action" => \App\Models\Action::find(142),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un agency    "],
            ["action" => \App\Models\Action::find(141),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un agency    "],
            ["action" => \App\Models\Action::find(140),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les agencies    "],
            ["action" => \App\Models\Action::find(139),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un master    "],
            ["action" => \App\Models\Action::find(138),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un master    "],
            ["action" => \App\Models\Action::find(137),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un master    "],
            ["action" => \App\Models\Action::find(136),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les masters    "],
            ["action" => \App\Models\Action::find(135),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider des factures    "],
            ["action" => \App\Models\Action::find(134),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des factures    "],
            ["action" => \App\Models\Action::find(133),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Emettre des factures    "],
            ["action" => \App\Models\Action::find(132),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste rechargement carte    "],
            ["action" => \App\Models\Action::find(131),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Autoriser reversement de commission    "],
            ["action" => \App\Models\Action::find(130),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste assurance    "],
            ["action" => \App\Models\Action::find(129),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Approuver devis    "],
            ["action" => \App\Models\Action::find(128),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Dévis assurance    "],
            ["action" => \App\Models\Action::find(127),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister assurance    "],
            ["action" => \App\Models\Action::find(126),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter assurance    "],
            ["action" => \App\Models\Action::find(125),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir relevé de compte    "],
            ["action" => \App\Models\Action::find(124),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider des dépôts    "],
            ["action" => \App\Models\Action::find(123),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des dépôts    "],
            ["action" => \App\Models\Action::find(122),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des dépôts    "],
            ["action" => \App\Models\Action::find(121),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réinitialiser mot de passe    "],
            ["action" => \App\Models\Action::find(120),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir solde    "],
            ["action" => \App\Models\Action::find(119),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir commission    "],
            ["action" => \App\Models\Action::find(118),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Répondre recherches approfondies    "],
            ["action" => \App\Models\Action::find(117),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste recherches approfondies    "],
            ["action" => \App\Models\Action::find(116),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recherche approfondie    "],
            ["action" => \App\Models\Action::find(115),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider activation de carte    "],
            ["action" => \App\Models\Action::find(114),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Délivrer une carte    "],
            ["action" => \App\Models\Action::find(113),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Retirer droit à un utilisateur    "],
            ["action" => \App\Models\Action::find(112),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réactivation    "],
            ["action" => \App\Models\Action::find(111),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les réactivations    "],
            ["action" => \App\Models\Action::find(110),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des reabonnements    "],
            ["action" => \App\Models\Action::find(109),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter stock    "],
            ["action" => \App\Models\Action::find(108),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Faire des migrations    "],
            ["action" => \App\Models\Action::find(107),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des miigration    "],
            ["action" => \App\Models\Action::find(106),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer un matériel    "],
            ["action" => \App\Models\Action::find(105),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des recrutements    "],
            ["action" => \App\Models\Action::find(104),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recrutement canal    "],
            ["action" => \App\Models\Action::find(103),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Modification abonnement canal    "],
            ["action" => \App\Models\Action::find(102),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Finir une Opération    "],
            ["action" => \App\Models\Action::find(101),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter accessoires    "],
            ["action" => \App\Models\Action::find(100),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer parabole    "],
            ["action" => \App\Models\Action::find(99),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer accessoires    "],
            ["action" => \App\Models\Action::find(98),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Migration de décodeur    "],
            ["action" => \App\Models\Action::find(97),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Recrutement (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(96),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Réabonnement    "],
            ["action" => \App\Models\Action::find(95),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste décodeurs (recrutement)    "],
            ["action" => \App\Models\Action::find(94),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider les recrutements (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(93),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter décodeur    "],
            ["action" => \App\Models\Action::find(92),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider les recrutements (vente de décodeur)    "],
            ["action" => \App\Models\Action::find(91),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Faire la migration de décodeur    "],
            ["action" => \App\Models\Action::find(90),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Vendre décodeur    "],
            ["action" => \App\Models\Action::find(89),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer le stock de décodeur pour un partenaire    "],
            ["action" => \App\Models\Action::find(88),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter décodeur    "],
            ["action" => \App\Models\Action::find(87),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider réabonnement    "],
            ["action" => \App\Models\Action::find(86),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter renouvellement    "],
            ["action" => \App\Models\Action::find(85),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Statistiques    "],
            ["action" => \App\Models\Action::find(84),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer carte    "],
            ["action" => \App\Models\Action::find(83),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Débiter une agence    "],
            ["action" => \App\Models\Action::find(82),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une carte    "],
            ["action" => \App\Models\Action::find(81),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer mon compte    "],
            ["action" => \App\Models\Action::find(80),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des masters    "],
            ["action" => \App\Models\Action::find(79),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter des masters    "],
            ["action" => \App\Models\Action::find(78),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister des masters    "],
            ["action" => \App\Models\Action::find(77),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Valider rechargement de carte    "],
            ["action" => \App\Models\Action::find(76),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rechargements    "],
            ["action" => \App\Models\Action::find(75),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter agent commercial    "],
            ["action" => \App\Models\Action::find(74),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister des agents commerciaux    "],
            ["action" => \App\Models\Action::find(73),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une carte    "],
            ["action" => \App\Models\Action::find(72),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Créditer une agence    "],
            ["action" => \App\Models\Action::find(71),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une agence    "],
            ["action" => \App\Models\Action::find(70),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les cartes    "],
            ["action" => \App\Models\Action::find(99),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Voir la liste des points de vente    "],
            ["action" => \App\Models\Action::find(98),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter Point de Service, agence pour les distributeur    "],
            ["action" => \App\Models\Action::find(97),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter distributeur    "],
            ["action" => \App\Models\Action::find(96),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout de carte    "],
            ["action" => \App\Models\Action::find(95),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: recharge de compte    "],
            ["action" => \App\Models\Action::find(94),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Administration pour distributeur    "],
            ["action" => \App\Models\Action::find(93),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Activation de carte    "],
            ["action" => \App\Models\Action::find(92),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Administration    "],
            ["action" => \App\Models\Action::find(91),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout de droit    "],
            ["action" => \App\Models\Action::find(90),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer distributeur    "],
            ["action" => \App\Models\Action::find(59),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Envoyer de message aux distributeur    "],
            ["action" => \App\Models\Action::find(58),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Editer distribibuteur    "],
            ["action" => \App\Models\Action::find(57),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Liste des distributeurs    "],
            ["action" => \App\Models\Action::find(56),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Statistique globale de la plateforme : Nombre de distributeurs, cartes, agents commerciaux, etc.    "],
            ["action" => \App\Models\Action::find(55),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajout d'utilisateur    "],
            ["action" => \App\Models\Action::find(54),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Crediter un compte    "],
            ["action" => \App\Models\Action::find(53),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Retirer un droit à un utilisateur    "],
            ["action" => \App\Models\Action::find(52),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Affecter un droit    "],
            ["action" => \App\Models\Action::find(51),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'une action    "],
            ["action" => \App\Models\Action::find(50),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un action    "],
            ["action" => \App\Models\Action::find(49),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un action    "],
            ["action" => \App\Models\Action::find(48),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un action    "],
            ["action" => \App\Models\Action::find(47),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les action    "],
            ["action" => \App\Models\Action::find(46),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un rang    "],
            ["action" => \App\Models\Action::find(45),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un rang    "],
            ["action" => \App\Models\Action::find(44),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un rang    "],
            ["action" => \App\Models\Action::find(43),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un rang    "],
            ["action" => \App\Models\Action::find(42),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rangs    "],
            ["action" => \App\Models\Action::find(41),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un profil    "],
            ["action" => \App\Models\Action::find(40),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un profil    "],
            ["action" => \App\Models\Action::find(39),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un profil    "],
            ["action" => \App\Models\Action::find(38),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un profil    "],
            ["action" => \App\Models\Action::find(37),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les profils    "],
            ["action" => \App\Models\Action::find(36),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un right    "],
            ["action" => \App\Models\Action::find(35),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un right    "],
            ["action" => \App\Models\Action::find(34),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un right    "],
            ["action" => \App\Models\Action::find(33),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un right    "],
            ["action" => \App\Models\Action::find(32),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les rights    "],
            ["action" => \App\Models\Action::find(31),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un user    "],
            ["action" => \App\Models\Action::find(30),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un user    "],
            ["action" => \App\Models\Action::find(19),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un user    "],
            ["action" => \App\Models\Action::find(18),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les users    "],
            ["action" => \App\Models\Action::find(17),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'une campagne    "],
            ["action" => \App\Models\Action::find(16),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Initier une campagne    "],
            ["action" => \App\Models\Action::find(15),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Stoper une campagne    "],
            ["action" => \App\Models\Action::find(14),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer une campagne    "],
            ["action" => \App\Models\Action::find(13),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour une campagne    "],
            ["action" => \App\Models\Action::find(12),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter une campagne    "],
            ["action" => \App\Models\Action::find(11),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les campagnes    "],
            ["action" => \App\Models\Action::find(10),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un sms    "],
            ["action" => \App\Models\Action::find(19),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un sms    "],
            ["action" => \App\Models\Action::find(18),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un sms    "],
            ["action" => \App\Models\Action::find(17),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un sms    "],
            ["action" => \App\Models\Action::find(16),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les sms    "],
            ["action" => \App\Models\Action::find(15),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un expeditor    "],
            ["action" => \App\Models\Action::find(14),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un expeditor    "],
            ["action" => \App\Models\Action::find(13),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un expeditor    "],
            ["action" => \App\Models\Action::find(12),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un expeditor    "],
            ["action" => \App\Models\Action::find(11),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les expeditors    "],
            ["action" => \App\Models\Action::find(10),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un groupe de contact    "],
            ["action" => \App\Models\Action::find(9),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un groupe de cintact    "],
            ["action" => \App\Models\Action::find(8),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un groupe de cintact    "],
            ["action" => \App\Models\Action::find(7),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un groupe de cintact    "],
            ["action" => \App\Models\Action::find(9),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les groupe de cintact    "],
            ["action" => \App\Models\Action::find(5),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Détail d'un contact    "],
            ["action" => \App\Models\Action::find(4),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Supprimer un contact    "],
            ["action" => \App\Models\Action::find(3),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Mettre à jour un contact    "],
            ["action" => \App\Models\Action::find(1),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Ajouter un contact    "],
            ["action" => \App\Models\Action::find(1),         "rang" => \App\Models\Rang::find(1),         "profil" => \App\Models\Profil::find(9),         "description" => "Droit: Lister les contacts "]
        ];

        foreach ($rights as $right) {
            \App\Models\Right::factory()->create($right);
        }

        #======== CREATION DES TYPES DE PRODUIT PAR DEFAUT =========#
        $produitTypes = [
            [
                "name" => "Stockable",
                "description" => "Produit stockable",
            ],
            [
                "name" => "Non Stockable",
                "description" => "Produit non stockable",
            ],
        ];
        foreach ($produitTypes as $type) {
            \App\Models\ProductType::factory()->create($type);
        }

        #======== CREATION DES STATUS DE CARD PAR DEFAUT =========#
        $statusCards = [
            [
                "name" => "on_old",
                "label" => "Attente",
                "description" => "Cette carte est en attente",
            ],
            [
                "name" => "rejected",
                "label" => "Activation rejetée",
                "description" => "Cette carte est est rejetée",
            ],
            [
                "name" => "unactivated",
                "label" => "Non activée",
                "description" => "Cette carte n'est pas encore activée",
            ],
            [
                "name" => "partial_activated",
                "label" => "Activée partiellement",
                "description" => "Cette carte est activée partiellement",
            ],
            [
                "name" => "activated",
                "label" => "Activée",
                "description" => "Cette Carte est activée",
            ],
        ];
        foreach ($statusCards as $statusCard) {
            \App\Models\CardStatus::factory()->create($statusCard);
        }

        #======== CREATION DES STATUS DE RECHARGEMENT PAR DEFAUT =========#
        $statusRechargeCards = [
            [
                "name" => "on_old",
                "label" => "Attente",
                "description" => "Ce rechargement est en attente",
            ],
            [
                "name" => "rejected",
                "label" => "Rejetée",
                "description" => "Ce rechargement a été rejeté",
            ],
            [
                "name" => "unactivated",
                "label" => "Non activé",
                "description" => "Ce rechargement n'est pas encore activé",
            ],
            [
                "name" => "initiated",
                "label" => "Initié",
                "description" => "Ce rechargement a été initié",
            ],
            [
                "name" => "validated",
                "label" => "Validé",
                "description" => "Ce rechargement a été validé",
            ],
        ];
        foreach ($statusRechargeCards as $statusRechargeCard) {
            \App\Models\CardRechargeStatus::factory()->create($statusRechargeCard);
        }

        #======== CREATION DES TYPES DE CARTES PAR DEFAUT =========#
        $cardTypes = [
            [
                "name" => "Low",
                "description" => "La carte Low est plafonné à 200.000 pour la recharge",
            ],
            [
                "name" => "Mid",
                "description" => "La carte Low est plafonné à 1.000.000 pour la recharge",
            ],
            [
                "name" => "High",
                "description" => "La carte Low est plafonné à 2.000.000 pour la recharge",
            ],
        ];
        foreach ($cardTypes as $type) {
            \App\Models\CardType::factory()->create($type);
        }

        #======== CREATION DES TYPES DE MODULE PAR DEFAUT =========#
        $modules = [
            [
                "name" => "Card",
                "description" => "Carte prépayée",
            ],
            [
                "name" => "Canal",
                "description" => "CanalPlus",
            ],
            [
                "name" => "MoMo",
                "description" => "Mobile Money",
            ],
            [
                "name" => "Code",
                "description" => "Code internet",
            ],
            [
                "name" => "Western",
                "description" => "Western Union transfer",
            ],
            [
                "name" => "MoneyGram",
                "description" => "MoneyGram transfer",
            ],
            [
                "name" => "Assurance",
                "description" => "Insurance",
            ],
            [
                "name" => "Ecobank",
                "description" => "Ecobank Mobile",
            ],
            [
                "name" => "Crypto",
                "description" => "Crypto Transfert",
            ],
            [
                "name" => "Ticket",
                "description" => "Ticket bus",
            ],
            [
                "name" => "Dashbord",
                "description" => "Tableau de bord",
            ],
            [
                "name" => "Facture",
                "description" => "SBEE et SONEB",
            ],
            [
                "name" => "Store",
                "description" => "Superrette",
            ],
        ];
        foreach ($modules as $module) {
            \App\Models\Module::factory()->create($module);
        }

        #======== CREATION DES TYPES DE MODULE PAR DEFAUT =========#
        $formules = [
            [
                "name" => "ACCESS",
                "description" => "FORMULE ACCESS",
                "amount" => "5000.00000",
            ],
            [
                "name" => "EVASION",
                "description" => "FORMULE EVASION",
                "amount" => "10000.00000",
            ],
            [
                "name" => "ESSENTIEL+",
                "description" => "FORMULE ESSENTIEL PLUS",
                "amount" => "12000.00000",
            ],
            [
                "name" => "ACCESS +",
                "description" => "FORMULE ACCESS PLUS",
                "amount" => "15000.00000",
            ],
            [
                "name" => "ACCESS +",
                "description" => "FORMULE ACCESS PLUS",
                "amount" => "15000.00000",
            ],
            [
                "name" => "EVASION +",
                "description" => "FORMULE EVASION PLUS",
                "amount" => "20000.00000",
            ],
            [
                "name" => "TOUT CANAL",
                "description" => "TOUS LE BOUQUET CANAL",
                "amount" => "40000.00000",
            ],

        ];
        foreach ($formules as $formule) {
            \App\Models\CanalFormula::factory()->create($formule);
        }

        #======== CREATION DES OPTIONS DE SOUSCRIPTION PAR DEFAUT =========#
        $subscriptions_options = [
            [
                "name" => "Charme",
                "description" => "OPTION CHARME",
                "amount" => "6000.00000",
            ],
            [
                "name" => "2EME ECRAN",
                "description" => "OPTION 2EME ECRAN",
                "amount" => "6000.00000",
            ]
        ];
        foreach ($subscriptions_options as $option) {
            \App\Models\CanalSubscriptionOption::factory()->create($option);
        }

        #======== CREATION DES STATUS DE SOUSCRIPTION PAR DEFAUT =========#
        $subscriptions_status = [
            [
                "name" => "PENDING",
                "description" => "PENDING - ATTENTE",
            ],
            [
                "name" => "CANCEL",
                "description" => "CANCEL - ANNULE",
            ],
            [
                "name" => "SUCCESS",
                "description" => "SUCCESS - SUCCES",
            ],
            [
                "name" => "ENROLL",
                "description" => "RECRUTEMENT - EN COURS DE TRAITEMENT",
            ]
        ];
        foreach ($subscriptions_status as $status) {
            \App\Models\CanalSubscriptionStatus::factory()->create($status);
        }
    }
}
