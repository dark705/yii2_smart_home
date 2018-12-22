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

class SensorDs18b20 extends ActiveRecord
{

    private static $sensorsInfo;

    public static function tableName(){
        return 'ds18b20';
    }
    
    public function getAllSensorsInfo(){
        if (!static::$sensorsInfo){
            $subQuery = (new Query())
                ->select('serial')
                ->from('ds18b20')
                ->distinct();

            static::$sensorsInfo =  (new Query())->select('distinct.serial, ds18b20_names.name')
                ->from('ds18b20_names')
                ->rightJoin(['distinct' => $subQuery], 'distinct.serial = ds18b20_names.serial')
                ->all();
            return   static::$sensorsInfo;
        } else {
            return   static::$sensorsInfo;
        }
    }

    public function getLastInfo($serial){
        return static::find()->where(['serial' => $serial])->orderBy('datetime DESC')->limit(1)->one();
    }
}