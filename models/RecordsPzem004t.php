<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsPzem004t implements RecordsInterface
{

    private static function convertTypes($records){
        \Yii::beginProfile('convert_types_pzem', __METHOD__);
        foreach ($records as $key => $record){
            $convertedRecord = [
                'datetime' => strtotime($record['datetime']),
                'voltage' => (float)$record['voltage'],
                'current' => (float)$record['current'],
                'active' => (float)$record['active']
                ];
            $records[$key] = $convertedRecord;
        }
        \Yii::endProfile('convert_types_pzem');
        return $records;
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

    public function get($serial = null, $days = 10){
        $records = (new Query())
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->where('datetime > NOW() - INTERVAL ' . $days . ' DAY')
            ->all();
        return static::convertTypes($records);
    }
}