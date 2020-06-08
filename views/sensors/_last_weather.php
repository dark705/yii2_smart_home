<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */

use app\models\RecordsBmp280;
use app\models\RecordsDht22;
use yii\web\View;

?>
    <a class="itemlink" href="#chart__weather">
        <div id="last__weather" class="item ">
            <h3>Погода:</h3>
            <?php
            /* @var $dht22 RecordsDht22 */
            $lastDht22  = $dht22->getLast();
            $indexDht22 = $lastDht22['types'];
            $dataDht22  = $lastDht22['data'][0];

            /* @var $bmp280 RecordsBmp280 */
            $lastBmp280  = $bmp280->getLast();
            $indexBmp280 = $lastBmp280['types'];
            $dataBmp280  = $lastBmp280['data'][0];
            ?>
            <p id="last__weather__time__dht22" class="ontime">(показания на:
                <span><?= gmdate("Y-m-d H:i:s", $dataDht22[$indexDht22['datetime']]) ?></span>)
            </p>
            <p id="last__weather__temp">Температура: <span><?= $dataDht22[$indexDht22['temperature']] ?></span></p>
            <p id="last__weather__humidity">Влажность: <span><?= $dataDht22[$indexDht22['humidity']] ?></span></p>

            <p id="last__weather__time__bmp280" class="ontime">(показания на:
                <span><?= gmdate("Y-m-d H:i:s", $dataBmp280[$indexBmp280['datetime']]) ?></span>)
            </p>
            <p id="last__weather__pressure">Давление: <span><?= $dataBmp280[$indexBmp280['pressure']] ?></span></p>
        </div>
    </a>
<?php
$this->registerJs(
    "
	function updateLastWeatherDht22(){
         $.ajax({  
            method: 'POST',
            data: {
                sensor: 'dht22',
                last: true,
                $crfAjaxToken
            },
            success: function(response){
                var data = response.data[0];
                var index = response.types;
                   
                //update last section
                var d = new Date((data[index.datetime] - 3*60*60) * 1000);
                $('#last__weather__time__dht22 span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                $('#last__weather__temp span').text(data[index.temperature]);
                $('#last__weather__humidity span').text(data[index.humidity]);
                $('#last__weather').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500);
                
                //update graph
                var chart = $('#weather').highcharts();
                var temperature = [data[index.datetime] * 1000, data[index.temperature]];
                var humidity = [data[index.datetime] * 1000, data[index.humidity]];	
                chart.series[0].addPoint(temperature, false, true);
                chart.series[1].addPoint(humidity, false, true);
                chart.redraw();   
            }
         });
	}
	
		function updateLastWeatherBmp280(){
         $.ajax({  
            method: 'POST',
            data: {
                sensor: 'bmp280',
                last: true,
                $crfAjaxToken
            },
            success: function(response){
                var data = response.data[0];
                var index = response.types;
                   
                //update last section pressure
                var d = new Date((data[index.datetime] - 3*60*60) * 1000);
                $('#last__weather__time__bmp280 span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                $('#last__weather__pressure span').text(data[index.pressure]);
                $('#last__weather').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500);
                
                //update graph
                var chart = $('#weather').highcharts();
                var pressure = [data[index.datetime] * 1000, data[index.pressure]];	
                chart.series[2].addPoint(pressure, false, true);
                chart.redraw();
            }
         });
	}
	
	setInterval(function(){
			updateLastWeatherDht22();
	}, {$intervalUpdateLast}*1000);
	
	setInterval(function(){
			updateLastWeatherBmp280();
	}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>