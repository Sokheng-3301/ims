<?php
    # Connection to DATABASE
    require_once('../ims-db-connection.php');
    
    #Check login 
    include_once('std-login-check.php');

    // class info start /
    $student_id = $_SESSION['LOGIN_STDID'];
    $student_info  = mysqli_query($conn, "SELECT * FROM student_info 
                                        INNER JOIN class ON student_info.class_id = class.class_id
                                        INNER JOIN major ON class.major_id = major.major_id
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE student_id ='". $student_id ."'");
    if(mysqli_num_rows($student_info) > 0){
        $result = mysqli_fetch_assoc($student_info);
        $class_id = $result['class_id'];
    }
    // class info end /





    if(!empty($_POST['your_sibling']) && $_POST['your_sibling'] > 0){
        $total_sibling = $_POST['your_sibling'];

?>
<div class="table">
    <table>
        <tr>
            <th>Fullname</th>
            <th>Gender</th>
            <th>Date of birth</th>
            <th>Occupation</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
<?php
        for($i=1; $i<= $total_sibling; $i++){
?>
        <tr>
            <td><input type="text" name="sibling_fullname<?=$i;?>" placeholder="Fullname"></td>
            <td>
                <select name="sibling_gender<?=$i;?>" id="">
                    <option disabled selected>Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </td>
            <td><input type="date" id="sibling_date<?=$i;?>" placeholder="dd-M-yyyy" name="sibling_birthdate<?=$i;?>"></td>
            <td><input type="text" name="sibling_occupation<?=$i;?>" placeholder="Occupation"></td>
            <td><textarea name="sibling_address<?=$i;?>" rows="1" placeholder="Address"></textarea></td>
            <td><input type="number" name="sibling_phone<?=$i;?>" placeholder="Phone number" min="0"></td>

        </tr>
<?php
        }
    echo '</table>';
echo '</div>';

    }




    if(!empty($_POST['academy_year'])){
        $academy_year = $_POST['academy_year'];
        $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study.year_of_study ='". $academy_year ."'");
        if(mysqli_num_rows($semester) > 0){
?>
        <option disabled selected>Select semester</option>
<?php
            while($semester_data = mysqli_fetch_assoc($semester)){
?>
        <option value="<?=$semester_data['year_semester_id'];?>">Semester: <?=$semester_data['semester'];?></option>
<?php
            }
        }else{
         echo "<option disabled selected>No semester.</option>";
        }
        
    }



    ##################################3
    ##### Schedule filter 
    ###################################

    if(!empty($_POST['semester_schedule'])){
        $semester_id = $_POST['semester_schedule'];
        $semester_info = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id ='". $semester_id."'");
        if(mysqli_num_rows($semester_info) > 0){
            $semester_result = mysqli_fetch_assoc($semester_info);
            $academy_year = $semester_result['year_of_study'];
        }
        // _______________
    ?>
        <div id="schedule_title">
            <p><i class="fa fa-search pe-2" aria-hidden="true"></i>Filter schedule for <br> Semester <b><?=$semester_result['semester']?></b> , Academy year <b><?=$semester_result['year_of_study'];?></b></p>
            <!-- <div id="save_schedule">
                <a href="<?=SITEURL;?>ims-student/save-schedule.php?semester=<?=$semester_id;?>&year=<?=$academy_year;?>"><i class="fa fa-download" aria-hidden="true"></i>Download schedule</a>
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


    <?php
        // --------------------

    }






?>
