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
                <h5 class="super__title">Members list <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Members</p>
           </div>
           <div class="all__teacher">
                <div class="control__top">
                    <div class="department mt-2">
                        <a class="add" href="<?=SITEURL?>add-member.php"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                    </div>

                    <!-- <div class="search">
                        <form action="">
                            <label for="">Search</label>
                            <div class="control__form">
                                <input type="search" placeholder="Search here...">
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div> -->

                </div>
                <!-- ######################
                ###### admin list
                ###################### -->

                <div class="table__manage">
                    <p class="mb-2"><i class="fa fa-user text-secondary" aria-hidden="true"></i>Admins list</p>
                    <div class="table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="no text-center">#</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Create date</th>
                                    <!-- <th>Create by</th> -->
                                    <th class="text-center">Active status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $member = mysqli_query($conn, "SELECT * FROM users WHERE role = 'admin' AND default_user = '1'  ORDER BY active_status DESC , role ASC");
                                    
                                    while($resutl = mysqli_fetch_assoc($member)){
                                ?>
                                <tr>
                                    <td class="no text-center"><?=$i++;?></td>
                                    <td><?=$resutl['fullname'];?></td>
                                    <td><?=$resutl['user_email'];?></td>
                                    <td><?=$resutl['username'];?></td>
                                    <td><?=$resutl['create_date'];?></td>
                                    <!-- <td><=$resutl['create_by'];?></td> -->
                                    <td class="text-center <?php
                                        echo ($resutl['active_status'] == '1') ? 'text-success' : 'text-danger';                                   
                                    ?>">
                                        <i class="fa fa-<?php
                                            echo ($resutl['active_status'] == '1') ? 'check-circle' : 'times-circle';
                                        ?>" aria-hidden="true"></i>
                                        
                                    </td>

                                    <td>
                                        <!-- <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a> -->
                                        <a href="<?=SITEURL;?>add-member.php?user-id=<?=$resutl['id'];?>" title="Edit this user"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <!-- <a class="delete" href="" title="Ban this user"><i class="fa fa-ban" aria-hidden="true"></i></a> -->
                                        <a class="reset" href="<?=SITEURL;?>member-action.php?reset-id=<?=$resutl['id'];?>" title="Reset password"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                        <a class="delete" href="<?=SITEURL;?>member-action.php?delete-id=<?=$resutl['id'];?>" title="Delete this user"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>


                                <?php
                                    }
                                    mysqli_free_result($member);
                                ?>
                            </tbody>
                        </table>
                    </div> 
                    <!-- <div class="pagination">
                        <a href="" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>
                        <a href="" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div> -->
                </div>
                <hr class="mt-4">





                <!-- ###############################
                ###### Teacher and officer list
                #################################### -->
                <div class="table__manage">
                    <p class="mb-2"><i class="fa fa-users text-secondary" aria-hidden="true"></i>Staffs officer list</p>

                    <div class="table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="no text-center">#</th>
                                    <th>Teacher ID</th>
                                    <th>Fullname (KH)</th>
                                    <th>Fullname (EN)</th>
                                    <th>Username</th>
                                    <!-- <th>User role</th> -->
                                    <th class="text-center">Active status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    $member = mysqli_query($conn, "SELECT * FROM  teacher_info
                                                                    INNER JOIN users ON users.user_id = teacher_info.teacher_id
                                                                    WHERE users.role != 'admin' 
                                                                    ORDER BY users.active_status DESC ,users.role ASC");
                                    while($resutl = mysqli_fetch_assoc($member)){
                                        $role = $resutl['role'];
                                        $role = explode(",", $role);
                                        foreach($role as $role){
                                            if($role == 'officer'){
                                
                                            
                                        // print_r($resutl);
                                    ?>
                                    <tr>
                                        <td class="no text-center"><?=$i++;?></td>
                                        <td><?=$resutl['user_id'];?></td>
                                        <td><?=$resutl['fn_en']." ".$resutl['ln_en'];?></td>
                                        <td><?=$resutl['fn_khmer']." ".$resutl['ln_khmer'];?></td>

                                        <td><?=$resutl['username'];?></td>
                                        <!-- <td>Staff officer</td> -->
                                        <td class="text-center <?php
                                            echo ($resutl['active_status'] == '1') ? 'text-success' : 'text-danger';                                   
                                        ?>">
                                            <i class="fa fa-<?php
                                                echo ($resutl['active_status'] == '1') ? 'check-circle' : 'times-circle';
                                            ?>" aria-hidden="true"></i>
                                            
                                        </td>

                                        <td>
                                            <!-- <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a> -->
                                            <!-- <a href="<?=SITEURL;?>add-member.php?user-id=<?=$resutl['id'];?>" title="Edit this user"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
                                            <!-- <a class="delete" href="" title="Ban this user"><i class="fa fa-ban" aria-hidden="true"></i></a> -->
                                            <a class="reset" href="<?=SITEURL;?>member-action.php?reset-id=<?=$resutl['id'];?>" title="Reset password"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <?php
                                                if($resutl['active_status'] == '1'){
                                            ?>
                                            <a class="delete" href="<?=SITEURL;?>member-action.php?delete-id=<?=$resutl['id'];?>" title="Disabled user"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                            <?php
                                                }else{
                                            ?>
                                            <a class="" href="<?=SITEURL;?>member-action.php?enable-id=<?=$resutl['id'];?>" title="Enabled user"><i class="fa fa-undo" aria-hidden="true"></i></a>
                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    mysqli_free_result($member);
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="pagination">
                        <a href="" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>
                        <a href="" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div> -->
                </div>
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>


    <!-- Update member done  -->
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
                <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_NOT_DONE']);

        if(isset($_SESSION['DELETE_ID'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                Do you want to disabled this user?
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>member-action.php?disabled=<?=$_SESSION['DELETE_ID'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
                <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-warning px-4 ms-2">Cancel</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['DELETE_ID']);

        if(isset($_SESSION['RESET_ID'])){

            $username = mysqli_query($conn, "SELECT * FROM users WHERE id ='". $_SESSION['RESET_ID'] ."'");
            if(mysqli_num_rows($username) > 0){
                $resutl = mysqli_fetch_assoc($username);
                if($resutl['role'] == 'admin'){

                    ##############################
                    ### USER ROLE ADMIN ONLY
                    ##############################

                   
                
    ?>
        <div id="popUp">
            <div class="form__verify text-center">
                <p class="text-center icon text-secondary"><i class="fa fa-refresh" aria-hidden="true"></i></p>              
                <p>                    
                    Password will reset for username : <span class="fw-bold text-danger"><?=$resutl['username'];?></span> <br>
                    Password reset : <span class="fw-bold text-danger">1234</span>
                </p>
                <p class="mt-4">
                    <a href="<?=SITEURL;?>member-action.php?reset=<?=$_SESSION['RESET_ID'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
                    <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-warning px-4 ms-2">Cancel</a>
                </p>                           
            </div>
        </div>

        <?php
                }else{

                    ##############################
                    ### USER ROLE TEACHER
                    ##############################

                    $teacher = mysqli_query($conn, "SELECT * FROM users INNER JOIN teacher_info ON users.user_id = teacher_info.teacher_id WHERE users.id = '". $_SESSION['RESET_ID'] ."'");
                    if(mysqli_num_rows($teacher) > 0){
                    
        ?>
            <div id="popUp">
            <div class="form__verify text-center">
                <p class="text-center icon text-secondary"><i class="fa fa-refresh" aria-hidden="true"></i></p>              
                <p>                    
                    Password will reset for username : <span class="fw-bold text-danger"><?=$resutl['username'];?></span> <br>
                    Password reset : <span class="fw-bold text-danger">1234</span>
                </p>
                <p class="mt-4">
                    <a href="<?=SITEURL;?>member-action.php?reset=<?=$_SESSION['RESET_ID'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
                    <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-warning px-4 ms-2">Cancel</a>
                </p>                
            </div>
        </div>
        <?php
                    }
                }
            }
        }
        unset($_SESSION['RESET_ID']);
        // mysqli_free_result($username);

        if(isset($_SESSION['ENABLED_ID'])){
        ?>
        <div id="popUp">
            <div class="form__verify text-center">
                <p class="text-center icon text-secondary"><i class="fa fa-undo" aria-hidden="true"></i></p>
                <p>
                    Do you want to enable this user?
                </p>
                <p class="mt-4">
                    <a href="<?=SITEURL;?>member-action.php?enable=<?=$_SESSION['ENABLED_ID'];?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
                    <a href="<?=SITEURL;?>members.php" class="ok btn btn-sm btn-warning px-4 ms-2">Cancel</a>
                </p>
            </div>
        </div>
        <?php
            }
            unset($_SESSION['ENABLED_ID']);
        
    ?>




    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>