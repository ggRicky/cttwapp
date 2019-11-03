<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'cttwapp-frontend-v1',
    'name' => 'CTT Web Application v1.0',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    // 2018-02-05 13:52 Hrs. : Configuration for language and sourceLanguage default settings
    'language' => 'es',
    'sourceLanguage' => 'es',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 2019-11-03 14:16 Hrs. : Configuration for using i18n Formatter internationalization.
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'MXN',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 2,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ],
        ],
        // 2018-02-05 13:52 Hrs. : Configuration for using Yii2 internationalization module.
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                      //'basePath' => '@app/messages',
                    'sourceLanguage' => 'es',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            // 2018-02-05 13:49 Hrs.  Disable the next param for properly function in servers calls via ajax's jQuery $.post( ... ) function
            'enableCsrfValidation' => false,
            'enableCookieValidation' => true,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    // Defines the cttwapp project alias
    'aliases' => [
        '@uploads' => '/uploads',                       // 2018-08-12 : Defined to uploads files into the system
        '@uploads_inv' => '/uploads/inventory_pics',    // 2018-08-12 : Defined to uploads image files into the system
        '@downloads' => '/downloads',                   // 2019-09-19 : Defined to downloads files into the system
    ],

    // 2018-02-05 13:54 Hrs. : Register a new component ( class ). One method included in this component is for change dynamically the application's language.
    'as beforeRequest' => [
        'class' => 'frontend\components\CTTGlobalMixin',
    ],

    'params' => $params,
];
