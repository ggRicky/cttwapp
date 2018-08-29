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
                    // 2018-08-28 : Defines a file target for logging all the cttwapp system actions [ -- Enabled -- ]

                    'class' => 'yii\log\FileTarget',                 // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => true,                               // 2018-08-28 : Target enabled
                    'logFile' => '@runtime/logs/cttwapp_admin.log',  // 2018-08-28 : The file for stores the cttwapp app log messages.
                    'levels' => ['info','error','warning'],          // 2018-08-28 : Defines log info messages.
                    'categories' => [],                              // 2018-08-28 : Defines a new category for selected actions.
                    'except' => [                                    // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'cttwapp_user',
                    ],
                    'prefix' => function ($message) {                // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.
                        // There is an user logged ?
                        if (Yii::$app->has('user', true)){
                            // Yes!. Then gets the user Name, the user ID, and the user IP.
                            $userID   = Yii::$app->user->identity->id;
                            $userName = Yii::$app->user->identity->username;
                            $userIP   = Yii::$app->request->getUserIP();

                            // Return the new prefix
                            return "[$userID][$userName][$userIP]";
                        }
                        return "[-][-][-]";
                    }

                ],

                'file_2' => [
                    // 2018-08-28 : Defines a file target for logging the cttwapp user actions [ -- Enabled -- ]

                    'class' => 'yii\log\FileTarget',                 // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => true,                               // 2018-08-28 : Target enabled
                    'logFile' => '@runtime/logs/cttwapp_user.log',   // 2018-08-28 : The file for stores the cttwapp app log messages.
                    'levels' => ['info'],                            // 2018-08-28 : Defines log info messages.
                    'categories' => ['cttwapp_user'],                // 2018-08-28 : Defines a new category for selected actions.
                    'logVars' => [],                                 // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                    // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.
                        // There is an user logged ?
                        if (Yii::$app->has('user', true)){
                            // Yes!. Then gets the user Name, the user ID, and the user IP.
                            $userID   = Yii::$app->user->identity->id;
                            $userName = Yii::$app->user->identity->username;
                            $userIP   = Yii::$app->request->getUserIP();

                            // Return the new prefix
                            return "[$userID][$userName][$userIP]";
                        }
                        return "[-][-][-]";
                    }

                ],

                'database_1' => [
                    // 2018-08-28 : Defines a Database target for cttwapp logging [ -- Disabled -- ]

                    'class' => 'yii\log\DbTarget',                   // 2018-08-28 : Uses File Target class for Logs.
                    'enabled' => false,                              // 2018-08-28 : Target disabled
                    'levels' => [],                                  // 2018-08-28 : No levels for disabled this target. To enables adds 'info, 'error', 'warnings, 'debug ', etc.
                    'categories' => [],                              // 2018-08-28 : No categories for disabled this target. To enables adds 'yii\db\*', 'yii\web\HttpException:*', etc.
                    'logVars' => [],                                 // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                    // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.
                        // There is an user logged ?
                        if (Yii::$app->has('user', true)){
                            // Yes!. Then gets the user Name, the user ID, and the user IP.
                            $userID   = Yii::$app->user->identity->id;
                            $userName = Yii::$app->user->identity->username;
                            $userIP   = Yii::$app->request->getUserIP();

                            // Return the new prefix
                            return "[$userID][$userName][$userIP]";
                        }
                        return "[-][-][-]";
                    }

                ],

                'email_1' => [
                    // 2018-08-28 : Defines a Email target for cttwapp logging [ -- Disabled -- ]

                    'class' => 'yii\log\EmailTarget',                // 2018-08-28 : Uses Email Target class for Logs.
                    'enabled' => true,                              // 2018-08-28 : Target disabled
                    'message' => [                                   // 2018-08-28 : Defines the source and destination mail accounts for send the Logs.
                        'from' => ['soporte.cttwapp@gmail.com'],
                        'to' => ['ricardogg67@gmail.com', 'ricardo.gonzalez@itcelaya.edu.mx'],
                        'subject' => 'Log activity from cttwapp.com',
                    ],
                    'levels' => ['info'],                            // 2018-08-28 : No levels for disabled this target. To enables adds 'info, 'error', 'warnings, 'debug ', etc.
                    'categories' => ['cttwapp_mail'],                              // 2018-08-28 : No categories for disabled this target. To enables adds 'yii\db\*', 'yii\web\HttpException:*', etc.
                    'logVars' => [],                                 // 2018-08-28 : This setting avoid to record the PHP variables info like $_SERVER, $_POST, $_SESSION, $_COOKIE in the log.
                    'except' => [                                    // 2018-08-28 : This setting avoid to record the SQL commands in the log.
                        'yii\db\*',
                    ],
                    'prefix' => function ($message) {                // 2018-08-28 : This setting defines a PHP callable to customize the message formatting.
                        // There is an user logged ?
                        if (Yii::$app->has('user', true)){
                            // Yes!. Then gets the user Name, the user ID, and the user IP.
                            $userID   = Yii::$app->user->identity->id;
                            $userName = Yii::$app->user->identity->username;
                            $userIP   = Yii::$app->request->getUserIP();

                            // Return the new prefix
                            return "[$userID][$userName][$userIP]";
                        }
                        return "[-][-][-]";
                    },

                ],
            ],
        ],
    ],
];
