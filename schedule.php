<?php
    #Connection to DATABASE
    require_once('../ims-db-connection.php');

    
    #Check login 
    include_once('std-login-check.php');

    $current_year = date("Y");
    $semester_id = '';
    $curr_semester = '';
    $curr_year = '';
    $current_semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE status = '1' AND year_of_study ='". $current_year ."'");
    // $current_semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $current_year ."'");
    if(mysqli_num_rows($current_semester) > 0){
        $current_data = mysqli_fetch_assoc($current_semester);
        $semester_id = $current_data['year_semester_id'];
        $curr_semester = $current_semester['semester'];
        $current_year = $current_data['year_of_study'];
    }else{

    }
    // $class_id in header 

?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <?php include_once('../ims-include/head-tage.php');?>
    </head>
    <body>
        <!-- include preload for web page  -->
        <?php #include_once('../ims-include/preload.php');?>

        <!-- top header - header of system  -->
        <?php include_once('../ims-include/header.php'); ?>

        <section id="main-content" id="closeDetial" onclick="closeDetial()">
            <div class="container-ims py-5">
                <div class="schedule p-4">
                    <h3><?=schedule;?></h3>
                    <div class="schedule-container">
                        <div class="shadow-bg">
                            <div class="background-content">
                                <div class="filter-schedule">
                                    <form action="">
                                        <div class="d-flex">
                                            <p><i class="fa fa-filter pe-2" aria-hidden="true"></i>Filter schedule: </p>

                                            <select name="" id="academy_year">
                                                <option disabled selected>Academy year</option>
                                                <?php
                                                    $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                                    while($year_data = mysqli_fetch_assoc($year)){
                                                ?>
                                                    <option value="<?=$year_data['year'];?>" <?php echo ($year_data['year'] == $current_year)? 'selected': '';?>>Year: <?=$year_data['year'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>

                                            <div class="border"></div>
                                            <select name="" id="semester">
                                                <option disabled selected>Select semester</option>
                                                <?php
                                                    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $current_year ."'");
                                                    while($semester_data = mysqli_fetch_assoc($semester)){
                                                ?>
                                                    <option <?php
                                                        echo ($semester_data['year_semester_id'] == $semester_id) ? 'selected' : '';
                                                    ?> value="<?=$semester_data['year_semester_id'];?>">Semester: <?=$semester_data['semester'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <?php
                                    if($semester_id == '' && $curr_semester == '' && $curr_year == ''){
                                ?>
                                    <div class="content-schedule" id="content_schedule">
                                        <p class="mt-4"><i class="fa fa-search" aria-hidden="true"></i> Please filter schedule.</p>
                                    </div>
                                <?php
                                    }else{
                                ?>

                                <div class="content-schedule" id="content_schedule">
                                    <div id="schedule_title">
                                        <p><i class="fa fa-calendar pe-2" aria-hidden="true"></i>Current schedule for <br> Semester <b><?=$curr_semester;?></b> , Academy year <b><?=$curr_year;?></b></p>
                                        <!-- <div id="save_schedule">
                                            <a href="<?=SITEURL;?>ims-student/save-schedule.php?semester=<?=$semester_id;?>&year=<?=$current_year;?>" id="download_schedule"><i class="fa fa-download" aria-hidden="true"></i>Download schedule</a>
                                        </div> -->
                                    </div>
                                    <p class="day">1. Monday</p>
                                    <div class="border">
                                        <table class="table">
                                            <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr>
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'
                                                                                AND schedule_study.day ='Monday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                            
                                        </table>
                                    </div>



                                    <p class="day">2. Tuesday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'
                                                                                
                                                                                AND schedule_study.day ='Tuesday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>



                                    <p class="day">3. Wednesday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'                                                                       
                                                                                AND schedule_study.day ='Wednesday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>


                                    
                                    <p class="day">4. Thursday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'                                                                       
                                                                                AND schedule_study.day ='Thursday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>


                                    
                                    <p class="day">5. Friday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'                                                                       
                                                                                AND schedule_study.day ='Friday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>



                                    <p class="day">6. Saturday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'                                                                       
                                                                                AND schedule_study.day ='Saturday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>



                                    <p class="day">7. Sunday</p>
                                    <div class="border">
                                        <table class="table">
                                            <!-- <tr>
                                                <th>Subject code</th>
                                                <th>Subject</th>
                                                <th>Credit</th>
                                                <th>Intructor</th>
                                                <th>Duration <sup>H</sup></th>
                                                <th>Room</th>
                                            </tr> -->
                                            <?php
                                                $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                WHERE schedule_study.class_id = '".$class_id."'
                                                                                AND schedule_study.year_semester_id = '". $semester_id ."'                                                                       
                                                                                AND schedule_study.day ='Sunday' ORDER BY schedule_study.at ASC");
                                                if(mysqli_num_rows($monday) > 0){
                                                    
                                                    while($monday_data = mysqli_fetch_assoc($monday)){
                                            ?>
                                            <tr>
                                                <td><?=$monday_data['subject_code']?></td>
                                                <td><?=$monday_data['subject_name']?></td>
                                                <td><?=$monday_data['credit']."(".$monday_data['theory'].".".$monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                                <td><?=$monday_data['fn_khmer']." ". $monday_data['ln_khmer'];?></td>
                                                <td><?=$monday_data['start_time']." - ". $monday_data['end_time'];?></td>
                                                <td><?=$monday_data['room']?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            
                                            ?>
                                        </table>
                                    </div>

                                </div>

                                <?php
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- footer of system  -->
        <?php include_once('../ims-include/footer.php');?>

        <!-- include javaScript in web page  -->
        <?php include_once('../ims-include/script-tage.php');?>



        <script>
            $(document).ready(function(){
               
                $('#academy_year').on('change', function(){
                    var academy_year = $(this).val();
                    if(academy_year){
                        $.ajax({
                            type:'POST',
                            url:'student-ajax.php',
                            data:'academy_year='+academy_year,
                            success:function(html){
                                $('#semester').html(html);
                            }
                        }); 
                    }
                    console.log(academy_year);
                });

                $('#semester').on('change', function(){
                    var semester = $(this).val();
                    if(semester){
                        $.ajax({
                            type:'POST',
                            url:'student-ajax.php',
                            data:'semester_schedule='+semester,
                            success:function(html){
                                $('#content_schedule').html(html);
                            }
                        }); 
                    }
                    // console.log(semester);                 
                });
            });
        </script>

    </body>
</html>

