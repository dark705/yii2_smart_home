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
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $request = Yii::$app->request;
            $validSensors = ['pzem004t', 'dht22', 'ds18b20'];


            if (!in_array($request->post('sensor'), $validSensors))
                return 'invalid sensor name';

            $jsonSensorData = new JsonSensorsData();
            return $jsonSensorData->getData($request, $days = 31);

        }
        if (Yii::$app->request->isGet){
            $ds18b20 = new RecordsDs18b20();
            $dht22 = new RecordsDht22();
            $pzem004t = new RecordsPzem004t();
            return $this->render('index', compact(['pzem004t', 'dht22', 'ds18b20']));
        }
    }

}
