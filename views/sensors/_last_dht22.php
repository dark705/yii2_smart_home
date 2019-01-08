<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */

use yii\web\View;

?>
<a class="itemlink" href="#chart__weather">
    <div id="last__weather" class="item ">
        <h3>Погода:</h3>
        <?php
        $last = $dht22->getLast();
        $index = $last['types'];
        $data = $last['data'][0];
        ?>
        <p id="last__weather__time" class="ontime">(показания на: <span><?=gmdate("Y-m-d H:i:s", $data[$index['datetime']])?></span>)</p>
        <p id="last__weather__temp">Температура: <span><?=$data[$index['temperature']]?></span></p>
        <p id="last__weather__humidity">Влажность: <span><?=$data[$index['humidity']]?></span></p>
    </div>
</a>
<?php
$this->registerJs(
    "
	function updateLastWeather(){
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
                $('#last__weather__time span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                $('#last__weather__temp span').text(data[index.temperature]);
                $('#last__weather__humidity span').text(data[index.humidity]);
                $('#last__weather').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500);
                
                //update graph
                var chartDht22 = $('#dht22').highcharts();
                var temperature = [data[index.datetime] * 1000, data[index.temperature]];
                var humidity = [data[index.datetime] * 1000, data[index.humidity]];	
                chartDht22.series[0].addPoint(temperature, false, true);
                chartDht22.series[1].addPoint(humidity, false, true);
                chartDht22.redraw();   
            }
         });
	}
	
	setInterval(function(){
			updateLastWeather();
	}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>