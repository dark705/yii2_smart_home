<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10.12.2018
 * Time: 16:18
 */
return [
    'id' => 'manage',
    'basePath' => '../',
    'bootstrap' => ['debug'],
	'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*']
        ]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'somesecret ssssssstring',
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'db' => require 'db.php',
        'assetManager' =>[
            'appendTimestamp' => true
        ]
    ]
];