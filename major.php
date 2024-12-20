<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');
    $department = '';
    if(!empty($_GET['dep'])){
        $dep_id = $_GET['dep'];

        $major = mysqli_query($conn, "SELECT * FROM department 
                                        -- INNER JOIN department ON major.department_id = department.department_id
                                        WHERE department_id ='". $dep_id ."'");

        if(mysqli_num_rows($major) > 0){
            $major_data = mysqli_fetch_assoc($major);
            $department = $major_data['department'];
        }else{
            
        }
        // else{
        //     header("Location:".SITEURL);
        //     exit;
        // }
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
                    <h5 class="super__title">Major list <span><?=systemname?></span></h5>
                    <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Major list</p>
            </div>
            <div class="my-3">
                    <a href="<?=SITEURL;?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                </div>
            <div class="all__teacher">
                <div class="mb-2">
                    <p class="mb-3"><i class="fa fa-list" aria-hidden="true"></i> Major list in Department: <b><?=$department;?></b></p>
                </div>
                <!-- <hr> -->

                <!-- <div class=" filter_class">
                    <p><i class="fa fa-filter" aria-hidden="true"></i>Filter by Academy year: </p>
                    <div class="select">
                        <select name="" id="year_filter">
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
                </div> -->


                <div id="class_list" class="mt-3">
                    <div class="flex__container">
                        <?php
                            // $year = date("Y");
                            $major_qry = mysqli_query($conn, "SELECT * FROM major WHERE department_id ='". $dep_id."'");
                            if(mysqli_num_rows($major_qry) > 0){
                                while($major_fetch = mysqli_fetch_assoc($major_qry)){
                                    $major_id = $major_fetch['major_id'];
                        ?>

                        <a href="<?=SITEURL;?>class-list.php?dep=<?=$dep_id;?>&major=<?=$major_id;?>" class="class__item major__item">
                            <div>
                                <p class="pb-1"><span class="text-primary"></span><span class="fs-4"><?=ucwords($major_data['department']);?></span></p>
                                <p><span class="">Major : </span><span class="fs-5 text-primary"><?=ucwords($major_fetch['major']);?></span></p>
                            </div>
                        </a>

                        <?php
                                }
                            }else{
                                // echo '<p class="text-danger">No major list.</p>';
                                echo '<p class="mt-3"><span class="text-danger">No major record.</span> <a href="'.SITEURL.'manage-major.php" style="text-decoration: underline;">Manage major</a></p>';

                            }
                        ?>
                        
                    </div>
                </div>

                

                


                <!-- <div id="class_detail" class="mt-1 p-3">

                </div> -->


            </div>
            

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        // $(document).ready(function(){
        //     $('#year_filter').on('change', function(){
        //         var year_filter = $(this).val();
        //         var major_id = $('#major_id').html();
        //         if(year_filter){
        //             $.ajax({
        //                 type:'POST',
        //                 url:'ajaxData.php',
        //                 data:{year_filter: year_filter,  major_id: major_id},
        //                 success:function(html){
        //                     $('#class_list').html(html);
        //                     // $('#city').html('<option value="">Select semester first</option>'); 
        //                 }
        //             }); 
        //         }
        //     });
        // });
    </script>

</body>
</html>