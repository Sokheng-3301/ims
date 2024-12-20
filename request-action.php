<?php
    # Connection to DATABASE
    require_once('../ims-db-connection.php');

    #Check login 
    include_once('std-login-check.php');
    $student_id = $_SESSION['LOGIN_STDID'];

    if(!empty($_GET['remove'])){
        $_SESSION['REMOVE_REQUEST'] = $_GET['remove'];
        header("Location:".SITEURL."ims-student/request-letter.php");
        exit(0);
    }

    if(!empty($_GET['delete'])){
        $id = $_GET['delete'];
        $delete = mysqli_query($conn, "DELETE FROM requests WHERE student_id ='". $student_id ."' AND id ='". $id ."'");
        if($delete == true){
            $_SESSION['ADD_DONE'] = 'Your request has removed.';
            header("Location:".SITEURL."ims-student/request-letter.php");
            exit(0);
        }else{
            $_SESSION['ADD_DONE_ERROR'] = 'Your request has not removed.';
            header("Location:".SITEURL."ims-student/request-letter.php");
            exit(0);
        }
    }
?>