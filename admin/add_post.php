<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
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
            if (!move_uploaded_file($_FILES['pimage']['tmp_name'], "../public/uploads/images/" . $pimage)) {

                $errors[] = "upload failed";

            }

        } else {

            $errors[] = "wrong format";

        }

    }


    if (empty($errors)) {

        $q = "INSERT INTO post (ptitle, pimage, pcontent, cid, created_at) VALUES ";
        $q .= " ('{$title}', '{$pimage}', '{$content}', $cid, NOW())";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) > 0) {

            $result = "<p class='green-text'>The post was created successfully.</p>";

            $_POST = [];

            redirect_to("show_posts.php");

            echo "<script>Materialize.toast('Your post was created successfully', 4000);</script>";

        } else {

            $result = "<p class='red-text'>An error has occured when insert to database. Sorry for inconvenience.</p>";

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
                        <h3>Thêm mới post</h3>
                        <hr>
                        <div class="input-field">
                            <input id="ptitle" type="text" class="validate" name="ptitle" autofocus required
                                   value="<?php echo isset($_POST['ptitle']) ? $_POST['ptitle'] : '' ?>">
                            <label for="ptitle">Post title</label>
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
                                    <input type="file" name="pimage" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" required name="pimage">
                                </div>
                            </div>
                        </div>

                        <div class="input-field">
                            <textarea name="pcontent" id="pcontent" rows="10" class="materialize-textarea" required><?php
                                echo (isset($_POST['pcontent'])) ? $_POST['pcontent'] : ''
                                ?></textarea>
                            <label for="pcontent">Post content</label>
                        </div>

                        <div class="input-field">
                            <select name="cid" required>
                                <?php
                                if (!empty($errors) && in_array('cid', $errors)) {
                                    echo "<p class='red-text'>Category id is not valid</p>";
                                }
                                ?>
                                <option disabled selected>Choose your option</option>
                                <?php
                                $q1 = "SELECT cid, cname FROM category";
                                $r1 = mysqli_query($dbc, $q1);
                                confirm_query($r1, $q1);

                                if (mysqli_num_rows($r1) > 0) {
                                    while (list($cid, $cname) = mysqli_fetch_array($r1, MYSQLI_NUM)) {
                                        echo "
                                                <option value='{$cid}'>{$cname}</option>
                                            ";
                                    }
                                }
                                ?>
                            </select>
                            <label>Category</label>
                        </div>

                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>