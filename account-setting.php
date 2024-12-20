<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');
    

    if(isset($_POST['chang_password'])){
        $password_message = '';

        $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);


        if(empty($current_password)){
            $password_message = 'Please enter your current password.';
        }else{
            if($new_password == ''){
                $password_message = 'Please enter new password.';
            }else{
                $current_password = md5($current_password);
                $check_current_pass = mysqli_query($conn, "SELECT teacher_id, password FROM teacher_info WHERE teacher_id ='". $_SESSION['LOGIN_USERID'] ."' AND password ='". $current_password ."'");
                if(mysqli_num_rows($check_current_pass) > 0){
                    if($new_password == $confirm_password){
                        $new_password = md5($new_password);
                        $update_password = mysqli_query($conn, "UPDATE teacher_info SET password = '$new_password' WHERE teacher_id ='". $_SESSION['LOGIN_USERID'] ."'");
                        if($update_password == true){
                            $_SESSION['CHANGE_PASS'] = 'Password has changed.';
                        }
                    }else{
                        $password_message = 'New password and confirm password not macth.';
                    }
                }else{
                    $password_message = 'Current password not found.';
                }
            }
        }


    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once('ims-include/head-tage.php');
        # link to teacher style 
        include_once('ims-include/staff__head_tage.php');
    ?>
</head>
<body>
    <?php
        include_once('ims-include/staff__topheader.php');
    ?>

    <section id="sidebar__content" onclick="closeProfileDash() , topNotication()">
        
    <!-- sidebar  -->
    <?php
        include_once('ims-include/staff__sidebar.php');
    ?>
        <div id="main__content">
            <div class="top__content_title">
                <h5 class="super__title">Account setting <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Account setting</p>
            </div>
            <div class="all__teacher account__setting">
                <!-- <p>Theme setting</p> -->
                <!-- <div class="change__profile">
                    <p>Change your profile account</p>
                    <form action="" enctype="multipart/form-data" method="post">
                        <label for="profile__account">
                            <div class="img__profile">
                                <img src="<?=SITEURL?>ims-assets/ims-images/user.png" id="img_profile" alt="">
                                <div class="camera">
                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                </div>
                            </div>
                        </label>
                        <input type="file" id="profile__account" accept="image/*">
                        <div class="button">
                            <button type="reset" class="cancel">Cancel</button>
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div> -->
                <div class="change__profile change__password">
                    <p>Change your password</p>
                    <?php
                        if(isset($password_message)){
                    ?>
                            <small class="mt-2 d-block bg-light text-danger px-2 py-2"><?=$password_message;?></small>
                    <?php
                            // unset($password_message);
                        }
                    ?>
                    <form action="" method="post">
                        <label for="current__password">Current password</label>
                        <input type="password" id="current__password" name="current_password" placeholder="Enter your current password...">

                        <label for="new__password">New password</label>
                        <input type="password" id="new__password" name="new_password" placeholder="Enter your new password...">
                        <label for="confirm__password">Confirm password <span id="show_match"></span></label> 
                        <!-- <i class="fa fa-check-circle ms-2" aria-hidden="true"></i> -->
                        <input type="password" id="confirm__password" name="confirm_password" placeholder="Enter confirm password..." oninput="checkMatch()">

                        <div class="button">
                            <button type="reset" class="cancel">Cancel</button>
                            <button type="submit" name="chang_password">Change</button>
                        </div>
                    </form>

                </div>
                
            </div>
        
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>

    <?php
        if(isset($_SESSION['CHANGE_PASS'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['CHANGE_PASS'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>account-setting.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
            unset($_SESSION['CHANGE_PASS']);
        }
    ?>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>