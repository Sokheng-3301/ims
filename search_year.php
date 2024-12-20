<!-- <p class="my-4"><i class="fa fa-search pe-2" aria-hidden="true"></i>Search results: <span class="fw-bold"><$_GET['search'];?></span></p> -->
            <?php
                $i= 1;
                $student = mysqli_query($conn, "SELECT * FROM year 
                                    INNER JOIN class ON year.year = class.year_of_study
                                    INNER JOIN student_info ON class.class_id = student_info.class_id
                                    WHERE 
                                    -- fn_khmer LIKE '%$search%' OR  
                                    -- ln_khmer LIKE '%$search%' OR
                                    -- firstname LIKE '%$search%' OR  
                                    -- lastname LIKE '%$search%' OR 
                                    -- student_id LIKE '%$search%' OR
                                    year LIKE '%$year_study%' AND active_status = '1'");

                // echo mysqli_error($conn);

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

                $student = mysqli_query($conn, "SELECT * FROM year 
                                                INNER JOIN class ON year.year = class.year_of_study
                                                INNER JOIN student_info ON class.class_id = student_info.class_id
                                                WHERE 
                                                -- fn_khmer LIKE '%$search%' OR  
                                                -- ln_khmer LIKE '%$search%' OR
                                                -- firstname LIKE '%$search%' OR  
                                                -- lastname LIKE '%$search%' OR 
                                                -- student_id LIKE '%$search%' OR
                                                year LIKE '%$year_study%' AND active_status = '1'
                                                LIMIT $page_first_result, $result_per_page");

                if(mysqli_num_rows($student) > 0){
            ?>
<div class="table__manage"> 
    <div class="table_manage">                
        <table id = "table">
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
                    <td class="text-uppercase"><?=$student_data['firstname']. " ". $student_data['lastname'];?></td>
                    <td class="table-width-50"><?=ucfirst($student_data['gender']);?></td>
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
                        <a href="<?=SITEURL;?>view-student.php?view-item=<?=$student_data['id'];?>&<?=$_SERVER['QUERY_STRING'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <?php
                            if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
                        ?>
                            <a href="<?=SITEURL;?>add-student.php?update-id=<?php echo $student_data['id'];
                                if($_SERVER['QUERY_STRING'] != ''){
                                    echo "&".$_SERVER['QUERY_STRING'];
                                }
                            ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a class="delete" href="<?=SITEURL;?>student-action.php?<?=$_SERVER['QUERY_STRING'];?>&leave=<?=$student_data['id'];?>"><i class="fa fa-times" aria-hidden="true"></i></a>
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
        <a href="<?php 

        if(isset($_GET['page']) && $_GET['page'] > 1){
            $query_string = $_SERVER['QUERY_STRING'];
            $replace = trim(str_replace('page='. $_GET['page']."&", '', $query_string));
            echo "?page=". $_GET['page'] - 1 . "&". $replace;
        }else{
            $query_string = $_SERVER['QUERY_STRING'];
            if(isset($_GET['page'])){
                $replace = trim(str_replace('page='. $_GET['page'] ."&", '', $query_string));
                echo "?page=1&".$replace;
            }else{
                echo "?page=1&". $query_string;
            }

        }?>" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Previous</a>


        <span class="mx-2"><?php
            if(isset($_GET['page'])) echo $_GET['page'];
            else echo '1';
        ?></span>


        <a href="<?php
        if(isset($_GET['page'])){
            $query_string = $_SERVER['QUERY_STRING'];
            $replace = trim(str_replace('page='. $_GET['page']."&", '', $query_string));


            if($_GET['page'] == $number_of_page){
                echo "?page=".$number_of_page ."&". $replace;
            }else{
                echo "?page=". $_GET['page'] + 1 ."&". $replace;
            }

        }else{
            if($number_of_page == 1){
                echo "?page=1&".$query_string;
            }else{
                echo "?page=2&".$query_string;
            }
        }?>" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
    </div>
</div>
<?php
                }else{
                    echo "Data not found. <a href = '". SITEURL . "students.php'>Back</a>";
                }
?>