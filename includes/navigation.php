<?php
session_start();
require_once "includes/connect.php";
require_once("includes/functions.php");
?>

        <!DOCTYPE html>
<html>
<head>
    <title>TinVit - <?php echo isset($title) ? $title : 'Homepage' ?></title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="public/lib/css/materialize.css" />
    <link rel="stylesheet" href="public/lib/css/material-scrolltop.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="public/lib/css/sweetalert.css">
    <link rel="stylesheet" href="public/lib/css/custom.css">
</head>

<body>
<!--Import jQuery before materialize.js-->


<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="brand-logo">TinVit.VN</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a class="modal-trigger" href="#loginModal">Login</a></li>
                <li><a class="modal-trigger" href="#registerModal">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
<button class="material-scrolltop" type="button"></button>


<!-- Modal login -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col m12" style="padding-top: 50px;">
                <h4 class="center-align">Login To Website</h4>
                <hr>
                <br>
                <form action="login.php" method="post">
                    <div class="input-field">
                        <input type="email" name="email" id="email" autofocus>
                        <label for="email">Email</label>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password">
                        <label for="password">Password</label>
                    </div>

                    <div class="input-field center-align">
                        <button type="submit" class="btn btn-block waves-effect waves-light" id="login-button">Login</button>
                        <br><br>
                        <p class="center-align"><a href="#" class="register-instead">Register</a></p>
                        <br>
                        <p class="center-align"><a href="#" class="forgot-password">Forgot Password</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal register -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col m12">
                <h4 class="center-align">Register for free</h4>
                <hr>
                <br>
                <form action="register.php" method="post" id="register-form">
                    <div class="input-field">
                        <input type="text" name="name" id="name" required autofocus>
                        <label for="name">Name</label>
                    </div>

                    <div class="input-field">
                        <input type="email" name="email" id="email" required>
                        <label for="email">Email</label>
                        <p id="email-error"></p>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Password</label>
                        <p id="password-error"></p>
                    </div>

                    <div class="input-field">
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <label for="confirm_password">Confirm Password</label>
                    </div>

                    <div class="input-field center-align">
                        <button type="submit" class="btn btn-block waves-effect waves-light" id="register-button">Register</button>
                        <br>
                        <br>
                        <p class="center-align"><a href="#" class="login-instead">Log in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal forgot password -->
<div id="forgotPasswordModal" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col m12" style="padding-top: 50px;">
                <h4 class="center-align">Forgot Password</h4>
                <hr>
                <br>
                <form action="forgot_password.php" method="post">
                    <div class="input-field">
                        <input type="email" name="email" id="email" required autofocus>
                        <label for="email">Enter your email here...</label>
                    </div>

                    <div class="input-field center-align">
                        <button type="submit" class="btn btn-block waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>