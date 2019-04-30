"use strict";
$(function(){
    //действуем только после загрузки DOM
    //получать статус будем через ajax для того чтобы не задерживать загрузку страницы
    updateInternetStatus();
    updateInternetStatusThroughGw();
    //регулярно обновляя статус
    setInterval(updateInternetStatusThroughGw, 5000);
    setInterval(updateInternetStatus, 5000);

    var gwDefault = $('#form_channge_gw input:radio:checked').val(); //ip gw при загрузки страницы
    $('#form_channge_gw').submit(function(e){
        e.preventDefault();//отмена действия браузера по умолчанию
        var gwNew = $('#form_channge_gw input:radio:checked').val(); //ip gw на момент отправки

        if (gwDefault == gwNew) {
            //если ip выбранного == ip начального
            showMessage('Не было изменений.');
        } else {
            $.post('', {'setIP': gwNew}, function(reply){
                if (reply == gwNew){ //провайдер успешно изменён
                    showMessage('Провайдер успешно изменён.');
                    gwDefault = gwNew; //обновляем значение ip gw
                } else {//если что-то пошло не так, говорим,
                    showMessage('Ошибка смены провайдера'); //и переводим переключатель на последнее успешное положение
                    $('#form_channge_gw input:radio[value="'+ gwDefault +'"]').prop('checked', true);;
                }
                updateInternetStatus(); //при любой отправке обновляем статус
            });
        }
    });

    function updateInternetStatus(){
        $.post('', {'checkInternet' : true}, function (reply) {
            switch(reply){
                case 'online':
                    $('#internetStatus span.loading').hide();
                    $('#internetStatus span.online').show();
                    $('#internetStatus span.offline').hide();
                    break;
                case 'offline':
                    $('#internetStatus span.loading').hide();
                    $('#internetStatus span.online').hide();
                    $('#internetStatus span.offline').show();
                    break;
                default:
                    $('#internetStatus span.loading').show();
                    $('#internetStatus span.online').hide();
                    $('#internetStatus span.offline').hide();
                    break;
            }
        });
    }

    function updateInternetStatusThroughGw(){
        //выполняем для всех шлюзов
        $('#form_channge_gw input[name="gw"]').each(function(){
            var ip = $(this).val();
            $.post('', {'checkInternetThroughGw': ip}, function (reply) {
                switch(reply){
                    case 'online':
                        $('#form_channge_gw label[for="'+ ip +'"] span.loading').hide(); //Скрываем сообщение о загрузки статуса
                        $('#form_channge_gw label[for="'+ ip +'"] span.online').show();
                        $('#form_channge_gw label[for="'+ ip +'"] span.offline').hide();
                        break;
                    case 'offline':
                        $('#form_channge_gw label[for="'+ ip +'"] span.loading').hide();
                        $('#form_channge_gw label[for="'+ ip +'"] span.online').hide();
                        $('#form_channge_gw label[for="'+ ip +'"] span.offline').show();
                        break;
                    default:
                        $('#form_channge_gw label[for="'+ ip +'"] span.loading').show(); //если что-то пошло не так
                        $('#form_channge_gw label[for="'+ ip +'"] span.online').hide();
                        $('#form_channge_gw label[for="'+ ip +'"] span.offline').hide();
                        break;
                }
            });
        });
    }

    function showMessage(message) {
        $('.popup__text').html(message);
        $('#popup').fadeIn(300).delay(1700).fadeOut(300);
    }
});