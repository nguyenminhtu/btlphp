<?php
$title = "Search Result";
require_once "includes/connect.php";
require_once "includes/functions.php";

include_once "includes/navigation.php";
?>
<br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col m9" style="padding-right: 20px !important;">



<?php

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        if (isset($_GET['q'])) {

            //pagination
            $display = 5;

            $start = (isset($_GET['s'])) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range'=>1)) ? $_GET['s'] : 0;

            $key = mysqli_real_escape_string($dbc, $_GET['q']);

            $q = "SELECT p.pid, p.ptitle, p.pcontent, p.pimage, DATE_FORMAT(p.created_at, '%h:%i %p %d/%m/%Y') AS date, c.cname,";
            $q.= " COUNT(cm.cmid) AS count_comment, COUNT(v.vid) AS count_view";
            $q.= " FROM post AS p JOIN category AS c ON p.cid = c.cid LEFT JOIN comment AS cm ON p.pid = cm.pid LEFT JOIN view AS v ON p.pid = v.pid";
            $q.= " WHERE p.ptitle LIKE '%{$key}%' OR p.pcontent LIKE '%{$key}%'";
            $q.= " GROUP BY p.pid LIMIT {$start}, {$display}";

            $q1 = "SELECT COUNT(pid) AS p FROM post WHERE ptitle LIKE '%{$key}%' OR pcontent LIKE '%{$key}%'";

            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            if (mysqli_num_rows($r) > 0) {
                $r1 = mysqli_query($dbc, $q1);
                confirm_query($r1, $q1);

                list($count_post) = mysqli_fetch_array($r1, MYSQLI_NUM);

                echo "
                    <nav>
                        <div class='nav-wrapper'>
                              <div class='col m12'>
                                    <p class='black-text'>Tìm thấy {$count_post} kết quả với từ khoá <strong class='white-text' style='font-size: 20px;text-decoration: underline; font-style: italic;'>{$key}</strong></p>
                              </div>
                        </div>
                    </nav>
                    <br/>
                ";

                while ($result = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

                    echo "
                        <div class='row'>
                            <div class='card'>
                                <div class='card-action' style='padding-bottom: 3px !important; padding-top: 25px !important;'>
                                    <div class='row' style='padding-bottom: 0 !important;'>
                                        <div class='col m4'>
                                            <img src='public/uploads/images/{$result['pimage']}' alt='{$result['ptitle']}' class='responsive-img materialboxed'>
                                        </div>
                                        
                                        <div class='col m8'>
                                            <p style='margin-bottom: 10px;'><strong>{$result['ptitle']}</strong></p>
                                            <p style='margin-bottom: 10px;'>
                                                <i class='material-icons'>account_circle</i> <span class='user-post'>Admin &nbsp;&nbsp;&nbsp;</span>
                                                <i class='material-icons'>schedule</i> <span class='time-post'>{$result['date']} &nbsp;&nbsp;&nbsp;</span>
                                                <i class='material-icons'>label</i> <span class='cate-post'>{$result['cname']} &nbsp;&nbsp;&nbsp;</span>
                                                <i class='material-icons'>message</i> <span class='cate-post'>{$result['count_comment']} &nbsp;&nbsp;&nbsp;</span>
                                                <i class='material-icons'>visibility</i> <span class='cate-post'>{$result['count_view']} &nbsp;&nbsp;&nbsp;</span>
                                            </p>
                                            <p class='truncate' style='font-size: 14px;'>{$result['pcontent']}</p>
                                            <br>
                                            <p><a href='show_post.php?pid={$result['pid']}&ptitle=".urlencode($result['ptitle'])."' class='right'>Read more &raquo;</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";

                }
                pagination($display, 'pid', 'post', "search.php?q={$key}&", "WHERE ptitle LIKE '%{$key}%' OR pcontent LIKE '%{$key}%'");

            } else {

                echo "<h4 class='center-align'>No post match with criteria</h4>";

            }

        } else {

            redirect_to("");

        }

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
