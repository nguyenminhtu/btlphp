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
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th>Active</th>
                            <th>Role</th>
                            <th>Comment</th>
                            <th>Joined At</th>
                            <th colspan="2">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // pagination
                        $display = 5;

                        $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

                        $q = "SELECT u.uid, u.uname, u.uemail, u.uavatar, u.urole, DATE_FORMAT(u.created_at, '%h:%i %p %d/%m/%Y') AS date, u.uactive, COUNT(cm.cmid) AS count_comment";
                        $q .= " FROM user AS u LEFT JOIN comment AS cm ON u.uid = cm.uid GROUP BY u.uid ORDER BY u.created_at DESC LIMIT {$start}, {$display}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        if (mysqli_num_rows($r) > 0) {
                            while ($user = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                echo "
                                        <tr id='{$user['uid']}'>
                                            <td>{$user['uid']}</td>
                                            <td>{$user['uname']}</td>
                                            <td>{$user['uemail']}</td>
                                            <td>
                                                <img src='../public/uploads/avatars/{$user['uavatar']}' alt='{$user['uname']}' width='96' height='100'>
                                            </td>
                                            <td>";

                                echo ($user['uactive'] == null) ? "Actived" : "Not Yet";

                                echo "</td>
                                            <td>";

                                echo ($user['urole'] == 0) ? "<span class='red-text'>Admin</span>" : "User";

                                echo "</td>
                                            <td>{$user['count_comment']}</td>
                                            <td>{$user['date']}</td>
                                            <td><a href='edit_user.php?uid={$user['uid']}'><i class='material-icons yellow-text'>edit</i></a></td>
                                            ";

                                if ($user['urole'] != 0) {
                                    echo "
                                        <td><a class='remove-user red-text' id-delete='{$user['uid']}' style='cursor: pointer;'><i class='material-icons'>delete</i></a></td>
                                    ";
                                }

                                echo "
                                        </tr>
                                    ";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <br>
                    <?php pagination($display, 'uid', 'user', 'show_users'); ?>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>