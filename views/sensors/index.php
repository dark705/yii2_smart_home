<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */
?>
<h1>Показания датчиков</h1>

<?php
    $rangeSelectorObj = [
        'selected' => 3,
        'buttons' => [
            ['type' => 'minute', 'count' => 10, 'text' => '10м'],
            ['type' => 'hour', 'count' => 1, 'text' => '1час'],
            ['type' => 'hour','count' => 6, 'text' => '6час'],
            ['type' => 'day', 'count' => 1,  'text' => '1дн'],
            ['type' => 'week', 'count' => 1, 'text' => 'нед'],
            ['type' => 'month', 'count' => 1, 'text' => 'мес']
        ]
    ];
    $intervalUpdateLast = 20;
?>

<div class="container-fluid .overflow-hide">
    <div id="lasts">
        <div class="last">
            <?=$this->render('_last_pzem004t', compact(['pzem004t', 'intervalUpdateLast']));?>
        </div>

        <div class="last">
            <?=$this->render('_last_dht22', compact(['dht22', 'intervalUpdateLast']));?>
        </div>

        <?php foreach($ds18b20->getAllSensorsInfo() as $sensor):?>
        <div class="last">
            <?=$this->render('_last_ds18b20', compact(['ds18b20', 'sensor', 'intervalUpdateLast']));?>
        </div>
        <?php endforeach;?>
        <div class="clear"></div>
    </div>

    <div class="chart">
        <a name="chart__electro"></a>
        <?=$this->render('_pzem004t', compact('rangeSelectorObj'));?>
    </div>

    <div class="chart">
        <a name="chart__weather"></a>
        <?=$this->render('_dht22',  compact('rangeSelectorObj'));?>
    </div>

    <?foreach($ds18b20->getAllSensorsInfo() as $sensor):?>
        <div class="chart">
            <a name="chart__<?=$sensor['serial']?>"></a>
            <?=$this->render('_ds18b20',  compact(['rangeSelectorObj','sensor']));?>
        </div>
    <?endforeach;?>
</div>





