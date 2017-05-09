$(document).ready(function () {
    //button to top
    $('body').materialScrollTop({
        duration: 600,
        easing: 'swing'
    });

    //init element
    $('input#input_text, textarea').characterCounter();
    $('.modal').modal();
    $('select').material_select();


    // click modal
    $(".register-instead").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('close');
        $("#registerModal").modal('open');

    });
    $(".login-instead").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('open');
        $("#registerModal").modal('close');

    });
    $(".forgot-password").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('close');
        $("#forgotPasswordModal").modal('open');

    });


    //submit form register
    $("#register-button").on("click", function (e) {

        e.preventDefault();

        var email = $("#register-form").find("input[id='email']").val();
        var password = $("#register-form").find("input[id='password']").val();
        var confirm = $("#register-form").find("input[id='confirm_password']").val();
        
        if (password !== confirm) {

            $("p#password-error").html("Password do not match. Try again !").addClass("red-text");
            $("#register-form").find("input[id='password']").select();

        } else {

            $.ajax({
                url: 'check.php',
                type: 'POST',
                data: {
                    email: email
                },
                success: function (data) {
                    if (data.trim() === 'ok') {
                        $("#register-form").submit();
                    } else {
                        $("p#email-error").html("Email has already been taken !").addClass("red-text");
                        $("p#password-error").hide();
                        $("input[id='email']").select();
                    }
                },
                error: function () {
                    Materialize.toast('An error has occured. Sorry for inconvenience :(', 4000);
                }
            });

        }

    });
    
    
    
    // validate form login
    $("#login-button").on("click", function (e) {

        e.preventDefault();

        

    });
});