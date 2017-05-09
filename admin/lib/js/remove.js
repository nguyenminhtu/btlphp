$(document).ready(function () {
    //init modal
    $('.modal').modal();

    //init select tag
    $('select').material_select();


    // delete category with ajax
    $(".remove-category").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?cid='+id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#"+id).hide('slow');
                    } else {
                        alert("co loi, khong xoa dc");
                    }
                }
            });
        }
    });

    // delete post with ajax
    $(".remove-post").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?pid='+id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#"+id).hide('slow');
                    } else {
                        alert("co loi, khong xoa dc");
                    }
                }
            });
        }
    });

    //delete comment with ajax
    $(".remove-comment").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?cmid='+id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#"+id).hide('slow');
                    } else {
                        alert("co loi, khong xoa dc");
                    }
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
                url: 'delete.php?uid='+id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#"+id).hide('slow');
                    } else {
                        alert("co loi, khong xoa dc");
                    }
                }
            });
        }
    });
});