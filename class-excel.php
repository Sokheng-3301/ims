<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    
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

            // while($student_result = mysqli_fetch_assoc($student_query)){
            //     echo '<pre>';
            //     print_r($student_result);
            //     echo '</pre>';
            // }
            
            // exit;



        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="student-list-in-class-'.$class_code.'".xls"');

        $file = fopen("php://output", "w");
echo
"Export student score to excel file.\n

Class: ". $class_code ."\n
Department: ".$department."\n
Major:".$major."\n
Degree:".$study_level."\n
Year level: ". $year_level  ."\n
Academy year: ". $academy_year ."\n";

            $headers = array('No.', 'Student ID', 'Fullname (KH)', 'Fullname (EN)' ,'Gender', 'Date of birth','Other');
            fputcsv($file, $headers, "\t");
                


            $i = 1;
            while($student_result =  mysqli_fetch_assoc($student_query)){
                $studentID = $student_result['student_id'];
                $fullnameKH = $student_result['fn_khmer'] . " " . $student_result['ln_khmer'];
                $fullnameEN = $student_result['firstname'] . " " . $student_result['lastname'];
                $gender = $student_result['gender'];
                $birthDate = $student_result['birth_date'];
                $other = '';

                // header('Content-Type: application/vnd.ms-excel');
                // header('Content-Disposition: attachment; filename="student-list-in-class-'.$class_code.'".xls"');


                // $file = fopen("php://output", "w");
        
                $data = array(
                    array($i++, $studentID, $fullnameKH, $fullnameEN, $gender, $birthDate, $other)

                );
                foreach ($data as $row) {
                    fputcsv($file, $row, "\t");
                }            
            }
            exit(0);

        }
    }
?>