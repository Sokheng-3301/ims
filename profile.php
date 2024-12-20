<?php
    #Connection to DATABASE
    require_once('../ims-db-connection.php');

    #Check login 
    include_once('std-login-check.php');


    $student_id = $_SESSION['LOGIN_STDID'];

    $student_info  = mysqli_query($conn, "SELECT * FROM student_info 
                                        INNER JOIN class ON student_info.class_id = class.class_id
                                        INNER JOIN major ON class.major_id = major.major_id
                                        INNER JOIN department ON major.department_id = department.department_id
                                        WHERE student_id ='". $student_id ."'");
    if(mysqli_num_rows($student_info) > 0){
        $result = mysqli_fetch_assoc($student_info);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('../ims-include/head-tage.php');?>
        <style>
            table td.year{
                width: 60px;
            }
        </style>
    </head>
    <body>
        <!-- include preload for web page  -->
        <?php #include_once('../ims-include/preload.php');?>


        <!-- top header - header of system  -->
        <?php include_once('../ims-include/header.php'); ?>


        <!-- main content of system  -->
        <section id="main-content" id="closeDetial" onclick="closeDetial()">
            <div class="container-ims">
                
                
                <div class="control-personal-info py-5">
                    <div class="shadow-bg">
                        <div class="background-content control-personal-info">
                            <div class="personal-info p-3">
                                <div class="img-profile">
                                    <?php
                                        if($result['profile_image'] == ''){
                                    ?>
                                    <img src="<?=SITEURL?>ims-assets/ims-images/user.png" alt="">
                                    <?php
                                        }else{
                                    ?>
                                    <img src="<?=SITEURL?>ims-assets/ims-images/<?=$result['profile_image'];?>" alt="">
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="text-profile">
                                    <h4><span class="text-uppercase fw-bold"><?=$result['firstname'] ." " . $result['lastname'];?></span> <span class="email">
                                        <?=$result['email'];?>
                                    </span></h4>
                                    <!-- <p>Student id: </p><span class="pro-content">23456543</span>
                                    <p>Department:</p><span class="pro-content">Computer Science</span>
                                    <p>Generation:</p><span class="pro-contnet">4</span>                      -->
                                    <!-- <p class="btn btn-success px-5 text-center m-auto">Update your profile</p> -->

                                    <div class="short-info">
                                        <p class="title">Student ID</p><span>:</span> <p><?=$result['student_id'];?></p>
                                    </div>
                                    <div class="short-info">
                                        <p class="title">Department</p><span>:</span> <p><?=$result['department'];?></p>
                                    </div>
                                    <div class="short-info">
                                        <p class="title">Major</p><span>:</span> <p><?=$result['major'];?></p>
                                    </div>
                                    <div class="short-info">
                                        <p class="title">Degree</p><span>:</span> <p><?=$result['level_study'];?></p>
                                    </div>
                                    <div class="short-info">
                                        <p class="title">Year level</p><span>:</span> <p>Year <?=$result['year_level'];?></p>
                                    </div>
                                    <!-- <a href="" class="update-btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit your profile</a> -->
                                </div>
                            </div>
                            <div class="personal-info-detial p-3">
                                <div class="info-title">
                                    <p><i class="fa fa-user" aria-hidden="true"></i> Personal information</p>  
                                </div>
                                <div class="info-detial">
                                    <div class="part">
                                        <div class="d-flex"><p>Fullname <sup>KH</sup></p><span><?=$result['fn_khmer'] . " " . $result['ln_khmer'];?></span></div>
                                        <div class="d-flex"><p>Fullname <sup>EN</sup> </p><span class="text-uppercase"><?=$result['firstname'] ." " . $result['lastname'];?></span></div>
                                        <div class="d-flex"><p>Gender </p><span><?=ucfirst($result['gender']);?></span></div>
                                        <div class="d-flex"><p>Date of birth </p><span><?php
                                            if($result['birth_date'] == ''){
                                                echo '';
                                            }
                                            else{
                                                // $birth_date = date_create($result['birth_date']);
                                                // echo date_format($birth_date, "d-M-Y");
                                                echo $result['birth_date'];
                                            }
                                            // echo $result['birth_date'];
                                        ?></span></div>
                                        <div class="d-flex"><p>National </p><span><?=ucfirst($result['national']);?></span></div>
                                        <div class="d-flex"><p>Nationality </p><span><?=ucfirst($result['nationality']);?></span></div>
                                    </div>
                                    <div class="part">
                                    
                                        <!-- <div class="d-flex"><p>Generation </p><span>4</span></div> -->
                                        <div class="d-flex"><p>Place of birth </p><span><?=$result['place_of_birth'];?></span></div>
                                        <div class="d-flex"><p>Current address </p><span><?=$result['current_place'];?></span></div>
                                        <div class="d-flex"><p>Phone number </p><span><?=$result['phone_number'];?></span></div>
                                        <div class="d-flex"><p>Email address </p><span><?=$result['email'];?></span></div>

                                    </div>
                                </div>

                                
                                <div class="info-title">
                                    <p><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education background</p>
                                </div>

                                <div class="table mt-3">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>កម្រិតថ្នាក់</th>
                                                <th>ឈ្មោះសាលារៀន</th>
                                                <th>ខេត្ត/រាជធានី</th>
                                                <th>ឆ្នាំចាប់ផ្តើម</th>
                                                <th>ឆ្នាំបញ្ចប់</th>
                                                <th>សញ្ញាបត្រទទួលបាន</th>
                                                <th>និទ្ទេសរួម</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '1' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                if(mysqli_num_rows($secondary) > 0){
                                                    $secondary_result = mysqli_fetch_assoc($secondary);
                                                }
                                            ?>
                                            <tr>
                                                <td scope="row">បឋមសិក្សា</td>
                                                <td><?=$secondary_result['school_name'];?></td>
                                                <td><?=$secondary_result['address'];?></td>
                                                <td class="year"><?=$secondary_result['start_year'];?></td>
                                                <td class="year"><?=$secondary_result['finish_year'];?></td>
                                                <td><?=$secondary_result['certificate'];?></td>
                                                <td><?=$secondary_result['rank'];?></td>
                                            </tr>

                                            <?php
                                                mysqli_free_result($secondary);
                                                $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '2' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                if(mysqli_num_rows($secondary) > 0){
                                                    $secondary_result = mysqli_fetch_assoc($secondary);
                                                }
                                            ?>
                                            <tr>
                                                <td scope="row">បឋមភូមិ​</td>
                                                <td><?=$secondary_result['school_name'];?></td>
                                                <td><?=$secondary_result['address'];?></td>
                                                <td class="year"><?=$secondary_result['start_year'];?></td>
                                                <td class="year"><?=$secondary_result['finish_year'];?></td>
                                                <td><?=$secondary_result['certificate'];?></td>
                                                <td><?=$secondary_result['rank'];?></td>
                                            </tr>


                                            <?php
                                                mysqli_free_result($secondary);
                                                $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '3' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                if(mysqli_num_rows($secondary) > 0){
                                                    $secondary_result = mysqli_fetch_assoc($secondary);
                                                }
                                            ?>
                                            <tr>
                                                <td scope="row">ទុតិយភូមិ</td>
                                                <td><?=$secondary_result['school_name'];?></td>
                                                <td><?=$secondary_result['address'];?></td>
                                                <td class="year"><?=$secondary_result['start_year'];?></td>
                                                <td class="year"><?=$secondary_result['finish_year'];?></td>
                                                <td><?=$secondary_result['certificate'];?></td>
                                                <td><?=$secondary_result['rank'];?></td>
                                            </tr>
            
                                        </tbody>
                                    </table>
                                    <?php
                                                mysqli_free_result($secondary);

                                    ?>
                                </div>

                                <div class="info-title">
                                    <p><i class="fa fa-users" aria-hidden="true"></i> Your family</p>
                                </div>
                                <div class="info-detial">
                                    <div class="part">
                                        <div class="d-flex"><p>Father name</p><span><?=$result['father_name'];?></span></div>
                                        <div class="d-flex"><p>Age</p><span><?=$result['father_age'];?></span></div>
                                        <div class="d-flex"><p>Occupation</p><span><?=$result['father_occupa'];?></span></div>
                                        <div class="d-flex"><p>Phone number</p><span><?=$result['father_phone'];?></span></div>
                                        <div class="d-flex"><p>Current address</p><span><?=$result['father_address'];?></span></div>
                                        <!-- <div class="d-flex"><p>Sibling </p><span><?=$result['sibling'];?></span></div> -->
                                    </div>
                                    <div class="part">
                                        <div class="d-flex"><p>Mother name</p><span><?=$result['mother_name'];?></span></div>
                                        <div class="d-flex"><p>Age</p><span><?=$result['mother_age'];?></span></div>
                                        <div class="d-flex"><p>Occupation</p><span><?=$result['mother_occupa'];?></span></div>
                                        <div class="d-flex"><p>Phone number</p><span><?=$result['mother_phone'];?></span></div>
                                        <div class="d-flex"><p>Current address</p><span><?=$result['mother_address'];?></span></div>
                                    </div>
                                </div>
                                <div class="info-detial">
                                    <div class="part">
                                        <div class="d-flex"><p>Sibling </p><span><?=$result['sibling'];?></span></div>
                                    </div>
                                </div>
                                <div class="table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px;" class="text-center">No.</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Date of birth</th>
                                                <th>Occupation</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                $sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id ='". $student_id ."'");
                                                if(mysqli_num_rows($sibling) > 0){
                                                    while($sibling_data = mysqli_fetch_assoc($sibling)){
                                            ?>
                                            <tr>
                                                <td scope="row" style="width: 10px;" class="text-center"><?=$i++;?></td>
                                                <td><?=$sibling_data['sibl1_name'];?></td>
                                                <td><?php echo ($sibling_data['sibl1_gender'] == 'female')? 'ស្រី': 'ប្រុស';?></td>
                                                <td><?php
                                                    if($sibling_data['sibl1_birth_date'] == '0000-00-00'){

                                                    }else{
                                                        $sibling_birth_date = date_create($sibling_data['sibl1_birth_date']);
                                                        echo date_format($sibling_birth_date, "d-M-Y");
                                                    }
                                                    // echo $sibling_data['sibl1_birth_date'];
                                                ?></td>
                                                <td><?=$sibling_data['sibl1_occupa'];?></td>
                                                <td><?=$sibling_data['sibl1_address'];?></td>
                                                <td><?=$sibling_data['sibl1_phone'];?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }else{
                                            ?>
                                            <tr>
                                                <td scope="row">1</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">2</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">3</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                                }
                                            ?>


                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>


 


        <!-- footer of system  -->
        <?php include_once('../ims-include/footer.php');?>


          
        
<!-- popup start  -->
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
                <a href="<?=SITEURL;?>ims-student/profile.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE']);
        if(isset($_SESSION['ADD_DONE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_DONE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>ims-student/profile.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE_ERROR']);

    ?>
<!-- popup end  -->
        <!-- include javaScript in web page  -->
        <?php include_once('../ims-include/script-tage.php');?>
    </body>
</html>