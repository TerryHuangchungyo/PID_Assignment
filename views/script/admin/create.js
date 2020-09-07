$(document).ready(function(){
    $("#progress").hide();
    $("#status").hide();

    $("#uploadBtn").click(function(event) {
        event.preventDefault();
        var file = $("input[name='productImage']")[0].files[0];
        var formData = new FormData();
        formData.append("productImage", file);
    
        $.ajax({
            url: '/PID_Assignment/admin/upload',
            method: 'POST',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            sucess: function(){

            },
            
            beforesend: function(){
                $("#progress").show();
                $("#status").show();
            },
            complete: function(){
                $("#progress").hide();
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress",uploadProgressHandler,false);
                xhr.addEventListener("load", loadHandler, false);
                xhr.addEventListener("error", errorHandler, false);
                xhr.addEventListener("abort", abortHandler, false);
    
                return xhr;
            }
        });
    });
})

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