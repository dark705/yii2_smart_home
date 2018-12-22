<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 22.12.2018
 * Time: 1:08
 */

namespace app\models;
use yii\db\ActiveRecord;

class SensorPzem004t extends ActiveRecord
{

    public static function tableName(){
        return 'pzem004t';
    }

    public function getLastInfo(){
        return static::find('datetime voltage current active')->orderBy('datetime DESC')->limit(1)->one();
    }
}