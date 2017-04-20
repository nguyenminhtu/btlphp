<?php

define("BASE_URL", "http://mycms.dev/admin/");

function confirm_query($r, $q) {
    if (!$r) {
        die("Loi khi thuc hien query! Query is: \n" . $q);
    }
}

function redirect_to($url = '') {
    header("Location: " . BASE_URL . $url);
}

function count_category() {
    global $dbc;
    $q = "SELECT COUNT(cid) FROM category";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {
        list($kq) = mysqli_fetch_array($r, MYSQLI_NUM);
        return $kq;
    } else {
        return null;
    }
}

function count_post() {
    global $dbc;
    $q = "SELECT COUNT(pid) FROM post";
    $r = mysqli_query($dbc, $q) ;
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {
        list($kq) = mysqli_fetch_array($r, MYSQLI_NUM);
        return $kq;
    } else {
        return null;
    }
}

function count_user() {
    global $dbc;
    $q = "SELECT COUNT(uid) FROM user";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {
        list($kq) = mysqli_fetch_array($r, MYSQLI_NUM);
        return $kq;
    } else {
        return null;
    }
}

function count_comment() {
    global $dbc;
    $q = "SELECT COUNT(cmid) FROM comment";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {
        list($kq) = mysqli_fetch_array($r, MYSQLI_NUM);
        return $kq;
    } else {
        return null;
    }
}

function showNotice() {
    if (isset($_SESSION['notice'])) {
        echo "
            <nav>
                <div class=\"nav-wrapper\">
                  <div class=\"col m12\ center-align green\">
                       {$_SESSION['notice']}
                  </div>
                </div>
              </nav>
        ";
        session_unset('notice');
    }

    if (isset($_SESSION['error'])) {
        echo "
            <nav>
                <div class=\"nav-wrapper\">
                  <div class=\"col m12\ center-align\">
                       {$_SESSION['error']}
                  </div>
                </div>
              </nav>
        ";
        session_unset('error');
    }
}

?>
