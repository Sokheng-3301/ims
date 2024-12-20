<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    if(!empty($_GET['user-id'])){
        $update_id = $_GET['user-id'];
        $member = mysqli_query($conn, "SELECT * FROM users WHERE id ='". $update_id ."'");
        if(!mysqli_num_rows($member) > 0){
            header("Location:". SITEURL ."members.php");
            exit(0);
        }else{
            $result = mysqli_fetch_assoc($member);
            $role = explode(',', $result['role']);

            $array_length =  count($role);
        }

    }
    // else{
    //     header("Location:". SITEURL ."members.php");
    //     exit(0);
    // }
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
                if(!isset($_GET['user-id'])){
            ?>
                <h5 class="super__title">Add new admin<span><?=systemname?></span></h5>
            <?php
                }else{
            ?>
                <h5 class="super__title">Edit admin<span><?=systemname?></span></h5>
            <?php
                }
            ?>

                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add admin</p>
           </div>
           <div class="my-3">
                <a href="<?=SITEURL;?>members.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>
           <div class="add__member">

            <?php
                if(!isset($_GET['user-id'])){
            ?>
                <!-- Generate data form  -->
                <form action="member-action.php" method="post">
                    <div class="generate__data">
                        <?php
                            if(isset($_SESSION['REQUIERED'])){
                        ?>
                            <div class="alert alert-danger" role="alert">
                               <?=$_SESSION['REQUIERED'];?>
                            </div>
                        <?php
                            }unset($_SESSION['REQUIERED']);
                        ?>
                        <!-- <p>Generate data</p> -->
                        <label for="fullname">Fullname <span class="text-danger">*</span></label>
                        <input type="text" id="fullname" name="fullname" placeholder="Fullname...">

                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Email...">

                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" id="username" name="username" placeholder="Username...">

                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Password...">

                        <label for="confirm_password">Confirm password <span class="text-danger">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password...">

                        <!-- <label for="role" class="mb-1">Functional role  <span class="text-danger">*</span></label>
                        <div class="check__box">
                            <input type="radio" checked value="admin" id="admin" name="role"> <label for="admin">Admin</label>
                        </div>
                        <div class="check__box">
                            <input type="radio" value="officer" id="officer" name="role"> <label for="officer">Staff officer</label>
                        </div> -->


                        <button class="generate-btn" type="submit" name="add_member"><i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                    </div>
                </form>  
            <?php
                }else{                    
            ?>
                <!-- update data form  -->
                <form action="member-action.php" method="post">
                    <div class="generate__data">

                        <?php
                            if(isset($_SESSION['REQUIERED'])){
                        ?>
                            <div class="alert alert-danger" role="alert">
                               <?=$_SESSION['REQUIERED'];?>
                            </div>
                        <?php
                            }unset($_SESSION['REQUIERED']);
                        ?>

                        <!-- <p>Generate data</p> -->
                        <input type="hidden" name="update_id" value="<?=$update_id?>">
                        <!-- <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" id="username" name="username" placeholder="Username..." value="<?=$result['username'];?>"> -->

                        <!-- <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="text" id="password" name="password" placeholder="Password..."> -->

                       
                        <label for="fullname">Fullname<span class="text-danger">*</span></label>
                        <input type="text" id="fullname" name="fullname" placeholder="Fullname..." value="<?=$result['fullname'];?>">

                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" placeholder="Email..." value="<?=$result['user_email'];?>">

                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" id="username" name="username" placeholder="Username..." value="<?=$result['username'];?>">

                        <!-- <div class="check__box">
                            <input type="checkbox" value="Officer" id="officer" name="role[]"> <label for="officer">Staff officer</label>
                        </div> -->
                        <div class="d-flex">
                            <button class="generate-btn" type="submit" name="update_member"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>
                            <?php
                                if($result['active_status'] == '0'){
                            ?>
                                <a href="<?=SITEURL;?>member-action.php?reco=<?=$update_id;?>" class="recovery"><i class="fa fa-repeat" aria-hidden="true"></i>Enable user</a>
                            <?php
                                }else{
                            ?>
                                <a href="<?=SITEURL;?>member-action.php?id=<?=$update_id;?>" class="ban"><i class="fa fa-ban" aria-hidden="true"></i>Disable user</a>
                            <?php
                                }
                            ?>

                        </div>
                    </div>
                </form>
            <?php
                }
                // mysqli_free_result($member);
            ?>
                
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>
        </div>
    </section>


        <!-- add member done  -->
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
                <a href="<?=SITEURL;?>add-member.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE']);

        if(isset($_SESSION['ADD_NOT_DONE'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_NOT_DONE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>add-member.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_NOT_DONE']);
    ?>


    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>