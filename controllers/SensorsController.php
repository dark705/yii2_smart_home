<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:54
 */

namespace app\controllers;

use app\models\JsonSensorsData;
use app\models\GetSensorsData;
use app\models\RecordsBmp280;
use app\models\RecordsDht22;
use app\models\RecordsDs18b20;
use app\models\RecordsPzem004t;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SensorsController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $jsonSensorData             = Yii::createObject([
                'class'        => JsonSensorsData::class,
                'validSensors' => [
                    'pzem004t' => 'RecordsPzem004t',
                    'dht22'    => 'RecordsDht22',
                    'ds18b20'  => 'RecordsDs18b20',
                    'bmp280'   => 'RecordsBmp280'
                ],
                'days'         => 31,
                'request'      => Yii::$app->request
            ]);

            if ($jsonSensorData->validate()) {
                return $jsonSensorData->data;
            } else {
                return $jsonSensorData->errors;
            }
        }

        if (Yii::$app->request->isGet) {
            $getSensorData = Yii::createObject([
                'class'   => GetSensorsData::class,
                'sensors' => [
                    'dht22'    => ['class' => RecordsDht22::class],
                    'pzem004t' => ['class' => RecordsPzem004t::class],
                    'ds18b20'  => ['class' => RecordsDs18b20::class],
                    'bmp280'   => ['class' => RecordsBmp280::class],
                ],
                'days'    => 31
            ]);

            return $this->render('index', compact(['getSensorData']));
        }
    }
}
