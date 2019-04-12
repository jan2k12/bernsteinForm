var $ = require('jquery');

$(document).ready(function () {
     $('.make_inactive').click(function () {
        $.ajax({
            method: 'POST',
            url: $(this).data('path'),
            data: {'id':$(this).val()}
        }).done(function(response){
            alert(response);
        })

    });

    $('.open_turnier').click(function () {
          window.location.href=$(this).data('path');

    });

    $('.pathButton').click(function(){
        window.location.href=$(this).data('path');
    });

    $('.pathButtonAndRefresh').click(function(){
        $.ajax({
            method: 'POST',
            url: $(this).data('path'),
            data: {'id':$(this).val()}
        }).done(function(response){
            window.location.reload();
        })
    });

     $('.agb').html('ich akzeptiere die <a href="https://bernsteineagles.de/datenschutz/" target="_new">Datenschutz Richtlinien</a>');
});