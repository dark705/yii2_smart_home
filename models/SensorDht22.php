<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class SensorDht22 extends ActiveRecord
{


    public static function tableName(){
        return 'dht22';
    }

    public function getLastInfo(){
        return static::find('datetime temperature humidity')->orderBy('datetime DESC')->limit(1)->one();
    }
}