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
        $ds18b20 = new RecordsDs18b20();
        $dht22 = new RecordsDht22();
        $pzem004t = new RecordsPzem004t();
        return $this->render('index', compact(['pzem004t', 'dht22', 'ds18b20']));
    }

    public function actionJson($sensor = null, $names = null, $serial = null, $last = null)
    {

        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            $sensor = $request->post('sensor');
            $names = $request->post('names');
            $serial = $request->post('serial');
            $last = $request->post('last');
        }

        $validSensors = ['pzem004t', 'dht22', 'ds18b20'];

        if (!$sensor)
            return $this->render('error', ['error' => 'please choose sensor name, by GET request']);
        if (!in_array($sensor, $validSensors))
            return $this->render('error', ['error' => 'invalid sensor name']);

        Yii::$app->response->format = Response::FORMAT_JSON;

        $jsonSensorData = new JsonSensorsData();
        return $jsonSensorData->getData($sensor, $names, $serial, $last, $days = 31);

    }

}
