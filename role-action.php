<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    if(isset($_POST['apply_function'])){
        if(empty($_POST['user_role'])){
            $_SESSION['REQUIRED'] = 'User role are required.';
            header("Location:". SITEURL ."permission.php");
            exit;
        }else{
            if(empty($_POST['function']) && empty($_POST['sub_function'])){

                $_SESSION['REQUIRED'] = 'Functions are empty select.';
                header("Location:". SITEURL ."permission.php");
                exit;
            }else{
                // print_r($_POST);
                $user_role = $_POST['user_role'];
                $main_function = $_POST['function'];
                $sub_function =  $_POST['sub_function'];

                $main_function = implode(',', $main_function);
                $sub_function = implode(',', $sub_function);
                
                $apply_function = "UPDATE role_permission SET 
                    func_id = '$main_function',
                    sub_func_id = '$sub_function' WHERE role_id ='". $user_role ."'";
                $apply_function = mysqli_query($conn, $apply_function);
                if($apply_function == true){
                    $_SESSION['GENERATE'] = 'Role permission have applied.';
                    header("Location:". SITEURL ."permission.php");
                    exit;

                }else{
                    $_SESSION['GENERATE_ERROR'] = 'Role permission have not applied.';
                    header("Location:". SITEURL ."permission.php");
                    exit;
                }


            }
        }
    }

    if(isset($_POST['apply_user'])){
        // echo 'apply role';
        // print_r($_POST);
        // exit;

        if(empty($_POST['user_role'])){
            $_SESSION['USER_REQUIRE'] = 'Please select user';
            header("location:". SITEURL ."permission.php");
            exit;
        }else{
            $user = $_POST['user_role'];
            if(empty($_POST['role'])){
                $role = 'teacher';
            }else{
                $role = implode(',', $_POST['role']).",teacher";
            }
            // echo $role;
            // exit;
            $update_role = mysqli_query($conn, "UPDATE users SET role ='$role' WHERE id ='". $user ."'");
            
            if($update_role == true){
                $_SESSION['GENERATE'] = 'User permisson has applied.';
                header("Location:". SITEURL ."permission.php");
                exit;

            }else{
                $_SESSION['GENERATE_ERROR'] = 'User permisson has not applied.';
                header("Location:". SITEURL ."permission.php");
                exit;
            }

        }
    }
?>