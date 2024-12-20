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
                    <h5 class="super__title">Theme setting <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Theme</p>
            </div>
            <div class="all__teacher theme__setting">
                <p class="fs-5"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</p>
                <div class="theme__controller">
                    <p class="title"><i class="fa fa-picture-o" aria-hidden="true"></i>Logo</p>
                    <div class="table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-start">Logo</th>
                                    <th class="text-start">System name</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $logo_qry = mysqli_query($conn, "SELECT * FROM logo");
                                    if(mysqli_num_rows($logo_qry) > 0){
                                        while($logo_data = mysqli_fetch_assoc($logo_qry)){
                                            $logo = $logo_data['logo_name'];
                                ?>
                                <tr>
                                    <td class="text-start" ><div class="logo" style="background-image: url('<?=SITEURL;?>ims-assets/ims-images/<?=$logo;?>');"></div></td>
                                    <td><?=ucwords($logo_data['system_name']);?></td>
                                    <td class="text-end" ><a type="button" data-bs-toggle="modal" data-bs-target="#updateLogo<?=$logo_data['logo_id'];?>">Edit</a></td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal fade" id="updateLogo<?=$logo_data['logo_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateLogo<?=$logo_data['logo_id'];?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?=SITEURL;?>theme-action.php" enctype="multipart/form-data" method="post">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit logo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="system_name">System name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="system_name" name="system_name" value="<?=$logo_data['system_name'];?>" placeholder="System name..." required>
                                                    <label for="logo_name" class="mt-3">Logo <span class="text-danger">*</span></label>
                                                    <label for="logo_name" id="previewLogo">
                                                        <div class="camera" id="logoPreEdit">
                                                            <img src="<?=SITEURL;?>ims-assets/ims-images/<?=$logo;?>" alt="">
                                                        </div>
                                                    </label>
                                                    <input type="file" class="d-none" name="logo_name" id="logo_name" accept="image/*" onchange="preview(event)">
                                                    <input type="hidden" name="old_logo" value="<?=$logo;?>">
                                                    <input type="hidden" name="update_id" value="<?=$logo_data['logo_id'];?>">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="save_logo" class="btn btn-primary btn-sm">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                        }
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>


                    <p class="title"><i class="fa fa-paint-brush" aria-hidden="true"></i>Theme color</p>
                    <div class="table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-start">Header and Footer</th>
                                    <th class="text-start">Sidebar</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $theme_color = mysqli_query($conn, "SELECT * FROM theme_color");
                                    if(mysqli_num_rows($theme_color) > 0){
                                        while($theme_color_fetch = mysqli_fetch_assoc($theme_color)){
                                ?>
                                <tr>
                                    <td class="text-start"><div class="color" style="background-color: <?=$theme_color_fetch['color_header_footer'];?>;"><?=$theme_color_fetch['color_header_footer'];?></div></td>
                                    <td class="text-start"><div class="color" style="background-color: <?=$theme_color_fetch['color_sidebar'];?>;"><?=$theme_color_fetch['color_sidebar'];?></div></td>
                                    <td class="text-end"><a type="button" data-bs-toggle="modal" data-bs-target="#updateColor<?=$theme_color_fetch['color_id'];?>">Edit</a></td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal fade" id="updateColor<?=$theme_color_fetch['color_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateColor<?=$theme_color_fetch['color_id'];?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?=SITEURL;?>theme-action.php" method="post">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit theme color</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    
                                                    <div class="color__contoller">
                                                        <input type="hidden" name="update_id" value="<?=$theme_color_fetch['color_id'];?>">
                                                        <label for="">Header and Footer <span class="text-danger">*</span></label>
                                                        <input type="color" class="form-control" value="<?=$theme_color_fetch['color_header_footer'];?>" name="header_footer">
                                                        <!-- <small class="mb-2 d-block"><p><?=$theme_color_fetch['color_header_footer'];?></p></small> -->


                                                        <label for="" class="mt-2">Sidebar <span class="text-danger">*</span></label>
                                                        <input type="color"  class="form-control" value="<?=$theme_color_fetch['color_sidebar'];?>" name="sidebar">
                                                        <!-- <small class=" d-block"><p><?=$theme_color_fetch['color_sidebar'];?></p></small> -->
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" name="default_color"  class="btn btn-secondary btn-sm">Default color</button>
                                                    <button type="submit" name="save_color" class="btn btn-primary btn-sm">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                        }
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- <p class="fs-5 mt-4"><i class="fa fa-users" aria-hidden="true"></i>Student theme</p>
                <div class="theme__controller">
                    <p class="title"><i class="fa fa-pencil" aria-hidden="true"></i>Footer</p>
                    <div class="table_manage">
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-start"><i class="fa fa-picture-o" aria-hidden="true"></i></th>
                                    <th class="text-end"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $logo_qry = mysqli_query($conn, "SELECT * FROM logo");
                                    if(mysqli_num_rows($logo_qry) > 0){
                                        while($logo_data = mysqli_fetch_assoc($logo_qry)){
                                            $logo = $logo_data['logo_name'];
                                ?>
                                <tr>
                                    <td class="text-start"><div class="logo" style="background-image: url('<?=SITEURL;?>ims-assets/ims-images/<?=$logo;?>');"></div></td>
                                    <td class="text-end"><a type="button" data-bs-toggle="modal" data-bs-target="#updateLogo<?=$logo_data['logo_id'];?>">Edit</a></td>
                                </tr>


                               
                                <div class="modal fade" id="updateLogo<?=$logo_data['logo_id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateLogo<?=$logo_data['logo_id'];?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?=SITEURL;?>theme-action.php" enctype="multipart/form-data" method="post">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit logo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="logo_name" id="previewLogo">
                                                        <div class="camera" id="logoPreEdit">
                                                            <img src="<?=SITEURL;?>ims-assets/ims-images/<?=$logo;?>" alt="">
                                                        </div>
                                                    </label>
                                                    <input type="file" class="d-none" name="logo_name" id="logo_name" accept="image/*" onchange="preview(event)">
                                                    <input type="hidden" name="old_logo" value="<?=$logo;?>">
                                                    <input type="hidden" name="update_id" value="<?=$logo_data['logo_id'];?>">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="save_logo" class="btn btn-primary btn-sm">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                        }
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>    
                </div> -->

            </div>
        
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>



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
                <a href="<?=SITEURL;?>theme.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
                <a href="<?=SITEURL;?>theme.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
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
        function preview(evt){
            // alert("hello");
            let img = "";
            let src = URL.createObjectURL(evt.target.files[0]);
            img += "<img src ='"+ src +"' width = '100%'>";
            document.getElementById("logoPreEdit").innerHTML = img;
            // alert("Hi");
        }
    </script>
</body>
</html>