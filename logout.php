<?php
session_start();
require_once "includes/functions.php";


if (isset($_SESSION['uid'])) {

    session_destroy();
    redirect_to("");

} else {
    redirect_to("");
}


?>