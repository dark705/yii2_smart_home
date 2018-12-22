<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:38
 */

namespace app\controllers;
use yii\web\Controller;


class SiteController extends Controller
{

    public function actionIndex(){
        return $this->render('index');
    }
}