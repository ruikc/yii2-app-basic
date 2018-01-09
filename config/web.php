<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-CN',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OKyQv4bwum1FR0SgW9nUnzYxFDh8oNtn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/course', 'v1/catalog', 'v1/content', 'v1/study'],
                    'tokens' => [
                        '{id}' => '<id:[a-zA-Z0-9-_]*>',//view操作可以识别字符串
                    ],
                    'pluralize' => false, //禁用复数形式
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user', 'v1/classify', 'v1/select'],
                    'tokens' => [
                        '{id}' => '<id:\\d[\\d,]*>', //view操作只能识别数字
                    ],
                    'pluralize' => false, //禁用复数形式
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/default'],
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST signup' => 'signup',
                    ],
                    'pluralize' => false,
                ],
            ],
        ]
    ],
    'params' => $params,
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
//            'as access' => [
//                'class' => \app\filters\AccessControl::className(),
//                'allowActions' => [
//                    'default/*',
//                    'course/*',
//                ],
//            ],
        ],
    ],
];

if (YII_ENV_DEV) {
//     configuration adjustments for 'dev' environment
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
