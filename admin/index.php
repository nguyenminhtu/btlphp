<?php
require_once("includes/navigation.php");
?>

<main>
    <div class="">
        <div class="row">
            <?php
                require_once "includes/sidebar.php";
            ?>

            <div class="col m10 center-align">
                <h3 class="center-align">Welcome Admin</h3>
                <p>There is:
                    <?php
                    if (count_category() != null) {
                        echo count_category();
                    }
                    ?>
                    category.
                </p>

                <p>There is:
                    <?php
                    if (count_post() != null) {
                        echo count_post();
                    }
                    ?>
                    post.
                </p>

                <p>There is:
                    <?php
                    if (count_user() != null) {
                        echo count_user();
                    }
                    ?>
                    user.
                </p>

                <p>There is:
                    <?php
                    if (count_comment() != null) {
                        echo count_comment();
                    }
                    ?>
                    comment.
                </p>
            </div>
        </div>
    </div>
</main>


<?php
    require_once("includes/footer.php");
?>