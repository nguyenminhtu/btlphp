<?php
require_once("includes/navigation.php");
?>

<div class="container">
    <div class="row center-align">
        <div class="col m8 offset-m2">
            <?php
            showNotice();
            ?>
        </div>
    </div>
</div>

    <main>
        <div class="">
            <div class="row">
                <?php
                require_once "includes/sidebar.php";
                ?>

                <div class="col m10 center-align">
                    <table class="centered highlight hoverable">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $q = "SELECT cid, cname, DATE_FORMAT(created_at, '%b %d %Y %h:%i %p') AS date FROM category ORDER BY created_at DESC";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);

                            if (mysqli_num_rows($r) > 0) {
                                while ($cate = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                    echo "
                                        <tr id='{$cate['cid']}'>
                                            <td>{$cate['cid']}</td>
                                            <td>{$cate['cname']}</td>
                                            <td>{$cate['date']}</td>
                                            <td><a href='edit_category.php?cid={$cate['cid']}'><i class='material-icons'>more edit</i></a></td>
                                            <td><a class='remove-category' id-delete='{$cate['cid']}' style='cursor: pointer;'><i class='material-icons'>delete</i></a></td>
                                        </tr>
                                    ";
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>