$(document).ready(function(){
    $("a.cancel").click( function (){
        $row = $(this).closest("tr");

        $.ajax({
            type: "delete",
            url: "/PID_Assignment/cart/" + $row.find("th").text()
        }).done(function( response ){
            console.log(response)
            $row.remove();
        });
    });

    $("input[type='number']").change( function(){
        $row = $(this).closest("tr");
        let dataToServer = {
            productId: $row.find("th").text(),
            value: $(this).val()
        };

        $.ajax({
            url: "/PID_Assignment/cart",
            type: "put",
            data: dataToServer
        }).done(function( response ){
            console.log(response)
        });
    });
})