<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsDht22 extends Query implements RecordsInterface
{
    public function getLast($serial = null){
        return (new Query())
            ->select(['datetime', 'temperature', 'humidity'])
            ->from('dht22')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->one();
    }

    public function get($serial = null){
        return (new Query())
            ->select(['datetime', 'temperature', 'humidity'])
            ->from('dht22')
            ->where('datetime > NOW() - INTERVAL 10 DAY')
            ->all();
    }
}