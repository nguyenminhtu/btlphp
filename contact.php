<?php
$title = "Contact";
include_once "includes/navigation.php";
?>

    <br>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col m9" style="padding-right: 20px !important;">
                    <h4>Do you want to get in touch with admin ? Please fill out this form.</h4>
                    <p id="check-error-submit"></p>
                    <br>
                    <form action="" method="post" id="form-send-feedback">
                        <div class="input-field">
                            <input type="text" name="name" id="name" autofocus required>
                            <label for="name">Your Name</label>
                        </div>

                        <div class="input-field">
                            <input type="email" name="email" id="email" required>
                            <label for="email">Your Email</label>
                            <p id="email-error"></p>
                        </div>

                        <div class="input-field">
                            <textarea name="message" id="message" data-length="1000" rows="10" required
                                      class="materialize-textarea"></textarea>
                            <label for="message">Your Message</label>
                        </div>

                        <div class="center-align">
                            <button type="submit" class="btn waves-effect waves-purple center" id="send-feedback">Send
                            </button>
                        </div>
                        <div class="spinner row">
                            <div class="center-align">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-blue">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>

                                    <div class="spinner-layer spinner-red">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>

                                    <div class="spinner-layer spinner-yellow">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>

                                    <div class="spinner-layer spinner-green">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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