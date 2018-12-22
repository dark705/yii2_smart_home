<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:54
 */

namespace app\controllers;
use app\models\SensorDht22;
use app\models\SensorDs18b20;
use yii\web\Controller;

class SensorsController extends Controller
{
    public function actionIndex(){
        $ds18b20 = new SensorDs18b20();
        $dht22 = new SensorDht22();
        return $this->render('index', compact(['dht22','ds18b20']));
    }
}