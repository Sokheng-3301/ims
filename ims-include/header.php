<?php
    $student_id = $_SESSION['LOGIN_STDID'];

    $student_info  = mysqli_query($conn, "SELECT * FROM student_info 
                                        INNER JOIN class ON student_info.class_id = class.class_id
                                        INNER JOIN major ON class.major_id = major.major_id
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE student_id ='". $student_id ."'");
    if(mysqli_num_rows($student_info) > 0){
        $result = mysqli_fetch_assoc($student_info);
        $class_id = $result['class_id'];
    }
?>
<section id="top-header" style="background-color: <?=$system_header_footer;?>;">
    <div class="continaer container-ims">
        <div class="control-header">
            <div class="logo-header">
                <a href="<?=SITEURL?>">
                    <img src="<?=SITEURL?>ims-assets/ims-images/<?=$system_logo;?>" alt="">
                </a>
                <div id="navBtn" onclick="responsiveSidebar()">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
            </div>
            <div class="ims-menu-header">
                <nav>
                    <ul>
                        <li><a href="<?=SITEURL?>ims-student/schedule.php"><?=schedule;?></a></li>
                        <li><a href="<?=SITEURL;?>ims-student/result.php"><?= result;?></a></li>
                        <li><a href="<?=SITEURL?>ims-student/course.php"><?=course;?></a></li>
                        <li><a type="button" class="m-0 px-3 p-0" data-bs-toggle="modal" data-bs-target="#request_modal"><?=request;?></a></li>
                        <!-- <li><a href="<=SITEURL;?>ims-student/request-letter.php"><=request;?></a></li> -->
                    </ul>
                </nav>
            </div>
            <div class="profile-header">
                <div class="control-profile" id="profileheader" onclick="profileDetial()">
                    <div class="profile-img">
                        <?php
                            if($result['profile_image'] == ''){
                                echo '<img src="'.SITEURL.'ims-assets/ims-images/user.png" alt="">';
                            }else{
                                echo '<img src="'.SITEURL.'ims-assets/ims-images/'.$result['profile_image'].'" alt="">';
                            }
                        ?>
                    </div>
                    <div class="profile-name">
                        <p class="name-profile"><?php
                            if($result['firstname'] == '' && $result['lastname'] == ''){
                                echo 'Student';
                            }else{
                                echo ucfirst($result['firstname']) ." ". ucfirst($result['lastname']);
                            }

                        ?></p>
                        <p class="email mt-1">ID : <?php
                            if($result['student_id'] == ''){
                                echo $result['email'];
                            }else{
                                echo $result['student_id'];
                            }
                        ?></p>
                    </div>
                    <div class="drop-down-icon">
                        <i class="fa fa-caret-down" aria-hidden="true" id="iconProfile"></i>
                    </div>
                </div>
            </div>
        </div>

        <div id="detialprofile" style="background-color: <?=$system_header_footer;?>;">
            <!-- <p>Your Profile</p> -->
            <ul>
                <li><a href="<?=SITEURL?>ims-student/profile.php"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>
                <li><a href="<?=SITEURL?>ims-student/edit-profile.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a></li>
                <li><a href="<?=SITEURL?>ims-student/setting.php"><i class="fa fa-gear" aria-hidden="true"></i> Account setting</a></li>
                <!-- <li><a href="<?=SITEURL?>ims-student/schedule.php"><i class="fa fa-calendar" aria-hidden="true"></i><?=schedule;?></a></li>
                <li><a href="<?=SITEURL?>ims-student/result.php"><i class="fa fa-line-chart" aria-hidden="true"></i><?=result;?></a></li>
                <li><a href="<?=SITEURL?>ims-student/course.php"><i class="fa fa-tasks" aria-hidden="true"></i><?=course;?></a></li>
                <li><a type="button" class="m-0" style="padding: 10px 18px" data-bs-toggle="modal" data-bs-target="#request_modal"><i class="fa fa-file-text" aria-hidden="true"></i><?=request;?></a></li> -->
                <li><a href="<?=SITEURL;?>ims-student/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</section>


<!-- in header include  -->
<section id="res-sidebar" onclick="closeSidebar()">
    <div id="nav-manager">
        <div class="logo">
            <div class="logo-part">
                <img src="<?=SITEURL?>ims-assets/ims-images/<?=$system_logo;?>" alt=""> <p>IMS</p>
            </div>
            <div class="bar-nav P-2"  onclick="responsiveSidebar()">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>

        <div class="menu">
            <ul>
                <li><a href="<?=SITEURL?>ims-student/schedule.php"><i class="fa fa-calendar" aria-hidden="true"></i><?=schedule;?></a></li>
                <li><a href="<?=SITEURL?>ims-student/result.php"><i class="fa fa-line-chart" aria-hidden="true"></i><?=result;?></a></li>
                <li><a href="<?=SITEURL?>ims-student/course.php"><i class="fa fa-tasks" aria-hidden="true"></i><?=course;?></a></li>
                <li><a type="button" class="m-0" data-bs-toggle="modal" data-bs-target="#request_modal"><i class="fa fa-file-text" aria-hidden="true"></i><?=request;?></a></li>
            </ul>
        </div>
    </div>
</section>

