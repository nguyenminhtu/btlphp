<?php
require_once "includes/connect.php";
require_once "includes/functions.php";

if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT)) {
    $cid = $_GET['cid'];

    $q = "DELETE FROM category WHERE cid = {$cid} LIMIT 1";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        echo "oke";
    } else {
        echo "fail";
    }
}

?>