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
                <h5 class="super__title">Student leave list <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Student leave</p>
           </div>
           <div class="all__teacher">
                <div class="table__manage">                 
                    <table class="mt-3">
                        <thead>
                            <tr>
                                <th class="no text-center">#</th>
                                <th>Full name</th>
                                <th>Gender</th>
                                <th>Date of birth</th>
                                <th>Department</th>
                                <th class="no">Study status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for($i = 1; $i <= 10; $i++){
                            ?>
                            <tr>
                                <td class="no text-center"><?=$i;?></td>
                                <td>Student name</td>
                                <td>Male</td>
                                <td>10/10/2010</td>
                                <td>Computer Science</td>
                                <td class="text-center no"><i class="fa fa-times-circle text-danger" aria-hidden="true"></i></td>
                                <td>
                                    <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href=""><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a class="delete success" href=""><i class="fa fa-check" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <a href="" class="prevois"><i class="fa fa-backward" aria-hidden="true"></i>Prevois</a>
                        <a href="" class="next">Next <i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div>
                </div>
           </div>
        
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>