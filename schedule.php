<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once("function.php");
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
                <h5 class="super__title">Schedule <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Schedule</p>
            </div>
            <div class="all__teacher schedule">
                <p><i class="fa fa-list-ul" aria-hidden="true"></i> Department list</p>        

                <div class="manage__major">
                    <?php
                        $major = mysqli_query($conn, "SELECT * FROM major INNER JOIN department ON major.department_id = department.department_id");
                        if(mysqli_num_rows($major) > 0){
                            while($result = mysqli_fetch_assoc($major)){
                    ?>
                    <div class="major border__left">
                        <div class="part" style="width: 80%;">
                            <p><small>Dep.</small> <b><?=$result['department'];?></b></p>
                            <!-- <p><small>Maj.</small> <=$result['major'];?></p> -->
                            <div class="link__manage">
                                <!-- <a href="<?=SITEURL;?>add-schedule.php?q=<?=$result['major_id'];?>"><i class="fa fa-plus" aria-hidden="true"></i> Schedule</a> -->
                                <a class="mt-2 w-100 text-center" href="<?=SITEURL;?>major-list.php?dep=<?=$result['department_id'];?>">Go to major... <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="part" style="width: 20%;">
                            <img width="100%" src="<?=SITEURL;?>ims-assets/ims-images/<?=$result['icon_name'];?>" alt="">
                        </div>
                    </div>
                    <?php
                            }
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

</body>
</html>