<?php
require_once("includes/navigation.php");
?>

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
                                <th>Post</th>
                                <th>Created At</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            // pagination
                            $display = 10;

                            $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

                            $q = "SELECT c.cid, c.cname, DATE_FORMAT(c.created_at, '%h:%i %p %d/%m/%Y') AS date, COUNT(p.pid) AS count_post FROM category AS c LEFT JOIN post AS p ON c.cid = p.cid GROUP BY c.cid ORDER BY c.created_at DESC LIMIT {$start}, {$display}";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);

                            if (mysqli_num_rows($r) > 0) {
                                while ($cate = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                    echo "
                                        <tr id='{$cate['cid']}'>
                                            <td>{$cate['cid']}</td>
                                            <td>{$cate['cname']}</td>
                                            <td>{$cate['count_post']}</td>
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
                    <br>
                    <?php pagination($display, 'cid', 'category', 'show_categories') ?>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>