<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsDs18b20 extends Query
{

    private $allSensorsInfo;

    public function getAllSensorsInfo(){
        if (!$this->allSensorsInfo){
            $subQuery = (new Query())
                ->select('serial')
                ->from('ds18b20')
                ->distinct();

            $this->allSensorsInfo =  (new Query())->select('distinct.serial, ds18b20_names.name')
                ->from('ds18b20_names')
                ->rightJoin(['distinct' => $subQuery], 'distinct.serial = ds18b20_names.serial')
                ->all();
            return   $this->allSensorsInfo;
        } else {
            return  $this->allSensorsInfo;
        }
    }

    public function getLastInfo($serial){
        return (new Query)
            ->select(['datetime', 'serial', 'temperature'])
            ->from('ds18b20')
            ->where(['serial' => $serial])
            ->orderBy('datetime DESC')
            ->limit(1)
            ->one();
    }

}