<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10.12.2018
 * Time: 16:18
 */
$config = [
    'id' => 'manage',
    'basePath' => '../',
	'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'somesecret ssssssstring',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'db' => require 'db.php',
        'assetManager' =>[
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // не опубликовывать комплект
                    'js' => [
                        '//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
                    ]
                ]
            ]
        ]

    ],
    'params' => [
        'gateway' => require 'gateway.php'
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*'],
    ];
}
return $config;