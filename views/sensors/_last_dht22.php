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
        <?php $lastW = $dht22->getLastInfo();?>
        <p id="last__weather__time" class="ontime">(показания на: <span><?=$lastW->datetime?></span>)</p>
        <p id="last__weather__temp">Температура: <span><?=$lastW->temperature?></span></p>
        <p id="last__weather__humidity">Влажность: <span><?=$lastW->humidity?></span></p>
    </div>
</a>
<?php
$this->registerJs(
    "
	function updateLastWeather(){
		$.getJSON('http://192.168.23.2/chart/zero/json/json.php?sensor=dht22&last', function(data){
			data = data[0];
			var d = new Date((data.datetime - 3*60*60) * 1000);
			data.datetime = d.toString('yyyy-MM-dd HH:mm:ss');
			$('#last__weather__time span').text(data.datetime);
			$('#last__weather__temp span').text(data.temperature);
			$('#last__weather__humidity span').text(data.humidity);
			$('#last__weather').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
		});
	}
	setInterval(function(){
			updateLastWeather();
	}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>