<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');



    if(empty($_GET['subject'])){
        header("location:".SITEURL."student-score.php");
        exit(0);
    }else{
        $schedule_id= $_GET['subject'];
        $schedule_check = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id='". $schedule_id ."'");
        if(!mysqli_num_rows($schedule_check) >  0){
            header("location:".SITEURL."student-score.php");
            exit(0);
        }else{
            $data = mysqli_fetch_assoc($schedule_check);
            $class_id = $data['class_id'];
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

        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Input sutdent score <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Input score</p>
           </div>
           <div class="my-3">
                <a href="<?=SITEURL;?>student-list.php?subject=<?=$schedule_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>
           <?php
                $major_info = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id 
                                                    WHERE schedule_study.schedule_id = '". $schedule_id ."'");
                $result = mysqli_fetch_assoc($major_info);
                $subject_name = $result['subject_name'];


            ?>
           <div class="all__teacher">
                <div class="control__top">
                    <!-- <div class="department">
                       <p>Subject : <?=$result['subject_name'];?></p>
                        <p>Class: <?=$result['class_code'];?></p>

                        <php
                            $student_list = mysqli_query($conn, "SELECT * FROM score INNER JOIN student_info ON score.student_id = student_info.student_id WHERE  schedule_id = '". $schedule_id ."'");
                            $total_student = mysqli_num_rows($student_list);
                        ?>

                        <p>Members : <?=$total_student;?></p>
                    </div> -->
                    
                    <div class="department top__list">
                        <?php
                            $short_info_qry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                    INNER JOIN class ON schedule_study.class_id 
                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                    INNER JOIN major ON class.major_id = major.major_id
                                                                    INNER JOIN department ON major.department_id = department.department_id
                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                    WHERE schedule_study.schedule_id='". $schedule_id ."'");
                            if(mysqli_num_rows($short_info_qry) > 0){
                                $data = mysqli_fetch_assoc($short_info_qry);
                                $subject_name = $data['subject_name'];
                                $subject_type = $data['type_name'];

                        ?>
                            <div id="display__grid">   
                                <p>Subject code: <span class="fw-bold text-primary"><?= $data['subject_code'] ." - ". $data['credit']  ." (". $data['theory']. ".". $data['execute']. ".". $data['apply']. ")"?></span></p>
                       
                                <p>Class: <span class="fw-bold"><?=$data['class_code'];?></span></p>
                                <p>Subject : <span class="fw-bold text-primary"><?=$data['subject_name'];?></span></p>
                                <p>Dep: <span class="fw-bold"><?=$data['department'];?></span></p>
                                <p>Semester: <span class="fw-bold"><?=$data['semester'];?></span></p>
                                <p>Maj: <span class="fw-bold"><?=$data['major'];?></span></p>
                            <?php
                                    $student_list = mysqli_query($conn, "SELECT * FROM score INNER JOIN student_info ON score.student_id = student_info.student_id WHERE  schedule_id = '". $schedule_id ."'");
                                    $total_student = mysqli_num_rows($student_list);
                                }
                        ?>
                                <p>Academy year: <span class="fw-bold"><?=$data['year_of_study'];?></span></p>

                                <p>Degree: <span class="fw-bold"><?=$data['level_study'];?></span></p>
                                <p>Total students : <span class="fw-bold"><?=$total_student;?></span></p>
                                <p>Year level: <span class="fw-bold">Year <?=$data['year_level'];?></span></p>
                            </div>
                    </div>
                    <div class="search"></div>
                </div>
                <div class="table__manage input__student__socre">
                    <form action="<?=SITEURL;?>score-action.php" method="post">
                        <input type="hidden" class="d-none" name="schedule_id" value="<?=$schedule_id;?>">
                        <input type="hidden" class="d-none" name="subject_name" value="<?=$subject_type;?>">
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Student ID</th>
                                        <th class="name">Fullname <sup>KH</sup></th>
                                        <th class="name">Fullname <sup>EN</sup></th>
                                        <th style="width: 10px;">Gender</th>
                                        <th style="width: 150px;">Date of birth</th>

                                    <?php
                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                            echo '<th>Grade</th>';
                                        }else{
                                    ?>
                                        <th>Attendance</th>
                                        <th>Assignment</th>
                                        <th>Midterm</th>
                                        <th>Final</th>
                                    <?php
                                        }
                                    ?>
                                        

                                        <!-- <th class="total">Total Score</th> -->
                                        <!-- <th>Grade</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // for($i = 1; $i <= 10; $i++){
                                            $i = 1;
                                            $index_form = 1;
                                            $internIn = 1;
                                            while($data = mysqli_fetch_assoc($student_list)){
                                    ?>
                                        <tr>
                                            <td class="no text-center"><?=$i++;?></td>
                                            <td><?=$data['student_id'];?></td>
                                            <td class="name"><?=$data['fn_khmer'] ." ". $data['ln_khmer'];?></td>
                                            <td class="name text-uppercase"><?=$data['firstname'] ." ". $data['lastname'];?></td>
                                            <td class="table-width-50" style="width: 10px;"><?=ucfirst($data['gender']);?></td>
                                            <td style="width: 150px;"><?=$data['birth_date'];?></td>

                                            <?php
                                                if($subject_type == 'ចុះកម្មសិក្សា'){
                                            ?>
                                            <td>
                                                <select name="s_u<?=$index_form?>" id="" class="selectpikcer">
                                                    <option disabled selected>Select grade</option>
                                                    <option value="S" <?php echo($data['s_u'] == 'S') ? 'selected' : '';?>>S</option>
                                                    <option value="U" <?php echo($data['s_u'] == 'I') ? 'selected' : '';?>>I</option>
                                                    <option value="U" <?php echo($data['s_u'] == 'U') ? 'selected' : '';?>>U</option>
                                                </select>
                                            </td>
                                            <?php
                                                }elseif($subject_type == 'គម្រោង'){
                                            ?>
                                            <td>
                                                <select name="s_u<?=$internIn?>" id="" class="selectpicker">
                                                    <option disabled selected>Select grade</option>
                                                    <option value="A" <?php echo($data['s_u'] == 'A') ? 'selected' : '';?>>A</option>
                                                    <option value="B+" <?php echo($data['s_u'] == 'B+') ? 'selected' : '';?>>B+</option>
                                                    <option value="B" <?php echo($data['s_u'] == 'B') ? 'selected' : '';?>>B</option>
                                                    <option value="C+" <?php echo($data['s_u'] == 'C+') ? 'selected' : '';?>>C+</option>
                                                    <option value="C" <?php echo($data['s_u'] == 'C') ? 'selected' : '';?>>C</option>
                                                    <option value="D" <?php echo($data['s_u'] == 'D') ? 'selected' : '';?>>D</option>
                                                    <option value="E" <?php echo($data['s_u'] == 'E') ? 'selected' : '';?>>E</option>
                                                    <option value="F" <?php echo($data['s_u'] == 'F') ? 'selected' : '';?>>F</option>
                                                </select>
                                            </td>
                                            <?php
                                                }else{
                                            ?>
                                            <td><input type="number" min = "0" max="10" placeholder="..." name="attendence<?=$index_form?>" value="<?=$data['attendence'];?>"></td>
                                            <td><input type="number" min = "0" max="20" placeholder="..." name="assignment<?=$index_form?>" value="<?=$data['assignment'];?>"></td>
                                            <td><input type="number" min = "0" max="30" placeholder="..." name="midterm<?=$index_form?>" value="<?=$data['midterm_exam'];?>"></td>
                                            <td><input type="number" min = "0" max="40" placeholder="..." name="final<?=$index_form?>" value="<?=$data['final_exam'];?>"></td>
                                            
                                            <?php
                                                }
                                            ?>
                                        <!-- <td class="total">-</td> -->
                                            <!-- <td>B+</td> -->
                                        </tr>
                                        <?php
                                            $index_form++;
                                            $internIn++;
                                            
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex control__btn__input">
                            <!-- <button class="btn__submit__score" id="submit" name="submit" type="button" data-bs-toggle="modal" data-bs-target="#submit"><i class="fa fa-arrow-right" aria-hidden="true"></i>Submit</button> -->
                            <!-- <button class="btn__submit__score" id="submit" name="submit" type="button" data-bs-toggle="modal" data-bs-target="#submit"><i class="fa fa-arrow-right" aria-hidden="true"></i>Submit</button> -->
                            <button type="button" class="btn__submit__score" data-bs-toggle="modal" data-bs-target="#submit"><i class="fa fa-arrow-right" aria-hidden="true"></i>Submit</button>

                            <?php
                                $check_submit = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id ."'");
                                if(!mysqli_num_rows($check_submit) > 0){
                            ?>
                                <!-- <button class="btn__save__score" id="save" name="save" type="button" data-bs-toggle="modal" data-bs-target="#save"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button> -->
                                <button type="button" class="btn__save__score" data-bs-toggle="modal" data-bs-target="#save"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>

                            <?php
                                }
                            ?>
                        </div>

                        

                        <!-- Save score model Start -->
                            <div class="modal fade" id="save" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Save score</h5>
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> 
                                        <div class="modal-body fs-small">
                                            <p class="text-center">Student score will save.</p>
                                            <p class="text-center">To submit score please press button "Submit".</p>
                                        </div>    
                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-sm save" type="submit" name="save">Ok</button>
                                            <button class="btn btn-warning btn-sm save" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                        </div>                               
                                    </div>
                                </div>
                            </div>
                        <!-- Save score model End -->


                        <!-- Submit score model Start -->
                            <div class="modal fade" id="submit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Submit score</h5>
                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div> 

                                        <div class="modal-body fs-small">
                                            <p class="text-center text-danger">Are you sure?</p>
                                            <p class="text-center">Do you want to submit score?</p>
                                            <p class="text-center">Student socre will submit to staff officer.</p>
                                            <!-- <p class="text-center">To submit score please press button "Submit".</p> -->
                                        </div>    
                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-sm save" type="submit" name="submit">Ok</button>
                                            <button class="btn btn-warning btn-sm save" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>                               
                                    </div>
                                </div>
                            </div>
                        <!-- Submit score model End -->








                    </form>
                    <!-- <div class="pagination">
                        <a href="" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>
                        <a href="" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div> -->
                </div>
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>