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
        <?php $lastE = $pzem004t->getLast()[0];?>
        <p id="last__electro__time" class="ontime" >(показания на: <span><?=gmdate("Y-m-d H:i:s", $lastE['datetime']);?></span>)</p>
        <p id="last__electro__voltage">Напряжение: <span><?=$lastE['voltage'];?></span></p>
        <p id="last__electro__current">Ток: <span><?=$lastE['current'];?></span></p>
        <p id="last__electro__active">Мощность: <span><?=$lastE['active'];?></span></p>
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
                last: true
            },
            success: function(data){
                data = data[0];
                //update last section
                var d = new Date((data.datetime - 3*60*60) * 1000);
                $('#last__electro__time span').text(d.toString('yyyy-MM-dd HH:mm:ss'));
                $('#last__electro__voltage span').text(data.voltage);
                $('#last__electro__current span').text(data.current);
                $('#last__electro__active span').text(data.active);
                $('#last__electro').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
                
                //update graph
                var chartPzem004t = $('#pzem004t').highcharts();
                var voltage = [data.datetime * 1000, data.voltage];
                var current = [data.datetime * 1000, data.current];
                var active = [data.datetime * 1000, data.active];		
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
