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
    
    if(!empty($_GET['q'])){
        $major_id = $_GET['q'];
    }else{
        // $department_id = 1;
        header("Location:".SITEURL."schedule.php");
        exit(0);
    }

    $department_sql = mysqli_query($conn, "SELECT * FROM major INNER JOIN department ON major.department_id = department.department_id  WHERE major_id='". $major_id ."'");
    if(mysqli_num_rows($department_sql) > 0){
        $department_result = mysqli_fetch_assoc($department_sql);
        $major_id = $department_result['major_id'];
    }else{
        header("Location:".SITEURL."schedule.php");
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

            // echo $class_code;
            // exit;
        }
    }
    // echo $information;
    // exit;

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
                    <a href="<?=$back_page;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>

                <div class="all__teacher schedule">
                    <p><i class="fa fa-plus" aria-hidden="true"></i>Add schedule for</p>        
                    <div class="bg-light py-1 px-2" style="width: fit-content;">
                        <p>
                            Department : <span class="fw-bold"><?=$department_result['department'];?> </span>
                        </p>
                            Major : <span class="fw-bold"><?=$department_result['major'];?></span>
                        <p></p>
                    </div>
                    
                    <!-- ADD FORM  -->
                    <form action="<?=SITEURL;?>schedule-action.php" method="post">
                        <div class="manage__form">
                            <div class="part">     
                                <input type="hidden" name="major" value="<?=$major_id;?>">    

                                <label for="semester">Apply to class <span class="text-danger">*</span></label>
                                <select name="class" id="class_info" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                    <option disabled selected>Please select class</option>

                                    <?php
                                        // $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study ='". date('Y') . "' AND major_id ='". $major_id ."'");
                                        $i = 1;
                                        $class = mysqli_query($conn, "SELECT * FROM class 
                                                                    INNER JOIN major ON class.major_id = major.major_id
                                                                    WHERE class.major_id ='". $major_id ."'");
                                        while($result = mysqli_fetch_assoc($class)){
                                    ?>            
                                        <option 
                                            <?php
                                                echo ($class_code == $result['class_code'])? 'selected':'';
                                            ?>
                                        value="<?=$result['class_id'];?>"><?=$i++?>. Class: <?=$result['class_code'];?> - <span class="text-primary"><?=$result['major'];?></span></option>

                                    <?php
                                        }
                                        mysqli_free_result($class);
                                    ?>
                                </select>       
                                <!-- <label for="">Year level</label>     
                                <div id="year_level">
                                    <input type="text" class="" value="<?=$information;?>" disabled>
                                </div>           -->

                                <label for="subject">Subject <span class="text-danger">*</span></label>                

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
                                <label for="academy_year" style="margin-top: 4px;">Academy Year <span class="text-danger">*</span></label>
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


                                <label for="semester"  style="margin-top: 10px;">Semester <span class="text-danger">*</span></label>
                                <div>
                                    <select name="semester"  id="semester_schedule"   required>
                                        <option disabled selected>Select academy year first</option>

                                        
                                    </select>    
                                </div>
                               
                            </div>


                            <div class="part">   
                                <label for="day">Day <span class="text-danger">*</span></label>
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

                                <div class="d-flex start_end_time" style="margin-top: 23px;">
                                    <div class="block">
                                        <label for="start_time">Start time <span class="text-danger">*</span></label>
                                        <input type="time" id="start_time" name="start_time" oninput="checkTime()" required>
                                    </div>
                                    <div class="block">
                                        <label for="end_time">End time <span class="text-danger">*</span></label>
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

                                
                                <label for="day" style="margin-top: 10px;">Instructor <span class="text-danger">*</span></label>
                                <select name="instructor" id="day" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
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

                            

                                <label for="room">Room <span class="text-danger">*</span></label>
                                <input type="text" id="room" name="room" placeholder="Room..." required>         
                                <p class="mt-1 text-danger text-end <?php if(isset($_SESSION['REQUIRED'])) echo $_SESSION['REQUIRED']; unset($_SESSION['REQUIRED']);?>"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Note!</b> <span>All fields are required.</span></p>                   
                                <button type="submit" name="add_schedule" class="add__shcedule"><i class="fa fa-plus" aria-hidden="true"></i>Apply</button>
            
                            </div>
                        </div>

                        <!-- class informaton show  -->
                        <div id="class_information">
                        </div>
                       
                    </form> 
                    

                    <!-- ---------------------- PREVIEW SCHEDULE start---------------------------  -->
                        <div id="preview__schedule">
                            <?php
                                // RT = Return 
                                if(isset($_SESSION['RT_CLASS_CODE'])){
                                    $class_id = $_SESSION['RT_CLASS_CODE'];

                                    // -------------start-----------
                                                                
                                        $query_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.status ='1'");

                                        if(mysqli_num_rows($query_schedule) > 0){
                                            $schedule_result = mysqli_fetch_assoc($query_schedule);
                            ?>
                                <div class="preview__schedule">
                                    <p class="mb-2"><i class="fa fa-list" aria-hidden="true"></i> Preview Schedule</p>
                                    <div class="bg-light rounded px-2 mb-2" style="width: fit-content;">
                                        <small>
                                            <span class="me-2">Class: <b><?=$schedule_result['class_code'];?></b></span> | 
                                            <span class="mx-2">Degree: <b><?=$schedule_result['level_study'];?></b></span> | 
                                            <span class="mx-2">Year level: <b><?=$schedule_result['year_level'];?></b></span> | 
                                            <span class="mx-2">Semester: <b><?=$schedule_result['semester'];?></b></span> | 
                                            <span class="mx-2">Academy year: <b><?=$schedule_result['year_of_study'];?></b></span> 

                                        </small>
                                    </div>

                                    <!-- ###################### 1 MONDAY start #################### -->

                                        <p class="text-primary mb-2">1. Monday</p>
                                        <?php
                                                $monday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Monday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($monday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$monday['subject_name'];?></td>
                                                            <td><?=$monday['subject_code'];?></td>
                                                            <td><?=$monday['credit']."(". $monday['theory'] .".". $monday['execute'] .".". $monday['apply'] .")";?></td>
                                                            <td><?=$monday['fn_khmer'] . " " .$monday['ln_khmer'];?></td>
                                                            <td><?=$monday['start_time'] . " - " .$monday['end_time'];?></td>
                                                            <td><?=$monday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$monday['schedule_id'];?>&q=<?=$monday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$monday['schedule_id'];?>&q=<?=$monday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>
                                            
                                    <!-- ###################### MONDAY stop #################### -->







                                    <!-- ###################### 2 TUESDAY start #################### -->

                                        <p class="text-primary my-2">2. Tuesday</p>
                                        <?php
                                                $tuesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Tuesday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($tuesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$tuesday['subject_name'];?></td>
                                                            <td><?=$tuesday['subject_code'];?></td>
                                                            <td><?=$tuesday['credit']."(". $tuesday['theory'] .".". $tuesday['execute'] .".". $tuesday['apply'] .")";?></td>
                                                            <td><?=$tuesday['fn_khmer'] . " " .$tuesday['ln_khmer'];?></td>
                                                            <td><?=$tuesday['start_time'] . " - " .$tuesday['end_time'];?></td>
                                                            <td><?=$tuesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$tuesday['schedule_id'];?>&q=<?=$tuesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$tuesday['schedule_id'];?>&q=<?=$tuesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>   
                                        
                                    <!-- ###################### TUESDAY stop #################### -->

                                            








                                    <!-- ###################### 3 WEDNESDAY start #################### -->
                                        <p class="text-primary my-2">3. Wednesday</p>
                                        <?php
                                                $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Wednesday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$wednesday['subject_name'];?></td>
                                                            <td><?=$wednesday['subject_code'];?></td>
                                                            <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                            <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                            <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                            <td><?=$wednesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>         
                                    <!-- ###################### WEDNESDAY stop #################### -->





                                    <!-- ###################### 4 THURSDAY start #################### -->
                                        <p class="text-primary my-2">4. Thursday</p>
                                        <?php
                                                $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Thursday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$wednesday['subject_name'];?></td>
                                                            <td><?=$wednesday['subject_code'];?></td>
                                                            <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                            <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                            <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                            <td><?=$wednesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>         
                                    <!-- ###################### THURSDAY stop #################### -->



                                    <!-- ###################### 5 FRIDAY start #################### -->
                                        <p class="text-primary my-2">5. Friday</p>
                                        <?php
                                                $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Friday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$wednesday['subject_name'];?></td>
                                                            <td><?=$wednesday['subject_code'];?></td>
                                                            <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                            <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                            <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                            <td><?=$wednesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>         
                                    <!-- ###################### FRIDAY stop #################### -->

                                            

                                    <!-- ###################### 6 SATURDAY start #################### -->
                                        <p class="text-primary my-2">6. Saturday</p>
                                        <?php
                                                $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Saturday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$wednesday['subject_name'];?></td>
                                                            <td><?=$wednesday['subject_code'];?></td>
                                                            <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                            <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                            <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                            <td><?=$wednesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>         
                                    <!-- ###################### SATURDAY stop #################### -->


                                    <!-- ###################### 7 SUNDAY start #################### -->
                                        <p class="text-primary my-2">7. Sunday</p>
                                        <?php
                                                $wednesday_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id ='". $class_id ."' 

                                                                                AND schedule_study.day = 'Sunday'
                                                                                AND year_of_study.status ='1'
                                                                                ORDER BY at ASC");
                                                if(mysqli_num_rows($wednesday_schedule) > 0){   
                                                    // $monday = mysqli_fetch_assoc($monday_schedule) ;
                                                    // $major_id = '';
                                                    
                                        ?>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>No.</th>
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
                                                            <td><?=$wednesday['subject_name'];?></td>
                                                            <td><?=$wednesday['subject_code'];?></td>
                                                            <td><?=$wednesday['credit']."(". $wednesday['theory'] .".". $wednesday['execute'] .".". $wednesday['apply'] .")";?></td>
                                                            <td><?=$wednesday['fn_khmer'] . " " .$wednesday['ln_khmer'];?></td>
                                                            <td><?=$wednesday['start_time'] . " - " .$wednesday['end_time'];?></td>
                                                            <td><?=$wednesday['room'];?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                <a class="btn btn-sm btn-danger" style="font-size: 10px;" href="<?=SITEURL;?>schedule-action.php?sch=<?=$wednesday['schedule_id'];?>&q=<?=$wednesday['major_id'];;?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                        <?php
                                                    }
                                        ?>
                                                    </tbody>
                                                </table>  
                                        <?php
                                                }
                                        ?>         
                                    <!-- ###################### SUNDAY stop #################### -->
                                     
                                    <a class="btn__addschedule" href="<?=SITEURL;?>schedule-action.php?semester=<?=$schedule_result['year_semester_id'];?>&class=<?=$schedule_result['class_id'];?>&q=<?=$major_id;?>"><i class="fa fa-check" aria-hidden="true"></i> Done</a>
                                </div>
                                
                            <?php
                                            
                                }

                                    // -------------end-----------


                                }
                            ?>
                        </div>



                    <!-- ---------------------- PREVIEW SCHEDULE end---------------------------  -->
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
            $schedule_id = $_GET['sch'];
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
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update schedule</p>
                </div>
                <div class="my-3">
                    <a href="<?=$back_page;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>

                <div class="all__teacher schedule">
                    <p>Update schedule for</p>        
                    <div class="bg-light py-1 px-2" style="width: fit-content;">
                        <p>
                            Department : <span class="fw-bold"><?=$department_result['department'];?> </span>
                        </p>
                            Major : <span class="fw-bold"><?=$department_result['major'];?></span>
                        <p></p>
                    </div>
                    
                    <form action="<?=SITEURL;?>schedule-action.php" method="post">
                        <input type="hidden" name="year_level" value="<?=$schedule_result['year_level'];?>">
                        <input type="hidden" name="id" value="<?=$schedule_result['schedule_id'];?>">
                        <input type="hidden" name="major" value="<?=$major_id;?>"> 
                        


                        <div class="manage__form">
                            <div class="part">     
                                
                                <label for="semester">Appy to class <span class="text-danger">*</span></label>
                                <select name="class" id="class_info" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                    <option disabled selected>Please select class</option>

                                    <?php
                                        // $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study ='". date('Y') . "' AND major_id ='". $major_id ."'");
                                        $i = 1;
                                        $class = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."'");
                                        while($result = mysqli_fetch_assoc($class)){
                                    ?>            
                                        <option 
                                            <?php
                                                echo ($schedule_result['class_id'] == $result['class_id'])? 'selected':'';
                                            ?>
                                        value="<?=$result['class_id'];?>"><?=$i++?>. Class: <?=$result['class_code'];?></option>

                                    <?php
                                        }
                                        mysqli_free_result($class);
                                    ?>
                                </select>       
                                <!-- <label for="">Year level</label>     
                                <div id="year_level">
                                    <input type="text" class="" value="<?=$information;?>" disabled>
                                </div>           -->

                                <label for="subject">Subject <span class="text-danger">*</span></label>                

                                <select name="subject" id="subject" class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true" required>
                                    <option disabled selected>Please select subject</option>
                                    
                                <?php
                                    $i = 1;
                                    $subject = mysqli_query($conn, "SELECT * FROM course WHERE department_id='". $department_id ."'");
                                    if(mysqli_num_rows($subject) > 0){
                                    
                                    while($result = mysqli_fetch_assoc($subject)){
                                ?>
                                    <!-- <option value="<=$result['subject_code'];?>"><=$i++.". ".$result['subject_name'];?></option> -->
                                    <option 
                                            <?php
                                                echo ($schedule_result['subject_code'] == $result['subject_code'])? 'selected':'';
                                            ?>
                                    value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_name'].": ".$result['subject_code'];?></option>

                                <?php
                                        }
                                    }else{
                                        $subject = mysqli_query($conn, "SELECT * FROM course");    
                                        while($result = mysqli_fetch_assoc($subject)){
                                    ?>
                                        <option 
                                            <?php
                                                echo ($schedule_result['subject_code'] == $result['subject_code'])? 'selected':'';
                                            ?>
                                        value="<?=$result['subject_code'];?>"><?=$i++.". ".$result['subject_name'].": ".$result['subject_code'];?></option>
                                    <?php
                                        }
                                    }
                                    mysqli_free_result($subject);
                                
                                ?>                               
                                </select>

                                <!-- ---------------- subject end ---------------- -->

                                <!-- study level should't show becuase year level below can identify student's study level  -->
                                <label for="academy_year" style="margin-top: 4px;">Academy Year <span class="text-danger">*</span></label>
                                <select name="academy_year" id="academy_year_schedule" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                    <option disabled selected>Please select academy year</option>

                                    <?php
                                        $i = 1;
                                        $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        while($result = mysqli_fetch_assoc($year)){
                                    ?>            
                                        <option <?php
                                                echo ($schedule_result['year_of_study'] == $result['year'])? 'selected':'';
                                            ?>  value="<?=$result['year'];?>"><?=$i++?>. Year: <?=$result['year'];?></option>
                                    <?php
                                        }
                                        mysqli_free_result($year);
                                    ?>
                                </select>    


                                <label for="semester"  style="margin-top: 10px;">Semester <span class="text-danger">*</span></label>
                                <div>
                                    <select name="semester"  id="semester_schedule"   required>
                                        <option disabled selected>Select academy year first</option>

                                    <?php
                                        $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $schedule_result['year_of_study'] ."'");
                                        while($result = mysqli_fetch_assoc($semester)){
                                    ?>            
                                        <option class="<?php
                                            echo ($result['status'] == '0') ? 'text-primary' : '';
                                        ?>" <?php
                                                echo ($schedule_result['year_semester_id'] == $result['year_semester_id'])? 'selected':'';
                                            ?>  value="<?=$result['year_semester_id'];?>">- Semester: <?=$result['year_semester_id'];?>, Year: <?=$result['year_of_study'];?> <?php echo ($result['status'] == '0')? ' (Finished) ' : '';?></option>
                                    <?php
                                        }
                                        mysqli_free_result($semester);
                                    ?>
                                        

                                    </select>    
                                </div>
                               
                            </div>


                            <div class="part">   
                                <label for="day">Day <span class="text-danger">*</span></label>
                                <select name="day" id="day" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                    <option disabled selected>Please select day</option>
                                <?php
                                    $day_in_week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                                    $i = 1;
                                    foreach($day_in_week as $day){
                                ?>
                                    <option <?php
                                                echo ($schedule_result['day'] == $day)? 'selected':'';
                                            ?> value="<?=$day;?>"><?= $i++. ". ". $day;?></option>
                                <?php
                                    }
                                ?>                             
                                </select>     

                                <div class="d-flex start_end_time" style="margin-top: 23px;">
                                    <div class="block">
                                        <label for="start_time">Start time <span class="text-danger">*</span></label>
                                        <input type="time" id="start_time" name="start_time" oninput="checkTime()" required value="<?=$schedule_result['start_time'];?>">
                                    </div>
                                    <div class="block">
                                        <label for="end_time">End time <span class="text-danger">*</span></label>
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

                                
                                <label for="day" style="margin-top: 10px;">Instructor <span class="text-danger">*</span></label>
                                <select name="instructor" id="day" data-live-search="true"  class="selectpicker d-block w-100 mb-3 mt-1" required>
                                    <option disabled selected>Please select insctructor</option>
                                <?php
                                    $i = 1;
                                    $instructor = mysqli_query($conn, "SELECT * FROM teacher_info");
                                    while($result = mysqli_fetch_assoc($instructor))
                                    {
                                ?>
                                        <option  <?php
                                                echo ($schedule_result['instructor_id'] == $result['teacher_id'])? 'selected':'';
                                            ?> value="<?=$result['teacher_id'];?>"><?=$i++. ". ".$result['fn_khmer'] . " " .$result['ln_khmer'];?></option>
                                <?php
                                    }
                                ?>                             
                                </select>   
                                <small class="d-block mb-0"><a href="<?=SITEURL;?>add-teacher.php" >Add new instructor.</a></small>

                            

                                <label for="room">Room <span class="text-danger">*</span></label>
                                <input type="text" id="room" name="room" placeholder="Room..." required value="<?=$schedule_result['room'];?>">         
                                <p class="mt-1 text-danger text-end <?php if(isset($_SESSION['REQUIRED'])) echo $_SESSION['REQUIRED']; unset($_SESSION['REQUIRED']);?>"><b><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Note!</b> <span>All fields are required.</span></p>                   
                                <button type="submit" name="edit_schedule" class="add__shcedule"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>
            
                            </div>
                        </div>

                        <!-- class informaton show  -->
                        <div id="class_information">
                        </div>


                    </form> 
                
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
                <a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>add-schedule.php?q=<?=$major_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_DONE_ERROR']);

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
            $('#class_info').on('change', function(){
                var class_info = $(this).val();
                if(class_info){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'class_selected='+class_info,
                        success:function(html){
                            $('#class_information').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    
                }            
            });



            $('#class_info').on('change', function(){
                var class_info = $(this).val();
                if(class_info){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'schedule_data='+class_info,
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