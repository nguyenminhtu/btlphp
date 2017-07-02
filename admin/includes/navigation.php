<?php
session_start();
require_once "includes/connect.php";
require_once("includes/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="lib/css/materialize.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="lib/css/custom.css">
</head>

<body>
<!--Import jQuery before materialize.js-->


<nav>
    <div class="nav-wrapper">
        <a href="<?php echo BASE_URL; ?>" class="brand-logo">TinVit - Admin Dashboard</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="/" target="_blank">Client Site</a></li>
            <li class='no-padding'><a href='' id='avatar'><img class='responsive-img' height='50' width='50'
                                                               src='../public/uploads/avatars/<?php echo $_SESSION['uavatar']; ?>'/></a>
            </li>
            <ul id='dropdown1' class='dropdown-content'>
                <li><a href='logout.php'>Log out</a></li>
            </ul>
            <li><a class='dropdown-button' href='#' data-activates='dropdown1'>  <?php echo $_SESSION['uname']; ?><i
                        class='material-icons right'>arrow_drop_down</i></a></li>
        </ul>
    </div>
</nav>