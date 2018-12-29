<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.12.2018
 * Time: 1:51
 */

namespace app\models;


use yii\base\Model;

class JsonSensorsData extends Model
{

    public $validSensors;
    public $request;

    public function rules(){
        return [
            ['validSensors', 'validateSensorName']
        ];

    }


    public function validateSensorName(){
        if(!in_array($this->request->post('sensor'), $this->validSensors))
            $this->addError('sensor',"Sensor name: {$this->request->post('sensor')} is not valid");
    }

    public function getData($days = 10){

        switch($this->request->post('sensor')){
            case 'pzem004t':
                $recordsModel = new RecordsPzem004t();
                break;
            case 'dht22':
                $recordsModel = new RecordsDht22();
                break;
            case 'ds18b20':
                $recordsModel = new RecordsDs18b20();
                break;
            default:
                return false;
        }

        if($this->request->post('sensor') == 'ds18b20' && $this->request->post('names'))
            return $recordsModel->getAllSensorsNames();

        if($this->request->post('last')){
            return $recordsModel->getLast($this->request->post('serial'));
        } else {
            return $recordsModel->get($this->request->post('serial'), $days);
        }

        return false;
    }
}