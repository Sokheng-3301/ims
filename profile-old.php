<?php
    #Connection to DATABASE
    require_once('../ims-db-connection.php');
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


        <!-- main content of system  -->
        <section id="main-content" id="closeDetial" onclick="closeDetial()">
            <div class="container-ims">
                <div class="control-personal-info py-5">
                    <div class="personal-info p-4">
                        <div class="img-profile">
                            <img src="<?=SITEURL?>ims-assets/ims-images/profile.jpg" alt="">
                        </div>
                        <div class="text-profile">
                            <h4>Eam ratha <span class="email">
                                eamratha3333@gmail.com
                            </span></h4>
                            <!-- <p>Student id: </p><span class="pro-content">23456543</span>
                            <p>Department:</p><span class="pro-content">Computer Science</span>
                            <p>Generation:</p><span class="pro-contnet">4</span>                      -->
                            <!-- <p class="btn btn-success px-5 text-center m-auto">Update your profile</p> -->

                            <div class="short-info">
                                <p class="title">Student ID</p><span>:</span> <p>1212012</p>
                            </div>
                            <div class="short-info">
                                <p class="title">Department</p><span>:</span> <p>Computer Science</p>
                            </div>
                            <div class="short-info">
                                <p class="title">Generation</p><span>:</span> <p>4</p>
                            </div>
                            <a href="" class="update-btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update your profile</a>
                        </div>
                    </div>
                    <div class="personal-info-detial p-4">
                        <div class="info-title">
                            <p>Personal information</p>  
                        </div>
                        <div class="info-detial">
                        
                        </div>


                        
                        <div class="info-title">
                            <p>Education background</p>
                        </div>
                        <div class="info-detial">
                            <ul>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                            </ul>
                        </div>

                        <div class="info-title">
                            <p>Your family</p>
                        </div>
                        <div class="info-detial">
                            <ul>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                            </ul>
                        </div>

                        <div class="info-title">
                            <p>Other</p>
                        </div>
                        <div class="info-detial">
                            <ul>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                                <li>
                                    <p>Your Personal info</p>
                                </li>
                            </ul>
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