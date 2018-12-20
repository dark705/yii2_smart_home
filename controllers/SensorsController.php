<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:54
 */

namespace app\controllers;


use Yii;
use yii\web\Controller;

class SensorsController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}