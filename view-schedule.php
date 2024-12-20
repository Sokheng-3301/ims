<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once("function.php");

    $monday_id[]    = '';
    $tuesday_id[]   = '';
    $wednesday_id[] = '';
    $thursday_id[]  = '';
    $friday_id[]    = '';
    $saturday_id[]  = '';
    $sunday_id[]    = '';


    // if(!empty($_GET['q'])){
    //     $major_id = $_GET['q'];
    // }else{
    //     // $department_id = 1;
    //     header("Location:".SITEURL."schedule.php");
    //     exit(0);
    // }

    // $department_sql = mysqli_query($conn, "SELECT * FROM major INNER JOIN department ON major.department_id = department.department_id WHERE major_id='". $major_id ."'");
    // if(mysqli_num_rows($department_sql) > 0){
    //     $department_result = mysqli_fetch_assoc($department_sql);
    // }else{
    //     header("Location:".SITEURL."schedule.php");
    //     exit(0);
    // }
   



// ----------------
        
    if(!empty($_GET['maj']) && !empty($_GET['dep']) && !empty($_GET['class'])){

        $dep_id = $_GET['dep'];
        $major_id = $_GET['maj'];
        $class_id = $_GET['class'];
        $class_code_default = $class_id;
    }else{
        // $department_id = 1;
        header("Location:".SITEURL."view-class.php?dep=".$dep_id."&maj=". $major_id);
        exit(0);
    }

    $department_sql = mysqli_query($conn, "SELECT * FROM class
                                            INNER JOIN major ON major.major_id =  class.major_id
                                            INNER JOIN department ON major.department_id = department.department_id
                                            WHERE class.class_id='". $class_id ."'");
    if(mysqli_num_rows($department_sql) > 0){
        $department_result = mysqli_fetch_assoc($department_sql);
        // $major_id = $department_result['major_id'];
    }else{
        header("Location:".SITEURL."view-class.php?dep=".$dep_id."&maj=". $major_id);
        exit(0);
    }
// -----------------







    $this_year = date("Y");
    // $year_of_study = mysqli_query($conn, "SELECT * FROM year");
    // while($year_of_study_result = mysqli_fetch_assoc($year_of_study)){
    //     // echo $year_of_study_result['year']."<br>";
    //     if($year_of_study_result['year'] == date("Y")){
    //         $this_year = $year_of_study_result['year_id'];
    //     }
    // }
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
                <h5 class="super__title">View schedule <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Schedule</p>
            </div>
            <div class="my-3">
                <a href="<?=SITEURL;?>schedule.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
            
            
           

            <div class="all__teacher schedule">
                <p>Filter to show schedule in</p>

                <!-- <div class="mt-2" id="department_info">
                    <p>Department : <span class="fw-bold"><?=$department_result['department'];?></span></p>
                    <p>Major : <span class="fw-bold"><?=$department_result['major'];?></span></p>
                </div> -->

                <div class="grid_item mb-2">
                        <div class="">Class code</div> <div>:</div>
                        <div class=""><span class="fw-bold text-primary"><?=$department_result['class_code'];?> </span></div>

                        
                        <div class="">Department</div> <div>:</div>
                        <div class=""><span class="fw-bold"><?=$department_result['department'];?> </span></div>
                    
                    
                        <div class="">Major</div> <div>:</div>
                        <div class=""><span class="fw-bold"><?=$department_result['major'];?> </span></div>
                
                    
                    
                    
                        <div class="">Degree</div> <div>:</div>
                        <div class=""><span class="fw-bold"><?=$department_result['level_study'];?> </span> - Year: <span class="fw-bold"><?=$department_result['year_level'];?></div>
                </div>

                <form action="" method="post" class="">
                    <input type="hidden" class="d-none" name="major" value="<?=$major_id;?>">
                    <input type="hidden" class="d-none" name="class" value="<?=$class_code_default;?>">
                    <div class="filter__manage">
                        <p class="title_filter"><i class="fa fa-filter" aria-hidden="true"></i><span class="me-4">Filter</span>
                            <select name="year_of_study" id="year_of_study" required class="selectpicker" data-live-search="true">
                                <option disabled selected>ជ្រើសរើសឆ្នាំសិក្សា</option>
                                <?php
                                    $year_of_study = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                    while($result = mysqli_fetch_assoc($year_of_study)){
                                ?>
                                    <option value="<?=$result['year'];?>" 
                                    <?php
                                        if(isset($_POST['year_of_study'])){
                                            if( $_POST['year_of_study'] == $result['year']){
                                                echo "selected";
                                            }
                                        }else{
                                            echo ($result['year'] == date("Y")) ? 'selected' : '';
                                        }
                                    ?>
                                    >ឆ្នាំសិក្សា <?=$result['year'];?></option>
                                <?php
                                    }
                                    mysqli_free_result($year_of_study);
                                ?>
                            </select>
                        </p>
                        <p class="title_filter">
                            <select name="semester" id="semester" required>
                                <option selected disabled>ជ្រើសរើសឆមាស</option>

                                <?php
                                    if(isset($_POST['year_of_study'])){
                                        $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $_POST['year_of_study'] ."'");
                                        while($result = mysqli_fetch_assoc($semester)){
                                ?>
                                        <option value="<?=$result['year_semester_id'];?>"
                                        <?php
                                        
                                            if(isset($_POST['semester'])) {
                                                if($_POST['semester'] == $result['year_semester_id']){
                                                    echo "selected";
                                                }
                                            }    
                                        
                                        ?>>ឆមាសទី <?=$result['semester'];?></option>

                                <?php
                                        }
                                    }else{
                                    
                                        $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $this_year ."'");
                                        while($result = mysqli_fetch_assoc($semester)){
                                    ?>            
                                        <option value="<?=$result['year_semester_id'];?>"
                                        <?php
                                        
                                            if(isset($_POST['semester'])) {
                                                if($_POST['semester'] == $result['year_semester_id']){
                                                    echo "selected";
                                                }
                                            }    
                                        
                                        ?>>ឆមាសទី <?=$result['semester'];?></option>
                                    <?php
                                        }
                                    }
                                        mysqli_free_result($semester);
                                    ?>
                                
                            </select>
                        </p>     
                        <button class="search-schedule" name="filter_schedule" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>            
                    </div>
                </form>
                <div class="schedule__manage">

                <!-- start schedule  -->
                    <?php
                        if(isset($_POST['filter_schedule'])){
                            if(empty($_POST['semester']) || empty($_POST['class'])){
                                echo '<p class = "text-secondary">* សូមធ្វើការជ្រើសរើសនូវជម្រើសទាំងអស់ដើម្បីបង្ហាញកាលវិភាគ។</p>';
                            }else{

                                // $major = mysqli_real_escape_string($conn, $_POST['major']);
                                // $year_of_study = mysqli_real_escape_string($conn, $_POST['year_of_study']);
                                $semester = mysqli_real_escape_string($conn, $_POST['semester']);
                                $class = mysqli_real_escape_string($conn, $_POST['class']);
                                
                    ?>
                                    
                        <div class="schedule__container mb-3">
                            <div id="schedule_top">                          
                                <div class="part">
                                    <p id="duplicate" class="duplicate" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-clone" aria-hidden="true"></i>Duplicate</p>
                                </div>
                            </div>


                            <!-- MONDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">1. Monday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Monday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $monday_run = mysqli_query($conn, $monday_sql);

                                        if(mysqli_num_rows($monday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($monday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $monday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $monday_id[] = null;
                                                }
                                            
                                            }
                                            
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- MONDAY END  -->


                            <!-- TUESDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">2. Tuesday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $tuesday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Tuesday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $tuesday_run = mysqli_query($conn, $tuesday_sql);

                                        if(mysqli_num_rows($tuesday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($tuesday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $tuesday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $tuesday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- TUESDAY END  -->




                            <!-- WEDNESDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">3. Wednesday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $wednesday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Wednesday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $wednesday_run = mysqli_query($conn, $wednesday_sql);

                                        if(mysqli_num_rows($wednesday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($wednesday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $wednesday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $wednesday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- WEDNESDAY END  -->





                            <!-- THURSDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">4. Thursday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $thursday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Thursday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $thursday_run = mysqli_query($conn, $thursday_sql);

                                        if(mysqli_num_rows($thursday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($thursday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $thursday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $thursday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- THURSDAY END  -->



                            <!-- FRIDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">5. Friday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $friday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Friday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $friday_run = mysqli_query($conn, $friday_sql);

                                        if(mysqli_num_rows($friday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($friday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $friday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $friday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- FRIDAY END  -->



                            <!-- SATURDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">6. Saturday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $saturday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Saturday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $saturday_run = mysqli_query($conn, $saturday_sql);

                                        if(mysqli_num_rows($saturday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($saturday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $saturday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $saturday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- SATURDAY END  -->


                            <!-- SUNDAY START  -->
                                <div class="content">
                                    <p class="fw-bold fs-5 day__title">7. Sunday</p>
                                    <!-- select schedule where day = monday and at morning  -->
                                    <?php
                                        $sunday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON 
                                                        schedule_study.instructor_id = teacher_info.teacher_id 
                                                        WHERE year_semester_id = '". $semester ."'
                                                        AND  class_id = '".$class."' 
                                                        AND day = 'Sunday' ORDER BY at ASC";
                                        // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                        $sunday_run = mysqli_query($conn, $sunday_sql);

                                        if(mysqli_num_rows($sunday_run) > 0){
                                    ?>
                                        <div class="section">
                                            <!-- <p class="fw-bold text-danger">Morning</p> -->
                                    <?php
                                            while($result = mysqli_fetch_assoc($sunday_run)){                                   
                                    ?>
                                            <div class="table__content">
                                                <p><?php
                                                    echo $result['subject_code'] . " - ";
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";

                                                    mysqli_free_result($course);
                                                ?></p> 
                                                <p><?=$result['start_time'] . " - " . $result['end_time'];?></p>
                                                <p><?=$result['fn_khmer']. " " .$result['ln_khmer'];?></p>
                                                <p><?=$result['room'];?></p>
                                                <!-- <p><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$result['schedule_id'];?>">Edit</a></p> -->
                                            </div>                     
                                    <?php
                                                if($result['schedule_id'] != ''){
                                                    $sunday_id[] =  $result['schedule_id'];
                                                }else{
                                                    $sunday_id[] = null;
                                                }
                                            }
                                    ?>
                                        </div>   
                                    <?php
                                            
                                        }else{
                                            echo '<p class = "mt-3">Schedule no record.</p>';
                                        }
                                    ?>                                         
                                </div>
                            <!-- SUNDAY END  -->

                            
                        </div>
                    <?php
                            }
                        }
                    ?>
                <!-- end schedule -->
            </div>

            <!-- footer  -->
            <?php include_once('ims-include/staff__footer.php');?>
        </div>
    </section>


<!-- popup start  -->
<?php
        if(isset($_SESSION['ADD_DONE'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_DONE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>view-schedule.php?q=<?=$major_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE']);
        if(isset($_SESSION['ADD_DONE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_DONE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>view-schedule.php?q=<?=$major_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_DONE_ERROR']);

    ?>
<!-- popup end  -->




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centere d">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-clone" aria-hidden="true"></i>Duplicate schedule</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?=SITEURL;?>schedule-action.php" method="post">
                <input type="hidden" name="q" value="<?=$major_id;?>" required>
                <div class="modal-body">
                    <?php
                        foreach($monday_id as $monday_id){
                            $monday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $monday_id ."'");
                            if(mysqli_num_rows($monday_sql) > 0){
                                $monday_fetch = mysqli_fetch_assoc($monday_sql);
                                // echo "<pre>";
                                //     print_r($monday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$monday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="monday_subject_code[]" value="<?=$monday_fetch['subject_code'];?>">
                                <input type="hidden" name="monday_year_semester_id[]" value="<?=$monday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="monday_year_level[]" value="<?=$monday_fetch['year_level'];?>">
                                <input type="hidden" name="monday_start_time[]" value="<?=$monday_fetch['start_time'];?>">
                                <input type="hidden" name="monday_end_time[]" value="<?=$monday_fetch['end_time'];?>">
                                <input type="hidden" name="monday_at[]" value="<?=$monday_fetch['at'];?>">
                                <input type="hidden" name="monday_day[]" value="<?=$monday_fetch['day'];?>">
                                <input type="hidden" name="monday_room[]" value="<?=$monday_fetch['room'];?>">
                                <input type="hidden" name="monday_instructor_id[]" value="<?=$monday_fetch['instructor_id'];?>">
                                <input type="hidden" name="monday_done_status[]" value="<?=$monday_fetch['done_status'];?>">
                    <?php
                            }   
                        }
                    ?>



                    <?php
                        foreach($tuesday_id as $tuesday_id){
                            $tuesday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $tuesday_id ."'");
                            if(mysqli_num_rows($tuesday_sql) > 0){
                                $tuesday_fetch = mysqli_fetch_assoc($tuesday_sql);
                                // echo "<pre>";
                                //     print_r($tuesday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$tuesday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="tuesday_subject_code[]" value="<?=$tuesday_fetch['subject_code'];?>">
                                <input type="hidden" name="tuesday_year_semester_id[]" value="<?=$tuesday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="tuesday_year_level[]" value="<?=$tuesday_fetch['year_level'];?>">
                                <input type="hidden" name="tuesday_start_time[]" value="<?=$tuesday_fetch['start_time'];?>">
                                <input type="hidden" name="tuesday_end_time[]" value="<?=$tuesday_fetch['end_time'];?>">
                                <input type="hidden" name="tuesday_at[]" value="<?=$tuesday_fetch['at'];?>">
                                <input type="hidden" name="tuesday_day[]" value="<?=$tuesday_fetch['day'];?>">
                                <input type="hidden" name="tuesday_room[]" value="<?=$tuesday_fetch['room'];?>">
                                <input type="hidden" name="tuesday_instructor_id[]" value="<?=$tuesday_fetch['instructor_id'];?>">
                                <input type="hidden" name="tuesday_done_status[]" value="<?=$tuesday_fetch['done_status'];?>">

                    <?php
                            }   
                        }
                    ?>


                    <?php
                        foreach($wednesday_id as $wednesday_id){
                            $wednesday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $wednesday_id ."'");
                            if(mysqli_num_rows($wednesday_sql) > 0){
                                $wednesday_fetch = mysqli_fetch_assoc($wednesday_sql);
                                // echo "<pre>";
                                //     print_r($wednesday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$wednesday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="wednesday_subject_code[]" value="<?=$wednesday_fetch['subject_code'];?>">
                                <input type="hidden" name="wednesday_year_semester_id[]" value="<?=$wednesday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="wednesday_year_level[]" value="<?=$wednesday_fetch['year_level'];?>">
                                <input type="hidden" name="wednesday_start_time[]" value="<?=$wednesday_fetch['start_time'];?>">
                                <input type="hidden" name="wednesday_end_time[]" value="<?=$wednesday_fetch['end_time'];?>">
                                <input type="hidden" name="wednesday_at[]" value="<?=$wednesday_fetch['at'];?>">
                                <input type="hidden" name="wednesday_day[]" value="<?=$wednesday_fetch['day'];?>">
                                <input type="hidden" name="wednesday_room[]" value="<?=$wednesday_fetch['room'];?>">
                                <input type="hidden" name="wednesday_instructor_id[]" value="<?=$wednesday_fetch['instructor_id'];?>">
                                <input type="hidden" name="wednesday_done_status[]" value="<?=$wednesday_fetch['done_status'];?>">

                    <?php
                            }   
                        }
                    ?>

                    <?php
                        foreach($thursday_id as $thursday_id){
                            $thursday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $thursday_id ."'");
                            if(mysqli_num_rows($thursday_sql) > 0){
                                $thursday_fetch = mysqli_fetch_assoc($thursday_sql);
                                // echo "<pre>";
                                //     print_r($thursday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$thursday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="thursday_subject_code[]" value="<?=$thursday_fetch['subject_code'];?>">
                                <input type="hidden" name="thursday_year_semester_id[]" value="<?=$thursday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="thursday_year_level[]" value="<?=$thursday_fetch['year_level'];?>">
                                <input type="hidden" name="thursday_start_time[]" value="<?=$thursday_fetch['start_time'];?>">
                                <input type="hidden" name="thursday_end_time[]" value="<?=$thursday_fetch['end_time'];?>">
                                <input type="hidden" name="thursday_at[]" value="<?=$thursday_fetch['at'];?>">
                                <input type="hidden" name="thursday_day[]" value="<?=$thursday_fetch['day'];?>">
                                <input type="hidden" name="thursday_room[]" value="<?=$thursday_fetch['room'];?>">
                                <input type="hidden" name="thursday_instructor_id[]" value="<?=$thursday_fetch['instructor_id'];?>">
                                <input type="hidden" name="thursday_done_status[]" value="<?=$thursday_fetch['done_status'];?>">

                    <?php
                            }   
                        }
                    ?>



                    <?php
                        foreach($friday_id as $friday_id){
                            $friday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $friday_id ."'");
                            if(mysqli_num_rows($friday_sql) > 0){
                                $friday_fetch = mysqli_fetch_assoc($friday_sql);
                                // echo "<pre>";
                                //     print_r($friday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$friday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="friday_subject_code[]" value="<?=$friday_fetch['subject_code'];?>">
                                <input type="hidden" name="friday_year_semester_id[]" value="<?=$friday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="friday_year_level[]" value="<?=$friday_fetch['year_level'];?>">
                                <input type="hidden" name="friday_start_time[]" value="<?=$friday_fetch['start_time'];?>">
                                <input type="hidden" name="friday_end_time[]" value="<?=$friday_fetch['end_time'];?>">
                                <input type="hidden" name="friday_at[]" value="<?=$friday_fetch['at'];?>">
                                <input type="hidden" name="friday_day[]" value="<?=$friday_fetch['day'];?>">
                                <input type="hidden" name="friday_room[]" value="<?=$friday_fetch['room'];?>">
                                <input type="hidden" name="friday_instructor_id[]" value="<?=$friday_fetch['instructor_id'];?>">
                                <input type="hidden" name="friday_done_status[]" value="<?=$friday_fetch['done_status'];?>">
                    <?php
                            }   
                        }
                    ?>


                    <?php
                        foreach($saturday_id as $saturday_id){
                            $saturday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $saturday_id ."'");
                            if(mysqli_num_rows($saturday_sql) > 0){
                                $saturday_fetch = mysqli_fetch_assoc($saturday_sql);
                                // echo "<pre>";
                                //     print_r($saturday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$saturday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="saturday_subject_code[]" value="<?=$saturday_fetch['subject_code'];?>">
                                <input type="hidden" name="saturday_year_semester_id[]" value="<?=$saturday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="saturday_year_level[]" value="<?=$saturday_fetch['year_level'];?>">
                                <input type="hidden" name="saturday_start_time[]" value="<?=$saturday_fetch['start_time'];?>">
                                <input type="hidden" name="saturday_end_time[]" value="<?=$saturday_fetch['end_time'];?>">
                                <input type="hidden" name="saturday_at[]" value="<?=$saturday_fetch['at'];?>">
                                <input type="hidden" name="saturday_day[]" value="<?=$saturday_fetch['day'];?>">
                                <input type="hidden" name="saturday_room[]" value="<?=$saturday_fetch['room'];?>">
                                <input type="hidden" name="saturday_instructor_id[]" value="<?=$saturday_fetch['instructor_id'];?>">
                                <input type="hidden" name="saturday_done_status[]" value="<?=$saturday_fetch['done_status'];?>">
                    <?php
                            }   
                        }
                    ?>

                    

                    <?php
                        foreach($sunday_id as $sunday_id){
                            $sunday_sql = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id = '". $sunday_id ."'");
                            if(mysqli_num_rows($sunday_sql) > 0){
                                $sunday_fetch = mysqli_fetch_assoc($sunday_sql);
                                // echo "<pre>";
                                //     print_r($sunday_fetch);
                                // echo "</pre>";

                    ?>
                                <!-- <input type="text" name="class_id" value="<=$sunday_fetch['class_id'];?>"> -->
                                <input type="hidden" name="sunday_subject_code[]" value="<?=$sunday_fetch['subject_code'];?>">
                                <input type="hidden" name="sunday_year_semester_id[]" value="<?=$sunday_fetch['year_semester_id'];?>">
                                <input type="hidden" name="sunday_year_level[]" value="<?=$sunday_fetch['year_level'];?>">
                                <input type="hidden" name="sunday_start_time[]" value="<?=$sunday_fetch['start_time'];?>">
                                <input type="hidden" name="sunday_end_time[]" value="<?=$sunday_fetch['end_time'];?>">
                                <input type="hidden" name="sunday_at[]" value="<?=$sunday_fetch['at'];?>">
                                <input type="hidden" name="sunday_day[]" value="<?=$sunday_fetch['day'];?>">
                                <input type="hidden" name="sunday_room[]" value="<?=$sunday_fetch['room'];?>">
                                <input type="hidden" name="sunday_instructor_id[]" value="<?=$sunday_fetch['instructor_id'];?>">
                                <input type="hidden" name="sunday_done_status[]" value="<?=$sunday_fetch['done_status'];?>">
                    <?php
                            }   
                        }
                    ?>


                    <label for="academy_year">1. Academy year <span class="text-danger">*</span></label>
                    <select name="academy_year_duplicate" id="academy_year_duplicate" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1">
                        <option disabled selected>Select academy year</option>
                        <?php
                            $academy_year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                            if(mysqli_num_rows($academy_year) > 0){
                                while($academy_year_data = mysqli_fetch_assoc($academy_year)){
                    ?>
                        <option value="<?=$academy_year_data['year'];?>">Year: <?=$academy_year_data['year'];?></option>
                    <?php
                                }
                            }

                        ?>
                    </select>


                    <label for="semester">2. Semester <span class="text-danger">*</span></label>
                    <select name="semester_duplicate" id="semester_duplicate">
                        <option disabled selected>Select academy year first.</option>

                        <?php
                            $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study = '". $year_now ."'");
                            if(mysqli_num_rows($semester) > 0){
                                while($semester_data = mysqli_fetch_assoc($semester)){
                        ?>
                            <!-- <option value="<=$semester_data['year_semester_id'];?>">Semester <=$semester_data['year_semester_id'];?></option> -->
                            <!-- <option class="<?php echo ($semester_data['status'] == '0')? 'text-primary' : '';?>" value="<?=$semester_data['year_semester_id'];?>">- Semester: <?=$semester_data['semester'];?>  , Year: <?=$semester_data['year_of_study'];?> <?php echo ($semester_data['status'] == '0')? ' (Finished) ' : '';?></option> -->

                        <?php
                                }
                            }

                        ?>
                    </select>

                    <label for="class">3. Class <span class="text-danger">*</span></label>
                    <!-- <select name="class_duplicate" id="class_selected" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1"> -->
                    <select name="class_duplicate" id="class_selected">
                        <option disabled selected>Select semester first.</option>
                        <?php
                            // $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study = '". $year_now ."' AND major_id = '". $major_id ."'");
                            $class = mysqli_query($conn, "SELECT * FROM class WHERE major_id = '". $major_id ."'");
                            if(mysqli_num_rows($class) > 0){
                                while($class_data = mysqli_fetch_assoc($class)){
                                    

                                    
                        ?>
                            <!-- <option <?php
                                if(isset($_POST['class']) && $_POST['class'] == $class_data['class_id']){ echo 'disabled';}
                            ?>  value="<?=$class_data['class_id'];?>">Class <?=$class_data['class_code'];?></option> -->
                        <?php
                                    
                                }
                            }

                        ?>
                    </select>

                    <div id="class_information">
                        
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" name="duplicate_schedule" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <!-- auto complete with select option  -->

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

                // console.log('Hi');
            });


            $('#class_selected').on('change', function(){
                var class_selected = $(this).val();
                if(class_selected){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'class_selected='+class_selected,
                        success:function(html){
                            $('#class_information').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    
                }            
            });

            $('#academy_year_duplicate').on('change', function(){
                var academy_year_duplicate = $(this).val();
                if(academy_year_duplicate){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'academy_year_schedule='+academy_year_duplicate,
                        success:function(html){
                            $('#semester_duplicate').html(html);
                            // $('#semester_schedule').html('<option value="">Hi there.</option>'); 
                        }
                    }); 
                }
            });

            $('#semester_duplicate').on('change', function(){
                var semester_duplicate = $(this).val();
                if(semester_duplicate){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'semester_duplicate='+semester_duplicate,
                        success:function(html){
                            $('#class_selected').html(html);
                        }
                    }); 
                }
            });
        });
    </script>


</body>
</html>