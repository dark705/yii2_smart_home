<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */
use miloschuman\highcharts\Highstock;
use yii\web\View;
?>

<a class="itemlink" href="#chart__<?=$sensor['serial']?>">
    <div id="<?=$sensor['serial']?>" class="item last__ds18b20">
        <h3><?=$sensor['name']?></h3>
        <?php $lastD = $ds18b20->getLastInfo($sensor['serial']);?>
        <p class="last__ds18b20__time ontime">(показания на: <span><?=$lastD->datetime;?></span>)</p>
        <p class="last__ds18b20__temp">Температура: <span><?=$lastD->temperature;?></span></p>
    </div>
</a>

