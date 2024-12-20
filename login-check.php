<?php

    $full_name_en = '';
    $full_name_kh = '';
    $user_profile = '';

    // print_r($_SESSION);

    if(!empty($_SESSION['LOGIN_USERID']) && !empty($_SESSION['LOGIN_STATUS']) && !empty($_SESSION['LOGIN_TYPE']) && !empty($_SESSION['LOGIN_ID'])){
        $login_id = $_SESSION['LOGIN_ID'];
        $profile_sql = mysqli_query($conn, "SELECT * FROM users WHERE id = '". $login_id ."'");
        $profile_result = mysqli_fetch_assoc($profile_sql);

        if($profile_result['user_id'] != ""){
            $user_id = $profile_result['user_id'];

            $teacher_profile = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id='". $user_id ."'");
            if(mysqli_num_rows($teacher_profile) > 0){
                $user_data = mysqli_fetch_assoc($teacher_profile);

                $full_name_kh = $user_data['fn_khmer']. " " . $user_data['ln_khmer'];
                $full_name_en = $user_data['fn_en']. " " . $user_data['ln_en'];
                $user_profile = $user_data['profile_image'];

                $_SESSION['TEACHER_ID'] = $user_data['teacher_id'];
            }
        }else{
            $full_name_en = $profile_result['fullname'];
            $full_name_kh = $profile_result['fullname'];;
            $user_profile = '';
        }




        // if(!empty($_SESSION['LOGIN_TYPE']) == 'teacher'){
        //     if(isset($_SESSION['LOGIN_USERID'])){
        //         $teacher_login_id = $_SESSION['LOGIN_USERID'];
    
        //         $teacher_login_sql = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id='". $teacher_login_id ."'");
        //         if(mysqli_num_rows($teacher_login_sql) > 0){
        //             $user_data = mysqli_fetch_assoc($teacher_login_sql);
    
    
        //             $full_name_kh = $user_data['fn_khmer']. " " . $user_data['ln_khmer'];
        //             $full_name_en = $user_data['fn_en']. " " . $user_data['ln_en'];
        //             $user_profile = $user_data['profile_image'];
        //         }
                
        //     }        
        // }
        
        // if(!empty($_SESSION['LOGIN_TYPE']) ){
        //     if($_SESSION['LOGIN_TYPE'] == 'admin'){
        //         $full_name_en = 'admin';
        //         $full_name_kh = 'admin';
        //         $user_profile = '';
        //     }elseif($_SESSION['LOGIN_TYPE'] == 'officer'){
        //         $full_name_en = 'Staff officer';
        //         $full_name_kh = 'Staff officer';
        //         $user_profile = '';
        //     }
        // }

    }else{
        #check if has student 
        if(!empty($_SESSION['STD_TYPE'])){
            header('Location:'. SITEURL ."ims-student/");
            exit;
        }else{
            header('Location:'. SITEURL ."ims-login.php");
            exit;
        }
        
    }

    // $function = mysqli_query($conn, "SELECT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");
    // while($function_result = mysqli_fetch_assoc($function)){
    //     $function_ex = explode(',', $function_result['func_id']);


    //     foreach($function_ex as $row){
    //          $each_func = mysqli_query($conn, "SELECT * FROM function WHERE func_id ='". $row ."'");
    //          $each_func_result = mysqli_fetch_assoc($each_func);
    //             echo $each_func_result['func_name'] ."<br>";
    //     }
    // }

   
?>