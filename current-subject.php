<?php

    $date = date('Y-m-d');
    $year = date('Y');
    $teacherId = '';
    if(!empty($_SESSION['LOGIN_USERID'])){
        $teacherId = $_SESSION['LOGIN_USERID'];
    }



    $subjectQry = "SELECT * FROM schedule_study 
                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                        WHERE schedule_study.instructor_id ='". $teacherId. "' AND schedule_study.done_status = '1'
                        AND year_of_study.finish_semester > '" . $date ."'
                        AND year_of_study.year_of_study = '" . $year ."'";


    
    $subject = mysqli_query($conn, $subjectQry);
    if(mysqli_num_rows($subject) > 0){
        $result = mysqli_fetch_assoc($subject);
        

?>
    <p><i class="fa fa-clock-o" aria-hidden="true"></i><b>Your current subject</b> <br> Semester: <b><?=$result['semester'];?></b> - Academy year: <b><?=$result['year_of_study'];?></b></p>
<?php
    }
    mysqli_free_result($subject);


    // start content here ! 

    $subjectSql = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code, 
                                        schedule_study.class_id, 
                                        year_of_study.year_of_study, 
                                        year_of_study.semester 
                                        FROM schedule_study 
                                        INNER JOIN year_of_study ON year_of_study.year_semester_id = schedule_study.year_semester_id 
                                        WHERE schedule_study.instructor_id = '".$teacherId."' 
                                        AND schedule_study.done_status = '1' 
                                        AND year_of_study.finish_semester > '".$date."' 
                                        AND year_of_study.year_of_study = '".$year."' 
                                        ORDER BY schedule_study.day ASC;");


                                        
    if(mysqli_num_rows($subjectSql) > 0){


?>
    <div class="control__content__subject">
            <?php
                
                while($subjectFetch = mysqli_fetch_assoc($subjectSql)){  
                    $class_id = $subjectFetch['class_id'];
                    $subject_code = $subjectFetch['subject_code'];

                    $contentSubject = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id 
                                                    INNER JOIN major ON class.major_id = major.major_id
                                                    WHERE schedule_study.class_id = '". $class_id ."'
                                                    AND schedule_study.subject_code = '". $subject_code ."'");

                    $result = mysqli_fetch_assoc($contentSubject);

                        
            ?>

                <div class="content__subject">
                    <a href="<?=SITEURL?>student-list.php?subject=<?=$result['schedule_id'];?>">
                        <p>Code: <b class="text-primary"><?=$result['subject_code'];?> - <?=$result['credit']."(".$result['theory'] .".". $result['execute'] .".".$result['apply'] .")";?></b></p>
                        <p>Subj: <b class="text-primary"><?=$result['subject_name'];?></b></p>
                        <p>Class: <b><?=$result['class_code'];?></b> - Year: <b><?=$result['year_level'];?></b></p>
                        <p>Major: <b><?=$result['major'];?></b></p>
                        <div class="border-bottom my-1"></div>
                        <small class="text-secondary"><?=$result['day'];?> (<?=$result['start_time']." - " .$result['end_time'];?>) - <?=$result['room'];?></small>
                    </a>
                </div>
            <?php
                    // break;
                }
            
                
            ?>
    </div>


<?php
    }else{
?>
    <!-- <p><i class="fa fa-clock-o" aria-hidden="true"></i><b>Your current subject</b> <br> Semester: <b><?=$result['semester'];?></b> - Academy year: <b><?=$result['year_of_study'];?></b></p>
     -->
    <p> <i class="fa fa-clock-o" aria-hidden="true"></i>Your current subject show here.</p>
    <p class="text-danger mt-2">No current subject applied.</p>
<?php
    }