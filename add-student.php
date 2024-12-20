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
                <h5 class="super__title">Add new student<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add student</p>
           </div>

           <div class="my-3">
                <a href="<?=SITEURL;?>students.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>

           <div class="add__member">
           <!-- Generate data form  -->
                <form action="<?=SITEURL;?>student-action.php" method="post" >
                    
                    <!-- menul generate form  -->
                    <div class="generate__data" id="menul_generate">
                    <p>Generate student </p>  

                        <?php
                            if(isset($_SESSION['NO_ID_M'])){
                        ?>
                            <div class="alert alert-warning" role="alert"><i class="fa fa-exclamation" aria-hidden="true"></i>
                                <?=$_SESSION['NO_ID_M'];?>
                            </div>
                        <?php
                            }
                            unset($_SESSION['NO_ID_M']);
                        ?>



                        <?php
                            if(isset($_SESSION['GENERATE_MANULE'])){
                        ?>
                            <small id="message_show">
                            <?php
                                echo $_SESSION['GENERATE_MANULE'];
                            ?>
                            </small>
                        <?php
                            }
                            unset($_SESSION['GENERATE_MANULE']);
                        ?> 
                        
                        
                        <?php
                            if(isset($_SESSION['GENERATE_MANULE_ERROR'])){
                        ?>
                            <small id="message_show_error">
                            <?php
                                echo $_SESSION['GENERATE_MANULE_ERROR'];
                            ?>
                            </small>
                        <?php
                            }
                            unset($_SESSION['GENERATE_MANULE_ERROR']);
                        ?>      


                        <label for="username">Username <span class="text-danger">*</span> 
                            <small class="text-danger ms-3">
                                <?php if(isset($_SESSION['NO_USENAME_M'])) {
                                    echo $_SESSION['NO_USENAME_M']; 
                                    unset($_SESSION['NO_USENAME_M']);
                                }
                                ?>
                            </small>
                        </label>
                        <input type="text" id="username" placeholder="Username..." name="username">

                        <label for="password">Password <span class="text-danger">*</span>
                            <small class="text-danger ms-3">
                                <?php if(isset($_SESSION['NO_PASS_M'])) {
                                    echo $_SESSION['NO_PASS_M']; 
                                    unset($_SESSION['NO_PASS_M']);
                                }
                                ?>
                            </small>
                        </label>
                        <input type="password" id="password" placeholder="Password..." name="password">

                        <!-- <label for="identify_number">Identify number <span class="text-danger">*</span>
                            <small class="text-danger ms-3">
                                < if(isset($_SESSION['NO_ID_M'])) {
                                    echo $_SESSION['NO_ID_M']; 
                                    unset($_SESSION['NO_ID_M']);
                                }
                                ?>
                            </small>
                        </label>
                        <input type="text" id="identify_number" placeholder="Identify number..." name="indentify_number"> -->
                        <div class="flex__form">
                            <div class="block__form w-100">
                                <label for="">Class <span class="text-danger">*</span>
                                    <small class="text-danger ms-3">
                                        <?php if(isset($_SESSION['NO_MAJOR_M'])) {
                                            echo $_SESSION['NO_MAJOR_M']; 
                                            unset($_SESSION['NO_MAJOR_M']);
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

                        
                        
                        
                        <button class="generate-btn" type="submit" name="std_generate"><i class="fa fa-plus" aria-hidden="true"></i>Generate</button>
                    </div>

                    <!-- Auto generate form  -->
                    


                    <!-- personal data form -->
                    <div id="student_personal_info">
                        <div class="control__form__add">
                            <p>ព័ត៌មានផ្ទាល់ខ្លួនរបស់និស្សិត</p>
                        </div>
                        <div class="control__form__add">
                            <div class="part">
                                <label for="" class="">នាមត្រកូល និងនាមខ្លួន</label>
                                <div class="flex__form">
                                    <input type="text" id="" name="fn_kh" placeholder="នាមត្រកូល...">
                                    <input type="text" name="ln_kh" placeholder="នាមខ្លួន...">
                                </div>

                                <label for="">ជាអក្សរឡាតាំង</label>
                                <div class="flex__form">
                                    <input type="text" id="" name="fn_en" placeholder="First name...">
                                    <input type="text" name="ln_en" placeholder="Last name...">
                                </div>

                                <div class="flex__form">
                                    <div class="block__form">
                                        <label for="birth_date">ភេទ</label>
                                        <select name="gender" id="" class="selectpicker mt-1">
                                            <option selected disabled>សូមជ្រើសរើសភេទ</option>
                                            <option value="male">ប្រុស</option>
                                            <option value="female">ស្រី</option>
                                        </select>
                                    </div>
                                    <div class="block__form">
                                        <label for="birth_date">ថ្ងៃខែឆ្នាំកំណើត</label>
                                        <input type="date" name="brith_date" id="birth_date">
                                    </div>
                                </div>

                               
                                
                               

                                <label for="">ទីកន្លែងកំណើត</label>
                                <textarea name="birth_place" id="" cols="30" rows="5" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"></textarea>

                            </div>
                            <div class="part">
                                
                                <div class="flex__form">
                                    <div class="block__form">
                                        <label for="">ជនជាតិ</label>
                                        <input type="text" name="national" placeholder="ជនជាតិ...">
                                    </div>
                                    <div class="block__form">
                                        <label for="">សញ្ជាតិ</label>
                                        <input type="text" name="nationality" placeholder="សញ្ជាតិ...">
                                    </div>
                                </div>


                                <!-- <label for="" class="">ជំនាញសិក្សា</label>
                                <select name="major" id="">
                                    <option value="">ជំនាញសិក្សា</option>
                                    <option value="">ជំនាញសិក្សា</option>
                                    <option value="">ជំនាញសិក្សា</option>
                                    <option value="">ជំនាញសិក្សា</option>
                                    <option value="">ជំនាញសិក្សា</option>
                                </select> -->

                                <label for="phone">លេខទូរស័ព្ទ</label>
                                <input type="text"  id="phone" placeholder="លេខទូរស័ព្ទ" name="phone_number">
                                <label for="birth_date">អ៊ីម៊ែល</label>
                                <input type="text" id="birth_date" placeholder="អ៊ីម៊ែល" name="email">
                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="current_place" id="" cols="30" rows="5" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"></textarea>
                            </div>
                        </div>
                        <div class="control__form__add">
                            <p>ប្រវត្តិការសិក្សា</p>
                        </div>
                        <div class="control__form__add">
                            <div class="table_manage">
                                <table>
                                    <tr>
                                        <th>កម្រិតថ្នាក់</th>
                                        <th>ឈ្មោះសាលារៀន</th>
                                        <th>ខេត្ត/រាជធានី</th>
                                        <th>ពីឆ្នាំណាដល់ឆ្នាំណា</th>
                                        <th>សញ្ញាបត្រទទួលបាន</th>
                                        <th>និទ្ទេសរួម</th>
                                    </tr>
                                    <tr>
                                        <td>បឋមសិក្សា</td>
                                        <td><input type="text" placeholder="ឈ្មោះសាលា" name="primary_school_name"></td>
                                        <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="primary_address"></td>
                                        <td>
                                            <div class="d-flex">
                                                <input type="text" placeholder="ចាប់ផ្តើម" name="primary_start">
                                                <span class="px-1">-</span>
                                                <input type="text" placeholder="បញ្ចប់" name="primary_end">
                                            </div>
                                        </td>
                                        <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="primary_certificate"></td>
                                        <td><input type="text" placeholder="និទ្ទេសរួម" name="primary_rank"></td>
                                    </tr>
                                    <tr>
                                        <td>បឋមភូមិ</td>
                                        <td><input type="text" placeholder="ឈ្មោះសាលា" name="secondary_school_name"></td>
                                        <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="secondary_address"></td>
                                        <td>
                                            <div class="d-flex">
                                                <input type="text" placeholder="ចាប់ផ្តើម" name="secondary_start">
                                                <span class="px-1">-</span>
                                                <input type="text" placeholder="បញ្ចប់" name="secondary_end">
                                            </div>
                                        </td>
                                        <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="secondary_certificate"></td>
                                        <td><input type="text" placeholder="និទ្ទេសរួម" name="secondary_rank"></td>
                                    </tr>
                                    <tr>
                                        <td>ទុតិយភូមិ</td>
                                        <td><input type="text" placeholder="ឈ្មោះសាលា" name="high_school_name"></td>
                                        <td><input type="text" placeholder="ខេត្ត/រាជធានី" name="high_address"></td>
                                        <td>
                                            <div class="d-flex">
                                                <input type="text" placeholder="ចាប់ផ្តើម" name="high_start">
                                                <span class="px-1">-</span>
                                                <input type="text" placeholder="បញ្ចប់" name="high_end">
                                            </div>
                                        </td>
                                        <td><input type="text" placeholder="សញ្ញាបត្រទទួលបាន" name="high_certificate"></td>
                                        <td><input type="text" placeholder="និទ្ទេសរួម" name="high_rank"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="control__form__add">
                            <p>ព័ត៌មានគ្រួសារ</p>
                        </div>

                        <div class="control__form__add">
                            <div class="part">
                                <label for="">ឈ្មោះឪពុក</label>
                                <input type="text" name="fatherName" placeholder="ឈ្មោះឪពុក">

                                <label for="">អាយុរបស់ឪពុក</label>
                                <input type="text" name="fatherAge" placeholder="អាយុរបស់ឪពុក">

                                <label for="">មុខរបរ</label>
                                <input type="text" name="fatherOccupa" placeholder="មុខរបរ">

                                <label for="">លេខទូរស័ព្ទ</label>
                                <input type="text" name="fatherPhone" placeholder="លេខទូរស័ព្ទ">

                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="fatherAddress" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"></textarea>                  
                            </div>

                            <div class="part">
                                <label for="">ឈ្មោះម្តាយ</label>
                                <input type="text" name="motherName" placeholder="ឈ្មោះម្តាយ">

                                <label for="">អាយុរបស់ម្តាយ</label>
                                <input type="text" name="motherAge" placeholder="អាយុរបស់ម្តាយ">

                                <label for="">មុខរបរ</label>
                                <input type="text" name="motherOccupa" placeholder="មុខរបរ">

                                <label for="">លេខទូរស័ព្ទ</label>
                                <input type="text" name="motherPhone" placeholder="លេខទូរស័ព្ទ">

                                <label for="">ទីកន្លែងបច្ចុប្បន្ន</label>
                                <textarea name="motherAddress" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"></textarea>                  
                            </div>
                        </div>


                        <div class="control__form__add">
                            <div class="part">
                                <div class="flex__form">
                                    <div class="block__form">
                                        <label for="">ចំនួនសមាជិកបងប្អូន</label>
                                        <input type="number" min = "0" max="10" name="sibling" id="sibling" placeholder="ចំនួនសមាជិកបងប្អូន">
                                    </div>
                                    <div class="block__form">
                                        <label for="">ចំនួនបងប្អូនស្រី</label>
                                        <input type="number" name="femaleSibling"  min = "0" max = "10" placeholder="ចំនួនបងប្អូនស្រី">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="control__form__add">
                            <div class="table_manage">
                                <table id="myTable">                              
                                        <tr>
                                            <th>ឈ្មោះ</th>
                                            <th>ភេទ</th>
                                            <th>ថ្ងៃខែឆ្នាំកំណើត</th>
                                            <th>មុខរបរ</th>
                                            <th>ទីកន្លែងបច្ចុប្បន្ន</th>
                                            <th>លេខទូរស័ព្ទ</th>
                                        </tr>
                                    
                                    
                                    <!-- <tr>
                                        <td>
                                            <input type="text" placeholder="ឈ្មោះ">
                                        </td>
                                        <td>
                                            <select name="" id="">
                                                <option value="">ប្រុស</option>
                                                <option value="">ស្រី</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="មុខរបរ">
                                        </td>
                                        <td>
                                            <textarea name="" id="" cols="30" rows="1" placeholder="ទីកន្លែងបច្ចុប្បន្ន"></textarea>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="លេខទូរស័ព្ទ">
                                        </td>
                                    </tr> -->
                                </table>
                            </div>
                        
                        </div>
                        <!-- form add row in table  -->
                        <div id="control__add__row">
                            <p  id="addRow" onclick="addRowTable()">Show table</p>
                            <p onclick="deleteRow()">Delete row</p>
                        </div>
                    
                        <div class="button">
                            <button type="submit" name="std_generate"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>
                        </div>
                    </div>

                </form>


            
            
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

                               <div class="flex__form">
                                    <div class="block__form">
                                        <label for="birth_date">ភេទ</label>
                                        <select name="gender" id="" class="selectpicker mt-1">
                                            <option selected disabled>សូមជ្រើសរើសភេទ</option>
                                            <option value="male" <?php
                                                if($result['gender'] == 'male') echo 'selected';
                                            ?>>ប្រុស</option>
                                            <option value="female" <?php
                                                if($result['gender'] == 'female') echo 'selected';
                                            ?>>ស្រី</option>
                                        </select>
                                    </div>
                                    <div class="block__form">
                                        <label for="birth_date">ថ្ងៃខែឆ្នាំកំណើត</label>
                                        <input type="date" name="brith_date" id="birth_date" value="<?=$result['birth_date'];?>">
                                    </div>
                               </div>

                               
                                
                                

                                <label for="">ទីកន្លែងកំណើត</label>
                                <textarea name="birth_place" id="" cols="30" rows="5" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$result['place_of_birth'];?></textarea>

                            </div>
                            <div class="part">
 
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
                            <div class="table_manage">
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
                            <div class="table_manage">
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
                                            <td><input type="text" placeholder="ឈ្មោះ" name = 'name<?=$i;?>' value="<?=$student_sibling['sibl1_name'];?>"></td>
                                            <td>
                                                <select name='gender<?=$i;?>' id="">
                                                    <option value="male" <?php echo ($student_sibling['sibl1_gender'] == 'male') ? 'selected' : ''; ?>>ប្រុស</option>
                                                    <option value="female" <?php echo ($student_sibling['sibl1_gender'] == 'female') ? 'selected' : ''; ?>>ស្រី</option>
                                                </select>
                                            </td>
                                            <td><input type="date" name = 'birthDate<?=$i;?>' value="<?=$student_sibling['sibl1_birth_date'];?>"></td>
                                            <td><input type="text" placeholder="មុខរបរ" name='occupa<?=$i;?>' value="<?=$student_sibling['sibl1_occupa'];?>"></td>
                                            <td><textarea id="" cols="30" rows="1" placeholder="ទីកន្លែងបច្ចុប្បន្ន" name='currentAdd<?=$i;?>'><?=$student_sibling['sibl1_address'];?></textarea></td>
                                            <td><input type="text" placeholder="លេខទូរស័ព្ទ"  name ="phone<?=$i;?>" value="<?=$student_sibling['sibl1_phone'];?>"></td>
                                        </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                        <!-- form add row in table  -->
                        <div id="control__add__row">
                            <p  id="addRow" onclick="addRowTable()">Show table</p>
                            <p onclick="deleteRow()">Delete row</p>
                        </div>


                        <div class="button__controller">
                            <?php
                                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] == 'admin'){
                            ?>

                            <div class="reset_pass_btn">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="reset p-1 px-2 rounded">Reset password</a>
                            </div>
                            <?php
                                }
                            ?>

                            <div class="button">
                            <?php
                                if($result['active_status'] == '0'){
                            ?>
                            <a href="<?=SITEURL;?>student-action.php?reco=<?=$id;?>" class="btn-update btn-primary p-1 px-2 rounded"><i class="fa fa-refresh" aria-hidden="true"></i>Recovery</a>
                            <?php
                                }
                            ?>
                            <button type="submit" name="update_student" class="btn-update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>
                        </div>
                        </div>
                        
                    </div>
                </form>        
           </div>

          
           <!-- modal reset  -->
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Reset password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h1 class="fs-1 text-center"><i class="fa fa-refresh text-warning" aria-hidden="true"></i></h1>
                            <p class="text-center">Password will reset for Student ID: <b class="text-primary"><?=$result['student_id'];?></b></p>
                            <p class="text-center">Password reset: <b class="text-primary">1234</b></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <form action="<?=SITEURL;?>student-action.php" method="post">
                                <input type="hidden" class="d-done" name="reset_id" value="<?=$id;?>">
                                <button type="submit" name="btnResetPass" class="btn btn-primary btn-sm">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
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





    <!-- pop up message when generate data success  -->
    <?php
        if(isset($_SESSION['RESETED'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['RESETED'];?>
            </p>
            <p class="mt-4">
                <a href="" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['RESETED']);
        if(isset($_SESSION['RESETED_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['RESETED_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['RESETED_ERROR']);
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