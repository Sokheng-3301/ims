<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once("function.php");

    
    $date = date('Y-m-d');
    $this_year = date('Y');
    $teacher_id = '';
    if(!empty($_SESSION['LOGIN_USERID'])){
        $teacher_id = $_SESSION['LOGIN_USERID'];
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
                <h5 class="super__title">Your schedule <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Your schedule</p>
            </div>
            <!-- <div class="my-3">
                <a href="<?=SITEURL;?>schedule.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
             -->
            
           

            <div class="all__teacher schedule">
                <p>Filter to show your schedule</p>

                <form action="" method="post">
                    <!-- <input type="hidden" name="major" value="<=$major_id;?>"> -->
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
                                        if(isset($_POST['filter_schedule'])){
                                            if($_POST['year_of_study'] == $result['year'] ) echo "selected";
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
                                    if(isset($_POST['filter_schedule'])){
                                        $this_year = mysqli_real_escape_string($conn, $_POST['year_of_study']);
                                    }else{
                                        $this_year = $this_year;
                                    }

                                    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $this_year ."'");
                                    while($result = mysqli_fetch_assoc($semester)){
                                        
                                ?>            
                                    <option value="<?=$result['year_semester_id'];?>"
                                    <?php
                                    if(isset($_POST['filter_schedule'])){
                                        if(isset($_POST['semester']) && $_POST['semester'] == $result['year_semester_id']){
                                          echo "selected";
                                       }    
                                    }
                                    ?>>ឆមាសទី <?=$result['semester'];?></option>
                                <?php
                                    }
                                    mysqli_free_result($semester);
                                ?>
                                
                            </select>
                        </p>

                        <!-- <p class="title_filter">
                            <select name="class" id="" required>
                                <option disabled selected>ជ្រើសរើសថ្នាក់</option>
                                <php
                                    $class = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."'");
                                    while($result = mysqli_fetch_assoc($class)){
                                >
                                    <option value="<=$result['class_id'];>"
                                    <php
                                    if(filter()){
                                        if($_POST['class'] == $result['class_id']){
                                          echo "selected";
                                       }    
                                    }
                                    >>ថ្នាក់ <=$result['class_code'];></option>

                                <php
                                    }
                                    mysqli_free_result($class);
                                >
                            </select>
                        </p>
                         -->
                        <button class="search-schedule" name="filter_schedule" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>            
                    </div>
                </form>
                <div class="schedule__manage">

                <!-- start schedule  -->
                <?php
                    if(isset($_POST['filter_schedule'])){
                        if(empty($_POST['semester'])){
                            echo '<p class = "text-danger">សូមធ្វើការជ្រើសរើសនូវជម្រើសទាំងអស់ដើម្បីបង្ហាញកាលវិភាគ។</p>';
                        }else{

                            // $major = mysqli_real_escape_string($conn, $_POST['major']);
                            // $year_of_study = mysqli_real_escape_string($conn, $_POST['year_of_study']);
                            $semester = mysqli_real_escape_string($conn, $_POST['semester']);
                            // $class = mysqli_real_escape_string($conn, $_POST['class']);

                            $semesterQry = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id ='". $semester ."'");
                            $semesterFetch = mysqli_fetch_assoc($semesterQry);
                ?>
                <p><i class="fa fa-calendar" aria-hidden="true"></i> <b>Your schedule</b> <br> Semester: <b><?=$semesterFetch['semester'];?></b> - Academy year: <b><?= $this_year;?></b></p>
       

                <!-- MONDAY QUERY START  -->
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE year_semester_id = '". $semester ."' 
                                        AND day = 'Monday'
                                        AND schedule_study.done_status = '1'
                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Monday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                    <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                </div>   
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>                                         
                <!-- MONDAY QUERY END  -->
                        



                <!-- TUESEDAY QUERY START  -->
 
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Tuesday' 
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Tuesday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                    <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                </div> 
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>            
                <!-- TUESEDAY QUERY END  -->




                <!-- WEDNESDAY QUERY START  -->
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Wednesday' 
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Wednesday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                    <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                </div>      
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>

                    
                    <?php
                        }
                    ?>       

                <!-- WEDNESDAY QUERY END  -->






                <!-- THURSDAY QUERY START  -->
                
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Thursday'
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Thursday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                </div>   
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>       
                <!-- THURSDAY QUERY END  -->






                <!-- FRIDAY QUERY START  -->
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Friday' 
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Friday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                </div>   
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>       
                <!-- FRIDAY QUERY END  -->




                <!-- SATURDAY QUERY START  -->
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Saturday'
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Saturday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                </div>  
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>       
                <!-- SATURDAY QUERY END  -->



                <!-- SUNDAY QUERY START  -->
                    <?php
                        $monday_sql = "SELECT * FROM schedule_study 
                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                    WHERE year_semester_id = '". $semester ."' 
                                    AND day = 'Sunday' 
                                    AND schedule_study.done_status = '1'
                                    AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                        $monday_run = mysqli_query($conn, $monday_sql);

                        if(mysqli_num_rows($monday_run) > 0){
                    ?>
                    <div class="schedule__container mb-2">
                        <div class="content">

                            <p class="fw-bold fs-5 day__title">Sunday</p>
                            <!-- select schedule where day = monday and at morning  -->
                            
                            <div class="section">
                                <!-- <p class="fw-bold text-danger">Morning</p> -->
                            <?php
                                while($result = mysqli_fetch_assoc($monday_run)){    
                                    
                                    // echo "<pre>";
                                    // print_r($result);
                                    // echo "</pre>";
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
                                    <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                    <p><?=$result['room'];?></p>
                                    <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                </div>  
                                
                                <!-- Modal -->
                                <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="class_information">
                                                    <div class="class_info_content border-0">
                                                        <div class="grid">
                                                            <?php
                                                                $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                                                        INNER JOIN department ON major.department_id = department.department_id
                                                                                                        WHERE class.class_id = '".$result['class_id'] ."'");
                                                                $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                            ?>
                                                            <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                            <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                            <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                            <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                            <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                            <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                        }
                    ?>       
                <!-- SUNDAY QUERY END  -->


                <?php
                        }
                    }else{
                        // current schedule start  


                            $subjectQry = "SELECT * FROM  year_of_study
                                            WHERE year_of_study.finish_semester > '" . $date ."'
                                            AND year_of_study.year_of_study = '" . $this_year ."'";

                            $subject = mysqli_query($conn, $subjectQry);
                            if(mysqli_num_rows($subject) > 0){
                                $result = mysqli_fetch_assoc($subject);
                                $semester = $result['year_semester_id'];

                                ?>
                                    <p><i class="fa fa-calendar" aria-hidden="true"></i> <b>Your current schedule</b> <br> Semester: <b><?=$result['semester'];?></b> - Academy year: <b><?=$result['year_of_study'];?></b></p>

                                <!-- // start schedule by day here. -->


                                                        
                                    <!-- MONDAY QUERY START  -->
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                            INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                            INNER JOIN class ON schedule_study.class_id = class.class_id
                                                            WHERE year_semester_id = '". $semester ."' 
                                                            AND day = 'Monday'
                                                            AND schedule_study.done_status = '1'
                                                            AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Monday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                                        <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                                    </div>   
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>                                         
                                    <!-- MONDAY QUERY END  -->
                                            



                                    <!-- TUESEDAY QUERY START  -->
                    
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Tuesday' 
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Tuesday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                                        <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                                    </div> 
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>            
                                    <!-- TUESEDAY QUERY END  -->




                                    <!-- WEDNESDAY QUERY START  -->
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Wednesday' 
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Wednesday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>

                                                        <!-- <p><a href="<=SITEURL;?>add-schedule.php?q=<=$major_id;?>&sch=<=$result['schedule_id'];?>">Edit</a></p> -->
                                                    </div>      
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>

                                        
                                        <?php
                                            }
                                        ?>       

                                    <!-- WEDNESDAY QUERY END  -->






                                    <!-- THURSDAY QUERY START  -->
                                    
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Thursday'
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Thursday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                                    </div>   
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>       
                                    <!-- THURSDAY QUERY END  -->






                                    <!-- FRIDAY QUERY START  -->
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Friday' 
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Friday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>
                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                                    </div>   
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>       
                                    <!-- FRIDAY QUERY END  -->




                                    <!-- SATURDAY QUERY START  -->
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Saturday'
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Saturday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                                    </div>  
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>       
                                    <!-- SATURDAY QUERY END  -->



                                    <!-- SUNDAY QUERY START  -->
                                        <?php
                                            $monday_sql = "SELECT * FROM schedule_study 
                                                        INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id 
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE year_semester_id = '". $semester ."' 
                                                        AND day = 'Sunday' 
                                                        AND schedule_study.done_status = '1'
                                                        AND instructor_id ='". $teacher_id ."' ORDER BY at ASC";
                                            $monday_run = mysqli_query($conn, $monday_sql);

                                            if(mysqli_num_rows($monday_run) > 0){
                                        ?>
                                        <div class="schedule__container mb-2">
                                            <div class="content">

                                                <p class="fw-bold fs-5 day__title">Sunday</p>
                                                <!-- select schedule where day = monday and at morning  -->
                                                
                                                <div class="section">
                                                    <!-- <p class="fw-bold text-danger">Morning</p> -->
                                                <?php
                                                    while($result = mysqli_fetch_assoc($monday_run)){    
                                                        
                                                        // echo "<pre>";
                                                        // print_r($result);
                                                        // echo "</pre>";
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
                                                        <p><a type="button"  id="class_code" type="button" data-bs-toggle="modal" data-bs-target="#class_information_<?=$result['class_id'];?>">Class: <?=$result['class_code'];?></a></p>

                                                        <p><?=$result['room'];?></p>
                                                        <p style="width: 200px;"><a href="<?=SITEURL;?>student-list.php?subject=<?=$result['schedule_id'];?>">Detail</a></p>
                                                    </div>  
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="class_information_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-6" id="staticBackdropLabel"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="class_information">
                                                                        <div class="class_info_content border-0">
                                                                            <div class="grid">
                                                                                <?php
                                                                                    $class_info_qry = mysqli_query($conn, "SELECT * FROM class
                                                                                                                            INNER JOIN major ON class.major_id = major.major_id
                                                                                                                            INNER JOIN department ON major.department_id = department.department_id
                                                                                                                            WHERE class.class_id = '".$result['class_id'] ."'");
                                                                                    $class_fetch    = mysqli_fetch_assoc($class_info_qry);

                                                                                ?>
                                                                                <p>Class code</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['class_code'];?></p>
                                                                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['department'];?></p>
                                                                                <p>Major</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['major'];?></p>
                                                                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$class_fetch['level_study'];?></p>
                                                                                <p>Year level</p> <p>:</p> <p class="fw-bold">ឆ្នាំទី <?=$class_fetch['year_level'];?></p>
                                                                                <p>Start  Ac.year</p> <p>:</p> <p class="fw-bold">ឆ្នាំ​ <?=$class_fetch['year_of_study'];?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                                </div> 
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        ?>       
                                    <!-- SUNDAY QUERY END  -->



                                <!--// End schedule by day here. -->

                                <?php
                            }else{
                                echo '<p> <i class="fa fa-clock-o" aria-hidden="true"></i>Your current schedule show here.</p>
                                      <p class="text-danger mt-2">No current schedule applied.</p>';
                            }


                        // current schedule end 
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
            });
        });
    </script>


</body>
</html>