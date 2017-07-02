<?php

define("BASE_URL", "http://mycms.dev/admin/");

function confirm_query($r, $q)
{
    if (!$r) {
        die("Loi khi thuc hien query! Query is: \n" . $q);
    }
}

function redirect_to($url = '')
{
    header("Location: " . BASE_URL . $url);
}

function count_category()
{
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

function count_post()
{
    global $dbc;
    $q = "SELECT COUNT(pid) FROM post";
    $r = mysqli_query($dbc, $q);
    confirm_query($r, $q);

    if (mysqli_num_rows($r) > 0) {
        list($kq) = mysqli_fetch_array($r, MYSQLI_NUM);
        return $kq;
    } else {
        return null;
    }
}

function count_user()
{
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

function count_comment()
{
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


function pagination($display = 5, $id, $table, $url)
{
    global $dbc;
    global $start;

    if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $page = $_GET['p'];
    } else {
        $q = "SELECT COUNT({$id}) FROM {$table}";
        $r = mysqli_query($dbc, $q);

        confirm_query($r, $q);

        list($record) = mysqli_fetch_array($r, MYSQLI_NUM);

        // kiem tra so bai post co lon hon so bai trong 1 page hay ko
        if ($record > $display) {
            $page = ceil($record / $display);
        } else {
            $page = 1;
        }
    }

    $output = "<div class='row center-align'><ul class='pagination'>";
    if ($page > 1) {
        $current_page = ($start / $display) + 1;

        // neu khong phai o trang dau thi se hien thi trang truoc
        if ($current_page != 1) {
            $output .= "<li><a href='{$url}.php?s=" . ($start - $display) . "&p={$page}'>Previous</a></li>";
        }

        // hien thi nhung trang con lai
        for ($i = 1; $i <= $page; $i++) {
            if ($i != $current_page) {
                $output .= "<li class='waves-effect'><a href='{$url}.php?s=" . ($display * ($i - 1)) . "&p={$page}'>{$i}</a></li>";
            } else {
                $output .= "<li class='active'><a>{$i}</a></li>";
            }
        } // end for

        if ($current_page != $page) {
            $output .= "<li><a href='{$url}.php?s=" . ($start + $display) . "&p={$page}'>Next</a></li>";
        }
    } // end section pagination
    $output .= "</ul></div>";

    echo $output;
}


function is_admin()
{
    return (isset($_SESSION['urole']) && $_SESSION['urole'] == 0);
}

?>
