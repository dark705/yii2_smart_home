<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10.12.2018
 * Time: 15:57
 */
define ('YII_DEBUG', true);
require '../vendor/autoload.php';
require '../vendor/yiisoft/yii2/Yii.php';
$config = require '../config/web.php';
(new yii\web\Application($config))->run();

