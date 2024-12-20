<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    if(!empty($_GET['major'])){
        $major_id = $_GET['major'];

        $major = mysqli_query($conn, "SELECT * FROM major 
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE major.major_id ='". $major_id ."'");

        if(mysqli_num_rows($major) > 0){
            $major_data = mysqli_fetch_assoc($major);
        }else{
            header("Location:".SITEURL);
            exit;
        }
    }else{
        header("Location:".SITEURL);
        exit;
    }

    // print_r($_SESSION);
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
                    <h5 class="super__title">Class list <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Class list</p>
            </div>
            <div class="my-3">
                    <a href="<?=SITEURL;?>major.php?dep=<?=$major_data['department_id'];?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>
            <div class="all__teacher">
                <div class="mb-2">
                    <p class="mb-3"><i class="fa fa-list" aria-hidden="true"></i> Class list in Dep.<b><?=$major_data['department']?></b> - Maj.<b> <?=$major_data['major'];?></b> <span class="d-none" style="display: none;" id="major_id"><?=$major_id;?></span></p>
                </div>
                <!-- <hr> -->
                <div class="filter_class">
                    <p><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                    <div class="select ms-2">
                        <select name="" id="year_filter" required class="selectpicker" data-live-search="true">
                            <option disabled selected>Select year</option>
                            <?php
                                $year_sqry = mysqli_query($conn, "SELECT * FROM year ORDER BY year DESC");
                                if(mysqli_num_rows($year_sqry) > 0){
                                    while($year_sqry_data = mysqli_fetch_assoc($year_sqry)){
                                ?>
                                <option <?php echo ($year_now == $year_sqry_data['year'])? 'selected' : '';?> value="<?=$year_sqry_data['year'];?>">Year <?=$year_sqry_data['year'];?></option>
                                <?php
                                    }
                                }else{
                                    echo '<option disabled selected>Class not found.</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div id="class_list" class="mt-3">
                    <div class="flex__container">
                        <?php
                            $year = date("Y");
                            $class_qry = mysqli_query($conn, "SELECT * FROM class WHERE major_id ='". $major_id ."' AND year_of_study = '". $year ."'");
                            if(mysqli_num_rows($class_qry) > 0){
                                while($class_fetch = mysqli_fetch_assoc($class_qry)){
                        ?>

                        <a href="<?=SITEURL;?>class.php?class=<?=$class_fetch['class_id'];?>&major=<?=$major_id;?>" class="class__item">
                            <div>
                                <p>Class code: <b><?=$class_fetch['class_code'];?></b></p>
                                <p>Degree: <b><?=$class_fetch['level_study'];?></b></p>
                                <p>Year level: <b><?=$class_fetch['year_level'];?></b></p>
                                <p>Academy year: <b><?=$class_fetch['year_of_study'];?></b></p>
                            </div>
                        </a>

                        <?php
                                }
                            }else{
                                echo '<p class="mt-3"><span class="text-danger">No class record.</span> <a href="'.SITEURL.'manage-class.php" style="text-decoration: underline;">Manage class</a></p>';
                            }
                        ?>
                        
                    </div>
                </div>

                

                


                <div id="class_detail" class="mt-1 p-3">

                </div>


            </div>
            

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        $(document).ready(function(){
            $('#year_filter').on('change', function(){
                var year_filter = $(this).val();
                var major_id = $('#major_id').html();
                if(year_filter){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:{year_filter: year_filter,  major_id: major_id},
                        success:function(html){
                            $('#class_list').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }
            });
        });
    </script>

</body>
</html>