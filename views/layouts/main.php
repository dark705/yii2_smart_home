<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:44
 */
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?= Html::csrfMetaTags() ?>
        <title>Управление</title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <?php
    NavBar::begin([
        'brandLabel' => 'Управление',
        'brandUrl' => Yii::$app->homeUrl,
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav navbar-left small'],
        'items' => [
            ['label' => 'Сенсоры', 'url' => 'sensors'],
            ['label' => 'Интернет', 'url' => 'internet'],
        ],
    ]);
    NavBar::end();
    ?>
    <?=$content;?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>