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


    public function getData($request, $days = 10){

        switch($request->post('sensor')){
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

        if($request->post('sensor') == 'ds18b20' && $request->post('names'))
            return $recordsModel->getAllSensorsNames();

        if($request->post('last')){
            return $recordsModel->getLast($request->post('serial'));
        } else {
            return $recordsModel->get($request->post('serial'), $days);
        }

        return false;
    }
}