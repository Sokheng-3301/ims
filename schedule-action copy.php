<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    if(isset($_POST['add_schedule'])){
        $room = '';

        $dep_id = mysqli_real_escape_string($conn, $_POST['dep']);
        $major = mysqli_real_escape_string($conn, $_POST['major']);
        $class_id = mysqli_real_escape_string($conn, $_POST['class']);

        if(!empty($_POST['room'])){
            $room = mysqli_real_escape_string($conn, $_POST['room']);
        }else{
            $room = '';
        }

        $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);

        if($major == '' || $room == '' || $start_time == '' || $end_time == '' || empty($_POST['subject'])  || empty($_POST['instructor'])
                        || empty($_POST['class']) || empty($_POST['semester']) || empty($_POST['day']) || empty($_POST['at'])){
                        
                        $_SESSION['REQUIRED'] = 'bg-note';
                        header("Location:". SITEURL ."add-schedule.php?dep=". $dep_id ."&maj=". $major. "&class=". $class_id);
                        exit(0);
        }else{

            $return_class_id = '';

            $subject = mysqli_real_escape_string($conn, $_POST['subject']);
            $semester = mysqli_real_escape_string($conn, $_POST['semester']);
            $day = mysqli_real_escape_string($conn, $_POST['day']);
            $instructor = mysqli_real_escape_string($conn, $_POST['instructor']);
            $class = mysqli_real_escape_string($conn, $_POST['class']);

            $year_level_sql = mysqli_query($conn, "SELECT * FROM class WHERE class_id ='". $class ."'");

            if(mysqli_num_rows($year_level_sql) > 0){
                $year_level_data = mysqli_fetch_assoc($year_level_sql);

                $year_level = $year_level_data['year_level'];
                $return_class_id = $year_level_data['class_id'];

            }
            // echo $return_class_code;
            // exit;

            $at = mysqli_real_escape_string($conn, $_POST['at']);
            

            $add_schedule = "INSERT INTO schedule_study 
                            (class_id,
                            subject_code,
                            year_semester_id,
                            year_level, 

                            start_time,
                            end_time,
                            day,
                            at,
                            instructor_id,
                            room)


                            VALUES
                            ('$class',
                            '$subject',
                            '$semester',
                            '$year_level',
                            
                            '$start_time',
                            '$end_time',
                            '$day',
                            '$at',
                            '$instructor',
                            '$room')";
            $add_schedule_run = mysqli_query($conn, $add_schedule);
            if($add_schedule_run == true){
                $_SESSION['ADD_DONE'] = 'Apply schedule has completed.';
                // $_SESSION['RT_CLASS_CODE'] = $return_class_id;
                $_SESSION['RT_CLASS_CODE'] = $semester;
                 header("Location:". SITEURL ."add-schedule.php?dep=". $dep_id ."&maj=". $major. "&class=". $class_id);
                exit(0);
            }else{
                $_SESSION['ADD_DONE_ERROR'] = 'Appy schedule has not completed.';
                // $_SESSION['RT_CLASS_CODE'] = $return_class_id;
                $_SESSION['RT_CLASS_CODE'] = $semester;
                 header("Location:". SITEURL ."add-schedule.php?dep=". $dep_id ."&maj=". $major. "&class=". $class_id);
                exit(0);
            }

        }
    }



    if(isset($_POST['edit_schedule'])){
        $room = '';
        $url = mysqli_real_escape_string($conn, $_POST['url']);
        $update_id = $_POST['id'];
        $major = mysqli_real_escape_string($conn, $_POST['major']);
        $department_id = mysqli_real_escape_string($conn, $_POST['dep']);
        $class_id = mysqli_real_escape_string($conn, $_POST['class']);

        if(!empty($_POST['room'])){

            $room = mysqli_real_escape_string($conn, $_POST['room']);
        }else{
            $room = '';
        }

        $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);

        if($major == '' || $room == '' || $start_time == '' || $end_time == '' || empty($_POST['subject'])  || empty($_POST['instructor'])
                        || empty($_POST['class']) || empty($_POST['day']) || empty($_POST['at'])){
                        
                        $_SESSION['REQUIRED'] = 'bg-note';
                        // header("Location:". SITEURL ."add-schedule.php?sch=".$update_id."&dep=". $department_id."&maj=". $major."&class=". $class_id);
                        header("Location:". SITEURL. $url);
                        exit(0);
        }else{

            $subject = mysqli_real_escape_string($conn, $_POST['subject']);
            // $semester = mysqli_real_escape_string($conn, $_POST['semester']);
            $day = mysqli_real_escape_string($conn, $_POST['day']);
            $instructor = mysqli_real_escape_string($conn, $_POST['instructor']);
            $class = mysqli_real_escape_string($conn, $_POST['class']);
            $at = mysqli_real_escape_string($conn, $_POST['at']);
            // $year_level = mysqli_real_escape_string($conn, $_POST['year_level']);

        }
            

        $update_schedule = mysqli_query($conn, "UPDATE schedule_study SET
                            subject_code = '$subject' ,
                            start_time = '$start_time',
                            end_time = '$end_time', 
                            day = '$day',
                            at = '$at' ,
                            instructor_id = '$instructor',
                            room = '$room' WHERE schedule_id ='". $update_id ."'");
        
        if($update_schedule == true){
            $_SESSION['ADD_DONE'] = 'Update schedule has completed.';
            header("Location:". SITEURL. $url);
            exit(0);
        }else{
            $_SESSION['ADD_DONE_ERROR'] = 'Update schedule has not completed.';
            header("Location:". SITEURL. $url);
            exit(0);

        }

    }


    // if(isset($_POST['filter_schedule'])){
    //     $major = $_POST['major'];
    //     include_once("function.php");
    //     header("Location:".SITEURL."view-schedule.php?q=".$major);
    //     exit(0);
    // }

    if(isset($_GET['semester']) && isset($_GET['class']) && isset($_GET['q'])){

        $class_id = $_GET['class'];
        $semester_id = $_GET['semester'];
        $major = $_GET['q'];
        $dep_qry = mysqli_query($conn, "SELECT * FROM major WHERE major_id ='". $major ."'");
        $dep_fetch = mysqli_fetch_assoc($dep_qry);

        $dep_id = $dep_fetch['department_id'];

        unset($_SESSION['RT_CLASS_CODE']);

        $done_schedule = mysqli_query($conn, "UPDATE schedule_study SET done_status = '1' WHERE class_id ='". $class_id ."' AND year_semester_id ='". $semester_id ."'");
        if($done_schedule == true){
            $_SESSION['ADD_DONE'] = 'Add schedule has completed.';
            // $_SESSION['RT_CLASS_CODE'] = $return_class_id;
            header("Location:". SITEURL ."add-schedule.php?dep=". $dep_id ."&maj=". $major. "&class=". $class_id);

            exit(0);
        }else{
            $_SESSION['ADD_DONE_ERROR'] = 'Add schedule has not completed.';
            // $_SESSION['RT_CLASS_CODE'] = $return_class_id;
            header("Location:". SITEURL ."add-schedule.php?dep=". $dep_id ."&maj=". $major. "&class=". $class_id);
            exit(0);
        }
        
    }




    if(isset($_POST['duplicate_schedule'])){
        $query_status = false;
        $q = $_POST['q'];
        // echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";

        if(!empty($_POST['semester_duplicate']) && !empty($_POST['class_duplicate'])){

            $semester = mysqli_real_escape_string($conn, $_POST['semester_duplicate']);
            $class = mysqli_real_escape_string($conn, $_POST['class_duplicate']);

            $year_level = mysqli_query($conn, "SELECT * FROM class WHERE class_id = '". $class ."'");
            if(mysqli_num_rows($year_level) > 0){
                $year_level_fetch = mysqli_fetch_assoc($year_level);
                $year_level_result = $year_level_fetch['year_level'];
            }


            // Monday 
            if(!empty($_POST['monday_subject_code'])){
                $monday_subject_code = $_POST['monday_subject_code'];
            }

            if(!empty($_POST['monday_start_time'])){
                $monday_start_time = $_POST['monday_start_time'];
            }

            if(!empty($_POST['monday_end_time'])){
                $monday_end_time = $_POST['monday_end_time'];
            }
            
            if(!empty($_POST['monday_at'])){
                $monday_at = $_POST['monday_at'];
            }

            if(!empty($_POST['monday_day'])){
                $monday_day = $_POST['monday_day'];
            }

            if(!empty($_POST['monday_room'])){
                $monday_room = $_POST['monday_room'];
            }

            if(!empty($_POST['monday_instructor_id'])){
                $monday_instructor_id = $_POST['monday_instructor_id'];
            }


            // while($monday_subject_code) {
            //     echo $monday_subject_code;
            // }
            $incrementQuery = 0;
            foreach($monday_subject_code as $monday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $monday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room,
                                done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$monday_subject_code', 
                                '$monday_start_time[$incrementQuery]',
                                '$monday_end_time[$incrementQuery]',
                                '$monday_day[$incrementQuery]',
                                '$monday_at[$incrementQuery]',
                                '$monday_instructor_id[$incrementQuery]',
                                '$monday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }


            // if($query_status == true){
            //     echo 'Yeas';
            // } else{
            //     echo "No";
            // }
                                    




            // Tuesday 
            if(!empty($_POST['tuesday_subject_code'])){
                $tuesday_subject_code = $_POST['tuesday_subject_code'];
            }

            if(!empty($_POST['tuesday_start_time'])){
                $tuesday_start_time = $_POST['tuesday_start_time'];
            }

            if(!empty($_POST['tuesday_end_time'])){
                $tuesday_end_time = $_POST['tuesday_end_time'];
            }
            
            if(!empty($_POST['tuesday_at'])){
                $tuesday_at = $_POST['tuesday_at'];
            }

            if(!empty($_POST['tuesday_day'])){
                $tuesday_day = $_POST['tuesday_day'];
            }

            if(!empty($_POST['tuesday_room'])){
                $tuesday_room = $_POST['tuesday_room'];
            }

            if(!empty($_POST['tuesday_instructor_id'])){
                $tuesday_instructor_id = $_POST['tuesday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($tuesday_subject_code as $tuesday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $tuesday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$tuesday_subject_code', 

                                '$tuesday_start_time[$incrementQuery]',
                                '$tuesday_end_time[$incrementQuery]',
                                '$tuesday_day[$incrementQuery]',
                                '$tuesday_at[$incrementQuery]',
                                '$tuesday_instructor_id[$incrementQuery]',
                                '$tuesday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }






            // Wednesday 
            if(!empty($_POST['wednesday_subject_code'])){
                $wednesday_subject_code = $_POST['wednesday_subject_code'];
            }

            if(!empty($_POST['wednesday_start_time'])){
                $wednesday_start_time = $_POST['wednesday_start_time'];
            }

            if(!empty($_POST['wednesday_end_time'])){
                $wednesday_end_time = $_POST['wednesday_end_time'];
            }

            if(!empty($_POST['wednesday_at'])){
                $wednesday_at = $_POST['wednesday_at'];
            }

            if(!empty($_POST['wednesday_day'])){
                $wednesday_day = $_POST['wednesday_day'];
            }

            if(!empty($_POST['wednesday_room'])){
                $wednesday_room = $_POST['wednesday_room'];
            }

            if(!empty($_POST['wednesday_instructor_id'])){
                $wednesday_instructor_id = $_POST['wednesday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($wednesday_subject_code as $wednesday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $wednesday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$wednesday_subject_code', 

                                '$wednesday_start_time[$incrementQuery]',
                                '$wednesday_end_time[$incrementQuery]',
                                '$wednesday_day[$incrementQuery]',
                                '$wednesday_at[$incrementQuery]',
                                '$wednesday_instructor_id[$incrementQuery]',
                                '$wednesday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }






            // Thursday 
            if(!empty($_POST['thursday_subject_code'])){
                $thursday_subject_code = $_POST['thursday_subject_code'];
            }

            if(!empty($_POST['thursday_start_time'])){
                $thursday_start_time = $_POST['thursday_start_time'];
            }

            if(!empty($_POST['thursday_end_time'])){
                $thursday_end_time = $_POST['thursday_end_time'];
            }

            if(!empty($_POST['thursday_at'])){
                $thursday_at = $_POST['thursday_at'];
            }

            if(!empty($_POST['thursday_day'])){
                $thursday_day = $_POST['thursday_day'];
            }

            if(!empty($_POST['thursday_room'])){
                $thursday_room = $_POST['thursday_room'];
            }

            if(!empty($_POST['thursday_instructor_id'])){
                $thursday_instructor_id = $_POST['thursday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($thursday_subject_code as $thursday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $thursday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$thursday_subject_code', 

                                '$thursday_start_time[$incrementQuery]',
                                '$thursday_end_time[$incrementQuery]',
                                '$thursday_day[$incrementQuery]',
                                '$thursday_at[$incrementQuery]',
                                '$thursday_instructor_id[$incrementQuery]',
                                '$thursday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }






            // Friday 
            if(!empty($_POST['friday_subject_code'])){
                $friday_subject_code = $_POST['friday_subject_code'];
            }

            if(!empty($_POST['friday_start_time'])){
                $friday_start_time = $_POST['friday_start_time'];
            }

            if(!empty($_POST['friday_end_time'])){
                $friday_end_time = $_POST['friday_end_time'];
            }

            if(!empty($_POST['friday_at'])){
                $friday_at = $_POST['friday_at'];
            }

            if(!empty($_POST['friday_day'])){
                $friday_day = $_POST['friday_day'];
            }

            if(!empty($_POST['friday_room'])){
                $friday_room = $_POST['friday_room'];
            }

            if(!empty($_POST['friday_instructor_id'])){
                $friday_instructor_id = $_POST['friday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($friday_subject_code as $friday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $friday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$friday_subject_code', 

                                '$friday_start_time[$incrementQuery]',
                                '$friday_end_time[$incrementQuery]',
                                '$friday_day[$incrementQuery]',
                                '$friday_at[$incrementQuery]',
                                '$friday_instructor_id[$incrementQuery]',
                                '$friday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }




            
            // Saturday 
            if(!empty($_POST['saturday_subject_code'])){
                $saturday_subject_code = $_POST['saturday_subject_code'];
            }

            if(!empty($_POST['saturday_start_time'])){
                $saturday_start_time = $_POST['saturday_start_time'];
            }

            if(!empty($_POST['saturday_end_time'])){
                $saturday_end_time = $_POST['saturday_end_time'];
            }

            if(!empty($_POST['saturday_at'])){
                $saturday_at = $_POST['saturday_at'];
            }

            if(!empty($_POST['saturday_day'])){
                $saturday_day = $_POST['saturday_day'];
            }

            if(!empty($_POST['saturday_room'])){
                $saturday_room = $_POST['saturday_room'];
            }

            if(!empty($_POST['saturday_instructor_id'])){
                $saturday_instructor_id = $_POST['saturday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($saturday_subject_code as $saturday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $saturday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$saturday_subject_code', 

                                '$saturday_start_time[$incrementQuery]',
                                '$saturday_end_time[$incrementQuery]',
                                '$saturday_day[$incrementQuery]',
                                '$saturday_at[$incrementQuery]',
                                '$saturday_instructor_id[$incrementQuery]',
                                '$saturday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }



            // Sunday 
            if(!empty($_POST['sunday_subject_code'])){
                $sunday_subject_code = $_POST['sunday_subject_code'];
            }

            if(!empty($_POST['sunday_start_time'])){
                $sunday_start_time = $_POST['sunday_start_time'];
            }

            if(!empty($_POST['sunday_end_time'])){
                $sunday_end_time = $_POST['sunday_end_time'];
            }

            if(!empty($_POST['sunday_at'])){
                $sunday_at = $_POST['sunday_at'];
            }

            if(!empty($_POST['sunday_day'])){
                $sunday_day = $_POST['sunday_day'];
            }

            if(!empty($_POST['sunday_room'])){
                $sunday_room = $_POST['sunday_room'];
            }

            if(!empty($_POST['sunday_instructor_id'])){
                $sunday_instructor_id = $_POST['sunday_instructor_id'];
            }

            $incrementQuery = 0;
            foreach($sunday_subject_code as $sunday_subject_code){
                // echo $incrementQuery++; echo '<br>';
                // echo $sunday_subject_code;
                // echo "<br>";

                $duplicate = "INSERT INTO schedule_study 
                                (class_id,
                                year_semester_id,
                                year_level,

                                subject_code,
                                start_time,
                                end_time,
                                day,
                                at,
                                instructor_id,
                                room, done_status) VALUES ('$class', 
                                '$semester', 
                                '$year_level_result', 
                                '$sunday_subject_code', 

                                '$sunday_start_time[$incrementQuery]',
                                '$sunday_end_time[$incrementQuery]',
                                '$sunday_day[$incrementQuery]',
                                '$sunday_at[$incrementQuery]',
                                '$sunday_instructor_id[$incrementQuery]',
                                '$sunday_room[$incrementQuery]', '1')";


                // #DONE STATUS NOT APPLY YET

                $duplicate_run = mysqli_query($conn, $duplicate);
                $query_status = true;
                $incrementQuery++;
            }




            if($query_status == true){
                $_SESSION['ADD_DONE'] = 'Duplicate schedule has completed.';
                header("Location:". SITEURL."view-schedule.php?q=". $q);
                exit;
            }else{
                echo 'No';
            }






        }else{
            $_SESSION['ADD_DONE_ERROR'] = 'Semester and Class are required to duplicate.';
            header("Location:". SITEURL."view-schedule.php?q=". $q);
            exit;
        }
    }



    if(isset($_GET['sch'])){
        $schedule_id = $_GET['sch'];
        $_SESSION['RE_DELETE'] = $_GET['sch'];
        $query_string = mysqli_query($conn, "SELECT * FROM schedule_study s
                                            INNER JOIN class c ON s.class_id = c.class_id
                                            INNER JOIN major m ON c.major_id = m.major_id
                                            INNER JOIN department d ON m.department_id = d.department_id 
                                            WHERE s.schedule_id ='". $schedule_id ."'");
        $result = mysqli_fetch_assoc($query_string);

        header("Location:". SITEURL."add-schedule.php?dep=". $result['department_id'] ."&maj=". $result['major_id'] ."&class=".$result['class_id']);
        exit(0);
    }
    if(isset($_GET['delete-sch'])){
        $delete_id = $_GET['delete-sch'];
        $string = $_SERVER['QUERY_STRING'];
        $new_string = str_replace('&delete-sch='. $delete_id, '', $string);


        $delete = mysqli_query($conn, "DELETE FROM schedule_study WHERE schedule_id='". $delete_id ."'");
        if($delete == true){
            $_SESSION['ADD_DONE'] = "Delete schedule has completed.";
            header("Location:". SITEURL."add-schedule.php?".$new_string);
            exit(0);
        }else{
            $_SESSION['ADD_DONE_ERROR'] = "Delete schedule has not completed.";
            header("Location:". SITEURL."add-schedule.php?".$new_string);
            exit(0);
        }
    }
?>