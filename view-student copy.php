<?php
    // use Mpdf\Tag\Em;

    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $class_id = '';
    $message = '';
    if(isset($_POST['report'])){
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $note = mysqli_real_escape_string($conn,$_POST['note']);

        $add_note = mysqli_query($conn, "UPDATE student_info SET note = '$note' WHERE id ='". $id ."'");
        if($add_note == true){
            $message = 'Your report has submitted.';
        }else{
            $message = 'Your report has not submitted.';
        }
    }
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
                <h5 class="super__title">Student view detail <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Student view</p>
           </div>
<?php
    if(isset($_GET['view-item'])){
        $id = $_GET['view-item'];
        $teacher = mysqli_query($conn, "SELECT * FROM student_info WHERE id='". $id ."'");
        if(mysqli_num_rows($teacher) > 0){
            $teacher_data = mysqli_fetch_assoc($teacher);
            $student_id = $teacher_data['student_id'];
            $class_id = $teacher_data['class_id'];
            if($teacher_data['active_status'] == '1'){
?>

            <div class="my-3">
                <a href="<?=SITEURL;?>students.php
<?php
    $view_item = 'view-item='.$_GET['view-item'];
    if($_SERVER['QUERY_STRING'] == $view_item){
        // echo 'dfdfd';
    }else{
        $query_string = $_SERVER['QUERY_STRING'];
        $new_url = trim(str_replace("view-item=".$_GET['view-item']."&", "", $query_string));
        echo "?".$new_url;
    }
?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
<?php
            }else{
?>
           <div class="my-3">
                <a href="<?=SITEURL;?>leave-students.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
<?php
            }
?>



            <div class="all__teacher view__teacher p-3">
                <div class="d-flex align-items-center mb-3">
                    <?php
                        $qry_string = '';
                        $pro_string = '';
                        $tran_string = '';
                        if(empty($_GET['profile']) && empty($_GET['transcript'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = $qry_string;
                            $tran_string = $qry_string;
                        }                           
                        elseif(!empty($_GET['transcript'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = str_replace('&transcript='. $_GET['transcript'], '', $qry_string);
                            
                            // if(strpos($pro_string, '&profile='. $_GET['profile'])){
                            //     $pro_string = str_replace('&profile='. $_GET['profile'], '', $pro_string);
                            // }else{
                            //     $pro_string = $pro_string;
                            // }

                        }elseif(!empty($_GET['profile'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $pro_string = str_replace('&profile='. $_GET['profile'], '', $qry_string);

                        }


                        if(!empty($_GET['profile'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $tran_string = str_replace('&profile='. $_GET['profile'], '', $qry_string);
                        }elseif(!empty($_GET['transcript'])){
                            $qry_string = $_SERVER['QUERY_STRING'];
                            $tran_string = str_replace('&transcript='. $_GET['transcript'], '', $qry_string);
                        }

                    ?>
                    <div class="btn__container">
                        <a href="<?=SITEURL;?>view-student.php?<?=$pro_string;?>&profile=<?=true;?>" class="<?php echo((empty($_GET['profile']) || isset($_GET['profile'])) && ((empty($_GET['transcript'])))) ? 'active' : 'no-active'; ?>"><i class="fa fa-user-circle" aria-hidden="true"></i>Student profile</a>
                        <a href="<?=SITEURL;?>view-student.php?<?=$tran_string;?>&transcript=<?=true;?>" class="<?php echo(!empty($_GET['transcript'])) ? 'active' : 'no-active'; ?>"><i class="fa fa-id-card" aria-hidden="true"></i>Transcript</a>
                    </div>
                    <!-- <p class="me-3">Export as:</p> 
                    <div class="action__button">                  
                        <a href="<?=SITEURL;?>class-pdf.php?info-id=<?=$id;?>" target="_blank" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Personal info</a>
                        <div class="border"></div>
                        <a href="<?=SITEURL;?>class-pdf.php?id=<?=$id;?>" target="_blank" class="pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Transcript</a>
                    </div> -->
                </div>
                <hr>
                <div class="view__top">
                    <div class="right__side">
                        <?php
                            if($teacher_data['profile_image'] == ''){
                        ?>
                            <img src="<?=SITEURL?>ims-assets/ims-images/user.png" alt="">

                        <?php
                            }else{
                        ?>
                                <img src="<?=SITEURL?>ims-assets/ims-images/<?=$teacher_data['profile_image'];?>" alt="">
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="title">
                    <h3 class="text-center fw-bold mt-4 text-uppercase">
                        <?php
                            $fullname_en = $teacher_data['firstname'] . " " . $teacher_data['lastname'];
                            if($fullname_en == ' '){
                                // echo '-';
                            }else{
                                echo $fullname_en;
                            }
                        ?>
                        </h3>
                    <p class="status">
                        <?php
                            if($teacher_data['active_status'] == '0'){
                                echo 'និស្សិតត្រូវបាន Leave';
                            }else{
                                if($teacher_data['study_status'] == '0'){
                                    echo 'បានបញ្ចប់ការសិក្សា';
                                }else echo 'កំពុងបន្តការសិក្សា';
                            }
                        ?>
                    </p>
                </div>


                <!-- START PROFILE  -->
                    <?php
                    if((empty($_GET['profile']) || !empty($_GET['profile'])) && empty($_GET['transcript'])){
                    ?>
                    
                    <div class="title">
                        <h5><i class="fa fa-user" aria-hidden="true"></i>ព័ត៌មានផ្ទាល់ខ្លួនរបស់និស្សិត</h5>
                    </div>
                    <div class="view__top">
                        <div class="section">
                            <div class="title">
                                <p>គោត្តនាម និងនាម</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $fullname_kh = $teacher_data['fn_khmer'] . " " . $teacher_data['ln_khmer'];
                                    if($fullname_kh == ' '){
                                            echo '-';
                                    }else{
                                        echo $fullname_kh;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        
                        
                        <div class="section">
                            <div class="title">
                                <p>កម្រិតសិក្សា</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $class_id = $teacher_data['class_id'];
                                    $class_info = mysqli_query($conn, "SELECT * FROM class INNER JOIN major ON class.major_id = major.major_id  INNER JOIN department ON major.department_id = department.department_id WHERE  class_id='". $teacher_data['class_id'] ."'");
                                    $result = mysqli_fetch_assoc($class_info);

                                    echo $result['level_study'];
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="title">
                                <p>អក្សរឡាតាំង</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p style="text-transform: uppercase;">
                                    <?php
                                    $fullname_en = $teacher_data['firstname'] . " " . $teacher_data['lastname'];
                                    if($fullname_en == ' '){
                                            echo '-';
                                    }else{
                                            echo $fullname_en;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ដេប៉ាតឺម៉ង់</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p><?php
                                    echo $result['department'];
                                ?></p>
                            </div>
                        </div>

                        
                        <div class="section">
                            <div class="title">
                                <p>អត្តលេខនិស្សិត</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                        $officer_id = $teacher_data['student_id'];
                                        if($officer_id == ''){
                                                echo '-';
                                        }else{
                                                echo $officer_id;
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ជំនាញសិក្សា</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p><?php
                                    echo $result['major'];
                                ?></p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ភេទ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    mysqli_free_result($class_info);

                                    $gender = $teacher_data['gender'];
                                    if($gender == ''){
                                            echo '-';
                                    }else{
                                            if($gender == 'male') echo 'ប្រុស';
                                            else echo 'ស្រី';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>លេខទូរស័ព្ទ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $gender = $teacher_data['phone_number'];
                                    if($gender == ''){
                                            echo '-';
                                    }else{
                                            echo $gender;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ថ្ងៃខែឆ្នាំកំណើត</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p><?php
                                    $birth_date = $teacher_data['birth_date'];
                                    if($birth_date == ''){
                                            echo '-';
                                    }else{
                                            echo $birth_date;
                                    }
                                ?></p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>អ៊ីម៊ែល</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p><?php
                                    $birth_date = $teacher_data['email'];
                                    if($birth_date == ''){
                                            echo '-';
                                    }else{
                                            echo $birth_date;
                                    }
                                ?></p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ជនជាតិ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $nationality = $teacher_data['nationality'];
                                    if($nationality == ''){
                                            echo '-';
                                    }else{
                                            echo $nationality;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="title">
                                <p>ទីកន្លែងកំណើត</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $place_birth = $teacher_data['place_of_birth'];
                                    if($place_birth == ''){
                                            echo '-';
                                    }else{
                                            echo $place_birth;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>សញ្ជាតិ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                    <?php
                                    $nationality = $teacher_data['national'];
                                    if($nationality == ''){
                                            echo '-';
                                    }else{
                                            echo $nationality;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        
                        
                    
                        <div class="section">
                            <div class="title">
                                <p>ទីកន្លែងបច្ចុប្បន្ន</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $indentify_card_number = $teacher_data['current_place'];
                                    if($indentify_card_number == ''){
                                            echo '-';
                                    }else{
                                            echo $indentify_card_number;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="section">
                            <!-- <div class="title">
                                <p>ជំនាន់ទី</p>
                                <p>:</p>
                            </div> -->
                            
                        </div>            
                    </div>


                    <div class="title">
                        <h5><i class="fa fa-graduation-cap" aria-hidden="true"></i>ប្រវត្តិការសិក្សា</h5>
                    </div>

                    
                    <div class="table__show">
                        <div class="table_manage">
                            <table class="table">
                                <?php
                                    $education = mysqli_query($conn, "SELECT * FROM background_education WHERE student_id='". $student_id ."'");
                                    if(mysqli_num_rows($education) > 0){
                                ?>
                                <tr>
                                    <th class="table-width-100">កម្រិតថ្នាក់</th>
                                    <th class="table-width-50">ឈ្មោះសាលារៀន</th>
                                    <th class="table-width-50">ខេត្ត/រាជធានី</th>
                                    <th class="table-width-50">ពីឆ្នាំណាដល់ឆ្នាំណា</th>
                                    <th class="table-width-100">សញ្ញាបត្រទទួលបាន</th>
                                    <th class="table-width-100">និទ្ទេសរួម</th>
                                </tr>
                                <?php
                                        while($data = mysqli_fetch_assoc($education)){
                                ?>
                                <tr>
                                    <td><?php
                                        if ($data['class_level'] == '1')  echo 'បឋមសិក្សា';
                                        elseif($data['class_level'] == '2') echo 'បឋមភូមិ';
                                        else echo 'ទុតិយភូមិ';
                                    ?></td>
                                    <td><?=$data['school_name'];?></td>
                                    <td><?=$data['address'];?></td>
                                    <td><?=$data['start_year']." - " .$data['finish_year'];?></td>
                                    <td><?=$data['certificate'];?></td>
                                    <td><?=$data['rank'];?></td>
                                </tr>
                                <?php
                                        }
                                    }
                                    mysqli_free_result($education);
                                ?>
                            </table>
                        </div>
                    </div>


                    <div class="title">
                        <h5><i class="fa fa-users" aria-hidden="true"></i>ព័ត៌មានគ្រួសារ</h5>
                    </div>
                    
                    <div class="view__top">
                        <div class="section">
                            <div class="title">
                                <p>ឈ្មោះឪពុក</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $father_name = $teacher_data['father_name'];
                                    if($father_name == ''){
                                            echo '-';
                                    }else{
                                            echo $father_name;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ឈ្មោះម្តាយ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $mother_name = $teacher_data['mother_name'];
                                    if($mother_name == ''){
                                            echo '-';
                                    }else{
                                            echo $mother_name;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="title">
                                <p>អាយុឪពុក</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $father_age = $teacher_data['father_age'];
                                    if($father_age == ''){
                                            echo '-';
                                    }else{
                                            echo $father_age;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>អាយុម្តាយ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $mother_age = $teacher_data['mother_age'];
                                    if($mother_age == ''){
                                            echo '-';
                                    }else{
                                            echo $mother_age;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="title">
                                <p>មុខរបរឪពុក</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $father_occupa = $teacher_data['father_occupa'];
                                    if($father_occupa == ''){
                                            echo '-';
                                    }else{
                                            echo $father_occupa;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>មុខរបរម្តាយ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $mother_occupa = $teacher_data['mother_occupa'];
                                    if($mother_occupa == ''){
                                            echo '-';
                                    }else{
                                            echo $mother_occupa;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="title">
                                <p>លេខទូរស័ព្ទ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $father_phone = $teacher_data['father_phone'];
                                    if($father_phone == ''){
                                            echo '-';
                                    }else{
                                            echo $father_phone;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>លេខទូរស័ព្ទ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $mother_phone = $teacher_data['mother_phone'];
                                    if($mother_phone == ''){
                                            echo '-';
                                    }else{
                                            echo $mother_phone;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ទីកន្លែងបច្ចុប្បន្នឪពុក</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $father_address = $teacher_data['father_address'];
                                    if($father_address == ''){
                                            echo '-';
                                    }else{
                                            echo $father_address;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ទីកន្លែងបច្ចុប្បន្នម្តាយ</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $mother_address = $teacher_data['mother_address'];
                                    if($mother_address == ''){
                                            echo '-';
                                    }else{
                                            echo $mother_address;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ចំនួនបងប្អូនបង្កើត</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $sibling = $teacher_data['sibling'];
                                    if($sibling == ''){
                                            echo '-';
                                    }else{
                                            echo $sibling;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                        <div class="section">
                            <div class="title">
                                <p>ចំនួនបងប្អូនស្រី</p>
                                <p>:</p>
                            </div>
                            <div class="value ps-3">
                                <p>
                                <?php
                                    $female_sibling = $teacher_data['female_sibling'];
                                    if($female_sibling == ''){
                                            echo '-';
                                    }else{
                                            echo $female_sibling;
                                    }
                                ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="table__show">
                        <div class="table_manage">
                            <table class="table border">
                                <?php
                                    $sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id='". $student_id ."'");
                                    if(mysqli_num_rows($sibling) > 0){
                                ?>
                                <tr>
                                    <th class="table-width-200">ឈ្មោះបងប្អូន</th>
                                    <th class="table-width-50">ភេទ</th>
                                    <th class="table-width-100">ថ្ងៃខែឆ្នាំកំណើត</th>
                                    <th class="table-width-50">មុខរបរ</th>
                                    <th class="table-width-100">អាសយដ្ឋាន</th>
                                    <th class="table-width-100">លេខទូរស័ព្ទ</th>
                                </tr>
                                <?php
                                        while($sibling_data = mysqli_fetch_assoc($sibling)){
                                ?>
                                <tr>
                                    <td><?=$sibling_data['sibl1_name'];?></td>
                                    <td><?php 
                                        $sibling_gender = $sibling_data['sibl1_gender'];
                                        if($sibling_gender == 'male'){
                                            echo 'ប្រុស';
                                        }else echo 'ស្រី';
                                    ;?></td>
                                    <td><?=$sibling_data['sibl1_birth_date'];?></td>
                                    <td><?=$sibling_data['sibl1_occupa'];?></td>
                                    <td><?=$sibling_data['sibl1_address'];?></td>
                                    <td><?=$sibling_data['sibl1_phone'];?></td>
                                </tr>
                                <?php
                                        }
                                    }
                                    mysqli_free_result($sibling);
                                ?>
                            </table>
                        </div>
                    </div>


                    <div class="title">
                        <h5><i class="fa fa-flag" aria-hidden="true"></i>ការរាយការណ៍</h5>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-12 p-2 px-3 mb-4">
                        <i><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php
                            echo $teacher_data['note'];
                        ?></i>
                    </div>
                    <div class="col-sm-12 col-md-7 col-xl-8 m-auto bg-light p-2 px-3">
                        <form method="post">
                            <label for="report"><i class="fa fa-flag" aria-hidden="true"></i>ការរាយការណ៍</label>
                            <input type="hidden" name="id" value="<?=$id;?>">
                            <textarea name="note" required rows="5" id="" class="form-control" placeholder="សរសេរការរាយការណ៍របស់អ្នក..."></textarea>
                            <button type="submit" class="btn btn-sm btn-primary ms-auto d-block" name="report">Report</button>
                        </form>
                    </div>

                <!-- END PROFILE  -->


                <!-- START TRANSCRIPT  -->          
                    <?php
                        }
                        if(!empty($_GET['transcript'])){
                    ?>

                    <div class="title">
                        <h5>ប្រតិបត្តិពិន្ទុរបស់និស្សិត</h5>
                    </div>
                    <!-- First & Second year start  -->
                        <?php
                            $student_info = mysqli_query($conn, "SELECT * FROM student_info 
                                                                INNER JOIN class ON student_info.class_id = class.class_id
                                                                INNER JOIN major ON class.major_id = major.major_id
                                                                INNER JOIN department ON major.department_id = department.department_id
                                                                WHERE student_id ='". $teacher_data['student_id']."'");
                            if(mysqli_num_rows($student_info) > 0){
                                $student_info_fetch = mysqli_fetch_assoc($student_info);
                            }
                        ?>
                        <div class="transcript__header ">
                            <div id="transcript__header">
                                <div class="part">
                                    <p>Student ID</p> <p>:</p> <p><?=$student_info_fetch['student_id'];?></p>
                                    <p>Student Name</p> <p>:</p> <p><?=ucwords($student_info_fetch['firstname']. " ". $student_info_fetch['lastname']);?></p>
                                    <p>Date Of Birth</p> <p>:</p> <p><?php $std_bd = date_create($student_info_fetch['birth_date']); echo date_format($std_bd, 'd-M-Y')?></p>
                                </div>
                                <div class="part">
                                    <p>Department</p> <p>:</p> <p><?=ucwords($student_info_fetch['department']);?></p>
                                    <p>Major</p> <p>:</p> <p><?=ucwords($student_info_fetch['major']);?></p>
                                    <p>Degree</p> <p>:</p> <p><?=ucwords($student_info_fetch['level_study']);?></p>
                                </div>
                            </div>
                        </div>
                       

                        <div class="transcript__container">
                            
                            <div class="part">
                                <div class="table_manage">
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Credit</th>
                                            <th>Grade</th>
                                        </tr>
                                        <tr>
                                            <td class="title">First year</td>
                                            <td class="title" colspan="3">1st Semester</td>
                                        </tr>

                                        <?php
                                            $total = 0;
                                            $count_n = 1;
                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                            INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                            
                                                                                            INNER JOIN student_info ON schedule_study.class_id = student_info.class_id

                                                                                            WHERE schedule_study.year_level = '1' 
                                                                                            AND schedule_study.class_id ='". $class_id ."' 
                                                                                            AND year_of_study.semester = '1'
                                                                                            AND student_info.id ='". $id."'");


                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                $count_n = mysqli_num_rows($first_semester_year);

                                                while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                        ?>
                                        <tr>
                                            <td><?=$result_data['subject_code'];?></td>
                                            <td><?=$result_data['subject_name'];?></td>
                                            <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                            <td class="last">
                                                <?php
                                                    $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                AND score_submitted.submit_status ='1'");

                                                    if(mysqli_num_rows($grade) > 0){
                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                        echo $grade_data['grade'];
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>    
                                        <?php
                                                $total += $result_data['credit'];
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2" class="title text-center">Grade Point Average</td>
                                            <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                        </tr>

                                        <!-- #################################################################### -->

                                        <tr>
                                            <td class="title">First year</td>
                                            <td class="title" colspan="3">2nd Semester</td>
                                        </tr>

                                    
                                        <?php
                                            mysqli_free_result($first_semester_year);

                                            $total = 0;
                                            $count_n = 1;
                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                            INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                            
                                                                                            INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                            WHERE schedule_study.year_level = '1' 
                                                                                            AND schedule_study.class_id ='". $class_id ."' 
                                                                                            AND year_of_study.semester = '2'
                                                                                            AND student_info.id ='". $id."'");
                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                $count_n = mysqli_num_rows($first_semester_year);

                                                while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                        ?>
                                        <tr>
                                            <td><?=$result_data['subject_code'];?></td>
                                            <td><?=$result_data['subject_name'];?></td>
                                            <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                            <td class="last">
                                                <?php
                                                    $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                AND score_submitted.submit_status ='1'");

                                                    if(mysqli_num_rows($grade) > 0){
                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                        echo $grade_data['grade'];
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>    
                                        <?php
                                                $total += $result_data['credit'];
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2" class="title text-center">Grade Point Average</td>
                                            <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                        </tr>

                                    </table>   
                                </div>                     
                            </div>

                            <div class="part">
                                <div class="table_manage">
                                    <table>
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Credit</th>
                                            <th>Grade</th>
                                        </tr>
                                        <tr>
                                            <td class="title">Second year</td>
                                            <td class="title" colspan="3">1st Semester</td>
                                        </tr>
                                                        
                                        <?php
                                            mysqli_free_result($first_semester_year);

                                            $total = 0;
                                            $count_n = 1;
                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                            INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                            
                                                                                            INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                            WHERE schedule_study.year_level = '2' 
                                                                                            AND schedule_study.class_id ='". $class_id ."' 
                                                                                            AND year_of_study.semester = '1'
                                                                                            AND student_info.id ='". $id."'");
                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                $count_n = mysqli_num_rows($first_semester_year);

                                                while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                        ?>
                                        <tr>
                                            <td><?=$result_data['subject_code'];?></td>
                                            <td><?=$result_data['subject_name'];?></td>
                                            <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                            <td class="last">
                                                <?php
                                                    $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                AND score_submitted.submit_status ='1'");

                                                    if(mysqli_num_rows($grade) > 0){
                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                        echo $grade_data['grade'];
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>    
                                        <?php
                                                $total += $result_data['credit'];
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2" class="title text-center">Grade Point Average</td>
                                            <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                        </tr>

                                        <!-- #################################################################### -->


                                        <tr>
                                            <td class="title">Second year</td>
                                            <td class="title" colspan="3">2nd Semester</td>
                                        </tr>

                                        <?php
                                            mysqli_free_result($first_semester_year);

                                            $total = 0;
                                            $count_n = 1;
                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                            INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                            INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                            
                                                                                            INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                            WHERE schedule_study.year_level = '2' 
                                                                                            AND schedule_study.class_id ='". $class_id ."' 
                                                                                            AND year_of_study.semester = '2'
                                                                                            AND student_info.id ='". $id."'");
                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                $count_n = mysqli_num_rows($first_semester_year);

                                                while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                        ?>
                                        <tr>
                                            <td><?=$result_data['subject_code'];?></td>
                                            <td><?=$result_data['subject_name'];?></td>
                                            <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                            <td class="last">
                                                <?php
                                                    $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                AND score_submitted.submit_status ='1'");

                                                    if(mysqli_num_rows($grade) > 0){
                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                        echo $grade_data['grade'];
                                                    }
                                                ?>
                                                
                                            </td>
                                        </tr>    
                                        <?php
                                                $total += $result_data['credit'];
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td colspan="2" class="title text-center">Grade Point Average</td>
                                            <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- First & Second year end  -->
                    


                        <!-- Three & Fourth year start  -->
                                <div class="transcript__container">
                                    <div class="part">
                                        <div class="table_manage">
                                            <table>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Subject</th>
                                                    <th>Credit</th>
                                                    <th>Grade</th>
                                                </tr>
                                                <tr>
                                                    <td class="title">Third year</td>
                                                    <td class="title" colspan="3">1st Semester</td>
                                                </tr>

                                                <?php
                                                    $total = 0;
                                                    $count_n = 1;
                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    
                                                                                                    INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                                    WHERE schedule_study.year_level = '3' 
                                                                                                    AND schedule_study.class_id ='". $class_id ."' 
                                                                                                    AND year_of_study.semester = '1'
                                                                                                    AND student_info.id ='". $id."'");
                                                    if(mysqli_num_rows($first_semester_year) > 0){
                                                        $count_n = mysqli_num_rows($first_semester_year);

                                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                ?>
                                                <tr>
                                                    <td><?=$result_data['subject_code'];?></td>
                                                    <td><?=$result_data['subject_name'];?></td>
                                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                    <td class="last">
                                                        <?php
                                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                        AND score_submitted.submit_status ='1'");

                                                            if(mysqli_num_rows($grade) > 0){
                                                                $grade_data = mysqli_fetch_assoc($grade);
                                                                echo $grade_data['grade'];
                                                            }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>    
                                                <?php
                                                        $total += $result_data['credit'];
                                                        }
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="title text-center">Grade Point Average</td>
                                                    <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                                </tr>

                                                <!-- #################################################################### -->

                                                <tr>
                                                    <td class="title">Third year</td>
                                                    <td class="title" colspan="3">2nd Semester</td>
                                                </tr>

                                            
                                                <?php
                                                    mysqli_free_result($first_semester_year);

                                                    $total = 0;
                                                    $count_n = 1;
                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    
                                                                                                    INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                                    WHERE schedule_study.year_level = '3' 
                                                                                                    AND schedule_study.class_id ='". $class_id ."' 
                                                                                                    AND year_of_study.semester = '2'
                                                                                                    AND student_info.id ='". $id."'");
                                                    if(mysqli_num_rows($first_semester_year) > 0){
                                                        $count_n = mysqli_num_rows($first_semester_year);

                                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                ?>
                                                <tr>
                                                    <td><?=$result_data['subject_code'];?></td>
                                                    <td><?=$result_data['subject_name'];?></td>
                                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                    <td class="last">
                                                        <?php
                                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                        AND score_submitted.submit_status ='1'");

                                                            if(mysqli_num_rows($grade) > 0){
                                                                $grade_data = mysqli_fetch_assoc($grade);
                                                                echo $grade_data['grade'];
                                                            }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>    
                                                <?php
                                                        $total += $result_data['credit'];
                                                        }
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="title text-center">Grade Point Average</td>
                                                    <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                                </tr>

                                            </table> 
                                        </div>                       
                                    </div>

                                    <div class="part">
                                        <div class="table_manage">
                                            <table>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Subject</th>
                                                    <th>Credit</th>
                                                    <th>Grade</th>
                                                </tr>
                                                <tr>
                                                    <td class="title">Fourth year</td>
                                                    <td class="title" colspan="3">1st Semester</td>
                                                </tr>
                                                                
                                                <?php
                                                    mysqli_free_result($first_semester_year);

                                                    $total = 0;
                                                    $count_n = 1;
                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    
                                                                                                    INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                                    WHERE schedule_study.year_level = '4' 
                                                                                                    AND schedule_study.class_id ='". $class_id ."' 
                                                                                                    AND year_of_study.semester = '1'
                                                                                                    AND student_info.id ='". $id."'");
                                                    if(mysqli_num_rows($first_semester_year) > 0){
                                                        $count_n = mysqli_num_rows($first_semester_year);

                                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                ?>
                                                <tr>
                                                    <td><?=$result_data['subject_code'];?></td>
                                                    <td><?=$result_data['subject_name'];?></td>
                                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                    <td class="last">
                                                        <?php
                                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                        AND score_submitted.submit_status ='1'");

                                                            if(mysqli_num_rows($grade) > 0){
                                                                $grade_data = mysqli_fetch_assoc($grade);
                                                                echo $grade_data['grade'];
                                                            }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>    
                                                <?php
                                                        $total += $result_data['credit'];
                                                        }
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="title text-center">Grade Point Average</td>
                                                    <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                                </tr>

                                                <!-- #################################################################### -->


                                                <tr>
                                                    <td class="title">Fourth year</td>
                                                    <td class="title" colspan="3">2nd Semester</td>
                                                </tr>

                                                <?php
                                                    mysqli_free_result($first_semester_year);

                                                    $total = 0;
                                                    $count_n = 1;
                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                    
                                                                                                    INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                                                    WHERE schedule_study.year_level = '4' 
                                                                                                    AND schedule_study.class_id ='". $class_id ."' 
                                                                                                    AND year_of_study.semester = '2'
                                                                                                    AND student_info.id ='". $id."'");
                                                    if(mysqli_num_rows($first_semester_year) > 0){
                                                        $count_n = mysqli_num_rows($first_semester_year);

                                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                ?>
                                                <tr>
                                                    <td><?=$result_data['subject_code'];?></td>
                                                    <td><?=$result_data['subject_name'];?></td>
                                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                                    <td class="last">
                                                        <?php
                                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                        AND score_submitted.submit_status ='1'");

                                                            if(mysqli_num_rows($grade) > 0){
                                                                $grade_data = mysqli_fetch_assoc($grade);
                                                                echo $grade_data['grade'];
                                                            }
                                                        ?>
                                                        
                                                    </td>
                                                </tr>    
                                                <?php
                                                        $total += $result_data['credit'];
                                                        }
                                                    }
                                                ?>
                                                <tr>
                                                    <td colspan="2" class="title text-center">Grade Point Average</td>
                                                    <td colspan="2" class="title text-center"><?=$total/$count_n;?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        <!-- Three &  Fourth year end  -->


                            <?php
                                }

                            ?>
                        <!-- END TRANSCRIPT  -->

                        
            </div>
          


           <?php
        }else{
            ?>
                <div class="all__teacher">
                    <p>Data not found. <a href="<?=SITEURL;?>students.php">Back</a></p>
                </div>

            <?php
        }
            
        
    }else{
        // no get view-item 
?>
                <div class="all__teacher">
                    <p>Data not found. <a href="<?=SITEURL;?>teachers.php">Back</a></p>
                </div>


<?php
    }
    mysqli_free_result($teacher);
?>
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>