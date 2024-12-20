
<?php
    #DB connection

    require_once('ims-db-connection.php');
    include_once('login-check.php');

    if(!empty($_GET['major']) || !empty($_GET['class'])){
        $class_id = $_GET['class'];
        $major_id = $_GET['major'];

        $major = mysqli_query($conn, "SELECT * FROM major 
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE major.major_id ='". $major_id ."'");

        if(mysqli_num_rows($major) > 0){
            $major_data = mysqli_fetch_assoc($major);
        }else{
            header("Location:".SITEURL);
            exit;
        }
    }else{
        header("Location:".SITEURL);
        exit;
    }

    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study = '". date("Y") . "' AND status = '1'");
    if(mysqli_num_rows($semester) > 0){
        $result = mysqli_fetch_assoc($semester);
        $semester_id = $result['year_semester_id'];
    }else{
        $semester_id = '';
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

        // $class_qry = mysqli_query($conn, "SELECT * FROM class ")
        $class_qry = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."' AND class_id = '". $class_id ."'");
        $class_result = mysqli_fetch_assoc($class_qry);


    ?>

        <div id="main__content">
            <div class="top__content_title">
                    <h5 class="super__title">Class detail <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Class detail</p>
            </div>
            <div class="my-3">
                <a href="<?=SITEURL;?>class-list.php?dep=<?=$major_data['department_id'];?>&major=<?=$major_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>

            <div class="all__teacher">
                <div class="btn__container mt-1">
                    <div class="left">
                        <a href="<?=SITEURL;?>class.php?class=<?=$class_id;?>&major=<?=$major_id;?>&list=<?=true;?>" class="<?php echo((empty($_GET['list']) || isset($_GET['list'])) && ((empty($_GET['schedule'])))) ? 'active' : 'no-active'; ?>"><i class="fa fa-list" aria-hidden="true"></i>Student list</a>
                        <a href="<?=SITEURL;?>class.php?class=<?=$class_id;?>&major=<?=$major_id;?>&schedule=<?=true;?>" class="<?php echo(isset($_GET['schedule'])) ? 'active' : 'no-active'; ?>"><i class="fa fa-calendar" aria-hidden="true"></i>Schedule</a>
                    </div>
                    <?php
                        if(empty($_GET['schedule'])){
                    ?>
                    <div class="right">
                        <div class="border-btn">
                            <a class="excel" id="excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Export</a>
                            <a class="pdf" id="pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Export</a>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    
                </div>
                <div id="classDetail__info" class="mt-4">
                    <p class="">Class code: <b class="text-primary"><?=$class_result['class_code']?></b></p>
                    <p class="">Department: <b><?=ucwords($major_data['department']);?></b> - Major: <b><?=ucwords($major_data['major']);?></b></p>
                    <p class="">Degree: <b><?=$class_result['level_study']?></b> - Year level: <b><?=$class_result['year_level']?></b></p>
                    <p class="d-none" style="display: none;" id="class_id"><?= $class_id;?></p>
                    <p class="d-none" style="display: none;" id="major_id"><?= $major_id;?></p>
                    <p class="mb-2">Total student: 
                        <b>
                        <?php
                            $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."'");
                            if(mysqli_num_rows($count_qry) > 0){
                                echo mysqli_num_rows($count_qry);
                            }else{
                                echo '0';
                            }
                        ?>
                        </b>
                        <span class="ps-2">Female student: <b>
                            <?php
                                mysqli_free_result($count_qry);

                                $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' AND gender = 'female'");
                                if(mysqli_num_rows($count_qry) > 0){
                                    echo mysqli_num_rows($count_qry);
                                }else{
                                    echo '0';
                                }
                            ?>
                        </b></span>
                    </p>
                </div>
                <!-- <hr> -->
                
                
                <div id="class_detail" class="mt-2">
                    <?php
                        if(!empty($_GET['list'])){
                    ?>
                    <!-- <p><i class="fa fa-list" aria-hidden="true"></i>Student list</p>
                    <hr> -->
                    
                    
                    <div id="student__list"  class="mt-3">
                        <table  id="none_table" class="d-none">
                            <tr>
                                <td>Export student list in class code: <?=$class_result['class_code']?></td>
                            </tr>
                            <tr>
                                <td>Department: <?=ucwords($major_data['department']);?></td>
                            </tr>
                            <tr>
                                <td>Major: <?=ucwords($major_data['major']);?></td>
                            </tr>
                            <tr>
                                <td>Degree: <?=$class_result['level_study']?> - Year level: <?=$class_result['year_level']?></td>
                            </tr>
                            <tr>
                                <td>Total student: 
                                    <?php
                                        $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."'");
                                        if(mysqli_num_rows($count_qry) > 0){
                                            echo mysqli_num_rows($count_qry);
                                        }else{
                                            echo '0';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Female student: 
                                    <?php
                                        mysqli_free_result($count_qry);

                                        $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' AND gender = 'female'");
                                        if(mysqli_num_rows($count_qry) > 0){
                                            echo mysqli_num_rows($count_qry);
                                        }else{
                                            echo '0';
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5px !important;">No.</th>
                                    <th style="width: 5px !important;">Student ID</th>
                                    <th>Fullname <sup>KH</sup></th>
                                    <th>Fullname <sup>EN</sup></th>
                                    <th style="width: 10px;">Gender</th>
                                    <th>Date of birth</th>
                                    <th>Phone number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    mysqli_free_result($count_qry);
                                    $i = 1;
                                    $student_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' ORDER BY student_id ASC");
                                    while($student_fetch = mysqli_fetch_assoc($student_qry)){
                                ?>
                                    <tr>
                                        <td class="text-center" style="width: 5px !important;"><?=$i++;?></td>
                                        <td style="width: 5px;"><?=$student_fetch['student_id']?></td>
                                        <td><?=$student_fetch['fn_khmer'] . " " . $student_fetch['ln_khmer'];?></td>
                                        <td class="text-uppercase"><?=$student_fetch['firstname'] . " " . $student_fetch['lastname'];?></td>
                                        <td style="width: 10px;"><?=ucfirst($student_fetch['gender']);?></td>
                                        <td><?php
                                            if($student_fetch['birth_date'] == '0000-00-00'){

                                            }else{
                                                $birth_date = date_create($student_fetch['birth_date']);
                                                echo date_format($birth_date, 'd-M-Y');
                                            }
                                        ?></td>
                                        <td><?=$student_fetch['phone_number']?></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                        }elseif(!empty($_GET['schedule'])){
                    ?>
                    <p><i class="fa fa-calendar" aria-hidden="true"></i>Schedule</p>
                    <hr>
                    <div id="schedule">
                        <div class="filter">
                            <div class="item"><i class="fa fa-filter" aria-hidden="true"></i>Filter: </div>
                            <div class="item">
                                <select name="" id="academy_year_filter" required class="selectpicker" data-live-search="true">
                                    <option disabled selected>Academy year</option>
                                    <?php
                                        $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        while($year_result = mysqli_fetch_assoc($year)){
                                    ?>
                                        <option <?php echo($year_result['year'] == $year_now)? 'selected' : ''; ?> value="<?=$year_result['year'];?>">Year <?=$year_result['year'];?></option>                                       
                                    <?php
                                        }
                                        mysqli_free_result($year);
                                    ?>
                                </select>
                                
                            </div>
                            <div class="item">
                                <select name="" id="semester_filter">
                                    <option disabled selected>Semester</option>
                                    <?php
                                        $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study = '". $year_now ."'");
                                        while($semester_result = mysqli_fetch_assoc($semester)){
                                    ?>
                                        <option value="<?=$semester_result['year_semester_id'];?>">Semester <?=$semester_result['semester'];?></option>                                        
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="schedule__content">
                        
                            <!-- Monday  -->
                            <div class="schedule__item">
                                <p class="day">1. Monday</p>

                                <?php
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."' 
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Monday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                        ?>
                                
                                        <div class="d-grid" >
                                            <div class="item">
                                                <?=$schedule_result['subject_code'];?>

                                                <?php
                                                    $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                    $course_data = $course -> fetch_assoc();

                                                    echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                    mysqli_free_result($course);
                                                ?>
                                                
                                            </div>
                                            <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                            <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                            <div class="item"><?=$schedule_result['room'];?></div>
                                            <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                        </div>

                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>
                                                
                                
                            </div>



                            <!-- Tuesday  -->
                            <div class="schedule__item">
                                <p class="day">2. Tuesday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Tuesday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>


                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>
                                                
                                
                            </div>


                            <!-- Wednesday  -->
                            <div class="schedule__item">
                                <p class="day">3. Wednesday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Wednesday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>


                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>
                                                
                                
                            </div>



                            <!-- Thursday  -->
                            <div class="schedule__item">
                                <p class="day">4. Thursday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Thursday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>


                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>
                                                
                                
                            </div>



                            <!-- Friday  -->
                            <div class="schedule__item">
                                <p class="day">5. Friday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Friday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>
                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>

                            </div>
                            


                            <!-- Saturday  -->
                            <div class="schedule__item">
                                <p class="day">6. Saturday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Saturday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>
                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>

                            </div>


                            <!-- Sunday  -->
                            <div class="schedule__item">
                                <p class="day">7. Sunday</p>

                                <?php
                                    mysqli_free_result($schedule_run);
                                    $schedule_sql = "SELECT * FROM schedule_study 
                                                    INNER JOIN teacher_info ON 
                                                    schedule_study.instructor_id = teacher_info.teacher_id 
                                                    WHERE year_semester_id = '". $semester_id."'
                                                    AND  class_id = '".$class_id."'
                                                    AND schedule_study.done_status = '1'
                                                    AND day = 'Sunday' ORDER BY at ASC";
                                    // AND year_semester_id = '". $semester ."' AND level_id = '" . $year_of_study ."' AND day = 'Monday' AND at = 'AM' ";
                                    $schedule_run = mysqli_query($conn, $schedule_sql);
                                    if(mysqli_num_rows($schedule_run) > 0){
                                        while($schedule_result = mysqli_fetch_assoc($schedule_run)){
                                ?>
                                
                                    <div class="d-grid">
                                        <div class="item">
                                            <?=$schedule_result['subject_code'];?>

                                            <?php
                                                $course = mysqli_query($conn, "SELECT * FROM course WHERE subject_code ='". $schedule_result['subject_code'] ."'");
                                                $course_data = $course -> fetch_assoc();

                                                echo $course_data['subject_name'] . " - " . $course_data['credit']. "(" .  $course_data['theory'] .".". $course_data['execute'] .".". $course_data['apply'] . ")";
                                                mysqli_free_result($course);
                                            ?>
                                            
                                        </div>
                                        <div class="text-center item"><?=$schedule_result['start_time'] . " - " . $schedule_result['end_time'];?></div>
                                        <div class="text-center item"><?=$schedule_result['fn_khmer']. " " .$schedule_result['ln_khmer'];?></div>
                                        <div class="item"><?=$schedule_result['room'];?></div>
                                        <!-- <div class="text-center item"><a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>&sch=<?=$schedule_result['schedule_id'];?>">Edit</a></div> -->
                                    </div>
                                <?php
                                        }
                                    }else{
                                
                                        echo '<p class="bg-0 px-2">No schedule record.</p>';
                               
                                    }
                                ?>

                            </div>
                            
                        </div>                     
                    </div>
                    <?php
                        }else{
                    ?>
                    <!-- <p><i class="fa fa-list" aria-hidden="true"></i>Student list</p>
                    <hr>
                    <p class="mb-2">Total student: 
                        <b>

                            $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."'");
                            if(mysqli_num_rows($count_qry) > 0){
                                echo mysqli_num_rows($count_qry);
                            }else{
                                echo '0';
                            }
                        ?>
                        </b>
                        <span class="ps-2">Female student: <b>
                            <
                                mysqli_free_result($count_qry);

                                $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' AND gender = 'female'");
                                if(mysqli_num_rows($count_qry) > 0){
                                    echo mysqli_num_rows($count_qry);
                                }else{
                                    echo '0';
                                }
                            ?>
                        </b></span>
                    </p> -->

                    

                    <div id="student__list" class="mt-3">
                        <table class="d-none" id="none_table">
                            <tr>
                                <td>Export student list in class code: <?=$class_result['class_code']?></td>
                            </tr>
                            <tr>
                                <td>Department: <?=ucwords($major_data['department']);?></td>
                            </tr>
                            <tr>
                                <td>Major: <?=ucwords($major_data['major']);?></td>
                            </tr>
                            <tr>
                                <td>Degree: <?=$class_result['level_study']?> - Year level: <?=$class_result['year_level']?></td>
                            </tr>
                            <tr>
                                <td>Total student: 
                                    <?php
                                        $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."'");
                                        if(mysqli_num_rows($count_qry) > 0){
                                            echo mysqli_num_rows($count_qry);
                                        }else{
                                            echo '0';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Female student: 
                                    <?php
                                        mysqli_free_result($count_qry);

                                        $count_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' AND gender = 'female'");
                                        if(mysqli_num_rows($count_qry) > 0){
                                            echo mysqli_num_rows($count_qry);
                                        }else{
                                            echo '0';
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <th class="table-width-50 text-center">No.</th>
                                    <th>Student ID</th>
                                    <th>Fullname <sup>KH</sup></th>
                                    <th>Fullname <sup>EN</sup></th>
                                    <th>Gender</th>
                                    <th>Date of birth</th>
                                    <th>Phone number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $student_qry = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id = '". $class_id ."' ORDER BY student_id ASC");
                                    while($student_fetch = mysqli_fetch_assoc($student_qry)){
                                ?>
                                    <tr>
                                        <td class="table-width-50 text-center"><?=$i++;?></td>
                                        <td><?=$student_fetch['student_id']?></td>
                                        <td><?=$student_fetch['fn_khmer'] . " " . $student_fetch['ln_khmer'];?></td>
                                        <td class="text-uppercase"><?=$student_fetch['firstname'] . " " . $student_fetch['lastname'];?></td>
                                        <td><?=ucfirst($student_fetch['gender']);?></td>
                                        <td>
                                            <?php
                                                if($student_fetch['birth_date'] == '0000-00-00'){

                                                }else{
                                                    $birth_date = date_create($student_fetch['birth_date']);
                                                    echo date_format($birth_date, 'd-M-Y');
                                                }
                                            ?>
                                        </td>
                                        <td><?=$student_fetch['phone_number']?></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
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

            $('#academy_year_filter').on('change', function(){
                var academy_year_filter = $(this).val();
                // var major_id = $('#major_id').html();
                if(academy_year_filter){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'academy_year_filter=' + academy_year_filter,
                        success:function(html){
                            $('#semester_filter').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });

            $('#semester_filter').on('change', function(){
                var semester_filter = $(this).val();
                var class_id = $('#class_id').html();
                var major_id = $('#major_id').html();
                if(semester_filter){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:{semester_filter: semester_filter, class_filter: class_id, major_id: major_id},
                        success:function(html){
                            $('#schedule__content').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });

            // excel export 
            $("#excel_btn").click(function () {
                $("#student__list").table2excel({
                    filename: "export-student-list.xls"
                });
            });           


            // pdf export 
            // $('#pdf_btn').click(function() {
            //     $('#none_table').addClass('d-block');

            //     const { jsPDF } = window.jspdf;

            //     html2canvas(document.querySelector("#student__list")).then(canvas => {
            //         const imgData = canvas.toDataURL('image/png');
            //         const pdf = new jsPDF();
            //         const imgWidth = 190; // Width of the image in the PDF
            //         // const pageHeight = pdf.internal.pageSize.height;
            //         const pageHeight = 190;
            //         const imgHeight = (canvas.height * imgWidth) / canvas.width;
            //         let heightLeft = imgHeight;

            //         let position = 0;

            //         pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            //         heightLeft -= pageHeight;

            //         while (heightLeft >= 0) {
            //             position = heightLeft - imgHeight;
            //             pdf.addPage();
            //             pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            //             heightLeft -= pageHeight;
            //         }
            //         pdf.save('studentListInClass.pdf');
            //     });

               
            // });
            // // location.reload();
            // $('#none_table').addClass('d-none');


            $('#pdf_btn').on('click', function() {
                    $('#none_table').addClass('d-block');
                    const { jsPDF } = window.jspdf;


                    // Create a new jsPDF instance
                    const doc = new jsPDF();

                    // Use html2canvas to take a snapshot of the table
                    html2canvas(document.querySelector("#student__list")).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const pdfWidth = doc.internal.pageSize.getWidth();
                        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                        // Add margins (10 units for example)
                        const marginX = 10;
                        const marginY = 10;

                        // Add the image to the PDF with margins
                        doc.addImage(imgData, 'PNG', marginX, marginY, pdfWidth - 2 * marginX, pdfHeight - 2 * marginY);
                        const pdf_save = doc.save('studentListInClass.pdf');
                        if(pdf_save == true){
                            $('#none_table').addClass('d-none');
                            location.reload();
                        }
                        
                        // if(doc.save('studentListInClass.pdf') == true){
                        //     $('#none_table').addClass('d-none');
                        //     // location.reload();
                        // }
                    });
            });

            let timer;
            let timeLeft = 40; // Set the timer countdown (in seconds)

            $('#pdf_btn').click(function() {
                clearInterval(timer); // Clear any existing timer
                timeLeft = 40; // Reset timer
                $('#timer').text(timeLeft); // Display the initial time

                timer = setInterval(function() {
                    timeLeft--;
                    $('#timer').text(timeLeft);
                    
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        // alert("Time's up!");
                        // $('#none_table').addClass('d-none');
                        location.reload();

                    }
                }, 5);
            });
        });
    </script>

</body>
</html>