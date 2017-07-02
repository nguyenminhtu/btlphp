<?php
session_start();
require_once "includes/connect.php";
require_once "includes/functions.php";

if (isset($_SESSION['uid'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = $_POST['id'];

        $q = "SELECT uid FROM comment WHERE cmid = {$id}";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_num_rows($r) == 1) {
            list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);

            if ($uid != $_SESSION['uid'] && $_SESSION['urole'] != 0) {
                redirect_to("");
            } else {

                $q1 = "DELETE FROM comment WHERE cmid = {$id} LIMIT 1";
                $r1 = mysqli_query($dbc, $q1);
                confirm_query($r1, $q1);

                if (mysqli_affected_rows($dbc) == 1) {

                    echo "ok";

                } else {
                    echo "fail";
                }

            }
        }

    }

} else {
    redirect_to("");
}

?>