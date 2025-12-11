// JavaScript Document
 function quantityWidget(){
    var currval;
    $(".less").click(function(){
        currval = parseInt($(this).parent().find("input").val());
        if (currval > 0){
        $(this).parent().find("input").val((currval-1));
        }
    });
    $(".more").click(function(){
        currval = parseInt($(this).parent().find("input").val());   
        $(this).parent().find("input").val((currval+1));
    });
 
    $(".quantity-widget input").keyup(function(){
        currval = $(this).val();
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        if(isNaN(currval)) {
            alert("Inserire solo numeri");
            $(this).val(1);
        }
    });
}
 
$(function(){
    quantityWidget();
});