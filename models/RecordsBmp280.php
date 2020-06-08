<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;

class RecordsBmp280 extends Model implements RecordsInterface
{
    public $days = 10;

    public function get($serial = null)
    {
        $records = $records = (new Query())
            ->select(['datetime', 'pressure', 'temperature'])
            ->from('bmp280')
            ->where('datetime > NOW() - INTERVAL ' . $this->days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }

    public function getLast($serial = null)
    {
        $records = $records = (new Query())
            ->select(['datetime', 'pressure', 'temperature'])
            ->from('bmp280')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->all();
        return static::convertTypes($records);
    }

    private static function convertTypes($records)
    {
        $types = [];
        $keys = array_keys($records[0]);
        foreach ($keys as $index => $key) {
            $types[$key] = $index;
        }

        foreach ($records as $key => $record) {
            $convertedRecord = [
                strtotime($record['datetime']),
                (float) $record['pressure'],
                (float) $record['temperature'],

            ];
            $records[$key] = $convertedRecord;
        }

        return [
            'types' => $types,
            'data'  => $records
        ];
    }
}