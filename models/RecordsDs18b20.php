<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\base\Model;
use yii\db\Query;

class RecordsDs18b20 extends Model implements RecordsInterface
{
    private $allSensorsNames;
    public $days = 10;

    private static function convertTypes($records){
        foreach ($records as $key => $record){
            $convertedRecord = [
                'datetime' => strtotime($record['datetime']),
                'temperature' => (float)$record['temperature'],
            ];
            $records[$key] = $convertedRecord;
        }
        return $records;
    }

    public function getAllSensorsNames(){
        if (!$this->allSensorsNames){
            $subQuery = (new Query())
                ->select('serial')
                ->from('ds18b20')
                ->where('datetime > NOW() - INTERVAL ' . $this->days . ' DAY')
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

        $records = (new Query)
            ->select(['datetime', 'temperature'])
            ->from('ds18b20')
            ->where(['serial' => $serial])
            ->orderBy('datetime DESC')
            ->limit(1)
            ->all();
        return static::convertTypes($records);
    }

    public function get($serial){
        if(!$this->validate($serial))
            return false;

        $records = (new Query())
            ->select(['datetime', 'temperature'])
            ->from('ds18b20')
            ->where(['serial' => $serial])
            ->andWhere('datetime > NOW() - INTERVAL ' . $this->days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }

    public function validate($serial){
        foreach($this->getAllSensorsNames() as $record){
            if ($record['serial'] == $serial)
                return  true;
        }
        return false;
    }
}