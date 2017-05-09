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
    <link type="text/css" rel="stylesheet" href="lib/css/materialize.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="lib/css/custom.css">
</head>

<body>
<!--Import jQuery before materialize.js-->


<nav>
    <div class="nav-wrapper">
        <a href="<?php echo BASE_URL; ?>" class="brand-logo">TinVit.VN - Admin Dashboard</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="">Sass</a></li>
        </ul>
    </div>
</nav>