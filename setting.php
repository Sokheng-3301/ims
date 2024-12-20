<?php
    # Connection to DATABASE
    require_once('../ims-db-connection.php');

    
    #Check login 
    include_once('std-login-check.php');

    $message = '';

    if(isset($_POST['change_password'])){
        if($_POST['current_pass'] == '' || $_POST['new_pass'] == '' || $_POST['confirm_pass'] == ''){
            $message = 'Please enter Current, New and Confirm password!';
        }else{
            $current_pass = mysqli_real_escape_string($conn, $_POST['current_pass']);
            $check_pass = mysqli_query($conn, "SELECT password, student_id FROM student_info WHERE student_id ='". $_SESSION['LOGIN_STDID'] ."' AND password ='". md5($current_pass) ."'");
            if(mysqli_num_rows($check_pass) > 0){
                #correct current passwrod
                $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
                $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);
                if($new_pass == $confirm_pass){
                    // update password 
                    $new_pass = md5($new_pass);

                    $change = mysqli_query($conn, "UPDATE student_info SET password = '$new_pass' WHERE student_id ='". $_SESSION['LOGIN_STDID'] ."'");
                    if($change == true){
                        $message = '<i class="fa fa-check-circle pe-2" aria-hidden="true"></i>Password has changed.';
                    }else{
                        $message = 'Password has not changed.';
                    }
                }else{
                    $message = 'New password and Confirm password not matched!';
                }
            }else{
                $message  = 'Incorrect current password!';
            }
        }
    }
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
        <div class="container-ims py-5">
            <div class="bg-profile system-bg p-4">
                <h3 class="change__password">Change your password</h3>

                <div class="mange_form__change">

                    <div class="shadow-bg">
                        <div id="background-header">
                            <p>Change password</p>
                        </div>
                        <div class="background-content">                      
                            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">

                                <?php
                                    if($message != ''){
                                        echo '<div class="alert alert-secondary" role="alert"><span class="fw-bold pe-2">Note!</span>'.$message.'</div>';
                                    }
                                ?>

                                <label for="current_password"><i class="fa fa-unlock" aria-hidden="true"></i> Current password</label>
                                <div class="control__input">
                                    <input type="password" placeholder="Current password" id="current_password" name="current_pass">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                                <label for="new_password"><i class="fa fa-key" aria-hidden="true"></i> New password</label>
                                <div class="control__input">
                                    <input type="password" placeholder="New password" id="new_password" name="new_pass">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>
                                <label for="confirm_new_password"><i class="fa fa-key" aria-hidden="true"></i> Confirm new password</label>
                                <div class="control__input">
                                    <input type="password" placeholder="Confirm new password" id="confirm_new_password" name="confirm_pass">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </div>

                                <button type="sumit" name="change_password"><i class="fa fa-key" aria-hidden="true"></i>Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer of system -->
    <?php include_once('../ims-include/footer.php');?>

    <!-- include javaScript in web page -->
    <?php include_once('../ims-include/script-tage.php');?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        var eyeIcons = document.querySelectorAll('.fa-eye');

        eyeIcons.forEach(function(icon) {

            var inputField = icon.previousElementSibling;
            inputField.type = 'password'; 
            icon.classList.add('fa-eye-slash'); 

            
            icon.addEventListener('click', function() {
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    inputField.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });
    });
</script>
</body>
</html>
