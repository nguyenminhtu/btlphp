<?php
include_once "includes/navigation.php";
?>

    <br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col m9" style="padding-right: 20px !important;">
                    <?php
                    //pagination
                    $display = 5;

                    $start = (isset($_GET['s'])) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1)) ? $_GET['s'] : 0;


                    $q = "SELECT p.pid, p.ptitle, p.pimage, p.pcontent, c.cname, DATE_FORMAT(p.created_at, '%h:%i %p %d/%m/%Y') AS date,";
                    $q .= " COUNT(cm.cmid) AS count_comment, COUNT(v.vid) AS count_view";
                    $q .= " FROM post AS p LEFT JOIN category AS c ON p.cid = c.cid";
                    $q .= " LEFT JOIN comment AS cm ON p.pid = cm.pid";
                    $q .= " LEFT JOIN view AS v ON p.pid = v.pid GROUP BY pid";
                    $q .= " LIMIT {$start}, {$display}";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);

                    echo "
                    <nav>
                        <div class='nav-wrapper'>
                              <div class='col m12'>
                                <a href='/' class='breadcrumb'>Home</a>
                              </div>
                        </div>
                    </nav>
                    <br/>
                ";

                    while ($post = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

                        echo "
                        <div class=\"card z-depth-3 hoverable\">
                            <div class=\"card-action\">
                                <a href='show_post.php?pid={$post['pid']}&ptitle=" . urlencode($post['ptitle']) . "'><h5>{$post['ptitle']}</h5></a>
                            </div>
                            <div class=\"card-image\">
                                <img src=\"public/uploads/images/{$post['pimage']}\" alt=\"cc\" class=\"responsive-img materialboxed\">
                            </div>
                            <div class=\"card-content\">
                                <p>
                                    <i class=\"material-icons\">account_circle</i> <span class='user-post'>Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <i class=\"material-icons\">schedule</i> <span class='time-post'>{$post['date']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <i class=\"material-icons\">label</i> <span class='cate-post'>{$post['cname']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <i class=\"material-icons\">message</i> <span class='cate-post'>{$post['count_comment']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <i class=\"material-icons\">visibility</i> <span class='cate-post'>{$post['count_view']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </p>
                                <br>
                                <p>" . excert_text($post['pcontent'], 200) . "...</p>
                                <br />
                                <p class='center-align'>
                                    <a href='show_post.php?pid={$post['pid']}&ptitle=" . urlencode($post['ptitle']) . "' class='btn waves-effect waves-light green'>Read more &raquo;</a>  
                                </p>
                            </div>
                        </div>
                    ";

                    }

                    echo "<br><hr><br>";
                    pagination($display, 'pid', 'post', '?');
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