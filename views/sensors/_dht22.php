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
        'id' => 'dht22',
        'options' => [
            'chart' => [
                'height' => 500,
            ],
            'rangeSelector' => $rangeSelectorObj,

            'title' => [
                'text' => 'Погода'
            ],

            'legend' => [
                'enabled' => true,
                'floating' => false,
                'verticalAlign' => 'bottom',
                'useHTML' => true
            ],

            'xAxis' => [
                'type' => 'datetime',
                'ordinal' => false
            ],

            'yAxis' => [[
                'labels' => [
                    'align' => 'right',
                    'x' => -3
                ],
                'title' => [
                    'text' => 'Температура'
                ],
                'height' => '60%',
                'lineWidth' => 1,
                'resize' => [
                    'enabled' => true
                ]
            ], [
                'labels' => [
                    'align' => 'right',
                    'x' => -3
                ],
                'title' => [
                    'text' => 'Влажность'
                ],
                'top' => '65%',
                'height' => '30%',
                'offset' => 0,
                'lineWidth' => 1
            ]],

            'plotOptions' => [
                'spline' => [
                    'marker' => [
                        'enabled' => true
                    ]
                ]
            ],

            'tooltip' => [
                'split' => true
            ],

            'series' => [[
                'type' => 'spline',
                'name' => 'С°',
                'yAxis' => 0
            ], [
                'type' => 'spline',
                'name' => '%',
                'yAxis' => 1
            ]]
        ]

    ]);
    $this->registerJs(
        "
            var chartDht22 = $('#dht22').highcharts();
            chartDht22.showLoading();
            $.ajax( 
            {  
                method: 'POST',
                url: 'sensors',
                data: {
                    sensor: 'dht22'
                },
                success: function(data){
                var temperature = [], humidity = [];
                	$.each(data, function(index, value){
                        temperature.push([value.datetime * 1000, value.temperature]);
                        humidity.push([value.datetime * 1000, value.humidity]);	
                    });
                    chartDht22.series[0].setData(temperature, false);
                    chartDht22.series[1].setData(humidity, true);
                    chartDht22.hideLoading();
                }
            });
        ",
        View::POS_READY
    );
    ?>



