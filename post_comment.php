<?php
session_start();
require_once "includes/connect.php";
require_once "includes/functions.php";

if (isset($_SESSION['uid'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $content = mysqli_real_escape_string($dbc, $_POST['content']);
        $uid = $_POST['uid'];
        $pid = $_POST['pid'];

        $q = "INSERT INTO comment (uid, pid, cmcontent, created_at) VALUES ({$uid}, {$pid}, '{$content}', NOW())";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);

        if (mysqli_affected_rows($dbc) == 1) {
            $q1 = "SELECT cmid FROM comment ORDER BY created_at DESC LIMIT 1";
            $r1 = mysqli_query($dbc, $q1);
            confirm_query($r1, $q1);

            if (mysqli_num_rows($r1) == 1) {
                list($cmid) = mysqli_fetch_array($r1, MYSQLI_NUM);
                echo $cmid;
            }
        } else {
            echo "fail";
        }

    }

} else {
    redirect_to("");
}


?>