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
                <h5 class="super__title">Dropout Student<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Dropout student</p>
           </div>
           <div class="all__teacher">
           <?php
                $i= 1;
                $student = mysqli_query($conn, "SELECT * FROM student_info  WHERE active_status = '0'");


                $number_of_results = mysqli_num_rows($student);
                $number_of_page = ceil ($number_of_results / $result_per_page);  

                if(empty($_GET['page'])){
                    $page = 1;

                }else{
                    if($_GET['page'] < 0){
                        $page = 1;
                    }else{
                        $page = $_GET['page'];
                    }
                }

                $page_first_result = ($page-1) * $result_per_page;  

                $student = mysqli_query($conn, "SELECT * FROM student_info WHERE active_status = '0'  LIMIT $page_first_result, $result_per_page");
                if(mysqli_num_rows($student) > 0){

                            
            ?>


           <div class="table__manage">  
                <div class="table_manage">               
                    <table>
                        <thead>
                            <tr>
                                <th class="no text-center">#</th>
                                <th>Student ID</th>
                                <th>Fullname (KH)</th>
                                <th>Fullname (EN)</th>
                                <th class="table-width-50">Gender</th>
                                <th>Date of birth</th>
                                <th>Class code</th>
                                <!-- <th class="no">Study status</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                while($student_data = mysqli_fetch_assoc($student)){
                            ?>
                            <tr>
                                <td class="no text-center">
                                        <?php if(isset($_GET['page'])){
                                            if($_GET['page'] >1){
                                                $next = ($_GET['page']-1)*$result_per_page+($i++);
                                                echo $next;
                                            }else{
                                                echo $i++;
                                            }
                                        }else{
                                            echo $i++;
                                        }
                                        ?>
                                </td>
                                <td><?=$student_data['student_id'];?></td>
                                <td><?=$student_data['fn_khmer']. " ". $student_data['ln_khmer'];?></td>
                                <td><?=$student_data['firstname']. " ". $student_data['lastname'];?></td>
                                <td class="table-width-50"><?=$student_data['gender'];?></td>
                                <td><?=$student_data['birth_date'];?></td>
                                <td>
                                    <?php
                                        $class = mysqli_query($conn, "SELECT * FROM class WHERE class_id ='". $student_data['class_id'] ."'");
                                        if(mysqli_num_rows($class) > 0){
                                            $class_data = mysqli_fetch_assoc($class);
                                            echo $class_data['class_code'];
                                        }else{
                                            echo "-";
                                        }
                                        // echo $student_data['class_id'];
                                    ?>
                                </td>
                                <!-- <td class="text-center no"><i class="fa fa-check-circle text-success" aria-hidden="true"></i></td> -->
                                <td>
                                    <a href="<?=SITEURL;?>view-student.php?view-item=<?=$student_data['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    
                                    <?php
                                        if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
                                    ?>
                                    <a href="<?=SITEURL;?>add-student.php?update-id=<?php echo $student_data['id'];
                                        if($_SERVER['QUERY_STRING'] != ''){
                                            echo "&".$_SERVER['QUERY_STRING'];
                                        }
                                    ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <!-- <a class="delete" href=""><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                    <a class="delete" href="<?=SITEURL;?>leave-students.php?delete=<?= $student_data['id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div> 
                <div class="pagination">
                    <a href="?page=<?php 
                    if(isset($_GET['page']) && $_GET['page'] > 1){
                        echo $_GET['page'] - 1;
                    }else{
                        echo '1';
                    }?>" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>

                    <span class="mx-2"><?php
                        if(isset($_GET['page'])) echo $_GET['page'];
                        else echo '1';
                    ?></span>

                    <a href="?page=<?php
                    if(isset($_GET['page'])){
                        if($_GET['page'] == $number_of_page){
                            echo $number_of_page;
                        }else{
                            echo $_GET['page'] + 1;
                        }
                    }else{
                        echo '2';
                    }?>" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                </div>
            </div>
               
           </div>
          
           

           <!-- footer  -->
           <?php 
                }else{
                    echo 'Leave student no record.';
                }
                            
            // mysqli_free_result($student);
            include_once('ims-include/staff__footer.php');
           ?>

        </div>
    </section>




    <!-- pop up message when generate data success  -->
    <?php
        if(isset($_SESSION['STD_DELETE'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['STD_DELETE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>leave-students.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['STD_DELETE']);
        if(isset($_SESSION['STD_DELETE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['STD_DELETE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>leave-students.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['STD_DELETE_ERROR']);

    ?>

    <!-- delete item  -->
    <?php
        if(isset($_GET['delete'])){
            $check_id = "SELECT * FROM student_info WHERE id = '". $_GET['delete'] . "'";
            $check_id_run = mysqli_query($conn, $check_id);
            if(mysqli_num_rows($check_id_run) > 0){
    ?>    
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>Are you sure? Do you want to delete?</p>
            <p class="btn-control">
                <a href="<?=SITEURL;?>student-action.php?delete=<?= $_GET['delete'];?>" class="ok">Ok</a>
                <a href="<?=SITEURL;?>leave-students.php" class="cancel">Cancel</a>
            </p>
        </div>
    </div>


    <?php
            }
        }
    ?>



    <!-- include javaScript in web page  -->
    <?php
        include_once('ims-include/script-tage.php');
        mysqli_close($conn);
    ?>


</body>
</html>