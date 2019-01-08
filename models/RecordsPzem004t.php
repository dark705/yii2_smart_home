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

class RecordsPzem004t extends Model implements RecordsInterface
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
                (float)$record['voltage'],
                (float)$record['current'],
                (float)$record['active']
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
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->all();
        return static::convertTypes($records);
    }

    public function get($serial = null){
        $records = (new Query())
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->where('datetime > NOW() - INTERVAL ' . $this->days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }
}