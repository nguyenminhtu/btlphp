<?php
require_once('includes/PHPMailer/PHPMailerAutoload.php');
require_once "includes/connect.php";
require_once "includes/functions.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $trimmed = array_map("trim", $_POST);

    $email = $trimmed['email'];

    $q = "SELECT uid FROM user WHERE uemail = '{$email}'";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) == 1) {

        list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);

        $temp = substr(uniqid(rand(), true), 3, 6);
        $pass = crypt($temp, '$5$rounds=5000$anexamplestringforsalt$');

        $q1 = "UPDATE user SET upassword = '{$pass}' WHERE uid = {$uid} LIMIT 1";
        $r1 = mysqli_query($dbc, $q1);
        confirm_query($r1, $q1);

        if (mysqli_affected_rows($dbc) == 1) {
            $body = "Your password has been temporarily changed to '{$temp}'. Please use this email address and the new password to login to website. You can change this password later !";
            if (sendmail($email, $body)) {
                echo "ok";
            } else {
                echo "fail";
            }
        } else {
            echo "system error";
        }

    } else {

        echo "email not found";

    }

}


?>