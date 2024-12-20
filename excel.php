<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    // if(empty($_GET['subject'])){
    //     header("location:".SITEURL."score-submitted.php");
    //     exit(0);
    // }

    if(isset($_GET['subject'])){
        $schedule_id= $_GET['subject'];
        $schedule_check = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                WHERE schedule_id='". $schedule_id ."'");


        if(!mysqli_num_rows($schedule_check) >  0){
            header("location:".SITEURL."score-submitted.php");
            exit(0);

        }else{
            $data = mysqli_fetch_assoc($schedule_check);
            $class_id = $data['class_id'];

            $subject_code = $data['subject_code'];
            $subject_name = $data['subject_name'];
            $credit = $data['credit']."(".$data['theory'].".".$data['execute'].".".$data['apply'].")";
            $teacher_name = $data['fn_en']. " " .$data['ln_en'];
            
        }
        $count_student = mysqli_query($conn, "SELECT * FROM score WHERE schedule_id ='". $schedule_id ."'");
        $count_student = mysqli_num_rows($count_student);

         
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="score-submit-for-'.$subject_code.'".xls"');


        $file = fopen("php://output", "w");
        // $headers = array('Export to excel');
echo
"Export student score to excel file.\n
Subject: ".$subject_name." - ". $credit ."\n
Subject code: ".$subject_code."\n
Instructor:".$teacher_name."\n
Students:".$count_student."\n";


        $headers = array('#', 'Student ID', 'Full name', 'Gender', 'Date of birth', 'Attendence', 'Assignment', 'Midterm', 'Final', 'Total score', 'Grade');
        fputcsv($file, $headers, "\t");

        $score_list = mysqli_query($conn, "SELECT * FROM score
                                            INNER JOIN student_info ON score.student_id = student_info.student_id
                                            WHERE schedule_id ='". $schedule_id ."' ORDER BY total_score ASC");

        $i = 1;
        while($score_data = mysqli_fetch_assoc($score_list)){

            $student_id = $score_data['student_id'];
            $full_name = $score_data['firstname']. " " .$score_data['lastname'];

            // $full_name = iconv("UTF-8", "UTF-8//IGNORE", $full_name);

            $gender = $score_data['gender'];
            $birth_date = date_create($score_data['birth_date']);
            $attendence = $score_data['attendence'];
            $assignment = $score_data['assignment'];
            $midter = $score_data['midterm_exam'];
            $final = $score_data['final_exam'];
            $total = $score_data['total_score'];

            $grade = $score_data['grade'];


            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="score-submit-for-'.$subject_code.'".xls"');


            $file = fopen("php://output", "w");
        
            $data = array(
                array($i++, $student_id, $full_name, $gender, date_format($birth_date, "d-m-Y"), $attendence, $assignment, $midter, $final, $total, $grade)
            );
            foreach ($data as $row) {
                fputcsv($file, $row, "\t");
            }                 
        }
        exit(0);
    }




    if(isset($_GET['class'])){
        $class_id = $_GET['class'];
        $student_query = mysqli_query($conn, "SELECT * FROM student_info 
                                            INNER JOIN class ON student_info.class_id = class.class_id
                                            INNER JOIN major ON class.major_id = major.major_id
                                            INNER JOIN department ON major.department_id = department.department_id
                                            WHERE student_info.class_id ='". $class_id ."'");
        if(mysqli_num_rows($student_query) > 0){
            // echo 'done';
            $count_student = mysqli_num_rows($student_query);
            $student_result = mysqli_fetch_assoc($student_query);
            $class_code = $student_result['class_code'];
            $department = $student_result['department'];
            $major      = $student_result['major'];
            $study_level = $student_result['level_study'];
            $year_level = $student_result['year_level'];
            $academy_year = $student_result['year_of_study'];



        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="student-list-in-class-'.$class_code.'".xls"');

        $file = fopen("php://output", "w");
echo
"Export student score to excel file.\n

Class: ". $class_code ."\n
Department: ".$department."\n
Major:".$major."\n
Study level:".$study_level."\n
Year level: ". $year_level  ."\n
Academy year: ". $academy_year ."\n";

            $headers = array('No.', 'Student ID', 'Fullname (KH)', 'Fullname (EN)' ,'Gender', 'Date of birth','Other');
            fputcsv($file, $headers, "\t");
                


            $i = 1;
            while($student_result){
                $studentID = $student_result['student_id'];
                $fullnameKH = $student_result['fn_khmer'] . " " . $student_result['ln_khmer'];
                $fullnameEN = $student_result['firstname'] . " " . $student_result['lastname'];
                $gender = $student_result['gender'];
                $birthDate = date_create($student_result['birth_date']);
                // $birthDate = date_format($birthDate, "d-m-Y");
                $other = '';

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="student-list-in-class-'.$class_code.'".xls"');


                $file = fopen("php://output", "w");
        
                $data = array(
                    array($i++, $studentID, $fullnameKH, $fullnameEN, $gender, date_format($birthDate, "d-m-Y"), $other)

                );
                foreach ($data as $row) {
                    fputcsv($file, $row, "\t");
                }            
            }
            exit(0);

        }
    }

    // mysqli_close($conn);
?>