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
        'id' => 'weather',
        'options' => [
            'chart' => [
                'height' => 700,
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
                'height' => '40%',
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
                'top' => '43%',
                'height' => '28%',
                'offset' => 0,
                'lineWidth' => 1
            ],[
                'labels' => [
                    'align' => 'right',
                    'x' => -3
                ],
                'title' => [
                    'text' => 'Давление'
                ],
                'top' => '75%',
                'height' => '28%',
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
            ], [
                'type' => 'spline',
                'name' => 'мм',
                'yAxis' => 2
            ]]
        ]

    ]);
    $this->registerJs(
        "
            var chartWeather = $('#weather').highcharts();
            chartWeather.showLoading();
            $.ajax({  
                method: 'POST',
                data: {
                    sensor: 'dht22',
                    $crfAjaxToken
                },
                success: function(response){
                var temperature = [], humidity = [];
                 var index = response.types; 
                	$.each(response.data, function(i, data){
                        temperature.push([data[index.datetime] * 1000, data[index.temperature]]);
                        humidity.push([data[index.datetime] * 1000, data[index.humidity]]);	
                    });
                    chartWeather.series[0].setData(temperature, false);
                    chartWeather.series[1].setData(humidity, true);
                    chartWeather.hideLoading();
                }
            });
            
            $.ajax({  
                method: 'POST',
                data: {
                    sensor: 'bmp280',
                    $crfAjaxToken
                },
                success: function(response){
                var pressure = []
                 var index = response.types; 
                	$.each(response.data, function(i, data){
                        pressure.push([data[index.datetime] * 1000, data[index.pressure]]);
                    });
                    chartWeather.series[2].setData(pressure, true);
                    chartWeather.hideLoading();
                }
            });
        ",
        View::POS_READY
    );
    ?>



