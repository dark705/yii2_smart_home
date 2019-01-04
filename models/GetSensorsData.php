<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.12.2018
 * Time: 1:51
 */

namespace app\models;

use Yii;
use yii\base\Model;

class GetSensorsData extends Model
{
    public $days = 10;
    public $sensors;

    public function __get($name){
        $class = $this->sensors[$name];
        $class['days'] = $this->days;
        return Yii::createObject($class);
    }
}