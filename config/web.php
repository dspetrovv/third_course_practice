<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'ExcursionApp',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'login' => [
            'class' => 'app\modules\login\Login',
        ],
        'signup' => [
            'class' => 'app\modules\signup\SignUp',
        ],
        'myprofile' => [
            'class' => 'app\modules\myprofile\Myprofile',
        ],
        'news' => [
            'class' => 'app\modules\news\News',
        ],
        'company' => [
            'class' => 'app\modules\company\Company',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Admin',
            'layout' => 'main',
        ],
    ],
    'components' => [
        'yandexMapsApi' => [
            'class' => 'mirocow\yandexmaps\Api',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CzQhgm6y6aB4vrIcqXnXLIZCeS5B9WJM',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'site/captcha/<refresh:\d+>' => 'site/captcha',
                'site/captcha/<v:\w+>' => 'site/captcha',
                'company/' => 'company/default/index',
                'about/' => 'site/about',
                'news/' => 'news/default/index',
            ],
        ], 
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
