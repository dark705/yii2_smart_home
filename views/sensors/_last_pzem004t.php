<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 21.12.2018
 * Time: 2:00
 */

use yii\web\View;

?>
<a class="itemlink" href="#chart__electro">
    <div id="last__electro" class="item">
        <h3>Электросеть:</h3>
        <?php
            $last = $pzem004t->getLast();
            $index = $last['types'];
            $data = $last['data'][0];
        ?>
        <p id="last__electro__time" class="ontime" >(показания на: <span><?=gmdate("Y-m-d H:i:s", $data[$index['datetime']]);?></span>)</p>
        <p id="last__electro__voltage">Напряжение: <span><?=$data[$index['voltage']];?></span></p>
        <p id="last__electro__current">Ток: <span><?=$data[$index['current']];?></span></p>
        <p id="last__electro__active">Мощность: <span><?=$data[$index['active']];?></span></p>
    </div>
</a>
<?php
$this->registerJs(
    "
    function updateLastElectro(){
         $.ajax({  
            method: 'POST',
            data: {
                sensor: 'pzem004t',
                last: true,
                $crfAjaxToken
            },
            success: function(response){
                var data = response.data[0];
                var index = response.types; 
                
                //update last section
                var d = new Date((data[index.datetime] - 3*60*60) * 1000);
                $('#last__electro__time span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                $('#last__electro__voltage span').text(data[index.voltage]);
                $('#last__electro__current span').text(data[index.current]);
                $('#last__electro__active span').text(data[index.active]);
                $('#last__electro').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
                
                //update graph
                var chartPzem004t = $('#pzem004t').highcharts();
                var voltage = [data[index.datetime] * 1000, data[index.voltage]];
                var current = [data[index.datetime] * 1000, data[index.current]];
                var active = [data[index.datetime] * 1000, data[index.active]];		
                chartPzem004t.series[0].addPoint(voltage, false, true);
                chartPzem004t.series[1].addPoint(current, false, true);
                chartPzem004t.series[2].addPoint(active, false, true);
                chartPzem004t.redraw();   
            }
         });
    }
    setInterval(function(){
		updateLastElectro();
	}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>
