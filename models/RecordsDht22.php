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

class RecordsDht22 extends Model implements RecordsInterface
{
    public $days = 10;

    private static function convertTypes($records){
        $types = [];
        $keys = array_keys($records[0]);
        foreach ($keys as $index => $key){
            $types[$key] = $index;
        }

        foreach ($records as $key => $record){
            $convertedRecord = [
                strtotime($record['datetime']),
                (float)$record['temperature'],
                (float)$record['humidity'],
            ];
            $records[$key] = $convertedRecord;
        }
        return [
            'types' => $types,
            'data' => $records
        ];
    }

    public function getLast($serial = null){
        $records = (new Query())
            ->select(['datetime', 'temperature', 'humidity'])
            ->from('dht22')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->all();
        return static::convertTypes($records);
    }

    public function get($serial = null){
        $records = (new Query())
            ->select(['datetime', 'temperature', 'humidity'])
            ->from('dht22')
            ->where('datetime > NOW() - INTERVAL ' . $this->days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }
}