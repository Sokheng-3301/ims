<?php 
// Include the database config file 
require_once('ims-db-connection.php');
 
if(!empty($_POST["year_of_study_id"])){ 
    // Fetch state data based on the specific country 
    $query = "SELECT * FROM year_of_study WHERE year_of_study = '".$_POST['year_of_study_id']."' ORDER BY semester ASC"; 
    $result = $conn->query($query); 
     
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        echo '<option value="">ជ្រើសរើសឆមាស</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['year_semester_id'].'"> ឆមាសទី '.$row['semester'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">មិនមានឆមាសទេ</option>'; 
    } 
}


if(!empty($_POST["class_id"])){ 
    // Fetch state data based on the specific country 
    $query = "SELECT * FROM class WHERE year_of_study = '".$_POST['class_id']."'";
    $result = $conn->query($query); 
     
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        echo '<option value="">ជ្រើសរើសថ្នាក់</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['class_id'].'"> ថ្នាក់ '.$row['class_code'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">មិនមានថ្នាក់ទេ</option>'; 
    } 
}



if(!empty($_POST['user_role'])){
    // echo 'Hello world';

    $query = "SELECT * FROM function";
    $result = $conn->query($query); 

    if(mysqli_num_rows($result) > 0){
        $i = 1;

        while($row = mysqli_fetch_assoc($result)){
            // $func_id = explode(',', $row['func_id']);
            // $sub_func_id = explode(',', $row['sub_func_id']);
            
            $role_function = mysqli_query($conn, "SELECT * FROM role_permission WHERE role_id ='". $_POST['user_role'] ."'");
            $role_function_data = mysqli_fetch_assoc($role_function);
            // while($role_function_data = mysqli_fetch_assoc($role_function)){
                // echo "<pre>";
                //     print_r($role_function_data);
                // echo "</pre>";
                $main_func_apply = explode(',', $role_function_data['func_id']);

                // foreach($main_func_apply as $func_apply){
                if($row['func_link'] != ''){

                
            ?>
                <div class="d-flex">
                    <span class="me-4" style="width: 17px;"><?=$i++?>.</span><input type="checkbox" <?php
                        foreach($main_func_apply as $main_func_apply){
                            if($main_func_apply == $row['func_id']) echo 'checked';
                        }
                    ?> name="function[]" id="function_<?=$row['func_id'];?>" value="<?=$row['func_id'];?>"> <label for="function_<?=$row['func_id'];?>"  class="ps-2"> <i class="<?=$row['func_icon'];?> text-secondary" aria-hidden="true"></i> <?=$row['func_name'];?></label>
                </div>

            <?php
                }else{
            ?>
                <div class="d-flex">
                    <span class="me-4" style="width: 17px;"><?=$i++?>.</span><input type="checkbox" <?php
                        foreach($main_func_apply as $main_func_apply){
                            if($main_func_apply == $row['func_id']) echo 'checked';
                        }
                    ?> name="function[]" id="function_<?=$row['func_id'];?>" value="<?=$row['func_id'];?>"> <label for="function_<?=$row['func_id'];?>" class="ps-2"> <i class="<?=$row['func_icon'];?> text-secondary" aria-hidden="true"></i><?=$row['func_name'];?></label>
                </div>
            <?php
                    $sub_func = mysqli_query($conn, "SELECT * FROM sub_function WHERE func_id ='". $row['func_id'] ."'");
                    while($sub_row = mysqli_fetch_assoc($sub_func)){
                        $sub_func_apply =  explode(',', $role_function_data['sub_func_id']);
                        
                        
            ?>
                        <div class="d-flex" style="margin-left: 82px;">
                            <input  type="checkbox"
                            <?php
                                foreach($sub_func_apply as $sub_func_apply){
                                    if($sub_func_apply == $sub_row['sub_id']) echo 'checked';
                                }
                            ?>
                            name="sub_function[]" id="sub_<?=$sub_row['sub_id'];?>" value="<?=$sub_row['sub_id'];?>"> <label for="sub_<?=$sub_row['sub_id'];?>"><i class="fa fa-circle text-secondary" style="font-size: 55%;" aria-hidden="true"></i><?=$sub_row['sub_name'];?></label>
                        </div>

            <?php   
                    }
                }
                // }
            // }
           
        }
        // exit;
    }

}



#####################################
###### Without status filter start
#####################################
    if(!empty($_POST['filter_request'])){

        $student_info = mysqli_real_escape_string($conn, $_POST['filter_request']);
        $filter = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.student_id LIKE '%$student_info%'
                                        -- OR requests.request_type LIKE '%$student_info%'
                                        -- OR student_info.firstname LIKE '%$student_info%'
                                        -- OR student_info.lastname LIKE '%$student_info%'
                                        AND requests.request_status = '0'");

        if(mysqli_num_rows($filter) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($filter)){
                // echo 'Defualt';
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?=$request_result['request_date'];?></td>
                <td>
                    <a href="<?=SITEURL;?>request-detail.php?q=<?=$request_result['id'];?>" class="detail">Detail</a>
                    <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                </td>
            </tr>
        <?php
            }
        }else{
            echo "<tr>";
            echo '<td colspan ="7" clast ="text-start">Request not found!</td>';
            echo "</tr>";

        }
    }

    if(isset($_POST['filter_request'])  && $_POST['filter_request'] == ''){
        $request = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.request_status = '0'
                                        ORDER BY request_date DESC");


        if(mysqli_num_rows($request) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($request)){
                // echo 'Defualt';
                // exit;
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?=$request_result['request_date'];?></td>
                <td>
                    <a href="<?=SITEURL;?>request-detail.php?q=<?=$request_result['id'];?>" class="detail">Detail</a>
                    <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                </td>
            </tr>

            <?php
            }                                  
        }
    }

#####################################
###### Without status filter end
#####################################





#####################################
###### Request done filter start
#####################################
    if(!empty($_POST['done_filter_request'])){

        $student_info = mysqli_real_escape_string($conn, $_POST['done_filter_request']);
        $filter = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.student_id LIKE '%$student_info%'
                                        -- OR requests.request_type LIKE '%$student_info%'
                                        -- OR student_info.firstname LIKE '%$student_info%'
                                        -- OR student_info.lastname LIKE '%$student_info%'
                                        AND requests.request_status = '1'");

        if(mysqli_num_rows($filter) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($filter)){
                // echo 'Defualt';
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td>
                    <p id="done_bg">
                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i><span class="ps-1 text-success">Done</span>
                    </p>
                </td>
            </tr>
        <?php
            }
        }else{
            echo "<tr>";
            echo '<td colspan ="7" clast ="text-start">Request not found!</td>';
            echo "</tr>";

        }
    }

    if(isset($_POST['done_filter_request'])  && $_POST['done_filter_request'] == ''){
        $request = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.request_status = '1'
                                        ORDER BY request_date DESC");


        if(mysqli_num_rows($request) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($request)){
                // echo 'Defualt';
                // exit;
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td>
                    <p id="done_bg">
                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i><span class="ps-1 text-success">Done</span>
                    </p>
                </td>
            </tr>

            <?php
            }                                  
        }
    }

#####################################
###### Request done filter end
#####################################







#####################################
###### Accepted request filter start
#####################################
    if(!empty($_POST['accept_filter_request'])){

        $student_info = mysqli_real_escape_string($conn, $_POST['accept_filter_request']);
        $filter = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.student_id LIKE '%$student_info%'
                                        -- OR requests.request_type LIKE '%$student_info%'
                                        -- OR student_info.firstname LIKE '%$student_info%'
                                        -- OR student_info.lastname LIKE '%$student_info%'
                                        AND requests.request_status = '0' 
                                        AND requests.feedback = 'accepted'");

        if(mysqli_num_rows($filter) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($filter)){
                // echo 'Defualt';
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td class="text-center">
                    <p id="bg_accept">
                        <i class="fa fa-check text-primary" aria-hidden="true"></i><span class="text-primary ps-1">Accepted</span>
                    </p>
                </td>
                <td>
                    <a href="<?=SITEURL;?>request-detail.php?q=<?=$request_result['id'];?>" class="detail">Detail</a>
                    <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                </td>
            </tr>
        <?php
            }
        }else{
            echo "<tr>";
            echo '<td colspan ="8" clast ="text-start">Request not found!</td>';
            echo "</tr>";

        }
    }

    if(isset($_POST['accept_filter_request'])  && $_POST['accept_filter_request'] == ''){
        $request = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.request_status = '0'
                                        AND requests.feedback = 'accepted'
                                        ORDER BY request_date DESC");


        if(mysqli_num_rows($request) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($request)){
                // echo 'Defualt';
                // exit;
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td class="text-center">
                    <p id="bg_accept">
                        <i class="fa fa-check text-primary" aria-hidden="true"></i><span class="text-primary ps-1">Accepted</span>
                    </p>
                </td>
                <td>
                    <a href="<?=SITEURL;?>request-detail.php?q=<?=$request_result['id'];?>" class="detail">Detail</a>
                    <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                </td>
            </tr>

            <?php
            }                                  
        }
    }

#####################################
###### Accepted request filter end
#####################################




#####################################
###### Reject request filter start
#####################################

    if(!empty($_POST['reject_filter_request'])){

        $student_info = mysqli_real_escape_string($conn, $_POST['reject_filter_request']);
        $filter = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.student_id LIKE '%$student_info%'
                                        -- OR requests.request_type LIKE '%$student_info%'
                                        -- OR student_info.firstname LIKE '%$student_info%'
                                        -- OR student_info.lastname LIKE '%$student_info%'
                                        AND requests.request_status = '2'
                                        AND requests.feedback = 'rejected'");

        if(mysqli_num_rows($filter) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($filter)){
                // echo 'Defualt';
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td>
                    <p id="done_bg">
                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i><span class="ps-1 text-danger">Rejected</span>
                    </p>
                </td>
            </tr>
        <?php
            }
        }else{
            echo "<tr>";
            echo '<td colspan ="7" clast ="text-start">Request not found!</td>';
            echo "</tr>";

        }
    }

    if(isset($_POST['reject_filter_request'])  && $_POST['reject_filter_request'] == ''){
        $request = mysqli_query($conn, "SELECT * FROM  student_info
                                        INNER JOIN requests ON requests.student_id = student_info.student_id
                                        WHERE requests.request_status = '2'
                                        AND requests.feedback = 'rejected'
                                        ORDER BY request_date DESC");


        if(mysqli_num_rows($request) > 0){
            $i =1;
            while($request_result = mysqli_fetch_assoc($request)){
                // echo 'Defualt';
                // exit;
            ?>

            <tr>
                <td class="no text-center"><?=$i++;?></td>
                <td><?=$request_result['student_id'];?></td>
                <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                <td class="table-width-50"><?=$request_result['gender'];?></td>
                <!-- <td>012458695</td> -->
                <td><?=$request_result['request_type'];?></td>
                <td><?php
                    $request_date = date_create($request_result['request_date']);
                    echo date_format($request_date, "m-d-Y");
                ?></td>
                <td>
                    <p id="done_bg">
                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i><span class="ps-1 text-danger">Rejected</span>
                    </p>
                </td>
            </tr>

            <?php
            }                                  
        }
    }

#####################################
###### Reject request filter end
#####################################







if(!empty($_POST['class_info'])){
    $class = $_POST['class_info'];

    // $_SESSION['CLASS_CODE'] = $class;

    $class_sql = mysqli_query($conn, "SELECT * FROM  class WHERE class_id = '". $class ."'");
    if(mysqli_num_rows($class_sql) > 0){
        $class_info = mysqli_fetch_assoc($class_sql);
?>
    <input type="text" class="" disabled value="Degree: <?=$class_info['level_study'];?> / Year level: <?=$class_info['year_level'];?>">

<?php
    }else{
        echo 'No class';
    }                                     
}


if(!empty($_POST['semester_schedule']) && !empty($_POST['pre_class'])){
    $semester_schedule = $_POST['semester_schedule'];
    $class_id = $_POST['pre_class'];

    $dep_qry = mysqli_query($conn, "SELECT * FROM class
                                    INNER JOIN major ON class.major_id = major.major_id 
                                    INNER jOIN department ON major.department_id = department.department_id 
                                    WHERE class.class_id ='". $class_id ."'");
    $dep_fetch = mysqli_fetch_assoc($dep_qry);

    $dep_id = $dep_fetch['department_id'];
    $major_id = $dep_fetch['major_id'];


    $query_schedule = mysqli_query($conn, "SELECT * FROM schedule_study
                                            INNER JOIN class ON schedule_study.class_id = class.class_id
                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                            WHERE schedule_study.class_id ='". $class_id ."'
                                            AND schedule_study.year_semester_id = '". $semester_schedule."'
                                            ");

    if(mysqli_num_rows($query_schedule) > 0){
        $schedule_result = mysqli_fetch_assoc($query_schedule);
?>
    <div class="preview__schedule mt-4">
        <p class="mb-2"><i class="fa fa-list" aria-hidden="true"></i> Preview Schedule</p>
        <div class="bg-white text-black rounded px-2 mb-2" style="width: fit-content;">
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
                                            WHERE schedule_study.class_id ='". $class_id ."'
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                            <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$monday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                        <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$tuesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                        <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                            <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                        <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        
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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                        <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

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
                                            WHERE schedule_study.class_id ='". $class_id ."' 
                                            AND schedule_study.year_semester_id = '". $semester_schedule ."'

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
                                        <a class="btn btn-sm btn-secondary" style="font-size: 10px;" href="<?=SITEURL;?>add-schedule.php?sch=<?=$wednesday['schedule_id'];?>&dep=<?=$dep_id?>&maj=<?=$major_id;?>&class=<?=$class_id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

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


    <a class="btn__addschedule btn" href="<?=SITEURL;?>schedule-action.php?semester=<?=$schedule_result['year_semester_id'];?>&class=<?=$schedule_result['class_id'];?>&q=<?=$schedule_result['major_id'];?>"><i class="fa fa-check-circle" aria-hidden="true"></i>Done add</a>
</div>
       
<?php
                   
    }

}





if(!empty($_POST['user'])){
    $select_role = mysqli_query($conn, "SELECT * FROM users WHERE id = '". $_POST['user'] ."'");
    $select_role_data = mysqli_fetch_assoc($select_role);

    $role_arr = explode(',', $select_role_data['role']);
    $admin = '';
    $officer = '';
    foreach($role_arr as $role_arr){
        // echo $role;
        // if($role == 'admin'){
        if($role_arr == 'admin'){
            $admin = 'admin';
        }elseif($role_arr == 'officer'){
            $officer = 'officer';
        }
    }


    ?>
    <div class="d-flex">
        <span class="me-4" style="width: 17px;">1.</span>
        <input type="checkbox" name="role[]" id="admin" <?php
            // foreach($role_arr as $role_arr){
                if($admin == 'admin') echo 'checked';
            // }
        ?> value="admin" > 
        <label for="admin">Admin</label>
    </div>


    <div class="d-flex">
        <span class="me-4" style="width: 17px;">2.</span>
        <input type="checkbox" name="role[]" id="officer" 
        <?php
            //  foreach($role_arr as $role_arr){
                if($officer == 'officer') echo 'checked';
            // }
        ?>
        value="officer">
        <label for="officer">Officer</label>
    </div>

    <?php
    
}


if(!empty($_POST['academy_year'])){
    // echo 'Hello world';
    $academy_year = mysqli_real_escape_string($conn, $_POST['academy_year']);

    $inc = 1;
    $class_query = mysqli_query($conn, "SELECT * FROM class 
                                INNER JOIN major ON class.major_id = major.major_id
                                WHERE class.year_of_study = '".$academy_year."'");
    if(mysqli_num_rows($class_query) > 0){
        while($result = mysqli_fetch_assoc($class_query)){

    ?>

    <tr>
        <td class="text-center id"><?=$inc++;?></td>
        <td class="table-width-50" style="width: 40px;"><span class="bg-warning rounded-pill px-1" ><?=$result['class_code'];?></span></td>
        <td class="table-width-500"><?=$result['major'];?></td>
        <td style="width: 20px;"><?=$result['level_study'];?></td>
        <td class="table-width-50" style="width: 70px;"><?=$result['year_level'];?></td>
        <td class="table-width-50" style="width: 70px;"><?=$result['year_of_study'];?></td>
        <td class="text-center" style="width: 20px;">
            <!-- <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['class_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['class_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a> -->

            <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['class_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['class_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>
    </tr>
      
    <?php
        }
    }else{
        echo '<tr>';
                                            
            echo ' <td colspan="7" class="text-center">Class not found.</td>';

        echo '</tr>';
    }
}


if(!empty($_POST['semester_academy_year'])){
    $year = $_POST['semester_academy_year'];
    $inc = 1;
    $class = mysqli_query($conn, "SELECT * FROM year_of_study 
                                -- INNER JOIN major ON class.major_id = major.major_id
                                WHERE year_of_study ='".$year."'");
    if(mysqli_num_rows($class) > 0){
        while($result = mysqli_fetch_assoc($class)){
    ?>
        <tr>
            <td class="text-center id"><?=$inc++;?></td>
            <td>Semester <?=$result['semester'];?></td>
            <td class="table-width-500">
                <?php
                    $startSemester = date_create($result['start_semester']);
                    echo date_format($startSemester, "d-m-Y");
                    
                ?>
            </td>
            <td>
                <?php
                    $finishSemester = date_create($result['finish_semester']);
                    echo date_format($finishSemester, "d-m-Y");
                ?>
            </td>
            <td class="table-width-50"><?=$result['year_of_study'];?></td>
            <td class="table-width-50 text-center">
                <?php 
                    if($result['status'] == '0'){
                        echo '<p class="text-center text-success"><i class="fa fa-check-circle text-success" aria-hidden="true"></i> Done</p>';
                    }else{
                        echo '<p class="text-center text-warning"><i class="fa fa-spinner text-warning" aria-hidden="true"></i> Process</p>';
                    }
                ?>
            </td>
            
            <td class="text-center">
                <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['year_semester_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['year_semester_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
        </tr>        
                                
    <!-- Update form pop up  -->
    <!-- <div class="modal fade" id="update_<?=$result['year_semester_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$result['year_semester_id'];?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_<?=$result['year_semester_id'];?>">Edit semester</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <div class="modal-body fs-small">
                    <?php
                        if(isset($_SESSION['REQUIRED'])){
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$_SESSION['REQUIRED'];?>
                    </div>
                    <?php
                        }
                        unset($_SESSION['REQUIRED']);
                    ?>

                    <form action="master-action.php" method="post">
                        <input type="hidden" name="update_id" value="<?=$result['year_semester_id'];?>">
                        <label for="semester">Semester <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="semester" id="semester" min ="0" placeholder="Class code..." value="<?=$result['semester'];?>">
                        <label for="start_semester">Start semester <span class="text-danger">*</span></label>
                        <input type="date"  class="form-control" name="start_semester" id="start_semester" value="<?=$result['start_semester'];?>">

                        <label for="finish_semester">Start semester <span class="text-danger">*</span></label>
                        <input type="date"  class="form-control" name="finish_semester" id="finish_semester" value="<?=$result['finish_semester'];?>">
                        <button class="btn btn-primary btn-sm save d-block mt-3 ms-auto" type="submit" name="edit_semester">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div> -->



    <!-- delete class pop up  -->
    <!-- <div class="modal fade" id="delete_<?=$result['year_semester_id'];?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-labelledby="delete_<?=$result['year_semester_id'];?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalToggleLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p>Do you want to delete semester?</p>

                <form action="master-action.php" method="post">
                    <input type="hidden" name="delete_id" value="<?=$result['year_semester_id'];?>">
                    <button class="btn btn-primary btn-sm px-3 save mt-3 d-block" style="margin-left: auto;" name="delete_semester">Ok</button>
                </form>
                </div>
                
            </div>
        </div>
    </div> -->

    <?php
        }
    }else{
        echo '<tr>';
                                            
            echo ' <td colspan="7" class="text-center">Semester not found.</td>';

        echo '</tr>';
    }
}



if(!empty($_POST['year_filter']) && !empty($_POST['major_id'])){
    
    $year = $_POST['year_filter'];
    $major_id = $_POST['major_id'];

    echo '<div class="flex__container">';

        $class_qry = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."' AND year_of_study = '". $year ."'");
        if(mysqli_num_rows($class_qry) > 0){
            while($class_fetch = mysqli_fetch_assoc($class_qry)){
    ?>

        <a href="<?=SITEURL;?>class.php?class=<?=$class_fetch['class_id'];?>&major=<?=$major_id;?>" class="class__item">
            <div>
                <p>Class code: <b><?=$class_fetch['class_code'];?></b></p>
                <p>Degree: <b><?=$class_fetch['level_study'];?></b></p>
                <p>Year level: <b><?=$class_fetch['year_level'];?></b></p>
                <p>Academy year: <b><?=$class_fetch['year_of_study'];?></b></p>
            </div>
        </a>

        <?php
            }
        }else{
            echo 'No class found.';
        }

    echo '</div>';

    mysqli_free_result($class_qry);
}



// semester each year 
if(!empty($_POST['academy_year_filter'])){
    $year = $_POST['academy_year_filter'];

    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $year ."'");
    if(mysqli_num_rows($semester) > 0){
        echo '<option disabled selected>Semester</option>';
        while($semester_data = mysqli_fetch_assoc($semester)){
?>
    <option value="<?=$semester_data['year_semester_id'];?>">Semester <?=$semester_data['semester'];?></option>                                        

<?php
        }
    }else{
        echo '<option disabled selected>No semester</option>';
    }

    mysqli_free_result($semester);
}

// filter scheudule in each class 
if(!empty($_POST['semester_filter']) && !empty($_POST['class_filter']) && !empty($_POST['major_id'])){
    $semester_id = $_POST['semester_filter'];
    $class_id = $_POST['class_filter'];
    $major_id = $_POST['major_id'];
?>
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
                                    AND schedule_study.done_status = '1'
                                    AND  class_id = '".$class_id."' 
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
                            
<?php

}
###############################################
## SCORE SUBMITTED FILTER
###############################################


/*
if(!empty($_POST['score__filter'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__filter']);

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        WHERE score_submitted.teacher_submit LIKE '%$filter%'
                                        OR teacher_info.fn_khmer LIKE '%$filter%' 
                                        OR teacher_info.ln_khmer LIKE '%$filter%'
                                        OR teacher_info.fn_en LIKE '%$filter%'
                                        OR teacher_info.ln_en LIKE '%$filter%'
                                        ");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>


                    <td><?=$data['submit_date'];?></td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-download fs-6 d-block pe-2" aria-hidden="true"></i> Accept</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
<?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}

if(isset($_POST['score__filter']) && $_POST['score__filter'] == ''){
    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        ORDER BY score_submitted.submit_date DESC ");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>


                    <td><?=$data['submit_date'];?></td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-download fs-6 d-block pe-2" aria-hidden="true"></i> Accept</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo "<p>No score submitted.</p>";
    }
}
*/



// filter by semester 
if(!empty($_POST['score__filter__semester'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__filter__semester']);

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE schedule_study.year_semester_id ='". $filter ."' AND score_submitted.submit_status = '0'");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}

    // filter by semester and input field 
if(!empty($_POST['score__filter']) && !empty($_POST['semester_filter'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__filter']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    // echo $filter; echo '<br>';
    // echo $semester;

    // exit;

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE schedule_study.year_semester_id = '". $semester ."'
                                        AND score_submitted.submit_status = '0'
                                        AND score_submitted.teacher_submit LIKE '%$filter%'
                                        OR teacher_info.fn_khmer LIKE '%$filter%' 
                                        OR teacher_info.ln_khmer LIKE '%$filter%'
                                        OR teacher_info.fn_en LIKE '%$filter%'
                                        OR teacher_info.ln_en LIKE '%$filter%'");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}


if(isset($_POST['score__filter']) && $_POST['score__filter'] == '' && !empty($_POST['semester_filter'])){
    $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE schedule_study.year_semester_id = '". $semester ."' AND score_submitted.submit_status = '0' ORDER BY score_submitted.submit_date DESC");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo "<p>No score submitted.</p>";
    }
}


// filter by input field 
if(!empty($_POST['score__filter'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__filter']);
    // $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    // echo $filter; echo '<br>';
    // echo $semester;

    // exit;

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE score_submitted.teacher_submit LIKE '%$filter%'
                                        AND score_submitted.submit_status = '0'
                                        OR teacher_info.fn_khmer LIKE '%$filter%' 
                                        OR teacher_info.ln_khmer LIKE '%$filter%'
                                        OR teacher_info.fn_en LIKE '%$filter%'
                                        OR teacher_info.ln_en LIKE '%$filter%'");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}

if(isset($_POST['score__filter']) && ($_POST['score__filter']) == ''){
    // $filter = mysqli_real_escape_string($conn, $_POST['score__accept__filter']);

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE score_submitted.submit_status = '0'
                                        ORDER BY score_submitted.submit_date DESC");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}







###############################################
## SCORE ACCEPTED FILTER
###############################################
    // filter by semester 
if(!empty($_POST['score__accept__filter__semester'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__accept__filter__semester']);

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE schedule_study.year_semester_id ='". $filter ."'
                                        AND score_submitted.submit_status = '2'
                                        ");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}



    // filter by semester and input field 
if(!empty($_POST['score__accept__filter']) && !empty($_POST['semester_filter'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__accept__filter']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    // echo $filter; echo '<br>';
    // echo $semester;

    // exit;

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE schedule_study.year_semester_id = '". $semester ."'
                                        AND score_submitted.teacher_submit LIKE '%$filter%'
                                        OR teacher_info.fn_khmer LIKE '%$filter%' 
                                        OR teacher_info.ln_khmer LIKE '%$filter%'
                                        OR teacher_info.fn_en LIKE '%$filter%'
                                        OR teacher_info.ln_en LIKE '%$filter%'                                     
                                        AND score_submitted.submit_status = '2'
                                        ");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}

if(isset($_POST['score__accept__filter']) && $_POST['score__accept__filter'] == '' && !empty($_POST['semester_filter'])){
    $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE score_submitted.submit_status = '2' AND  schedule_study.year_semester_id = '". $semester ."' ORDER BY score_submitted.submit_date DESC");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo "<p>No score submitted.</p>";
    }
}


// filter by input field 
if(!empty($_POST['score__accept__filter'])){
    $filter = mysqli_real_escape_string($conn, $_POST['score__accept__filter']);
    // $semester = mysqli_real_escape_string($conn, $_POST['semester_filter']);
    // echo $filter; echo '<br>';
    // echo $semester;

    // exit;

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE score_submitted.teacher_submit LIKE '%$filter%'
                                        AND score_submitted.submit_status = '2'
                                        OR teacher_info.fn_khmer LIKE '%$filter%' 
                                        OR teacher_info.ln_khmer LIKE '%$filter%'
                                        OR teacher_info.fn_en LIKE '%$filter%'
                                        OR teacher_info.ln_en LIKE '%$filter%'");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}

if(isset($_POST['score__accept__filter']) && ($_POST['score__accept__filter']) == ''){
    // $filter = mysqli_real_escape_string($conn, $_POST['score__accept__filter']);

    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                        WHERE score_submitted.submit_status = '2'
                                        ORDER BY score_submitted.submit_date DESC");
    if(mysqli_num_rows($submit_score) > 0){
    ?>
        <table>
            <thead>
                <tr>
                    <th class="no text-center">#</th>
                    <th>Teacher ID</th>
                    <th>Teacher name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <!-- <th>Phone number</th> -->
                    <th>Submit date</th>
                    <!-- <th>Request date</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while($data = mysqli_fetch_assoc($submit_score)){
                        // print_r($data);
                ?>
                <tr>
                    <td class="no text-center"><?=$i++;?></td>
                    <td><?=$data['teacher_submit'];?></td>
                    <td><?=$data['fn_en']. " " . $data['ln_en'];?></td>

                    <td><?=$data['subject_name'];?></td>

                    <!-- <td>012458695</td> -->
                    <td>Semester <?=$data['semester'];?></td>
                    <td><?=$data['class_code'];?></td>


                    <td>
                        <?php
                            $submit_date = date_create($data['submit_date']);
                            echo date_format($submit_date, "d-m-Y");
                        ?>
                    </td>
                    <td>
                        <a href="<?=SITEURL;?>score-detail.php?subject=<?=$data['schedule_id'];?>" class="detail"><i class="fa fa-eye fs-6 d-block pe-2" aria-hidden="true"></i> View</a>
                        <!-- <a href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a class="delete" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                    </td>
                </tr>
                <?php
                    }
                ?>                          
            </tbody>
        </table>
    <?php
    }else{
        echo '<p>No record found.</p>';
    }
    
}








if(!empty($_POST['class_selected'])){
    $class_id = mysqli_real_escape_string($conn, $_POST['class_selected']);
    $class_info = mysqli_query($conn, "SELECT * FROM class
                                        INNER JOIN major ON class.major_id = major.major_id
                                        INNER JOIN department ON major.department_id = department.department_id

                                        WHERE class_id ='". $class_id ."'");
    if(mysqli_num_rows($class_info) > 0){
        $class_data = mysqli_fetch_assoc($class_info);
    ?>
    <small class="class_info_content">
        <span class="title"><i class="fa fa-info-circle" aria-hidden="true"></i>Class information</span>
        <div class="grid">
            <span>Class code</span> <span>:</span>  <span class="value"><?=$class_data['class_code'];?></span>
            <span>Department</span> <span>:</span>  <span class="value"><?=$class_data['department'];?></span>
            <span>Major</span> <span>:</span>  <span class="value"><?=$class_data['major'];?></span>
            <span>Degree</span> <span>:</span>  <span class="value"><?=$class_data['level_study'];?></span>
            <span>Year level</span> <span>:</span>  <span class="value">ឆ្នាំទី <?=$class_data['year_level'];?></span>
            <span>Start academy year</span>  <span>:</span> <span class="value">ឆ្នាំ <?=$class_data['year_of_study'];?></span>
            
        </div>
    </small>
    <?php
        }
}


######################
// ADD SCHEDULE FILTER SEMESTER BY ACADEMY YEAR 
######################
if(!empty($_POST['academy_year_schedule'])){

    $academy_year_schedule = mysqli_real_escape_string($conn, $_POST['academy_year_schedule']);

    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $academy_year_schedule . "'");
    if(mysqli_num_rows($semester) > 0){
        echo '<option selected disabled>Please select semester</option>';

        while($result = mysqli_fetch_assoc($semester)){
?>            
            <option class="<?php echo ($result['status'] == '0')? 'text-primary' : '';?>" value="<?=$result['year_semester_id'];?>">- Semester: <?=$result['semester'];?>  , Year: <?=$result['year_of_study'];?> <?php echo ($result['status'] == '0')? ' (Finished) ' : '';?></option>
<?php
        }
    }else{
        echo '<option value="">Semester not found.</option>';
    }
}

######################
// DUPLICATE SCHEDULE + CLASS FILTER BY SEMESTER 
######################
if(!empty($_POST['semester_duplicate'])){
    $semester_id = mysqli_real_escape_string($conn, $_POST['semester_duplicate']);
    $i = 1;
    // echo '<option value="">Semester not found.</option>';
    $class_qry = mysqli_query($conn, "SELECT * FROM class");
    if(mysqli_num_rows($class_qry) > 0){
        echo '<option disabled selected>Please select class.</option>';

        while($class_reuslt = mysqli_fetch_assoc($class_qry)){
            
            $class_check = mysqli_query($conn, "SELECT * FROM schedule_study
                                    -- INNER JOIN schedule_study ON class.class_id = schedule_study.class_id
                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                    WHERE schedule_study.year_semester_id = '". $semester_id ."'");
            if(mysqli_num_rows($class_check) > 0){
                // while($class_check_result = mysqli_fetch_assoc($class_check)){
                    if($class_check_result['class_code'] == $class_reuslt['class_code']){
                            echo '<option value="">'.$class_reuslt['class_code'].'</option>';
                    }else{
                        echo '<option disabled>Class has apllied schedule already.</option>';
                        break;
                    }
                // }
            }else{
                echo '<option value="'.$class_reuslt['class_id'].'">'.$i++.'. Class: '.$class_reuslt['class_code'].'</option>';
            }


            
        }

    }else{
        echo '<option disabled>No class created.</option>';
    }
}

if(!empty($_POST['instructor']) && !empty($_POST['semester_id'])){
    $teacher_id = $_POST['instructor'];
    $semester_id = $_POST['semester_id'];

    $semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id ='". $semester_id. "'");
    $semester_fetch = mysqli_fetch_assoc($semester);

    $teacher_qry = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id='". $teacher_id ."'");
    $teacher_qry_fetch = mysqli_fetch_assoc($teacher_qry);
    $teacher_name = $teacher_qry_fetch['fn_khmer'] . " " . $teacher_qry_fetch['ln_khmer'];


    ?>

    <p class="my-2 border-top mt-5 pt-4 mb-3"><i class="fa fa-calendar" aria-hidden="true"></i>Schedule for teacher <b class="text-primary"><?=$teacher_name;?></b> - Semester : <b class="text-primary"><?=$semester_fetch['semester'];?></b> - Ac.Year: <b class="text-primary"><?=$semester_fetch['year_of_study'];?></b></p>
    <?php
        $check_schedule = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                AND schedule_study.year_semester_id = '". $semester_id . "'
                                                AND schedule_study.done_status ='1'");
        if(mysqli_num_rows($check_schedule) > 0){
    ?>

    <div class="controll_part">
        <p class="fw-bold day">1. Monday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $Monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Monday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Monday) > 0){
                        while($Monday_fetch = mysqli_fetch_assoc($Monday)){
                ?>
                    <tr>
                        <td><?=$Monday_fetch['subject_code'];?> - <?=$Monday_fetch['subject_name'];?> - <?=$Monday_fetch['credit']."(". $Monday_fetch['theory'].".". $Monday_fetch['execute'].".". $Monday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Monday_fetch['class_code'];?></td>
                        <td><?=$Monday_fetch['start_time'] . " - ". $Monday_fetch['end_time'];?></td>
                        <td><?=$Monday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>

        <p class="fw-bold day">2. Tuesday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Monday);
                    $Tuesday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Tuesday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Tuesday) > 0){
                        while($Tuesday_fetch = mysqli_fetch_assoc($Tuesday)){
                ?>
                    <tr>
                        <td><?=$Tuesday_fetch['subject_code'];?> - <?=$Tuesday_fetch['subject_name'];?> - <?=$Tuesday_fetch['credit']."(". $Tuesday_fetch['theory'].".". $Tuesday_fetch['execute'].".". $Tuesday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Tuesday_fetch['class_code'];?></td>
                        <td><?=$Tuesday_fetch['start_time'] . " - ". $Tuesday_fetch['end_time'];?></td>
                        <td><?=$Tuesday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>


        <p class="fw-bold day">3. Wednesday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Tuesday);
                    $Wednesday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Wednesday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Wednesday) > 0){
                        while($Wednesday_fetch = mysqli_fetch_assoc($Wednesday)){
                ?>
                    <tr>
                        <td><?=$Wednesday_fetch['subject_code'];?> - <?=$Wednesday_fetch['subject_name'];?> - <?=$Wednesday_fetch['credit']."(". $Wednesday_fetch['theory'].".". $Wednesday_fetch['execute'].".". $Wednesday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Wednesday_fetch['class_code'];?></td>
                        <td><?=$Wednesday_fetch['start_time'] . " - ". $Wednesday_fetch['end_time'];?></td>
                        <td><?=$Wednesday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>


        <p class="fw-bold day">4. Thursday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Wednesday);
                    $Thursday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Thursday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Thursday) > 0){
                        while($Thursday_fetch = mysqli_fetch_assoc($Thursday)){
                ?>
                    <tr>
                        <td><?=$Thursday_fetch['subject_code'];?> - <?=$Thursday_fetch['subject_name'];?> - <?=$Thursday_fetch['credit']."(". $Thursday_fetch['theory'].".". $Thursday_fetch['execute'].".". $Thursday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Thursday_fetch['class_code'];?></td>
                        <td><?=$Thursday_fetch['start_time'] . " - ". $Thursday_fetch['end_time'];?></td>
                        <td><?=$Thursday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>



        <p class="fw-bold day">5. Friday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Thursday);
                    $Friday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Friday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Friday) > 0){
                        while($Friday_fetch = mysqli_fetch_assoc($Friday)){
                ?>
                    <tr>
                        <td><?=$Friday_fetch['subject_code'];?> - <?=$Friday_fetch['subject_name'];?> - <?=$Friday_fetch['credit']."(". $Friday_fetch['theory'].".". $Friday_fetch['execute'].".". $Friday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Friday_fetch['class_code'];?></td>
                        <td><?=$Friday_fetch['start_time'] . " - ". $Friday_fetch['end_time'];?></td>
                        <td><?=$Friday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>


        <p class="fw-bold day">6. Saturday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Friday);
                    $Saturday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Saturday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Saturday) > 0){
                        while($Saturday_fetch = mysqli_fetch_assoc($Saturday)){
                ?>
                    <tr>
                        <td><?=$Saturday_fetch['subject_code'];?> - <?=$Saturday_fetch['subject_name'];?> - <?=$Saturday_fetch['credit']."(". $Saturday_fetch['theory'].".". $Saturday_fetch['execute'].".". $Saturday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Saturday_fetch['class_code'];?></td>
                        <td><?=$Saturday_fetch['start_time'] . " - ". $Saturday_fetch['end_time'];?></td>
                        <td><?=$Saturday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>



        <p class="fw-bold day">7. Sunday</p>
        <div class="table_manage">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Start - End time</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    mysqli_free_result($Saturday);
                    $Sunday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    WHERE schedule_study.instructor_id ='". $teacher_id ."'
                                                    AND schedule_study.year_semester_id = '". $semester_id . "'
                                                    AND schedule_study.day = 'Sunday'
                                                    AND schedule_study.done_status ='1'");
                    if(mysqli_num_rows($Sunday) > 0){
                        while($Sunday_fetch = mysqli_fetch_assoc($Sunday)){
                ?>
                    <tr>
                        <td><?=$Sunday_fetch['subject_code'];?> - <?=$Sunday_fetch['subject_name'];?> - <?=$Sunday_fetch['credit']."(". $Sunday_fetch['theory'].".". $Sunday_fetch['execute'].".". $Sunday_fetch['apply'].")";?></td>
                        <td>Class: <?=$Sunday_fetch['class_code'];?></td>
                        <td><?=$Sunday_fetch['start_time'] . " - ". $Sunday_fetch['end_time'];?></td>
                        <td><?=$Sunday_fetch['room'];?></td>
                    </tr>
                <?php
                        }
                        mysqli_free_result($Sunday);
                    }
                ?>
                </tbody>
            </table>
        </div>
        
    </div>
    <?php
        }else{
            echo '<p class = "text-danger">Scheule has not applied.</p>';
        }
}


if(!empty($_POST['class_yearFilter']) && !empty($_POST['major_id']) && !empty($_POST['department_id'])){
    $acYear = mysqli_real_escape_string($conn, $_POST['class_yearFilter']);
    $department_id = mysqli_real_escape_string($conn, $_POST['department_id']);
    $major_id = mysqli_real_escape_string($conn, $_POST['major_id']);
    $class = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."' AND year_of_study = '". $acYear ."'");
    if(mysqli_num_rows($class) > 0){
        while($result = mysqli_fetch_assoc($class)){
    ?>
    <div class="major">
        <div class="part" style="width: 100%;">
            <!-- <p><small>Dep.</small> <b><?=$dep_fech['department'];?></b></p> -->
            <!-- <p><small>Maj.</small> <b><?=$maj_fetch['major'];?></b></p> -->
            <p><small>Class.</small> <b><?=$result['class_code'];?></b></p>
            <p><small>Degree.</small> <b><?=$result['level_study'];?></b> Year:  <b><?=$result['year_level'];?></b></p>
            <!-- <p><small>Year level.</small> <b><?=$result['year_level'];?></b></p> -->
            <p><small>Academy year.</small> <b><?=$result['year_of_study'];?></b></p>
            <div class="link__manage">
                <a class="text-center w-50" href="<?=SITEURL;?>add-schedule.php?dep=<?=$department_id;?>&maj=<?=$result['major_id'];?>&class=<?=$result['class_id'];?>"><i class="fa fa-plus" aria-hidden="true"></i> Add schedule</a>
                <a class="text-center w-50" href="<?=SITEURL;?>view-schedule.php?dep=<?=$department_id;?>&maj=<?=$result['major_id'];?>&class=<?=$result['class_id'];?>"><i class="fa fa-eye" aria-hidden="true"></i> View schedule</a>
            </div>
        </div>
        <!-- <div class="part" style="width: 20%;">
            <img width="100%" src="<?=SITEURL;?>ims-assets/ims-images/<?=$result['icon_name'];?>" alt="">
        </div> -->
    </div>
    <?php
            }
        }else{
    ?>
        <a href="<?=SITEURL;?>manage-class.php" class="mt-3 btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>Manage class</a>

    <?php
    }                 
}


mysqli_close($conn);
?>



