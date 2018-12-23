<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\Query;

class RecordsPzem004t extends Query
{

    public function getLastInfo(){
        return (new Query())
            ->select(['datetime', 'voltage', 'current', 'active'])
            ->from('pzem004t')
            ->orderBy('datetime DESC')
            ->limit(1)
            ->one();
    }

    public function get(){
        return (new Query())->select(['datetime', 'voltage', 'current', 'active'])->from('pzem004t')->where('datetime > NOW() - INTERVAL 10 DAY')->all();
    }
}