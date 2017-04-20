$(document).ready(function () {
    $(".remove-category").on("click", function () {
        if (confirm("Ban co chac chan muon xoa ko ?")) {
            var id = $(this).attr('id-delete');

            $.ajax({
                type: "GET",
                url: 'delete.php?cid='+id,
                success: function (data) {
                    if (data.trim() === 'oke') {
                        $("tr#"+id).remove();
                    } else {
                        alert("co loi, khong xoa dc");
                    }
                }
            });
        }
    });
});