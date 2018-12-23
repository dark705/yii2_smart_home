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
    <?php
    echo Highstock::widget([
        'id' => 'ds18b20_' . $sensor['serial'],
        'options' => [
            'chart' => [
                'height' => 400,
            ],
            'rangeSelector' => $rangeSelectorObj,
            'title' => [
                'text' => $sensor['name']
            ],
                'legend' => [
                'enabled' => true,
                'floating' => false,
                'verticalAlign' => 'bottom',
                'useHTML' => true
            ],
            'xAxis' => [
                'type' => 'datetime',
                'ordinal' => false,
            ],
            'yAxis' => [
                'labels' => [
                    'align' => 'right',
                    'x' => -3
                ],
                'title' => [
                    'text' => 'Температура'
                ]
            ],
            'series' => [[
                'name' => 'С° ' . $sensor['name'],
                'type' => 'spline',
                'tooltip' => [
                    'valueDecimals' => 2
                ]
            ]]
        ]
    ]);

    $this->registerJs(
        "
            var chartDs18b20__" . md5($sensor['serial']) . " = $('#ds18b20_" . $sensor['serial'] . "').highcharts();
            chartDs18b20__" . md5($sensor['serial']) . ".showLoading();
            $.getJSON('sensors/json?sensor=ds18b20&serial=" . $sensor['serial']. "', function (data) {
                var temperature = [];
                $.each(data, function(index, value){
					temperature.push([data[index]['datetime'] * 1000, data[index]['temperature']]);
                });    
                chartDs18b20__" . md5($sensor['serial']) . ".series[0].setData(temperature);
                chartDs18b20__" . md5($sensor['serial']) . ".hideLoading();
            });
        ",
        View::POS_READY
    );
    ?>




