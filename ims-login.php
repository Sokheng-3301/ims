<?php
    #Connection to DATABASE
    require_once('ims-db-connection.php');

    if(!empty($_SESSION['LOGIN_USERID']) && !empty($_SESSION['LOGIN_STATUS']) && !empty($_SESSION['LOGIN_TYPE'])){
        

        header('Location:'. SITEURL);
        // echo 'You have loged in.';
        exit;
    }

    // login button active 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('ims-include/head-tage.php');?>
</head>
<body>
    <!-- include preload for web page  -->
    <?php #include_once('ims-include/preload.php');?>

    <div id="bg-login-form">
        <div class="control-login-form">
            <img src="<?=SITEURL?>ims-assets/ims-images/<?=$system_logo;?>" alt="">
            <h4><?=systemname;?></h4>
            <?php
                if(isset($_GET['login'])){
            ?>
                <p class="message_show_success"><span><span class="fw-bold"><i class="fa fa-check pe-2" aria-hidden="true"></i></span> Logout has successfully.</span> <span><a href="<?php echo SITEURL.trim(basename($_SERVER['PHP_SELF']));?>"><i class="fa fa-times" aria-hidden="true"></i></a></span></p>
            <?php
                }
            ?>
            <?php
                if(isset($_SESSION['LOGIN_ERROR'])){
            ?>
            <p class="message_show_error"><span> <span class="fw-bold pe-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> Invalid Username or Password.</span><span><a href=""><i class="fa fa-times" aria-hidden="true"></i></a></span></p>
            <?php
                unset($_SESSION['LOGIN_ERROR']);
                }
            ?>
            <form action="<?=SITEURL;?>login-action.php" class="mt-4" method="POST" >
                <div class="input-container">
                    <i class="fa fa-user" aria-hidden="true"></i><input type="text" name="username" placeholder="Username...">
                </div>
                <div class="input-container">
                    <i class="fa fa-lock" aria-hidden="true"></i><input type="password" name="password" placeholder="Password..." id="password">
                    <i class="fa fa-eye-slash" aria-hidden="true" id="iconpass"></i>
                </div>
                <button type="submit" name="btn_login">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </button>
                <!-- Button trigger modal -->
                <p class="text-center" >
                    Forgot username or password? 
                    <a class="forgot-pass" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Get help.</a>
                </p>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-exclamation-circle fs-4 me-2" aria-hidden="true"></i>ចំណាំ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>អំពីការភ្លេចលេខសម្ងាត់</h5>
                សូមនិស្សិតធ្វើការទាក់ទងទៅកាន់ការិយាល័យសិក្សា និងកិច្ចការនិស្សិតនៃវិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ ដើម្បីបំពេញទម្រង់ស្នើសុំលេខសម្ងាត់សម្រាប់ចូលប្រព័ន្ធ។<br>
                សូមអរគុណ!
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>
</body>
</html>