$(document).ready(function() {

$('#meses').children().hide();
$('#mensal').children().hide();
$('#submit').children().hide();

$('#select').on('change', function(){
    var selectedValor = $(this).val();
    if(selectedValor == "sim"){
    $('#mensal').children().hide();
    $('#meses').children().show();
    }
});

$('#select').on('change', function(){
    var selectedValor = $(this).val();
    if(selectedValor == " "){
    $('#mensal').children().hide();
    $('#meses').children().hide();
    $('#submit').children().hide();
    }
});

$('#select').on('change', function(){
    var selectedValor = $(this).val();
    if(selectedValor == "nao" || selectedValor == ""){
    $('#mensal').children().show();
    $('#meses').children().hide();
    }
});
});