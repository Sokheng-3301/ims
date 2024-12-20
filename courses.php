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
                <h5 class="super__title">Course description <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Course</p>
           </div>
           <div class="all__teacher">
                <div class="control__top">
                    <div class="department">
                        <a class="add" href="<?=SITEURL?>add-course.php"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                    </div>
                    <div class="search">
                        <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" class="course__filter">
                            <!-- <label for="">Search</label> -->
                            <div class="control__form course_filter">
                                <input type="hidden" 
                                name="<?php
                                    // if(isset($_GET['page'])){
                                    //     echo "page";
                                    // }
                                ?>"
                                value="<?php
                                    // if(isset($_GET['page'])){
                                    //     echo $_GET['page'];
                                    // }
                                ?>">
                                <select name="department" id="" class="selectpicker" data-live-search = "true">
                                    <option selected disabled>Select department</option>
                                <?php
                                    $i=1;
                                    $department = mysqli_query($conn, "SELECT * FROM department");
                                    while($department_data = mysqli_fetch_assoc($department)){
                                        if(isset($_GET['search_btn']) && isset($_GET['department'])){
                                
                                        
                                ?>
                                    <option value="<?=$department_data['department_id'];?>"
                                            <?php
                                                if($_GET['department'] == $department_data['department_id']){
                                                    echo 'selected';
                                                }
                                            ?>
                                    ><?=$department_data['department'];?></option>
                                <?php
                                        }else{
                                ?>
                                <option value="<?=$department_data['department_id'];?>"><?=$i++. ". ".$department_data['department'];?></option>
                                <?php
                                        }
                                    }
                                    mysqli_free_result($department);
                                ?>
                                </select>
                                <div class="part"></div>
                                <input class="input filter" type="search" name="search" placeholder="Course code or name..." value="<?php if(isset($_GET['search_btn'])) echo $_GET['search'];?>">
                                <button class="button filter-btn" type="submit" name="search_btn" value="search"><i class="fa fa-search" aria-hidden="true"></i></button>
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

                <?php
                    if(!isset($_GET['search_btn'])){
                ?>

                    <div class="table__manage" id="table_data">
                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="no text-center">#</th>
                                        <th>Subject code</th>
                                        <th>Subject name</th>
                                        <th class="text-center">Credit</th>
                                        <th>Instructor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $course = "SELECT * FROM course";
                                        $course_run = mysqli_query($conn, $course);

                                        $number_of_results = mysqli_num_rows($course_run);
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

                                        




                                        $course = "SELECT * FROM course LIMIT $page_first_result, $result_per_page";
                                        $course_run = mysqli_query($conn, $course);
                                        if(mysqli_num_rows($course_run) > 0){
                                            $i = 1;
                                            while($data = mysqli_fetch_assoc($course_run)){                                       
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
                                        <td><?=$data['subject_code'];?></td>
                                        <td><?=$data['subject_name'];?></td>
                                        <td class="text-center"><?=$data['credit'] . "(" . $data['theory'] . ". " . $data['execute'] . ". " . $data['apply'] .")";?></td>
                                        <td>
                                            <?php
                                                // $data['teaching_by'];
                                                $instructor = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id ='". $data['teaching_by']."'");

                                                if(mysqli_num_rows($instructor) > 0){
                                                    $instructor_name = mysqli_fetch_assoc($instructor);
                                                    echo $instructor_name['fn_en']. " " .$instructor_name['ln_en'];
                                                }

                                                mysqli_free_result($instructor);
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?=$_SERVER['PHP_SELF'];?>?view-item=<?php echo $data['id']."&".$_SERVER['QUERY_STRING'];?>#viewdetial"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="<?=SITEURL;?>add-course.php?update-id=<?=$data['id']."&".$_SERVER['QUERY_STRING'];?>#update"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                            <?php
                                                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
                                            ?>
                                            <a class="delete" href="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>&delete-id=<?=$data['id'];?>#deletecourse"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination without search btn active  sumerize pagination all of data-->

                        <div class="pagination">
                            <a href="
                                    <?php
                                        if(isset($_GET['page']) && $_GET['page'] > 1){
                                            echo "?page=".$_GET['page']-1;
                                        }
                                    ?>
                            " class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                            <span class="mx-2">
                                <?php
                                    if(isset($_GET['page'])){
                                        echo $_GET['page'];
                                    }else{
                                        echo '1';
                                    }
                                ?>
                            </span>
                            <a href="
                                    <?php
                                        if(isset($_GET['page']) && $_GET['page'] < $number_of_page){
                                            echo "?page=".$_GET['page']+1;
                                        }elseif(isset($_GET['page']) == $number_of_page){
                                            echo "?page=". $number_of_page;
                                        }
                                        else{
                                            echo "?page=2";
                                        }
                                    ?>  
                            " class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <?php
                        // SEARCH BTN ACTIVED
                    }else{
                        $course_search = mysqli_real_escape_string($conn, $_GET['search']);
                        // $page = 1;
                        // print_r($_GET['page']);
                        // exit;
                        if($course_search != ''){
                            if(isset($_GET['department'])){
                                $department_name = mysqli_real_escape_string($conn, $_GET['department']);


                                $course = "SELECT * FROM course WHERE department_id = '". $department_name ."' AND subject_code like '%". $course_search ."%' OR subject_name like '%" . $course_search . "%'";
                                $course_run = mysqli_query($conn, $course);

                                $number_of_results = mysqli_num_rows($course_run);
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


                                $course = "SELECT * FROM course WHERE department_id = '". $department_name ."' AND subject_code like '%". $course_search ."%' OR subject_name like '%" . $course_search . "%' LIMIT $page_first_result, $result_per_page";
                                $course_run = mysqli_query($conn, $course);
                                if(mysqli_num_rows($course_run) > 0){
                                    $i = 1;
                    ?>
                        <p class="my-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching : <b> <?=$course_search;?></b></p>
                        <div class="table__manage">
                            <div class="table_manage">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="no text-center">#</th>
                                            <th>Subject code</th>
                                            <th>Subject name</th>
                                            <th class="text-center">Credit</th>
                                            <th>Instructor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        while($data = mysqli_fetch_assoc($course_run)){
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
                                            <td><?=$data['subject_code'];?></td>
                                            <td><?=$data['subject_name'];?></td>
                                            <td class="text-center"><?=$data['credit'] . "(" . $data['theory'] . ". " . $data['execute'] . ". " . $data['apply'] .")";?></td>
                                            <td>
                                                <?php
                                                    // $data['teaching_by'];
                                                    $instructor = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id ='". $data['teaching_by']."'");

                                                    if(mysqli_num_rows($instructor) > 0){
                                                        $instructor_name = mysqli_fetch_assoc($instructor);
                                                        echo $instructor_name['fn_en']. " " .$instructor_name['ln_en'];
                                                    }

                                                    mysqli_free_result($instructor);
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?=$_SERVER['PHP_SELF'];?>?view-item=<?php echo $data['id']."&".$_SERVER['QUERY_STRING'];?>#viewdetial"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="<?=SITEURL;?>add-course.php?update-id=<?=$data['id']."&".$_SERVER['QUERY_STRING'];?>#update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a class="delete" href="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>&delete-id=<?=$data['id'];?>#deletecourse"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }   
                                                        
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- pagination with search btn active and reqire with department name to search-->
                            <div class="pagination">
                                <a href="
                                    <?php
                                        // back btn 
                                        if(isset($_GET['search_btn'])){                                               
                                            if(isset($_GET['page'])){
                                               if($_GET['page'] > 1){
                                                    $bansename = $_SERVER['PHP_SELF'];
                                                    $old_url = $_SERVER['QUERY_STRING'];
                                                    
                                                    $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] - 1, $old_url);

                                                    echo $bansename ."?". $new_url;
                                               }else{
                                                    echo "?". $_SERVER['QUERY_STRING'];
                                               }
                                            }
                                        }                                                                      
                                    
                                    ?>
                                " class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                                <span class="mx-2">
                                    <?php
                                        if(isset($_GET['page'])){
                                            echo $_GET['page'];
                                        }else{
                                            echo '1';
                                        }
                                    ?>
                                </span>
                                <a href="
                                    <?php
                                        // next btn 
                                        if(isset($_GET['search_btn'])){                                               
                                            if(isset($_GET['page'])){

                                               if($_GET['page'] < $number_of_page){
                                                    $bansename = $_SERVER['PHP_SELF'];
                                                    $old_url = $_SERVER['QUERY_STRING'];
                                                    
                                                    $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] + 1, $old_url);

                                                    echo $bansename ."?". $new_url;
                                               }else{
                                                    echo "?". $_SERVER['QUERY_STRING'];
                                               }
                                            }else{
                                               
                                                if($number_of_page <= 1){
                                                    $url = "?". $_SERVER['QUERY_STRING'] . "&page=".$number_of_page;
                                                    echo $url;
                                                }else{
                                                    // $sub_number_page = $number_of_page - ($number_of_page-1);
                                                    $url = "?". $_SERVER['QUERY_STRING'] . "&page=2";
                                                    echo $url;
                                                }
                                            }
                                        }                                                                      
                                    ?>
                                " class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    <?php
                            }else{
                    ?>
                            <p class="my-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching : <b><?= $course_search;?></b></p>
                    <?php
                                echo 'No results found. <a href="'.SITEURL.'courses.php">Back</a>';
                                // exit(0);
                            }
                         
                        }else{

                            $course = "SELECT * FROM course WHERE subject_code like '%". $course_search ."%' or subject_name like '%" . $course_search . "%'";
                            $course_run = mysqli_query($conn, $course);
                            $number_of_results = mysqli_num_rows($course_run);
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

 
                            $course = "SELECT * FROM course WHERE subject_code like '%". $course_search ."%' or subject_name like '%" . $course_search . "%' LIMIT $page_first_result, $result_per_page";
                            $course_run = mysqli_query($conn, $course);

                            if(mysqli_num_rows($course_run) > 0){
                                $i = 1;
                    ?>
                        <p class="my-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching : <b><?= $course_search;?></b></p>
                        <div class="table__manage">
                            <div class="table_manage">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="no text-center">#</th>
                                            <th>Subject code</th>
                                            <th>Subject name</th>
                                            <th class="text-center">Credit</th>
                                            <th class="text-center">Instructor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                <?php
                                    while($data = mysqli_fetch_assoc($course_run)){
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
                                        <td><?=$data['subject_code'];?></td>
                                        <td><?=$data['subject_name'];?></td>
                                        <td class="text-center"><?=$data['credit'] . "(" . $data['theory'] . ". " . $data['execute'] . ". " . $data['apply'] .")";?></td>
                                        <td>
                                        <?php
                                                // $data['teaching_by'];
                                                $instructor = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id ='". $data['teaching_by']."'");

                                                if(mysqli_num_rows($instructor) > 0){
                                                    $instructor_name = mysqli_fetch_assoc($instructor);
                                                    echo $instructor_name['fn_en']. " " .$instructor_name['ln_en'];
                                                }

                                                mysqli_free_result($instructor);
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?=$_SERVER['PHP_SELF'];?>?view-item=<?php echo $data['id']."&".$_SERVER['QUERY_STRING'];?>#viewdetial"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <a href="<?=SITEURL;?>add-course.php?update-id=<?=$data['id']."&".$_SERVER['QUERY_STRING'];?>#update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a class="delete" href="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>&delete-id=<?=$data['id'];?>#deletecourse"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }   
                                                    
                                ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- pagination width search btn active but not require with department search  -->
                            <div class="pagination">
                                <a href="
                                    <?php
                                        if(isset($_GET['search_btn'])){                                               
                                            if(isset($_GET['page'])){
                                               if($_GET['page'] > 1){
                                                    $bansename = $_SERVER['PHP_SELF'];
                                                    $old_url = $_SERVER['QUERY_STRING'];
                                                    
                                                    $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] - 1, $old_url);

                                                    echo $bansename ."?". $new_url;
                                               }else{
                                                    echo "?". $_SERVER['QUERY_STRING'];
                                               }
                                            }
                                        }             
                                    ?>
                                " class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                                <span class="mx-2">
                                    <?php
                                        if(isset($_GET['page'])){
                                            echo $_GET['page'];
                                        }else{
                                            echo '1';
                                        }
                                    ?>
                                </span>
                                <a href="
                                <?php
                                    // next page 
                                    if(isset($_GET['page'])){
                                        if($_GET['page'] < $number_of_page){
                                            $bansename = $_SERVER['PHP_SELF'];
                                            $old_url = $_SERVER['QUERY_STRING'];
                                            
                                            $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] + 1, $old_url);

                                            echo $bansename ."?". $new_url;
                                       }else{
                                            echo "?". $_SERVER['QUERY_STRING'];
                                       }
                                    }else{
                                        if($number_of_page <=1){
                                            echo "?".$_SERVER['QUERY_STRING']. "&page=".$number_of_page;
                                        }else{
                                            echo "?".$_SERVER['QUERY_STRING']. "&page=2";
                                        }
                                    }
                                ?>
                                
                                " class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    <?php
                            }else{
                    ?>
                                <p class="my-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching : <b><?= $course_search;?></b></p>

                    <?php
                                echo 'No results found. <a href="'.SITEURL.'courses.php">Back</a>';
                            }   
                        }
                        
                    }else{
                        // search by department only . 
                        if(isset($_GET['department'])){
                            $department = mysqli_real_escape_string($conn, $_GET['department']);

                            $course = "SELECT * FROM course WHERE department_id like '%". $department."%'";
                            $course_run = mysqli_query($conn, $course);
                            $number_of_results = mysqli_num_rows($course_run);
                            $number_of_page = ceil ($number_of_results / $result_per_page);  

                            // echo $number_of_page;
                            // exit;

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
    
                            $course = "SELECT * FROM course WHERE department_id like '%". $department."%' LIMIT $page_first_result, $result_per_page";
                            $course_run = mysqli_query($conn, $course);

                            if(mysqli_num_rows($course_run) > 0){
                                $i = 1;
                            ?>
                            <p class="my-3"><i class="fa fa-search" aria-hidden="true"></i> You are searching : 
                                <b>
                                    <?php 
                                        $show_departmen_search = mysqli_query($conn, "SELECT * FROM department WHERE department_id ='". $department ."'");
                                        $result = mysqli_fetch_assoc($show_departmen_search);
                                        echo $result['department'];
                                    ?>
                                </b>
                            </p>
                            <div class="table__manage">
                                <div class="table_manage">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="no text-center">#</th>
                                                <th>Subject code</th>
                                                <th>Subject name</th>
                                                <th class="text-center">Credit</th>
                                                <th class="text-center">Instructor</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                
                                    <?php
                                        while($data = mysqli_fetch_assoc($course_run)){
                                            
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
                                            <td><?=$data['subject_code'];?></td>
                                            <td><?=$data['subject_name'];?></td>
                                            <td class="text-center"><?=$data['credit'] . "(" . $data['theory'] . ". " . $data['execute'] . ". " . $data['apply'] .")";?></td>
                                            <td>
                                                <?php
                                                    // $data['teaching_by'];
                                                    $instructor = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id ='". $data['teaching_by']."'");

                                                    if(mysqli_num_rows($instructor) > 0){
                                                        $instructor_name = mysqli_fetch_assoc($instructor);
                                                        echo $instructor_name['fn_en']. " " .$instructor_name['ln_en'];
                                                    }

                                                    mysqli_free_result($instructor);
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?=$_SERVER['PHP_SELF'];?>?view-item=<?php echo $data['id']."&".$_SERVER['QUERY_STRING'];?>#viewdetial"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href="<?=SITEURL;?>add-course.php?update-id=<?=$data['id']."&".$_SERVER['QUERY_STRING'];?>#update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a class="delete" href="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>&delete-id=<?=$data['id'];?>#deletecourse"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }   
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- pagination with search by department only.  -->
                                <div class="pagination">
                                    <a href="
                                        <?php
                                            if(isset($_GET['search_btn'])){                                               
                                                if(isset($_GET['page'])){
                                                if($_GET['page'] > 1){
                                                        $bansename = $_SERVER['PHP_SELF'];
                                                        $old_url = $_SERVER['QUERY_STRING'];
                                                        
                                                        $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] - 1, $old_url);

                                                        echo $bansename ."?". $new_url;
                                                }else{
                                                        echo "?". $_SERVER['QUERY_STRING'];
                                                }
                                                }
                                            }             
                                        ?>
                                    " class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>
                                    <span class="mx-2">
                                        <?php
                                            if(isset($_GET['page'])){
                                                echo $_GET['page'];
                                            }else{
                                                echo '1';
                                            }
                                        ?>
                                    </span>
                                    <a href="
                                    <?php
                                        // next page 
                                        if(isset($_GET['page'])){
                                            if($_GET['page'] < $number_of_page){
                                                $bansename = $_SERVER['PHP_SELF'];
                                                $old_url = $_SERVER['QUERY_STRING'];
                                                
                                                $new_url = str_replace('page='. $_GET['page'], 'page='.$_GET['page'] + 1, $old_url);

                                                echo $bansename ."?". $new_url;
                                        }else{
                                                echo "?". $_SERVER['QUERY_STRING'];
                                        }
                                        }else{
                                            if($number_of_page <=1){
                                                echo "?".$_SERVER['QUERY_STRING']. "&page=".$number_of_page;
                                            }else{
                                                echo "?".$_SERVER['QUERY_STRING']. "&page=2";
                                            }
                                        }
                                    ?>
                                    
                                    " class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                                </div>

                                    </div>
                            <?php
                            }else{
                                echo 'No results found. <a href="'.SITEURL.'courses.php">Back</a>';
                            }
                        }else{
                            echo 'No results found. <a href="'.SITEURL.'courses.php">Back</a>';
                            
                        }
                    }
                }
                ?>
           </div>


           
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>

<!-- delete item  -->
    <?php
        if(isset($_GET['delete-id'])){
            $check_id = "SELECT * FROM course WHERE id = '". $_GET['delete-id'] . "'";
            $check_id_run = mysqli_query($conn, $check_id);
            if(mysqli_num_rows($check_id_run) > 0){
    ?>    
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>Are you sure? Do you want to delete?</p>
            <p class="btn-control">
                <a href="<?=SITEURL;?>course-action.php?delete-id=<?=$_GET['delete-id'];?>" class="ok">Ok</a>
                <a href="
                <?php 
                    if(isset($_GET['delete-id'])){
                        $query_string = $_SERVER['QUERY_STRING'];
                        $new_query_string = str_replace('&delete-id='.$_GET['delete-id'], "", $query_string);
                        echo $_SERVER['PHP_SELF']."?".$new_query_string;
                    }                
                ?>" class="cancel">Cancel</a>
            </p>
        </div>
    </div>


    <?php
            }
        }

        #<!--//////////// course detail here  \\\\\\\\\\\\\\\\\\-->
        if(isset($_GET['view-item'])){
            $id = $_GET['view-item'];
            $course_detail = "SELECT * FROM course WHERE id ='". $id ."'";
            $course_detail_run = mysqli_query($conn, $course_detail);
            if(mysqli_num_rows($course_detail_run) > 0){
                $detail = mysqli_fetch_assoc($course_detail_run);
    ?> 

    <div id="popUp">
        <div class="course__description">
            <p class="title">
                <span>Course description detial</span>
                <span>
                    <a href="<?php
                        if(isset($_GET['view-item'])){
                            $bansename = $_SERVER['PHP_SELF'];
                            $old_url = $_SERVER['QUERY_STRING'];
                            
                            $new_url = str_replace('view-item='. $_GET['view-item']."&", '', $old_url);

                            echo $bansename ."?". $new_url;
                        }
                    ?>">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                </span>
            </p>
            <div class="course__manage">
                <div class="course__flex">
                    <p class="course__title">Subject Name</p>
                    <p class="content">
                        <?=$detail['subject_name'];?> <br>
                        <?=$detail['subject_name_kh'];?>
                    </p>
                    
                </div>
                <div class="course__flex">
                    <p class="course__title">Credit</p>
                    <p class="content"><?=$detail['credit']." (" . $detail['theory'] . "." . $detail['execute'] . ".". $detail['apply'] . ")";?></p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Department</p>
                    <p class="content">
                        <?php
                            $department = mysqli_query($conn, "SELECT * FROM department WHERE department_id ='" . $detail['department_id'] . "'");
                            $department_data = mysqli_fetch_assoc($department);
                            echo $department_data['department'];
                            mysqli_free_result($department);
                        ?>
                    </p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Subject Type</p>
                    <p class="content">
                    <?php
                            $subject_type = mysqli_query($conn, "SELECT * FROM subject_type WHERE id ='" . $detail['subject_type'] . "'");
                            if(mysqli_num_rows($subject_type)>0){
                                $subject_type_data = mysqli_fetch_assoc($subject_type);
                                echo $subject_type_data['type_name'];
                                mysqli_free_result($subject_type);    
                            }else{
                                echo "-";
                            }
                        ?>
                    </p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Instructor</p>
                    <p class="content"><?php 
                    
                        // $['teaching_by'];
                    
                        // $data['teaching_by'];
                        $instructor = mysqli_query($conn, "SELECT * FROM teacher_info WHERE teacher_id ='". $detail['teaching_by']."'");

                        if(mysqli_num_rows($instructor) > 0){
                            $instructor_name = mysqli_fetch_assoc($instructor);
                            echo $instructor_name['fn_en']. " " .$instructor_name['ln_en'];
                        }

                        mysqli_free_result($instructor);
                                        
                    ?></p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Total Hours</p>
                    <p class="content"><?=$detail['total_hourse'];?> h</p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Description</p>
                    <p class="content"><?=$detail['description'];?></p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Purpose</p>
                    <p class="content"><?=$detail['purpose'];?></p>
                </div>
                <div class="course__flex">
                    <p class="course__title">Anticipated Outcome</p>
                    <p class="content"><?=$detail['anticipated_outcome'];?></p>
                </div>
            </div>
        </div>
    </div>

    <?php       
        mysqli_free_result($course_detail_run);    
            }
        }
    ?>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>


    <script>
        // $(document).ready(function () {
        //     $("#btnExport").click(function () {
        //         var  table = document.getElementsByTagName('table');
        //         console.log(table);
        //         // debugger;
        //         TableToExcel.convert(table[0], {
        //             name: `UserManagement.xlsx`,
        //             sheet: {
        //                 name: 'Usermanagement'
        //             }
        //         });
        //     });
        // });
        $(document).ready(function () {
            $("#btnExport").click(function () {
                $("#table_data").table2excel({
                    filename: "Employees.xls"
                });
            });
            
        });

        
        
    </script>

</body>
</html>