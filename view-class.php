<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once("function.php");
    include_once('login-check.php');

    if(!empty($_GET['dep'])){
        $dep_id = $_GET['dep'];
        $check_dep = mysqli_query($conn, "SELECT * FROM department WHERE department_id ='". $dep_id ."'");
        if(!mysqli_num_rows($check_dep) > 0){
            header("Location:". SITEURL ."major-list.php?dep=".$dep_id);
            exit(0);
        }else{
            $dep_fech = mysqli_fetch_assoc($check_dep);
            $department_name = $dep_fech['department'];
        }

    }
    else{
        header("Location:". SITEURL ."major-list.php?dep=".$dep_id);
        exit(0);
    }


    if(!empty($_GET['maj'])){
        $major_id = $_GET['maj'];
        $check_maj = mysqli_query($conn, "SELECT * FROM major WHERE major_id ='". $major_id ."'");
        if(!mysqli_num_rows($check_maj) > 0){
            header("Location:". SITEURL ."major-list.php?dep=".$dep_id);
            exit(0);
        }else{
            $maj_fetch = mysqli_fetch_assoc($check_maj);
            $major_name = $maj_fetch['major'];
        }
    }
    else{
        header("Location:". SITEURL ."major-list.php?dep=".$dep_id);
        exit(0);
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
                <h5 class="super__title">Schedule <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Schedule</p>
            </div>
            <div class="my-3">
                <a href="<?=SITEURL;?>major-list.php?dep=<?=$dep_id;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
            <div class="all__teacher schedule">
                <p><i class="fa fa-list-ul" aria-hidden="true"></i> Class list - in Dep. <b><?=ucfirst($department_name);?></b> - Maj. <b><?=ucfirst($major_name);?></b> 
                    <span id="major_id" class="d-none" style="display: none;"><?=$major_id;?></span>
                    <span id="department_id" class="d-none" style="display: none;"><?=$dep_id;?></span>
                </p>        
                <div class="mt-3 filter_class">
                    <p class="pe-2"><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                    <div class="select">
                        <select name="" id="year_filter" class="selectpicker" data-live-search="true">
                            <option disabled selected>Select year</option>
                            <?php
                                $year_sqry = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                if(mysqli_num_rows($year_sqry) > 0){
                                    while($year_sqry_data = mysqli_fetch_assoc($year_sqry)){
                                ?>
                                <option <?php echo ($year_now == $year_sqry_data['year'])? 'selected' : '';?> value="<?=$year_sqry_data['year'];?>">Year <?=$year_sqry_data['year'];?></option>
                                <?php
                                    }
                                }else{
                                    echo '<option disabled selected>Class not found.</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="manage__major" id="class_show">
                    <?php
                        $class = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."' AND year_of_study = '". $year_now ."'");
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
                                <a class="text-center w-50" href="<?=SITEURL;?>add-schedule.php?dep=<?=$dep_id;?>&maj=<?=$result['major_id'];?>&class=<?=$result['class_id'];?>"><i class="fa fa-plus" aria-hidden="true"></i> Add schedule</a>
                                <a class="text-center w-50" href="<?=SITEURL;?>view-schedule.php?dep=<?=$dep_id;?>&maj=<?=$result['major_id'];?>&class=<?=$result['class_id'];?>"><i class="fa fa-eye" aria-hidden="true"></i> View schedule</a>
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
                        <p class="mt-3"><span class="text-danger">No class record.</span> <a href="<?=SITEURL;?>manage-class.php" style="text-decoration: underline;">Manage class</a></p>
                    <?php
                        }
                    ?>                                                     
                </div>
            </div>
            
        
            <!-- footer  -->
            <?php include_once('ims-include/staff__footer.php');?>
        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>


    <script>
        $(document).ready(function(){
            $('#year_filter').on('change', function(){
                var class_yearFilter = $(this).val();
                var major_id = $('#major_id').html();
                var department_id = $('#department_id').html();
                if(class_yearFilter){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:{class_yearFilter: class_yearFilter,  major_id: major_id, department_id: department_id},
                        success:function(html){
                            $('#class_show').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });
        });
    </script>
</body>
</html>