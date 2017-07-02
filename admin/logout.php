<?php
session_start();
require_once "includes/functions.php";

if (!is_admin()) {
    redirect_to("login.php");
} else {
    session_destroy();
    redirect_to("login.php");
}


?>