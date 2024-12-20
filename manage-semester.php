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
                <h5 class="super__title">Manage semester <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Manage semester</p>
            </div>
            <div class="all__teacher master__data">            
                <!-- <p><i class="fa fa-database" aria-hidden="true"></i> Master data</p> -->
                <div class="flex__item">
                    <div class="view__data">
                        <div class="flex">
                            <p><i class="fa fa-list-ol" aria-hidden="true"></i>Manage Semester</p>
                            <a type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                        </div>
                        <div class="filter mb-2">
                            <p class="pe-2"><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                            <form action="" method="post">
                                <select name="academy_year" id="semester_academy_year" class="selectpicker" data-live-search="true">
                                    <option disabled selected>Academy year</option>
                                    <?php
                                        $academy_year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        while($academy_year_data = mysqli_fetch_assoc($academy_year)){
                                    ?>
                                    <option value="<?=$academy_year_data['year'];?>">Year <?=$academy_year_data['year'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </form>
                        </div>
                        <div class="table_manage">                    
                            <table>
                                <thead>
                                    <tr class="fw-normal">
                                        <th class="text-center id">#</th>
                                        <th>Semester</th>
                                        <th class="table-width-500">Start semester</th>
                                        <th class="table-width-100">Finish semester</th>
                                        <th class="table-width-50">Academy year</th>
                                        <th class="table-width-50">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="semester_data">
                                <?php
                                    $year = date('Y');
                                    $inc = 1;
                                    $class = mysqli_query($conn, "SELECT * FROM year_of_study 
                                                                -- INNER JOIN major ON class.major_id = major.major_id
                                                                WHERE year_of_study ='".$year."'");
                                    if(mysqli_num_rows($class) > 0){

                                    
                                        while($result = mysqli_fetch_assoc($class)){
                                ?>
                                        <tr>
                                            <td class="text-center id"><?=$inc++;?></td>
                                            <td>Semester <?=$result['semester'];?></td>
                                            <td class="table-width-500">
                                                <?php
                                                    $startSemester = date_create($result['start_semester']);
                                                    echo date_format($startSemester, "d-m-Y");
                                                    
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $finishSemester = date_create($result['finish_semester']);
                                                    echo date_format($finishSemester, "d-m-Y");
                                                ?>
                                            </td>
                                            <td class="table-width-50"><?=$result['year_of_study'];?></td>
                                            <td class="table-width-50 text-center">
                                                <?php 
                                                    if($result['status'] == '0'){
                                                        echo '<p class="text-center text-success"><i class="fa fa-check-circle text-success" aria-hidden="true"></i> Done</p>';
                                                    }else{
                                                        echo '<p class="text-center text-warning"><i class="fa fa-spinner text-warning" aria-hidden="true"></i> Process</p>';
                                                    }
                                                ?>
                                            </td>
                                            
                                            <td class="text-center">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['year_semester_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['year_semester_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>        
                                                                    
                                        
                                <?php
                                        }
                                    }else{
                                        echo '<tr>';
                                            
                                            echo ' <td colspan="7" class="text-center">Semester not found.</td>';

                                        echo '</tr>';
                                    }
                                ?>
                                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <?php

        $class = mysqli_query($conn, "SELECT * FROM year_of_study");
        if(mysqli_num_rows($class) > 0){
            while($result = mysqli_fetch_assoc($class)){
    ?>
                <!-- Update form pop up  -->
                <div class="modal fade" id="update_<?=$result['year_semester_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$result['year_semester_id'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="update_<?=$result['year_semester_id'];?>">Edit semester</h5>
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div> 
                            <div class="modal-body fs-small">
                                <?php
                                    if(isset($_SESSION['REQUIRED'])){
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <?=$_SESSION['REQUIRED'];?>
                                </div>
                                <?php
                                    }
                                    unset($_SESSION['REQUIRED']);
                                ?>

                                <form action="master-action.php" method="post">
                                    <input type="hidden" name="update_id" value="<?=$result['year_semester_id'];?>">
                                    <label for="semester">Semester <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="semester" id="semester" min ="0" placeholder="Class code..." value="<?=$result['semester'];?>" required>
                                    <label for="start_semester">Start semester <span class="text-danger">*</span></label>
                                    <input type="date"  class="form-control" name="start_semester" id="start_semester" value="<?=$result['start_semester'];?>" required>

                                    <label for="finish_semester">Finish semester <span class="text-danger">*</span></label>
                                    <input type="date"  class="form-control" name="finish_semester" id="finish_semester" value="<?=$result['finish_semester'];?>" required>

                                    <label for="academy_year">Academy year <span class="text-danger">*</span></label>
                                    <select name="academy_year" id="academy_year" class="selectpicker" data-live-search="true" required>
                                        <option disabled selected>Please select academy year</option>
                                        <?php
                                            $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                            while($year_fetch = mysqli_fetch_assoc($year)){
                                        ?>
                                            <option <?php echo ($year_fetch['year'] == $result['year_of_study'])? 'selected' : '';?> value="<?=$year_fetch['year'];?>">Year <?=$year_fetch['year'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <button class="btn btn-primary btn-sm save d-block mt-3 ms-auto" type="submit" name="edit_semester">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- delete class pop up  -->
                <div class="modal fade" id="delete_<?=$result['year_semester_id'];?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="exampleModalToggleLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Warning</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <p>Do you want to delete semester?</p>

                            <form action="master-action.php" method="post">
                                <input type="hidden" name="delete_id" value="<?=$result['year_semester_id'];?>">
                                <button class="btn btn-primary btn-sm px-3 save mt-3 d-block" style="margin-left: auto;" name="delete_semester">Ok</button>
                            </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

    <?php
            }
        }
    ?>






    <!-- add semester model -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus" aria-hidden="true"></i>Add semester</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body fs-small">
                <?php
                    if(isset($_SESSION['REQUIRED'])){
                ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_SESSION['REQUIRED'];?>
                </div>
                <?php
                    }
                    unset($_SESSION['REQUIRED']);
                ?>
                <form action="master-action.php" method="post">
                    <label for="semester">Semester <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="semester" id="semester" min ="0" placeholder="Class code..." required>
                    <label for="start_semester">Start semester <span class="text-danger">*</span></label>
                    <input type="date"  class="form-control" name="start_semester" id="start_semester" required>

                    <label for="finish_semester">Finish semester <span class="text-danger">*</span></label>
                    <input type="date"  class="form-control" name="finish_semester" id="finish_semester" required>

                    <label for="academy_year">Academy year <span class="text-danger">*</span></label>
                    <select name="academy_year" id="academy_year" class="selectpicker" data-live-search="true" required>
                        <option disabled selected>Please select academy year</option>
                        <?php
                            $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                            while($year_fetch = mysqli_fetch_assoc($year)){
                        ?>
                            <option value="<?=$year_fetch['year'];?>">Year <?=$year_fetch['year'];?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <button class="btn btn-primary btn-sm save mt-3" type="submit" name="save_semester">Save</button>

                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
            </div>
        </div>
    </div>

    
    <!-- add class done  -->
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
                <a href="<?=SITEURL;?>manage-semester.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>manage-semester.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['ADD_NOT_DONE']);
    ?>

    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        $(document).ready(function(){
            $('#semester_academy_year').on('change', function(){
                var semester_academy_year = $(this).val();
                if(semester_academy_year){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'semester_academy_year='+semester_academy_year,
                        success:function(html){
                            $('#semester_data').html(html);
                        }
                    }); 
                }
                // else{
                //     $('#semester').html('<option value="">Select academy year first</option>');
                // }

                // console.log('Hi');
            });
        });
    </script>





</body>
</html>