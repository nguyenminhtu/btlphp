<?php
$title = "Show Category";
include_once "includes/navigation.php";
?>

<br>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col m9" style="padding-right: 30px !important;">
                <?php
                //pagination
                $display = 5;

                $start = (isset($_GET['s'])) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range'=>1)) ? $_GET['s'] : 0;


                if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {

                    $cid = $_GET['cid'];

                    $q = "SELECT p.pid, p.ptitle, p.pcontent, p.pimage, p.cid, c.cname, DATE_FORMAT(p.created_at, '%h:%i %p %d/%m/%Y') AS date FROM post AS p JOIN category AS c ON p.cid = c.cid WHERE p.cid = {$cid} LIMIT {$start}, {$display}";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);

                    if (mysqli_num_rows($r) >= 1) {

                        echo "
                            <nav>
                                <div class='nav-wrapper'>
                                      <div class='col m12'>
                                        <a href='/' class='breadcrumb'>Home</a>
                                        <a href='' class='breadcrumb'>".urldecode($_GET['cname'])."</a>
                                      </div>
                                </div>
                            </nav>
                            <br/>
                        ";

                        while ($posts = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

                            echo "
                                <div class='row'>
                                    <div class='card'>
                                        <div class='card-action' style='padding-bottom: 3px !important; padding-top: 25px !important;'>
                                            <div class='row' style='padding-bottom: 0 !important;'>
                                                <div class='col m4'>
                                                    <img src='public/uploads/images/{$posts['pimage']}' alt='{$posts['ptitle']}' class='responsive-img materialboxed'>
                                                </div>
                                                
                                                <div class='col m8'>
                                                    <p style='margin-bottom: 10px;'><strong>{$posts['ptitle']}</strong></p>
                                                    <p style='margin-bottom: 10px;'>
                                                        <i class='material-icons'>account_circle</i> <span class='user-post'>Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <i class='material-icons'>schedule</i> <span class='time-post'>{$posts['date']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <i class='material-icons'>label</i> <span class='cate-post'>{$posts['cname']} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    </p>
                                                    <p class='truncate' style='font-size: 14px;'>{$posts['pcontent']}</p>
                                                    <br>
                                                    <p><a href='show_post.php?pid={$posts['pid']}&ptitle=".urlencode($posts['ptitle'])."' class='right'>Read more &raquo;</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";

                        }

                        pagination($display, 'pid', 'post', "show_category.php?cid={$cid}&cname=".urldecode($_GET['cname'])."&", "WHERE cid = {$cid}");

                    } else {
                        echo "<h3 class='center-align'>This category don't have any post or category does not exist !</h3>";
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