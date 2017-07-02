<?php
session_start();
require_once "includes/connect.php";
require_once "includes/functions.php";
if (is_admin()) {
    redirect_to("index.php");
}
?>




<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    $trimmed = array_map('trim', $_POST);

    $email = mysqli_real_escape_string($dbc, $trimmed['email']);
    $password = crypt(mysqli_real_escape_string($dbc, $trimmed['password']), '$5$rounds=5000$anexamplestringforsalt$');

    $q = "SELECT uid, uname, uavatar, urole FROM user WHERE uemail = '{$email}' AND upassword = '{$password}'";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) == 1) {

        list($uid, $name, $avatar, $role) = mysqli_fetch_array($r, MYSQLI_NUM);

        if ($role == 0) {

            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $name;
            $_SESSION['uavatar'] = $avatar;
            $_SESSION['urole'] = $role;
            redirect_to("index.php");

        } else {

            $errors[] = "error";

        }

    } else {
        $errors[] = "error";
    }

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="lib/css/materialize.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="lib/css/custom.css">
</head>
<body>
<main>
    <div class="">
        <div class="row">

            <div class="col m4 offset-m4">
                <form action="" method="post" style="margin-top: 150px;">
                    <h3 class="center-align">LOGIN</h3>
                    <?php
                    if (!empty($errors)) {
                        echo "<p class='center-align red-text'>Wrong credentials</p>";
                    }
                    ?>
                    <hr>
                    <br>
                    <div class="input-field">
                        <input id="email" type="email" name="email" required>
                        <label for="email">Your email</label>
                    </div>

                    <div class="input-field">
                        <input id="password" type="password" name="password" required>
                        <label for="password">Your password</label>
                    </div>

                    <div class="input-field center-align">
                        <button type="submit" class="btn waves-effect waves-light">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript" src="lib/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/js/materialize.js"></script>
<script type="text/javascript" src="lib/js/remove.js"></script>
</body>
</html>