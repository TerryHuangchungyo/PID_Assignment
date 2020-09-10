var formElement = new Set();

$(document).ready(function(){
    $("#changePasswordSuccess").hide();
    
    $("#v-order-tab").click( function() {

    });

    /* user setting panel */
    $("#v-setting-tab").click( function() {
        $("#settingSuccess").hide();
        $(".setting div:nth-child(2) span").show();
        $(".setting div:nth-child(2) input").hide();
        $(`.setting div:nth-child(3) button.modify`).show();
        $(".setting div:nth-child(3) button.cancel").hide();
        formElement.clear();
    });

    $(".setting div:nth-child(3) button.modify").click( function(){
        let index = $(".setting").index($(this).closest( ".setting" ));
        let input = $(`.setting:eq(${index}) div:nth-child(2) input`);
        let span = $(`.setting:eq(${index}) div:nth-child(2) span`);
        let modifyBtn = $(`.setting:eq(${index}) div:nth-child(3) button.modify`);
        let cancelBtn = $(`.setting:eq(${index}) div:nth-child(3) button.cancel`);

        formElement.add( input.prop("name") );
        input.show();
        span.hide();
        modifyBtn.hide();
        cancelBtn.show();
    });

    $(".setting div:nth-child(3) button.cancel").click( function(){
        let index = $(".setting").index($(this).closest( ".setting" ));
        let input = $(`.setting:eq(${index}) div:nth-child(2) input`);
        let span = $(`.setting:eq(${index}) div:nth-child(2) span`);
        let modifyBtn = $(`.setting:eq(${index}) div:nth-child(3) button.modify`);
        let cancelBtn = $(`.setting:eq(${index}) div:nth-child(3) button.cancel`);

        formElement.delete( input.prop("name") );
        input.hide();
        span.show();
        input.val( span.text() );
        modifyBtn.show();
        cancelBtn.hide();
    });

    $("#settingSubmit").click( function() {
        if( formElement.size > 0 ) {
            let dataToServer = {};

            for( let field of formElement ) {
                dataToServer[field] = $(`.setting input[name='${field}']`).val();
            }

            $.ajax({
                url: "/PID_Assignment/shop/setting",
                type: "post",
                data: dataToServer,
            }).done(function( response ){
                console.log(response);
                // if( response["success"] ) {
                //     $("#settingSuccess").show();
                // } else {
                // }
            })
        }
    })

    /* change password panel */
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