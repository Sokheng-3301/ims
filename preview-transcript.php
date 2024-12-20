<?php
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
        $infoQuery = mysqli_query($conn, "SELECT * FROM student_info 
                                            INNER JOIN class ON class.class_id = student_info.class_id
                                            INNER JOIN major ON class.major_id = major.major_id
                                            INNER JOIN department ON major.department_id = department.department_id

                                            WHERE student_info.id='". $id. "'");
        if(mysqli_num_rows($infoQuery) > 0){
            $infoData = mysqli_fetch_assoc($infoQuery);
            $class_id = $infoData['class_id'];
            $student_id = $infoData['student_id'];
            
        }else{
            header("Location:". SITEURL."request.php");
            exit;
        }
    }else{
        header("Location:". SITEURL."request.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once('ims-include/head-tage.php');
        # link to teacher style 
        include_once('ims-include/staff__head_tage.php');
        
    ?>
    <link rel="stylesheet" href="<?=SITEURL?>ims-assets/ims-custom-style/transcript.css">
</head>
<body>
    <div id="transcript_content">
        <button id="savePDF" class="btn btn-sm btn-danger mb-3 ms-auto d-block"><i class="fa fa-save text-white" aria-hidden="true"></i>Save to PDF</button>
        <h1 id="main_title">OFFICIAL ACADEMIC TRANSCRIPT</h1>

        <?php
            if($infoData['level_study'] == 'Associate Degree'){
        ?>
            <!-- Associate degree start  -->
                <div class="flex_item">
                    <div class="item">
                        <p><span class="title">Name</span>: <span class="value"><?php echo ($infoData['gender']) == 'male' ? 'Mr. ': 'Miss. '; echo strtoupper($infoData['firstname']). " ".strtoupper($infoData['lastname']);?></span></p>
                        <p><span class="title">Student ID</span>: <span class="value"><?=$infoData['student_id'];?></span></p>
                        <p><span class="title">Nationality</span>: <span class="value"><?=$infoData['nationality'];?></span></p>
                        <p><span class="title">Date of Birth</span>: <span class="value"><?=$infoData['birth_date'];?></span></p>
                        <p><span class="title">Place of Birth</span>: <span class="value"><?=$infoData['place_of_birth'];?></span></p>
                    </div>
                    <div class="item">
                        <p><span class="title">Department</span>: <span class="value"><?=$infoData['department'];?></span></p>
                        <p><span class="title">Degree</span>: <span class="value"><?php echo ($infoData['level_study'] == 'Associate Degree')? 'Assocate in '.$infoData['major'] : 'Bachelor in '. $infoData['major'];?></span></p>
                        <p><span class="title">Major Subject</span>: <span class="value"><?=$infoData['major']?></span></p>
                        <p><span class="title">Date of Admission</span>: <span class="value">
                            <?php
                                $startAdmission = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                        INNER JOIN class ON schedule_study. class_id = class.class_id

                                                                        WHERE schedule_study.year_level='1' AND schedule_study.class_id ='". $class_id ."'");
                                if(mysqli_num_rows($startAdmission) > 0){
                                    $data = mysqli_fetch_assoc($startAdmission);
                                    $semester_id = $data['year_semester_id'];
                                    $year_of_study = $data['year_of_study'];

                                    $startAdmission = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id = '". $semester_id ."' AND year_of_study = '". $year_of_study ."' AND semester = '1'");
                                    if(mysqli_num_rows($startAdmission) > 0){
                                        $data = mysqli_fetch_assoc($startAdmission);
                                        $startDate = date_create($data['start_semester']);
                                        echo date_format($startDate, 'd F Y');

                                    }else{
                                        echo date('d F Y');
                                    }
                                }else{
                                    echo date('d F Y');
                                    
                                }

                            ?>
                        </span></p>
                        <p><span class="title">Date of Graduation</span>: <span class="value">
                            <?php
                                $startAdmission = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                        INNER JOIN class ON schedule_study. class_id = class.class_id
                                                                        WHERE schedule_study.year_level='2' AND schedule_study.class_id ='". $class_id ."'");
                                if(mysqli_num_rows($startAdmission) > 0){
                                    $data = mysqli_fetch_assoc($startAdmission);
                                    $semester_id = $data['year_semester_id'];
                                    $year_of_study = $data['year_of_study'];
                                    
                                    $startAdmission = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id = '". $semester_id ."' AND semester = '2'");
                                    if(mysqli_num_rows($startAdmission) > 0){
                                        $data = mysqli_fetch_assoc($startAdmission);
                                        $finishDate = date_create($data['finish_semester']);
                                        echo date_format($finishDate, 'd F Y');
                                    }else{
                                        echo date('d F Y');
                                    }
                                }else{
                                    echo date('d F Y');
                                }

                            ?>
                        </span></p>
                    </div>
                </div>

                <div class="flex_table">
                    <div class="tb">
                        <table>
                            <thead>
                            
                                <tr>
                                    <th class="text-left code">Code</th>
                                    <th class="text-left">Subject</th>
                                    <th colspan="2" class="text-right fit">Credits / Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sum">First Year </td>
                                    <td class="sum">1<sup>st</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit1 = 0;
                                        $creditxpoint1 = 0;
                                        $passCredit = 0;
                                        $projectCredit = 0;


                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '1' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '1'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];
                                                



                                    ?>
                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint1 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint1 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint1 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint1 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint1 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint1 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint1 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint1 += 0* $result_data['credit'];
                                                        }

                                                        


                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint1 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint1 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint1 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint1 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint1 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint1 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint1 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint1 += 0* $result_data['credit'];
                                                        }
                                                    }
                                                    
                                                    if($subject_type != 'ចុះកម្មសិក្សា'){
                                                        $credit1 += $result_data['credit'];
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }                                                                   
                                                    }
                                                    
                                                }
                                            ?>
                                    </td>
                                </tr>
                                    <?php
                                                
                                                

                                            }
                                            

                                        }
                                    ?>


                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum"><?php echo $gpa1 = ($creditxpoint1 != '0')? $creditxpoint1 / $credit1 : '0'; echo substr($gpa1,0, 4)?></td>
                                </tr>
                            

                                <!-- -------2222----- -->


                                <tr>
                                    <td class="sum">First Year </td>
                                    <td class="sum">2<sup>nd</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                    <?php
                                        mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit2 = 0;
                                        $creditxpoint2 = 0;
                                        $creditSemester2Year1 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '1' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '2'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                                // echo $result_data['credit'];
                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $creditSemester2Year1 +=  $result_data['credit'];
                                                }

                                                // if($subject_type != 'គម្រោង'){
                                                
                                    ?>

                                <tr>
                                <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint2 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint2 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint2 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint2 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint2 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint2 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint2 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint2 += 0* $result_data['credit'];
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint2 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint2 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint2 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint2 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint2 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint2 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint2 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint2 += 0* $result_data['credit'];
                                                        }
                                                        
                                                        
                                                    }

                                                    if($subject_type != 'ចុះកម្មសិក្សា'){

                                                        $credit2 += $result_data['credit'];

                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }
                                                    }
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                    <?php
                                                
                                                    
                                                // }else{
                                                //     $projectCredit = $result_data['credit'];
                                                // }
                                            }
                                            
                                            

                                        }
                                    ?>
                                
                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum"><?php $gpa2 = ($creditxpoint2 != '0')? $creditxpoint2 / $credit2 : '0'; echo substr($gpa2, 0, 4)?></td>
                                </tr>
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="tb">
                        <table>
                            <thead>
                            
                                <tr>
                                    <th class="text-left code">Code</th>
                                    <th class="text-left">Subject</th>
                                    <th colspan="2" class="text-right fit">Credits / Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sum">Second Year </td>
                                    <td class="sum">1<sup>st</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit3 = 0;
                                        $creditxpoint3 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '2' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '1'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                    ?>


                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'] + $projectCredit;?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint3 += 4.0* ($result_data['credit']);
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint3 += 3.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint3 += 3* ($result_data['credit']);
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint3 += 2.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint3 += 2* ($result_data['credit']);
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint3 += 1.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint3 += 1* ($result_data['credit']);
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint3 += 0* ($result_data['credit']);
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint3 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint3 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint3 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint3 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint3 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint3 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint3 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint3 += 0* $result_data['credit'];
                                                        }

                                                    }
                                                    
                                                    if($subject_type != 'ចុះកម្មសិក្សា'){

                                                        $credit3 += $result_data['credit'];
        
                                                        
                                                    
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                            // $projectCredit = $projectCredit;
                                                        }
                                                    }
                                                }
                                            ?>
                                        
                                    </td>
                                </tr>
                                    <?php
                                                
                                            }
                                            

                                        }
                                    ?>
                            
                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum">
                                        <?php 
                                            $credit3 = $credit3 + $projectCredit;
                                            $gpa3 = ($creditxpoint3 != '0')? $creditxpoint3 / ($credit3) : '0'; 
                                            echo substr($gpa3, 0, 4);
                                            ?>
                                    </td>
                                </tr>

                                <!-- ------222222222222------ -->


                                <tr>
                                    <td class="sum">Second Year </td>
                                    <td class="sum">2<sup>nd</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit4 = 0;
                                        $creditxpoint4 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '2' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '2'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                    ?>
                                

                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        // echo $grade_data['s_u'];
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint4 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint4 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint4 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint4 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint4 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint4 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint4 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint4 += 0* $result_data['credit'];
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint4 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint4 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint4 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint4 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint4 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint4 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint4 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint4 += 0* $result_data['credit'];
                                                        }
                                                    }

                                                    if($subject_type != 'ចុះកម្មសិក្សា'){
                                                        $credit4 += $result_data['credit'];
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }
                                                    }
                                                }
                                            ?>
                                    </td>
                                </tr>

                                    <?php
                                                
                                            }
                                            

                                        }
                                    ?>



                                <tr class="">
                                    <td class="code pt-4"></td>
                                    <td class="subject total pt-4">Number of Credits Studied</td>
                                    <td class="fit pt-4"></td>
                                    <td class="fit total pt-4">
                                        <?php
                                            $tranferred  = 0;
                                            echo ($passCredit) - $tranferred;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Number of Credits Transferred</td>
                                    <td class="fit"></td>
                                    <td class="fit total">
                                        <?php
                                            if($tranferred == 0){
                                                echo '00';
                                            }else{
                                                echo $tranferred;
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Total Number of Credits Earned</td>
                                    <td class="fit"></td>
                                    <td class="fit total">
                                        <?=$credit1 + $credit2 + $credit3 + $credit4;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Cumulative Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit total underline">
                                        <?php
                                            $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3+$creditxpoint4)/($credit1+$credit2+$credit3+$credit4); 
                                            echo substr($gpax, 0, 4);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center total pt-3">Transcript Closed</td>
                                </tr>
                                
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- Associate degree end  -->

        <?php
            }elseif($infoData['level_study'] == "Bachelor's Degree"){
        ?>
            <!-- Bachelor degree start -->
                <div class="flex_item">
                    <div class="item">
                        <p><span class="title">Name</span>: <span class="value"><?php echo ($infoData['gender']) == 'male' ? 'Mr. ': 'Miss. '; echo strtoupper($infoData['firstname']). " ".strtoupper($infoData['lastname']);?></span></p>
                        <p><span class="title">Student ID</span>: <span class="value"><?=$infoData['student_id'];?></span></p>
                        <p><span class="title">Nationality</span>: <span class="value"><?=$infoData['nationality'];?></span></p>
                        <p><span class="title">Date of Birth</span>: <span class="value"><?=$infoData['birth_date'];?></span></p>
                        <p><span class="title">Place of Birth</span>: <span class="value"><?=$infoData['place_of_birth'];?></span></p>
                    </div>
                    <div class="item">
                        <p><span class="title">Department</span>: <span class="value"><?=$infoData['department'];?></span></p>
                        <p><span class="title">Degree</span>: <span class="value"><?php echo ($infoData['level_study'] == 'Associate Degree')? 'Assocate in '.$infoData['major'] : 'Bachelor in '. $infoData['major'];?></span></p>
                        <p><span class="title">Major Subject</span>: <span class="value"><?=$infoData['major']?></span></p>
                        <p><span class="title">Date of Admission</span>: <span class="value">
                            <?php
                                $startAdmission = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                        INNER JOIN class ON schedule_study. class_id = class.class_id

                                                                        WHERE schedule_study.year_level='3' AND schedule_study.class_id ='". $class_id ."'");
                                if(mysqli_num_rows($startAdmission) > 0){
                                    $data = mysqli_fetch_assoc($startAdmission);
                                    $semester_id = $data['year_semester_id'];
                                    $year_of_study = $data['year_of_study'];

                                    $startAdmission = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id = '". $semester_id ."' AND year_of_study = '". $year_of_study ."' AND semester = '1'");
                                    if(mysqli_num_rows($startAdmission) > 0){
                                        $data = mysqli_fetch_assoc($startAdmission);
                                        $startDate = date_create($data['start_semester']);
                                        echo date_format($startDate, 'd F Y');

                                    }else{
                                        echo date('d F Y');
                                    }
                                }else{
                                    echo date('d F Y');
                                    
                                }

                            ?>
                        </span></p>
                        <p><span class="title">Date of Graduation</span>: <span class="value">
                            <?php
                                $startAdmission = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                        INNER JOIN class ON schedule_study. class_id = class.class_id
                                                                        WHERE schedule_study.year_level='4' AND schedule_study.class_id ='". $class_id ."'");
                                if(mysqli_num_rows($startAdmission) > 0){
                                    $data = mysqli_fetch_assoc($startAdmission);
                                    $semester_id = $data['year_semester_id'];
                                    $year_of_study = $data['year_of_study'];
                                    
                                    $startAdmission = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id = '". $semester_id ."' AND AND semester = '2'");
                                    if(mysqli_num_rows($startAdmission) > 0){
                                        $data = mysqli_fetch_assoc($startAdmission);
                                        $finishDate = date_create($data['finish_semester']);
                                        echo date_format($finishDate, 'd F Y');
                                    }else{
                                        echo date('d F Y');
                                    }
                                }else{
                                    echo date('d F Y');
                                }

                            ?>
                        </span></p>
                    </div>
                </div>

                <div class="flex_table">
                    <div class="tb">
                        <table>
                            <thead>
                            
                                <tr>
                                    <th class="text-left code">Code</th>
                                    <th class="text-left">Subject</th>
                                    <th colspan="2" class="text-right fit">Credits / Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sum">Third Year </td>
                                    <td class="sum">1<sup>st</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit1 = 0;
                                        $creditxpoint1 = 0;
                                        $passCredit = 0;
                                        $projectCredit = 0;

                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '3' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '1'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];
                                                



                                    ?>
                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint1 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint1 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint1 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint1 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint1 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint1 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint1 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint1 += 0* $result_data['credit'];
                                                        }

                                                        


                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint1 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint1 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint1 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint1 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint1 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint1 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint1 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint1 += 0* $result_data['credit'];
                                                        }
                                                    }
                                                    
                                                    if($subject_type != 'ចុះកម្មសិក្សា'){
                                                        $credit1 += $result_data['credit'];
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }                                                                   
                                                    }
                                                    
                                                }
                                            ?>
                                    </td>
                                </tr>
                                    <?php
                                                
                                                

                                            }
                                            

                                        }
                                    ?>


                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum"><?php echo $gpa1 = ($creditxpoint1 != '0')? $creditxpoint1 / $credit1 : '0'; echo substr($gpa1,0, 4)?></td>
                                </tr>
                            

                                <!-- -------2222----- -->


                                <tr>
                                    <td class="sum">Third Year </td>
                                    <td class="sum">2<sup>nd</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                    <?php
                                        mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit2 = 0;
                                        $creditxpoint2 = 0;
                                        $creditSemester2Year1 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '3' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '2'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                                // echo $result_data['credit'];
                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $creditSemester2Year1 +=  $result_data['credit'];
                                                }

                                                // if($subject_type != 'គម្រោង'){
                                                
                                    ?>

                                <tr>
                                <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint2 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint2 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint2 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint2 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint2 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint2 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint2 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint2 += 0* $result_data['credit'];
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint2 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint2 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint2 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint2 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint2 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint2 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint2 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint2 += 0* $result_data['credit'];
                                                        }
                                                        
                                                        
                                                    }

                                                    if($subject_type != 'ចុះកម្មសិក្សា'){

                                                        $credit2 += $result_data['credit'];

                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }
                                                    }
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                    <?php
                                                
                                                    
                                                // }else{
                                                //     $projectCredit = $result_data['credit'];
                                                // }
                                            }
                                            
                                            

                                        }
                                    ?>
                                
                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum"><?php $gpa2 = ($creditxpoint2 != '0')? $creditxpoint2 / $credit2 : '0'; echo substr($gpa2, 0, 4)?></td>
                                </tr>
                            
                            </tbody>
                        </table>
                    </div>
                    <div class="tb">
                        <table>
                            <thead>
                            
                                <tr>
                                    <th class="text-left code">Code</th>
                                    <th class="text-left">Subject</th>
                                    <th colspan="2" class="text-right fit">Credits / Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="sum">Fourth Year </td>
                                    <td class="sum">1<sup>st</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit3 = 0;
                                        $creditxpoint3 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '4' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '1'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                    ?>


                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint3 += 4.0* ($result_data['credit']);
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint3 += 3.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint3 += 3* ($result_data['credit']);
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint3 += 2.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint3 += 2* ($result_data['credit']);
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint3 += 1.50* ($result_data['credit']);
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint3 += 1* ($result_data['credit']);
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint3 += 0* ($result_data['credit']);
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint3 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint3 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint3 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint3 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint3 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint3 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint3 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint3 += 0* $result_data['credit'];
                                                        }

                                                    }
                                                    
                                                    if($subject_type != 'ចុះកម្មសិក្សា'){

                                                        $credit3 += $result_data['credit'];
        
                                                        
                                                    
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                            // $projectCredit = $projectCredit;
                                                            
                                                        }
                                                    }
                                                }
                                            ?>
                                        
                                    </td>
                                </tr>
                                    <?php
                                                
                                            }
                                            

                                        }
                                    ?>
                            
                                <tr>
                                    <td></td>
                                    <td class="text-center sum">Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit text-center sum">
                                        <?php 
                                            // $credit3 = $credit3 + $projectCredit;
                                            $credit3 = $credit3;
                                            $gpa3 = ($creditxpoint3 != '0')? $creditxpoint3 / ($credit3) : '0'; 
                                            echo substr($gpa3, 0, 4);
                                            ?>
                                    </td>
                                </tr>

                                <!-- ------222222222222------ -->


                                <tr>
                                    <td class="sum">Fourth Year </td>
                                    <td class="sum">2<sup>nd</sup> Semester</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                    <?php
                                        // mysqli_free_result($first_semester_year);
                                        
                                        $count_n = 1;
                                        $credit4 = 0;
                                        $creditxpoint4 = 0;
                                        $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                    schedule_study.year_semester_id,
                                                                                    -- schedule_study.schedule_id,
                                                                                    
                                                                                    course.subject_code,
                                                                                    course.subject_name,
                                                                                    course.credit,
                                                                                    course.theory,
                                                                                    course.execute,
                                                                                    course.apply,
                                                                                    course.subject_type,

                                                                                    subject_type.type_name

                                                                                    FROM schedule_study 
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.year_level = '4' 
                                                                                    AND schedule_study.class_id ='". $class_id ."'
                                                                                    AND year_of_study.semester = '2'
                                                                                    AND schedule_study.done_status = '1'");
                                                                                    
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);
                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_code = $result_data['subject_code'];

                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                        WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                $subject_type = $result_data['type_name'];

                                    ?>
                                

                                <tr>
                                    <td scope="row" class="code"><?=$result_data['subject_code'];?></td>
                                    <td class="subject"><?=$result_data['subject_name'];?></td>
                                    <td class="fit"><?=$result_data['credit'];?></td>
                                    <td class="fit">
                                            <?php
                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                            AND score_submitted.submit_status ='2'");
                                                if(mysqli_num_rows($grade) > 0){
                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                    if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                        // echo $grade_data['s_u'];
                                                        $su_grade = $grade_data['s_u'];
                                                        echo $su_grade;

                                                        if($su_grade == 'A'){
                                                            $creditxpoint4 += 4.0* $result_data['credit'];
                                                        }elseif($su_grade == 'B+'){
                                                            $creditxpoint4 += 3.50* $result_data['credit'];
                                                        }elseif($su_grade == 'B'){
                                                            $creditxpoint4 += 3* $result_data['credit'];
                                                        }elseif($su_grade == 'C+'){
                                                            $creditxpoint4 += 2.50* $result_data['credit'];
                                                        }elseif($su_grade == 'C'){
                                                            $creditxpoint4 += 2* $result_data['credit'];
                                                        }elseif($su_grade == 'D'){
                                                            $creditxpoint4 += 1.50* $result_data['credit'];
                                                        }elseif($su_grade == 'E'){
                                                            $creditxpoint4 += 1* $result_data['credit'];
                                                        }elseif($su_grade == 'F'){
                                                            $creditxpoint4 += 0* $result_data['credit'];
                                                        }
                                                    }else{

                                                        $grade_total = $grade_data['grade'];
                                                        echo $grade_total;

                                                        if($grade_total == 'A'){
                                                            $creditxpoint4 += 4.0* $result_data['credit'];
                                                        }elseif($grade_total == 'B+'){
                                                            $creditxpoint4 += 3.50* $result_data['credit'];
                                                        }elseif($grade_total == 'B'){
                                                            $creditxpoint4 += 3* $result_data['credit'];
                                                        }elseif($grade_total == 'C+'){
                                                            $creditxpoint4 += 2.50* $result_data['credit'];
                                                        }elseif($grade_total == 'C'){
                                                            $creditxpoint4 += 2* $result_data['credit'];
                                                        }elseif($grade_total == 'D'){
                                                            $creditxpoint4 += 1.50* $result_data['credit'];
                                                        }elseif($grade_total == 'E'){
                                                            $creditxpoint4 += 1* $result_data['credit'];
                                                        }elseif($grade_total == 'F'){
                                                            $creditxpoint4 += 0* $result_data['credit'];
                                                        }
                                                    }

                                                    if($subject_type != 'ចុះកម្មសិក្សា'){
                                                        $credit4 += $result_data['credit'];
        
                                                        if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                            $passCredit += $result_data['credit'];
                                                        }
                                                    }
                                                }
                                            ?>
                                    </td>
                                </tr>

                                    <?php
                                                
                                            }
                                            

                                        }
                                    ?>



                                <tr class="">
                                    <td class="code pt-4"></td>
                                    <td class="subject total pt-4">Number of Credits Studied</td>
                                    <td class="fit pt-4"></td>
                                    <td class="fit total pt-4">
                                        <?php
                                            $tranferred  = 0;
                                            echo ($passCredit) - $tranferred;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Number of Credits Transferred</td>
                                    <td class="fit"></td>
                                    <td class="fit total">
                                        <?php
                                            if($tranferred == 0){
                                                echo '00';
                                            }else{
                                                echo $tranferred;
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Total Number of Credits Earned</td>
                                    <td class="fit"></td>
                                    <td class="fit total">
                                        <?=$credit1 + $credit2 + $credit3 + $credit4;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="code"></td>
                                    <td class="subject total">Cumulative Grade Point Average</td>
                                    <td class="fit"></td>
                                    <td class="fit total underline">
                                        <?php
                                            if($credit1+$credit2+$credit3+$credit4 == '0'){
                                                $gpax = 0;
                                            }else{
                                                $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3+$creditxpoint4)/($credit1+$credit2+$credit3+$credit4); 
                                            }
                                            echo substr($gpax, 0, 4);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center total pt-3">Transcript Closed</td>
                                </tr>
                                
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- Bachelor degree end -->

        <?php
            }
        ?>

        <div class="flex_footer">
            <div class="sm_table">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center">Grade</th>
                            <th colspan="4" class="text-center">Mention</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>4.00</td>
                            <td>85-100</td>
                            <td>Excellent</td>
                            <td>S=SATIFACTORY</td>
                        </tr>
                        <tr>
                            <td>B+</td>
                            <td>3.50</td>
                            <td>80-84</td>
                            <td>Very Good</td>
                            <td>U=UNSATISFACTORY</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>3.00</td>
                            <td>70-79</td>
                            <td>Good</td>
                            <td>I=INCOMPLETE</td>
                        </tr>
                        <tr>
                            <td>C+</td>
                            <td>2.50</td>
                            <td>65-69</td>
                            <td>Fairly Good</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td>2.00</td>
                            <td>60-64</td>
                            <td>Fair</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td>1.50</td>
                            <td>50-59</td>
                            <td>Poor</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td>1.00</td>
                            <td>40-49</td>
                            <td>Very Poor</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>F</td>
                            <td>0.00</td>
                            <td>< 40</td>
                            <td>Fail</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="signature">
                <p>Kampong Speu, <?php
                    echo $date = date("d F Y");
                ?></p>
                <h3>Director</h3>
                <h3 class="name">HONG Kimcheang, PhD</h3>
            </div>
        </div>

    </div>



    <!-- include javaScript in web page  -->
    <?php #include_once('ims-include/script-tage.php');?>
    <script>
        // export default function printDiv({divId, title}) {
        // let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=150');

        // mywindow.document.write(`<html><head><title>${title}</title>`);
        // mywindow.document.write('</head><body >');
        // mywindow.document.write(document.getElementById(divId).innerHTML);
        // mywindow.document.write('</body></html>');

        // mywindow.document.close(); // necessary for IE >= 10
        // mywindow.focus(); // necessary for IE >= 10*/

        // mywindow.print();
        // mywindow.close();

        // return true;
        // }
        var status = 1;
        var btnSave = document.getElementById("savePDF")
        btnSave.addEventListener("click", function(){
            if(btnSave.className == 'btn btn-sm btn-danger mb-3 ms-auto d-block'){
                btnSave.className = 'btn btn-sm btn-danger mb-3 ms-auto d-none';
            }
            window.print();
            status = 0;
        });

        var cancelBtn = window.document.querySelector('.cancel-button');
        cancelBtn.addEventListener("click", function(){
            alert('hi');
        });
        
        // if(status == '0'){
        //     if(btnSave.className == 'btn btn-sm btn-danger mb-3 ms-auto d-none'){
        //         btnSave.className = 'btn btn-sm btn-danger mb-3 ms-auto d-block';
        //     } 
        // }

    </script>
</body>
</html>