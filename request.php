<?php
    #DB connection

use Mpdf\Tag\Em;

    require_once('ims-db-connection.php');
    include_once('login-check.php');


    // request status changed 
    $change_status = mysqli_query($conn, "UPDATE requests SET notification = '0' WHERE notification = '1'");
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
                <h5 class="super__title">Request Transcript and Certificate <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Request</p>
           </div>
           <div class="all__teacher request__control">
                <div class="control__top">
                    <div class="department sub__menu">
                        <a class="<?php
                            if(empty($_GET['done']) && empty($_GET['accept']) && empty($_GET['reject'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>"><i class="fa fa-flag-checkered" aria-hidden="true"></i>New</a> <span class="px-1">|</span>
                        
                        <a class="<?php
                            if(!empty($_GET['accept'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>?accept=1"><i class="fa fa-download" aria-hidden="true"></i>Accept list</a> <span class="px-1">|</span>
                        <a class="<?php
                            if(!empty($_GET['reject'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>?reject=1"><i class="fa fa-times" aria-hidden="true"></i>Reject list</a> <span class="px-1">|</span>
                        <a class="<?php
                            if(!empty($_GET['done'])) echo 'active';
                        ?>" href="<?=SITEURL.basename($_SERVER['PHP_SELF']);?>?done=1"><i class="fa fa-check-circle-o" aria-hidden="true"></i>Done list</a> 
                    </div>

                    <div class="search request__search">
                        <form action="" method="post">
                            
                            <div class="request__form">
                                <label for="" style="margin: 0;"><i class="fa fa-filter" aria-hidden="true"></i>Filter </label>
                                <input type="search" placeholder="Enter student ID..." id="filter_request" name="filter_request">
                                <!-- <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> -->
                            </div>
                        </form>
                    </div>

                </div>

                
                <!-- <p>Request lists</p> -->
                <?php
                    if(!empty($_GET['done'])){
                ?>
                    <div class="table__manage width-100">
                        <?php
                            $request = mysqli_query($conn, "SELECT * FROM  student_info
                                                            INNER JOIN requests ON requests.student_id = student_info.student_id
                                                            WHERE request_status = '1'
                                                            ORDER BY request_date DESC");

                            if(mysqli_num_rows($request) > 0){
                        ?>
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Student ID</th>
                                        <th>Full name</th>
                                        <th class="table-width-50">Gender</th>
                                        <!-- <th>Phone number</th> -->
                                        <th>Request type</th>
                                        <th>Request date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="show_filter">
                                    <?php   
                                        $i = 1;                            
                                        while($request_result = mysqli_fetch_assoc($request)){                               
                                    ?>

                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$request_result['student_id'];?></td>
                                        <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                                        <td class="table-width-50"><?=ucfirst($request_result['gender']);?></td>
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
                                    ?>                          
                                </tbody>
                            </table>
                        </div>
                        <?php
                            }else{
                                echo '<p>No request found.';
                            }
                        ?>     
                    </div>
                <?php
                    }elseif(!empty($_GET['accept'])){
                ?>
                    <div class="table__manage width-100">
                        <?php
                            $request = mysqli_query($conn, "SELECT * FROM  student_info
                                                            INNER JOIN requests ON requests.student_id = student_info.student_id
                                                            WHERE feedback = 'accepted' AND request_status = '0'
                                                            ORDER BY request_date DESC");

                            if(mysqli_num_rows($request) > 0){
                        ?>
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Student ID</th>
                                        <th>Full name</th>
                                        <th class="table-width-50">Gender</th>
                                        <!-- <th>Phone number</th> -->
                                        <th>Request type</th>
                                        <th>Request date</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="show_filter">
                                    <?php   
                                        $i = 1;                            
                                        while($request_result = mysqli_fetch_assoc($request)){                               
                                    ?>

                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$request_result['student_id'];?></td>
                                        <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                                        <td class="table-width-50"><?=ucfirst($request_result['gender']);?></td>
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
                                    ?>                          
                                </tbody>
                            </table>
                        </div>
                        <?php
                            }else{
                                echo '<p>No request found.';
                            }
                        ?>     
                    </div>
                <?php
                    }elseif(!empty($_GET['reject'])){
                ?>
                    <div class="table__manage width-100">
                        <?php
                            $request = mysqli_query($conn, "SELECT * FROM  student_info
                                                            INNER JOIN requests ON requests.student_id = student_info.student_id
                                                            WHERE request_status = '2' AND feedback = 'rejected'
                                                            ORDER BY request_date DESC");

                            if(mysqli_num_rows($request) > 0){
                        ?>
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Student ID</th>
                                        <th>Full name</th>
                                        <th class="table-width-50">Gender</th>
                                        <!-- <th>Phone number</th> -->
                                        <th>Request type</th>
                                        <th>Request date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="show_filter">
                                    <?php   
                                        $i = 1;                            
                                        while($request_result = mysqli_fetch_assoc($request)){                               
                                    ?>

                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$request_result['student_id'];?></td>
                                        <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                                        <td class="table-width-50"><?=ucfirst($request_result['gender']);?></td>
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
                                    ?>                          
                                </tbody>
                            </table>
                        </div>
                        <?php
                            }else{
                                echo '<p>No request found.';
                            }
                        ?>     
                    </div>
                <?php
                    }else{
                ?>
                    <div class="table__manage width-100">
                        <?php
                            $request = mysqli_query($conn, "SELECT * FROM  student_info
                                                            INNER JOIN requests ON requests.student_id = student_info.student_id
                                                            WHERE request_status = '0'
                                                            ORDER BY request_date DESC");

                            if(mysqli_num_rows($request) > 0){
                        ?>
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Student ID</th>
                                        <th>Full name</th>
                                        <th class="table-width-50">Gender</th>
                                        <!-- <th>Phone number</th> -->
                                        <th>Request type</th>
                                        <th>Request date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="show_filter">
                                    <?php   
                                        $i = 1;                            
                                        while($request_result = mysqli_fetch_assoc($request)){                               
                                    ?>

                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$request_result['student_id'];?></td>
                                        <td><?=$request_result['firstname'] ." ".$request_result['lastname'];?></td>
                                        <td class="table-width-50"><?=ucfirst($request_result['gender']);?></td>
                                        <!-- <td>012458695</td> -->
                                        <td><?=$request_result['request_type'];?></td>
                                        <td><?php
                                            $request_date = date_create($request_result['request_date']);
                                            echo date_format($request_date, "m-d-Y");
                                        ?></td>
                                        <td>
                                            <a href="<?=SITEURL;?>request-detail.php?q=<?=$request_result['id'];?>" class="detail">Detail</a>
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
                        <?php
                            }else{
                                echo '<p>No request found.';
                            }
                        ?>     
                    </div>
                <?php
                    }
                ?>
                

                <!-- <div class="clear"></div> -->
           </div>

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>


    <?php
        if(!empty($_GET['done'])){
            // done request 
    ?>
        <script>
            $(document).ready(function(){
                $('#filter_request').on('input', function(){
                    var filter_request = $(this).val();
                    if(filter_request != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'done_filter_request='+filter_request,
                            success:function(html){
                                $('#show_filter').html(html);
                                // $('#city').html('<option value="">Select semester first</option>'); 
                            }
                        }); 
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'done_filter_request='+filter_request,
                            success:function(inner){
                                $('#show_filter').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });
            });
        </script>
    <?php
        }elseif(!empty($_GET['accept'])){
            // accept request filter 
    ?>
        <script>
            $(document).ready(function(){
                $('#filter_request').on('input', function(){
                    var filter_request = $(this).val();
                    if(filter_request != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'accept_filter_request='+filter_request,
                            success:function(html){
                                $('#show_filter').html(html);
                                // $('#city').html('<option value="">Select semester first</option>'); 
                            }
                        }); 
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'accept_filter_request='+filter_request,
                            success:function(inner){
                                $('#show_filter').html(inner);
                                // alert('Hello');
                            }
                        }); 
                    }
                });
            });
        </script>
    <?php
        }elseif(!empty($_GET['reject'])){
            // reject request filter 
    ?>
        <script>
            $(document).ready(function(){
                $('#filter_request').on('input', function(){
                    var filter_request = $(this).val();
                    if(filter_request != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'reject_filter_request='+filter_request,
                            success:function(html){
                                $('#show_filter').html(html);
                                // $('#city').html('<option value="">Select semester first</option>'); 
                            }
                        }); 
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'reject_filter_request='+filter_request,
                            success:function(inner){
                                $('#show_filter').html(inner);
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
                $('#filter_request').on('input', function(){
                    var filter_request = $(this).val();
                    if(filter_request != ''){
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'filter_request='+filter_request,
                            success:function(html){
                                $('#show_filter').html(html);
                                // $('#city').html('<option value="">Select semester first</option>'); 
                            }
                        }); 
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'ajaxData.php',
                            data:'filter_request='+filter_request,
                            success:function(inner){
                                $('#show_filter').html(inner);
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
    


</body>
</html>