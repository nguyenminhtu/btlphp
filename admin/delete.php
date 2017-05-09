<?php
require_once "includes/connect.php";
require_once "includes/functions.php";

// kiem tra category id co hop le ko de xoa
if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT)) {
    $cid = $_GET['cid'];

    $q = "DELETE FROM category WHERE cid = {$cid} LIMIT 1";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        $q1 = "SELECT pid FROM post WHERE cid = {$cid}";
        $r1 = mysqli_query($dbc, $q1);
        confirm_query($r1, $q1);

        if (mysqli_num_rows($r1) > 0) {
            while ($posts = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {

                $q2 = "DELETE FROM comment WHERE pid = {$posts['pid']}";
                $r2 = mysqli_query($dbc, $q2);
                confirm_query($r2, $q2);

            }
            echo "oke";
        } else {
            echo "fail";
        }
    } else {
        echo "fail";
    }
}


// kiem tra post id co hop le ko de xoa
if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT)) {
    $pid = $_GET['pid'];

    $q = "DELETE FROM post WHERE pid = {$pid} LIMIT 1";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        $q1 = "DELETE FROM comment WHERE pid = {$pid}";
        $r1 = mysqli_query($dbc, $q1);
        confirm_query($r1, $q1);

        if (mysqli_affected_rows($dbc) > 0) {
            echo "oke";
        } else {
            echo "fail";
        }
    } else {
        echo "fail";
    }
}


// kiem tra comment id co hop le ko de xoa
if (isset($_GET['cmid']) && filter_var($_GET['cmid'], FILTER_VALIDATE_INT)) {
    $cmid = $_GET['cmid'];

    $q = "DELETE FROM comment WHERE cmid = {$cmid} LIMIT 1";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        echo "oke";
    } else {
        echo "fail";
    }
}


// kiem tra user id co hop le ko de xoa
if (isset($_GET['uid']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT)) {
    $uid = $_GET['uid'];

    $q = "DELETE FROM user WHERE uid = {$uid} LIMIT 1";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_affected_rows($dbc) == 1) {
        $q1 = "DELETE FROM comment WHERE uid = {$uid}";
        $r1 = mysqli_query($dbc, $q1);
        confirm_query($r1, $q1);

        if (mysqli_affected_rows($dbc) > 0) {
            echo "oke";
        } else {
            echo "fail";
        }
    } else {
        echo "fail";
    }
}
?>