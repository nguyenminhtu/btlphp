<?php
$title = "Show Post";
include_once "includes/navigation.php";
?>

    <br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col m9" style="padding-right: 30px !important;">
                    <?php

                    if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

                    $pid = $_GET['pid'];

                    // count view
                    count_view($pid);

                    $q = "SELECT p.ptitle, p.pcontent, p.pimage, p.cid, c.cname, DATE_FORMAT(p.created_at, '%h:%i %p %d/%m/%Y') AS date, v.vcount FROM post AS p JOIN category AS c ON p.cid = c.cid LEFT JOIN view AS v ON p.pid = v.pid WHERE p.pid = {$pid}";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);

                    if (mysqli_num_rows($r) >= 1) {

                    list($ptitle, $pcontent, $pimage, $cid, $cname, $pdate, $vcount) = mysqli_fetch_array($r, MYSQLI_NUM);

                    echo "
                            <nav>
                                <div class='nav-wrapper'>
                                      <div class='col m12'>
                                        <a href='/' class='breadcrumb'>Home</a>
                                        <a href='show_category.php?cid={$cid}&cname=" . urlencode($cname) . "' class='breadcrumb'>{$cname}</a>
                                        <a href='' class='breadcrumb'>{$ptitle}</a>
                                      </div>
                                </div>
                            </nav>
                            <br/>

                            <div class='row'>
                                <div class='card z-depth-4 hoverable'>
                                    <div class='card-content'>
                                    <h3 class='card-title'>{$ptitle}</h3>
                                    <div class='card-action'>
                                        <p><img src='public/uploads/images/{$pimage}' alt='{$ptitle}' class='responsive-img materialboxed' /></p>
                                        <br>
                                        <p>
                                            <i class=\"material-icons\">account_circle</i> <span class='user-post'>Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <i class=\"material-icons\">schedule</i> <span class='time-post'>{$pdate} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <i class=\"material-icons\">label</i> <span class='cate-post'>{$cname} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            <i class=\"material-icons\">visibility</i> <span class='cate-post'>{$vcount} views &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </p>
                                        <br>
                                        <p>{$pcontent}</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        ";


                    ?>




                    <?php
                    //pagination
                    $display = 10;

                    $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;
                    $q1 = "SELECT cm.cmid, cm.uid, u.uname, u.uavatar, cm.cmcontent, DATE_FORMAT(cm.created_at, '%h:%i %p %d/%m/%Y') AS date FROM comment AS cm JOIN user AS u ON cm.uid = u.uid WHERE cm.pid = {$pid} ORDER BY cm.created_at DESC LIMIT {$start}, {$display}";
                    $r1 = mysqli_query($dbc, $q1);
                    confirm_query($r1, $q1);
                    ?>

                    <div class="row">
                        <div class="card z-depth-4 hoverable">
                            <div class="card-content">
                                <div class="card-title">
                                    <?php
                                    if (mysqli_num_rows($r1) >= 1) {

                                        $q2 = "SELECT COUNT(cmid) AS num FROM comment WHERE pid = {$pid}";
                                        $r2 = mysqli_query($dbc, $q2);
                                        confirm_query($r2, $q2);
                                        list($num_comment) = mysqli_fetch_array($r2, MYSQLI_NUM);
                                        echo "<span id='count-comment'>{$num_comment}</span> comments";

                                    } else {

                                        echo "Post the first comment";

                                    }
                                    ?>
                                </div>

                                <div class="card-action">
                                    <?php
                                    if (isset($_SESSION['uid'])) {

                                        echo "
                                                    <form class=\"\" action=\"\" method=\"post\" id=\"post-comment-form\">
                                                        <div class=\"\">
                                                            <div class=\"input-field\">
                                                                <i class=\"material-icons prefix\">mode_edit</i>
                                                                <textarea id=\"icon_prefix2\" class=\"materialize-textarea\" name=\"cmcontent\" data-length=\"250\"></textarea>
                                                                <label for=\"icon_prefix2\">Comment here...</label>
                                                            </div>
                                                            <button avatar='{$_SESSION['uavatar']}' username='{$_SESSION['uname']}' uid='{$_SESSION['uid']}' pid='{$pid}' style=\"margin-left: 40px;\" type=\"submit\" class=\"btn waves-effect waves-light darken-1 post-comment\">Send</button>
                                                        </div>
                                                    </form>
                                                ";

                                    } else {
                                        echo "<a class='modal-trigger center-align' href=\"#loginModal\">Please login to post comment</a>";
                                    }
                                    ?>
                                    <br>
                                    <hr>

                                    <?php
                                    echo "<div id='show-comments'>";
                                    if (mysqli_num_rows($r1) >= 1) {

                                        while ($comments = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {

                                            echo "
                                                    <div class='card-panel hoverable' id='comment_{$comments['cmid']}'>
                                                        <div class='row'>
                                                            <div class='col m2'>
                                                                <img src='public/uploads/avatars/{$comments['uavatar']}' alt='{$comments['uname']}' class='responsive-img'>
                                                            </div>
                                                            <div class='col m10 no-padding'>
                                                                <strong style='font-size: 20px; margin-top: 20px !important;'>{$comments['uname']}</strong>
                                                                <small class='right'><i>{$comments['date']}</i></small>
                                                                <div class='clearfix'></div>
                                                                <p id='comment-content-{$comments['cmid']}'>{$comments['cmcontent']}</p>
                                                            </div>
                                                        </div>";

                                            if (isset($_SESSION['uid']) && ($_SESSION['uid'] == $comments['uid']) && !is_admin()) {
                                                echo "<p><a class='red-text right delete-comment' id-delete='{$comments['cmid']}'><i class='material-icons'>delete</i></a></p>";
                                                echo "<p><a href='#edit-comment-{$comments['cmid']}' class='yellow-text right'><i class='material-icons'>edit</i></a></p>";
                                            }

                                            if (is_admin()) {
                                                echo "<p><a class='red-text right delete-comment' id-delete='{$comments['cmid']}'><i class='material-icons'>delete</i></a></p>";
                                            }

                                            echo "<div class='clearfix'></div>
                                                    </div>
                                                    
                                                    <div id='edit-comment-{$comments['cmid']}' class='modal'>
                                                        <div class=\"modal-content\">
                                                          <textarea name='cmcontent' id='cmcontent' rows='10' class='materialize-textarea' required>{$comments['cmcontent']}</textarea>
                                                        </div>
                                                        <div class=\"modal-footer\">
                                                          <a href='' id-update='{$comments['cmid']}' class='modal-action modal-close waves-effect waves-green btn-flat save-change-comment'>Save changes</a>
                                                        </div>
                                                    </div>
                                                ";

                                        }

                                        echo "<br><br>";
                                        pagination($display, 'cmid', 'comment', "show_post.php?pid={$pid}&ptitle=" . urlencode($_GET['ptitle']) . "&", " WHERE pid = {$pid}");

                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php

                } else {
                    echo "<h3 class='center-align'>This post id is not exist !</h3>";
                }

                } else {
                    redirect_to("");
                }
                ?>
            </div>

            <?php
            include_once "includes/sidebar.php";
            ?>
        </div>
    </div>
    </div>


<?php
include_once "includes/footer.php";
?>