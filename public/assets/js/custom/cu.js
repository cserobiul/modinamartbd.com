$(function (){
    let submitForm = $('#customerAccountDetails');
    $(submitForm).submit(function(e) {
        e.preventDefault();

        formData = $(submitForm).serialize();
        console.log(formData);
        $.ajax({
            url: 'customer-profile-update',
            data: formData,
            type:'post',
            success: function (data){
                if($.isEmptyObject(data.error)){
                    $(".print-success-msg").find("strong").html('');
                    $(".print-success-msg").css('display','block');
                    $(".print-success-msg").find("strong").append(data.success);
                }else{
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display','block');
                    $.each( data.error, function( key, value ) {
                        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                }
            },
        })

    });
});
