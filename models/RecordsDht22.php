<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsDht22 implements RecordsInterface
{
    private static function convertTypes($records){
        foreach ($records as $key => $record){
            $convertedRecord = [
                'datetime' => strtotime($record['datetime']),
                'temperature' => (float)$record['temperature'],
                'humidity' => (float)$record['humidity'],
            ];
            $records[$key] = $convertedRecord;
        }
        return $records;
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

    public function get($serial = null, $days = 10){
        $records = (new Query())
            ->select(['datetime', 'temperature', 'humidity'])
            ->from('dht22')
            ->where('datetime > NOW() - INTERVAL ' . $days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }
}