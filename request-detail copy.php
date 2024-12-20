<?php
    #DB connection

// use Mpdf\Tag\Em;

    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $back_page = '';
    if(!empty($_SERVER['HTTP_REFERER'])){
        $back_page = $_SERVER['HTTP_REFERER'];
    }else{
        $back_page = SITEURL."request.php";
    }



    $grade_total = '';
    if(isset($_GET['q'])){
        $q = $_GET['q'];
        $check_q = mysqli_query($conn, "SELECT * FROM student_info 
                                        INNER JOIN requests ON student_info.student_id = requests.student_id
                                        INNER JOIN class ON student_info.class_id = class.class_id
                                        INNER JOIN major ON class.major_id = major.major_id
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE requests.id = '". $q ."'");

        if(!mysqli_num_rows($check_q) >0){
            header("Location: ". SITEURL ."request.php");
            exit;
        }else{
            $data = mysqli_fetch_assoc($check_q);
            $student_id = $data['student_id'];
            $class_id = $data['class_id'];
            // print_r($data);
            // exit;
        }
    }

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

        <div id="main__content" >
           <div class="top__content_title">
                <h5 class="super__title">Request detail <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Request detail</p>
           </div>
           <div class="my-3">
                <a href="<?=$back_page;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>

           <div class="all__teacher request__control">  


            <?php
                if($data['request_status'] == '1' || ($data['request_status'] == '2' && $data['feedback'] == 'rejected') ){
                   echo '';
                }else{
            ?>
                <!-- <div class="button">
                    <div class="button__action" id="actions" onclick="alertActionList()">
                        <i class="fa fa-cog" aria-hidden="true"></i> Action
                    </div>
                </div> -->
            <?php
                }
            ?>
                



                <?php
                    if($data['request_status'] == '0'){
                ?>
                <div id="action__list">
                    <ul>
                        <!-- <li id="btn__feed" onclick="feedBackForm()"><i class="fa fa-reply" aria-hidden="true"></i>Feedback</li> -->
                        <?php
                            if($data['feedback'] == 'accepted'){
                        ?>
                            <li><a href="<?=SITEURL;?>request-action.php?done=<?=$q?>" class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>Request done</a></li>
                        <?php
                            }else{
                        ?>
                            <li><a href="<?=SITEURL;?>request-action.php?accept=<?=$q?>" class="text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>Accept</a></li>
                            <li><a href="<?=SITEURL;?>request-action.php?reject=<?=$q?>" class="text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i>Reject</a></li>

                        <?php
                            }
                        ?>
                    </ul>
                </div>
                <?php
                    }
                ?>
                
                
                <?php
                        $qry_string = '';
                        $pro_string = '';
                        $tran_string = '';
                        if(empty($_GET['profile']) && empty($_GET['transcript']) && empty($_GET['request'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = $qry_string;
                            $tran_string = $qry_string;
                        }                           
                        elseif(!empty($_GET['transcript'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = str_replace('&transcript='. $_GET['transcript'], '', $qry_string);
                            
                            // if(strpos($pro_string, '&profile='. $_GET['profile'])){
                            //     $pro_string = str_replace('&profile='. $_GET['profile'], '', $pro_string);
                            // }else{
                            //     $pro_string = $pro_string;
                            // }

                        }elseif(!empty($_GET['profile'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = str_replace('&profile='. $_GET['profile'], '', $qry_string);

                        }
                        elseif(!empty($_GET['request'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = str_replace('&request='. $_GET['request'], '', $qry_string);
 
                        }



                        if(!empty($_GET['profile'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $tran_string = str_replace('&profile='. $_GET['profile'], '', $qry_string);
                        }elseif(!empty($_GET['transcript'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $tran_string = str_replace('&transcript='. $_GET['transcript'], '', $qry_string);
                        }elseif(!empty($_GET['request'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $tran_string = str_replace('&request='. $_GET['request'], '', $qry_string);
 
                        }



                    ?>
                    <div class="btn__container">
                        <div class="left">
                            <a href="<?=SITEURL;?>request-detail.php?<?=$pro_string;?>&profile=<?=true;?>" class="<?php echo((empty($_GET['profile']) || isset($_GET['profile'])) && ((empty($_GET['transcript']))) && empty($_GET['request'])) ? 'active' : 'no-active'; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i>Information</a>
                            <a href="<?=SITEURL;?>request-detail.php?<?=$pro_string;?>&request=<?=true;?>" class="<?php echo(!empty($_GET['request'])) ? 'active' : 'no-active'; ?>"><i class="fa fa-eye" aria-hidden="true"></i>History</a>
                            <a href="<?=SITEURL;?>request-detail.php?<?=$tran_string;?>&transcript=<?=true;?>" class="<?php echo(!empty($_GET['transcript'])) ? 'active' : 'no-active'; ?>"><i class="fa fa-eye" aria-hidden="true"></i>Transcript</a>
                        </div>
                        <?php
                            if(!empty($_GET['transcript'])){
                                $student_info = mysqli_query($conn, "SELECT id, student_id FROM student_info WHERE student_id ='". $student_id."'");
                                if(mysqli_num_rows($student_info) > 0){
                                    $student_info_fetch = mysqli_fetch_assoc($student_info);
                                }
                        ?>
                        <div class="right">
                            <!-- <a href="<?=SITEURL;?>class-pdf.php?id=<?=$student_info_fetch['id'];?>" target="_blank" class="export"><i class="fa fa-upload" aria-hidden="true"></i>Export</a> -->
                            <!-- <a href="<?=SITEURL;?>transcript-export.php?id=<?=$student_info_fetch['id'];?>" target="_blank" class="export"><i class="fa fa-upload" aria-hidden="true"></i>Export</a> -->
                            <a type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="export"><i class="fa fa-upload" aria-hidden="true"></i>Export</a>
                        </div>
                        <?php
                            }
                        ?>
                        
                    </div>
                    <hr>



                <?php
                    if(empty($_GET['profile']) && empty($_GET['request']) && empty($_GET['transcript']) || !empty($_GET['profile'])){
                ?>
               
                    <div class="detail__request">
                        
                        <!-- <h5 class="fs-5"><i class="fa fa-info-circle" aria-hidden="true"></i>Short information</h5> -->
                        
                        <div id="request_short_info">
                            <p><img src="<?=SITEURL;?>ims-assets/ims-images/<?=$data['profile_image'];?>" alt=""></p>

                            <div class="information">
                                <p>Stuent ID</p> <p>:</p><p class="fw-bold"><?=$data['student_id'];?></p>
                                <p>Student name</p> <p>:</p> <p class="fw-bold"><?=$data['fn_khmer']. " " .$data['ln_khmer'];?> - <span class="text-uppercase"><?=$data['firstname']. " " .$data['lastname'];?></span></p>
                                <p>Gender</p> <p>:</p> <p class="fw-bold "><?=ucfirst($data['gender']);?></p>
                                <p>Date of birth</p> <p>:</p> <p class="fw-bold "><?php $std_bd = date_create($data['birth_date']); echo date_format($std_bd, 'd-m-Y');?></p>
                                <p>Department</p> <p>:</p> <p class="fw-bold"><?=$data['department'];?></p>
                                <p>Major</p> <p>:</p><p class="fw-bold"><?=$data['major'];?></p>
                                <p>Degree</p> <p>:</p> <p class="fw-bold"><?=$data['level_study'];?> - ឆ្នាំទី <?=$data['year_level'];?></p>
                                <p>Current address</p> <p>:</p><p class="fw-bold"><?=$data['current_place'];?></p>
                                <p>Phone</p> <p>:</p><p class="fw-bold"><?=$data['phone_number'];?></p>

                            </div>
                        </div>
                        
                        

                        <h5 class="mt-4">Request document on <?php
                            $date_request = date_create($data['request_date']);
                            echo date_format($date_request, "d-m-Y");?></h5>


                        <!-- <h5>Purpose</h5>
                        <p><=$data['purpose'];?></p> -->
                        
                        <div class="d-block">
                            <?php
                                $type = explode(",", $data['request_type']);
                                foreach($type as $type){
                            ?>
                                <p class="document"><i class="fa fa-toggle-on" aria-hidden="true"></i><?=$type;?></p>
                            
                            <?php
                                }
                            ?>
                        </div>
                        <p class="mt-2 date">Request on: <?php
                            $date_request = date_create($data['request_date']);
                            echo date_format($date_request, "d-m-Y");?>
                        </p>
                        <p class="mt-3">
                            <?php
                                if($data['feedback'] == 'accepted'){
                            ?>
                                <a href="<?=SITEURL;?>request-action.php?done=<?=$q?>" class="btn btn-sm btn-primary me-2"><i class="fa fa-check-circle" aria-hidden="true"></i>Done</a>

                            <?php
                                }else{
                                    if($data['request_status'] == '0'){
                            ?>
                                <a href="<?=SITEURL;?>request-action.php?accept=<?=$q?>" class="btn btn-sm btn-success me-2"><i class="fa fa-check-circle-o" aria-hidden="true"></i>Accept</a>
                                <a href="<?=SITEURL;?>request-action.php?reject=<?=$q?>" class="btn btn-sm btn-danger"><i class="fa fa-times-circle-o" aria-hidden="true"></i>Reject</a>

                            <?php
                                    }elseif($data['request_status'] == '1' || ($data['request_status'] == '2' && $data['feedback'] == 'rejected') ){
                                        // echo 'Hi';
                                    }
                                }
                            ?>


                        </p>

                         
                        <?php
                            if($data['feedback'] != ''){
                        ?>

                        <div class="noted">
                            <h6><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Noted</h6>
                            <div class="px-4">
                                <?php
                                    if($data['request_status'] == '1'){
                                ?>
                                <p><span><i class="fa fa-reply" aria-hidden="true"></i></span> <span class="text-success fst-italic fw-bold">Request done</span></p>
                                <?php
                                    }else{
                                ?>
                                <p><span><i class="fa fa-reply" aria-hidden="true"></i></span> <span class="<?php
                                    if($data['feedback'] == 'accepted') echo 'text-success';
                                    else echo 'text-danger';
                                ?> fst-italic fw-bold"><?=ucfirst($data['feedback']);?></span></p>
                                <?php
                                    }
                                ?>
                                

                                <p><span><i class="fa fa-comment" aria-hidden="true"></i></span> <span class="fst-italic"><?=$data['comment'];?></span></p>

                            </div>
                        </div>
                    
                        <div class="mt-4" id="comment">
                            <h5>Add a feedback</h5>
                            <div class="form" id="form_show">
                                <form action="<?=SITEURL;?>request-action.php" method="post">
                                    <input type="hidden" class="d-none" name="id" value="<?=$q;?>">
                                    <div class="comment__content">
                                        <textarea name="comment" id="comment" rows="3" placeholder="Write your feedback..."></textarea>
                                        <button type="submit" name="feedback"><i class="fa fa-paper-plane" aria-hidden="true"></i>Go</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        
                    
                        

                    </div>

                <?php
                    }
                    if(!empty($_GET['transcript'])){
                ?>

                

    <!-- ############################################
    ##### Study background shouldn't show
    ############################################ -->

                    <!-- <div class="border-top mt-3 pt-3 d-flex" style="align-items: center;">
                        <p class="me-3">Export :</p> 
                        <div class="action__button">                  
                            <a href="<?=SITEURL;?>class-pdf.php?info-id=<?=$id;?>" target="_blank" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Personal info</a>
                            <div class="border"></div>
                            
                            <a href="<?=SITEURL;?>class-pdf.php?id=<?=$student_info_fetch['id'];?>" target="_blank" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Transcript</a>
                        </div>
                    </div> -->
                    <?php
                        $student_info = mysqli_query($conn, "SELECT * FROM student_info 
                                                            INNER JOIN class ON student_info.class_id = class.class_id
                                                            INNER JOIN major ON class.major_id = major.major_id
                                                            INNER JOIN department ON major.department_id = department.department_id
                                                            WHERE student_id ='". $student_id."'");
                        if(mysqli_num_rows($student_info) > 0){
                            $student_info_fetch = mysqli_fetch_assoc($student_info);
                        }
                    ?>
                    
                    <div id="transcript_request">
                        <!-- <h5 class="fs-5"><i class="fa fa-id-card" aria-hidden="true"></i>Transcript</h5> -->
                        <div id="transcript__header">
                            <div class="part">
                                <p>Student ID</p> <p>:</p> <p><?=$student_info_fetch['student_id'];?></p>
                                <p>Student Name</p> <p>:</p> <p><?=ucwords($student_info_fetch['firstname']. " ". $student_info_fetch['lastname']);?></p>
                                <p>Date Of Birth</p> <p>:</p> <p><?php $std_bd = date_create($student_info_fetch['birth_date']); echo date_format($std_bd, 'd-M-Y')?></p>
                            </div>
                            <div class="part">
                                <p>Department</p> <p>:</p> <p><?=ucwords($student_info_fetch['department']);?></p>
                                <p>Major</p> <p>:</p> <p><?=ucwords($student_info_fetch['major']);?></p>
                                <p>Degree</p> <p>:</p> <p><?=ucwords($student_info_fetch['level_study']);?></p>
                            </div>
                        </div>


                        <!-- transcript content  -->

                        <?php
                            if($student_info_fetch['level_study'] == "Associate Degree"){
                        ?>
                            <!-- ASSOCIATED'S DEGREE START -->
                                <div class="manager">                  
                                    <!-- 1 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">1<sup>st</sup> Semester, 1<sup>st</sup> Year</h6>
                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '1' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '1'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                    </div>


                                    <!-- 2 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">2<sup>nd</sup> Semester, 1<sup>st</sup> Year</h6>
                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '1' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '2'
                                                                                                        AND schedule_study.done_status = '1'");


                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                    </div>

                                </div>

                                
                                <div class="manager">
                                    <!-- 3 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">1<sup>st</sup> Semester, 2<sup>nd</sup> Year</h6>
                                        

                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '2' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '1'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>



                                    </div>

                                    <!-- 4 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">2<sup>nd</sup> Semester, 2<sup>nd</sup> Year</h6>

                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '2' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '2'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>

                                    </div>
                                </div>
                            <!-- ASSOCIATED'S DEGREE END -->
                        <?php
                            }elseif($student_info_fetch['level_study'] == "Bachelor's Degree"){
                        ?>

                            <!-- BACHELOR'S DEGREE START  -->
                                <div class="manager">
                                    <!-- 5 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">1<sup>st</sup> Semester, 3<sup>rd</sup> Year</h6>

                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '3' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '1'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                        
                                    </div>




                                    <!-- 6 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">2<sup>nd</sup> Semester, 3<sup>rd</sup> Year</h6>

                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '3' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '2'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                    </div>
                                </div>


                                <div class="manager">
                                    <!-- 7 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">1<sup>st</sup> Semester, 4<sup>th</sup> Year</h6>
                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '4' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '1'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                    </div>

                                    <!-- 8 -->
                                    <div class="transcript__content">
                                        <h6 class="fw-bold">2<sup>nd</sup> Semester, 4<sup>th</sup> Year</h6>

                                        <div class="table_manage">
                                            <table>
                                                <!-- <thead>
                                                    <tr>
                                                        <th>Subject Code</th>
                                                        <th>Subject Name</th>
                                                        <th>Credit</th>
                                                        <th class="last">Grade</th>
                                                    </tr>
                                                </thead> -->
                                                <tbody>
                                                    <?php
                                                        $total = 0;
                                                        $count_n = 1;
                                                        $grade_total = '';
                                                        // $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                        //                                                 INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        //                                                 INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        //                                                 WHERE schedule_study.year_level = '1' 
                                                        //                                                 AND schedule_study.class_id ='". $class_id ."'
                                                        //                                                 AND year_of_study.semester = '2'
                                                        //                                                 AND schedule_study.done_status = '1'");

                                                        $first_semester_year = mysqli_query($conn, "SELECT DISTINCT schedule_study.subject_code,
                                                                                                        schedule_study.year_semester_id,
                                                                                                        -- schedule_study.schedule_id,
                                                                                                        
                                                                                                        course.subject_code,
                                                                                                        course.subject_name,
                                                                                                        course.credit,
                                                                                                        course.theory,
                                                                                                        course.execute,
                                                                                                        course.apply,
                                                                                                        course.subject_type,

                                                                                                        subject_type.type_name

                                                                                                        FROM schedule_study 
                                                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                        WHERE schedule_study.year_level = '4' 
                                                                                                        AND schedule_study.class_id ='". $class_id ."'
                                                                                                        AND year_of_study.semester = '2'
                                                                                                        AND schedule_study.done_status = '1'");



                                                                                                        
                                                        if(mysqli_num_rows($first_semester_year) > 0){
                                                            $count_n = mysqli_num_rows($first_semester_year);

                                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                                $subject_code = $result_data['subject_code'];

                                                                $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                                                $result_data = mysqli_fetch_assoc($subjectQry);
                                                                $subject_type = $result_data['type_name'];

                                                    ?>
                                                    <tr>
                                                        <td><?=$result_data['subject_code'];?></td>
                                                        <td><?=$result_data['subject_name'];?></td>
                                                        <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                        <td class="last">
                                                            <?php
                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");

                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            echo $grade_data['s_u'];
                                                                        }else{

                                                                            $grade_total = $grade_data['grade'];
                                                                            echo $grade_total;
                                                                        }
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                if($grade_total == 'F' || $grade_total == ''){
                                                                    echo '<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>    
                                                    
                                                    <?php
                                                            $total += $result_data['credit'];
                                                            }
                                                        }
                                                    ?>
                                                                                
                                                </tbody>
                                            </table>                
                                        </div>
                                        <div class="total__marks mt-3">
                                            <p class="text-bold">Total</p>
                                            <p>Credit : </p> <span><?=$total;?></span>
                                            <p>GPA : </p> <span> <?php echo ($total / $count_n);?></span>
                                            <!-- <p>Grade :</p><span> B</span> -->
                                        </div>
                                    </div>
                                </div>
                            <!-- BACHELOR'S DEGREE END  -->
                        
                        <?php
                            }
                        ?>

                        <!-- transcript content  -->

                    </div>


    <!-- ############################################
    ##### Study background shouldn't show
    ############################################ -->

                <?php
                    }
                    if(!empty($_GET['request'])){

                ?>

                    
                    <div id="transcript_request" >
                        <h5 class="fs-5"><i class="fa fa-file-text" aria-hidden="true"></i>Request history</h5>

                        <div class="table_manage">
                            <table id="request_his_table">
                                <tr>
                                    <th style="width: 13px;" class="text-center">No.</th>
                                    <th class="text-center">លិ.បញ្ញាក់ការសិក្សា</th>
                                    <th class="text-center">ប្រតិបត្តិពិន្ទុ</th>
                                    <th class="text-center">ស.បណ្តោះអាសន្ន</th>
                                    <th class="text-center">Request date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                <?php
                                    $i = 1;
                                    $request_history = mysqli_query($conn, "SELECT * FROM requests WHERE student_id ='". $student_id ."' AND request_status != '0' ORDER BY request_date DESC");
                                    while($request_result = mysqli_fetch_assoc($request_history)){
                                ?>
                                
                                <tr>
                                    <td style="width: 13px;" class="text-center"><?=$i++;?></td>
                                    <td class="text-center"><?php
                                        $document_type = explode(',', $request_result['request_type']);
                                        foreach($document_type as $document){
                                            if($document == 'លិខិតបញ្ជាក់ការសិក្សា'){
                                                echo '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                                            }
                                        }
                                    ?></td>

                                    <td class="text-center"><?php
                                        $document_type = explode(',', $request_result['request_type']);
                                        foreach($document_type as $document){
                                            if($document == 'ប្រតិបត្តិពិន្ទុ'){
                                                echo '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                                            }
                                        }
                                    ?></td>

                                    <td class="text-center"><?php
                                        $document_type = explode(',', $request_result['request_type']);
                                        foreach($document_type as $document){
                                            if($document == 'សញ្ញាបត្របណ្តោះអាសន្ន'){
                                                echo '<i class="fa fa-check text-success" aria-hidden="true"></i>';
                                            }
                                        }
                                    ?></td>
                                    <td class="text-center"><?php
                                        $request_date = date_create($request_result['request_date']);
                                        echo date_format($request_date, 'd-m-Y');
                                    ?></td>
                                    <td class="text-center"><?php
                                        if($request_result['request_status'] == '1'){
                                            echo '<span class="status success"><i class="fa fa-check-circle" aria-hidden="true"></i> Done</span>';
                                        }else{
                                            echo '<span class="status danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Rejected</span>';

                                        }
                                    ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </div>

                <?php
                    }
                ?>

           </div>

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>




    <div id="feed__back__form">
        <div class="form" id="form_show">
            <form action="<?=SITEURL;?>request-action.php" method="post">
                <h5>Feedback.</h5>
                <input type="text" class="" name="q" value="<?=$q;?>">
                <input type="text" class="" name="id" value="<?=$data['id'];?>">
                <label for="status">Status <span class="text-danger">*</span></label>
                <input type="text" name="status" id="status" placeholder="Enter request status..." required>
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" rows="4" placeholder="Write your comment..."></textarea>
                <div class="d-flex manage__button">
                    <button type="submit" name="submit">Go</button>
                    <button type="button" onclick="feedBackForm()">Close</button>
                </div>
            </form>
        </div>
    </div>




    <!-- add member done  -->
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
                <a href="<?=SITEURL;?>request-detail.php?<?=$_SERVER['QUERY_STRING'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE']);

        if(isset($_SESSION['ADD_NOT_DONE'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_NOT_DONE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>request-detail.php?<?=$_SERVER['QUERY_STRING'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_NOT_DONE']);
    ?>



    <!-- add class model Start -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-upload" aria-hidden="true"></i>Export Transcript</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <div class="modal-body fs-small text-center">
                    <p class="fw-bold mb-2">Select degree to export:</p>

                    <p><a href="<?=SITEURL;?>transcript-export.php?id=<?=$student_info_fetch['id'];?>&degree=1" target="_blank" class="associate text-white">Associated's degree</a></p>
                    <p><a href="<?=SITEURL;?>transcript-export.php?id=<?=$student_info_fetch['id'];?>&degree=1" target="_blank" class="bachelor text-white">Bachelor degree</a></p>

                </div>
            </div>
        </div>
    </div>
    <!-- add class model End -->


    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>