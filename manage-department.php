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
                <h5 class="super__title">Manage department <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Manage department</p>
            </div>
            <div class="all__teacher master__data">            
                <!-- <p><i class="fa fa-database" aria-hidden="true"></i> Master data</p> -->
                <div class="flex__item">
                    <div class="view__data">
                        <div class="flex">
                            <p><i class="fa fa-list-ol" aria-hidden="true"></i>Manage Department</p>
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
                                        <th class="table-width-500">Department code</th>
                                        <th class="table-width-500">Department</th>
                                        <th class="table-width-50 text-center">Logo</th>
                                        <th class="table-width-50 text-center">Create date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                <?php
                                    $inc = 1;
                                    $class = mysqli_query($conn, "SELECT * FROM department");

                                    while($result = mysqli_fetch_assoc($class)){
                                ?>
                                    <tr>
                                        <td class="text-center id"><?=$inc++;?></td>
                                        <td class="table-width-50"><?=$result['department_code'];?></td>
                                        <td class="table-width-50"><?=$result['department'];?></td>
                                        <td class="table-width-50 text-center">
                                            <?php
                                                if($result['icon_name'] !=''){
                                            ?>
                                                <img width="50px" src="<?=SITEURL;?>ims-assets/ims-images/<?=$result['icon_name'];?>" alt="">
                                            <?php
                                                }
                                            ?>
                                        </td>
                                        <td class="table-width-50 text-center">
                                            <?php
                                                $createDate = date_create($result['create_date']);
                                                echo date_format($createDate, "d-m-Y");
                                                
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$result['department_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#delete_<?=$result['department_id'];?>" class="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>        
                                        
                                    
                                    <!-- Update form pop up  -->
                                    <div class="modal fade" id="update_<?=$result['department_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$result['department_id'];?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="update_<?=$result['department_id'];?>">Edit department</h5>
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

                                                    <form action="master-action.php" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="update_id" value="<?=$result['department_id']?>">

                                                        <label for="department_code">Department code<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="department_code" name="department_code" placeholder="Department code..." value="<?=$result['department_code'];?>"> 
                                                        
                                                        <label for="department">Department <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="department" name="department" placeholder="Department..." value="<?=$result['department'];?>">
                                                        
                                                        <!-- <label for="department_logo">Logo department</label> -->
                                                        <p>Logo department <span class="text-danger">*</span></p>

                                                        <label for="department_logo<?=$result['department_id'];?>" class="preview__logo">
                                                            <div class="bg-logo" id="preview__logo<?=$result['department_id'];?>">
                                                                <?php
                                                                    if($result['icon_name'] == ''){
                                                                ?>
                                                                    <i class="fa fa-camera p-0" aria-hidden="true"></i>
                                                                <?php
                                                                    }else{
                                                                ?>
                                                                    <img width="100%" src="<?=SITEURL;?>ims-assets/ims-images/<?=$result['icon_name'];?>" alt="">
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </label>
                                                        <input type="file"  class="form-control d-none" onchange="preview(event, 'preview__logo<?=$result['department_id'];?>')" id="department_logo<?=$result['department_id'];?>" name="department_logo" accept="image/*">
                                                        <input type="hidden" class="d-none" name="old_logo" value="<?=$result['icon_name'];?>">
                                                        <button class="btn btn-primary btn-sm save d-block mt-3" style="margin-left: auto;  padding: 4px 15px;" type="submit" name="update_department">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- delete class pop up  -->
                                    <div class="modal fade" id="delete_<?=$result['department_id'];?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger" id="exampleModalToggleLabel"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Warning</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <p>Do you want to delete major?</p>

                                                <form action="master-action.php" method="post">
                                                    <input type="hidden" name="delete_id" value="<?=$result['department_id'];?>">
                                                    <button class="btn btn-primary btn-sm px-3 save mt-3 d-block" style="margin-left: auto;" name="delete_department">Ok</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus" aria-hidden="true"></i>Add department</h5>
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

                    <form action="master-action.php" method="post" enctype="multipart/form-data">
                        <label for="department_code">Department code<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="department_code" name="department_code" placeholder="Department code...">
                        
                        <label for="department">Department <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="Department...">
                        
                        <!-- <label for="department_logo">Logo department</label> -->
                         <p>Logo department <span class="text-danger">*</span></p>

                        <label for="department_logo" id="pre__logo" class="preview__logo">
                            <div class="bg-logo" id="preview__logo">
                                <i class="fa fa-camera p-0" aria-hidden="true"></i>
                            </div>
                        </label>
                        <input type="file"  class="form-control d-none" id="department_logo" name="department_logo" accept="image/*">
                        <button class="btn btn-primary btn-sm save" type="submit" name="save_department">Save</button>
                    </form>
                </div>
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
                <a href="<?=SITEURL;?>manage-department.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>manage-department.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
            });

            $('#department_logo').on('change', function(evt){    
                // let photo = evt.target.files;
                let img = "";
                let src = URL.createObjectURL(evt.target.files[0]);
                img += "<img src ='"+ src +"' width = '100%'>";
                document.getElementById('preview__logo').innerHTML = img;
            });
        });

        function preview(evt, pre){
            // alert("hello");
            let img = "";
            let src = URL.createObjectURL(evt.target.files[0]);
            img += "<img src ='"+ src +"' width = '100%'>";
            document.getElementById(pre).innerHTML = img;

            // alert("Hi");
        }

    </script>



</body>
</html>