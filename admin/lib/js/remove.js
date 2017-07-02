$(document).ready(function () {
    //init element
    $('input#input_text, textarea').characterCounter();
    $('.modal').modal();
    $('select').material_select();
    $(".dropdown-button").dropdown({
        hover: true
    });


    // delete category with ajax
    $(".remove-category").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?cid=' + id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#" + id).hide('slow');
                        Materialize.toast("Your category was deleted successfully !", 4000);
                    } else {
                        Materialize.toast("Your category could not be deleted due to system error !", 4000);
                    }
                }
            });
        }
    });

    // delete post with ajax
    $(document).delegate("a.remove-post", "click", function (e) {
        e.preventDefault();
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?pid=' + id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#" + id).hide('slow');
                        Materialize.toast("Your post was deleted successfully !", 4000);
                    } else {
                        Materialize.toast("Your post could not be deleted due to system error !", 4000);
                    }
                }
            });
        }
    });

    //delete comment with ajax
    $(document).delegate("a.remove-comment", "click", function (e) {
        e.preventDefault();
        if (confirm("Ban co chac chan muon xoa comment nay ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                url: 'delete.php',
                type: "GET",
                data: {
                    cmid: id
                },
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#" + id).hide('slow');
                        Materialize.toast("Comment was deleted successfully !", 4000);
                    } else {
                        Materialize.toast("This comment could not be deleted !", 4000);
                    }
                },
                error: function () {
                    Materialize.toast("This comment could not be deleted due to system error !", 4000);
                }
            });
        }
    });


    //delete user with ajax
    $(".remove-user").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?uid=' + id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#" + id).hide('slow');
                        Materialize.toast("User was deleted successfully !", 4000);
                    } else {
                        Materialize.toast("User could not be deleted due to system error !", 4000);
                    }
                }
            });
        }
    });
});