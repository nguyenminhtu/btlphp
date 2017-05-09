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

                if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {

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
                                        <a href='show_category.php?cid={$cid}&cname=".urlencode($cname)."' class='breadcrumb'>{$cname}</a>
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $cmcontent = mysqli_real_escape_string($dbc, $_POST['cmcontent']);

        $query = "INSERT INTO comment (uid, pid, cmcontent, created_at) VALUES (1, {$pid}, '{$cmcontent}', NOW())";
        $result = mysqli_query($dbc, $query);
        confirm_query($result, $query);

        echo "<script>Materialize.toast('Comment was created successfully', 3000)</script>";

    }
?>




                        <?php
                        //pagination
                        $display = 10;

                        $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range'=>1))) ? $_GET['s'] : 0;
                        $q1 = "SELECT u.uname, cm.cmcontent, DATE_FORMAT(cm.created_at, '%h:%i %p %d/%m/%Y') AS date FROM comment AS cm JOIN user AS u ON cm.uid = u.uid WHERE cm.pid = {$pid} ORDER BY cm.created_at DESC LIMIT {$start}, {$display}";
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
                                            echo "{$num_comment} comments";

                                        } else {

                                            echo "Post the first comment";

                                        }
                                        ?>
                                    </div>

                                    <div class="card-action">
                                        <form class="" action="" method="post">
                                            <div class="">
                                                <div class="input-field">
                                                    <i class="material-icons prefix">mode_edit</i>
                                                    <textarea id="icon_prefix2" class="materialize-textarea" name="cmcontent" data-length="250"></textarea>
                                                    <label for="icon_prefix2">Comment here...</label>
                                                </div>
                                                <button style="margin-left: 40px;" type="submit" class="btn waves-effect waves-light darken-1">Send</button>
                                            </div>
                                        </form>
                                        <br>
                                        <hr>

                                        <?php
                                        if (mysqli_num_rows($r1) >= 1) {

                                            while ($comments = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {

                                                echo "
                                                    <div class='card-panel hoverable'>
                                                        <p><strong style='font-size: 20px; margin-bottom: 7px !important;'>{$comments['uname']}</strong><small class='right'><i>{$comments['date']}</i></small></p>
                                                        <div class='clearfix'></div>
                                                        <p>{$comments['cmcontent']}</p>
                                                    </div>
                                                ";

                                            }

                                            echo "<br><br>";
                                            pagination($display, 'cmid', 'comment', "show_post.php?pid={$pid}&ptitle=".urlencode($_GET['ptitle'])."&", " WHERE pid = {$pid}");

                                        }
                                        ?>
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