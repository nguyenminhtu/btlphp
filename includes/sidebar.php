<div class="col m3" style="padding-left: 10px !important;">
    <div class="row">
        <form action="search.php" method="get">
            <div class="input-field">
                <input id="search" type="search" required placeholder="Search here..." name="q">
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="card darken-1">
            <div class="card-action">
                <h5 class="title">CATEGORIES</h5>
            </div>
            <div class="card-content no-padding">
                <ul class="collection">
                    <?php
                    $q = "SELECT cid, cname FROM category";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);

                    while ($cate = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

                        echo "<a href='show_category.php?cid={$cate['cid']}&cname=".urlencode($cate['cname'])."' class='collection-item'>{$cate['cname']}</a>";

                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card darken-1">
            <div class="card-action">
                <h5 class="title">POPULAR POSTS</h5>
            </div>
            <div class="card-content no-padding">
                <ul class="collection">
                    <?php
                    $q1 = "SELECT pid, ptitle, pimage FROM post ORDER BY created_at DESC LIMIT 5";
                    $r1 = mysqli_query($dbc, $q1);
                    confirm_query($r1, $q1);

                    while ($post = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {

                        echo "
                            <a href='show_post.php?pid={$post['pid']}&ptitle=".urlencode($post['ptitle'])."' class='collection-item'>
                                <div class='card-panel grey lighten-5 z-depth-1 popular-post'>
                                    <div class='row valign-wrapper'>
                                        <div class='col m4'>
                                            <img src='public/uploads/images/".$post['pimage']."' alt='' class='circle responsive-img'>
                                        </div>
                                        <div class='col m8'>
                                              <span class=\"black-text\">
                                                {$post['ptitle']}
                                              </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        ";

                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>