$(document).ready(function(){
    $("#changePasswordSuccess").hide();

    $("#v-order-tab").click( function() {

    });

    $("#v-setting-tab").click( function() {

    });

    $("#v-changePassword-tab").click( function() {
        $("#changePasswordSuccess").hide();
    });

    $("#changePasswordSubmit").click( function(){
        let dataToServer = { 
            "changedPassword": $( "#changedPassword" ).val(),
            "changedPasswordCheck" : $( "#changedPasswordCheck" ).val(),
            "password" : $( "#password" ).val(),
            "passwordCheck" : $("#passwordCheck" ).val()
        }

        $.ajax({
            url: "/PID_Assignment/shop/changePassword",
            type: "post",
            data: dataToServer,
            beforeSend: function() {
                refreshPasswordForm();
            }
        }).done(function( response ){
            if( response["success"] ) {
                $("#changePasswordSuccess").show();
            } else {
                for( let field in response ) {
                    $("#"+field).addClass("is-invalid");
                    $("#"+field+"Feedback").text( response[field] );
                }
            }
        })
    });
})

function refreshPasswordForm() {
    $("#changePasswordSuccess").hide();
    $("#changedPassword").val("").removeClass("is-invalid");
    $("#changedPasswordCheck").val("").removeClass("is-invalid");
    $("#password").val("").removeClass("is-invalid");
    $("#passwordCheck").val("").removeClass("is-invalid");
}