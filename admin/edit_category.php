<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
}
?>


<?php
if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT)) {
    $cid = $_GET['cid'];
}

$q = "SELECT cname FROM category WHERE cid = {$cid}";
$r = mysqli_query($dbc, $q);
confirm_query($r, $q);

if (mysqli_num_rows($r) > 0) {
    list($cname) = mysqli_fetch_array($r, MYSQLI_NUM);
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cname'])) {
        $name_edit = $_POST['cname'];
        $q = "UPDATE category SET cname = '{$name_edit}' WHERE cid = {$cid} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            redirect_to("show_categories.php");
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
                    <form action="" method="post">
                        <h3>Sửa category
                            <small><?php if (isset($cname)) echo $cname; ?></small>
                        </h3>
                        <hr>
                        <div class="input-field">
                            <input id="cname" type="text" class="validate" name="cname"
                                   value="<?php if (isset($cname)) echo $cname; ?>">
                        </div>

                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>