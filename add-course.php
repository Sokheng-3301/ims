<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

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
            <?php
                if(!isset($_GET['update-id'])){
            ?>
                <h5 class="super__title">Add course<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add course</p>
                
            <?php
                }else{
            ?>
                <h5 class="super__title">Update course<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update course</p>
            <?php
                }
            ?>
           </div>
            <?php
                if(!isset($_GET['update-id'])){
            ?>
            <div class="my-3">
                <a href="<?=SITEURL;?>courses.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
            <?php
                }else{
                    $query_string = $_SERVER['QUERY_STRING'];
                    $query_string = str_replace('update-id='.$_GET['update-id'].'&', '', $query_string);
            ?>
            <div class="my-3">
                <a href="<?=SITEURL;?>courses.php?<?=$query_string;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
            <?php
                }
            ?>
            

           <div class="add__member">
            <?php
                if(!isset($_GET['update-id'])){
            ?>
                <form action="<?=SITEURL;?>course-action.php" method="post">
                    <div class="generate__data add__course">
                        <p>Add course</p>
                        <?php
                            if(isset($_SESSION['MESSAGE_SQL'])){
                        ?>
                        <div class="message_show_success mb-2">
                            <s><i class="fa fa-check" aria-hidden="true"></i><?=$_SESSION['MESSAGE_SQL'];?></s>
                            <a href=""><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <?php                               
                                unset($_SESSION['MESSAGE_SQL']);
                            }elseif(isset($_SESSION['MESSAGE_SQL_ERROR'])){
                        ?>
                        <div class="message_show_error mb-2">
                            <s><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?=$_SESSION['MESSAGE_SQL_ERROR'];?></s>
                            <a href=""><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <?php
                            unset($_SESSION['MESSAGE_SQL_ERROR']);
                            }
                        ?>

                        <label for="subject_code">Subject code <span class="text-danger">*</span></label>
                        <input type="text" id="subject_code" name="subject_code" placeholder="Subject code...">
                        <span class="mb-2 d-block text-danger"><small id="subject_code_message"></small></span>
                        <label for="subject_name">Subject name <sup>KH</sup> <span class="text-danger">*</span></label>
                        <input type="text" id="subject_name" name="subject_name_kh" placeholder="Subject name (KH)...">

                        <label for="subject_name">Subject name <sup>EN</sup> <span class="text-danger">*</span></label>
                        <input type="text" id="subject_name" name="subject_name" placeholder="Subject name (EN)...">

                        <div class="flex__form">
                            <div class="block__form">
                                <label for="">Credit <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="credit" placeholder="Credit...">
                            </div>
                            <div class="block__form">
                                <label for="">Theory <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="theory" placeholder="Theory...">
                            </div>
                            <div class="block__form">
                                <label for="">Execute <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="execute" placeholder="Execute...">
                            </div>
                            <div class="block__form">
                                <label for="">Apply <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="apply" placeholder="Apply...">
                            </div>
                        </div>

                        <label for="">Department <span class="text-danger">*</span></label>
                      
                            <?php
                                if(isset($_SESSION['NO_DEPARTMENT'])){
                            ?>
                            
                            <small class="text-danger ms-3">
                                    <?=$_SESSION['NO_DEPARTMENT'];?>
                            </small>
                            <?php
                                    
                                    unset($_SESSION['NO_DEPARTMENT']);
                                }
                            ?>
                        
                        <select name="department" id="" class="selectpicker" data-live-search="true">
                            <option disabled selected>Please select department</option>
                            <?php
                                $inc = 1;
                                $department = "SELECT * FROM department ORDER BY department_id ASC";
                                $department_run = mysqli_query($conn, $department);
                                while($data = mysqli_fetch_assoc($department_run)){
                            ?>
                            <option value="<?=$data['department_id'];?>"><?=$inc++. ". ".ucfirst($data['department']);?></option>
                            <?php
                                }
                                mysqli_free_result($department_run);
                            ?>
                        </select>

                        <label for="subject_type">Suject type <span class="text-danger">*</span></label>
                        <!-- <input type="text" id="subject_type" name="subject_type" placeholder="Suject type..."> -->
                        <select name="subject_type" id="subject_type" class="selectpicker" data-live-search="true">
                            <option disabled selected>Please select subject type</option>
                            <?php
                                $inc = 1;
                                $subject_type = "SELECT * FROM subject_type";
                                $subject_type_run = mysqli_query($conn, $subject_type);
                                while($data = mysqli_fetch_assoc($subject_type_run)){
                            ?>
                            <option value="<?=$data['id'];?>"><?=$inc++.". ".$data['type_name'];?></option>
                            <?php
                                }
                                mysqli_free_result($subject_type_run);
                            ?>
                        </select>
                        
                        <label for="teacher_name">Instructor <span class="text-danger">*</span></label>
                        <!-- <input type="text" id="teacher_name" name="teacher_name" placeholder="Instructor..."> -->

                        <select name="teacher_name" id="" class="selectpicker" data-live-search="true">
                            <option selected disabled>Please select instructor</option>
                            <?php
                                $inc = 1;
                                $teacher_info = "SELECT * FROM teacher_info";
                                $teacher_info_run = mysqli_query($conn, $teacher_info);
                                while($data = mysqli_fetch_assoc($teacher_info_run)){
                            ?>
                            <option value="<?=$data['teacher_id'];?>"><?=$inc++ . ". ". $data['fn_khmer']. " " .$data['ln_khmer']." - " .$data['fn_en']. " " .$data['ln_en'];?></option>
                            <?php
                                }
                                mysqli_free_result($teacher_info_run);
                            ?>
                        </select>

                        <small>
                            <a href="<?=SITEURL;?>add-teacher.php" class="d-inline-block mb-2">Add new teacher here.</a>
                        </small>


                        <label for="total_hours">Total hours <span class="text-danger">*</span></label>
                        <input type="number" id="total_hours" name="total_hours" min = "0" placeholder="Total hours...">

                       
                        <label for="Description">Description</label>
                        <textarea name="description" id="Description" cols="30" rows="5" placeholder="Description..."></textarea>

                        <label for="Purpose">Purpose</label>
                        <textarea name="purpose" id="Purpose" cols="30" rows="5" placeholder="Purpose..."></textarea>
                        
                        <label for="AnticipatedOutcome">Expected Outcome</label>
                        <textarea name="anticipated_outcome" id="Anticipated Outcome" cols="30" rows="5" placeholder="Anticipated Outcome..."></textarea>
                        
                        
                        <button type="submit" name="save_course" class="generate-btn" id="save_course"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save course</button>
                    </div>
                </form>
            <?php
            #Update form if have update-id requested by GET 
                }else{

                    $update_id = $_GET['update-id'];
                    $update_data = "SELECT * FROM course WHERE id ='". $update_id . "'";
                    $update_work = mysqli_query($conn, $update_data);
                    if(mysqli_num_rows($update_work) > 0){
                        $resutls = mysqli_fetch_assoc($update_work);

            ?>
                <form action="<?=SITEURL;?>course-action.php" method="post">
                    <div class="generate__data add__course">
                        
                        <p> Update course
                            <small class="ms-3 text-primary">
                                <!-- <php
                                    if(isset($_SESSION['MESSAGE_SQL'])){
                                        echo $_SESSION['MESSAGE_SQL'];
                                        unset($_SESSION['MESSAGE_SQL']);
                                    }
                                ?> -->
                            </small>
                        </p>
                        <?php
                            if(isset($_SESSION['MESSAGE_SQL_ERROR'])){
                        ?>
                            <samp class="message_show_error my-3"><span> <span class="fw-bold pe-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> <?=$_SESSION['MESSAGE_SQL_ERROR'];?></span><span><a href=""><i class="fa fa-times" aria-hidden="true"></i></a></span></samp>
                        <?php
                            unset($_SESSION['MESSAGE_SQL_ERROR']);
                            }
                        ?>
                        <input type="hidden" name="url" value="<?=$_SERVER['QUERY_STRING'];?>">
                        <input type="hidden" name="id" value="<?=$resutls['id'];?>">
                        
                        <label for="subject_code">Subject code <span class="text-danger">*</span></label>
                        <input type="text" id="subject_code" name="subject_code" placeholder="Subject code..." value="<?=$resutls['subject_code'];?>">
                        <span class="mb-2 d-block text-danger"><small id="subject_code_message"></small></span>

                        <label for="subject_name">Subject name <sup>KH</sup> <span class="text-danger">*</span></label>
                        <input type="text" id="subject_name" name="subject_name_kh" placeholder="Subject name (KH)..." value="<?=$resutls['subject_name_kh'];?>">

                        <label for="subject_name">Subject name <sup>EN</sup> <span class="text-danger">*</span></label>
                        <input type="text" id="subject_name" name="subject_name" placeholder="Subject name (EN)..." value="<?=$resutls['subject_name'];?>">

                        <div class="flex__form">
                            <div class="block__form">
                                <label for="">Credit <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="credit" placeholder="Credit..." value="<?=$resutls['credit'];?>">
                            </div>
                            <div class="block__form">
                                <label for="">Theory <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="theory" placeholder="Theory..." value="<?=$resutls['theory'];?>">
                            </div>
                            <div class="block__form">
                                <label for="">Execute <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="execute" placeholder="Execute..." value="<?=$resutls['execute'];?>">
                            </div>
                            <div class="block__form">
                                <label for="">Apply <span class="text-danger">*</span></label>
                                <input type="number" min = "0" name="apply" placeholder="Apply..." value="<?=$resutls['apply'];?>">
                            </div>
                        </div>

                        <label for="">Department <span class="text-danger">*</span></label>
                            <?php
                                if(isset($_SESSION['NO_DEPARTMENT'])){
                            ?>
                            
                            <small class="text-danger ms-3">
                                    <?=$_SESSION['NO_DEPARTMENT'];?>
                            </small>
                            <?php
                                    
                                    unset($_SESSION['NO_DEPARTMENT']);
                                }
                            ?>
                        
                        <select name="department" id="" class="selectpicker" data-live-search="true">
                            <option disabled selected>Please select department</option>
                            <?php
                                $inc = 1;
                                $department = "SELECT * FROM department";
                                $department_run = mysqli_query($conn, $department);
                                while($data = mysqli_fetch_assoc($department_run)){
                            ?>
                            <option value="<?=$data['department_id'];?>"
                            <?php
                                if($data['department_id'] == $resutls['department_id']){
                                    echo "selected";
                                }
                            ?>>
                                <?=$inc++. ". ". ucfirst($data['department']);?>
                            </option>
                            <?php
                                }
                                mysqli_free_result($department_run);
                            ?>
                        </select>

                        <label for="subject_type">Suject type <span class="text-danger">*</span></label>
                        <!-- <input type="text" id="subject_type" name="subject_type" placeholder="Suject type..."> -->
                        <select name="subject_type" id="subject_type" class="selectpicker" data-live-search="true">
                            <option disabled selected>Please select subject type</option>
                            <?php
                                $inc = 1;
                                $subject_type = "SELECT * FROM subject_type";
                                $subject_type_run = mysqli_query($conn, $subject_type);
                                while($data = mysqli_fetch_assoc($subject_type_run)){
                            ?>
                            <option value="<?=$data['id'];?>"
                            <?php
                                if($data['id'] == $resutls['subject_type'])
                                {
                                    echo "selected";
                                }
                            ?>
                            >
                                <?=$inc++ .". ". $data['type_name'];?>
                            </option>
                            <?php
                                }
                                mysqli_free_result($subject_type_run);
                            ?>
                        </select>

                        <label for="teacher_name">Instructor <span class="text-danger">*</span></label>

                        <!-- <input type="text" id="teacher_name" name="teacher_name" placeholder="Instructor..." value="<=$resutls['teaching_by'];?>"> -->


                        <select name="teacher_name" id="" class="selectpicker" data-live-search="true">
                            <option selected disabled>Please select instructor</option>
                            <?php
                                $inc = 1;
                                $teacher_info = "SELECT * FROM teacher_info";
                                $teacher_info_run = mysqli_query($conn, $teacher_info);
                                while($data = mysqli_fetch_assoc($teacher_info_run)){
                            ?>
                            <option value="<?=$data['teacher_id'];?>" <?php
                                echo ($data['teacher_id'] == $resutls['teaching_by']) ? 'selected' : '';
                            ?>><?=$inc++.". ". $data['fn_khmer']. " " .$data['ln_khmer']. " - ".$data['fn_en']. " " .$data['ln_en'];?></option>
                            <?php
                                }
                                mysqli_free_result($teacher_info_run);
                            ?>
                        </select>
                        
                        <small>
                            <a href="<?=SITEURL;?>add-teacher.php" class="d-inline-block mb-2">Add new teacher here.</a>
                        </small>


                        <label for="total_hours">Total hours</label>
                        <input type="number" id="total_hours" name="total_hours"  min = "0" placeholder="Total hours..." value="<?=$resutls['total_hourse'];?>">

                       
                        <label for="Description">Description</label>
                        <textarea name="description" id="Description" cols="30" rows="5" placeholder="Description..."><?=$resutls['description'];?></textarea>

                        <label for="Purpose">Purpose</label>
                        <textarea name="purpose" id="Purpose" cols="30" rows="5" placeholder="Purpose..."><?=$resutls['purpose'];?></textarea>
                        
                        <label for="AnticipatedOutcome">Anticipated Outcome</label>
                        <textarea name="anticipated_outcome" id="Anticipated Outcome" cols="30" rows="5" placeholder="Anticipated Outcome..."><?=$resutls['anticipated_outcome'];?></textarea>
                        
                        
                        <button type="submit" name="update_course" id="save_course" class="generate-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i>Update course</button>
                    </div>
                </form>            
            <?php
                mysqli_free_result($update_work);
                    }else{
            ?>
                <p class="mx-3 mt-3">
                    No data found.
                    <a href="<?=SITEURL;?>courses.php">Back to course</a>
                </p>

            <?php
                    }
                }
            ?>
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>
        </div>
    </section>

    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        // var subjectCode = document.getElementById('subject_code');
        // subjectCode.addEventListener('input', function () { 
        //     var subjectCodeMesage = document.getElementById('subject_code_message');
        //     var saveButton =  document.getElementById('save_course');
        //     if(isNaN(subjectCode.value)){
        //         subjectCodeMesage.innerHTML = 'Subject code are number only!';
        //         saveButton.disabled = true;
        //         saveButton.style.opacity = '0.4';
                
        //     }else{
        //         subjectCodeMesage.innerHTML = '';
        //         saveButton.removeAttribute('disabled');
        //         saveButton.style.opacity = '1';
        //     }
        //  });
        
        // !isNaN(subject_code.value)
    </script>
</body>
</html>