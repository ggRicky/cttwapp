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


        // Defines all the permissions for cttwapp system
        // -----------------------------------------------


        // Defines the permissions to adminSite
        // ------------------------------------

        // Adds "adminSite" permission
        $adminSite = $auth->createPermission('adminSite');
        $adminSite->description = 'Permission : Allows to admin site actions in the cttwapp system.';
        $auth->add($adminSite);


        // Defines the permissions to access the special admin process
        // -----------------------------------------------------------

        // Adds "adminProcess" permission
        $adminProcess = $auth->createPermission('adminProcess');
        $adminProcess->description = 'Permission : Allows access to the admin process in the cttwapp system.';
        $auth->add($adminProcess);


        // Defines the permissions to access the main index
        // ------------------------------------------------

        // Adds "accessMain" permission
        $accessMain = $auth->createPermission('accessMain');
        $accessMain->description = 'Permission : Allows to access the cttwapp system site main index.';
        $auth->add($accessMain);


        // Defines the permissions on the client types module
        // --------------------------------------------------

        // Adds "createClientType" permission
        $createClientType = $auth->createPermission('createClientType');
        $createClientType->description = 'Permission : Allows to create a client type in the cttwapp system.';
        $auth->add($createClientType);

        // Adds "updateClientType" permission
        $updateClientType = $auth->createPermission('updateClientType');
        $updateClientType->description = 'Permission : Allows to update a client type in the cttwapp system.';
        $auth->add($updateClientType);

        // Adds "viewClientType" permission
        $viewClientType = $auth->createPermission('viewClientType');
        $viewClientType->description = 'Permission : Allows to view a client type in the cttwapp system.';
        $auth->add($viewClientType);

        // Adds "deleteClientType" permission
        $deleteClientType = $auth->createPermission('deleteClientType');
        $deleteClientType->description = 'Permission : Allows to delete a client type in the cttwapp system.';
        $auth->add($deleteClientType);

        // Adds "listClientType" permission
        $listClientType = $auth->createPermission('listClientType');
        $listClientType->description = 'Permission : Allows to list the client types in the cttwapp system.';
        $auth->add($listClientType);



        // Defines the permissions on the clients module
        // --------------------------------------------

        // Adds "createClient" permission
        $createClient = $auth->createPermission('createClient');
        $createClient->description = 'Permission : Allows to create a client in the cttwapp system.';
        $auth->add($createClient);

        // Adds "updateClient" permission
        $updateClient = $auth->createPermission('updateClient');
        $updateClient->description = 'Permission : Allows to update a client in the cttwapp system.';
        $auth->add($updateClient);

        // Adds "viewClient" permission
        $viewClient = $auth->createPermission('viewClient');
        $viewClient->description = 'Permission : Allows to view a client in the cttwapp system.';
        $auth->add($viewClient);

        // Adds "deleteClient" permission
        $deleteClient = $auth->createPermission('deleteClient');
        $deleteClient->description = 'Permission : Allows to delete a client in the cttwapp system.';
        $auth->add($deleteClient);

        // Adds "listClient" permission
        $listClient = $auth->createPermission('listClient');
        $listClient->description = 'Permission : Allows to list the clients in the cttwapp system.';
        $auth->add($listClient);



        // Defines the permissions on the catalogs module
        // ---------------------------------------------

        // Adds "createCatalog" permission
        $createCatalog = $auth->createPermission('createCatalog');
        $createCatalog->description = 'Permission : Allows to create a Catalog in the cttwapp system.';
        $auth->add($createCatalog);

        // Adds "updateCatalog" permission
        $updateCatalog = $auth->createPermission('updateCatalog');
        $updateCatalog->description = 'Permission : Allows to update a Catalog in the cttwapp system.';
        $auth->add($updateCatalog);

        // Adds "viewCatalog" permission
        $viewCatalog = $auth->createPermission('viewCatalog');
        $viewCatalog->description = 'Permission : Allows to view a Catalog in the cttwapp system.';
        $auth->add($viewCatalog);

        // Adds "deleteCatalog" permission
        $deleteCatalog = $auth->createPermission('deleteCatalog');
        $deleteCatalog->description = 'Permission : Allows to delete a Catalog in the cttwapp system.';
        $auth->add($deleteCatalog);

        // Adds "listCatalog" permission
        $listCatalog = $auth->createPermission('listCatalog');
        $listCatalog->description = 'Permission : Allows to list the Catalogs in the cttwapp system.';
        $auth->add($listCatalog);



        // Defines the permissions on the brands module
        // -------------------------------------------

        // Adds "createBrand" permission
        $createBrand = $auth->createPermission('createBrand');
        $createBrand->description = 'Permission : Allows to create a Brand in the cttwapp system.';
        $auth->add($createBrand);

        // Adds "updateBrand" permission
        $updateBrand = $auth->createPermission('updateBrand');
        $updateBrand->description = 'Permission : Allows to update a Brand in the cttwapp system.';
        $auth->add($updateBrand);

        // Adds "viewBrand" permission
        $viewBrand = $auth->createPermission('viewBrand');
        $viewBrand->description = 'Permission : Allows to view a Brand in the cttwapp system.';
        $auth->add($viewBrand);

        // Adds "deleteBrand" permission
        $deleteBrand = $auth->createPermission('deleteBrand');
        $deleteBrand->description = 'Permission : Allows to delete a Brand in the cttwapp system.';
        $auth->add($deleteBrand);

        // Adds "listBrand" permission
        $listBrand = $auth->createPermission('listBrand');
        $listBrand->description = 'Permission : Allows to list the Brands in the cttwapp system.';
        $auth->add($listBrand);



        // Defines the permissions on the articles module
        // ---------------------------------------------

        // Adds "createArticle" permission
        $createArticle = $auth->createPermission('createArticle');
        $createArticle->description = 'Permission : Allows to create an Article in the cttwapp system.';
        $auth->add($createArticle);

        // Adds "updateArticle" permission
        $updateArticle = $auth->createPermission('updateArticle');
        $updateArticle->description = 'Permission : Allows to update an Article in the cttwapp system.';
        $auth->add($updateArticle);

        // Adds "viewArticle" permission
        $viewArticle = $auth->createPermission('viewArticle');
        $viewArticle->description = 'Permission : Allows to view an Article in the cttwapp system.';
        $auth->add($viewArticle);

        // Adds "deleteArticle" permission
        $deleteArticle = $auth->createPermission('deleteArticle');
        $deleteArticle->description = 'Permission : Allows to delete an Article in the cttwapp system.';
        $auth->add($deleteArticle);

        // Adds "listArticle" permission
        $listArticle = $auth->createPermission('listArticle');
        $listArticle->description = 'Permission : Allows to list the Articles in the cttwapp system.';
        $auth->add($listArticle);



        // Defines all the roles for cttwapp system
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



        // Role : $userGuest
        // -----------------

        // Creates the role 'userGuest' and give only the permissions to access the site main index.
        $userGuest = $auth->createRole('userGuest');
        $userGuest->description = 'Role : Defines a guest user with only permission to access the main index.';
        $auth->add($userGuest);

        // Adds basic permission
        $auth->addChild($userGuest, $accessMain);          // Grant access only to the site main index.



        // Role : userCTT
        // --------------

        // Creates the role 'userCTT' and give only the permissions to list the available entities.
        $userCTT = $auth->createRole('userCTT');
        $userCTT->description = 'Role : Defines a default CTT user with only permissions to list the available entities.';
        $auth->add($userCTT);

        // Adds basic roles to list entities
        $auth->addChild($userCTT, $adminSite);             // Grant access to admin all site process.
        $auth->addChild($userCTT, $userClient);            // Grant access to list client entities.
        $auth->addChild($userCTT, $userClientType);        // Grant access to list client type entities.
        $auth->addChild($userCTT, $userBrand);             // Grant access to list brand entities.
        $auth->addChild($userCTT, $userCatalog);           // Grant access to list catalog entities.
        $auth->addChild($userCTT, $userArticle);           // Grant access to list article entities.



        // Role : adminCTT
        // ---------------

        // Creates the role 'adminCTT' and grant ALL the available permissions in the rbac system.
        $adminCTT = $auth->createRole('adminCTT');
        $adminCTT->description = 'Role : Defines an adminCTT user with all available permissions in the rbac system.';
        $auth->add($adminCTT);

        // Adds all the roles and permissions
        $auth->addChild($adminCTT, $adminSite);            // Grant access to admin all site process.
        $auth->addChild($adminCTT, $adminProcess);         // Grant access to special admin process.
        $auth->addChild($adminCTT, $adminClient);          // Grant access to admin all client process.
        $auth->addChild($adminCTT, $adminClientType);      // Grant access to admin all client type process.
        $auth->addChild($adminCTT, $adminBrand);           // Grant access to admin all brand process.
        $auth->addChild($adminCTT, $adminCatalog);         // Grant access to admin all catalog process.
        $auth->addChild($adminCTT, $adminArticle);         // Grant access to admin all article process.



        // Role Assignments
        // ----------------

        // Assigns the role adminCTT to the admin user.

        $auth->assign($adminCTT, 1);                 // Assign the adminCTT role to the UserId = 1
        $auth->assign($userCTT, 2);                  // Assign the userCTT role to the UserId = 2
        $auth->assign($userGuest, 3);                // Assign the userTest role to the UserId = 3
    }

    public function actionDown()
    {
        // This action removes all authorization data, including roles, permissions, rules, and assignments.

        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}