<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $back_page = '';
    if(!empty($_SERVER['HTTP_REFERER'])){
        $back_page = $_SERVER['HTTP_REFERER'];
    }else{
        $back_page = SITEURL."schedule.php";
    }


    // print_r($_SESSION);
    
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


    $year_of_study = mysqli_query($conn, "SELECT * FROM year");
    while($year_of_study_result = mysqli_fetch_assoc($year_of_study)){
        // echo $year_of_study_result['year']."<br>";
        if($year_of_study_result['year'] == date("Y")){
            $this_year = $year_of_study_result['year_id'];
        }
    }


    $information = '';
    $rt_class_id = '';
    $class_code = '';

    if(isset($_SESSION['RT_CLASS_CODE'])){
        $rt_class_id = $_SESSION['RT_CLASS_CODE'];
        $query = mysqli_query($conn, "SELECT * FROM class WHERE class_id ='". $rt_class_id ."'");
        if(mysqli_num_rows($query) > 0){
            $query_data = mysqli_fetch_assoc($query);

            $information = "Degree: ".$query_data['level_study'] . " / Year level: ".$query_data['year_level'];
            $class_code = $query_data['class_code'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <link rel="stylesheet" href="ims-assets/jQuery/chosen.min.css"> -->
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

        if(empty($_GET['sch'])){
    ?>

        <!-- ADD SCHEDULE FORM START HERE  -->

            <div id="main__content">
                <div class="top__content_title">
                    <h5 class="super__title">Add schedule <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Schedule</p>
                </div>
                <div class="my-3">
                    <a href="<?=SITEURL."view-class.php?dep=".$dep_id."&maj=". $major_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>

                <div class="all__teacher schedule">
                    <p class="fw-bold text-primary"><i class="fa fa-plus" aria-hidden="true"></i>Add schedule</p>        
                    <div class="grid_item">
                            <div class="">Class code</div> <div>:</div>
                            <div class=""><span class="fw-bold text-primary"><?=$department_result['class_code'];?> </span></div>


                            <div class="">Department</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['department'];?> </span></div>
                      
                        
                            <div class="">Major</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['major'];?> </span></div>
                    
                        
                            
                     
                        
                            <div class="">Degree</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['level_study'];?> </span> - Year: <span class="fw-bold"><?=$department_result['year_level'];?></div>
                    </div>

                    <div id="border__form">

                    
                        <!-- ADD FORM  -->
                        <form action="<?=SITEURL;?>schedule-action.php" method="post">
                            <?php
                                if(isset($_SESSION['CHECK_SCHEDULE'])){
                            ?>
                            <div id="message_schedule">
                                <p><i class="fa fa-exclamation" aria-hidden="true"></i><b class="pe-2">Note!</b> <?= $_SESSION['CHECK_SCHEDULE'];?></p>
                            </div>
                            <?php
                                }
                                unset($_SESSION['CHECK_SCHEDULE']);

                                if(isset($_SESSION['APPLY_DONE'])){
                            ?>
                            <div id="message_schedule_done">
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i><b class="pe-2">Note!</b> <?= $_SESSION['APPLY_DONE'];?></p>
                            </div>
                            <?php
                                }
                                unset($_SESSION['APPLY_DONE']);

                            ?>


                            <!-- <p class="mb-1 text-primary mb-2 fw-bold"><i class="fa fa-plus" aria-hidden="true"></i> Add Schedule form</p> -->
                            <div class="manage__form">
                                <div class="part">     

                                    <input type="hidden" name="dep" id="dep_id" value="<?=$dep_id;?>">    
                                    <input type="hidden" name="major" id="major_id" value="<?=$major_id;?>">    
                                    <input type="hidden" name="class" id="class_id" value="<?=$class_id;?>">


                                    <label for="semester">1. Apply to class <span class="text-danger"></span></label>
                                    <select disabled id="class_info" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                        <option disabled selected>Please select class</option>

                                        <?php
                                            // $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study ='". date('Y') . "' AND major_id ='". $major_id ."'");
                                            $i = 1;
                                            $class = mysqli_query($conn, "SELECT * FROM class 
                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                        WHERE class.class_id ='". $class_id ."'");
                                            while($result = mysqli_fetch_assoc($class)){
                                        ?>            
                                            <option 
                                                <?php
                                                    echo ($class_id == $result['class_id'])? 'selected':'';
                                                ?>
                                            value="<?=$result['class_id'];?>">Class: <?=$result['class_code'];?> - <span class="text-primary"><?=$result['major'];?></span></option>

                                        <?php
                                            }
                                            mysqli_free_result($class);
                                        ?>
                                    </select>       
                                    <!-- <label for="">Year level</label>     
                                    <div id="year_level">
                                        <input type="text" class="" value="<?=$information;?>" disabled>
                                    </div>           -->

                                    <label for="subject">2. Subject <span class="text-danger">*</span></label>                

                                    <select name="subject" id="subject" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                        <option disabled selected>Please select subject</option>
                                        
                                    <?php
                                        $i = 1;
                                        $subject = mysqli_query($conn, "SELECT * FROM course WHERE department_id='". $department_id ."'");
                                        if(mysqli_num_rows($subject) > 0){
                                        
                                        while($result = mysqli_fetch_assoc($subject)){
                                    ?>
                                        <!-- <option value="<=$result['subject_code'];?>"><=$i++.". ".$result['subject_name'];?></option> -->
                                        <option value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_code'].": ".$result['subject_name']. " - " .$result['credit'] ."(". $result['theory']. ".". $result['execute'].".". $result['apply'].")";?></option>

                                    <?php
                                            }
                                        }else{
                                            $i = 1;
                                            $subject = mysqli_query($conn, "SELECT * FROM course");    
                                            while($result = mysqli_fetch_assoc($subject)){
                                        ?>
                                            <option value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_code'].": ".$result['subject_name']. " - " .$result['credit'] ."(". $result['theory']. ".". $result['execute'].".". $result['apply'].")";?></option>

                                        <?php
                                            }
                                        }
                                        mysqli_free_result($subject);
                                    
                                    ?>                               
                                    </select>

                                    <!-- ---------------- subject end ---------------- -->

                                    <!-- study level should't show becuase year level below can identify student's study level  -->
                                    <label for="academy_year" style="margin-top: 4px;">3. Academy Year <span class="text-danger">*</span></label>
                                    <select name="academy_year" id="academy_year_schedule" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                        <option disabled selected>Please select academy year</option>

                                        <?php
                                            $i = 1;
                                            $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                            while($result = mysqli_fetch_assoc($year)){
                                        ?>            
                                            <option value="<?=$result['year'];?>"><?=$i++?>. Year: <?=$result['year'];?></option>
                                        <?php
                                            }
                                            mysqli_free_result($year);
                                        ?>
                                    </select>    


                                    <label for="semester"  style="margin-top: 10px;">4. Semester <span class="text-danger">*</span></label>
                                    <div>
                                        <select name="semester"  id="semester_schedule"   required>
                                            <option disabled selected>Select academy year first</option>

                                            
                                        </select>    
                                    </div>
                                
                                </div>


                                <div class="part"> 
                                    <label for="day" class="mt-0">5. Instructor <span class="text-danger">*</span></label>
                                    <select name="instructor" id="instructor" data-live-search="true"  class="selectpicker d-block w-100 mb-2 mt-1" required>
                                        <option disabled selected>Please select insctructor</option>
                                    <?php
                                        $i = 1;
                                        $instructor = mysqli_query($conn, "SELECT * FROM teacher_info");
                                        while($result = mysqli_fetch_assoc($instructor))
                                        {
                                    ?>
                                            <option value="<?=$result['teacher_id'];?>"><?=$i++. ". ".$result['fn_khmer'] . " " .$result['ln_khmer'];?></option>
                                    <?php
                                        }
                                    ?>                             
                                    </select>   
                                    <small class="d-block mb-0"><a href="<?=SITEURL;?>add-teacher.php" >Add new instructor.</a></small>
  
                                    <label for="day">6. Day <span class="text-danger">*</span></label>
                                    <select name="day" id="day" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                        <option disabled selected>Please select day</option>
                                    <?php
                                        $day_in_week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                        $i = 1;
                                        foreach($day_in_week as $day){
                                    ?>
                                        <option value="<?=$day;?>"><?= $i++. ". ". $day;?></option>
                                    <?php
                                        }
                                    ?>                             
                                    </select>     

                                    <div class="d-flex start_end_time" style="margin-top: 20px;">
                                        <div class="block">
                                            <label for="start_time">7. Start time <span class="text-danger">*</span></label>
                                            <input type="time" id="start_time" name="start_time" oninput="checkTime()" required>
                                        </div>
                                        <div class="block">
                                            <label for="end_time">8. End time <span class="text-danger">*</span></label>
                                            <input type="time" id="end_time" name="end_time" required>
                                        </div>
                                        
                                        <div class="block last">
                                            <input type="hidden" name="at" value="" id="at">
                                            <!-- <label for="">&nbsp</label>
                                            
                                            <select name="at" id="">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select> -->
                                        </div>
                                    </div>

                                    
                                    
                                

                                    <label for="room">9. Room <span class="text-danger">*</span></label>
                                    <!-- <input type="text" id="room" name="room" placeholder="Room..." required>    -->
                                    <select name="room" data-live-search="true"  class="selectpicker d-block w-100 mb-1 mt-1" required>
                                        <option disabled selected>Please select room</option>
                                        <?php
                                            $i = 1;
                                            $room = mysqli_query($conn, "SELECT * FROM room");
                                            while($result = mysqli_fetch_assoc($room))
                                            {
                                        ?>
                                                <option value="<?=$result['room'];?>"><?=$i++. ". ".$result['room'];?></option>
                                        <?php
                                            }
                                        ?>                             
                                    </select>       
                                    <p class="mt-1 text-danger text-end <?php if(isset($_SESSION['REQUIRED'])) echo $_SESSION['REQUIRED']; unset($_SESSION['REQUIRED']);?>"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Note!</b> <span>All fields are required.</span></p>                   
                                    <button type="submit" name="add_schedule" class="add__shcedule btn"><i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                
                                </div>
                            </div>
                            
                            
                        
                        </form> 

                        <!-- ---------------------- PREVIEW SCHEDULE start---------------------------  -->
                            <div id="preview__schedule">
                                <?php
                                    // RT = Return 
                                
                                        // $class_id = $_SESSION['RT_CLASS_CODE'];
                                        if(isset($_SESSION['RT_CLASS_CODE'])){
                                            $semester_id = $_SESSION['RT_CLASS_CODE'];
        
                                        // if(isset($class_id)){
                                            // -------------start-----------
                                                                    
                                            $query_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."'
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'");

                                            if(mysqli_num_rows($query_schedule) > 0){
                                                $schedule_result = mysqli_fetch_assoc($query_schedule);
                                ?>
                                    <div class="preview__schedule mt-4">
                                        <p class="mb-2"><i class="fa fa-list" aria-hidden="true"></i> Preview Schedule</p>
                                        <div class="bg-light rounded px-2 mb-2" style="width: fit-content;">
                                            <small>
                                                <span class="me-2">Class: <b><?=$schedule_result['class_code'];?></b></span> | 
                                                <!-- <span class="mx-2">Degree: <b><=$schedule_result['level_study'];?></b></span> | 
                                                <span class="mx-2">Year level: <b><=$schedule_result['year_level'];?></b></span> |  -->
                                                <span class="mx-2">Semester: <b><?=$schedule_result['semester'];?></b></span> | 
                                                <span class="mx-2">Academy year: <b><?=$schedule_result['year_of_study'];?></b></span> 

                                            </small>
                                        </div>

                                        <!-- ###################### 1 MONDAY start #################### -->

                                            <p class="text-white mb-2">1. Monday</p>
                                            <?php
                                                    $monday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'
                                                                                    AND schedule_study.day = 'Monday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($monday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($monday = mysqli_fetch_assoc($monday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$monday['subject_code'];?></td>
                                                                <td><?=$monday['subject_name'];?></td>
                                                                <td><?=$monday['credit']."(". $monday['theory'] .".". $monday['execute'] .".". $monday['apply'] .")";?></td>
                                                                <td><?=$monday['fn_khmer'] . " " .$monday['ln_khmer'];?></td>
                                                                <td><?=$monday['start_time'] . " - " .$monday['end_time'];?></td>
                                                                <td><?=$monday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$monday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$monday['schedule_id'];?>&q=<?=$monday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                                
                                        <!-- ###################### MONDAY stop #################### -->







                                        <!-- ###################### 2 TUESDAY start #################### -->

                                            <p class="text-white my-2">2. Tuesday</p>
                                            <?php
                                                    $tuesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'

                                                                                    AND schedule_study.day = 'Tuesday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($tuesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($tuesday = mysqli_fetch_assoc($tuesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$tuesday['subject_code'];?></td>
                                                                <td><?=$tuesday['subject_name'];?></td>
                                                                <td><?=$tuesday['credit']."(". $tuesday['theory'] .".". $tuesday['execute'] .".". $tuesday['apply'] .")";?></td>
                                                                <td><?=$tuesday['fn_khmer'] . " " .$tuesday['ln_khmer'];?></td>
                                                                <td><?=$tuesday['start_time'] . " - " .$tuesday['end_time'];?></td>
                                                                <td><?=$tuesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$tuesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$tuesday['schedule_id'];?>&q=<?=$tuesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                            
                                        <!-- ###################### TUESDAY stop #################### -->

                                                








                                        <!-- ###################### 3 WEDNESDAY start #################### -->
                                            <p class="text-white my-2">3. Wednesday</p>
                                            <?php
                                                    $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'

                                                                                    AND schedule_study.day = 'Wednesday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($wednesday = mysqli_fetch_assoc($wednesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$wednesday['subject_code'];?></td>
                                                                <td><?=$wednesday['subject_name'];?></td>
                                                                <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                                <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                                <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                                <td><?=$wednesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                        <!-- ###################### WEDNESDAY stop #################### -->





                                        <!-- ###################### 4 THURSDAY start #################### -->
                                            <p class="text-white my-2">4. Thursday</p>
                                            <?php
                                                    $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'

                                                                                    AND schedule_study.day = 'Thursday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($wednesday = mysqli_fetch_assoc($wednesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$wednesday['subject_code'];?></td>
                                                                <td><?=$wednesday['subject_name'];?></td>
                                                                <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                                <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                                <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                                <td><?=$wednesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                        <!-- ###################### THURSDAY stop #################### -->



                                        <!-- ###################### 5 FRIDAY start #################### -->
                                            <p class="text-white my-2">5. Friday</p>
                                            <?php
                                                    $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'

                                                                                    AND schedule_study.day = 'Friday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($wednesday = mysqli_fetch_assoc($wednesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$wednesday['subject_code'];?></td>
                                                                <td><?=$wednesday['subject_name'];?></td>
                                                                <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                                <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                                <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                                <td><?=$wednesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                        <!-- ###################### FRIDAY stop #################### -->

                                                

                                        <!-- ###################### 6 SATURDAY start #################### -->
                                            <p class="text-white my-2">6. Saturday</p>
                                            <?php
                                                    $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."' 

                                                                                    AND schedule_study.day = 'Saturday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($wednesday = mysqli_fetch_assoc($wednesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$wednesday['subject_code'];?></td>
                                                                <td><?=$wednesday['subject_name'];?></td>
                                                                <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                                <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                                <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                                <td><?=$wednesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                        <!-- ###################### SATURDAY stop #################### -->


                                        <!-- ###################### 7 SUNDAY start #################### -->
                                            <p class="text-white my-2">7. Sunday</p>
                                            <?php
                                                    $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    WHERE schedule_study.class_id ='". $class_code_default ."' 
                                                                                    AND schedule_study.year_semester_id = '". $semester_id ."'

                                                                                    AND schedule_study.day = 'Sunday'
                                                                                    ORDER BY at ASC");
                                                    if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                        // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                        // $major_id = '';
                                                        
                                            ?>
                                                    <div class="table_manage">

                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Subject code</th>
                                                                <th>Subject</th>
                                                                <th>Credit</th>
                                                                <th>Instructor</th>
                                                                <th>Start - Finish time</th>
                                                                <th>Room</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                            <?php
                                                        while($wednesday = mysqli_fetch_assoc($wednesday_schedule)){
                                                            
                                                        
                                            ?>
                                                            <tr>
                                                                <td><?=$wednesday['subject_code'];?></td>
                                                                <td><?=$wednesday['subject_name'];?></td>
                                                                <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                                <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                                <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                                <td><?=$wednesday['room'];?></td>
                                                                <td class="text-center">
                                                                    <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                    <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </td>
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
                                        <!-- ###################### SUNDAY stop #################### -->
                                        
                                        <a class="btn__addschedule btn" href="<?=SITEURL;?>schedule-action.php?semester=<?=$schedule_result['year_semester_id'];?>&class=<?=$schedule_result['class_id'];?>&q=<?=$major_id;?>"><i class="fa fa-check-circle" aria-hidden="true"></i>Done add</a>
                                    </div>
                                    
                                <?php
                                                
                                    }

                                        // -------------end-----------


                                    }
                                ?>
                            </div>



                        <!-- ---------------------- PREVIEW SCHEDULE end---------------------------  -->
                    </div>

                    <!-- Teacher schedule show start -->
                        <div id="teacher_information">
                            
                        </div>
                    <!-- Teacher schedule show end -->

                </div>
                
                
                <!-- footer  -->
                <?php include_once('ims-include/staff__footer.php');?>
            </div>

        <!-- ADD SCHEDULE FORM END HERE  -->

    <?php
        }else{
            #################################
            ## UPDATE SCHEDULE HERE 
            #################################
            $schedule_id = mysqli_real_escape_string($conn, $_GET['sch']);
            $schedule_sql = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                WHERE schedule_study.schedule_id = '". $schedule_id ."'");
            if(mysqli_num_rows($schedule_sql) > 0){

                $schedule_result = mysqli_fetch_assoc($schedule_sql);

    ?>

        <!-- // UPDATE SCHEDULE START FORM  -->

            <div id="main__content">
                <div class="top__content_title">
                    <h5 class="super__title">Update schedule <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Schedule</p>
                </div>
                <div class="my-3">
                    <a href="<?=SITEURL."view-class.php?dep=".$dep_id."&maj=". $major_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>

                <div class="all__teacher schedule">
                    <p><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update schedule for</p>        
                    <div class="grid_item">
                            <div class="">Department</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['department'];?> </span></div>
                      
                        
                            <div class="">Major</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['major'];?> </span></div>
                    
                        
                            <div class="">Class code</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['class_code'];?> </span></div>
                     
                        
                            <div class="">Degree</div> <div>:</div>
                            <div class=""><span class="fw-bold"><?=$department_result['level_study'];?> </span> Year: <span class="fw-bold"><?=$department_result['year_level'];?></div>
                    </div>
                    
                    <!-- ADD FORM  -->
                    <div id="border__form">


                        <form action="<?=SITEURL;?>schedule-action.php" method="post">
                            <?php
                                if(isset($_SESSION['CHECK_SCHEDULE'])){
                            ?>
                            <div id="message_schedule">
                                <p><i class="fa fa-exclamation" aria-hidden="true"></i><b class="pe-2">Note!</b> <?= $_SESSION['CHECK_SCHEDULE'];?></p>
                            </div>
                            <?php
                                }
                                unset($_SESSION['CHECK_SCHEDULE']);
                            ?>

                            <div class="manage__form">
                                <div class="part">     

                                    <input type="hidden" class="d-none" name="dep" id="dep_id" value="<?=$dep_id;?>">    
                                    <input type="hidden" class="d-none" name="major" id="major_id" value="<?=$major_id;?>">    
                                    <input type="hidden" class="d-none" name="class" id="class_id" value="<?=$class_id;?>">
                                    <input type="hidden" class="d-none" name="id" value="<?=$schedule_id;?>">
                                    <input type="hidden" class="d-none" name="semester" value="<?=$schedule_result['year_semester_id'];?>">
                                    <input type="hidden" class="d-none" name="url" value="<?php echo basename($_SERVER['PHP_SELF']);
                                                                                        if($_SERVER['QUERY_STRING'] != ''){
                                                                                            // echo '?'. str_replace('sch='. $schedule_id.'&', '', $_SERVER['QUERY_STRING']);
                                                                                            echo '?'.$_SERVER['QUERY_STRING'];
                                                                                        }?>">
                                    <input type="hidden" class="d-none" name="schId" value="<?=$_GET['sch'];?>">
                                                   

                                    <label for="semester">1. Apply to class <span class="text-danger"></span></label>
                                    <select disabled id="class_info" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                        <option disabled selected>Please select class</option>

                                        <?php
                                            // $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study ='". date('Y') . "' AND major_id ='". $major_id ."'");
                                            $i = 1;
                                            $class = mysqli_query($conn, "SELECT * FROM class 
                                                                        INNER JOIN major ON class.major_id = major.major_id
                                                                        WHERE class.class_id ='". $class_id ."'");
                                            while($result = mysqli_fetch_assoc($class)){
                                        ?>            
                                            <option 
                                                <?php
                                                    echo ($class_id == $result['class_id'])? 'selected':'';
                                                ?>
                                            value="<?=$result['class_id'];?>">Class: <?=$result['class_code'];?> - <span class="text-white"><?=$result['major'];?></span></option>

                                        <?php
                                            }
                                            mysqli_free_result($class);
                                        ?>
                                    </select>       
                                    <!-- <label for="">Year level</label>     
                                    <div id="year_level">
                                        <input type="text" class="" value="<?=$information;?>" disabled>
                                    </div>           -->

                                    <label for="subject">2. Subject <span class="text-danger">*</span></label>                

                                    <select name="subject" id="subject" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                        <option disabled selected>Please select subject</option>
                                        
                                    <?php
                                        $i = 1;
                                        $subject = mysqli_query($conn, "SELECT * FROM course WHERE department_id='". $department_id ."'");
                                        if(mysqli_num_rows($subject) > 0){
                                        
                                        while($result = mysqli_fetch_assoc($subject)){
                                    ?>
                                        <!-- <option value="<=$result['subject_code'];?>"><=$i++.". ".$result['subject_name'];?></option> -->
                                        <option <?php echo ($schedule_result['subject_code'] == $result['subject_code']) ? 'selected': '';?> value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_code'].": ".$result['subject_name']. " - " .$result['credit'] ."(". $result['theory']. ".". $result['execute'].".". $result['apply'].")";?></option>

                                    <?php
                                            }
                                        }else{
                                            $i = 1;
                                            $subject = mysqli_query($conn, "SELECT * FROM course");    
                                            while($result = mysqli_fetch_assoc($subject)){
                                        ?>
                                            <option <?php echo ($schedule_result['subject_code'] == $result['subject_code']) ? 'selected': '';?> value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_code'].": ".$result['subject_name']. " - " .$result['credit'] ."(". $result['theory']. ".". $result['execute'].".". $result['apply'].")";?></option>

                                        <?php
                                            }
                                        }
                                        mysqli_free_result($subject);
                                    
                                    ?>                               
                                    </select>

                                    <!-- ---------------- subject end ---------------- -->

                                    
                                    <label for="day" style="margin-top: 0;">3. Instructor <span class="text-danger">*</span></label>
                                    <select name="instructor" id="instructor" data-live-search="true"  class="selectpicker d-block w-100 mb-1 mt-1" required>
                                        <option disabled selected>Please select insctructor</option>
                                    <?php
                                        $i = 1;
                                        $instructor = mysqli_query($conn, "SELECT * FROM teacher_info");
                                        while($result = mysqli_fetch_assoc($instructor))
                                        {
                                    ?>
                                            <option <?php echo ($schedule_result['instructor_id'] == $result['teacher_id']) ? 'selected': '';?>  value="<?=$result['teacher_id'];?>"><?=$i++. ". ".$result['fn_khmer'] . " " .$result['ln_khmer'];?></option>
                                    <?php
                                        }
                                    ?>                             
                                    </select>   
                                    <small class="d-block mb-0"><a href="<?=SITEURL;?>add-teacher.php" >Add new instructor.</a></small>

                                
                                </div>


                                <div class="part">   
                                    
                                    <label for="day" class="mt-2">4. Day <span class="text-danger">*</span></label>
                                    <select name="day" id="day" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                        <option disabled selected>Please select day</option>
                                    <?php
                                        $day_in_week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                        $i = 1;
                                        foreach($day_in_week as $day){
                                    ?>
                                        <option <?php echo ($schedule_result['day'] == $day) ? 'selected': '';?> value="<?=$day;?>"><?= $i++. ". ". $day;?></option>
                                    <?php
                                        }
                                    ?>                             
                                    </select>

                                    <div class="d-flex start_end_time" style="margin-top: 5px;">
                                        <div class="block">
                                            <label for="start_time">5. Start time <span class="text-danger">*</span></label>
                                            <input type="time" id="start_time" name="start_time" oninput="checkTime()" required value="<?=$schedule_result['start_time'];?>">
                                        </div>
                                        <div class="block">
                                            <label for="end_time">6. End time <span class="text-danger">*</span></label>
                                            <input type="time" id="end_time" name="end_time" required value="<?=$schedule_result['end_time'];?>"> 
                                        </div>
                                        
                                        <div class="block last">
                                            <input type="hidden" name="at" value="<?=$schedule_result['at'];?>" id="at">
                                            <!-- <label for="">&nbsp</label>
                                            
                                            <select name="at" id="">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select> -->
                                        </div>
                                    </div>

                                    
                                    
                                

                                    <label for="room">7. Room <span class="text-danger">*</span></label>
                                    <!-- <input type="text" id="room" name="room" placeholder="Room..." required  value="<?=$schedule_result['room'];?>">   -->
                                    
                                    <select name="room" data-live-search="true"  class="selectpicker d-block w-100 mb-1 mt-1" required>
                                        <option disabled selected>Please select insctructor</option>
                                    <?php
                                        $i = 1;
                                        $room = mysqli_query($conn, "SELECT * FROM room");
                                        while($result = mysqli_fetch_assoc($room))
                                        {
                                    ?>
                                            <option <?php echo ($schedule_result['room'] == $result['room']) ? 'selected': '';?>  value="<?=$result['room'];?>"><?=$i++. ". ".$result['room'];?></option>
                                    <?php
                                        }
                                    ?>                             
                                    </select>  
                                    <p class="mt-1 text-danger text-end <?php if(isset($_SESSION['REQUIRED'])) echo $_SESSION['REQUIRED']; unset($_SESSION['REQUIRED']);?>"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Note!</b> <span>All fields are required.</span></p>                   
                                    <button type="submit" name="edit_schedule" class="add__shcedule btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>
                
                                </div>
                            </div>                                                               
                        </form> 
                    </div>
                </div>
                
                
                <!-- footer  -->
                <?php include_once('ims-include/staff__footer.php');?>
            </div>

        <!-- // UPDATE SCHEDULE END FORM  -->

    <?php
            }else{

                // no found data 
    ?>
            <div id="main__content">
                <div class="top__content_title">
                    <h5 class="super__title">Update schedule <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update schedule</p>
                </div>
                <div class="my-3">
                    <a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>

                <div class="all__teacher schedule">
                    <p>No data found.</p>
                </div>
            </div>
    <?php

            }
        }
    ?>
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
                <a href="<?=SITEURL;?>add-schedule.php?dep=<?=$dep_id;?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>add-schedule.php?dep=<?=$dep_id;?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>

            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_DONE_ERROR']);



        if(isset($_SESSION['RE_DELETE'])){
    ?>
        <div id="popUp">
            <div class="form__verify text-center">
                <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
                <p>
                    Do you want to delete shedule?
                </p>
                <p class="mt-4">
                    <a href="<?=SITEURL;?>schedule-action.php?dep=<?=$dep_id;?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>&delete-sch=<?=$_SESSION['RE_DELETE'];?>" class="ok btn btn-sm btn-primary px-5">Ok</a>
                    <a href="<?=SITEURL;?>add-schedule.php?dep=<?=$dep_id;?>&maj=<?=$major_id;?>&class=<?=$class_code_default;?>" class="cancel btn btn-sm btn-warning px-5">Cancel</a>
                </p>
            </div>
        </div>
    <?php
        }
        unset($_SESSION['RE_DELETE']);

    ?>
<!-- popup end  -->



    <!-- <script src="ims-assets/jQuery/chosen.jquery.min.js"></script>
    <script src="ims-assets/jQuery/jquery-3.7.1.min.js"></script> -->

    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        function checkTime(){
            const timeInput = document.getElementById('start_time');
            const timeValue = timeInput.value; // The value will be in 24-hour format, e.g., "13:30"
            const atTime = document.getElementById('at');

            // Extract the AM/PM value
            let amPm = 'am';
            let hours = parseInt(timeValue.split(':')[0]);
            if (hours >= 12) {
                amPm = 'pm';
                if (hours > 12) {
                    hours -= 12;
                }
            }
            atTime.value = amPm;
        }
    </script>

    


    <script>
        $(document).ready(function(){
            $('#instructor').on('change', function(){
                var instructor = $(this).val();
                var semester = $('#semester_schedule').val();
                if(instructor){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        // data:'instructor='+instructor,
                        data:{instructor: instructor, semester_id: semester},
                        success:function(html){
                            $('#teacher_information').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    
                }            
            });



            $('#semester_schedule').on('change', function(){
                var semester_schedule = $(this).val();
                var class_id = $('#class_id').val();

                if(semester_schedule){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:{semester_schedule: semester_schedule, pre_class: class_id},
                        success:function(html){
                            $('#preview__schedule').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });


            
            $('#academy_year_schedule').on('change', function(){
                var academy_year_schedule = $(this).val();
                if(academy_year_schedule){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'academy_year_schedule='+academy_year_schedule,
                        success:function(html){
                            $('#semester_schedule').html(html);
                            // $('#semester_schedule').html('<option value="">Hi there.</option>'); 
                        }
                    }); 
                }
            });
        });
    </script>   
</body>
</html>