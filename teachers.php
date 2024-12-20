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

    <section id="sidebar__content" onclick="closeProfileDash()">
        
    <!-- sidebar  -->
    <?php
        include_once('ims-include/staff__sidebar.php');
    ?>

        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Teachers list <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Teachers</p>
           </div>
           <div class="all__teacher">
                <div class="control__top">
                    <div class="department">
                        <a class="add" href="<?=SITEURL?>add-teacher.php"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                    </div>
                    <div class="search">
                        <form action="" method="GET">
                            <label for="search" class="mb-0">Search</label>
                            <div class="control__form">
                                <input class="input" type="search" name="search" id="search" placeholder="Enter Name or ID...">
                                <button class="button filter-btn" type="submit" name="search-btn" value="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- GET MESSAGE FROM SQL ACTION HERE-->
                <?php
                    if(isset($_SESSION['MESSAGE_SQL'])){
                ?>
                    <samp class="message_show_success my-3 w-50 ms-auto"><span><span class="fw-bold"><i class="fa fa-check pe-2" aria-hidden="true"></i></span> <?=$_SESSION['MESSAGE_SQL'];?></span> <span><a href="<?php #echo SITEURL.trim(basename($_SERVER['PHP_SELF']));?>"><i class="fa fa-times" aria-hidden="true"></i></a></span></samp>
                <?php
                    unset($_SESSION['MESSAGE_SQL']);
                    }
                    elseif(isset($_SESSION['MESSAGE_SQL_ERROR'])){
                ?>
                    <samp class="message_show_error my-3 w-50 ms-auto"><span> <span class="fw-bold pe-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span> <?=$_SESSION['MESSAGE_SQL'];?></span><span><a href=""><i class="fa fa-times" aria-hidden="true"></i></a></span></samp>

                <?php
                    unset($_SESSION['MESSAGE_SQL_ERROR']);
                    }
                ?>
                <div class="table__manage">

                <!-- btn search not active  -->
                <?php
                    if(!isset($_GET['search-btn'])){
                        $teacher = mysqli_query($conn, "SELECT * FROM teacher_info");

                        $number_of_results = mysqli_num_rows($teacher);
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

                        $teacher = mysqli_query($conn, "SELECT * FROM teacher_info ORDER BY active_status DESC LIMIT $page_first_result, $result_per_page ");
                        if(mysqli_num_rows($teacher) > 0){
                ?>
                    <div class = "table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="no text-center">No.</th>
                                    <th>Teacher ID</th>
                                    <th>Fullname (KH)</th>
                                    <th>Fullname (EN)</th>
                                    <th style="width: 20px;">Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Phone number</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 1;
                                    while($teacher_data = mysqli_fetch_assoc($teacher)){
                                ?>
                                <tr class="<?php echo ($teacher_data['active_status'] == '0') ? 'text-danger' : '';?>">
                                    <td class="no text-center"><?php if(isset($_GET['page'])){
                                                if($_GET['page'] >1){
                                                    $next = ($_GET['page']-1)*$result_per_page+($i++);
                                                    echo $next;
                                                }else{
                                                    echo $i++;
                                                }
                                            }else{
                                                echo $i++;
                                            }
                                            ?></td>
                                    <td><?=$teacher_data['teacher_id'];?></td>
                                    <td>
                                        <?php 
                                            $fullname = $teacher_data['fn_khmer']." ".$teacher_data['ln_khmer'];
                                            if($fullname == ' '){
                                                echo '-';
                                            }else{
                                                echo $fullname;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $fullname = $teacher_data['fn_en']." ".$teacher_data['ln_en'];
                                            if($fullname == ' '){
                                                echo '-';
                                            }else{
                                                echo $fullname;
                                            }
                                        ?>
                                    </td>
                                    
                                    <td style="width: 20px;">
                                        <?php 
                                            if($teacher_data['gender'] == ''){
                                                echo '-';
                                            }else{
                                                echo ucfirst($teacher_data['gender']);
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($teacher_data['birth_date'] == ''){
                                                echo '-';
                                            }else{
                                                echo $teacher_data['birth_date'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($teacher_data['personal_phone'] == ''){
                                                echo '-';
                                            }else{
                                                echo $teacher_data['personal_phone'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($teacher_data['department_id'] == ''){
                                                echo '-';
                                            }else{
                                                $department_id =  $teacher_data['department_id'];
                                                $department = mysqli_query($conn, "SELECT * FROM department WHERE department_id='". $department_id ."'");
                                                if(mysqli_num_rows($department)){
                                                    $department_data = mysqli_fetch_assoc($department);
                                                    echo $department_data['department'];
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?=SITEURL;?>view-teacher.php?view-item=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data['id'];
    }else{
        echo $teacher_data['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>
                                        "><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="<?=SITEURL;?>add-teacher.php?update-id=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data['id'];
    }else{
        echo $teacher_data['id'] ."&".$_SERVER['QUERY_STRING'];
    }
    ?>                                    
                                        "><i class="fa fa-pencil" aria-hidden="true"></i></a>



                                        <a class="" href="<?=SITEURL;?>teacher-action.php?reset-id=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data['id'];
    }else{
        echo $teacher_data['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>
                                        "><i class="fa fa-refresh" aria-hidden="true"></i></a>



                                        <!-- <a class="delete" href="<=$_SERVER['PHP_SELF'];?>?delete-id=
    <php
        if($_SERVER['QUERY_STRING'] == ''){
            echo $teacher_data['id'];
        }else{
            echo $teacher_data['id'] ."&".$_SERVER['QUERY_STRING'];
        }
    ?>
                                        "><i class="fa fa-trash" aria-hidden="true"></i></a> -->

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
                            if(isset($_GET['page'])){
                                if($_GET['page'] <= 1){
                                    echo '1';
                                }else
                                    echo $_GET['page'] - 1;
                            }else{
                                echo '1';
                            }
                        ?>" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                        <span class="mx-2"><?php
                            if(isset($_GET['page'])) echo $_GET['page'];
                            else echo "1";
                        ?></span>
                        <a href="?page=<?php
                            if(isset($_GET['page'])){  
                                if($_GET['page'] < $number_of_page){
                                    echo $_GET['page']+1;
                                }else{
                                    if($_GET['page'] == $number_of_page){
                                        echo $number_of_page;
                                    }
                                }
                            }else{
                                if($number_of_page == 1){
                                    echo "1";
                                }else{
                                   echo '2';
                                }
                                // echo '2';
                            }
                        ?>" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div>
                <?php
                        }else{
                            echo 'No data found.';
                            echo " <a href = '".SITEURL."teachers.php'>Back</a>";
                        }
                        mysqli_free_result($teacher);
                    }else{
#######################################
#### btn search active here 
#######################################

                        if(isset($_GET['search']) != ''){
                            $search = mysqli_real_escape_string($conn, $_GET['search']);

                            $search_page = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id like '%$search%' OR fn_khmer like '%$search%' OR ln_khmer like '%$search%'
                            OR fn_en like '%$search%' OR ln_en like '%$search%'");

                                    $number_of_results = mysqli_num_rows($search_page);
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

                                $search_sql = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id like '%$search%' OR fn_khmer like '%$search%' OR ln_khmer like '%$search%'
                                OR fn_en like '%$search%' OR ln_en like '%$search%' ORDER BY active_status DESC LIMIT $page_first_result, $result_per_page");



                            if(mysqli_num_rows($search_sql) > 0){
                        ?>
                    <p class="mb-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching: <span class="fw-bold ps-2"> <?=$_GET['search'];?></span></p>
                    <div class="table_manage">
                    <table>
                        <thead>
                            <tr>
                                <th class="no text-center">No.</th>
                                <th>Teacher ID</th>
                                <th>Fullname (KH)</th>
                                <th>Fullname (EN)</th>
                                <th style="width: 20px;">Gender</th>
                                <th>Date of Birth</th>
                                <th>Phone number</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $i=1;
                                while($teacher_data_search = mysqli_fetch_assoc($search_sql)){
                        ?>
                            <tr class="<?php echo ($teacher_data_search['active_status'] == '0') ? 'text-danger' : '';?>">

                                <td class="no text-center"><?php if(isset($_GET['page'])){
                                            if($_GET['page'] >1){
                                                $next = ($_GET['page']-1)*$result_per_page+($i++);
                                                echo $next;
                                            }else{
                                                echo $i++;
                                            }
                                        }else{
                                            echo $i++;
                                        }
                                        ?></td>
                                <td><?=$teacher_data_search['teacher_id'];?></td>
                                <td>
                                    <?php 
                                        $fullname = $teacher_data_search['fn_khmer']." ".$teacher_data_search['ln_khmer'];
                                        if($fullname == ' '){
                                            echo '-';
                                        }else{
                                            echo $fullname;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $fullname = $teacher_data_search['fn_en']." ".$teacher_data_search['ln_en'];
                                        if($fullname == ' '){
                                            echo '-';
                                        }else{
                                            echo $fullname;
                                        }
                                    ?>
                                </td>
                                <td style="width: 20px;">
                                    <?php 
                                        if($teacher_data_search['gender'] == ''){
                                            echo '-';
                                        }else{
                                            echo ucfirst($teacher_data_search['gender']);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($teacher_data_search['birth_date'] == ''){
                                            echo '-';
                                        }else{
                                            echo $teacher_data_search['birth_date'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($teacher_data_search['personal_phone'] == ''){
                                            echo '-';
                                        }else{
                                            echo $teacher_data_search['personal_phone'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($teacher_data_search['department_id'] == ''){
                                            echo '-';
                                        }else{
                                            $department_id =  $teacher_data_search['department_id'];
                                            $department = mysqli_query($conn, "SELECT * FROM department WHERE department_id='". $department_id ."'");
                                            if(mysqli_num_rows($department)){
                                                $department_data = mysqli_fetch_assoc($department);
                                                echo $department_data['department'];
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?=SITEURL;?>view-teacher.php?view-item=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data_search['id'];
    }else{
        echo $teacher_data_search['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>
                                    "><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="<?=SITEURL;?>add-teacher.php?update-id=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data_search['id'];
    }else{
        echo $teacher_data_search['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>                                    
                                    "><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                    


                                    
                                    <a class="" href="<?=SITEURL;?>teacher-action.php?reset-id=
<?php
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data_search['id'];
    }else{
        echo $teacher_data_search['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>
                                    "><i class="fa fa-refresh" aria-hidden="true"></i></a>



                                    <!-- <a class="delete" href="<=$_SERVER['PHP_SELF'];?>?delete-id=
<
    if($_SERVER['QUERY_STRING'] == ''){
        echo $teacher_data_search['id'];
    }else{
        echo $teacher_data_search['id'] ."&".$_SERVER['QUERY_STRING'];
    }
?>
                                    "><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                </td>
                            </tr>


                        <?php
                                }
                        ?>
                        </tbody>
                    </table>
                    </div>
                    <div class="pagination">
                        <a href="?<?php
$url = $_SERVER['QUERY_STRING'];
if(isset($_GET['page'])){
    $new_url = str_replace('&page='.$_GET['page'], '', $url);
    echo $new_url;
}else{
echo $url;
}
?>
&page=<?php
if(isset($_GET['page'])){
    if($_GET['page'] <= 1){
        echo '1';
    }else
        echo $_GET['page'] - 1;
}else{
    echo '1';
}
?>" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                        <span class="mx-2"><?php
                            if(isset($_GET['page'])) echo $_GET['page'];
                            else echo "1";
                        ?></span>
                        <a href="?<?php
$url = $_SERVER['QUERY_STRING'];
if(isset($_GET['page'])){
    $new_url = str_replace('&page='.$_GET['page'], '', $url);
    echo $new_url;
}else{
echo $url;
}
?>&page=<?php
if(isset($_GET['page'])){  
    if($_GET['page'] < $number_of_page){
        echo $_GET['page']+1;
    }else{
        if($_GET['page'] == $number_of_page){
            echo $number_of_page;
        }
    }
}else{
    if($number_of_page == 1)echo 1;
    else echo 2;
}
?>" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div>

                        <?php
                            }else{
                                echo "Data not found. <a href = '".SITEURL."teachers.php'>Back</a>";
                            }
                        }else{
                            echo "Data not found. <a href = '".SITEURL."teachers.php'>Back</a>";
                        }

                    }
                ?>
                </div>
           </div>




           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>



<!-- delete TEACHER  -->
    <?php
        if(isset($_GET['delete-id'])){
            $check_id = "SELECT * FROM teacher_info WHERE id = '". $_GET['delete-id'] . "'";
            $check_id_run = mysqli_query($conn, $check_id);
            if(mysqli_num_rows($check_id_run) > 0){
    ?>    
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>Are you sure? Do you want to delete?</p>
            <p class="btn-control">
                <a href="<?=SITEURL;?>teacher-action.php?<?=$_SERVER['QUERY_STRING'];?>" class="ok">Ok</a>


                <a href="<?php 
                    if(isset($_SERVER['QUERY_STRING'])){
                        $query_string = $_SERVER['QUERY_STRING'];
                        if($query_string == 'delete-id='. $_GET['delete-id']){
                            echo $_SERVER['PHP_SELF'];
                        }else{
                            $new_query_string = str_replace('delete-id='.$_GET['delete-id']."&", '', $query_string);
                            if($new_query_string != ''){
                                echo $_SERVER['PHP_SELF']."?".$new_query_string;
                            }else{
                                echo $_SERVER['PHP_SELF'];
                                // $query_string = $_SERVER['QUERY_STRING'];
                                // $new_query_string = str_replace('?delete-id='.$_GET['delete-id'], '', $query_string);
                                // echo 'Hello';
                            }
                        }
                        
                    }            
                ?>" class="cancel">Cancel</a>
            </p>
        </div>
    </div>
    <?php
            }
        }
    ?>




<!-- delete TEACHER  -->
<?php
    ###########################
    ## RESET PASSWORD 
    ###########################
        if(isset($_SESSION['RESET_PASS'])){
    ?>    
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon"><i class="fa fa-refresh text-secondary" aria-hidden="true"></i></p>
            <p>Password will reset for: <span class="fw-bold"><?=$_SESSION['TEACHER_FULLNAME'];?></span></p>
            <p>Password reset: <span class="fw-bold">1234</span></p>
            <p class="btn-control">
                <a href="<?=SITEURL;?>teacher-action.php?<?=$_SESSION['RESET_PASS']."&".$_SERVER['QUERY_STRING'];?>" class="ok">Ok</a>


                <a href="<?=SITEURL;?>teachers.php<?php echo ($_SERVER['QUERY_STRING'] != '') ? '?'. $_SERVER['QUERY_STRING'] : '';?>" class="cancel">Cancel</a>
            </p>
        </div>
    </div>
    <?php
            
        }
        unset($_SESSION['RESET_PASS']);
        unset($_SESSION['TEACHER_FULLNAME']);
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
                <a href="<?=SITEURL;?>teachers.php<?php
                $query_string = $_SERVER['QUERY_STRING'];
                if($query_string != '' && !empty($_GET['update-id'])){
                    $url = trim(str_replace('update-id='. $_GET['update-id'], '', $query_string));
                    if($url != ''){
                        echo "?".$url;
                    }
                }else{
                    if($query_string != ''){
                        echo "?". $query_string;
                    }
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
                <a href="<?=SITEURL;?>teachers.php?<?php
                $query_string = $_SERVER['QUERY_STRING'];
                $url = trim(str_replace('update-id='. $_GET['update-id'], '', $query_string));
                echo $url;?>" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['GENERATE_ERROR']);

    ?>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>