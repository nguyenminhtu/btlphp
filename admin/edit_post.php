<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
}
?>


<?php

if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {

    $pid = $_GET['pid'];

    $q = "SELECT ptitle, pimage, pcontent, cid FROM post WHERE pid = {$pid}";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {

        list($ptitle_edit, $pimage_edit, $pcontent_edit, $cid_edit) = mysqli_fetch_array($r, MYSQLI_NUM);

    } else {

        redirect_to("show_post.php");

    }

}

?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    $trimmed = array_map('trim', $_POST);

    //category title
    $title = mysqli_real_escape_string($dbc, $trimmed['ptitle']);


    // category id
    if (filter_var($trimmed['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $cid = $trimmed['cid'];
    } else {
        $errors[] = "cid";
    }


    //content
    $content = mysqli_real_escape_string($dbc, $trimmed['pcontent']);


    //image
    if (file_exists($_FILES['pimage']['tmp_name']) || is_uploaded_file($_FILES['pimage']['tmp_name'])) {

        //tao array anh hop le
        $allowed = array('image/jpg', 'image/jpeg', 'image/png');

        // kiem tra anh upload co hop le hay ko
        if (in_array(strtolower($_FILES['pimage']['type']), $allowed)) {

            //lay phan extension
            $ext = end(explode('.', $_FILES['pimage']['name']));

            // dat lai ten cho anh
            $pimage = uniqid(rand(), true) . '.' . $ext;

            // kiem tra upload anh co thanh cong hay ko
            if (unlink("../public/uploads/images/" . $trimmed['old_image'])) {
                if (!move_uploaded_file($_FILES['pimage']['tmp_name'], "../public/uploads/images/" . $pimage)) {
                    $errors[] = "upload failed";
                }
            } else {
                $errors[] = "upload failed";
            }

        } else {

            $errors[] = "wrong format";

        }

    } else {

        $pimage = $trimmed['old_image'];

    }


    if (empty($errors)) {

        $q = "UPDATE post SET ptitle = '{$title}', pimage = '{$pimage}', pcontent = '{$content}', cid = $cid WHERE pid = $pid LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) > 0) {

            $result = "<p class='green-text center-align'>The post was updated successfully.</p>";

            $_POST = [];

            redirect_to("show_posts.php");

        } else {

            $result = "<p class='red-text center-align'>An error has occured when insert to database. Sorry for inconvenience.</p>";

        }

    }

}
?>


    <main>
        <div class="">
            <div class="row">
                <?php
                require_once "includes/sidebar.php";
                ?>

                <div class="col m10 center-align">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php
                        if (isset($result)) {
                            echo $result;
                        }
                        ?>
                        <h3>Sửa post
                            <small><i><?php echo $ptitle_edit; ?></i></small>
                        </h3>
                        <hr>
                        <div class="input-field">
                            <input id="ptitle" type="text" class="validate" name="ptitle" autofocus required
                                   value="<?php echo (isset($ptitle_edit)) ? $ptitle_edit : '' ?>">
                            <label for="ptitle">Post title</label>
                        </div>


                        <div class="input-field">
                            <div class="row">
                                <div class="col m6">
                                    <img class="responsive-img" src="/public/uploads/images/<?php echo $pimage_edit; ?>"
                                         alt="<?php echo $ptitle_edit; ?>">
                                    <input type="hidden" name="old_image" value="<?php echo $pimage_edit; ?>">
                                </div>
                            </div>
                        </div>


                        <div class="input-field">
                            <div class="file-field input-field">
                                <?php
                                if (!empty($errors) && in_array('wrong format', $errors)) {
                                    echo "<p class='red-text'>This image is wrong format !</p>";
                                }
                                if (!empty($errors) && in_array('upload failed', $errors)) {
                                    echo "<p class='red-text'>Could not upload image !</p>";
                                }
                                ?>
                                <div class="btn">
                                    <span>Post Image</span>
                                    <input type="file" name="pimage">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="pimage">
                                </div>
                            </div>
                        </div>

                        <div class="input-field">
                            <textarea name="pcontent" id="pcontent" rows="10" class="materialize-textarea" required><?php
                                echo isset($pcontent_edit) ? $pcontent_edit : ''
                                ?></textarea>
                            <label for="pcontent">Post content</label>
                        </div>

                        <div class="input-field">
                            <select name="cid">
                                <?php
                                if (!empty($errors) && in_array('cid', $errors)) {
                                    echo "<p class='red-text'>Category id is not valid</p>";
                                }
                                ?>

                                <?php
                                $q1 = "SELECT cid, cname FROM category";
                                $r1 = mysqli_query($dbc, $q1);
                                confirm_query($r1, $q1);

                                if (mysqli_num_rows($r1) > 0) {
                                    while (list($cid, $cname) = mysqli_fetch_array($r1, MYSQLI_NUM)) {
                                        echo "<option";

                                        if ($cid_edit == $cid) {
                                            echo " selected ";
                                        }

                                        echo " value='{$cid}'>{$cname}</option>
                                            ";
                                    }
                                }
                                ?>
                            </select>
                            <label>Category</label>
                        </div>

                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>