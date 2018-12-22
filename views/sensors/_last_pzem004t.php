<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */
?>
<a class="itemlink" href="#chart__electro">
    <div id="last__electro" class="item">
        <h3>Электросеть:</h3>
        <?php $lastE = $pzem004t->getLastInfo();?>
        <p id="last__electro__time" class="ontime" >(показания на: <span><?=$lastE->datetime;?></span>)</p>
        <p id="last__electro__voltage">Напряжение: <span><?=$lastE->voltage;?></span></p>
        <p id="last__electro__current">Ток: <span><?=$lastE->current;?></span></p>
        <p id="last__electro__active">Мощность: <span><?=$lastE->active;?></span></p>
    </div>
</a>
