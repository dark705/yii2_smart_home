<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:54
 */

namespace app\controllers;
use app\models\JsonSensorsData;
use app\models\RecordsDht22;
use app\models\RecordsDs18b20;
use app\models\RecordsPzem004t;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SensorsController extends Controller
{
    public function actionIndex(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $jsonSensorData = Yii::createObject([
                'class' => JsonSensorsData::class,
                'validSensors' => [
                    'pzem004t' => 'RecordsPzem004t',
                    'dht22' => 'RecordsDht22',
                    'ds18b20' => 'RecordsDs18b20'
                ],
                'days' => 31,
                'request' => Yii::$app->request
            ]);

            if($jsonSensorData->validate()){
                return $jsonSensorData->data;
            } else {
                return $jsonSensorData->errors;
            }
        }

        if (Yii::$app->request->isGet){
            $ds18b20 = new RecordsDs18b20();
            $dht22 = new RecordsDht22();
            $pzem004t = new RecordsPzem004t();
            return $this->render('index', compact(['pzem004t', 'dht22', 'ds18b20']));
        }
    }

}
