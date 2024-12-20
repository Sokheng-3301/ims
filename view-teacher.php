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
                <h5 class="super__title">Teacher view detail <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Teacher view</p>
           </div>
<?php
    if(isset($_GET['view-item'])){
        $id = $_GET['view-item'];
        $teacher = mysqli_query($conn, "SELECT * FROM teacher_info WHERE id='". $id ."'");
        if(mysqli_num_rows($teacher) > 0){
            $teacher_data = mysqli_fetch_assoc($teacher);
            $teacher_id = $teacher_data['teacher_id'];
?>


           <div class="my-3">
                <a href="<?=SITEURL;?>teachers.php
<?php
    $view_item = 'view-item='.$_GET['view-item'];
    if($_SERVER['QUERY_STRING'] == $view_item){
        echo '';
    }else{
        $query_string = $_SERVER['QUERY_STRING'];
        $new_url = trim(str_replace("view-item=".$_GET['view-item']."&", "", $query_string));
        echo "?".$new_url;
    }
?>
                    " class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
            </div>
           <div class="all__teacher view__teacher p-3">
                <div class="view__top">
                    <div class="right__side">
                        <?php
                            if($teacher_data['profile_image'] == ''){
                        ?>
                            <img src="<?=SITEURL;?>ims-assets/ims-images/user.png" alt="">

                        <?php
                            }else{
                        ?>
                                <img src="<?=SITEURL;?>ims-assets/ims-images/<?=$teacher_data['profile_image'];?>" alt="">
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="title">
                    <h3 class="text-center fw-bold mt-4 text-uppercase">

                    <?php
                        if($teacher_data['gender'] == 'male'){
                            echo 'Mr. ';
                        }else{
                            echo 'Ms. ';
                        }
                        $fullname_en = $teacher_data['fn_en'] . " " . $teacher_data['ln_en'];
                        if($fullname_en == ' '){
                            echo '-';
                        }else{
                            echo $fullname_en;
                        }
                    ?>
                    <span class="d-block fs-5 mt-2 text-primary">ID : <?=$teacher_data['teacher_id'];?></span>
                    </h3>
                </div>
                <div class="title">
                    <h5>ប្រវត្តិរូបគ្រូបង្រៀន</h5>
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
                            <p>អក្សរឡាតាំង</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p style="text-transform: uppercase;">
                                <?php
                                   $fullname_en = $teacher_data['fn_en'] . " " . $teacher_data['ln_en'];
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
                            <p>ភេទ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                                <?php
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
                            <p>អត្តលេខមន្ត្រី</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                                <?php
                                    $officer_id = $teacher_data['officer_id'];
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
                            <p>ពិការភាព</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                                <?php
                                   $disability = $teacher_data['disability'];
                                   if($disability == ''){
                                        echo '-';
                                   }else{
                                        echo $disability;
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
                                   $place_birth = $teacher_data['place_birth'];
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
                            <p>លេខអត្តសញ្ញាណបណ្ណ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $indentify_card_number = $teacher_data['indentify_card_number'];
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
                        <div class="title">
                            <p>លេខគណនីបៀវត្ស</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $payroll_acc = $teacher_data['payroll_acc'];
                                   if($payroll_acc == ''){
                                        echo '-';
                                   }else{
                                        echo $payroll_acc;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>លេខសមាជិកបសបខ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $member_bcc_id = $teacher_data['member_bcc_id'];
                                   if($member_bcc_id == ''){
                                        echo '-';
                                   }else{
                                        echo $member_bcc_id;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ថ្ងៃខែឆ្នាំចូលបម្រើការងារ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $date_of_employment = $teacher_data['date_of_employment'];
                                   if($date_of_employment == ''){
                                        echo '-';
                                   }else{
                                        echo $date_of_employment;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ថ្ងៃខែឆ្នាំតែងតាំងស៊ុប</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $date_of_soup = $teacher_data['date_of_soup'];
                                   if($date_of_soup == ''){
                                        echo '-';
                                   }else{
                                        echo $date_of_soup;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>អង្គភាពបម្រើការងារ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $working_unit = $teacher_data['working_unit'];
                                   if($working_unit == ''){
                                        echo '-';
                                   }else{
                                        echo $working_unit;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="section">
                        <div class="title">
                            <p>អាសយដ្ឋានអង្គភាព</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $working_unit_address = explode(",", $teacher_data['working_unit_address']);
                                //    var_dump($working_unit_address);
                                   if($working_unit_address == ''){
                                        echo '-';
                                   }else{
                                        echo "ភូមិ".$working_unit_address['0'] . " ឃុំ". $working_unit_address['1']." ស្រុក". $working_unit_address['2'] . " ខេត្ត". $working_unit_address['3'];
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ការិយាល័យ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $office = $teacher_data['office'];
                                   if($office == ''){
                                        echo '-';
                                   }else{
                                        echo $office;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>មុខដំណែង</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $position = $teacher_data['position'];
                                   if($position == ''){
                                        echo '-';
                                   }else{
                                        echo $position;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ប្រកាស</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $anountment = $teacher_data['anountment'];
                                   if($anountment == ''){
                                        echo '-';
                                   }else{
                                        echo $anountment;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="title">
                    <h5>ឋានៈវិជ្ជាជីវៈគ្រូបង្រៀន</h5>
                </div>
                <div class="table__show">
                    <table class="table border">
                    <?php
                        $teacher_professional = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($teacher_professional) > 0){
                    ?>
                        <tr>
                            <th>ប្រភេទឋានៈវិជ្ជាជីវៈ</th>
                            <th>បរិយាយ</th>
                            <th>ប្រកាសលេខ</th>
                            <th>កាលបរិច្ឆេទទទួល</th>
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($teacher_professional)){
                    ?>
                        <tr>
                            <td><?=$data['type_pro_status'];?></td>
                            <td><?=$data['description'];?></td>
                            <td><?=$data['post_number'];?></td>
                            <td><?=$data['date_get'];?></td>
                        </tr>
                    <?php
                            }
                        }else{
                            
                        }
                        mysqli_free_result($teacher_professional);
                    ?>
                        
                    </table>
                </div>
                <div class="view__top">
                    <div class="section">
                        <div class="title">
                            <p>ឋាននន្តរស័ក្តិ និងថ្នាក់</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $rank = $teacher_data['rank'];
                                   if($rank == ''){
                                        echo '-';
                                   }else{
                                        echo $rank;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>យោង</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $refer = $teacher_data['refer'];
                                   if($refer == ''){
                                        echo '-';
                                   }else{
                                        echo $refer;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="section">
                        <div class="title">
                            <p>លេខរៀង</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $numbering = $teacher_data['numbering'];
                                   if($numbering == ''){
                                        echo '-';
                                   }else{
                                        echo $numbering;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ថ្ងៃខែឡើងកាំប្រាក់</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $date_last_interest = $teacher_data['date_last_interest'];
                                   if($date_last_interest == ''){
                                        echo '-';
                                   }else{
                                        echo $date_last_interest;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="section">
                        <div class="title">
                            <p>ចុះថ្ងៃទី</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $dated = $teacher_data['dated'];
                                   if($dated == ''){
                                        echo '-';
                                   }else{
                                        echo $dated;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>បង្រៀននៅឆ្នាំសិក្សា</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $teaching_in_year = $teacher_data['teaching_in_year'];
                                   if($teaching_in_year == ''){
                                        echo '-';
                                   }else{
                                        echo $teaching_in_year;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>

                    <div class="section">
                        <div class="title">
                            <p>បង្រៀនភាសាអង់គ្លេស</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $english_teaching = $teacher_data['english_teaching'];
                                   if($english_teaching == ''){
                                        echo '-';
                                   }else{
                                        echo $english_teaching;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ថ្នាក់គួបបីកម្រិត</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $three_level_combine = $teacher_data['three_level_combine'];
                                   if($three_level_combine == ''){
                                        echo '-';
                                   }else{
                                        echo $three_level_combine;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ប្រធានក្រុមបច្ចេកទេស</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $technic_team_leader = $teacher_data['technic_team_leader'];
                                   if($technic_team_leader == ''){
                                        echo '-';
                                   }else{
                                        echo $technic_team_leader;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ជួយបង្រៀន</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $help_teach = $teacher_data['help_teach'];
                                   if($help_teach == ''){
                                        echo '-';
                                   }else{
                                        echo $help_teach;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ពីរថ្នាក់ណីរពេល</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $two_class = $teacher_data['two_class'];
                                   if($two_class == ''){
                                        echo '-';
                                   }else{
                                        echo $two_class;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ទទួលបន្ទុកថ្នាក់</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $class_charge = $teacher_data['class_charge'];
                                   if($class_charge == ''){
                                        echo '-';
                                   }else{
                                        echo $class_charge;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>បង្រៀនឆ្លងសាលា</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $cross_school = $teacher_data['cross_school'];
                                   if($cross_school == ''){
                                        echo '-';
                                   }else{
                                        echo $cross_school;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ម៉ោងលើស</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $overtime = $teacher_data['overtime'];
                                   if($overtime == ''){
                                        echo '-';
                                   }else{
                                        echo $overtime;
                                   }
                            ?>
                            </p>
                        </div>
                    </div><div class="section">
                        <div class="title">
                            <p>ថ្នាក់គួប</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $coupling_class = $teacher_data['coupling_class'];
                                   if($coupling_class == ''){
                                        echo '-';
                                   }else{
                                        echo $coupling_class;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ពីរភាសា</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $two_language = $teacher_data['two_language'];
                                   if($two_language == ''){
                                        echo '-';
                                   }else{
                                        echo $two_language;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ថ្នាក់ទី របស់គ្រូ ត្រូវបានដកចេញ -->
                <!-- <div class="table__show">
                    <table class="table border">
                        <tr>
                            <th>ថ្នាក់ទី</th>
                            <th>មុខវិជ្ជាបង្រៀន</th>
                            <th>ថ្ងៃបង្រៀន</th>
                            <th>ម៉ោងបង្រៀន</th>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </table>
                </div> -->


                <div class="title">
                    <h5>ប្រវត្តិការងារបន្តបន្ទាប់</h5>
                </div>
                <div class="view__top">
                    <div class="section">
                        <div class="title">
                            <p>ស្ថានភាព</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $status = $teacher_data['status'];
                                   if($status == ''){
                                        echo '-';
                                   }else{
                                        echo $status;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="table__show">
                    <table class="table border">
                        <?php
                            $work_history = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id='". $teacher_id ."'");
                            if(mysqli_num_rows($work_history) > 0){
                        ?>
                        <tr>
                            <th>ការងារបន្តបន្ទាប់</th>
                            <th>អង្គភាពបម្រើការងារបច្ចុប្បន្ន</th>
                            <th>ថ្ងៃចាប់ផ្តើម</th>
                            <th>ថ្ងៃបញ្ចប់</th>
                        </tr>
                        <?php
                                while($data = mysqli_fetch_assoc($work_history)){
                        ?>
                        <tr>
                            <td><?=$data['follow_work'];?></td>
                            <td><?=$data['current_unit'];?></td>
                            <td><?=$data['start_date'];?></td>
                            <td><?=$data['finish_date'];?></td>
                        </tr>
                        <?php
                                }
                            }
                            mysqli_free_result($work_history);
                        ?>
                    </table>
                </div>

                <div class="title">
                    <h5>ការសរសើរ​ / ស្តីបន្ទោស</h5>
                </div>

                <div class="table__show">
                    <?php
                        $praise = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($praise) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th class="table-width-200">ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច</th>
                            <th>ផ្តល់ដោយ</th>
                            <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($praise)){
                    ?>
                        <tr>
                            <td><?=$data['type_praise_blame'];?></td>
                            <td><?=$data['provided'];?></td>
                            <td><?=$data['recieve_date'];?></td>
                        </tr>
                    <?php
                            }
                    echo '</table>';
                        }else{
                            echo '-';
                        }
                        mysqli_free_result($praise);
                    ?>                                              
                </div>

                <div class="title">
                    <h5>កម្រិតវប្បធម៌</h5>
                </div>

                <div class="table__show">
                    <?php
                        $education = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id = '". $teacher_id ."'");
                        if(mysqli_num_rows($education) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th>កម្រិតវប្បធម៌</th>
                            <th>ឈ្មោះជំនាញ</th>
                            <th>កាលបរិច្ឆេទទទួល</th>
                            <th>ប្រទេស</th>
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($education)){
                    ?>
                        <tr>
                            <td><?=$data['education'];?></td>
                            <td><?=$data['major'];?></td>
                            <td><?=$data['recieve_date'];?></td>
                            <td><?=$data['country'];?></td>
                        </tr>
                    <?php
                            }
                            echo ' </table>';
                        }else{
                            echo '-';
                        }
                        mysqli_free_result($education);
                    ?>
                </div>

                <div class="title">
                    <h5>វគ្គគរុកោសល្យ</h5>
                </div>

                <div class="table__show">
                    <?php
                        $pedegogy = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($pedegogy) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th>កម្រិតវិជ្ជាជីវៈ</th>
                            <th>ឯកទេសទី១</th>
                            <th>ឯកទេសទី២</th>
                            <th>ប្រព័ន្ធបណ្តុះបណ្តាល</th>
                            <th>ថ្ងៃខែបានទទួល</th>
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($pedegogy)){
                    ?>
                        <tr>
                            <td><?=$data['profess_level'];?></td>
                            <td><?=$data['skill1'];?></td>
                            <td><?=$data['skill2'];?></td>
                            <td><?=$data['train_system'];?></td>
                            <td><?=$data['receive_date'];?></td>
                        </tr>
                    <?php
                            }
                        echo '</table>';
                        }else
                        echo '-';
                        mysqli_free_result($pedegogy);
                    ?>
                </div>


                <div class="title">
                    <h5>វគ្គខ្លីៗ</h5>
                </div>

                <div class="table__show">
                    <?php
                        $short_course = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($short_course) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th>ផ្នែក</th>
                            <th>ឈ្មោះជំនាញ</th>
                            <th>ថ្ងៃចាប់ផ្តើម</th>
                            <th>ថ្ងៃបញ្ចប់</th>
                            <th>រយៈពេល</th>
                            <th>រៀបចំដោយ</th>
                            <th>គាំទ្រដោយ</th>
                        </tr>

                    <?php
                            while($data = mysqli_fetch_assoc($short_course)){
                    ?>
                        <tr>
                            <td><?=$data['section'];?></td>
                            <td><?=$data['major'];?></td>
                            <td><?=$data['start_date'];?></td>
                            <td><?=$data['finish_date'];?></td>
                            <td><?=$data['duration'];?></td>
                            <td><?=$data['prepair_by'];?></td>
                            <td><?=$data['support_by'];?></td>
                        </tr>
                        <?php
                            }
                        echo '</table>';
                        }else
                        echo '-';
                        mysqli_free_result($short_course);
                    ?>
                </div>


                <div class="title">
                    <h5>ភាសាបរទេស</h5>
                </div>

                <div class="table__show">
                    <?php
                        $foreign_language = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($foreign_language) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th>ភាសា</th>
                            <th>ការអាន</th>
                            <th>ការសរសេរ</th>
                            <th>ការសន្ទនា</th>
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($foreign_language)){
                    ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    <?php
                            }
                        echo '</table>';
                        }else
                        echo '-';
                        mysqli_free_result($foreign_language);
                    ?>
                </div>

                <div class="title">
                    <h5>ស្ថានភាពគ្រួសារ</h5>
                </div>
                <div class="view__top">
                    <div class="section">
                        <div class="title">
                            <p>ស្ថានភាពគ្រួសារ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $family_status = $teacher_data['family_status'];
                                   if($family_status == ''){
                                        echo '-';
                                   }else{
                                        echo $family_status;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ឈ្មោះសហទ័ព្ធ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $name_confederate = $teacher_data['name_confederate'];
                                   if($name_confederate == ''){
                                        echo '-';
                                   }else{
                                        echo $name_confederate;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>អង្គភាពសហព័ទ្ធ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $confederation = $teacher_data['confederation'];
                                   if($confederation == ''){
                                        echo '-';
                                   }else{
                                        echo $confederation;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ត្រូវជា</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $must_be = $teacher_data['must_be'];
                                   if($must_be == ''){
                                        echo '-';
                                   }else{
                                        echo $must_be;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>មុខរបរសហព័ទ្ធ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $occupation = $teacher_data['occupation'];
                                   if($occupation == ''){
                                        echo '-';
                                   }else{
                                        echo $occupation;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ថ្ងៃខែឆ្នាំកំណើតសហព័ទ្ធ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $date_birth_spouse = $teacher_data['date_birth_spouse'];
                                   if($date_birth_spouse == ''){
                                        echo '-';
                                   }else{
                                        echo $date_birth_spouse;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>ប្រាក់ខែប្រពន្ធ</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $wife_salary = $teacher_data['wife_salary'];
                                   if($wife_salary == ''){
                                        echo '-';
                                   }else{
                                        echo $wife_salary;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="table__show">
                    <?php
                        $teacher_family = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($teacher_family) > 0){
                    ?>
                    <table class="table border">
                        <tr>
                            <th>ឈ្មោះកូន</th>
                            <th>ភេទ</th>
                            <th>ថ្ងៃខែឆ្នាំកំណើត</th>
                            <th>មុខរបរ</th>
                            <!-- <th>ប្រាក់កូន</th> -->
                        </tr>
                    <?php
                            while($data = mysqli_fetch_assoc($teacher_family)){
                            
                                if($data['child_name'] == '' && $data['gender'] == '' && $data['birth_date'] == '0000-00-00' && $data['occupation'] == ''){
                                    // echo 'No';
                                }else{
                            
                    ?>
                        <tr>
                            <td><?=$data['child_name'];?></td>
                            <td><?=$data['gender'];?></td>
                            <td><?=$data['birth_date'];?></td>
                            <td><?=$data['occupation'];?></td>
                        </tr>
                        <?php
                                }
                            }
                        echo '</table>';
                        }
                        mysqli_free_result($teacher_family);
                    ?>
                </div>

                <div class="view__top">
                    <div class="section">
                        <div class="title">
                            <p>ទូរស័ព្ទផ្ទាល់ខ្លួន</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $personal_phone = $teacher_data['personal_phone'];
                                   if($personal_phone == ''){
                                        echo '-';
                                   }else{
                                        echo $personal_phone;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>អ៊ីម៊ែល</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $email = $teacher_data['email'];
                                   if($email == ''){
                                        echo '-';
                                   }else{
                                        echo $email;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="section">
                        <div class="title">
                            <p>អាសយដ្ឋានបច្ចុប្បន្ន</p>
                            <p>:</p>
                        </div>
                        <div class="value ps-3">
                            <p>
                            <?php
                                   $current_address = $teacher_data['current_address'];
                                   if($current_address == ''){
                                        echo '-';
                                   }else{
                                        echo $current_address;
                                   }
                            ?>
                            </p>
                        </div>
                    </div>
                </div>
           </div>
          
           <?php
        }else{
            ?>
                <div class="all__teacher">
                    <p>Data not found. <a href="<?=SITEURL;?>teachers.php">Back</a></p>
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
?>
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>