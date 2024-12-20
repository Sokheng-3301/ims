<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');
    $back_page = '';
    if(!empty($_SERVER['HTTP_REFERER'])){
        $back_page = $_SERVER['HTTP_REFERER'];
    }else{
        $back_page = SITEURL."score-submitted.php";
    }

    

    if(empty($_GET['subject'])){
        header("location:".SITEURL."score-submitted.php");
        exit(0);
    }else{
        $schedule_id= $_GET['subject'];
        $schedule_check = mysqli_query($conn, "SELECT * FROM schedule_study WHERE schedule_id='". $schedule_id ."'");
        if(!mysqli_num_rows($schedule_check) >  0){
            header("location:".SITEURL."score-submitted.php");
            exit(0);
        }else{
            $data = mysqli_fetch_assoc($schedule_check);
            $class_id = $data['class_id'];


            // change accepted 
            $change_accept = mysqli_query($conn, "UPDATE score_submitted SET submit_status = '2' WHERE schedule_id = '". $schedule_id ."'");
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
                    <h5 class="super__title">Score submitted detail <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Score detail</p>
            </div>
            <div class="my-3">
                    <!-- <a href="<?=SITEURL;?>score-submitted.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a> -->
                    <a href="<?=$back_page;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>

            <div class="all__teacher score__detail"> 
                <div class="d-flex align-items-center mb-3">
                    <p class="me-3">Export as:</p> 
                    <!-- <div class="action__button">                  
                        <a href="=SITEURL;?>excel.php?subject==$schedule_id;?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a>
                        <div class="border"></div>
                        <a href="=SITEURL;?>pdf.php?subject==$schedule_id;?>" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a>
                    </div> -->

                    <div class="action__button">                  
                        <!-- <a type="button" id="excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a>
                        <div class="border"></div>
                        <a type="button" id="pdf_btn" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a> -->

                        <a type="button" id="excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a>
                        <div class="border"></div>
                        <a href="<?=SITEURL;?>pdf.php?subject=<?=$schedule_id;?>" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a>

                    </div>
                </div>

            <?php
                $major_info = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code 
                                                    INNER JOIN class ON schedule_study.class_id = class.class_id 
                                                    INNER JOIN major ON class.major_id = major.major_id
                                                    INNER JOIN department ON major.department_id = department.department_id
                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                    WHERE schedule_study.schedule_id='". $schedule_id ."'");

                $result = mysqli_fetch_assoc($major_info);
                $subject_name = $result['subject_name'];
                $subject_type = $result['type_name'];
            ?>

                <div class="border-top pt-3">
                    <div id="top_score">
                        <p>Subject: <b><?=$result['subject_code'];?></b> - <b><?=$result['subject_name'];?></b> - <small><?=$result['department']. ", ". $result['major'];?></small></p>
                        <p>Instructor: <b><?=$result['fn_en']. " " .$result['ln_en'];?></b></p>
                        <p>Class: <b><?=$result['class_code'];?></b>, <b><?=$result['level_study'];?></b>, Year: <b><?=$result['year_level'];?></b>, Semester: <b><?=$result['semester'];?></b>, <b><?=$result['year_of_study'];?></b></p>
                    
                        <?php
                            // mysqli_free_result($major_info);
                            $student_list = mysqli_query($conn, "SELECT * FROM score
                                                                INNER JOIN student_info ON score.student_id = student_info.student_id
                                                            
                                                                WHERE schedule_id ='". $schedule_id ."'");
                            $count_member = mysqli_num_rows($student_list);
                        ?>
                        <p>Total students: <b><?=$count_member;?></b></p>
                    </div>

                    <?php
                        $check_edit_status = mysqli_query($conn, "SELECT * FROM score_submitted WHERE schedule_id ='". $schedule_id ."'");
                        $check_result = mysqli_fetch_assoc($check_edit_status);
                        if($check_result['edit_status'] == '0'){
                    ?>
                        <p class="mt-3">
                            <span>Time out to edit score</span> <br>
                            <a href="<?=SITEURL;?>score-action.php?score=<?=$schedule_id;?>" class="btn btn-sm btn-primary px-4"><i class="fa fa-refresh" aria-hidden="true"></i>Enable edit score</a>
                        </p>
                    <?php
                        }
                    ?>
                    <div class="table_manage" id="student_score">
                        <table id="none_table" class="d-none">
                            <tr>
                                <td class="fs-3">Export student score</td>
                            </tr>
                            <tr>
                                <td>Subject: <b><?=$result['subject_code'];?></b> - <b><?=$result['subject_name'];?></b> - <small><?=$result['department']. ", ". $result['major'];?></small></td>
                            </tr>
                            <tr>
                                <td><p>Instructor: <b><?=$result['fn_en']. " " .$result['ln_en'];?></b></p></td>
                            </tr>
                            <tr>
                                <td><p>Class: <b><?=$result['class_code'];?></b>, <b><?=$result['level_study'];?></b>, Year: <b><?=$result['year_level'];?></b>, Semester: <b><?=$result['semester'];?></b>, <b><?=$result['year_of_study'];?></b></p></td>
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
                        <table class="table mt-3 student__score">
                            <thead>
                                <tr>
                                    <th class="table-width-50 text-center">No</th>
                                    <th>Student id</th>
                                    <th class="table-width-100">Fullname <sup>KH</sup></th>
                                    <th class="table-width-200">Fullname <sup>EN</sup></th>
                                    <th style="width: 30px;">Gender</th>
                                    <th class="text-center" style="width: 125px;">Birth date</th>

                                    <?php
                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                    
                                            echo '<th class="text-center table-width-50">Grade</th>';
                                        }else{
                                    ?>
                                    
                                    <th class="text-center">Att.</th>
                                    <th class="text-center">Ass.</th>
                                    <th class="text-center">Midterm</th>
                                    <th class="text-center">Final</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center table-width-50">Grade</th>

                                    <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $i=1;
                                    while($data = mysqli_fetch_assoc($student_list)){
                                ?>
                                <tr>
                                    <td class="table-width-50 text-center"><?=$i++?></td>
                                    <td><?=$data['student_id'];?></td>
                                    <td class="table-width-100"><?=$data['fn_khmer']. " " .$data['ln_khmer'];?></td>
                                    <td class="table-width-200 text-uppercase"><?=$data['firstname']. " " .$data['lastname'];?></td>
                                    <td style="width: 30px;"><?=ucfirst($data['gender']);?></td>
                                    <td class="text-center" style="width: 125px;">
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
                                        <td class="text-center table-width-50"><p class="grade"><?php echo ($data['s_u'] != '')? $data['s_u'] :'-';?></p></td>

                                    <?php        
                                        }else{
                                    ?>

                                    <td class="text-center fw-bold"><?=$data['attendence'];?></td>
                                    <td class="text-center fw-bold"><?=$data['assignment'];?></td>
                                    <td class="text-center fw-bold"><?=$data['midterm_exam'];?></td>
                                    <td class="text-center fw-bold"><?=$data['final_exam'];?></td>
                                    <td class="text-center fw-bold text-danger"><?=$data['total_score'];?></td>
                                    <td class="text-center table-width-50"><p class="grade"><?=$data['grade'];?></p></td>

                                    <?php
                                        }
                                    ?>
                                </tr>
                                <?php
                                    }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>

    <div id="feed__back__form">
        <div class="form" id="form_show">
            <form action="" method="post">
                <h5>Feedback.</h5>
                <label for="status">Status</label>
                <input type="text" name="status" id="status" placeholder="Enter request status...">
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" rows="4" placeholder="Write your comment..."></textarea>
                <div class="d-flex manage__button">
                    <button type="submit" name="submit">Go</button>
                    <button type="button" onclick="feedBackForm()">Close</button>
                </div>
            </form>
        </div>
    </div>
    
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