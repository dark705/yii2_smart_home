<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.12.2018
 * Time: 1:51
 */

namespace app\models;


class JsonSensorsData
{


    public function getData($sensor = null, $names = null, $serial = null, $last = null, $days = 10){

        switch($sensor){
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

        if($sensor == 'ds18b20' && !is_null($names))
            return $recordsModel->getAllSensorsNames();

        if(!is_null($last)){
            return $recordsModel->getLast($serial);
        } else {
            return $recordsModel->get($serial, $days);
        }

        return false;
    }
}