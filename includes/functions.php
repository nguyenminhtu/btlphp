<?php
ob_start();

define("BASE_URL", "http://mycms.dev/");

function confirm_query($r, $q)
{
    if (!$r) {
        die("Loi khi thuc hien query! Query is: \n" . $q);
    }
}

function redirect_to($url = '')
{
    header("Location: " . BASE_URL . $url);
    ob_end_flush();
}


function pagination($display = 5, $id, $table, $url, $condition = null)
{
    global $dbc;
    global $start;

    if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $page = $_GET['p'];
    } else {
        if ($condition) {
            $q = "SELECT COUNT({$id}) FROM {$table} " . $condition;
        } else {
            $q = "SELECT COUNT({$id}) FROM {$table}";
        }
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
            $output .= "<li><a href='{$url}s=" . ($start - $display) . "&p={$page}'>Previous</a></li>";
        }

        // hien thi nhung trang con lai
        for ($i = 1; $i <= $page; $i++) {
            if ($i != $current_page) {
                $output .= "<li class='waves-effect'><a href='{$url}s=" . ($display * ($i - 1)) . "&p={$page}'>{$i}</a></li>";
            } else {
                $output .= "<li class='active'><a>{$i}</a></li>";
            }
        } // end for

        if ($current_page != $page) {
            $output .= "<li><a href='{$url}s=" . ($start + $display) . "&p={$page}'>Next</a></li>";
        }
    } // end section pagination
    $output .= "</ul></div>";

    echo $output;
}

function excert_text($text, $length)
{
    $safe_text = htmlentities($text, ENT_COMPAT, 'UTF-8');
    if (strlen($safe_text) > $length) {
        $cut = substr($safe_text, 0, $length);
        $cut2 = substr($safe_text, 0, strrpos($cut, '.'));
        return $cut2;
    } else {
        return $safe_text;
    }
}


function count_view($pid)
{
    global $dbc;
    $ip = $_SERVER['REMOTE_ADDR'];

    //truy van database xem pid da ton tai trong day chua
    $q = "SELECT vcount, vip FROM view WHERE pid = {$pid}";
    $r = mysqli_query($dbc, $q);

    confirm_query($r, $q);

    if (mysqli_num_rows($r) >= 1) {

        list($num, $dbip) = mysqli_fetch_array($r, MYSQLI_NUM);

        if ($dbip != $ip) {

            $q1 = "UPDATE view SET vcount = (vcount + 1) WHERE pid = {$pid}";
            $r1 = mysqli_query($dbc, $q1);
            confirm_query($r1, $q1);

        }

    } else {

        $q1 = "INSERT INTO view (pid, vcount, vip) VALUES ({$pid}, 1, '{$ip}')";
        $r1 = mysqli_query($dbc, $q1);
        confirm_query($r1, $q1);

    }
}


function sendmail($receive, $body)
{
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
<<<<<<< HEAD
    $mail->Username = 'gmail của ông';                 // SMTP username
    $mail->Password = 'mật khẩu gamil của ông';                           // SMTP password
=======
    $mail->Username = '';                 // SMTP username
    $mail->Password = '';                           // SMTP password
>>>>>>> f1d2f11cfe8c20afd72a4514eaff57956841452a
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25;                                    // TCP port to connect to

    $mail->setFrom('localhost@localhost', 'TinVit submission');
    $mail->addAddress($receive, 'User');     // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'TinVit email';
    $mail->Body = $body;

    if (!$mail->send()) {
        $result = false;
    } else {
        $result = true;
    }

    return $result;
}


function is_logged_in()
{

    return (isset($_SESSION['uid']));

}


function is_admin()
{

    return (isset($_SESSION['urole']) && $_SESSION['urole'] == 0);

}

?>
