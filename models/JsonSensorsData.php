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
    public $days;

    public function rules(){
        return [
            ['validSensors', 'validateSensorName']
        ];
    }


    public function validateSensorName(){
        if(!array_key_exists($this->request->post('sensor'), $this->validSensors))
            $this->addError('error',"Sensor name: {$this->request->post('sensor')} is not valid");
    }

    public function getData(){
        if(!$this->days)
            $this->days = 10;
        $sensor = $this->request->post('sensor');
        $class = __NAMESPACE__ . '\\'.  $this->validSensors[$sensor];
        $recordsModel = new $class();

        if($this->request->post('sensor') == 'ds18b20' && $this->request->post('names'))
            return $recordsModel->getAllSensorsNames();
        if($this->request->post('last')){
            return $recordsModel->getLast($this->request->post('serial'));
        } else {
            return $recordsModel->get($this->request->post('serial'), $this->days);
        }
        return false;
    }
}