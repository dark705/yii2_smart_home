<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 1:54
 */

namespace app\controllers;
use app\models\RecordsDht22;
use app\models\RecordsDs18b20;
use app\models\RecordsPzem004t;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SensorsController extends Controller
{
    public function actionIndex(){
        $ds18b20 = new RecordsDs18b20();
        $dht22 = new RecordsDht22();
        $pzem004t = new RecordsPzem004t();
        return $this->render('index', compact(['pzem004t','dht22','ds18b20']));
    }

    public function actionJson(){
        $validSensors = ['pzem004t', 'dht22', 'ds18b20'];
        $request  = yii::$app->request;
        if (!$request->get('sensor'))
            return $this->render('error', ['error' => 'please choose sensor name, by GET request']);
        if (!in_array($request->get('sensor'), $validSensors))
            return $this->render('error', ['error' => 'invalid sensor name']);

       Yii::$app->response->format = Response::FORMAT_JSON;

        switch($request->get('sensor')){
            case 'pzem004t':
                $records = new RecordsPzem004t();
                break;
            case 'dht22':
                $records = new RecordsDht22();
                break;
            case 'ds18b20':
                $records = new RecordsDs18b20();
                break;
        }

        if($request->get('sensor') ==  'ds18b20' && !is_null($request->get('names')))
            return $records->getAllSensorsNames();

        if( !is_null($request->get('last'))){
            return $records->getLast($request->get('serial'));
        } else {
            return $records->get($request->get('serial'), 31);

        }

    }
}