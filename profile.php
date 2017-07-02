<?php
require_once "includes/connect.php";
require_once "includes/functions.php";

include_once "includes/navigation.php";


if (is_logged_in()) {


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();

        // upload avatar
        if (isset($_FILES['avatar'])) {

            $allowed = array("image/jpg", "image/jpeg", "image/png");

            if (in_array($_FILES['avatar']['type'], $allowed)) {

                $ext = end(explode('.', $_FILES['avatar']['name']));

                $avatar = uniqid(rand(), true) . '.' . $ext;

                if ($_POST['old_avatar'] != 'no-avatar.png') {

                    if (unlink("public/uploads/avatars/" . $_POST['old_avatar'])) {

                        if (move_uploaded_file($_FILES['avatar']['tmp_name'], "public/uploads/avatars/" . $avatar)) {

                            $q = "UPDATE user SET uavatar = '{$avatar}' WHERE uid = {$_SESSION['uid']} LIMIT 1";
                            $r = mysqli_query($dbc, $q);
                            confirm_query($r, $q);

                            if (mysqli_affected_rows($dbc) == 1) {

                                $_SESSION['uavatar'] = $avatar;
                                redirect_to("profile.php");

                            } else {
                                $errors[] = "system error";
                            }

                        }

                    }

                } else {

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], "public/uploads/avatars/" . $avatar)) {

                        $q = "UPDATE user SET uavatar = '{$avatar}' WHERE uid = {$_SESSION['uid']} LIMIT 1";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        if (mysqli_affected_rows($dbc) == 1) {

                            redirect_to("profile.php");

                        } else {
                            $errors[] = "system error";
                        }

                    }

                }

            } else {
                $errors[] = "wrong format";
            }

        }

        //change name
        if (isset($_POST['uname'])) {

            $name = mysqli_real_escape_string($dbc, $_POST['uname']);

            $q = "UPDATE user SET uname = '{$name}' WHERE uid = {$_SESSION['uid']}";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            if (mysqli_affected_rows($dbc) == 1) {

                $_SESSION['uname'] = $name;

            } else {
                $message = "<p class='green-text center-align'>Your name was updated successfully !</p>";
            }

        }


        // change password
        if (isset($_POST['new_password'])) {

            $trimmed = array_map('trim', $_POST);

            $new_password = crypt($trimmed['new_password'], '$5$rounds=5000$anexamplestringforsalt$');

            $current_password = crypt($trimmed['current_password'], '$5$rounds=5000$anexamplestringforsalt$');

            $q = "SELECT uid FROM user WHERE uid = {$_SESSION['uid']} AND upassword = '{$current_password}'";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);

            if (mysqli_num_rows($r) == 1) {

                $q1 = "UPDATE user SET upassword = '{$new_password}' WHERE uid = {$_SESSION['uid']}";
                $r1 = mysqli_query($dbc, $q1);
                confirm_query($r1, $q1);

                if (mysqli_affected_rows($dbc) == 1) {

                    $message_password = "<p class='green-text'>Your password was updated successfully !</p>";

                } else {

                    $message_password = "<p class='red-text'>Your password could not be changed due to system error !</p>";

                }

            } else {
                $message_password = "<p class='red-text'>Your current password is not valid !</p>";
            }

        }

    }


    $q = "SELECT uname, uemail, uavatar, DATE_FORMAT(created_at, '%h:%i %p %d/%m/%Y') AS date FROM user WHERE uid = {$_SESSION['uid']}";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) == 1) {
        list($name, $email, $avatar, $date) = mysqli_fetch_array($r, MYSQLI_NUM);
        ?>


        <br>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col m9" style="padding-right: 20px !important;">


                        <div class="row">
                            <div class="col m6" style="border: 1px solid #f3f4ee;">
                                <img src="public/uploads/avatars/<?php echo $avatar; ?>" alt="<?php echo $name; ?>"
                                     class="materialboxed responsive-img">
                            </div>

                            <div class="col m6">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <h4 class="center-align">Change Avatar</h4>
                                    <hr>
                                    <br><br>

                                    <div class="input-field">
                                        <?php
                                        if (isset($errors) && in_array("wrong format", $errors)) {

                                            echo "<p class='red-text'>Image is not valid. Image must be jpeg, jpg or png.</p>";

                                        }
                                        if (isset($errors) && in_array("system error", $errors)) {

                                            echo "<p class='red-text'>Avatar could not be upload due to system error. Sorry for inconvenience !</p>";

                                        }
                                        ?>
                                        <input type="hidden" name="old_avatar" value="<?php echo $avatar; ?>">
                                        <div class="file-field input-field">
                                            <div class="btn">
                                                <span>Choose file to upload</span>
                                                <input type="file" name="avatar" required>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" required name="avatar">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-field center-align">
                                        <button type="submit" class="btn waves-effect waves-orange">Save Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <br>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col m8 offset-m2">
                                <h4 class="center-align">User Info</h4>
                                <?php
                                if (isset($message)) {
                                    echo $message;
                                }
                                ?>

                                <form action="" method="post">
                                    <div class="input-field">
                                        <input type="text" name="uname" id="uname" value="<?php echo $name; ?>"
                                               required>
                                        <label for="uname">Full Name</label>
                                    </div>

                                    <div class="input-field">
                                        <input type="text" disabled id="uemail" value="<?php echo $email; ?>">
                                        <label for="uemail">Email</label>
                                    </div>

                                    <button class="btn waves-effect waves-purple center-align" type="submit">Save
                                        Changes
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <br>
                            <hr>
                            <br>
                        </div>

                        <div class="row">
                            <div class="col m8 offset-m2 center-align">
                                <?php
                                if (isset($message_password)) {
                                    echo $message_password;
                                }
                                ?>

                                <form action="" id="form-change-password" method="post" class="">
                                    <p class="center-align" id="no-current-password"></p>
                                    <h4 class="center-align">Change Password</h4>
                                    <div class="input-field">
                                        <input type="password" name="new_password" id="new_password" required>
                                        <label for="new_password">New Password</label>
                                    </div>

                                    <div class="input-field">
                                        <input type="password" name="confirm_new_password" id="confirm_new_password"
                                               required>
                                        <label for="confirm_new_password">Confirm New Password</label>
                                        <p id="error-new-password"></p>
                                    </div>

                                    <div class="input-field">
                                        <input type="password" name="current_password" id="current_password" required>
                                        <label for="current_password">Current Password</label>
                                    </div>

                                    <div class="input-field">
                                        <button type="submit" class="btn waves-effect waves-green" id="change_password"
                                                name="change_password">Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>

                    <?php
                    include_once "includes/sidebar.php";
                    ?>
                </div>
            </div>
        </div>


        <?php

        include_once "includes/footer.php";

    }


} else {

    redirect_to("");

}

?>