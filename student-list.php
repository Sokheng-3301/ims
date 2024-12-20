<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $back_page = '';
    if(!empty($_SERVER['HTTP_REFERER'])){
        $back_page = $_SERVER['HTTP_REFERER'];
    }else{
        $back_page = SITEURL."student-score.php";
    }


    $data = '';
    if(empty($_GET['subject'])){
        header("location:".SITEURL."student-score.php");
        exit(0);
    }else{
        $schedule_id= $_GET['subject'];
        $schedule_check = mysqli_query($conn, "SELECT * FROM schedule_study
                                                -- INNER JOIN class ON schedule_study.class_id 
                                                -- INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                -- INNER JOIN major ON class.major_id = major.major_id
                                                -- INNER JOIN department ON major.department_id = department.department_id
                                                -- INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                WHERE schedule_study.schedule_id='". $schedule_id ."'");
        if(!mysqli_num_rows($schedule_check) >  0){
            header("location:".SITEURL."student-score.php");
            exit(0);
        }else{
            $data = mysqli_fetch_assoc($schedule_check);
            $class_id = $data['class_id'];
        }
    }

    // echo $schedule_id;

    // check student list in each subject AND ADD STUDENT IN
    $check_student = mysqli_query($conn, "SELECT * FROM score WHERE schedule_id = '". $schedule_id ."'");
    if(!mysqli_num_rows($check_student) > 0){
            $student_inclass = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id ='". $class_id ."'");

            // this while loop in student_info table 
            while($data = mysqli_fetch_assoc($student_inclass)){
                $student_id = $data['student_id'];
                $insert_student_class = "INSERT INTO score (student_id, schedule_id) 
                                        VALUES ('$student_id', '$schedule_id')";
                $insert_run = mysqli_query($conn, $insert_student_class);
            }
    }else{
        // echo 'Insert done';
    }



    $student_inclass = mysqli_query($conn, "SELECT * FROM student_info WHERE class_id ='". $class_id ."' AND list_status = '0'");
    // $data = mysqli_fetch_assoc($student_inclass);
        while($data = mysqli_fetch_assoc($student_inclass)){
            $student_id = $data['student_id'];
            $insert_student_class = "INSERT INTO score (student_id, schedule_id) 
                                    VALUES ('$student_id', '$schedule_id')";
            $insert_run = mysqli_query($conn, $insert_student_class);
            if($insert_run == true){
                $list_status = mysqli_query($conn, "UPDATE student_info SET list_status = 1");
            }
        }



    // edit score on data script 
    $edit_status = true;
    $submite_status = false;

    $submit_date = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id . "'");

    if(mysqli_num_rows($submit_date) > 0){
        $result = mysqli_fetch_assoc($submit_date);

        $submite_status = true;


        if($result['edit_status'] == '1'){
            // $update_edit_stat = mysqli_query($conn, "UPDATE score_submitted SET edit_status = '1' WHERE id ='". $schedule_id ."'");
            $edit_status = true;
            $new_date = date("d-m-Y", strtotime($result['submit_date']. '+7 days'));
        }else{
            $new_date = date("d-m-Y", strtotime($result['submit_date']. '+7 days'));
            if(date('d-m-Y') >= $new_date){
                // echo 'Can not edit score';
                $update_edit_stat = mysqli_query($conn, "UPDATE score_submitted SET edit_status = '0' WHERE id ='". $schedule_id ."'");
                $edit_status = false;
            }
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
                <h5 class="super__title">Student list in class <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Student list</p>
           </div>
           <div class="my-3">
                <a href="<?=SITEURL;?>student-score.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>

            <?php
                $major_info = mysqli_query($conn, "SELECT * FROM schedule_study INNER JOIN course ON schedule_study.subject_code = course.subject_code INNER JOIN class ON schedule_study.class_id = class.class_id WHERE schedule_id='". $schedule_id ."'");
                $result = mysqli_fetch_assoc($major_info);
            ?>
           <div class="all__teacher">
                <?php
                    $submit_date = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id . "'");
                    if(mysqli_num_rows($submit_date) > 0){
                ?>
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <p class="me-3">Export as:</p> 
                        <div class="action__button d-flex">                  
                            <!-- <a href="<?=SITEURL;?>excel.php?subject=<?=$schedule_id;?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a> -->
                            <a type="button" id="excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a>
                            <div class="border"></div>
                            <a href="<?=SITEURL;?>pdf.php?subject=<?=$schedule_id;?>" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a>
                        </div>
                    </div>
                <?php
                    }
                ?>

                <div class="control__top">
                    <div class="department top__list">
                        <?php
                            $short_info_qry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                    INNER JOIN class ON schedule_study.class_id 
                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                    INNER JOIN major ON class.major_id = major.major_id
                                                                    INNER JOIN department ON major.department_id = department.department_id
                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id

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
            <?php
                if($edit_status == true ){
                    if($submite_status == true){
            ?>
                <div class="search">
                    <a href="<?=SITEURL?>input-score.php?subject=<?=$schedule_id;?>" class="btn btn-success btn-sm "><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Score</a>
                </div>
            <?php
                    }else{
            ?>
                <div class="search">
                    <a href="<?=SITEURL?>input-score.php?subject=<?=$schedule_id;?>" class="btn btn-primary btn-sm "><i class="fa fa-plus" aria-hidden="true"></i>Add Score</a>
                </div>
            <?php
                    }
                }
            ?>
                </div>

                

                <div class="table__manage input__student__socre">
                    <div class="table_manage" id="student_score">

                        <table id="none_table" class="d-none">
                            <tr>
                                <td class="fs-3">Export student score</td>
                            </tr>
                            <tr>
                                <td>Subject: <b><?=$data['subject_code'];?></b> - <b><?=$data['subject_name'];?></b> - <small><?=$data['department']. ", ". $data['major'];?></small></td>
                            </tr>
                            <tr>
                                <td><p>Instructor: <b><?=$data['fn_en']. " " .$data['ln_en'];?></b></p></td>
                            </tr>
                            <tr>
                                <td><p>Class: <b><?=$data['class_code'];?></b>, <b><?=$data['level_study'];?></b>, Year: <b><?=$data['year_level'];?></b>, Semester: <b><?=$data['semester'];?></b>, <b><?=$data['year_of_study'];?></b></p></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                        // mysqli_free_result($major_info);
                                        $student_list = mysqli_query($conn, "SELECT * FROM score
                                                                            INNER JOIN student_info ON score.student_id = student_info.student_id
                                                                        
                                                                            WHERE schedule_id ='". $schedule_id ."'");
                                        $count_member = mysqli_num_rows($student_list);
                                    ?>
                                    <p>Total students: <b><?=$count_member;?></b></p>
                                </td>
                            </tr>
                        </table>


                        <table class="fs-small">
                            <thead>
                                <tr>
                                    <th class="no text-center">No.</th>
                                    <th>Student ID</th>
                                    <th class="table-width-100">Fullname <sup>KH</sup></th>
                                    <th class="table-width-100">Fullname <sup>EN</sup></th>
                                    <th class="table-width-50">Gender</th>
                                    <th class="table-width-50 text-center">Birth date</th>
                                    <?php
                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                            echo '<th class="text-center" style="width: 18px;">Grade</th>';
                                        }else{
                                    ?> 

                                    <th class="text-center" style="width: 18px;">Att.</th>
                                    <th class="text-center" style="width: 18px;">Ass.</th>
                                    <th class="text-center" style="width: 18px;">Mid.</th>
                                    <th class="text-center" style="width: 18px;">Final</th>
                                    <th class="text-center" style="width: 18px;">Total</th>
                                    <th class="text-center" style="width: 18px;">Grade</th>

                                    <?php
                                        }
                                    ?>
                                    <th class="text-center" style="width: 17px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    while($data = mysqli_fetch_assoc($student_list)){
                                ?>
                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$data['student_id'];?></td>
                                        <td class="table-width-200"><?=$data['fn_khmer'] ." ". $data['ln_khmer'];?></td>
                                        <td class="table-width-200 text-uppercase"><?=$data['firstname'] ." ". $data['lastname'];?></td>
                                        <td class="table-width-50"><?=ucfirst($data['gender']);?></td>
                                        <td class="table-width-50 text-center">
                                            <?php
                                                if($data['birth_date'] == '0000-00-00'){

                                                }else{
                                                    $birth_date = date_create($data['birth_date']);
                                                    echo date_format($birth_date, "d-M-Y");
                                                }
                                            ?>
                                        </td>
                                        <?php
                                            if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                        ?>

                                        <td class="text-primary text-center" style="width: 18px;"><?php echo ($data['s_u'] == '') ? '<span class ="text-secondary">Null</span>' : $data['s_u'];?></td>

                                        <?php
                                            }else{
                                        ?>
                                        
                                        <td class="text-primary text-center" style="width: 18px;"><?php echo ($data['attendence'] == '') ? '<span class ="text-secondary">Null</span>' : $data['attendence'];?></td>
                                        <td class="text-primary text-center" style="width: 18px;"><?php echo ($data['assignment'] == '') ? '<span class ="text-secondary">Null</span>' : $data['assignment'];?></td>
                                        <td class="text-primary text-center" style="width: 18px;"><?php echo ($data['midterm_exam'] == '') ? '<span class ="text-secondary">Null</span>' : $data['midterm_exam'];?></td>
                                        <td class="text-primary text-center" style="width: 18px;"><?php echo ($data['final_exam'] == '') ? '<span class ="text-secondary">Null</span>' : $data['final_exam'] ;?></td>
                                        <td class="text-success text-center fw-bold" style="width: 18px;"><?php echo $data['total_score'];?></td>
                                        <td class="text-danger text-center fw-bold" style="width: 17px;"><?php echo $data['grade'];?></td>

                                        <?php
                                            }
                                        ?>
                                        <td class="text-center" style="width: 20px;"><span><a href="<?=SITEURL;?>view-student.php?view-item=<?=$data['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span></td>
                                    </tr>
                                    
                                    <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="pagination">
                        <a href="" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>
                        <a href="" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div> -->
                </div>
                <?php
                    $submit_date = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id . "'");
                    if(mysqli_num_rows($submit_date) > 0){
                ?>
                    <div class="count_day my-3 fs-small px-2">
                        <p>
                            <b class="text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Note!: </b> You can edit student score to date: <span class="fw-bold ps-2 text-primary"><?= $new_date;?></span>
                        </p>
                    </div>
                <?php
                    }
                ?>
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
                <a href="<?=SITEURL;?>student-list.php?subject=<?=$schedule_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>student-list.php?subject=<?=$schedule_id;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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


    <script>
        $(document).ready(function(){
            // excel export 
            $("#excel_btn").click(function () {
                $("#student_score").table2excel({
                    filename: "export-student-score.xls"
              });             
            });

            // pdf export 
            $('#pdf_btn').on('click', function() {
                    $('#none_table').addClass('d-block');
                    const { jsPDF } = window.jspdf;

                    // Create a new jsPDF instance
                    const doc = new jsPDF();

                    // Use html2canvas to take a snapshot of the table
                    html2canvas(document.querySelector("#student_score")).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const pdfWidth = doc.internal.pageSize.getWidth();
                        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                        // Add margins (10 units for example)
                        const marginX = 10;
                        const marginY = 10;

                        // Add the image to the PDF with margins
                        doc.addImage(imgData, 'PNG', marginX, marginY, pdfWidth - 2 * marginX, pdfHeight - 2 * marginY);
                        const pdf_save = doc.save('studentScore.pdf');

                        // if(pdf_save == true){
                        //     $('#none_table').addClass('d-none');
                        //     location.reload();
                        // }
                        
                        // if(doc.save('studentListInClass.pdf') == true){
                        //     $('#none_table').addClass('d-none');
                        //     // location.reload();
                        // }
                    });
            });

            let timer;
            let timeLeft = 10; // Set the timer countdown (in seconds)

            $('#pdf_btn').click(function() {
                clearInterval(timer); // Clear any existing timer
                timeLeft = 15; // Reset timer
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