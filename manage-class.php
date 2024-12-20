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
                <h5 class="super__title">Manage class <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Manage class</p>
            </div>
            <div class="all__teacher master__data">            
                <!-- <p><i class="fa fa-database" aria-hidden="true"></i> Master data</p> -->
                <div class="flex__item">
                    <div class="view__data">
                        <div class="flex">
                            <p><i class="fa fa-list-ol" aria-hidden="true"></i>Manage Class</p>
                            <a type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                        </div>
                        <div class="filter mb-2">
                            <p class="pe-2"><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                            <form action="" method="post">
                                <select name="academy_year" id="academy_year" class="selectpicker" data-live-search="true">
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
                            <table class="">
                                <thead>
                                    <tr class="fw-normal">
                                        <th class="text-center id">#</th>
                                        <th class="table-width-50" style="width: 40px;">Class code</th>
                                        <th class="table-width-500">Major</th>
                                        <th class="table-width-100" style="width: 20px;">Degree</th>
                                        <th class="table-width-50" style="width: 70px;">Year level</th>
                                        <th class="table-width-50" style="width: 70px;">Academy year</th>
                                        <th class="text-center" style="width: 20px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                    <?php
                                        $year = date('Y');
                                        $inc = 1;
                                        $class = mysqli_query($conn, "SELECT * FROM class 
                                                                    INNER JOIN major ON class.major_id = major.major_id
                                                                    WHERE class.year_of_study ='".$year."'");
                                        if(mysqli_num_rows($class) > 0){
                                        while($result = mysqli_fetch_assoc($class)){
                                    ?>
                                        <tr>
                                            <td class="text-center id"><?=$inc++;?></td>
                                            <td class="table-width-50" style="width: 40px;"><span class="bg-warning rounded-pill px-1" ><?=$result['class_code'];?></span></td>
                                            <td class="table-width-500"><?=$result['major'];?></td>
                                            <td style="width: 20px;"><?=$result['level_study'];?></td>
                                            <td class="table-width-50" style="width: 70px;"><?=$result['year_level'];?></td>
                                            <td class="table-width-50" style="width: 70px;"><?=$result['year_of_study'];?></td>
                                            <td class="text-center" style="width: 20px;">
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['class_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['class_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>        
                                                                    
                                        

                                    <?php
                                            }
                                        }else{
                                            echo '<tr>';
                                            
                                                echo ' <td colspan="7" class="text-center">Class not found.</td>';

                                            echo '</tr>';
                                        }
                                    ?>
                                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    

                    <!-- <div class="list__menu">
                        < include_once('master-sidebar.php');?>
                    </div> -->
                </div>
            </div>


            
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>

    <?php
        // $year = date('Y');
        // $inc = 1;
        $all_class_qry = mysqli_query($conn, "SELECT * FROM class 
                                    INNER JOIN major ON class.major_id = major.major_id");

        if(mysqli_num_rows($all_class_qry) > 0){
            while($result = mysqli_fetch_assoc($all_class_qry)){
    ?>

            <!-- Update form pop up  -->
            <div class="modal fade" id="update_<?=$result['class_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$result['class_id'];?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="update_<?=$result['class_id'];?>">Edit class</h5>
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
                                <input type="hidden" name="update_id" value="<?=$result['class_id']?>" required>
                                <label for="class_code">Class code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="class_code" placeholder="Class code..." value="<?=$result['class_code']?>" required>
                                
                                <label for="major">Major <span class="text-danger">*</span></label>
                                <select name="major" id="major" class="selectpicker" required>
                                    <option disabled selected>Please select major</option>
                                    <?php
                                        $major = mysqli_query($conn, "SELECT * FROM major");
                                        while($data = mysqli_fetch_assoc($major)){
                                    ?>
                                        <option value="<?=$data['major_id'];?>" <?php
                                            echo ($data['major_id'] == $result['major_id']) ? 'selected' : '';
                                        ?>><?=$data['major'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                                <label for="study_level">Degree <span class="text-danger">*</span></label>
                                <select name="study_level" id="study_level" class="selectpicker" required>
                                    <option disabled selected>Please select degree</option>
                                    <option value="Bachelor's Degree" <?php
                                            echo ($result['level_study'] == "Bachelor's Degree") ? 'selected' : '';
                                        ?> >Bachelor's Degree</option>

                                    <option value="Associate Degree" <?php
                                            echo ($result['level_study'] == "Associate Degree") ? 'selected' : '';
                                        ?> >Associate Degree</option>
                                    <!-- <option value="Vocational Degree" <?php
                                            echo ($result['level_study'] == 'Vocational Degree') ? 'selected' : '';
                                        ?> >Vocational Degree</option> -->
                                   
                                </select>

                                <label for="year_level">Year level <span class="text-danger">*</span></label>
                                <select name="year_level" id="year_level" class="selectpicker" required>
                                    <option disabled selected>Please select year level</option>
                                    <?php
                                        for($i=1; $i<=4; $i++){
                                    ?>
                                        <option value="<?=$i;?>" <?php
                                            echo ($result['year_level'] == $i) ? 'selected' : '';
                                        ?>>ឆ្នាំទី <?=$i;?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <label for="academy_year">Academy year <span class="text-danger">*</span></label>
                                <select name="academy_year" id="academy_year" class="selectpicker" data-live-search="true" required>
                                    <option disabled selected>Please select academy year</option>
                                    <?php
                                        $year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        while($year_fetch = mysqli_fetch_assoc($year)){
                                    ?>
                                        <option <?php echo($year_fetch['year'] == $result['year_of_study']) ? 'selected' : '';?> value="<?=$year_fetch['year'];?>">Year <?=$year_fetch['year'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <button class="btn btn-primary btn-sm save d-block mt-3" style="margin-left: auto;  padding: 4px 15px;" type="submit" name="update_class">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- delete class pop up  -->
            <div class="modal fade" id="delete_<?=$result['class_id'];?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="exampleModalToggleLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Warning</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p>Do you want to delete class?</p>

                        <form action="master-action.php" method="post">
                            <input type="hidden" name="delete_id" value="<?=$result['class_id'];?>">
                            <button class="btn btn-primary btn-sm px-3 save mt-3 d-block" style="margin-left: auto;" name="delete_class">Ok</button>
                        </form>
                        </div>
                        
                    </div>
                </div>
            </div>
    
    <?php
            }
        }
    ?>




    <!-- add class model Start -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus" aria-hidden="true"></i>Add class</h5>
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
                    <label for="class_code">Class code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="class_code" placeholder="Class code..." required>
                    
                    <label for="major">Major <span class="text-danger">*</span></label>
                    <select name="major" id="major" class="selectpicker" required>
                        <option disabled selected>Please select major</option>
                        <?php
                            $major = mysqli_query($conn, "SELECT * FROM major");
                            while($result = mysqli_fetch_assoc($major)){
                        ?>
                            <option value="<?=$result['major_id'];?>"><?=$result['major'];?></option>
                        <?php
                            }
                        ?>
                    </select>

                    <label for="study_level">Degree <span class="text-danger">*</span></label>
                    <select name="study_level" id="study_level" class="selectpicker" required>
                        <option disabled selected>Please select study level</option>
                        <!-- <option value="បរិញ្ញាបត្រ">Bachelor degree</option>
                        <option value="បរិញ្ញាបត្ររង">Associated degree</option>
                        <option value="វិជ្ជាជីវៈកម្រិត ៣">Vocational</option> -->

                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                        <option value="Associate Degree">Associate Degree</option>
                        <!-- <option value="Vocational Degree">Vocational Degree</option> -->
                    </select>

                    <label for="year_level">Year level <span class="text-danger">*</span></label>
                    <select name="year_level" id="year_level" class="selectpicker" required>
                        <option disabled selected>Please select year level</option>
                        <?php
                            for($i=1; $i<=4; $i++){
                        ?>
                            <option value="<?=$i;?>">ឆ្នាំទី <?=$i;?></option>
                        <?php
                            }
                        ?>
                    </select>

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
                    <button class="btn btn-primary btn-sm save mt-3" type="submit" name="save_class">Save</button>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
            </div>
        </div>
    </div>
    <!-- add class model End -->






    
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
                <a href="<?=SITEURL;?>master-data.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>master-data.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
            $('#academy_year').on('change', function(){
                var academy_year = $(this).val();
                if(academy_year){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'academy_year='+academy_year,
                        success:function(html){
                            $('#table_data').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
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