<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $teacherId = '';
    if(!empty($_SESSION['LOGIN_USERID'])){
        $teacherId = $_SESSION['LOGIN_USERID'];
    }
    // print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once('ims-include/head-tage.php');
        # link to teacher style 
        include_once('ims-include/staff__head_tage.php');
    ?>
</head>
<body>
    <?php
        include_once('ims-include/staff__topheader.php');
    ?>

    <section id="sidebar__content" onclick="closeProfileDash(), topNotication()">
        
    <!-- sidebar  -->
    <?php
        include_once('ims-include/staff__sidebar.php');
    ?>

        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Input student score <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Student score</p>
           </div>
           <div class="all__teacher student__score">
               <div class="search__subject">
                    <p>Search your subject here</p>                  
                    <form action="" method="post">
                        <div class="form__search">
                            <!-- <label for="">Year of study</label> -->
                            <select name="year_of_study" id="year_of_study" required class="subject_list selectpicker d-block" data-live-search="true">
                                <option disabled selected>ជ្រើសរើសឆ្នាំសិក្សា</option>
                                <?php
                                    $year_of_study = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                    while($result = mysqli_fetch_assoc($year_of_study)){
                                ?>
                                    <option value="<?=$result['year'];?>" <?php
                                        if(isset($_POST['search_subject'])){
                                            if($_POST['year_of_study'] == $result['year']){
                                                echo 'selected';
                                            }
                                        }else{
                                            if($result['year'] == date('Y')) echo 'selected';
                                        }
                                    ?>>ឆ្នាំសិក្សា <?=$result['year'];?></option>
                                <?php
                                    }
                                    mysqli_free_result($year_of_study);
                                ?>
                            </select>

                            <div class="border-right"></div>
                            <!-- <label for="">Semester</label> -->
                            <select name="semester" id="semester" required>
                                <option selected disabled>ជ្រើសរើសឆមាស</option>
                                <?php
                                    $this_year = "";
                                    if(isset($_POST['search_subject'])){
                                        $this_year = mysqli_real_escape_string($conn, $_POST['year_of_study']);
                                    }else{
                                        $this_year = date('Y');
                                    }

                                    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $this_year ."'");
                                    while($result = mysqli_fetch_assoc($semester)){
                                ?>            
                                    <option value="<?=$result['year_semester_id'];?>"
                                    <?php
                                        if(isset($_POST['search_subject'])){
                                            if(isset($_POST['semester'])  && $_POST['semester']== $result['year_semester_id']){
                                                echo "selected";
                                            }
                                        }
                                    ?>>ឆមាសទី <?=$result['semester'];?></option>
                                <?php
                                    }
                                    // mysqli_free_result($semester);
                                ?>
                                
                            </select>

                            <button class="search_score" type="submit" name="search_subject"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </form>
               </div>
               <div class="show__subject">
                <?php
                    if(!isset($_POST['search_subject'])){
                        
                        ######### Include current subject fo teacher ################
                        include_once('current-subject.php');



                    }else{
                        if(empty($_POST['semester'])){
                            echo 'Please select semester.';
                        }else{
                            #######################
                            ### Filter start
                            #######################
                            $year_of_study = $_POST['year_of_study'];
                            $semester = $_POST['semester'];


                            $subject = "SELECT * FROM schedule_study 
                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                            WHERE year_of_study.year_of_study = '" . $year_of_study ."'
                                            AND schedule_study.done_status = '1'
                                            AND year_of_study.year_semester_id = '". $semester ."'
                                            AND schedule_study.instructor_id ='". $teacherId ."'
                                            ORDER BY schedule_study.day ASC";
                    



                            // $subject = "SELECT * FROM schedule_study 
                            //             INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                            //             INNER JOIN class ON schedule_study.class_id = class.class_id 
                            //             INNER JOIN major ON class.major_id = major.major_id 
                            //             INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                            //             WHERE year_of_study.year_of_study = '" . $year_of_study ."'
                            //             AND schedule_study.done_status = '1'
                            //             AND year_of_study.year_semester_id = '". $semester ."'
                            //             AND schedule_study.instructor_id ='". $_SESSION['LOGIN_USERID'] ."'
                            //             ORDER BY schedule_study.day ASC";
                            $subjectRun = mysqli_query($conn, $subject);

                            if(mysqli_num_rows($subjectRun) > 0){
                                $result = mysqli_fetch_assoc($subjectRun);
                            

                ?>

                           
                    <p><i class="fa fa-search" aria-hidden="true"></i><b>Your subject </b><br> Semester: <b><?=$result['semester'];?></b> - Academy year: <b><?=$result['year_of_study'];?></b></p>
                   
                    <?php
                            }
                            mysqli_free_result($subjectRun);



                            $subjectSql = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code, 
                                                    schedule_study.class_id, 
                                                    year_of_study.year_of_study, 
                                                    year_of_study.semester 
                                                    FROM schedule_study 
                                                    INNER JOIN year_of_study ON year_of_study.year_semester_id = schedule_study.year_semester_id 
                                                    WHERE year_of_study.year_of_study = '" . $year_of_study ."'
                                                    AND schedule_study.done_status = '1'
                                                    AND year_of_study.year_semester_id = '". $semester ."'
                                                    AND schedule_study.instructor_id ='". $teacherId ."'
                                                    ORDER BY schedule_study.day ASC");
                    ?>



                    <div class="control__content__subject">
                           <?php
                                if(mysqli_num_rows($subjectSql) > 0){
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
                                       <p>Subj: <b><?=$result['subject_name'];?></b></p>
                                       <p>Code: <b><?=$result['subject_code'];?> - <?=$result['credit']."(".$result['theory'] .".". $result['execute'] .".".$result['apply'] .")";?></b></p>
                                       <p>Class: <b class="text-primary"><?=$result['class_code'];?></b></p>
                                       <p>Major: <b class="text-primary"><?=$result['major'];?></b></p>
                                       <div class="border-bottom my-1"></div>
                                       <small class="text-secondary"><?=$result['day'];?> (<?=$result['start_time']." - " .$result['end_time'];?>) - <?=$result['room'];?></small>
                                   </a>
                               </div>
                           <?php
                                   }
                           ?>
                    </div>


                <?php
                            #######################
                                ### Filter end
                            #######################
                                }else{
                                    echo "<p>No subject founded.</p>";
                                }

                        }
                    }
                ?>
               </div>
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        $(document).ready(function(){
            $('#year_of_study').on('change', function(){
                var yearOfStudy = $(this).val();
                if(yearOfStudy){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'year_of_study_id='+yearOfStudy,
                        success:function(html){
                            $('#semester').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    $('#semester').html('<option value="">Select academy year first</option>');
                }
            });
        });
    </script>

</body>
</html>