<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once("function.php");
    include_once('login-check.php');

    if(!empty($_GET['dep'])){
        $dep_id = $_GET['dep'];
        $check_dep = mysqli_query($conn, "SELECT * FROM department WHERE department_id ='". $dep_id ."'");
        if(!mysqli_num_rows($check_dep) > 0){
            header("Location:". SITEURL ."schedule.php");
            exit(0);
        }else{
            $dep_fech = mysqli_fetch_assoc($check_dep);
            $department_name = $dep_fech['department'];
        }

    }else{
        header("Location:". SITEURL ."schedule.php");
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
                <a href="<?=SITEURL;?>schedule.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
            <div class="all__teacher schedule">
                <p><i class="fa fa-list-ul" aria-hidden="true"></i> Major list - in Dep. <b><?=ucfirst($department_name);?></b></p>        


                <div class="manage__major">
                    <?php
                        $major = mysqli_query($conn, "SELECT * FROM major INNER JOIN department ON major.department_id = department.department_id WHERE department.department_id ='". $dep_id ."'");
                        if(mysqli_num_rows($major) > 0){
                            while($result = mysqli_fetch_assoc($major)){
                    ?>
                    <div class="major border__left">
                        <div class="part" style="width: 100%;">
                            <p><small>Dep.</small> <b><?=$result['department'];?></b></p>
                            <p><small>Maj.</small> <b><?=$result['major'];?></b></p>
                            <div class="link__manage">
                                <a class="w-100 text-center" href="<?=SITEURL;?>view-class.php?dep=<?=$dep_id;?>&maj=<?=$result['major_id'];?>"><i class="fa fa-list-ul" aria-hidden="true"></i> Class list</a>
                                <!-- <a href="<?=SITEURL;?>view-schedule.php?q=<?=$result['major_id'];?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a> -->
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
                        <p class="mt-3"><span class="text-danger">No major record.</span> <a href="<?=SITEURL;?>manage-major.php" style="text-decoration: underline;">Manage major</a></p>

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

</body>
</html>