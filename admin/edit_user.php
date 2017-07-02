<?php
require_once("includes/navigation.php");
if (!is_admin()) {
    redirect_to("login.php");
}
?>


<?php
if (isset($_GET['uid']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT)) {
    $uid = $_GET['uid'];
}

$q = "SELECT uname, uemail, uavatar, urole, uactive, DATE_FORMAT(created_at, '%h:%i %p %d/%m/%Y') AS date FROM user WHERE uid = {$uid}";
$r = mysqli_query($dbc, $q);
confirm_query($r, $q);

if (mysqli_num_rows($r) > 0) {
    list($uname, $uemail, $uavatar, $urole, $uactive, $date) = mysqli_fetch_array($r, MYSQLI_NUM);
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $role = $_POST['urole'];
    $active = $_POST['uactive'];

    if ($active == 1) {
        $q = "UPDATE user SET urole = {$role}, uactive = 'tinvit' WHERE uid = {$uid} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            $message = "<p class='center-align green-text'>Account has been updated successfully !</p>";
        } else {
            $message = "<p class='center-align red-text'>An error has occured. Try again !</p>";
        }
    } else {
        $q = "UPDATE user SET urole = {$role}, uactive = NULL WHERE uid = {$uid} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            $message = "<p class='center-align green-text'>Account has been updated successfully !</p>";
        } else {
            $message = "<p class='center-align red-text'>An error has occured. Try again !</p>";
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
                        <h3>Edit user
                            <small><?php if (isset($uname)) echo $uname; ?></small>
                        </h3>
                        <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <hr>
                        <div class="input-field">
                            <div class="row">
                                <div class="col m6 offset-m3">
                                    <img
                                        src="../public/uploads/avatars/<?php echo (isset($uavatar)) ? $uavatar : "" ?>"
                                        alt="" class="circle" height="200px">
                                </div>
                            </div>
                        </div>

                        <div class="input-field">
                            <input id="uname" type="text" disabled class="validate" name="uname"
                                   value="<?php if (isset($uname)) echo $uname; ?>">
                            <label for="uname">Full Name</label>
                        </div>

                        <div class="input-field">
                            <input id="uemail" type="email" disabled class="validate" name="uemail"
                                   value="<?php if (isset($uemail)) echo $uemail; ?>">
                            <label for="uemail">Email</label>
                        </div>

                        <div class="input-field">
                            <input id="created_at" type="text" disabled class="validate" name="created_at"
                                   value="<?php if (isset($date)) echo $date; ?>">
                            <label for="created_at">Joined At</label>
                        </div>

                        <div class="input-field">
                            <select name="urole" id="urole">
                                <option value="1" <?php echo (isset($urole) && $urole == 1) ? "selected" : "" ?> >User
                                </option>
                                <option value="0" <?php echo (isset($urole) && $urole == 0) ? "selected" : "" ?> >
                                    Admin
                                </option>
                            </select>
                            <label for="urole">Role</label>
                        </div>

                        <div class="input-field">
                            <select name="uactive" id="uactive">
                                <option
                                    value="1" <?php echo (isset($uactive) && $uactive != null) ? "selected" : "" ?> >Non
                                    Activated
                                </option>
                                <option
                                    value="0" <?php echo (isset($uactive) && $uactive == null) ? "selected" : "" ?> >
                                    Activated
                                </option>
                            </select>
                            <label for="uactive">Active</label>
                        </div>

                        <div class="input-field">
                            <button type="submit" class="btn waves-effect waves-light">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php
require_once("includes/footer.php");
?>