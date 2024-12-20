<?php
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    #INSERT COURSE HERE.

    if(isset($_POST['save_course'])){

        $department = '';
        $totalHours = '';
        $teaching_by = '';
        $subjectType = '';

        if(empty($_POST['department']) || empty($_POST['total_hours']) || empty($_POST['teacher_name']) || empty($_POST['subject_type'])){
            // $_SESSION['NO_DEPARTMENT'] = "Please select Department / Department are reqired.";
            // header("Location:". SITEURL . "add-course.php");
            $department = '';
            $totalHours = '';
            $teaching_by = '';
            $subjectType = '';
        }
        else{
            $department  = mysqli_real_escape_string($conn,$_POST['department']);
            $totalHours  = mysqli_real_escape_string($conn,$_POST['total_hours']);
            $teaching_by = mysqli_real_escape_string($conn, $_POST['teacher_name']);
            $subjectType = mysqli_real_escape_string($conn,$_POST['subject_type']);
        }



            $subjectCode = mysqli_real_escape_string($conn,$_POST['subject_code']);
            $subjectName = mysqli_real_escape_string($conn,$_POST['subject_name']);
            $subjectNameKh = mysqli_real_escape_string($conn,$_POST['subject_name_kh']);
            $credit      = mysqli_real_escape_string($conn,$_POST['credit']);
            $theory     = mysqli_real_escape_string($conn,$_POST['theory']);
            $execute     = mysqli_real_escape_string($conn,$_POST['execute']);
            $apply       = mysqli_real_escape_string($conn,$_POST['apply']);
            $description = mysqli_real_escape_string($conn,$_POST['description']);
            $purpose     = mysqli_real_escape_string($conn,$_POST['purpose']);
            $anticipatedOutcome = mysqli_real_escape_string($conn,$_POST['anticipated_outcome']);

            if($subjectCode == '' || $subjectName == '' || $subjectNameKh == '' 
                || $credit == '' || $theory == '' || $execute == '' || $apply == '' 
                || $department == '' || $subjectType == '' || $teaching_by == '' || $totalHours == ''){
                    $_SESSION['MESSAGE_SQL_ERROR'] = 'Please complete required field.';
                    header("Location:". SITEURL ."add-course.php");
                    // echo mysqli_error($conn, $addCourseRun);
                    exit(0);
                }else{

                    $addCourse = "INSERT INTO course 
                                        (subject_code, 
                                        subject_name,
                                        subject_name_kh,
                                        description,
                                        purpose,
                                        anticipated_outcome,
                                        credit,
                                        theory,
                                        execute,
                                        apply,
                                        teaching_by,
                                        total_hourse,
                                        subject_type,
                                        department_id)
                                    VALUES 
                                        ('$subjectCode',
                                        '$subjectName',
                                        '$subjectNameKh',
                                        '$description',
                                        '$purpose',
                                        '$anticipatedOutcome',
                                        '$credit',
                                        '$theory',
                                        '$execute',
                                        '$apply',
                                        '$teaching_by',
                                        '$totalHours',
                                        '$subjectType',
                                        '$department');";
                    $addCourseRun = mysqli_query($conn, $addCourse);

                    if($addCourseRun == TRUE){
                        $_SESSION['MESSAGE_SQL'] = 'Add course has completed.';
                        header("Location:". SITEURL ."add-course.php");
                        exit(0);
                    }else{
                        $_SESSION['MESSAGE_SQL_ERROR'] = 'Add course has not completed.';
                        header("Location:". SITEURL ."add-course.php");
                        // echo mysqli_error($conn, $addCourseRun);
                        exit(0);
                    }
                }

        
    }

    #UPDAE COURSE HERE.

    if(isset($_POST['update_course'])){
        $id = $_POST['id'];
        $url = $_POST['url'];

        $cutstring = strpos($url, "&");
        $cut_url = str_split($url, $cutstring+1);
        $cut_url[0] = "";

        // echo "<br>";
        $url = trim(implode($cut_url));

        // print_r($cut_url);
        // exit;


        $department = '';
        $totalHours = '';
        $teaching_by = '';
        $subjectType = '';


        if(empty($_POST['department']) || empty($_POST['total_hours']) || empty($_POST['teacher_name']) || empty($_POST['subject_type'])){
            // $_SESSION['NO_DEPARTMENT'] = "Please select Department / Department are reqired.";
            // header("Location:". SITEURL . "add-course.php");
            $department = '';
            $totalHours = '';
            $teaching_by = '';
            $subjectType = '';
        }
        else{
            $department  = mysqli_real_escape_string($conn,$_POST['department']);
            $totalHours  = mysqli_real_escape_string($conn,$_POST['total_hours']);
            $teaching_by = mysqli_real_escape_string($conn, $_POST['teacher_name']);
            $subjectType = mysqli_real_escape_string($conn,$_POST['subject_type']);
        }



        // $subjectCode = mysqli_real_escape_string($conn,$_POST['subject_code']);
        // $subjectName = mysqli_real_escape_string($conn,$_POST['subject_name']);
        // $subjectNameKh = mysqli_real_escape_string($conn,$_POST['subject_name_kh']);
        // $credit      = mysqli_real_escape_string($conn,$_POST['credit']);
        // $theory     = mysqli_real_escape_string($conn,$_POST['theory']);
        // $execute     = mysqli_real_escape_string($conn,$_POST['execute']);
        // $apply       = mysqli_real_escape_string($conn,$_POST['apply']);
        // $department  = mysqli_real_escape_string($conn,$_POST['department']);
        // $subjectType = mysqli_real_escape_string($conn,$_POST['subject_type']);
        // $teaching_by = mysqli_real_escape_string($conn, $_POST['teacher_name']);
        // $totalHours  = mysqli_real_escape_string($conn,$_POST['total_hours']);
        // $description = mysqli_real_escape_string($conn,$_POST['description']);
        // $purpose     = mysqli_real_escape_string($conn,$_POST['purpose']);
        // $anticipatedOutcome = mysqli_real_escape_string($conn,$_POST['anticipated_outcome']);


        $subjectCode = mysqli_real_escape_string($conn,$_POST['subject_code']);
        $subjectName = mysqli_real_escape_string($conn,$_POST['subject_name']);
        $subjectNameKh = mysqli_real_escape_string($conn,$_POST['subject_name_kh']);
        $credit      = mysqli_real_escape_string($conn,$_POST['credit']);
        $theory     = mysqli_real_escape_string($conn,$_POST['theory']);
        $execute     = mysqli_real_escape_string($conn,$_POST['execute']);
        $apply       = mysqli_real_escape_string($conn,$_POST['apply']);
        $description = mysqli_real_escape_string($conn,$_POST['description']);
        $purpose     = mysqli_real_escape_string($conn,$_POST['purpose']);
        $anticipatedOutcome = mysqli_real_escape_string($conn,$_POST['anticipated_outcome']);


        if($subjectCode == '' || $subjectName == '' || $subjectNameKh == '' 
        || $credit == '' || $theory == '' || $execute == '' || $apply == '' 
        || $department == '' || $subjectType == '' || $teaching_by == '' || $totalHours == ''){
            $_SESSION['MESSAGE_SQL_ERROR'] = 'Please complete required field.';
            header("Location:". SITEURL ."add-course.php?update-id=".$id."#update");
            // echo mysqli_error($conn, $addCourseRun);
            exit(0);
        }else{

        

            $updateCourse = "UPDATE course SET
                subject_code         = '$subjectCode', 
                subject_name         = '$subjectName',
                subject_name_kh      = '$subjectNameKh',
                description          = '$description',
                purpose              = '$purpose',
                anticipated_outcome  = '$anticipatedOutcome',
                credit               = '$credit',
                theory               = '$theory',
                execute              = '$execute',
                apply                = '$apply',
                teaching_by          = '$teaching_by',
                total_hourse         = '$totalHours',
                subject_type         = '$subjectType',
                department_id        = '$department'
                WHERE id = '". $id ."'";
            $updateCourseRun = mysqli_query($conn, $updateCourse);
            if($updateCourseRun == TRUE){
                $_SESSION['MESSAGE_SQL'] = 'Update course has completed.';
                #must replace url update-id to none string 27-2-2024

                
                header("Location:". SITEURL ."courses.php");
                exit(0);
            }else{
                $_SESSION['MESSAGE_SQL_ERROR'] = 'Update course has not completed.';
                header("Location:". SITEURL ."add-course.php?update-id=".$id."#update");
                // header("Location:". SITEURL ."add-course.php?".$url."#update");
                exit(0);
            }
        }
    }


    #DELETE COURSE HERE.
    if(isset($_GET['delete-id'])){
        $id = $_GET['delete-id'];
        $delete = "DELETE FROM course WHERE id ='". $id ."'";
        $deleteRun = mysqli_query($conn, $delete);
        if($deleteRun == TRUE){
            $_SESSION['MESSAGE_SQL'] = "Delete course has completed.";
            header("Location:". SITEURL ."courses.php");
            exit(0);
        }else{
            $_SESSION['MESSAGE_SQL_ERROR'] = "Delete course has not completed.";
            header("Location:". SITEURL ."courses.php");
            exit(0);
        }
    }
?>