$(document).ready(function(){
    var price = parseInt($("#price").text());
    $("input[type='number']").change(function(){
        let total = parseInt($(this).val()) * price;
        $("#total").text(total);
    })
})