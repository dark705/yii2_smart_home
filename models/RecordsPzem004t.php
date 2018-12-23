<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsPzem004t extends Query implements RecordsInterface
{

    public function getLast($serial = null){
        return (new Query())
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->one();
    }

    public function get($serial = null, $days = 10){
        return (new Query())
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->where('datetime > NOW() - INTERVAL ' . $days . ' DAY')
            ->all();
    }
}