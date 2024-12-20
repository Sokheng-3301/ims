<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

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


    <?php
        // form add student here 
        if(!isset($_GET['update-id'])){
    ?>
        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Add multi students<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add student</p>
           </div>

           <div class="my-3">
                <a href="<?=SITEURL;?>students.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>

           <div class="add__member">

            <!-- auto generate  -->
                <form action="<?=SITEURL;?>student-action.php" method="post">
                    <div class="generate__data" id="auto_generate"> 

                            <p>Multi generate student </p>
                            <?php
                                if(isset($_SESSION['NO_ID'])){
                            ?>
                                <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation" aria-hidden="true"></i>
                                    <?=$_SESSION['NO_ID'];?>
                                </div>
                            <?php
                                }
                                unset($_SESSION['NO_ID']);
                            ?>


                            <?php
                                if(isset($_SESSION['GENERATE'])){
                            ?>
                                <small id="message_show">
                                <?php
                                    echo $_SESSION['GENERATE'];
                                    // unset($_SESSION['GENERATE']);
                                ?>
                                </small>
                            <?php
                                }
                            ?>      

                        <label for="identify_number">Quantity number <span class="text-danger">*</span>
                            <small class="text-danger ms-3">
                                <?php if(isset($_SESSION['NUMBER_GENERATE'])) {
                                    echo $_SESSION['NUMBER_GENERATE']; 
                                    unset($_SESSION['NUMBER_GENERATE']);
                                }
                                ?>
                            </small>
                        </label>
                        <input type="number" class="" min = "1" name="number_generate" placeholder="Please input number to generate...">

                        <div class="flex__form">
                            <div class="block__form w-100">
                                <label for="">Class <span class="text-danger">*</span>
                                    <small class="text-danger ms-3">
                                        <?php if(isset($_SESSION['NO_MAJOR'])) {
                                            echo $_SESSION['NO_MAJOR']; 
                                            unset($_SESSION['NO_MAJOR']);
                                        }
                                        ?>
                                    </small>
                                </label>
                                <select name="class" id="class_selected" class="selectpicker" data-live-search="true"> 
                                    <option selected disabled>Please select class</option>

                                    <?php
                                        $class = "SELECT * FROM class";
                                        $class_run = mysqli_query($conn, $class);
                                        // if(mysqli_num_rows($class_run) > 0){
                                        while($data = mysqli_fetch_assoc($class_run)){                                       
                                    ?>
                                    <option value="<?= $data['class_id'];?>">Class <?= $data['class_code'];?></option>
                                    <?php
                                        }
                                        // }
                                    ?>                                  
                                </select>
                            </div>
                            <!-- <div class="block__form">
                                <label for="">Generation <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Generation...">
                            </div> -->
                        </div>

                        <div id="class_information" class="mt-3">
                            
                        </div>
                        
                        <button class="generate-btn" type="submit" name="std_auto_generate"><i class="fa fa-plus" aria-hidden="true"></i>Generate</button>
                    </div>
                </form>

           <!-- Generate data form  -->      
            
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>
        </div>

    <?php

        }else{
            // form update student here 
            $id = $_GET['update-id'];
            $update_data = mysqli_query($conn, "SELECT * FROM student_info WHERE id ='". $id ."'");
            if(mysqli_num_rows($update_data) > 0){
                $result = mysqli_fetch_assoc($update_data);
                $student_id = $result['student_id'];
            
    ?>
        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Update student<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update student</p>
           </div>

           <div class="my-3">
                <a href="<?=SITEURL;?>students.php<?php
                        $url_get = 'update-id='.$_GET['update-id'];
                        if($_SERVER['QUERY_STRING'] != $url_get){
                            echo '?'.trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                        }else{
                            echo "";
                        }
                    ?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>

           <div class="add__member">

                <!-- Generate data form  -->
                <form action="<?=SITEURL;?>student-action.php" method="post">
                    <input type="hidden" name="update_id" value="<?=$result['id'];?>">
                    <input type="hidden" name="url" value="<?php
                        $url_get = 'update-id='.$_GET['update-id'];
                        if($_SERVER['QUERY_STRING'] != $url_get){
                            echo trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                        }else{
                            echo "";
                        }
                    ?>">
                    <!-- personal data form -->
                    <div id="student_personal_info">
                        <div class="control__form__add">
                            <p>ព័ត៌មានផ្ទាល់ខ្លួនរបស់និស្សិត</p>
                        </div>
                        <div class="control__form__add">
                            <div class="part">
                                <label for="" class="">នាមត្រកូល និងនាមខ្លួន</label>
                                <div class="flex__form">
                                    <input type="text" id="" name="fn_kh" placeholder="នាមត្រកូល..." value="<?=$result['fn_khmer'];?>">
                                    <input type="text" name="ln_kh" placeholder="នាមខ្លួន..." value="<?=$result['ln_khmer'];?>">
                                </div>

                                <label for="">ជាអក្សរឡាតាំង</label>
                                <div class="flex__form"> 
                                    <input type="text" id="" name="fn_en" placeholder="First name..." value="<?=$result['firstname'];?>">
                                    <input type="text" name="ln_en" placeholder="Last name..." value="<?=$result['lastname'];?>">
                                </div>

                                <label for="birth_date">ភេទ</label>
                                <select name="gender" id="">
                                    <option selected disabled>សូមជ្រើសរើសភេទ</option>
                                    <option value="male" <?php
                                        if($result['gender'] == 'male') echo 'selected';
                                    ?>>ប្រុស</option>
                                    <option value="female" <?php
                                        if($result['gender'] == 'female') echo 'selected';
                                    ?>>ស្រី</option>
                                </select>

                                <label for="birth_date">ថ្ងៃខែឆ្នាំកំណើត</label>
                                <input type="date" name="brith_date" id="birth_date" value="<?=$result['birth_date'];?>">
                                
                                <div class="flex__form">
                                    <div class="block__form">
                                        <label for="">ជនជាតិ</label>
                                        <input type="text" name="national" placeholder="ជនជាតិ..." value="<?=$result['national'];?>">
                                    </div>
                                    <div class="block__form">
                                        <label for="">សញ្ជាតិ</label>
                                        <input type="text" name="nationality" placeholder="សញ្ជាតិ..." value="<?=$result['nationality'];?>">
                                    </div>
                                </div>

                                <label for="">ទីកន្លែងកំណើត</label>
                                <textarea name="birth_place" id="" cols="30" rows="5" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$result['place_of_birth'];?></textarea>

                            </div>
                            <div class="part">
                                
                                <label for="" class="">កម្រិតសិក្សា</label>
                                <select name="study_lavel" id="">
                                    <option selected disabled>សូមជ្រើសរើសកម្រិតសិក្សា</option>
                                    <option value="1" <?php
                                        if($result['level_id'] == '1') echo 'selected';
                                    ?>>បរិញ្ញាបត្រ</option>
                                    <option value="2" <?php
                                        if($result['level_id'] == '2') echo 'selected';
                                    ?>>បរិញ្ញាបត្ររង</option>
                                    <!-- <option value="">វិជ្ជាជីវៈកម្រិត​ ៣</option> -->
                                </select>

                                <label for="" class="">កម្រិតឆ្នាំ</label>
                                <select name="year_level_study" id="">
                                    <option selected disabled>សូមជ្រើសរើសកម្រិតឆ្នាំសិក្សា</option>
                                    <?php
                                        $yaer_study_level = mysqli_query($conn, "SELECT * FROM year_study_level");
                                        while($years = mysqli_fetch_assoc($yaer_study_level)){
                                    ?>
                                    <option value="<?=$years['year_level_id']?>" <?php
                                        if($result['year_level_id'] == $years['year_level_id']) echo 'selected';
                                    ?>>ឆ្នាំទី <?=$years['year_level'];?></option>
                                    <?php
                                        }
                                        mysqli_free_result($yaer_study_level);
                                    ?>
                                </select>

                                <label for="" class="">ឆ្នាំសិក្សា</label>
                                <select name="year_of_study" id="">
                                    <option selected disabled>សូមជ្រើសរើសឆ្នាំសិក្សា</option>
                                    <?php
                                        for($i=0; $i<=9; $i++){
                                    ?>
                                    <option value="202<?=$i;?>">ឆ្នាំសិក្សា 202<?=$i;?></option>
                                    <?php
                                        }
                                    ?>
                                </select>

                                <label for="phone">លេខទូរស័ព្ទ</label>
                                <input type="text"  id="phone" placeholder="លេខទូរស័ព្ទ" name="phone_number" value="<?=$result['phone_number'];?>">
                                <label for="birth_date">អ៊ីម៊ែល</label>
                                <input type="text" id="birth_date" placeholder="អ៊ីម៊ែល" name="email" value="<?=$result['email'];?>">
                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="current_place" id="" cols="30" rows="5" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$result['current_place'];?></textarea>
                            </div>
                        </div>
                        
                        <div class="control__form__add">
                            <p>ប្រវត្តិការសិក្សា</p>
                        </div>
                        <div class="control__form__add">
                               
                            <table>
                                <tr>
                                    <th>កម្រិតថ្នាក់</th>
                                    <th>ឈ្មោះសាលារៀន</th>
                                    <th>ខេត្ត/រាជធានី</th>
                                    <th>ពីឆ្នាំណាដល់ឆ្នាំណា</th>
                                    <th>សញ្ញាបត្រទទួលបាន</th>
                                    <th>និទ្ទេសរួម</th>
                                </tr>
                                    <?php
                                        $primary_sql = mysqli_query($conn, "SELECT * FROM background_education WHERE student_id ='". $student_id ."' AND class_level ='1'");
                                        // if(mysqli_num_rows($primary_sql) > 0){
                                            $primary_data = mysqli_fetch_assoc($primary_sql);
                                        //     print_r($primary_data);
                                        //     echo 'Hello';
                                        // }
                                    ?>
                                <tr>
                                    <input type="hidden" name="primary_id" value="<?=$primary_data['id'];?>">
                                    <td>បឋមសិក្សា</td>
                                    <td><input type="text" placeholder="ឈ្មោះសាលា" name="primary_school_name" value="<?=$primary_data['school_name'];?>"></td>
                                    <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="primary_address" value="<?=$primary_data['address'];?>"></td>
                                    <td>
                                        <div class="d-flex">
                                            <input type="text" placeholder="ចាប់ផ្តើម" name="primary_start" value="<?=$primary_data['start_year'];?>">
                                            <span class="px-1">-</span>
                                            <input type="text" placeholder="បញ្ចប់" name="primary_end" value="<?=$primary_data['finish_year'];?>">
                                        </div>
                                    </td>
                                    <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="primary_certificate" value="<?=$primary_data['certificate'];?>"></td>
                                    <td><input type="text" placeholder="និទ្ទេសរួម" name="primary_rank" value="<?=$primary_data['rank'];?>"></td>
                                </tr>

                                <?php
                                    mysqli_free_result($primary_sql);

                                        $secondary_sql = mysqli_query($conn, "SELECT * FROM background_education WHERE student_id ='". $student_id ."' AND class_level ='2'");
                                        // if(mysqli_num_rows($secondary_sql) > 0){
                                            $secondary_data = mysqli_fetch_assoc($secondary_sql);
                                        //     print_r($primary_data);
                                        //     echo 'Hello';
                                        // }
                                    ?>
                                <tr>
                                    <input type="hidden" name="secondary_id" value="<?=$secondary_data['id'];?>">

                                    <td>បឋមភូមិ</td>
                                    <td><input type="text" placeholder="ឈ្មោះសាលា" name="secondary_school_name" value="<?=$secondary_data['school_name'];?>"></td>
                                    <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="secondary_address" value="<?=$secondary_data['address'];?>"></td>
                                    <td>
                                        <div class="d-flex">
                                            <input type="text" placeholder="ចាប់ផ្តើម" name="secondary_start" value="<?=$secondary_data['start_year'];?>">
                                            <span class="px-1">-</span>
                                            <input type="text" placeholder="បញ្ចប់" name="secondary_end" value="<?=$secondary_data['finish_year'];?>">
                                        </div>
                                    </td>
                                    <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="secondary_certificate" value="<?=$secondary_data['certificate'];?>"></td>
                                    <td><input type="text" placeholder="និទ្ទេសរួម" name="secondary_rank" value="<?=$secondary_data['rank'];?>"></td>
                                </tr>

                                <?php
                                    mysqli_free_result($secondary_sql);

                                        $high_sql = mysqli_query($conn, "SELECT * FROM background_education WHERE student_id ='". $student_id ."' AND class_level ='3'");
                                        // if(mysqli_num_rows($high_sql) > 0){
                                            $high_data = mysqli_fetch_assoc($high_sql);
                                        //     print_r($primary_data);
                                        //     echo 'Hello';
                                        // }
                                    ?>
                                <tr>
                                    <input type="hidden" name="high_id" value="<?=$high_data['id'];?>">

                                    <td>ទុតិយភូមិ</td>
                                    <td><input type="text" placeholder="ឈ្មោះសាលា" name="high_school_name" value="<?=$high_data['school_name'];?>"></td>
                                    <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="high_address" value="<?=$high_data['address'];?>"></td>
                                    <td>
                                        <div class="d-flex">
                                            <input type="text" placeholder="ចាប់ផ្តើម" name="high_start" value="<?=$high_data['start_year'];?>">
                                            <span class="px-1">-</span>
                                            <input type="text" placeholder="បញ្ចប់" name="high_end" value="<?=$high_data['finish_year'];?>">
                                        </div>
                                    </td>
                                    <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="high_certificate" value="<?=$high_data['certificate'];?>"></td>
                                    <td><input type="text" placeholder="និទ្ទេសរួម" name="high_rank" value="<?=$high_data['rank'];?>"></td>
                                </tr>
                            </table>
                        </div>


                        <div class="control__form__add">
                            <p>ព័ត៌មានគ្រួសារ</p>
                        </div>

                        <div class="control__form__add">
                            <div class="part">
                                <label for="">ឈ្មោះឪពុក</label>
                                <input type="text" name="fatherName" placeholder="ឈ្មោះឪពុក" value="<?=$result['father_name'];?>">

                                <label for="">អាយុរបស់ឪពុក</label>
                                <input type="text" name="fatherAge" placeholder="អាយុរបស់ឪពុក" value="<?=$result['father_age'];?>">

                                <label for="">មុខរបរ</label>
                                <input type="text" name="fatherOccupa" placeholder="មុខរបរ" value="<?=$result['father_occupa'];?>">

                                <label for="">លេខទូរស័ព្ទ</label>
                                <input type="text" name="fatherPhone" placeholder="លេខទូរស័ព្ទ" value="<?=$result['father_phone'];?>">

                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="fatherAddress" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$result['father_address'];?></textarea>                  
                            </div>

                            <div class="part">
                                <label for="">ឈ្មោះម្តាយ</label>
                                <input type="text" name="motherName" placeholder="ឈ្មោះម្តាយ" value="<?=$result['mother_name'];?>">

                                <label for="">អាយុរបស់ម្តាយ</label>
                                <input type="text" name="motherAge" placeholder="អាយុរបស់ម្តាយ" value="<?=$result['mother_age'];?>">

                                <label for="">មុខរបរ</label>
                                <input type="text" name="motherOccupa" placeholder="មុខរបរ" value="<?=$result['mother_occupa'];?>">

                                <label for="">លេខទូរស័ព្ទ</label>
                                <input type="text" name="motherPhone" placeholder="លេខទូរស័ព្ទ" value="<?=$result['mother_phone'];?>">

                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="motherAddress" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$result['mother_address'];?></textarea>                  
                            </div>
                        </div>


                        <div class="control__form__add">
                            <div class="part">
                                <div class="flex__form">
                                    <div class="block__form">
                                        <label for="">ចំនួនសមាជិកបងប្អូន</label>
                                        <input type="number" min = "0" max="10" name="sibling" id="sibling" placeholder="ចំនួនសមាជិកបងប្អូន" value="<?=$result['sibling'];?>">
                                    </div>
                                    <div class="block__form">
                                        <label for="">ចំនួនបងប្អូនស្រី</label>
                                        <input type="number" name="femaleSibling"  min = "0" max = "10" placeholder="ចំនួនបងប្អូនស្រី" value="<?=$result['female_sibling'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="control__form__add">
                            <table id="myTable">                           
                                <tr>
                                    <th>ឈ្មោះ</th>
                                    <th>ភេទ</th>
                                    <th>ថ្ងៃខែឆ្នាំកំណើត</th>
                                    <th>មុខរបរ</th>
                                    <th>ទីកន្លែងបច្ចុប្បន្ន</th>
                                    <th>លេខទូរស័ព្ទ</th>
                                </tr>
                                <?php
                                    $sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id='". $student_id ."'");
                                    $count_sibling = mysqli_num_rows($sibling);
                                    if($count_sibling > 0){
                                        $i = 1;
                                        for($i; $i<=$count_sibling; $i++){
                                            $student_sibling = mysqli_fetch_assoc($sibling)
                                ?>
                                    <tr>
                                        <td><input type="text" placeholder="ឈ្មោះ" name = 'name<?=$i;?>'></td>
                                        <td><select name='gender<?=$i;?>' id=""><option value="male">ប្រុស</option><option value="female">ស្រី</option></select></td>
                                        <td><input type="date" name = 'birthDate<?=$i;?>'></td>
                                        <td><input type="text" placeholder="មុខរបរ" name='occupa<?=$i;?>'></td>
                                        <td><textarea id="" cols="30" rows="1" placeholder="ទីកន្លែងបច្ចុប្បន្ន" name='currentAdd<?=$i;?>'></textarea></td>
                                        <td><input type="text" placeholder="លេខទូរស័ព្ទ"  name ="phone<?=$i;?>"></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </table>
                        
                        </div>
                        <!-- form add row in table  -->
                        <div id="control__add__row">
                            <p  id="addRow" onclick="addRowTable()">Show table</p>
                            <p onclick="deleteRow()">Delete row</p>
                        </div>
                    
                        <div class="button">
                            <button type="submit" name="update_student" class="btn-update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>
                        </div>
                    </div>
                </form>          
           </div>
          

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>
        </div>
    <?php
            }else{
    ?>
        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Add new student<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add student</p>
           </div>

           <!-- <div class="my-3">
                <a href="<?=SITEURL;?>students.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div> -->

           <div class="add__member">
                <P class="p-2">Data not found. <a href="<?=SITEURL;?>students.php">Back</a></P> 
           </div>
        </div>

    <?php
            }
        }
    ?>
        
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

    <script>
        $(document).ready(function(){
            $('#class_selected').on('change', function(){
                var class_selected = $(this).val();
                if(class_selected){
                    $.ajax({
                        type:'POST',
                        url:'ajaxData.php',
                        data:'class_selected='+class_selected,
                        success:function(html){
                            $('#class_information').html(html);
                            // $('#city').html('<option value="">Select semester first</option>'); 
                        }
                    }); 
                }else{
                    
                }            
            });
        });
    </script>

</body>
</html>