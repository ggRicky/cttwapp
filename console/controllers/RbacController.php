<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 23/05/18
 * Time: 09:28 AM
 *
 * 2018-05-23 : This controller initialize authorization data for Rbac Manager
 *
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

        // Access to the Rbac Manager
        // --------------------------
        $auth = Yii::$app->authManager;

        // Removes all authorization data, including roles, permissions, rules, and assignments.
        // -------------------------------------------------------------------------------------
        $auth->removeAll();


        // Defines all the permissions for CTTwapp system
        // -----------------------------------------------


        // Defines the permissions to adminSite
        // ------------------------------------

        // Adds "adminSite" permission
        $adminSite = $auth->createPermission('adminSite');
        $adminSite->description = 'Permission : Allows to admin site actions in the CTTwapp system.';
        $auth->add($adminSite);


        // Defines the permissions to access the special admin process
        // -----------------------------------------------------------

        // Adds "adminProcess" permission
        $adminProcess = $auth->createPermission('adminProcess');
        $adminProcess->description = 'Permission : Allows access to the admin process in the CTTwapp system.';
        $auth->add($adminProcess);


        // Defines the permissions to access the Main index
        // ------------------------------------------------

        // Adds "accessMain" permission
        $accessMain = $auth->createPermission('accessMain');
        $accessMain->description = 'Permission : Allows to access the CTTwapp system site main index.';
        $auth->add($accessMain);


        // Defines the permissions to uploads files
        // ----------------------------------------

        // Adds "uploadFile" permission
        $uploadFile = $auth->createPermission('uploadFile');
        $uploadFile->description = 'Permission : Allows access to load files in to CTTwapp server.';
        $auth->add($uploadFile);


        // Defines the permissions to access the Help module
        // -------------------------------------------------

        // Adds "viewHelp" permission
        $viewHelp = $auth->createPermission('viewHelp');
        $viewHelp->description = 'Permission : Allows to view the help in the CTTwapp system.';
        $auth->add($viewHelp);



        // Defines the permissions on the Client Types module
        // --------------------------------------------------

        // Adds "createClientType" permission
        $createClientType = $auth->createPermission('createClientType');
        $createClientType->description = 'Permission : Allows to create a client type in the CTTwapp system.';
        $auth->add($createClientType);

        // Adds "updateClientType" permission
        $updateClientType = $auth->createPermission('updateClientType');
        $updateClientType->description = 'Permission : Allows to update a client type in the CTTwapp system.';
        $auth->add($updateClientType);

        // Adds "viewClientType" permission
        $viewClientType = $auth->createPermission('viewClientType');
        $viewClientType->description = 'Permission : Allows to view a client type in the CTTwapp system.';
        $auth->add($viewClientType);

        // Adds "deleteClientType" permission
        $deleteClientType = $auth->createPermission('deleteClientType');
        $deleteClientType->description = 'Permission : Allows to delete a client type in the CTTwapp system.';
        $auth->add($deleteClientType);

        // Adds "listClientType" permission
        $listClientType = $auth->createPermission('listClientType');
        $listClientType->description = 'Permission : Allows to list the client types in the CTTwapp system.';
        $auth->add($listClientType);



        // Defines the permissions on the Clients module
        // ---------------------------------------------

        // Adds "createClient" permission
        $createClient = $auth->createPermission('createClient');
        $createClient->description = 'Permission : Allows to create a client in the CTTwapp system.';
        $auth->add($createClient);

        // Adds "updateClient" permission
        $updateClient = $auth->createPermission('updateClient');
        $updateClient->description = 'Permission : Allows to update a client in the CTTwapp system.';
        $auth->add($updateClient);

        // Adds "viewClient" permission
        $viewClient = $auth->createPermission('viewClient');
        $viewClient->description = 'Permission : Allows to view a client in the CTTwapp system.';
        $auth->add($viewClient);

        // Adds "deleteClient" permission
        $deleteClient = $auth->createPermission('deleteClient');
        $deleteClient->description = 'Permission : Allows to delete a client in the CTTwapp system.';
        $auth->add($deleteClient);

        // Adds "listClient" permission
        $listClient = $auth->createPermission('listClient');
        $listClient->description = 'Permission : Allows to list the clients in the CTTwapp system.';
        $auth->add($listClient);



        // Defines the permissions on the Catalogs module
        // ----------------------------------------------

        // Adds "createCatalog" permission
        $createCatalog = $auth->createPermission('createCatalog');
        $createCatalog->description = 'Permission : Allows to create a Catalog in the CTTwapp system.';
        $auth->add($createCatalog);

        // Adds "updateCatalog" permission
        $updateCatalog = $auth->createPermission('updateCatalog');
        $updateCatalog->description = 'Permission : Allows to update a Catalog in the CTTwapp system.';
        $auth->add($updateCatalog);

        // Adds "viewCatalog" permission
        $viewCatalog = $auth->createPermission('viewCatalog');
        $viewCatalog->description = 'Permission : Allows to view a Catalog in the CTTwapp system.';
        $auth->add($viewCatalog);

        // Adds "deleteCatalog" permission
        $deleteCatalog = $auth->createPermission('deleteCatalog');
        $deleteCatalog->description = 'Permission : Allows to delete a Catalog in the CTTwapp system.';
        $auth->add($deleteCatalog);

        // Adds "listCatalog" permission
        $listCatalog = $auth->createPermission('listCatalog');
        $listCatalog->description = 'Permission : Allows to list the Catalogs in the CTTwapp system.';
        $auth->add($listCatalog);



        // Defines the permissions on the Brands module
        // --------------------------------------------

        // Adds "createBrand" permission
        $createBrand = $auth->createPermission('createBrand');
        $createBrand->description = 'Permission : Allows to create a Brand in the CTTwapp system.';
        $auth->add($createBrand);

        // Adds "updateBrand" permission
        $updateBrand = $auth->createPermission('updateBrand');
        $updateBrand->description = 'Permission : Allows to update a Brand in the CTTwapp system.';
        $auth->add($updateBrand);

        // Adds "viewBrand" permission
        $viewBrand = $auth->createPermission('viewBrand');
        $viewBrand->description = 'Permission : Allows to view a Brand in the CTTwapp system.';
        $auth->add($viewBrand);

        // Adds "deleteBrand" permission
        $deleteBrand = $auth->createPermission('deleteBrand');
        $deleteBrand->description = 'Permission : Allows to delete a Brand in the CTTwapp system.';
        $auth->add($deleteBrand);

        // Adds "listBrand" permission
        $listBrand = $auth->createPermission('listBrand');
        $listBrand->description = 'Permission : Allows to list the Brands in the CTTwapp system.';
        $auth->add($listBrand);



        // Defines the permissions on the Articles module
        // ----------------------------------------------

        // Adds "createArticle" permission
        $createArticle = $auth->createPermission('createArticle');
        $createArticle->description = 'Permission : Allows to create an Article in the CTTwapp system.';
        $auth->add($createArticle);

        // Adds "updateArticle" permission
        $updateArticle = $auth->createPermission('updateArticle');
        $updateArticle->description = 'Permission : Allows to update an Article in the CTTwapp system.';
        $auth->add($updateArticle);

        // Adds "viewArticle" permission
        $viewArticle = $auth->createPermission('viewArticle');
        $viewArticle->description = 'Permission : Allows to view an Article in the CTTwapp system.';
        $auth->add($viewArticle);

        // Adds "deleteArticle" permission
        $deleteArticle = $auth->createPermission('deleteArticle');
        $deleteArticle->description = 'Permission : Allows to delete an Article in the CTTwapp system.';
        $auth->add($deleteArticle);

        // Adds "listArticle" permission
        $listArticle = $auth->createPermission('listArticle');
        $listArticle->description = 'Permission : Allows to list the Articles in the CTTwapp system.';
        $auth->add($listArticle);

        // Adds "printArticle" permission
        $printArticle = $auth->createPermission('printArticle');
        $printArticle->description = 'Permission : Allows to print an Article info in the CTTwapp system.';
        $auth->add($printArticle);


        // Defines the permissions on the Inventory module
        // -----------------------------------------------

        // Adds "createInventory" permission
        $createInventory = $auth->createPermission('createInventory');
        $createInventory->description = 'Permission : Allows to create the Inventory entries in the CTTwapp system.';
        $auth->add($createInventory);

        // Adds "updateInventory" permission
        $updateInventory = $auth->createPermission('updateInventory');
        $updateInventory->description = 'Permission : Allows to update the Inventory entries in the CTTwapp system.';
        $auth->add($updateInventory);

        // Adds "viewInventory" permission
        $viewInventory = $auth->createPermission('viewInventory');
        $viewInventory->description = 'Permission : Allows to view the Inventory entries in the CTTwapp system.';
        $auth->add($viewInventory);

        // Adds "deleteInventory" permission
        $deleteInventory = $auth->createPermission('deleteInventory');
        $deleteInventory->description = 'Permission : Allows to delete the Inventory entries in the CTTwapp system.';
        $auth->add($deleteInventory);

        // Adds "listInventory" permission
        $listInventory = $auth->createPermission('listInventory');
        $listInventory->description = 'Permission : Allows to list the Inventory entries in the CTTwapp system.';
        $auth->add($listInventory);



        // Defines the permissions on the Project module
        // ---------------------------------------------

        // Adds "createProject" permission
        $createProject = $auth->createPermission('createProject');
        $createProject->description = 'Permission : Allows to create the Project records in the CTTwapp system.';
        $auth->add($createProject);

        // Adds "updateProject" permission
        $updateProject = $auth->createPermission('updateProject');
        $updateProject->description = 'Permission : Allows to update the Project records in the CTTwapp system.';
        $auth->add($updateProject);

        // Adds "viewProject" permission
        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'Permission : Allows to view the Project records in the CTTwapp system.';
        $auth->add($viewProject);

        // Adds "deleteProject" permission
        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'Permission : Allows to delete the Project records in the CTTwapp system.';
        $auth->add($deleteProject);

        // Adds "listProject" permission
        $listProject = $auth->createPermission('listProject');
        $listProject->description = 'Permission : Allows to list the Project records in the CTTwapp system.';
        $auth->add($listProject);



        // Defines the permissions on the Reservations module
        // --------------------------------------------------

        // Adds "createReservations" permission
        $createReservation = $auth->createPermission('createReservation');
        $createReservation->description = 'Permission : Allows to create the Reservation records in the CTTwapp system.';
        $auth->add($createReservation);

        // Adds "updateReservation" permission
        $updateReservation = $auth->createPermission('updateReservation');
        $updateReservation->description = 'Permission : Allows to update the Reservation records in the CTTwapp system.';
        $auth->add($updateReservation);

        // Adds "viewReservation" permission
        $viewReservation = $auth->createPermission('viewReservation');
        $viewReservation->description = 'Permission : Allows to view the Reservation records in the CTTwapp system.';
        $auth->add($viewReservation);

        // Adds "deleteReservation" permission
        $deleteReservation = $auth->createPermission('deleteReservation');
        $deleteReservation->description = 'Permission : Allows to delete the Reservation records in the CTTwapp system.';
        $auth->add($deleteReservation);

        // Adds "listReservation" permission
        $listReservation = $auth->createPermission('listReservation');
        $listReservation->description = 'Permission : Allows to list the Reservation records in the CTTwapp system.';
        $auth->add($listReservation);



        // Defines the permissions on the MarketRate module
        // -----------------------------------------------

        // Adds "createMarketRate" permission
        $createMarketRate = $auth->createPermission('createMarketRate');
        $createMarketRate->description = 'Permission : Allows to create the MarketRate records in the CTTwapp system.';
        $auth->add($createMarketRate);

        // Adds "updateMarketRate" permission
        $updateMarketRate = $auth->createPermission('updateMarketRate');
        $updateMarketRate->description = 'Permission : Allows to update the MarketRate records in the CTTwapp system.';
        $auth->add($updateMarketRate);

        // Adds "viewMarketRate" permission
        $viewMarketRate = $auth->createPermission('viewMarketRate');
        $viewMarketRate->description = 'Permission : Allows to view the MarketRate records in the CTTwapp system.';
        $auth->add($viewMarketRate);

        // Adds "deleteMarketRate" permission
        $deleteMarketRate = $auth->createPermission('deleteMarketRate');
        $deleteMarketRate->description = 'Permission : Allows to delete the MarketRate records in the CTTwapp system.';
        $auth->add($deleteMarketRate);

        // Adds "listMarketRate" permission
        $listMarketRate = $auth->createPermission('listMarketRate');
        $listMarketRate->description = 'Permission : Allows to list the MarketRate records in the CTTwapp system.';
        $auth->add($listMarketRate);



        // Defines all the roles for CTTwapp system
        // ----------------------------------------



        // Role : userClientType
        // ---------------------

        // Adds the role 'userClientType' for a user of the Client Type module.
        $userClientType = $auth->createRole('userClientType');
        $userClientType->description = 'Role : Defines a user with the only permission to list types of clients.';
        $auth->add($userClientType);

        // Adds permissions
        $auth->addChild($userClientType, $listClientType);           // Add this permission to role userClientType, to allows the access to the list client type.



        // Role : adminClientType
        // ----------------------

        // Adds the role 'adminClientType' for an admin of the Client Type module.
        $adminClientType = $auth->createRole('adminClientType');
        $adminClientType->description = 'Role : Defines an admin user with all permissions to process types of clients.';
        $auth->add($adminClientType);

        // Adds roles and permissions
        $auth->addChild($adminClientType, $userClientType);          // Add the role userTypeClient to the role adminClientType.
        $auth->addChild($adminClientType, $createClientType);        // Add these permissions to role adminTypeClient, to allows create, update, view, and delete client types.
        $auth->addChild($adminClientType, $updateClientType);
        $auth->addChild($adminClientType, $viewClientType);
        $auth->addChild($adminClientType, $deleteClientType);



        // Role : userClient
        // -----------------

        // Adds the role 'userClient' for a user of the Client module.
        $userClient = $auth->createRole('userClient');
        $userClient->description = 'Role : Defines a user with the only permission to list clients.';
        $auth->add($userClient);

        // Adds permissions
        $auth->addChild($userClient, $listClient);                   // Adds this permission to role userClient, to allows the access to the list clients.



        // Role : adminClient
        // ------------------

        // Adds the role 'adminClient' for an admin of the Client module.
        $adminClient = $auth->createRole('adminClient');
        $adminClient->description = 'Role : Defines an admin user with all permissions to process clients.';
        $auth->add($adminClient);

        // Adds roles and permissions
        $auth->addChild($adminClient, $userClient);                  // Adds the role userClient to the role adminClient.
        $auth->addChild($adminClient, $createClient);                // Adds these permissions to role adminClient, to allows create, update, view, and delete clients.
        $auth->addChild($adminClient, $updateClient);
        $auth->addChild($adminClient, $viewClient);
        $auth->addChild($adminClient, $deleteClient);



        // Role : userBrand
        // -----------------

        // Adds the role 'userBrand' for a user of the Brand module.
        $userBrand = $auth->createRole('userBrand');
        $userBrand->description = 'Role : Defines a user with the only permission to list brands.';
        $auth->add($userBrand);

        // Adds permissions
        $auth->addChild($userBrand, $listBrand);                     // Adds this permission to role userBrand, to allows the access to the list brands.



        // Role : adminBrand
        // -----------------

        // Adds the role 'adminBrand' for an admin of the Brand module.
        $adminBrand = $auth->createRole('adminBrand');
        $adminBrand->description = 'Role : Defines an admin user with all permissions to process brands.';
        $auth->add($adminBrand);

        // Adds roles and permissions
        $auth->addChild($adminBrand, $userBrand);                    // Adds the role userBrand to role adminBrand.
        $auth->addChild($adminBrand, $createBrand);                  // Adds these permissions to role adminBrand, to allows create, update, view, and delete brands.
        $auth->addChild($adminBrand, $updateBrand);
        $auth->addChild($adminBrand, $viewBrand);
        $auth->addChild($adminBrand, $deleteBrand);



        // Role : userCatalog
        // -----------------

        // Adds the role 'userCatalog' for a user of the Catalog module.
        $userCatalog = $auth->createRole('userCatalog');
        $userCatalog->description = 'Role : Defines a user with the only permission to list catalogs.';
        $auth->add($userCatalog);

        // Adds permissions
        $auth->addChild($userCatalog, $listCatalog);                 // Adds this permission to role userCatalog, to allows the access to the list catalogs.



        // Role : adminCatalog
        // -------------------

        // Adds the role 'adminCatalog' for an admin of the Catalog module.
        $adminCatalog = $auth->createRole('adminCatalog');
        $adminCatalog->description = 'Role : Defines an admin user with all permissions to process catalogs.';
        $auth->add($adminCatalog);

        // Adds roles and permissions
        $auth->addChild($adminCatalog, $userCatalog);                // Adds the role userCatalog to role adminCatalog.
        $auth->addChild($adminCatalog, $createCatalog);              // Adds these permissions to role adminCatalog, to allows create, update, view, and delete catalogs.
        $auth->addChild($adminCatalog, $updateCatalog);
        $auth->addChild($adminCatalog, $viewCatalog);
        $auth->addChild($adminCatalog, $deleteCatalog);



        // Role : userArticle
        // ------------------

        // Creates the role 'userArticle' for a user of the Article module.
        $userArticle = $auth->createRole('userArticle');
        $userArticle->description = 'Role : Defines a user with the only permission to list articles.';
        $auth->add($userArticle);

        // Adds permissions
        $auth->addChild($userArticle, $listArticle);                 // Adds this permission to role userArticle, to allows the access to the list catalogs.



        // Role : adminArticle
        // -------------------

        // Creates the role 'adminArticle' for an admin of the Article module.
        $adminArticle = $auth->createRole('adminArticle');
        $adminArticle->description = 'Role : Defines an admin user with all permissions to process articles.';
        $auth->add($adminArticle);

        // Adds roles and permissions
        $auth->addChild($adminArticle, $userArticle);                // Adds the role userArticle to role adminArticle.
        $auth->addChild($adminArticle, $createArticle);              // Adds these permissions to role adminArticle, to allows create, update, view, and delete articles.
        $auth->addChild($adminArticle, $updateArticle);
        $auth->addChild($adminArticle, $viewArticle);
        $auth->addChild($adminArticle, $deleteArticle);
        $auth->addChild($adminArticle, $printArticle);



        // Role : userInventory
        // --------------------

        // Adds the role 'userInventory' for a user of the Inventory module.
        $userInventory = $auth->createRole('userInventory');
        $userInventory->description = 'Role : Defines a user with the only permission to list inventories.';
        $auth->add($userInventory);

        // Adds permissions
        $auth->addChild($userInventory, $listInventory);                   // Adds this permission to role userInventory, to allows the access to the list Inventories.



        // Role : adminInventory
        // ---------------------

        // Adds the role 'adminInventory' for an admin of the Inventory module.
        $adminInventory = $auth->createRole('adminInventory');
        $adminInventory->description = 'Role : Defines an admin user with all permissions to process Inventories.';
        $auth->add($adminInventory);

        // Adds roles and permissions
        $auth->addChild($adminInventory, $userInventory);                  // Adds the role userInventory to the role adminInventory.
        $auth->addChild($adminInventory, $createInventory);                // Adds these permissions to role adminInventory, to allows create, update, view, and delete Inventories.
        $auth->addChild($adminInventory, $updateInventory);
        $auth->addChild($adminInventory, $viewInventory);
        $auth->addChild($adminInventory, $deleteInventory);



        // Role : userProject
        // ------------------

        // Adds the role 'userProject' for a user of the Project module.
        $userProject = $auth->createRole('userProject');
        $userProject->description = 'Role : Defines a user with the only permission to list Projects.';
        $auth->add($userProject);

        // Adds permissions
        $auth->addChild($userProject, $listProject);                   // Adds this permission to role userProject, to allows the access to the list Projects.



        // Role : adminProject
        // -------------------

        // Adds the role 'adminProject' for an admin of the Project module.
        $adminProject = $auth->createRole('adminProject');
        $adminProject->description = 'Role : Defines an admin user with all permissions to process Projects.';
        $auth->add($adminProject);

        // Adds roles and permissions
        $auth->addChild($adminProject, $userProject);                  // Adds the role userProject to the role adminProject.
        $auth->addChild($adminProject, $createProject);                // Adds these permissions to role adminProject, to allows create, update, view, and delete Projects.
        $auth->addChild($adminProject, $updateProject);
        $auth->addChild($adminProject, $viewProject);
        $auth->addChild($adminProject, $deleteProject);



        // Role : userReservation
        // -----------------------

        // Adds the role 'userReservation' for a user of the Reservation module.
        $userReservation = $auth->createRole('userReservation');
        $userReservation->description = 'Role : Defines a user with the only permission to list Reservation.';
        $auth->add($userReservation);

        // Adds permissions
        $auth->addChild($userReservation, $listReservation);                   // Adds this permission to role userReservation, to allows the access to the list Reservation.



        // Role : adminReservation
        // -------------------

        // Adds the role 'adminReservation' for an admin of the Reservation module.
        $adminReservation = $auth->createRole('adminReservation');
        $adminReservation->description = 'Role : Defines an admin user with all permissions to process Reservation.';
        $auth->add($adminReservation);

        // Adds roles and permissions
        $auth->addChild($adminReservation, $userReservation);                  // Adds the role userReservation to the role adminReservation.
        $auth->addChild($adminReservation, $createReservation);                // Adds these permissions to role adminReservation, to allows create, update, view, and delete Reservation.
        $auth->addChild($adminReservation, $updateReservation);
        $auth->addChild($adminReservation, $viewReservation);
        $auth->addChild($adminReservation, $deleteReservation);



        // Role : userMarketRate
        // ---------------------

        // Adds the role 'userMarketRate' for a user of the MarketRate module.
        $userMarketRate = $auth->createRole('userMarketRate');
        $userMarketRate->description = 'Role : Defines a user with the only permission to list MarketRates.';
        $auth->add($userMarketRate);

        // Adds permissions
        $auth->addChild($userMarketRate, $listMarketRate);                   // Adds this permission to role userMarketRate, to allows the access to the list MarketRates.



        // Role : adminMarketRate
        // ----------------------

        // Adds the role 'adminMarketRate' for an admin of the MarketRate module.
        $adminMarketRate = $auth->createRole('adminMarketRate');
        $adminMarketRate->description = 'Role : Defines an admin user with all permissions to process MarketRates.';
        $auth->add($adminMarketRate);

        // Adds roles and permissions
        $auth->addChild($adminMarketRate, $userMarketRate);                  // Adds the role userMarketRate to the role adminMarketRate.
        $auth->addChild($adminMarketRate, $createMarketRate);                // Adds these permissions to role adminMarketRate, to allows create, update, view, and delete MarketRates.
        $auth->addChild($adminMarketRate, $updateMarketRate);
        $auth->addChild($adminMarketRate, $viewMarketRate);
        $auth->addChild($adminMarketRate, $deleteMarketRate);



        // Role : guestCTT
        // ----------------

        // Creates the role 'guestCTT' and give only the permissions to access the site main index.
        $guestCTT = $auth->createRole('guestCTT');
        $guestCTT->description = 'Role : Defines a guest user with only permission to access the main index.';
        $auth->add($guestCTT);

        // Adds basic permission
        $auth->addChild($guestCTT, $accessMain);          // Grant access only to the site main index.



        // Role : userCTT
        // --------------

        // Creates the role 'userCTT' and give only the permissions to list the available entities.
        $userCTT = $auth->createRole('userCTT');
        $userCTT->description = 'Role : Defines a default CTT user with only permissions to list the available entities.';
        $auth->add($userCTT);

        // Adds basic roles to list entities
        $auth->addChild($userCTT, $accessMain);            // Grant access only to the site main index.
        $auth->addChild($userCTT, $adminSite);             // Grant access to admin site process.
        //$auth->addChild($userCTT, $viewHelp);              // Grant access to view the CTTwapp help.
        $auth->addChild($userCTT, $userClient);            // Grant access to list client entities.
        $auth->addChild($userCTT, $userClientType);        // Grant access to list client type entities.
        $auth->addChild($userCTT, $userBrand);             // Grant access to list brand entities.
        $auth->addChild($userCTT, $userCatalog);           // Grant access to list catalog entities.
        $auth->addChild($userCTT, $userArticle);           // Grant access to list article entities.
        $auth->addChild($userCTT, $userInventory);         // Grant access to list inventory entities.
        $auth->addChild($userCTT, $userProject);           // Grant access to list project entities.
        $auth->addChild($userCTT, $userReservation);       // Grant access to list reservation entities.
        $auth->addChild($userCTT, $userMarketRate);        // Grant access to list market rate entities.



        // Role : inventoryCTT
        // -------------------

        // Creates the role 'inventoryCTT' and grants to it all the available permissions for the Articles, Catalogs and Brands entities.
        $inventoryCTT = $auth->createRole('inventoryCTT');
        $inventoryCTT->description = 'Role : Defines a default CTT inventory user and grants all the available permissions.';
        $auth->add($inventoryCTT);

        // Adds all roles to list entities
        $auth->addChild($inventoryCTT, $accessMain);           // Grant access only to the site main index.
        $auth->addChild($inventoryCTT, $adminSite);            // Grant access to admin site process.
        $auth->addChild($inventoryCTT, $uploadFile);           // Grant access to uploads files.
        $auth->addChild($inventoryCTT, $viewHelp);             // Grant access to view the CTTwapp help.
        $auth->addChild($inventoryCTT, $adminBrand);           // Grant access to admin all brand process.
        $auth->addChild($inventoryCTT, $adminCatalog);         // Grant access to admin all catalog process.
        $auth->addChild($inventoryCTT, $adminArticle);         // Grant access to admin all article process.



        // Role : marketingCTT
        // -------------------

        // Creates the role 'marketingCTT' and grants to it all the available permissions for the Clients and Articles entities.
        $marketingCTT = $auth->createRole('marketingCTT');
        $marketingCTT->description = 'Role : Defines a default CTT marketing user and grants all the available permissions.';
        $auth->add($marketingCTT);

        // Adds all roles to list entities
        $auth->addChild($marketingCTT, $accessMain);           // Grant access only to the site main index.
        $auth->addChild($marketingCTT, $adminSite);            // Grant access to admin site process.
        $auth->addChild($marketingCTT, $viewHelp);             // Grant access to view the CTTwapp help.
        $auth->addChild($marketingCTT, $adminClient);          // Grant access to admin all client process.
        $auth->addChild($marketingCTT, $adminClientType);      // Grant access to admin all client type process.
        $auth->addChild($marketingCTT, $adminBrand);           // Grant access to admin all brand process.
        $auth->addChild($marketingCTT, $adminCatalog);         // Grant access to admin all catalog process.
        $auth->addChild($marketingCTT, $adminArticle);         // Grant access to admin all article process.



        // Role : superCTT
        // ---------------

        // Creates the role 'superCTT' and grants to it all the available permissions in the CTTwapp application.
        $superCTT = $auth->createRole('superCTT');
        $superCTT->description = 'Role : Defines a default CTT super user and grants all the available permissions.';
        $auth->add($superCTT);

        // Adds all roles to list entities
        $auth->addChild($superCTT, $accessMain);           // Grant access only to the site main index.
        $auth->addChild($superCTT, $adminSite);            // Grant access to admin site process.
        $auth->addChild($superCTT, $uploadFile);           // Grant access to uploads files.
        $auth->addChild($superCTT, $viewHelp);             // Grant access to view the CTTwapp help.
        $auth->addChild($superCTT, $adminClient);          // Grant access to admin all client process.
        $auth->addChild($superCTT, $adminClientType);      // Grant access to admin all client type process.
        $auth->addChild($superCTT, $adminBrand);           // Grant access to admin all brand process.
        $auth->addChild($superCTT, $adminCatalog);         // Grant access to admin all catalog process.
        $auth->addChild($superCTT, $adminArticle);         // Grant access to admin all article process.
        $auth->addChild($superCTT, $adminInventory);       // Grant access to admin all inventory entities.
        $auth->addChild($superCTT, $adminProject);         // Grant access to admin all project entities.
        $auth->addChild($superCTT, $adminReservation);     // Grant access to admin all reservation entities.
        $auth->addChild($superCTT, $adminMarketRate);      // Grant access to admin all market rate entities.



        // Role : adminCTT
        // ---------------

        // Creates the role 'adminCTT' and grant ALL the available permissions in the Rbac system.
        $adminCTT = $auth->createRole('adminCTT');
        $adminCTT->description = 'Role : Defines an adminCTT user with all available permissions in the Rbac system.';
        $auth->add($adminCTT);

        // Adds all the roles and permissions
        $auth->addChild($adminCTT, $accessMain);           // Grant access only to the site main index.
        $auth->addChild($adminCTT, $adminSite);            // Grant access to admin site process.
        $auth->addChild($adminCTT, $uploadFile);           // Grant access to uploads files.
        $auth->addChild($adminCTT, $viewHelp);             // Grant access to view the CTTwapp help.
        $auth->addChild($adminCTT, $adminProcess);         // Grant access to special admin process.
        $auth->addChild($adminCTT, $adminClient);          // Grant access to admin all client process.
        $auth->addChild($adminCTT, $adminClientType);      // Grant access to admin all client type process.
        $auth->addChild($adminCTT, $adminBrand);           // Grant access to admin all brand process.
        $auth->addChild($adminCTT, $adminCatalog);         // Grant access to admin all catalog process.
        $auth->addChild($adminCTT, $adminArticle);         // Grant access to admin all article process.
        $auth->addChild($adminCTT, $adminInventory);       // Grant access to admin all inventory entities.
        $auth->addChild($adminCTT, $adminProject);         // Grant access to admin all project entities.
        $auth->addChild($adminCTT, $adminReservation);     // Grant access to admin all reservation entities.
        $auth->addChild($adminCTT, $adminMarketRate);      // Grant access to admin all market rate entities.



        // Role Assignments
        // ----------------

        // Assigns the role adminCTT to the admin user.

        $auth->assign($adminCTT, 1);                 // Assign the adminCTT role to the UserId = 1
        $auth->assign($superCTT, 2);                 // Assign the superCTT role to the UserId = 2
        $auth->assign($marketingCTT, 3);             // Assign the marketingCTT role to the UserId = 3
        $auth->assign($inventoryCTT, 4);             // Assign the inventoryCTT role to the UserId = 4
        $auth->assign($guestCTT, 5);                 // Assign the guestCTT role to the UserId = 5
        $auth->assign($userCTT, 6);                  // Assign the guestCTT role to the UserId = 5
    }

    public function actionDown()
    {
        // This action removes all authorization data, including roles, permissions, rules, and assignments.

        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}