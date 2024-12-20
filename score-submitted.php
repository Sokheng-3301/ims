<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $change_status = mysqli_query($conn, "UPDATE score_submitted SET submit_status = '0' WHERE submit_status = '1'");
    // mysqli_free_result($change_status);

    

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
                <h5 class="super__title">Student score submitted <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Score submitted</p>
           </div>
           <div class="all__teacher request__control">
                <div class="control__top">
                    <div class="department sub__menu">
                        <a class="<?php
                            if(empty($_GET['accept'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-flag-checkered" aria-hidden="true"></i>New</a> <span class="px-1">|</span>
                        
                        <a class="<?php
                            if(!empty($_GET['accept'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>?accept=1"><i class="fa fa-download" aria-hidden="true"></i>Accept list</a>
                    </div>
                    <div class="search search__container">
                        <form action="">
                            <label for=""><i class="fa fa-filter" aria-hidden="true"></i>Filter</label>
                            <div class="control__form live__search">
                                <select name="academy_year" id="academy_year" class="selectpicker" data-live-search = "true">
                                    <option disabled selected>Academy year</option>
                                    <?php
                                        $acYearQry = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        if(mysqli_num_rows($acYearQry) > 0){
                                            while($acYearFetch = mysqli_fetch_assoc($acYearQry)){
                                    ?>
                                    <option <?php echo ($acYearFetch['year'] == $year_now)?'selected': ''?> value="<?=$acYearFetch['year'];?>">Year: <?=$acYearFetch['year'];?></option>
                                    <?php
                                            }
                                        }
                                        mysqli_free_result($acYearQry);
                                    ?>
                                </select>
                                <div class="border"></div>
                                <select name="semester_filter" id="semester_filter">
                                    <option disabled selected>Semester</option>
                                    <?php
                                        $semQry = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_of_study ='". $year_now ."'");
                                        if(mysqli_num_rows($semQry) > 0){
                                            while($semFetch = mysqli_fetch_assoc($semQry)){
                                    ?>
                                    <option value="<?=$semFetch['year_semester_id'];?>">Semester: <?=$semFetch['semester'];?></option>
                                    <?php
                                            }
                                        }
                                        mysqli_free_result($semQry);
                                    ?>
                                </select>
                                <div class="border"></div>
                                <input class="input" type="search" placeholder="By Teacher ID or Name..." id="score__filter">
                                <!-- <button type="submit" name="search"><i class="fa fa-search" aria-hidden="true"></i></button> -->
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                if(empty($_GET['accept'])){
                    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE score_submitted.submit_status = '0'
                                                        ORDER BY score_submitted.submit_date DESC
                                                        ");
                    if(mysqli_num_rows($submit_score) > 0){  
                        
            ?>
                <!-- <p>Request lists</p> -->
                <div class="table__manage width-100">
                    <div class="table_manage" id="score__submitted">
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
                    </div>
                </div>
            <?php
                    }else{
                        echo "<p>Score submitted no record.</p>";
                    }

                }else{
                    $submit_score = mysqli_query($conn, "SELECT * FROM score_submitted 
                                                        INNER JOIN teacher_info ON score_submitted.teacher_submit = teacher_info.teacher_id 
                                                        INNER JOIN schedule_study ON score_submitted.schedule_id = schedule_study.schedule_id
                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                        INNER JOIN class ON schedule_study.class_id = class.class_id
                                                        WHERE score_submitted.submit_status = '2'
                                                        ORDER BY score_submitted.submit_date DESC
                                                        ");
                    if(mysqli_num_rows($submit_score) > 0){  
                
            ?>
                    <div class="table__manage width-100">
                        <div class="table_manage" id="score__submitted">
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
                        </div>
                    </div>
            <?php
                    }else{
                        echo "<p>Score accepted no record.</p>";
                    }
                }
            ?>


                <!-- <div class="clear"></div> -->
           </div>

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    
    <!-- include javaScript in web page  -->
    <?php 
        include_once('ims-include/script-tage.php');
        if(empty($_GET['accept'])){
    ?>
       
        <!-- <script>
            $(document).ready(function(){
                $('#score__filter').on('input', function(){
                    var score__filter = $(this).val();
                    if(score__filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__filter='+score__filter,
                            success:function(html){
                                $('#score__submitted').html(html);
                            }
                        }); 
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__filter',
                            success:function(inner){
                                $('#score__submitted').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });
            });
        </script> -->

        <script>
            $(document).ready(function(){
                $('#semester_filter').on('change', function(){
                    // var score__filter = $('#score__filter').val();
                    var semester_filter = $('#semester_filter').val();

                    if(semester_filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__filter__semester='+semester_filter,
                            success:function(html){
                                $('#score__submitted').html(html);
                            }
                        }); 
                    }
                    
                });




                $('#score__filter').on('input', function(){
                    var score__filter = $('#score__filter').val();
                    var semester_filter = $('#semester_filter').val();


                    if(semester_filter != '' && score__filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:{score__filter:score__filter, semester_filter: semester_filter},
                            success:function(html){
                                $('#score__submitted').html(html);
                                // alert(semester_filter);
                            }
                        }); 
                    }

                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:{score__filter:score__filter, semester_filter: semester_filter},
                            success:function(inner){
                                $('#score__submitted').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });

                

                $('#score__filter').on('input', function(){
                    var score__filter = $('#score__filter').val();


                    if(score__filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__filter='+score__filter,
                            success:function(html){
                                $('#score__submitted').html(html);
                                // alert(score__filter);
                            }
                        }); 
                    }
                    
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__filter',
                            success:function(inner){
                                $('#score__submitted').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });








            });
        </script>

    <?php
        }else{
    ?>
        <script>
            $(document).ready(function(){
                $('#semester_filter').on('change', function(){
                    // var score__filter = $('#score__filter').val();
                    var semester_filter = $('#semester_filter').val();

                    if(semester_filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__accept__filter__semester='+semester_filter,
                            success:function(html){
                                $('#score__submitted').html(html);
                            }
                        }); 
                    }
                    
                });



                $('#score__filter').on('input', function(){
                    var score__filter = $('#score__filter').val();
                    var semester_filter = $('#semester_filter').val();


                    if(semester_filter != '' && score__filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:{score__accept__filter:score__filter, semester_filter: semester_filter},
                            success:function(html){
                                $('#score__submitted').html(html);
                                // alert(semester_filter);
                            }
                        }); 
                    }
                    
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:{score__accept__filter:score__filter, semester_filter: semester_filter},
                            success:function(inner){
                                $('#score__submitted').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });


                $('#score__filter').on('input', function(){
                    var score__filter = $('#score__filter').val();


                    if(score__filter != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__accept__filter='+score__filter,
                            success:function(html){
                                $('#score__submitted').html(html);
                                // alert(score__filter);
                            }
                        }); 
                    }
                    
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'score__accept__filter',
                            success:function(inner){
                                $('#score__submitted').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });




            });
        </script>



    <?php
        }
    ?>

        <script>
            $(document).ready(function(){
                $('#academy_year').on('change', function(){
                    var academy_year = $(this).val();
                    if(academy_year != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'academy_year_filter='+academy_year,
                            success:function(html){
                                $('#semester_filter').html(html);
                            }
                        }); 
                    }
                   
                });
            });
        </script>
</body>
</html>