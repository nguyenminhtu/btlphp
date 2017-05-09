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
                            <th>Comment ID</th>
                            <th>Post Title</th>
                            <th>User</th>
                            <th>Content</th>
                            <th>Created At</th>
                            <th colspan="1">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // pagination
                        $display = 10;

                        $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

                        $q = "SELECT cm.cmid, p.ptitle, u.uname, cm.cmcontent, DATE_FORMAT(cm.created_at, '%h:%i %p %d/%m/%Y') AS date FROM comment AS cm JOIN post AS p ON cm.pid = p.pid JOIN user AS u ON cm.uid = u.uid ORDER BY cm.created_at DESC LIMIT {$start}, {$display}";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        if (mysqli_num_rows($r) > 0) {
                            while ($comments = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                                echo "
                                        <tr id='{$comments['cmid']}'>
                                            <td>{$comments['cmid']}</td>
                                            <td>{$comments['ptitle']}</td>
                                            <td>{$comments['uname']}</td>
                                            <td><a href='#view-content-".$comments['cmid']."'>".substr($comments['cmcontent'], 0, 100)."</a> ...</td>
                                            <td>{$comments['date']}</td>
                                            <td><a class='remove-comment red-text' id-delete='{$comments['cmid']}' style='cursor: pointer;'><i class='material-icons'>delete</i></a></td>
                                        </tr>
                                    ";
                                ?>
                                <div id='view-content-<?php echo $comments['cmid']; ?>' class='modal'>
                                    <div class='modal-content'>

                                        <div class='row'>
                                            <?php echo $comments['cmcontent']; ?>
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
                    <?php pagination($display, 'cmid', 'comment', 'show_comments'); ?>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>