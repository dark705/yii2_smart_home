<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */

use yii\web\View;

?>
<a class="itemlink" href="#chart__<?=$sensor['serial']?>">
    <div id="<?=$sensor['serial']?>" class="item last__ds18b20">
        <h3><?=$sensor['name']?></h3>
        <?php $lastD = $ds18b20->getLastInfo($sensor['serial']);?>
        <p class="last__ds18b20__time ontime">(показания на: <span><?=$lastD->datetime;?></span>)</p>
        <p class="last__ds18b20__temp">Температура: <span><?=$lastD->temperature;?></span></p>
    </div>
</a>
<?php
$this->registerJs(
    "
	function updateLastDs18b20(){
		$(\".last__ds18b20\").each(function(index, thisEl){
			var serial = $(this).attr('id');
			$.getJSON('http://192.168.23.2/chart/zero/json/json.php?sensor=ds18b20&serial=' + serial +'&last', function(data){
				data = data[0];
				var d = new Date((data.datetime - 3*60*60) * 1000);
				data.datetime = d.toString('yyyy-MM-dd HH:mm:ss');
				$(thisEl).find('.last__ds18b20__time span').text(data.datetime);
				$(thisEl).find('.last__ds18b20__temp span').text(data.temperature);
				$('#' + serial).animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
			});
		});
	}
	setInterval(function(){
			updateLastDs18b20();
		}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>
