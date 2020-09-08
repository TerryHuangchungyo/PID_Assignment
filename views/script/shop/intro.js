$(document).ready(function(){

    $("#back").click(function(){
        history.back();
    })


    $("a.cart").click(function(){
        let dataToServer = {
            productId: $(this).data("productid"),
            value: 1
        };

        const _this = $(this);
        $.ajax({
            url: "/PID_Assignment/cart",
            type: "put",
            data: dataToServer
        }).done( function( response ){
            console.log(response);
            _this.text("已加入");
            _this.addClass("disabled");
        })
    });
});