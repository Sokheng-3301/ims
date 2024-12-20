<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    // print_r($_SESSION);


    if(isset($_POST['add_member'])){
        if($_POST['fullname'] != '' && $_POST['email'] != '' && $_POST['username'] != '' && $_POST['password'] != '' && $_POST['confirm_password'] != ''){
            $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
            $user_email = mysqli_real_escape_string($conn, $_POST['email']);


            $username = mysqli_real_escape_string($conn, $_POST['username']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);


            $role     = 'admin';
            $creator  = $_SESSION['LOGIN_USERID'];


            if($confirm_password == $password){
                $password = md5($password);

                $user = mysqli_query($conn, "INSERT INTO users (fullname, user_email, username, password, role, create_by)
                VALUES ('$fullname', '$user_email', 'username', '$password', '$role', '$creator')");

                if($user == true){
                    $_SESSION['ADD_DONE'] = 'Add admin has completed.';
                    header("Location:". SITEURL ."add-member.php");
                    exit(0);
                }else{
                    $_SESSION['ADD_NOT_DONE'] = 'Add admin has not completed.';
                    header("Location:". SITEURL ."add-member.php");
                    exit(0);
                }
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Password and confirm password not match.';
                header("Location:". SITEURL ."add-member.php");
                exit(0);
            }


           
        }else{
            $_SESSION['REQUIERED'] = 'All fields are required.';
            header("Location:". SITEURL ."add-member.php");
            exit(0); 
        }
    }elseif(isset($_POST['update_member'])){
        // echo 'update';
        $update_id = $_POST['update_id'];


        if($_POST['fullname'] != '' && $_POST['email'] != '' && $_POST['username'] != ''){
            $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
            $user_email = mysqli_real_escape_string($conn, $_POST['email']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);

            $creator  = $_SESSION['LOGIN_USERID'];
            
            $update = mysqli_query($conn, "UPDATE users SET fullname = '$fullname', user_email = '$user_email', username = '$username' , create_by ='$creator' WHERE id ='". $update_id ."'");
            if($update == true){
                $_SESSION['ADD_DONE'] = 'Update admin has completed.';
                header("Location:". SITEURL ."members.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Update admin has not completed.';
                header("Location:". SITEURL ."members.php");
                exit(0);
            }



        }else{
            $_SESSION['REQUIERED'] = 'All fields are required.';
            header("Location:". SITEURL ."add-member.php?user-id=". $update_id ."");
            exit(0); 
        }

    }elseif(isset($_GET['id'])){
        $id = $_GET['id'];
        $status = mysqli_query($conn, "UPDATE users SET active_status = '0' WHERE id ='". $id ."'");
        
        if($status == true){
            $_SESSION['ADD_DONE'] = 'User has disabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'User has not disabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }
    }elseif(isset($_GET['reco'])){
        $id = $_GET['reco'];
        $status = mysqli_query($conn, "UPDATE users SET active_status = '1' WHERE id ='". $id ."'");
        
        if($status == true){
            $_SESSION['ADD_DONE'] = 'User has recoveryied.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'User has not recoveryied.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }
    }elseif(isset($_GET['delete-id'])){
        $id = $_GET['delete-id'];
        $_SESSION['DELETE_ID'] = $id;
        header("Location:". SITEURL ."members.php");
        exit(0);
    }elseif(isset($_GET['disabled'])){
        $id = $_GET['disabled'];

        $delete = mysqli_query($conn, "UPDATE users SET active_status = '0' WHERE id ='". $id ."'");

        if($delete == true){
            $_SESSION['ADD_DONE'] = 'User has disabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'User has not disabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }

    }
    elseif(isset($_GET['enable-id'])){
        $id = $_GET['enable-id'];
        $_SESSION['ENABLED_ID'] = $id;
        header("Location:". SITEURL ."members.php");
        exit(0);
    }
    elseif(isset($_GET['enable'])){
        $id = $_GET['enable'];

        $enable = mysqli_query($conn, "UPDATE users SET active_status = '1' WHERE id ='". $id ."'");

        if($enable == true){
            $_SESSION['ADD_DONE'] = 'User has enabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'User has not enabled.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }
    }
    
    elseif(isset($_GET['reset-id'])){
        $id = $_GET['reset-id'];
        $_SESSION['RESET_ID'] = $id;
        header("Location:". SITEURL ."members.php");
        exit(0);
    }
    elseif(isset($_GET['reset'])){
        $id = $_GET['reset'];
        $re_pass = md5('1234');

        $delete = mysqli_query($conn, "UPDATE users SET password = '$re_pass' WHERE id ='". $id ."'");

        if($delete == true){
            $_SESSION['ADD_DONE'] = 'Password has reset.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Password has not reset.';
            header("Location:". SITEURL ."members.php");
            exit(0);
        }

    }
   
?>