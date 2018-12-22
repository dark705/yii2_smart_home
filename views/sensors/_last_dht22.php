<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */
?>
<a class="itemlink" href="#chart__weather">
    <div id="last__weather" class="item ">
        <h3>Погода:</h3>
        <?php $lastW = $dht22->getLastInfo();?>
        <p id="last__weather__time" class="ontime">(показания на: <span><?=$lastW->datetime?></span>)</p>
        <p id="last__weather__temp">Температура: <span><?=$lastW->temperature?></span></p>
        <p id="last__weather__humidity">Влажность: <span><?=$lastW->humidity?></span></p>
    </div>
</a>
