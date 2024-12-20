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
                <h5 class="super__title">User and Role permission <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Role permission</p>
           </div>
           <div class="all__teacher">
                <div class="d-flex gap-5">
                    <div class="role__permission">
                        <p class="mb-3"><i class="fa fa-list-alt" aria-hidden="true"></i>Apply role permission</p>
                        <form action="<?=SITEURL;?>role-action.php" method="post">
                            <label for="user_role" class="fw-bold">- User role <span class="text-danger fw-0">*</span></label>
                            <select name="user_role" id="user_role" required class="selectpicker">
                                <option selected disabled>Please select role</option>
                                <?php
                                    $role = mysqli_query($conn, "SELECT * FROM role_permission ");
                                    while($row = mysqli_fetch_assoc($role)){
                                ?>
                                <option value="<?=$row['role_id'];?>">Role: <?=ucfirst($row['role_name']);?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                            <?php
                                if(isset($_SESSION['REQUIRED'])){
                            ?>
                            <small class="d-block mb-3 text-danger"><?=$_SESSION['REQUIRED'];?></small>
                            <?php
                                unset($_SESSION['REQUIRED']);
                                }

                                // if(empty($_POST['user_role'])){

                                
                            ?>
                            
                            <label for="" class="fw-bold mt-3">- Functions to apply</label>
                            <div id="control_checkbox">
                                <?php
                                    $i = 1;

                                    $function = mysqli_query($conn, "SELECT * FROM function");
                                    while($func_row = mysqli_fetch_assoc($function)){
                                        if($func_row['func_link'] != ''){
                                
                                        
                                ?>
                                    <div class="d-flex">
                                        <span class="me-4" style="width: 17px;"><?=$i++?>.</span><input type="checkbox" name="function[]" id="function_<?=$func_row['func_id'];?>" value="<?=$func_row['func_id'];?>"> <label for="function_<?=$func_row['func_id'];?>" class="ps-2"> <i class="<?=$func_row['func_icon'];?> text-secondary" aria-hidden="true"></i><?=$func_row['func_name'];?></label>
                                    </div>
                                    <?php
                                            }else{
                                    ?>
                                    <div class="d-flex">
                                        <span class="me-4" style="width: 17px;"><?=$i++?>.</span><input type="checkbox" name="function[]" id="function_<?=$func_row['func_id'];?>" value="<?=$func_row['func_id'];?>"> <label for="function_<?=$func_row['func_id'];?>" class="ps-2"><i class="<?=$func_row['func_icon'];?> text-secondary" aria-hidden="true"></i><?=$func_row['func_name'];?></label>
                                    </div>

                                    <?php
                                                                                
                                                $sub_func = mysqli_query($conn, "SELECT * FROM sub_function WHERE func_id ='". $func_row['func_id'] ."'");
                                                while($sub_row = mysqli_fetch_assoc($sub_func)){
                                    ?>


                                    <div class="d-flex" style="margin-left: 82px;">
                                        <input  type="checkbox" name="sub_function[]" id="sub_<?=$sub_row['sub_id'];?>" value="<?=$sub_row['sub_id'];?>"> <label for="sub_<?=$sub_row['sub_id'];?>"><i class="fa fa-circle text-secondary" style="font-size: 55%;" aria-hidden="true"></i><?=$sub_row['sub_name'];?></label>
                                    </div>
                                
                                <?php
                                            }

                                        }
                                    }
                            
                                ?>
                            </div>
                            <button class="apply_role btn" type="submit" name="apply_function"><i class="fa fa-check" aria-hidden="true"></i> Apply</button>
                        </form>
                    </div>

                    <div class="role__permission" >
                        <p class="mb-3"><i class="fa fa-user" aria-hidden="true"></i> Apply user permission</p>
                        <form action="<?=SITEURL;?>role-action.php" method="post">
                            <?php
                                if(isset($_SESSION['USER_REQUIRE'])){
                            ?>
                            <small class="d-block mb-1 p-1 px-2 text-danger alert alert-danger"><?=$_SESSION['USER_REQUIRE'];?></small>
                            <?php
                                unset($_SESSION['USER_REQUIRE']);
                                }                            
                            ?>
                            <label for="user" class="fw-bold">- User <span class="text-danger fw-0">*</span></label>
                            <select name="user_role" id="user" required  class="subject_list selectpicker d-block w-100 mb-3 mt-1" data-live-search="true">
                                <option selected disabled>Please select user</option>
                                <?php
                                    $i = 1;
                                    $role = mysqli_query($conn, "SELECT * FROM users WHERE role != 'admin'");
                                    while($row = mysqli_fetch_assoc($role)){
                                ?>
                                <option value="<?=$row['id'];?>"><?=$i++.". ". $row['username'] ." - ". $row['user_id'];?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>

                            <label for="" class="fw-bold">- Apply user role <span class="text-danger fw-0">*</span></label>
                            <div id="control_role">
                                <div class="d-flex">
                                    <span class="me-4" style="width: 17px;"><?=1?>.</span>
                                    <input type="checkbox" name="role[]" id="admin" value="admin"> 
                                    <label for="admin">Admin</label>
                                </div>
                                <?php
                                    $i = 2;
                                    $role = mysqli_query($conn, "SELECT * FROM role_permission LIMIT 1");
                                    while($row = mysqli_fetch_assoc($role)){
                                ?>

                                <div class="d-flex">
                                    <span class="me-4" style="width: 17px;"><?=$i++?>.</span>
                                    <input type="checkbox" name="role[]" id="role<?=$row['role_id'];?>" value="<?=$row['role_name'];?>">
                                    <label for="role<?=$row['role_id'];?>"><?=ucfirst($row['role_name']);?></label>
                                </div>

                                <?php
                                    }
                                ?>
                            </div>

                            <button class="apply_role btn" type="submit" name="apply_user"><i class="fa fa-check" aria-hidden="true"></i> Apply</button>
                        </form>
                    </div>
                </div>

           </div>
        
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>


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
                <a href="<?=SITEURL;?>permission.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>permission.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['GENERATE_ERROR']);

    ?>
<!-- pop up message when generate data success  -->


    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>


    
    <script>
        $(document).ready(function(){
            $('#user_role').on('change', function(){
                var user_role = $(this).val();
                if(user_role){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'user_role='+user_role,
                        success:function(html){
                            $('#control_checkbox').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });

            $('#user').on('change', function(){
                var user = $(this).val();
                if(user){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'user='+user,
                        success:function(html){
                            $('#control_role').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }                      
                    }); 
                }
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
    </script>


</body>
</html>