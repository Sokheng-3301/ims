<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    // if(isset($_POST['submit'])){
    //     $id = $_POST['id'];
    //     $q = $_POST['q'];
    //     $status = mysqli_real_escape_string($conn, $_POST['status']);
    //     $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    //     if($status == ''){
    //         header("locatoin: ".SITEURL. "request-detail.php?q=".$q);

    //     }else{
    //         $feedback = mysqli_query($conn, "UPDATE requests SET 
    //                                         feedback ='$status', 
    //                                         comment = '$comment' WHERE id ='". $id ."'");
    //         if($feedback == true){
    //             $_SESSION['ADD_DONE'] = 'Feedback to student has completed.';
    //             header("Location:".SITEURL."request-detail.php?q=". $q);
    //             exit;
    //         }else{
    //             $_SESSION['ADD_NOT_DONE'] = 'Feedback to student has completed.';
    //             header("Location:".SITEURL."request-detail.php?q=".$q);
    //             exit;
    //         }
    //     }
    // }

    if(isset($_POST['feedback'])){
        $id = $_POST['id'];
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        if($comment == ''){
            header("location: ".SITEURL. "request-detail.php?q=".$id);
            exit;
        }else{
            $feedback = mysqli_query($conn, "UPDATE requests SET 
                                            comment = '$comment' WHERE id ='". $id ."'");
            if($feedback == true){
                $_SESSION['ADD_DONE'] = 'Feedback to student has completed.';
                header("Location:".SITEURL."request-detail.php?q=". $id);
                exit;
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Feedback to student has not completed.';
                header("Location:".SITEURL."request-detail.php?q=".$id);
                exit;
            }
        }

    }
    if(isset($_GET['accept'])){
        $id = $_GET['accept'];

        $feedback = mysqli_query($conn, "UPDATE requests SET 
                                            feedback = 'accepted' WHERE id ='". $id ."'");
            if($feedback == true){
                $_SESSION['ADD_DONE'] = 'Request has accepted.';
                header("Location:".SITEURL."request-detail.php?q=". $id);
                exit;
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Request has not accepted.';
                header("Location:".SITEURL."request-detail.php?q=".$id);
                exit;
            }
    }
    if(isset($_GET['reject'])){
        $id = $_GET['reject'];

        $feedback = mysqli_query($conn, "UPDATE requests SET 
                                            feedback = 'rejected',
                                            request_status = '2'
                                             WHERE id ='". $id ."'");
            if($feedback == true){
                $_SESSION['ADD_DONE'] = 'Request has rejected.';
                header("Location:".SITEURL."request-detail.php?q=". $id);
                exit;
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Request has not rejected.';
                header("Location:".SITEURL."request-detail.php?q=".$id);
                exit;
            }
    }

    if(isset($_GET['done'])){
        $id = $_GET['done'];
        $comment = 'និស្សិតអាចមកដកយកឯកសារដែលស្នើសុំនៅការិយាល័យសិក្សានិងកិច្ចការនិស្សិតនៃវិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺបានចាប់ពីថ្ងៃនេះតទៅ។';
        $feedback = mysqli_query($conn, "UPDATE requests SET 
                                            request_status = '1',
                                            feedback = 'Done',
                                            comment = '$comment'
                                            WHERE id ='". $id ."'");
            if($feedback == true){
                $_SESSION['ADD_DONE'] = 'Request has done.';
                header("Location:".SITEURL."request-detail.php?q=". $id);
                exit;
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Request has not done.';
                header("Location:".SITEURL."request-detail.php?q=".$id);
                exit;
            }
    }
?>