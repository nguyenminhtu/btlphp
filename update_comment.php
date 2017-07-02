<?php
session_start();
require_once "includes/connect.php";
require_once "includes/functions.php";


if (isset($_SESSION['uid'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $content = mysqli_real_escape_string($dbc, $_POST['content']);

        $id = $_POST['id'];

        $q = "UPDATE comment SET cmcontent = '{$content}' WHERE cmid = {$id} LIMIT 1";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) == 1) {

            echo "ok";

        } else {
            echo "fail";
        }

    }

} else {
    redirect_to("");
}


?>