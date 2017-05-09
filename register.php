<?php
require_once('includes/PHPMailer/PHPMailerAutoload.php');
require_once "includes/connect.php";
require_once "includes/functions.php";
include_once "includes/navigation.php";
?>


<br>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col m9" style="padding-right: 20px !important;">

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $trimmed = array_map('trim', $_POST);

    $email = $trimmed['email'];
    $name = $trimmed['name'];
    $password = crypt($trimmed['password'], '$5$rounds=5000$anexamplestringforsalt$');

    $key = md5(uniqid(rand(), true));

    $q = "INSERT INTO user (uname, uemail, upassword, uactive, uavatar, urole, created_at)";
    $q.= " VALUES('{$name}', '{$email}', '{$password}', '{$key}', 'no-avatar.png', 1, NOW())";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {

        $body = "Cảm ơn bạn đã đăng kí thành viên. Phiền bạn click vào đường link để kích hoạt tài khoản <br><br>";
        $body .= BASE_URL . "active.php?x=" . urlencode($email) . "&y=" . $key;

        $message = sendmail($email, $body, "An email has been send to your email. Please check your email to active your account!");

    } else {
        $message = "<h4 class='center-align red-text'>Cannot register due to system error. Try again !</h4>";
    }
}


if (isset($message)) {

    echo $message;

}

?>

</div>

<?php
include_once "includes/sidebar.php";
?>
</div>
</div>
</div>


<?php
include_once "includes/footer.php";
?>
