$(document).ready(function(){
    $("a.cancel").click( function (){
        $row = $(this).closest("tr");

        $.ajax({
            type: "delete",
            url: "/PID_Assignment/cart/" + $row.find("th").text()
        }).done(function( response ){
            data = JSON.parse(response);
            $("#cartCount").text( data["count"]);
            if( data["count"] == 0 ) 
                $("#confirmBtn").hide();
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