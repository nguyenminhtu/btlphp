<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
}
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
                            <th>Post ID</th>
                            <th>Post Title</th>
                            <th>Post Image</th>
                            <th>Post Content</th>
                            <th>Category</th>
                            <th>Comment</th>
                            <th>Created At</th>
                            <th colspan="2">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // pagination
                        $display = 5;

                        $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

                        $q = "SELECT p.pid, p.ptitle, p.pimage, p.pcontent, c.cname, DATE_FORMAT(p.created_at, '%h:%i %p %d/%m/%Y') AS date, COUNT(cm.cmid) AS count_comment FROM post AS p JOIN category AS c ON p.cid = c.cid LEFT JOIN comment AS cm ON p.pid = cm.pid GROUP BY p.pid ORDER BY p.created_at DESC LIMIT {$start}, {$display}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        if (mysqli_num_rows($r) > 0) {
                            while ($post = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                echo "
                                        <tr id='{$post['pid']}'>
                                            <td>{$post['pid']}</td>
                                            <td>{$post['ptitle']}</td>
                                            <td>
                                                <img class='materialboxed' src=" . "/public/uploads/images/" . $post['pimage'] . " width='96' height='100' />
                                            </td>
                                            <td><a href='#view-comment-" . $post['pid'] . "'>" . substr($post['pcontent'], 0, 100) . "</a> ...</td>
                                            <td>{$post['cname']}</td>
                                            <td>{$post['count_comment']}</td>
                                            <td>{$post['date']}</td>
                                            <td><a href='edit_post.php?pid={$post['pid']}'><i class='material-icons'>edit</i></a></td>
                                            <td><a class='remove-post' id-delete='{$post['pid']}' style='cursor: pointer;'><i class='material-icons'>delete</i></a></td>
                                        </tr>
                                    ";
                                ?>
                                <div id='view-comment-<?php echo $post['pid']; ?>' class='modal'>
                                    <div class='modal-content'>

                                        <div class='row'>
                                            <?php echo $post['pcontent']; ?>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <br>
                    <?php pagination($display, 'pid', 'post', 'show_posts'); ?>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>