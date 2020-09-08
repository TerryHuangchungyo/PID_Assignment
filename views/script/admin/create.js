$(document).ready(function(){
    $("#progress").hide();
    $("#status").hide();

    $("#back").click(function(){
        history.back();
    })
    
    $("#uploadBtn").click(function(event) {
        var file = $("#productImage")[0].files[0];
        var formData = new FormData();
        formData.append("productImage", file);
    
        $.ajax({
            url: '/PID_Assignment/admin/uploadImg',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function( response ){
                console.log(response);
                if( response["success"] ) {
                    $("#status").text(response["msg"]);
                    $("#status").show();
                    $("#imageURI").val(response["fileURI"]);
                    $("#demoImg").prop("src","/PID_Assignment/uploadImg/"+response["fileURI"]);
                } else {
                    $("#status").text(response["msg"]);
                    $("#status").show();
                }
            },
            error: function( response ) {
                alert("系統發生問題");
            }
        });
    });
})

// xhr: function () {
//     var xhr = new window.XMLHttpRequest();
//     xhr.upload.addEventListener("progress",uploadProgressHandler,false);
//     xhr.addEventListener("load", loadHandler, false);
//     xhr.addEventListener("error", errorHandler, false);
//     xhr.addEventListener("abort", abortHandler, false);

//     return xhr;
// }

function uploadProgressHandler(event) {
    // $("#loaded_n_total").html("Uploaded " + event.loaded + " bytes of " + event.total);
    var percent = (event.loaded / event.total) * 100;
    var progress = Math.round(percent);
    $("#status").html("上傳進度:  "+percent+"%");
    $("#progress-bar").css("width", progress + "%");
}

function loadHandler(event) {
    $("#status").html(event.target.responseText);
    $("#progress-bar").css("width", "0%");
}

function errorHandler(event) {
    $("#status").html("上傳失敗");
}

function abortHandler(event) {
    $("#status").html("上傳中斷");
}