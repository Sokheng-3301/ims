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
    <!-- top header - header of system  -->
    <?php include_once('../ims-include/header.php'); ?>
        

    <!-- main content of system  -->
    <section id="main-content" id="closeDetial" onclick="closeDetial()">
        <div class="container-ims py-5">
            <div class="control-result p-4">
                <h3>Student results</h3>

                <div class="request-content">
               
                    <!-- include here .  -->

                        <?php include_once('include-result.php');?>

                    <!-- include here.  -->
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