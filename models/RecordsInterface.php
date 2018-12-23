<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 23.12.2018
 * Time: 13:32
 */
namespace app\models;

interface RecordsInterface{
    public function getLast($serial);
    public function get($serial, $days);
}