<?php
require_once "includes/connect.php";
require_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];

    $q = "SELECT uid FROM user WHERE uemail = '{$email}'";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) == 1) {
        echo "fail";
    } else {
        echo "ok";
    }

}

?>