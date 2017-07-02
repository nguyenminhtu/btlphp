<?php
require_once('includes/PHPMailer/PHPMailerAutoload.php');
require_once "includes/connect.php";
require_once "includes/functions.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $trimmed = array_map('trim', $_POST);

    $name = $trimmed['name'];
    $email = $trimmed['email'];
    $message = $trimmed['message'];

    $owner = "tuunguyen2795@gmail.com";


    $body = "<strong>Name:</strong> " . $name . " <br><br> <strong>Email:</strong> " . $email . " <br><br><strong>Message:</strong> " . $message;

    if (sendmail($owner, $body)) {
        echo 'ok';
    } else {
        echo 'fail';
    }

}


?>