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
    $intervalUpdateLast = 60;
    $crfAjaxToken = Yii::$app->request->csrfParam . ': \'' . Yii::$app->request->csrfToken . '\'';

?>

<div class="container-fluid .overflow-hide">
    <!-- start last section -->
    <div id="lasts">
        <!-- start electro last section -->
        <div class="last">
            <?=$this->render('_last_pzem004t', compact(['pzem004t', 'intervalUpdateLast', 'crfAjaxToken']));?>
        </div>
        <!-- end -->
        <!-- start weather last section -->
        <div class="last">
            <?=$this->render('_last_dht22', compact(['dht22', 'intervalUpdateLast', 'crfAjaxToken']));?>
        </div>
        <!-- end -->
        <!-- start ds18b20 last section -->
        <?php foreach($ds18b20->getAllSensorsNames() as $sensor):?>
        <div class="last">
            <?=$this->render('_last_ds18b20', compact(['ds18b20', 'sensor', 'intervalUpdateLast', 'crfAjaxToken']));?>
        </div>
        <?php endforeach;?>
        <!-- end -->
        <div class="clear"></div>
    </div>
    <!-- end -->

    <!-- start charts section -->
    <div class="chart">
        <a name="chart__electro"></a>
        <?=$this->render('_pzem004t', compact(['rangeSelectorObj', 'crfAjaxToken']));?>
    </div>

    <div class="chart">
        <a name="chart__weather"></a>
        <?=$this->render('_dht22',  compact(['rangeSelectorObj', 'crfAjaxToken']));?>
    </div>

    <?foreach($ds18b20->getAllSensorsNames() as $sensor):?>
        <div class="chart">
            <a name="chart__<?=$sensor['serial']?>"></a>
            <?=$this->render('_ds18b20',  compact(['rangeSelectorObj', 'sensor', 'crfAjaxToken']));?>
        </div>
    <?endforeach;?>
    <!-- end -->
</div>





