<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    // 2018-08-27 : The "log" component must be loaded during bootstrapping time
    'bootstrap' => ['log'],
    // 2018-08-27 : The "log" component process messages with timestamp. Set PHP timezone to create correct timestamp
    'timeZone' => 'America/Mexico_City',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // 2018-05-22 : Includes the Yii2 Rbac Manager component.
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        // 2018-08-27 : Includes the Yii2 Logging.
        'log' => [
            'targets' => [
                'file_1' => [
                    // 2018-08-28 : Defines a file target for logging all cttwapp system actions except cttwapp_user actions [ -- Enabled -- ]

                    'class' => 'yii\log\FileTarget',                      // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => true,                                    // 2018-08-28 : Target Enabled
                    'logFile' => '@runtime/logs/cttwapp_admin.log',       // 2018-08-28 : The file for stores the cttwapp app log messages.
                    'levels' => ['info','error','warning'],               // 2018-08-28 : Defines log info messages.
                    'categories' => [],                                   // 2018-08-28 : Defines a new category for selected actions.
                    'except' => [                                         // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'cttwapp_user',
                    ],
                    'prefix' => function ($message) {                     // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.

                        // 2019-01-30 [ Refactored ] : Gets the current user and init the ID, Name and IP variables.

                        // Is there a user registered in Yii? : Yes Then, it returns the user currently registered in Yii2. No. Then it returns a null value.
                        $user     = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        // The current user is not null? : Yes Then, checks if the ID type is not equal to 'NULL'. If true then returns the user ID. Otherwise return '-'.
                        // The current user is null? : Yes. Then return '-'.
                        $userID   = $user ? (gettype($user->getId(false)) != 'NULL' ? $user->getId(false) : '-') : '-';
                        $userName = '-';
                        $userIP   = '-';

                        // 2019-01-30 [ Refactored ] : Is there a logged user? : Yes. Then gets the Name and the user IP.
                        if ($userID != '-'){
                           $userName = $user->getUsername();
                           $userIP   = Yii::$app->request->getUserIP();
                        }

                        // 2019-01-30 [ Refactored ] : Creates the new prefix
                        return "[$userID][$userName][$userIP]";

                    }

                ],

                'file_2' => [
                    // 2018-08-28 : Defines a file target for logging the 'application' and 'cttwapp_user' categories [ -- Enabled -- ]

                    'class' => 'yii\log\FileTarget',                      // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => true,                                    // 2018-08-28 : Target Enabled
                    'logFile' => '@runtime/logs/cttwapp_user.log',        // 2018-08-28 : The file for stores the cttwapp app log messages.
                    'levels' => ['info', 'error', 'warning', 'profile'],  // 2018-08-28 : Defines log info and profile messages. The level 'profile' needs the 'application' category to log 'Performance Profiling'
                    'categories' => ['application','cttwapp_user'],       // 2018-08-28 : Defines a new category 'cttwapp_user' for selected actions.
                    'logVars' => [],                                      // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                         // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                     // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.

                        // 2019-01-30 [ Refactored ] : Gets the current user and init the ID, Name and IP variables.

                        // Is there a user registered in Yii? : Yes Then, it returns the user currently registered in Yii2. No. Then it returns a null value.
                        $user     = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        // The current user is not null? : Yes Then, checks if the ID type is not equal to 'NULL'. If true then returns the user ID. Otherwise return '-'.
                        // The current user is null? : Yes. Then return '-'.
                        $userID   = $user ? (gettype($user->getId(false)) != 'NULL' ? $user->getId(false) : '-') : '-';
                        $userName = '-';
                        $userIP   = '-';

                        // 2019-01-30 [ Refactored ] : Is there a logged user? : Yes. Then gets the Name and the user IP.
                        if ($userID != '-'){
                            $userName = $user->getUsername();
                            $userIP   = Yii::$app->request->getUserIP();
                        }

                        // 2019-01-30 [ Refactored ] : Creates the new prefix
                        return "[$userID][$userName][$userIP]";

                    }

                ],

                'database_1' => [
                    // 2018-08-28 : Defines a Database target for cttwapp logging [ -- Disabled -- ]

                    'class' => 'yii\log\DbTarget',                        // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => false,                                   // 2018-08-28 : Target Disabled
                    'levels' => [],                                       // 2018-08-28 : No levels for disabled this target. To enables adds 'info, 'error', 'warnings, 'debug ', etc.
                    'categories' => [],                                   // 2018-08-28 : No categories for disabled this target. To enables adds 'yii\db\*', 'yii\web\HttpException:*', etc.
                    'logVars' => [],                                      // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                         // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                     // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.

                        // 2019-01-30 [ Refactored ] : Gets the current user and init the ID, Name and IP variables.

                        // Is there a user registered in Yii? : Yes Then, it returns the user currently registered in Yii2. No. Then it returns a null value.
                        $user     = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        // The current user is not null? : Yes Then, checks if the ID type is not equal to 'NULL'. If true then returns the user ID. Otherwise return '-'.
                        // The current user is null? : Yes. Then return '-'.
                        $userID   = $user ? (gettype($user->getId(false)) != 'NULL' ? $user->getId(false) : '-') : '-';
                        $userName = '-';
                        $userIP   = '-';

                        // 2019-01-30 [ Refactored ] : Is there a logged user? : Yes. Then gets the Name and the user IP.
                        if ($userID != '-'){
                            $userName = $user->getUsername();
                            $userIP   = Yii::$app->request->getUserIP();
                        }

                        // 2019-01-30 [ Refactored ] : Creates the new prefix
                        return "[$userID][$userName][$userIP]";

                    }

                ],

                'email_1' => [
                    // 2018-08-28 : Defines an Email target for cttwapp logging [ -- Disabled -- ]

                    'class' => 'yii\log\EmailTarget',                     // 2018-08-28 : Uses Email Target class for Logs.
                    'enabled' => true,                                    // 2018-08-28 : Target disabled
                    'mailer' => 'mailer',
                    'message' => [                                        // 2018-08-28 : Defines the source and destination mail accounts for send the Logs.
                        'from' => ['soporte.cttwapp@gmail.com'],
                        'to' => ['ricardogg67@gmail.com', 'ricardo.gonzalez@itcelaya.edu.mx'],
                        'subject' => 'Activity logged from CTTwapp',
                    ],
                    'levels' => ['info','error','warning'],               // 2018-08-28 : No levels for disabled this target. To enables adds 'info, 'error', 'warnings, 'debug ', etc.
                    'categories' => ['cttwapp_mail'],                     // 2018-08-28 : No categories for disabled this target. To enables adds 'yii\db\*', 'yii\web\HttpException:*', etc.
                    'logVars' => [],                                      // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                         // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                     // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.

                        // 2019-01-30 [ Refactored ] : Gets the current user and init the ID, Name and IP variables.

                        // Is there a user registered in Yii? : Yes Then, it returns the user currently registered in Yii2. No. Then it returns a null value.
                        $user     = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        // The current user is not null? : Yes Then, checks if the ID type is not equal to 'NULL'. If true then returns the user ID. Otherwise return '-'.
                        // The current user is null? : Yes. Then return '-'.
                        $userID   = $user ? (gettype($user->getId(false)) != 'NULL' ? $user->getId(false) : '-') : '-';
                        $userName = '-';
                        $userIP   = '-';

                        // 2019-01-30 [ Refactored ] : Is there a logged user? : Yes. Then gets the Name and the user IP.
                        if ($userID != '-'){
                            $userName = $user->getUsername();
                            $userIP   = Yii::$app->request->getUserIP();
                        }

                        // 2019-01-30 [ Refactored ] : Creates the new prefix
                        return "[$userID][$userName][$userIP]";

                    },

                ],
            ],
        ],
        // 2019-01-04 : To bends Yii2 to your will, by virtually extending everything!
        'user' => [
            'class' => 'frontend\components\User', // extend User component
        ],
        // 2019-01-17 : Extends the GridView class to re-config the html table structure and leave the table header fixed
        'gridview' => [
            'class' => 'frontend\components\GriView', // extend GridView component
        ],
    ],
];
