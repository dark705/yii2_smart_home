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
        <?php $lastE = $pzem004t->getLastInfo();?>
        <p id="last__electro__time" class="ontime" >(показания на: <span><?=$lastE['datetime'];?></span>)</p>
        <p id="last__electro__voltage">Напряжение: <span><?=$lastE['voltage'];?></span></p>
        <p id="last__electro__current">Ток: <span><?=$lastE['current'];?></span></p>
        <p id="last__electro__active">Мощность: <span><?=$lastE['active'];?></span></p>
    </div>
</a>
<?php
$this->registerJs(
    "
    function updateLastElectro(){
        $.getJSON('http://192.168.23.2/chart/zero/json/json.php?sensor=pzem004t&last', function(data){
            console.log(data);
            data = data[0];
            var d = new Date((data.datetime - 3*60*60) * 1000);
            data.datetime = d.toString('yyyy-MM-dd HH:mm:ss');
            $('#last__electro__time span').text(data.datetime);
            $('#last__electro__voltage span').text(data.voltage);
            $('#last__electro__current span').text(data.current);
            $('#last__electro__active span').text(data.active);
            $('#last__electro').animate({opacity: 0.1}, 500).animate({opacity: 1.0}, 500)
        });
    }
    setInterval(function(){
		updateLastElectro();
	}, {$intervalUpdateLast}*1000);
    ",
    View::POS_READY
);
?>
