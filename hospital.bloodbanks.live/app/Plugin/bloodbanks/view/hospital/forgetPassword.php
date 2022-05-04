<!doctype html>
<html class="fixed">
    <head>
        <title>Forgot password</title>
        <!-- Basic -->
        <meta charset="UTF-8">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/datepicker3.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/mOrdernizr.js"></script>

    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Forgot password</h2>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <?php
                            if (isset($_GET['status']))
                                switch ($_GET['status']) {
                                    case 1: echo '<p style="color: red;">Password reset request successful. Please check your email for login information</p>';
                                        break;
                                    case -1: echo '<p style="color: red;">Password reset request failed</p>';
                                        break;
                                    case -2: echo '<p style="color: red;">Your account is locked</p>';
                                        break;
                                    case -4: echo '<p style="color: red;">Your username or email does not exist</p>';
                                        break;
                                }
                            ?>
							<div class="form-group mb-lg">
                                <label>Account:</label>
                                <div class="input-group input-group-icon">
                                    <input name="user" type="text" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 ">
                                   <a href="/login">Login</a>
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Send</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Send</button>
                                </div>
                            </div>
                            <br/>

                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-md mb-md">Lao Cai High School for the Gifted</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.browser.mobile.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/bootstrap.js"></script>
        <!-- <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/nanoscroller.js"></script> -->
        <!-- <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/bootstrap-datepicker.js"></script> -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/magnific-popup.js"></script>
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.placeholder.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.js"></script>

        <!-- Theme Custom -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.init.js"></script>

    </body>
</html>