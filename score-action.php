<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');



    if(isset($_POST['save'])){
        $schedule_id = $_POST['schedule_id'];
        $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);


        // echo $schedule_id;


        $count_student = mysqli_query($conn, "SELECT * FROM score WHERE schedule_id ='". $schedule_id ."'");
        $count = mysqli_num_rows($count_student);


        $s_u = '';
        if($subject_name == 'គម្រោង' || $subject_name == 'ចុះកម្មសិក្សា'){
            for($i=1; $i<=$count; $i++){
                $result = mysqli_fetch_assoc($count_student);
                $student_id = $result['student_id'];
                if(!empty($_POST['s_u'.$i])){
                    $s_u = mysqli_real_escape_string($conn, $_POST['s_u'.$i]);
                }else{
                    $s_u = '';
                }
                
                $insert_score_run = '';
                $insert_score = "UPDATE score SET 
                                    s_u = '$s_u'
                                    WHERE schedule_id ='". $schedule_id ."' AND student_id ='". $student_id ."'";
            
                $insert_score_run = mysqli_query($conn, $insert_score);

            }
        }else{      
            for($i=1; $i<=$count; $i++){
                $result = mysqli_fetch_assoc($count_student);
                $student_id = $result['student_id'];


                $attendence = mysqli_real_escape_string($conn, $_POST['attendence'. $i]);
                $assignment = mysqli_real_escape_string($conn, $_POST['assignment'. $i]);
                $midterm = mysqli_real_escape_string($conn, $_POST['midterm'. $i]);
                $final = mysqli_real_escape_string($conn, $_POST['final'. $i]);

                $total = intval($attendence) + intval($assignment) + intval($midterm) + intval($final);




                $grade = '';

                if($total >= '85'){
                    $grade = 'A';
                }elseif($total >= '80'){
                    $grade = 'B+';
                }elseif($total >= '70'){
                    $grade = 'B';
                }elseif($total >= '65'){
                    $grade = 'C+';
                }elseif($total >= '50'){
                    $grade = 'C';
                }elseif($total >= '45'){
                    $grade = 'D';
                }elseif($total >= '40'){
                    $grade = 'E';
                }else{
                    $grade = 'F';
                }
                $insert_score_run = '';
                $insert_score = "UPDATE score SET 
                                    attendence = '$attendence',
                                    assignment = '$assignment',
                                    midterm_exam = '$midterm',
                                    final_exam = '$final',
                                    total_score = '$total',
                                    grade = '$grade'

                                    WHERE schedule_id ='". $schedule_id ."' AND student_id ='". $student_id ."'";

                if($total <= '100'){
                    $insert_score_run = mysqli_query($conn, $insert_score);
                }else{
                    $insert_score_run = false;
                }
            }
        }
        // echo '<pre>';
        //     echo $attendence;
        //     echo $assignment;
        //     echo $midterm;
        //     echo $final;
        // echo "</pre>";
        // exit;
        if($insert_score_run == true){
            // echo 'Insert score done';
            $_SESSION['ADD_DONE'] = "Insert student scores have completed.";
            header("Location:". SITEURL ."student-list.php?subject=". $schedule_id);
            exit;

        }else{
            // echo "Insert not done";
            $_SESSION['ADD_DONE_ERROR'] = "Insert student scores have not completed<br>(Max total are 100).";
            header("Location:". SITEURL ."student-list.php?subject=". $schedule_id);
            exit;
        }
    }



    // submit score 
    if(isset($_POST['submit'])){
        $schedule_id = $_POST['schedule_id'];
        $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);

        // echo $schedule_id;

        $count_student = mysqli_query($conn, "SELECT * FROM score WHERE schedule_id ='". $schedule_id ."'");
        $count = mysqli_num_rows($count_student);



        $s_u = '';
        if($subject_name == 'គម្រោង' || $subject_name == 'ចុះកម្មសិក្សា'){
            for($i=1; $i<=$count; $i++){
                $result = mysqli_fetch_assoc($count_student);
                $student_id = $result['student_id'];
                if(!empty($_POST['s_u'.$i])){
                    $s_u = mysqli_real_escape_string($conn, $_POST['s_u'.$i]);
                }else{
                    $s_u = '';
                }
                
                $insert_score_run = '';
                $insert_score = "UPDATE score SET 
                                    s_u = '$s_u'
                                    WHERE schedule_id ='". $schedule_id ."' AND student_id ='". $student_id ."'";
            
                $insert_score_run = mysqli_query($conn, $insert_score);

            }
        }else{      
            for($i=1; $i<=$count; $i++){
                $result = mysqli_fetch_assoc($count_student);
                $student_id = $result['student_id'];


                $attendence = mysqli_real_escape_string($conn, $_POST['attendence'. $i]);
                $assignment = mysqli_real_escape_string($conn, $_POST['assignment'. $i]);
                $midterm = mysqli_real_escape_string($conn, $_POST['midterm'. $i]);
                $final = mysqli_real_escape_string($conn, $_POST['final'. $i]);

                $total = intval($attendence) + intval($assignment) + intval($midterm) + intval($final);




                $grade = '';

                if($total >= '85'){
                    $grade = 'A';
                }elseif($total >= '80'){
                    $grade = 'B+';
                }elseif($total >= '70'){
                    $grade = 'B';
                }elseif($total >= '65'){
                    $grade = 'C+';
                }elseif($total >= '50'){
                    $grade = 'C';
                }elseif($total >= '45'){
                    $grade = 'D';
                }elseif($total >= '40'){
                    $grade = 'E';
                }else{
                    $grade = 'F';
                }
                $insert_score_run = '';
                $insert_score = "UPDATE score SET 
                                    attendence = '$attendence',
                                    assignment = '$assignment',
                                    midterm_exam = '$midterm',
                                    final_exam = '$final',
                                    total_score = '$total',
                                    grade = '$grade'

                                    WHERE schedule_id ='". $schedule_id ."' AND student_id ='". $student_id ."'";

                if($total <= '100'){
                    $insert_score_run = mysqli_query($conn, $insert_score);
                }else{
                    $insert_score_run = false;
                }
            }
        }

            

        
        // $i++;
        // exit;
        if($insert_score_run == true){
            // echo 'Insert score done';
            // $submit_date = date()
            $user = $_SESSION['LOGIN_USERID'];
            $check_submit = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id ."'");
            if(!mysqli_num_rows($check_submit) > 0){
            
                $submit = mysqli_query($conn, "INSERT INTO score_submitted (schedule_id, teacher_submit)
                                            VALUES ('$schedule_id', '$user')");
            }
            

            

            $_SESSION['ADD_DONE'] = "Submit score have done";
            header("Location:". SITEURL ."student-list.php?subject=". $schedule_id);
            exit;

        }else{
            // echo "Insert not done";
            $_SESSION['ADD_DONE_ERROR'] = "Submit score have not done<br>(Max total are 100).";
            header("Location:". SITEURL ."student-list.php?subject=". $schedule_id);
            exit;
        }
    }



    if(!empty($_GET['score'])){
        $id = $_GET['score'];
        $date = date("Y-m-d");
        $change_status = mysqli_query($conn, "UPDATE score_submitted SET edit_status = '1', submit_date = '$date' WHERE schedule_id = '". $id ."'");
        if($change_status == true){
            header("Location:".SITEURL."score-detail.php?subject=". $id);
            exit;
        }
    }
?>