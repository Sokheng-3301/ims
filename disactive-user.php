<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    if(isset($_GET['disactive-user'])){
        $id = $_GET['disactive-user'];
        $teacher_sql = mysqli_query($conn, "SELECT teacher_id , id FROM teacher_info WHERE id ='". $id ."'");
        $fetch = mysqli_fetch_assoc($teacher_sql);
        $teacher_id = $fetch['teacher_id'];


        $url_get = 'disactive-user='.$_GET['disactive-user'];
        if($_SERVER['QUERY_STRING'] != $url_get){
            $old_url =  'teachers.php?'.trim(str_replace('disactive-user='.$_GET['disactive-user'].'&', '', $_SERVER['QUERY_STRING']));
        }else{
            $old_url = 'teachers.php';
        }

        $disactive = mysqli_query($conn, "UPDATE teacher_info SET active_status = '0' WHERE id='". $id ."'");

        if($disactive == true){

            $login_ban = mysqli_query($conn, "UPDATE users SET active_status = '0' WHERE user_id='". $teacher_id ."'");

            $_SESSION['GENERATE'] = 'This user has banned in system.';
            header("Location:". $old_url);
            exit(0);
        }else{
            $_SESSION['GENERATE_ERROR'] = 'This user has not banned in system.';
            header("Location:". $old_url);
            exit(0);
        }
    
    }elseif(isset($_GET['active-user'])){

        $id = $_GET['active-user'];

        $teacher_sql = mysqli_query($conn, "SELECT teacher_id , id FROM teacher_info WHERE id ='". $id ."'");
        $fetch = mysqli_fetch_assoc($teacher_sql);
        $teacher_id = $fetch['teacher_id'];

        $url_get = 'active-user='.$_GET['active-user'];
        if($_SERVER['QUERY_STRING'] != $url_get){
            $old_url =  'teachers.php?'.trim(str_replace('active-user='.$_GET['active-user'].'&', '', $_SERVER['QUERY_STRING']));
        }else{
            $old_url = 'teachers.php';
        }

        $disactive = mysqli_query($conn, "UPDATE teacher_info SET active_status = '1' WHERE id='". $id ."'");
        if($disactive == true){

            $login_ban = mysqli_query($conn, "UPDATE users SET active_status = '1' WHERE user_id='". $teacher_id ."'");
            
            $_SESSION['GENERATE'] = 'This user has disbanned in system.';
            header("Location:". $old_url);
            exit(0);
        }else{
            $_SESSION['GENERATE_ERROR'] = 'This user has not disbanned in system.';
            header("Location:". $old_url);
            exit(0);
        }

    }


?>
