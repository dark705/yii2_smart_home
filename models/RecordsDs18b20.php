<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsDs18b20 extends Query implements RecordsInterface
{
    private $allSensorsNames;

    public function getAllSensorsNames(){
        if (!$this->allSensorsNames){
            $subQuery = (new Query())
                ->select('serial')
                ->from('ds18b20')
                ->distinct();

            $this->allSensorsNames =  (new Query())->select('distinct.serial, ds18b20_names.name')
                ->from('ds18b20_names')
                ->rightJoin(['distinct' => $subQuery], 'distinct.serial = ds18b20_names.serial')
                ->all();
            return   $this->allSensorsNames;
        } else {
            return  $this->allSensorsNames;
        }
    }

    public function getLast($serial){
        if(!$this->validate($serial))
            return false;

        return (new Query)
            ->select(['datetime', 'serial', 'temperature'])
            ->from('ds18b20')
            ->where(['serial' => $serial])
            ->orderBy('datetime DESC')
            ->limit(1)
            ->one();
    }

    public function get($serial, $days = 10){
        if(!$this->validate($serial))
            return false;

        return (new Query())
            ->select(['datetime', 'serial', 'temperature'])
            ->from('ds18b20')
            ->where(['serial' => $serial])
            ->andWhere('datetime > NOW() - INTERVAL ' . $days . ' DAY')
            ->all();
    }

    private function validate($serial){
        foreach($this->getAllSensorsNames() as $record){
            if ($record['serial'] == $serial)
                return  true;
        }
        return false;
    }
}