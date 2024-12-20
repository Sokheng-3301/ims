<?php
    #Connection to DATABASE
    require_once('../ims-db-connection.php');

    #Check login 
    include_once('std-login-check.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../ims-include/head-tage.php');?>
    </head>
    <body>
        <!-- include preload for web page  -->
        <?php #include_once('../ims-include/preload.php');?>

        <!-- top header - header of system  -->
        <?php include_once('../ims-include/header.php'); ?>

        <section id="main-content" id="closeDetial" onclick="closeDetial()">
            <div class="container-ims">
                <div class="bg-profile py-4">
                    <div class="control-profile">
                        <div class="menu-side">
                            <div class="side-bar">
                                <ul>
                                    <li><a href="#my-profile"><i class="fa fa-user-circle-o" aria-hidden="true"></i> My profile</a></li>
                                    <li><a href="#family"><i class="fa fa-users" aria-hidden="true"></i> Family</a></li>
                                    <li><a href="#education-bg"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education background</a></li>
                                    <li><a href=""><i class="fa fa-refresh" aria-hidden="true"></i> Change password</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="pro-info">
                            <p class="pro-title" id="my-profile">
                                <i class="fa fa-refresh" aria-hidden="true"></i> Change your password
                            </p>
                            <div class="change-password">
                                <form action="">
                                    <div class="input-control">
                                        <input type="text" placeholder="Current password">
                                    </div>
                                    <div class="input-control">
                                        <input type="text" placeholder="New password">
                                    </div>
                                    <div class="input-control">
                                        <input type="text" placeholder="Confirm password">
                                    </div>
                                    <button>Change password</button>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- footer of system  -->
        <?php include_once('../ims-include//footer.php');?>

        <!-- include javaScript in web page  -->
        <?php include_once('../ims-include/script-tage.php');?>
</body>
</html>