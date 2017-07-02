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
    $(".dropdown-button").dropdown({
        hover: true
    });
    $(".spinner").hide();


    // click modal
    $(".register-instead").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('close');
        $("#forgotPasswordModal").modal('close');
        $("#registerModal").modal('open');

    });
    $(".login-instead").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('open');
        $("#registerModal").modal('close');
        $("#forgotPasswordModal").modal('close');

    });
    $(".forgot-password").on("click", function (e) {

        e.preventDefault();

        $("#loginModal").modal('close');
        $("#registerModal").modal('close');
        $("#forgotPasswordModal").modal('open');

    });


    //submit form register
    $("#register-button").on("click", function (e) {

        e.preventDefault();

        var name = $("#register-form").find("input[id='name']").val();
        var email = $("#register-form").find("input[id='email']").val();
        var password = $("#register-form").find("input[id='password']").val();
        var confirm = $("#register-form").find("input[id='confirm_password']").val();

        if (name.length === 0 || email.length === 0 || password.length === 0 || confirm.length === 0) {

            $("p#error-register").addClass('red-text').html("Please fill out all field below !");

        } else {

            $("p#error-register").hide();

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

        }

    });


    // validate form login
    $("#login-button").on("click", function (e) {

        e.preventDefault();

        var url = window.location.href;

        var email = $("#login-form").find("input[id='email']").val();
        var password = $("#login-form").find("input[id='password']").val();

        var patternEmail = /^[\w]+@[\w]+\.[A-z]{2,5}$/i;

        var patternPassword = /^[\w]{5,40}$/i;

        var that = this;

        if (patternEmail.test(email)) {
            if (patternPassword.test(password)) {
                $(that).hide();
                $(".spinner").show();
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function (data) {
                        if (data.trim() === 'ok') {
                            $("p#password-error").hide();
                            $("p#email-error").hide();
                            $(that).show();
                            $(".spinner").hide();
                            swal("Success", "Login successfully", "success");
                            window.location.href = url;
                        } else if (data.trim() == 'not active') {
                            $("p#password-error").hide();
                            $("p#email-error").hide();
                            $(that).show();
                            $(".spinner").hide();
                            Materialize.toast("Your account is not activated. Check your email.", 4000);
                        } else if (data.trim() == 'wrong') {
                            $("p#password-error").hide();
                            $("p#email-error").hide();
                            $(that).show();
                            $(".spinner").hide();
                            Materialize.toast("Wrong credentials. Try again !", 4000);
                        }
                    },
                    error: function () {
                        alert("fail");
                    }
                });
            } else {
                $("#login-form").find("input[id='password']").focus();
                $("p#password-error").html("Password is between 5 and 40 character !").addClass('red-text');
            }
        } else {
            $("#login-form").find("input[id='email']").focus();
            $("p#email-error").html("Email is not valid. Try again !").addClass('red-text');
        }

    });


    //forgot password
    $(document).delegate("button#forgot-password", "click", function (e) {

        e.preventDefault();

        var form = $("form#form-forgot-password");
        var email = form.find("input[id='email']").val();
        var patternEmail = /^[\w]+@[\w]+\.[A-z]{2,5}$/i;
        var that = this;

        if (email.length === 0 || !patternEmail.test(email)) {

            $("p#forgot-password-error").html("Email is not valid.").addClass('red-text');

        } else {
            $(".spinner").show();
            $(that).hide();
            $("p#forgot-password-error").html("");

            $.ajax({
                url: 'forgot_password.php',
                type: 'POST',
                data: {
                    email: email
                },
                success: function (data) {
                    if (data.trim() === 'ok') {
                        $(".spinner").hide();
                        $(that).show();
                        $(".modal").modal('close');
                        swal("Success", "An email already sent to your email. Check your email !", "success");
                    } else if (data.trim() === 'fail') {
                        $(".spinner").hide();
                        $(that).show();
                        $("p#form-forgot-password-error").html("Email could not be sent to your email. Try again !").addClass("red-text");
                    } else if (data.trim() === 'system error') {
                        $(".spinner").hide();
                        $(that).show();
                        $("p#form-forgot-password-error").html("System error. Try again !").addClass("red-text");
                    } else if (data.trim() === 'email not found') {
                        $(".spinner").hide();
                        $(that).show();
                        $("p#form-forgot-password-error").html("Email not found!").addClass("red-text");
                    }
                }
            });

        }

    });


    //function post comment
    $(document).delegate("button.post-comment", "click", function (e) {

        e.preventDefault();

        var date = new Date();
        var content = $("#post-comment-form").find("textarea[name='cmcontent']").val();
        var uid = $(this).attr("uid");
        var pid = $(this).attr("pid");
        var uname = $(this).attr("username");
        var avatar = $(this).attr('avatar');

        $.ajax({
            url: 'post_comment.php',
            type: 'POST',
            data: {
                content: content,
                uid: uid,
                pid: pid
            },
            success: function (data) {
                if (data.trim() !== 'fail') {

                    $("#show-comments").prepend("<div class='card-panel hoverable'><div class='row'><div class='col m2'><img src='public/uploads/avatars/" + avatar + "' alt='{$comments['uname']}' class='responsive-img'></div><div class='col m10 no-padding'><strong style='font-size: 20px; margin-bottom: 7px !important'>" + uname + "</strong><small class='right'><i>" + moment(date).format("h:mm a DD/MM/YYYY") + "</i></small><div class='clearfix'></div><p>" + content + "</p></div></div><p><a class='red-text right delete-comment' id-delete='" + data + "'><i class='material-icons'>delete</i></a></p><p><a href='#edit-comment-" + data + "' class='yellow-text right'><i class='material-icons'>edit</i></a></p><div class='clearfix'></div><div id='edit-comment-" + data + "' class='modal'> <div class=\"modal-content\"> <textarea name='cmcontent' id='cmcontent' rows='10' class='materialize-textarea' required>" + content + "</textarea> </div> <div class=\"modal-footer\"> <a href='' id-update='" + data + "' class='modal-action modal-close waves-effect waves-green btn-flat save-change-comment'>Save changes</a> </div> </div>");

                    $("#post-comment-form").find("textarea[name='cmcontent']").val("")
                    $("#count-comment").html(parseInt($("#count-comment").html()) + 1);
                    Materialize.toast("Tks for your comment", 3000);
                }
            },
            error: function () {
                Materialize.toast("Comment could not be posted. Try again !", 3000);
            }
        });


    });


    //function delete comment
    $(document).delegate("a.delete-comment", "click", function (e) {

        e.preventDefault();

        var comment_id = $(this).attr("id-delete");

        swal({
                title: "Are you sure?",
                text: "Your comment will be deleted permanently",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            },
            function () {
                $.ajax({
                    url: 'delete_comment.php',
                    type: 'POST',
                    data: {
                        id: comment_id
                    },
                    success: function (data) {
                        if (data.trim() === 'ok') {
                            $("div#comment_" + comment_id).hide('slow');
                            $("#count-comment").html(parseInt($("#count-comment").html()) - 1);
                            Materialize.toast("Your comment was deleted successfully", 3000);
                        } else {
                            alert("fail");
                        }
                    },
                    error: function () {
                    }
                });
            });

    });


    //function update comment
    $(document).delegate(".save-change-comment", "click", function (e) {

        e.preventDefault();

        var id = $(this).attr("id-update");
        var content = $("div#edit-comment-" + id).find("textarea#cmcontent").val();

        $.ajax({
            url: 'update_comment.php',
            type: 'POST',
            data: {
                content: content,
                id: id
            },
            success: function (data) {
                if (data.trim() === 'ok') {
                    $("p#comment-content-" + id).html(content);
                    Materialize.toast("Your comment has been updated", 3000);
                }
            },
            error: function () {
            }
        });

    });


    //validate new password
    $(document).delegate("#change_password", "click", function (e) {

        e.preventDefault();

        var new_password = $("form#form-change-password").find("input[id='new_password']").val();
        var confirm = $("form#form-change-password").find("input[id='confirm_new_password']").val();
        var current_password = $("form#form-change-password").find("input[id='current_password']").val();

        if (new_password.length === 0 || confirm.length === 0 || current_password.length === 0) {

            $("p#no-current-password").html("Please fill out all field to perform this action !").addClass("red-text");

        } else {

            if (new_password.trim() !== confirm.trim()) {
                $("form#form-change-password").find("input[id='new_password']").focus();
                $("p#error-new-password").html("Password do not match. Try again !").addClass("red-text");
            } else {
                $("form#form-change-password").submit();
            }

        }

    });


    //function for send feedback
    $(document).delegate("#send-feedback", "click", function (e) {

        e.preventDefault();

        var name = $("#form-send-feedback").find("input[id='name']").val();
        var email = $("#form-send-feedback").find("input[id='email']").val();
        var message = $("#form-send-feedback").find("textarea[id='message']").val();

        var patternEmail = /^[\w]+@[\w]+\.[A-z]{2,5}$/i;

        if (name.length === 0 || email.length === 0 || message.length === 0) {

            $("#check-error-submit").addClass('red-text').html("Please fill out all the fill below");

        } else {

            $("#check-error-submit").html("");

            if (patternEmail.test(email)) {

                $(this).hide();
                $(".spinner").show();
                $("#check-error-submit").hide();
                $("p#email-error").hide();

                $.ajax({
                    url: 'send_feedback.php',
                    type: 'POST',
                    data: {
                        name: name,
                        email: email,
                        message: message
                    },
                    success: function (data) {
                        if (data.trim() === 'ok') {
                            $("#email-error").hide();
                            $(".spinner").hide();
                            $("#send-feedback").show();
                            Materialize.toast("Your message was sent to admin", 4000);
                            $("#form-send-feedback").find("input, textarea").val("");
                        } else {
                            Materialize.toast("Your message could not be sent. Try again !", 4000);
                            $(".spinner").hide();
                            $("#send-feedback").show();
                        }
                    }
                });

            } else {

                $("p#email-error").addClass('red-text').html("Your email is not valid.");
                $("#form-send-feedback").find("input[id='email']").select();

            }

        }

    });
});