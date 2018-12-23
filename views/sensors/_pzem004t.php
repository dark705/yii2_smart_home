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
        'id' => 'pzem004t',
        'scripts' => [
            'lang/ru',
            'modules/exporting',
            'themes/grid-light',

        ],
        'options' => [
                'chart' => [
                    'height' => 800,
                ],
                'rangeSelector' => $rangeSelectorObj,
                'title' => [
                        'text' => 'Электросеть'
                ],
                'legend' => [
                        'enabled' => true,
                        'floating' => false,
                        'verticalAlign' => 'bottom',
                        'useHTML' => true
                ],
                'xAxis' => [
                        'type'=> 'datetime',
                        'ordinal'=> false
                ],
                'yAxis' => [
                    [
                        'labels' => [
                            'align' => 'right',
                            'x' => -3
                        ],
                        'title' => [
                            'text' => 'Напряжение'
                        ],
                        'height' => '50%',
                        'lineWidth' => 1,
                        'resize' => [
                            'enabled' => true
                        ]
                    ], [
                        'labels'=> [
                            'align' => 'right',
                            'x' => -3
                        ],
                        'title' => [
                            'text' => 'Ток'
                        ],
                        'top' => '52%',
                        'height' => '20%',
                        'offset' => 0,
                        'lineWidth' => 1
                    ], [
                        'labels' => [
                            'align' => 'right',
                            'x' => -3
                        ],
                        'title' => [
                            'text' => 'Мощьность'
                        ],
                        'top' => '75%',
                        'height' => '20%',
                        'offset' => 0,
                        'lineWidth' => 1
                    ]

                ],
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
                'series' =>  [
                        [
                            'type' =>  'spline',
                            'name' =>  'Вольт',
                            'yAxis' =>  0
                        ], [
                            'type' =>  'spline',
                            'name' =>  'Ампер',
                            'yAxis' =>  1
                        ], [
                            'type' =>  'spline',
                            'name' =>  'Ватт',
                            'yAxis' =>  2
                        ]
                ]
        ]
    ]);
    $this->registerJs(
        "
            var w1 = $('#pzem004t').highcharts();
            w1.showLoading();
            console.time('t1');
            console.time('t2');
            console.time('t3');
            console.time('t4');
            console.log('begin');
            console.timeEnd('t1');
             $.getJSON('sensors/json?sensor=pzem004t', function (data) {
             console.log('start loading');
             console.timeEnd('t2');
                var voltage = [], current = [], active = [];
                $.each(data, function(index, value){
					voltage.push([value.datetime * 1000, value.voltage]);
					current.push([value.datetime * 1000, value.current]);
					active.push([value.datetime * 1000, value.active]);
                });
                console.log('array ready');
                console.timeEnd('t3');
                w1.series[0].setData(voltage, false);
                w1.series[1].setData(current, false);
                w1.series[2].setData(active, true);
                w1.hideLoading();
                console.log('complete set data');
                console.timeEnd('t4');
           });
        ",
        View::POS_READY
    );
    ?>



