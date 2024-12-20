<?php
    #Connection to DATABASE
    require_once('ims-db-connection.php');

    // check login active 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $requestBtn = mysqli_real_escape_string($conn, $_POST['btn_login']);
        $username   = mysqli_real_escape_string($conn, $_POST['username']);


        $password   = md5(mysqli_real_escape_string($conn, $_POST['password']));

        // $password = 
        // student check 
        $login      = "SELECT * FROM student_info WHERE username ='".$username."' AND password ='". $password ."' AND active_status = '1'";
        $login_run  = mysqli_query($conn, $login);
        
        if(mysqli_num_rows($login_run) > 0){
            $data       = mysqli_fetch_assoc($login_run);
          
            // login has corrected data 
            $_SESSION['LOGIN_STDID']   = $data['student_id'];
            $_SESSION['CLASS_ID']   = $data['class_id'];
            // $_SESSION['LOGIN_USERNAME'] = $data['username'];
            $_SESSION['STD_LOGIN_STATUS']   = TRUE;
            $_SESSION['STD_TYPE'] = 'student';
            // if($data['user_type'] == '')
            header("Location:". SITEURL ."ims-student/");
            exit(0);

    
            // $_SESSION['LOGIN_ERROR'] = "Invalid Username or Password.";
            // header("Location:". SITEURL ."ims-login.php");
            // exit(0);
            
            
        }else{
            // admin, officer, teacher check       
            $login      = "SELECT * FROM users WHERE username ='".$username."' AND password ='". $password ."' AND active_status = '1'";
            $login_run  = mysqli_query($conn, $login);
    
            if(mysqli_num_rows($login_run) > 0){
                $data       = mysqli_fetch_assoc($login_run);
              
                // login has corrected data 
                
                if($data['user_id'] == ''){
                    $_SESSION['LOGIN_USERID']   = 'Admin';

                }else{
                    $_SESSION['LOGIN_USERID']   = $data['user_id'];
                }
                $_SESSION['LOGIN_STATUS']   = TRUE;

                $login_type  = explode(',', $data['role']);
                // $login_type = $_SESSION['LOGIN_TYPE'];

                foreach($login_type as $login_type){
                    // print_r($login_type);

                    if($login_type == 'admin'){
                        #echo 'all menu for admin' ."<br>";
                        $_SESSION['LOGIN_TYPE'] = 'admin';
                        break;

                    }elseif($login_type == 'officer'){
                        
                        $_SESSION['LOGIN_TYPE'] = 'officer';
                        if(!empty($_SESSION['LOGIN_TYPE'])){
                            $_SESSION['TEACHER'] = 'teacher';
                            #echo 'For officer and teacher' ."<br>";
                        }
                        break;

                    }else{
                        $_SESSION['LOGIN_TYPE'] = 'teacher';
                        #echo 'Teacher Only';
                    }

                }
                // exit;


                $_SESSION['LOGIN_ID'] = $data['id'];
                

                header("Location:". SITEURL ."");
                exit(0);                
            }else{
                
                $_SESSION['LOGIN_ERROR'] = "Invalid Username or Password.";
                header("Location:". SITEURL ."ims-login.php");
                exit(0);
            
            }
            
            // else{
            //     // admin check 

            //     $admin = "SELECT * FROM super_admin WHERE username = '". $username ."' AND password = '". $password ."'";
            //     $admin = mysqli_query($conn, $admin);
            //     if(mysqli_num_rows($admin) > 0){
            //         $data = mysqli_fetch_assoc($admin);
            //         $role = explode(',', $data['role']);

            //         // print_r($role);
            //         // if(is_array($role)){
            //         //     echo 'Array';
                        
            //         // }
            //         // exit;

            //         // login has corrected data 
            //         $_SESSION['LOGIN_USERID']   = true;
            //         $_SESSION['LOGIN_STATUS']   = TRUE;
            //         $_SESSION['LOGIN_TYPE'] = $data['role'];
                   

            //         header("Location:". SITEURL ."");
            //         exit(0);

            //     }else{
            //         $_SESSION['LOGIN_ERROR'] = "Invalid Username or Password.";
            //         header("Location:". SITEURL ."ims-login.php");
            //         exit(0);
            //     }
                
            // }

            
        }

    }else{
        header("Location:". SITEURL . "ims-login.php");
        exit(0);
    }

?>