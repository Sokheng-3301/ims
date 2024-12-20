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
                <h5 class="super__title">Student list <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Students</p>
            </div>
            <div class="all__teacher" id="my__content">
                <div class="d-flex align-items-end" style="justify-content: space-between;" >
                <?php
                    if(isset($_GET['class']) && $_GET['class'] != ''){
                        $class = $_GET['class'];
                ?>
                    <div class="d-flex align-items-center btn__export">
                        <p class="me-3">Export by class:</p> 
                        <div class="action__button">                  
                            <!-- <a href="<?=SITEURL;?>class-excel.php?class=<?=$class;?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a> -->
                            <a id="exportExcelBtn" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel</a>
                            <div class="border"></div>
                            <a href="<?=SITEURL;?>class-pdfe.php?class=<?=$class;?>" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a>
                            <!-- <a id="exportPdfBtn" type="button" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a> -->
                        </div>
                    </div>
                    
                <?php
                    }

                    if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
                ?>
                    <div class="department my-2">
                        <a class="add" href="<?=SITEURL?>add-student.php"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                    </div>
                <?php
                    }

                ?>
                </div>
                
                <hr>




<!-- ------------------------------------------------------------------------------------------- -->

                <div class="control__top">
                    <div class="search__student">
                        <!-- <p class="mb-3">Search Student</p> -->
                        <form method="get">
                            <div class="control__form">
                                <div class="select__container select__year">
                                    <select name="year_study" id="year_of_study" required class="selectpicker" data-live-search = "true">
                                        <option selected disabled>ជ្រើសរើសឆ្នាំសិក្សា</option>
                                        <?php
                                            $year = mysqli_query($conn, "SELECT  * FROM year ORDER BY year DESC");
                                            while($row = mysqli_fetch_assoc($year)){
                                        ?>
                                            <option value="<?=$row['year'];?>" <?php
                                                if(isset($_GET['year_study'])){
                                                    if($_GET['year_study'] == $row['year']){
                                                        echo 'selected';
                                                    }
                                                }else{

                                                    echo (date('Y') == $row['year']) ? 'selected' : '';
                                                }
                                            ?>>ឆ្នាំសិក្សា <?=$row['year'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="select__container">
                                    <select name="class" id="class_id">
                                        <option selected disabled>ជ្រើសរើសថ្នាក់</option>
                                    <?php
                                        if(isset($_GET['year_study'])){
                                            $getYear = $_GET['year_study'];
                                            $class = mysqli_query($conn, "SELECT * FROM class WHERE year_of_study = '". $getYear ."'" );
                                        }else{
                                            $class = mysqli_query($conn, "SELECT * FROM class");
                                        }
                                        while($class_data = mysqli_fetch_assoc($class)){
                                    ?>
                                        <option value="<?=$class_data['class_id']?>"
                                            <?php
                                                if(!empty($_GET['class'])){
                                                    if($_GET['class'] == $class_data['class_id'])
                                                    echo "selected";
                                                }
                                            ?>
                                        >ថ្នាក់ <?=$class_data['class_code']?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <input type="search" name="search" class="input" placeholder="Enter student name or ID..." value="<?php
                                    if(!empty($_GET['search'])){
                                        echo trim($_GET['search']);
                                    }
                                ?>">
                                <button class="search-btn" type="submit" name="btn" value="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>


<!-- -------------------------------------------------------------------------------------------- -->
           

<!-- search btn active  -->

                <?php
                    if(isset($_GET['btn'])){
                        if(!empty($_GET['class'])){
                            $count_student = '';
                            $class = mysqli_real_escape_string($conn, $_GET['class']);                                                         
                            $group_sql = mysqli_query($conn, "SELECT * FROM class
                                                                INNER JOIN major ON class.major_id = major.major_id
                                                                INNER JOIN department ON major.department_id = department.department_id
                                                                INNER JOIN student_info ON class.class_id = student_info.class_id
                                                                WHERE student_info.class_id ='". $class ."'");

                            if(mysqli_num_rows($group_sql) > 0){
                                $count_student = mysqli_num_rows($group_sql);
                                $group_result = mysqli_fetch_assoc($group_sql);
                                // print_r($group_result);
                                echo "<div class = 'mb-3' id ='grid_style'>";
                                    echo "<p>Class: <b>".$group_result['class_code']."</b></p>";
                                    echo "<p>Department: <b>".$group_result['department']."</b></p>";
                                    echo "<p>Academy year: <b>".$group_result['year_of_study']."</b></p>";
                                    echo "<p>Major: <b>".$group_result['major']."</b></p>";
                                    echo "<p>Total students: <b>". $count_student ."</b></p>";
                                    echo "<p>Degree: <b> ". $group_result['level_study'] ."</b></p>";
                                    echo "<p>Female students: <b>";
                                        $female_student = mysqli_query($conn, "SELECT * FROM student_info WHERE gender ='female' AND class_id ='". $class ."'");
                                        $female_student_count = mysqli_num_rows($female_student);
                                        if($female_student_count > 0){
                                            echo $female_student_count;
                                        }else{
                                            echo '-';
                                        }
                                    echo "</b></p>";
                                    echo "<p>Year level: <b> Year ". $group_result['year_level'] ."</b></p>";
                                echo "</div>";

                                mysqli_free_result($female_student);
                            }       
                        }

            ?>
                    <!-- short info for export class  -->
                    <table class="d-none" id="table">
                        <tr>
                            <th>Export student in class <?=$group_result['class_code'];?></th>
                        </tr>
                        <tr>
                            <th>Degree: <?=$group_result['level_study'];?></th>
                        </tr>
                        <tr>
                            <th>Year level: <?=$group_result['year_level'];?></th>
                        </tr>
                        <tr>
                            <th>Department: <?=$group_result['department'];?></th>
                        </tr>
                        <tr>
                            <th>Major: <?=$group_result['major'];?></th>
                        </tr>
                        <tr>
                            <th>Total students: <?=$count_student;?></th>
                        </tr>

                        <tr>
                            <th>Femal students: <?= $female_student_count;?></th>
                        </tr>
                        <tr>
                            <th>Academy year: <?= $group_result['year_of_study'] ;?></th>
                        </tr>
                    </table>
            <?php
                        // mysqli_free_result($group_sql);

                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                        $search = trim($search);
                        if($search == '' && empty($_GET['year_study']) && empty($_GET['class'])){
                            include_once('student_include.php'); 
                                               
                        }elseif(!empty($_GET['class']) && $search == ''){
                            $class = mysqli_real_escape_string($conn, $_GET['class']);                                                        
                            // echo 'Search by class only.';
                            include_once('search_department.php');
                            // done 

// -----------------------

                        }
                        elseif(!empty($_GET['year_study']) && empty($_GET['class']) && $search == ''){
                            // $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                            // echo "search with year of study.";
                            $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                            include_once('search_year.php');
                            // done 
// +-----------------------
                        }
                        // elseif(!empty($_GET['year_study']) && !empty($_GET['class']) && $search == ''){
                        //     // $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                        //     // echo "search with year of study and department.";
                        //     $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                        //     $class = mysqli_real_escape_string($conn, $_GET['class']);
                        //     include_once('search_year_dep.php');

                        //     // done 



                        // }
                        
                        elseif(!empty($_GET['year_study']) && empty($_GET['class']) && $search != ''){
                            // $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                            // echo "search with year of study and search-input.";
                            $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                            include_once('search_year_in.php');

                            // done 
// +------------------
                        }
                        
                        // elseif(empty($_GET['year_study']) && !empty($_GET['class']) && $search != ''){
                        //     // $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                        //     // echo "search with department and search-input.";
                        //     $class = mysqli_real_escape_string($conn, $_GET['class']);
                        //     include_once('search_dep_in.php');

                        //     // done 

                        // }elseif(empty($_GET['year_study']) && empty($_GET['class']) && $search != ''){
                        //     // $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                        //     // echo "search with search-input.";               
                        //     include_once('search_in.php');
                            

                        // }


                        else{
                            $class = mysqli_real_escape_string($conn, $_GET['class']); 
                            $year_study = mysqli_real_escape_string($conn, $_GET['year_study']);
                            // echo "search with all field.";
                            include_once('student_search_all.php');
                            
// +--------------------------
                        }
                ?>
                
<!-- no search btn  -->
                <?php  
                        if(!empty($_GET['class'])){
                            echo '<div style="position: absolute; bottom: 30px; margin-bottom: 40px; display: block; line-height: 50px">បញ្ចប់បញ្ជីគិតត្រឹមលេខរៀង '. $count_student .' សិស្សសរុបចំនួន ' . $count_student .'</div>';
                        }  
                    }
                    else{
                        // include_once('student_include.php');
                    }
                ?>
               
           </div>
          

           <!-- footer  -->
           <?php 
            // mysqli_free_result($student);
            include_once('ims-include/staff__footer.php');
           ?>

        </div>
    </section>


<!-- leave student popup  -->
<?php
    if(isset($_SESSION['LEAVE'])){
    ?>    
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>Are you sure? This student is leave?</p>
            <p class="btn-control">
                <a href="<?=SITEURL;?>student-action.php?<?=$_SESSION['LEAVE'];?>" class="ok">Ok</a>
                <a href="
                <?php 
                    if(isset($_GET['delete-id'])){
                        $query_string = $_SERVER['QUERY_STRING'];
                        // $new_query_string = str_replace('&delete-id='.$_GET['delete-id'], "", $query_string);
                        echo $_SERVER['PHP_SELF']."?".$query_string;
                    }                
                ?>" class="cancel">Cancel</a>
            </p>
        </div>
    </div>


    <?php
        }
        unset($_SESSION['LEAVE']);
    ?>




    <!-- pop up message when generate data success  -->
    <?php
        if(isset($_SESSION['GENERATE'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['GENERATE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>students.php<?php
                $query_string = $_SERVER['QUERY_STRING'];
                if($query_string != ''){
                    echo "?".$query_string;
                }                             
                ?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['GENERATE']);
        if(isset($_SESSION['GENERATE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['GENERATE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>students.php<?php
                $query_string = $_SERVER['QUERY_STRING'];
                if($query_string != ''){
                    echo "?".$query_string;
                }                             
                ?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['GENERATE_ERROR']);
    ?>

    <!-- include javaScript in web page  -->
    <?php
        include_once('ims-include/script-tage.php');
        mysqli_close($conn);
    ?>


    <script>
        $(document).ready(function(){
            $('#year_of_study').on('change', function(){
                var yearOfStudy = $(this).val();
                if(yearOfStudy){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'class_id='+yearOfStudy,
                        success:function(html){
                            $('#class_id').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    $('#class_id').html('<option value="">Select academy year first</option>');
                }

                // console.log('Hi');
            });
            
            // $('#state').on('change', function(){
            //     var stateID = $(this).val();
            //     if(stateID){
            //         $.ajax({
            //             type:'POST',
            //             url:'ajaxData.php',
            //             data:'state_id='+stateID,
            //             success:function(html){
            //                 $('#city').html(html);
            //             }
            //         }); 
            //     }else{
            //         $('#city').html('<option value="">Select state first</option>'); 
            //     }
            // });
        });

        $(document).ready(function () {
            $("#exportExcelBtn").click(function () {
                $("#my__content").table2excel({
                    filename: "export-class-student.xls"
                });
            });           
        });



        $(document).ready(function () {
            $("#exportPdfBtn").click(function () {
                html2canvas($('#table')[0], {
                    onrendered: function (canvas) {
                        var data = canvas.toDataURL();
                        var docDefinition = {
                            content: [{
                                image: data,
                                width: 500
                            }]
                        };
                        pdfMake.createPdf(docDefinition).download("cutomer-details.pdf");
                    }
                });
            });     
        });

    </script>


    <script>
       
    </script>


</body>
</html>