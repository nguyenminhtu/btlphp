<?php
session_start();
require_once "includes/connect.php";
require_once "includes/functions.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $trimmed = array_map('trim', $_POST);

    $email = $trimmed['email'];
    $password = crypt($trimmed['password'], '$5$rounds=5000$anexamplestringforsalt$');


    $q = "SELECT uid, uname, uavatar, uactive, urole FROM user WHERE uemail = '{$email}' AND upassword = '{$password}'";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) == 1) {
        list($uid, $name, $avatar, $active, $role) = mysqli_fetch_array($r, MYSQLI_NUM);

        if ($active == null) {
            $_SESSION['uid'] = $uid;
            $_SESSION['uname'] = $name;
            $_SESSION['uavatar'] = $avatar;
            $_SESSION['urole'] = $role;
            echo 'ok';
        } else {
            echo 'not active';
        }
    } else {
        echo 'wrong';
    }


}


?>