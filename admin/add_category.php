<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cname'])) {
        $cname = $_POST['cname'];
    }

    $q = "INSERT INTO category (cname) VALUES ('{$cname}')";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        redirect_to('show_categories.php');
        echo "<script>Materialize.toast('Category was created successfully', 3000);</script>";
    } else {
        echo "Error when insert to database. Sorry for inconvenience !";
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
                        <h3>Thêm mới category</h3>
                        <hr>
                        <div class="input-field">
                            <input id="cname" type="text" class="validate" name="cname">
                            <label for="cname">Category name</label>
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