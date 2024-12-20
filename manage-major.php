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
                <h5 class="super__title">Manage major <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Manage major</p>
            </div>
            <div class="all__teacher master__data">            
                <!-- <p><i class="fa fa-database" aria-hidden="true"></i> Master data</p> -->
                <div class="flex__item">
                    <div class="view__data">
                        <div class="flex">
                            <p><i class="fa fa-list-ol" aria-hidden="true"></i>Manage Major</p>
                            <a type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-plus" aria-hidden="true"></i>Add new</a>
                        </div>

                        <!-- <div class="filter mb-2">
                            <p><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                            <form action="" method="post">
                                <select name="academy_year" id="academy_year">
                                    <option disabled selected>Academy year</option>
                                    <
                                        $academy_year = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                        while($academy_year_data = mysqli_fetch_assoc($academy_year)){
                                    ?>
                                    <option value="<=$academy_year_data['year'];?>">Year <=$academy_year_data['year'];?></option>
                                    <
                                        }
                                    ?>
                                </select>
                            </form>
                        </div> -->

                        <div class="table_manage">
                            <table>
                                <thead>
                                    <tr class="fw-normal">
                                        <th class="text-center id">#</th>
                                        <th class="table-width-50">Major Code</th>
                                        <th class="table-width-50">Major</th>
                                        <th class="table-width-500">Department</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                <?php
                                    $inc = 1;
                                    $class = mysqli_query($conn, "SELECT * FROM major 
                                                                INNER JOIN department ON major.department_id = department.department_id ORDER BY major.department_id ASC");

                                    while($result = mysqli_fetch_assoc($class)){
                                ?>
                                    <tr>
                                        <td class="text-center id"><?=$inc++;?></td>
                                        <td class="table-width-50"><?=$result['major_code'];?></td>
                                        <td class="table-width-50"><?=$result['major'];?></td>
                                        <td class="table-width-50"><?=$result['department'];?></td>
                                        <td class="text-center">
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['major_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['major_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>        
                                                                
                                    <!-- Update form pop up  -->
                                    <div class="modal fade" id="update_<?=$result['major_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$result['major_id'];?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="update_<?=$result['major_id'];?>">Edit major</h5>
                                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div> 
                                                <div class="modal-body fs-small">
                                                    

                                                    <form action="master-action.php" method="POST">
                                                        <input type="hidden" name="update_id" value="<?=$result['major_id']?>">

                                                        <label for="major_code">Major code<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="major_code" name="major_code" placeholder="Major code..." value="<?=$result['major_code'];?>">

                                                        <label for="major">Major <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="major" name="major" placeholder="Major..." value="<?=$result['major'];?>">
                                                        
                                                        <label for="department_id">Department <span class="text-danger">*</span></label>
                                                        <select id="department_id" name="department_id">
                                                            <option disabled selected>Please select department</option>
                                                            <?php
                                                                $i=1;
                                                                $department = mysqli_query($conn, "SELECT * FROM department");
                                                                while($result_dep = mysqli_fetch_assoc($department)){
                                                            ?>
                                                                <option <?php
                                                                    echo ($result['department_id'] == $result_dep['department_id'])? 'selected' : '';
                                                                ?> value="<?=$result_dep['department_id'];?>"><?=$i++. ". ".$result_dep['department'];?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                        <button class="btn btn-primary btn-sm save d-block mt-3" style="margin-left: auto;  padding: 4px 15px;" type="submit" name="update_major" value="1">Update</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- delete class pop up  -->
                                    <div class="modal fade" id="delete_<?=$result['major_id'];?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger" id="exampleModalToggleLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Warning</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <p>Do you want to delete major?</p>

                                                <form action="master-action.php" method="post">
                                                    <input type="hidden" name="delete_id" value="<?=$result['major_id'];?>">
                                                    <button class="btn btn-primary btn-sm px-3 save mt-3 d-block" style="margin-left: auto;" name="delete_major">Ok</button>
                                                </form>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                <?php
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





    <!-- add class model -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus" aria-hidden="true"></i>Add major</h5>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body fs-small">
                <?php
                    if(isset($_SESSION['REQUIRED_DATA'])){
                ?>
                <div class="alert alert-danger" role="alert">
                    <?=$_SESSION['REQUIRED_DATA'];?>
                </div>
                <?php
                    }
                    unset($_SESSION['REQUIRED_DATA']);
                ?>

                <form action="master-action.php" method="post">
                    <label for="major_code">Major code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="major_code" name="major_code" placeholder="Major code...">

                    <label for="major">Major <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="major" name="major" placeholder="Major...">
                    
                    <label for="department">Department <span class="text-danger">*</span></label>
                    <select name="department" id="department" class="selectpicker" data-live-search="true">
                        <option disabled selected>Please select department</option>
                        <?php
                            $i=1;
                            $department = mysqli_query($conn, "SELECT * FROM department");
                            while($result_dep = mysqli_fetch_assoc($department)){
                        ?>
                            <option value="<?=$result_dep['department_id'];?>"><?=$i++. ". ".$result_dep['department'];?></option>
                        <?php
                            }
                        ?>
                    </select>
                   
                    <button class="btn btn-primary btn-sm save mt-3" type="submit" name="save_major">Save</button>
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
                <a href="<?=SITEURL;?>manage-major.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>manage-major.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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