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
        <?php
        $last = $ds18b20->getLast($sensor['serial']);
        $index = $last['types'];
        $data = $last['data'][0];
        ?>
        <p class="last__ds18b20__time ontime">(показания на: <span><?=gmdate("Y-m-d H:i:s", $data[$index['datetime']]);?></span>)</p>
        <p class="last__ds18b20__temp">Температура: <span><?=$data[$index['temperature']];?></span></p>
    </div>
</a>
<?php
/*TODO
    Переделать JS?
*/

$this->registerJs(
    "
	function updateLastDs18b20(){
		$('.last__ds18b20').each(function(index, thisEl){
			var serial = $(this).attr('id');
		    $.ajax({  
                method: 'POST',
                data: {
                    sensor: 'ds18b20',
                    serial: serial,
                    last: true,
                    $crfAjaxToken
                },
                success: function(response){
                    var data = response.data[0];
                    var index = response.types;
            
                    //update last section
                    var d = new Date((data[index.datetime] - 3*60*60) * 1000);
                    $(thisEl).find('.last__ds18b20__time span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                    $(thisEl).find('.last__ds18b20__temp span').text(data[index.temperature]);
                    $('#' + serial).animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
                    
                    //update graph
                    var chartDs18b20__item = $('#ds18b20_' + serial).highcharts();
                    var temperature = [data[index.datetime] * 1000, data[index.temperature]]; 
                    chartDs18b20__item.series[0].addPoint(temperature, false, true);
                    chartDs18b20__item.redraw();
                }
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
