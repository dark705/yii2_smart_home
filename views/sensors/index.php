<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */

use yii\web\View;

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
    ]


?>
<div class="chart">
    <a name="chart__electro"></a>
    <?=$this->render('_pzem004t', compact('rangeSelectorObj'));?>
</div>
<div class="chart">
    <a name="chart__dht22"></a>
    <?=$this->render('_dht22',  compact('rangeSelectorObj'));?>
</div>



