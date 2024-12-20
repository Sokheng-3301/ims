<div id="side__bar">
    <!-- <h3 class="text-white text-center mb-2">IMS</h3> -->
    
    <div class="menu__bar">
        <ul>
            <li><a href="<?=SITEURL?>dashboard.php" class="<?php 
                if(basename($_SERVER['PHP_SELF']) == "dashboard.php"){
                    echo "active";
                }else{
                    echo "no-active";
                }
                ?>">
                <i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>


            <li><a href="<?=SITEURL?>master-data.php" class="<?php 
                if(basename($_SERVER['PHP_SELF']) == "master-data.php"){
                    echo "active";
                }else{
                    echo "no-active";
                }
                ?>"><i class="fa fa-database" aria-hidden="true"></i>Master data</a></li>
            <?php
                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
            ?>
            <li>
                <div class="main__menu <?php 
                        if((basename($_SERVER['PHP_SELF']) == "members.php") || (basename($_SERVER['PHP_SELF']) == "teachers.php")){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>"  onclick="submenu('teacher__menu', 'icon1')" id="main_menu">
                    <p><i class="fa fa-users" aria-hidden="true"></i>Users</p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon1"></i>
                </div>

                <ul id="teacher__menu">
                    <li><a href="<?=SITEURL?>members.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "members.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active1"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active1"></i>Administrators</a></li>
                    <li><a href="<?=SITEURL?>teachers.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "teachers.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active2"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active2"></i>Teachers</a></li>
                   
                </ul>
            </li>
            <?php
                }
            ?>

            <li>
                <div class="main__menu <?php 
                        if((basename($_SERVER['PHP_SELF']) == "add-student.php") || (basename($_SERVER['PHP_SELF']) == "add-multi-student.php") || (basename($_SERVER['PHP_SELF']) == "students.php") || (basename($_SERVER['PHP_SELF']) == "leave-students.php")){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>"  onclick="submenu('student__menu', 'icon2')" id="student_main_menu">
                    <p><i class="fa fa-graduation-cap" aria-hidden="true"></i>Students</p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon2"></i>
                </div>

                <ul id="student__menu">
                <?php
                    if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
                ?>
                    <li><a href="<?=SITEURL?>add-multi-student.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "add-multi-student.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active4"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active4"></i>Add multiple users</a></li>
                    
                    <li><a href="<?=SITEURL?>add-student.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "add-student.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active3"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active3"></i>Add single user</a></li>
                <?php
                    }
                ?>

                    <li><a href="<?=SITEURL?>students.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "students.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active5"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active5"></i>Students list</i></a></li>


                    <li><a href="<?=SITEURL;?>leave-students.php" class="<?php 
                        if(basename($_SERVER['PHP_SELF']) == "leave-students.php"){
                            echo "active";
                        }else{
                            echo "no-active";
                        }
                    ?>" id="active6"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active6"></i>Leave students</i></a></li>
                    
                </ul>
            </li>

            <?php
                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] == 'Super-admin'){
            ?>        
            <li>
                <!-- <div class="main__menu" onclick="submenu('schedule__menu', 'icon3')"> -->
                    <a href="<?=SITEURL;?>schedule.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "schedule.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-clock-o" aria-hidden="true"></i>Manage schedule</a>
                <!-- </div> -->
               
            </li>

            <?php
                }

                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'Super-admin'){
            ?>

            <li>
                <!-- <div class="main__menu" onclick="submenu('schedule__menu', 'icon3')"> -->
                    <a href="<?=SITEURL;?>your-schedule.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "your-schedule.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-calendar" aria-hidden="true"></i>Schedule</a>
                <!-- </div> -->
               
            </li>

            <?php
                }
            ?>
            
            <li>
                <!-- <a href=""><i class="fa fa-tasks" aria-hidden="true"></i>Course description <i class="fa fa-angle-right" aria-hidden="true"></i></a> -->
                <!-- <div class="main__menu" onclick="submenu('course__menu', 'icon4')"> -->
                <a href="<?=SITEURL?>courses.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "courses.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-tasks" aria-hidden="true"></i>Courses</a>
                    <!-- <i class="fa fa-angle-right" id="icon4" aria-hidden="true"></i> -->
                <!-- </div> -->
                <!-- <ul id="course__menu">
                    <li><a href="<?=SITEURL?>add-course.php"><i class="fa fa-circle-o" aria-hidden="true"></i>Add course</a></li>
                    <li><a href="<?=SITEURL?>courses.php"><i class="fa fa-circle-o" aria-hidden="true"></i>View course</a></li>
                </ul> -->
            </li>
            <!-- <li>
                <div class="main__menu" onclick="submenu('member__menu', 'icon5')">
                    <p href=""><i class="fa fa-user-plus" aria-hidden="true"></i>Members</p>
                    <i class="fa fa-angle-right" id="icon5" aria-hidden="true"></i>
                </div>
                <ul id="member__menu">
                    <li><a href="<?=SITEURL?>members.php?member=super-admin"><i class="fa fa-circle-o" aria-hidden="true"></i>Super admin</a></li>
                    <li><a href="<?=SITEURL?>members.php?member=staff-officer"><i class="fa fa-circle-o" aria-hidden="true"></i>Staff officer</a></li>
                </ul>
            </li> -->
            <li><a href="<?=SITEURL?>student-score.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "student-score.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-bar-chart" aria-hidden="true"></i>Student score</a></li>

            <?php
                

                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
            ?>
                <li><a href="<?=SITEURL?>score-submitted.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "score-submitted.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-clipboard" aria-hidden="true"></i>Score submitted 
                <?php
                    $show_note = mysqli_query($conn, "SELECT * FROM score_submitted WHERE submit_status = '1'");
                    if(mysqli_num_rows($show_note) > 0){
                        $count = mysqli_num_rows($show_note);
                ?>
                    <sup class="ms-1 bg-light text-dark rounded" style="padding: 0 3px; font-size: 10px;">New</sup>
                <?php
                    }
                    mysqli_free_result($show_note);
                ?></a></li>
            

            <li><a href="<?=SITEURL?>request.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "request.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-file-text-o" aria-hidden="true"></i>Request 
                <?php
                    $show_note = mysqli_query($conn, "SELECT * FROM requests WHERE notification = '1'");
                    if(mysqli_num_rows($show_note) > 0){
                        $count = mysqli_num_rows($show_note);
                ?>
                    <sup class="ms-1 bg-light text-dark rounded" style="padding: 0 3px; font-size: 10px;">New</sup>
                <?php
                    }
                ?></a></li>
            <li><a href="<?=SITEURL?>theme.php" class="<?php 
                    if(basename($_SERVER['PHP_SELF']) == "theme.php"){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                ?>"><i class="fa fa-cog" aria-hidden="true"></i>Theme setting</a>
            </li>   

            <?php
                }
            ?>


        </ul>
    </div>
</div>