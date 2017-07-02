<?php
require_once "includes/connect.php";
include_once "includes/functions.php";
include_once "includes/navigation.php";
?>

    <br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col m9" style="padding-right: 20px !important;">

                    <?php
                    if (isset($_GET['x'], $_GET['y']) && preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,5}$/', $_GET['x']) && strlen($_GET['y']) == 32) {

                        $email = $_GET['x'];
                        $token = $_GET['y'];

                        $q = "UPDATE user SET uactive = NULL WHERE uemail = '{$email}' AND uactive = '{$token}' LIMIT 1";
                        $r = mysqli_query($dbc, $q);
                        confirm_query($r, $q);

                        if (mysqli_affected_rows($dbc) == 1) {

                            echo "<h4 class='center-align green-text'>Your account has been activated successfully. Now you can login to website !</h4>";

                        } else {

                            echo "<h4 class='center-align red-text'>An error has occured. Sorry for inconvenience !</h4>";

                        }

                    } else {
                        redirect_to("");
                    }
                    ?>

                </div>

                <?php
                include_once "includes/sidebar.php";
                ?>
            </div>
        </div>
    </div>


<?php
include_once "includes/footer.php";
?>