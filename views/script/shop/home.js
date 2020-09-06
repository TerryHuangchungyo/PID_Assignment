$(document).ready(function(){
    $("a.cart").click(function(){
        let dataToServer = {
            productId: $(this).data("productid")
        };

        const _this = $(this);
        $.ajax({
            url: "/PID_Assignment/cart",
            type: "post",
            data: dataToServer
        }).done( function(){
            _this.text("已加入");
            _this.addClass("disabled");
        })
    });
});