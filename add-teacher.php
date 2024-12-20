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

        if(!isset($_GET['update-id'])){
#============================= ADD TEACHER INFO HERE ===========================#

    ?>

        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Add new teacher<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Add teacher</p>
           </div>
           <div class="my-3">
                <a href="<?=SITEURL;?>teachers.php" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>
           <div class="add__member">


                    
                <form action="<?=SITEURL;?>teacher-action.php" method="post">
                    <!-- Generate data form  -->
                    <div class="generate__data">
                        <p>Generate data</p>
                        
                            <?php
                                // if(isset($_SESSION['GENERATE'])){
                            ?>
                                <!-- <small id="message_show"> -->
                                <?php
                                    // echo $_SESSION['GENERATE'];
                                    // unset($_SESSION['GENERATE']);
                                ?>
                                <!-- </small> -->
                            <?php
                                // }
                            ?>                       
                        
                        <input class="d-none" type="hidden" name="url" value="<?php echo basename($_SERVER['PHP_SELF']);?>">
                        <label for="username">Username <span class="text-danger">*</span>
                            <small class="ms-3 text-danger">
                                <?php
                                    if(isset($_SESSION['NO_USERNAME'])){
                                        echo $_SESSION['NO_USERNAME'];
                                        unset($_SESSION['NO_USERNAME']);
                                    }
                                ?>
                            </small>
                        </label>
                        <input type="text" id="username" name="username" placeholder="Username...">

                        <label for="password">Password <span class="text-danger">*</span>
                            <small class="ms-3 text-danger">
                                <?php
                                    if(isset($_SESSION['NO_PASSWORD'])){
                                        echo $_SESSION['NO_PASSWORD'];
                                        unset($_SESSION['NO_PASSWORD']);
                                    }
                                ?>
                            </small>
                        </label>
                        <input type="text" id="password" name="password" placeholder="Password...">

                        <label for="teacher_id">Identify number<span class="text-danger"> *</span>
                            <small class="ms-3 text-danger">
                                <?php
                                    if(isset($_SESSION['NO_ID'])){
                                        echo $_SESSION['NO_ID'];
                                        unset($_SESSION['NO_ID']);
                                    }
                                ?>
                            </small>
                        </label>
                        <input type="text" id="teacher_id" name="teacher_id" placeholder="Identify number...">
                        <label for="department">Department</label><span class="text-danger"> *</span> <small class="ms-3 text-danger">
                                <?php
                                    if(isset($_SESSION['NO_DEPARTMENT'])){
                                        echo $_SESSION['NO_DEPARTMENT'];
                                        unset($_SESSION['NO_DEPARTMENT']);
                                    }
                                ?>
                            </small>
                        <select name="teacher_department" id="department"> 
                            <option disabled selected>Please select department</option>
                            <?php
                                $department = mysqli_query($conn, "SELECT * FROM department");
                                while($result = mysqli_fetch_assoc($department)){
                            ?>
                            <option value="<?=$result['department_id'];?>"><?=$result['department'];?></option>
                            <?php
                                }
                            ?>
                        </select>

                        <!-- <label for="role" class="mb-1">Functional role  <span class="text-danger">*</span></label>
                        <div class="check__box">
                            <input type="checkbox" name="role_permission" checked value="Teacher" id="teacher"> <label for="teacher">Teacher / Instructor</label>
                        </div>
                        <div class="check__box">
                            <input type="checkbox" name="role_permission" value="Officer" id="officer"> <label for="officer">Staff officer</label>
                        </div> -->
                        <button type="submit" name="generate_teacher" class="generate-btn"><i class="fa fa-plus" aria-hidden="true"></i>Generate</button>
                    </div>

                    <!-- personal data form -->
                    <div class="control__form__add">
                        <p>ប្រវត្តិរូបគ្រូបង្រៀន</p>
                    </div>
                    <div class="control__form__add">
                        <div class="part">
                            <label for="teacher_nameKh" class="">នាមត្រកូល និងនាមខ្លួន</label>
                            <div class="flex__form">
                                <input type="text" name="fn_kh" id="teacher_nameKh" placeholder="នាមត្រកូល...">
                                <input type="text" name="ln_kh" placeholder="នាមខ្លួន...">
                            </div>
                            <label for="teacher_nameEn">ជាអក្សរឡាតាំង</label>
                            <div class="flex__form">
                                <input type="text" name="fn_en" id="teacher_nameEn" placeholder="First name...">
                                <input type="text" name="ln_en" placeholder="Last name...">
                            </div>

                            <label for="birth_date">ភេទ</label>
                            <select name="gender" id="">
                                <option selected disabled>សូមជ្រើសរើស</option>
                                <option value="male">ប្រុស</option>
                                <option value="female">ស្រី</option>
                            </select>

                            <label for="birth_date">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="date" name="teacher_birth_date" id="birth_date">
                            
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ជនជាតិ</label>
                                    <input type="text" name="nationality" placeholder="ជនជាតិ...">
                                </div>
                                <div class="block__form">
                                    <label for="">ពិការ</label>
                                    <input type="text" name="disability"  placeholder="ពិការ...">
                                </div>
                            </div>
                            <label for="" class="">អត្តលេខមន្ត្រី</label>
                            <input type="text" id="" name="officer_id" placeholder="អត្តលេខមន្ត្រី...">
                            <label for="" class="">លេខអត្តសញ្ញាណបណ្ណ</label>
                            <input type="text" id="" name="indentify_card_number" placeholder="លេខអត្តសញ្ញាណបណ្ណ...">
                            <label for="">ទីកន្លែងកំណើត</label>
                            <textarea name="place_birth" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"></textarea>

                        </div>
                        <div class="part">
                            
                            <label for="" class="">លេខគណនីបៀវត្ស</label>
                            <input type="text" id="" name="payroll_acc" placeholder="លេខគណនីបៀវត្ស...">
                            <label for="" class="">លេខសមាជិកបសបខ</label>
                            <input type="text" id="" name="member_bcc_id" placeholder="លេខសមាជិកបសបខ...">


                            <label for="birth_date">ថ្ងៃខែឆ្នាំចូលបម្រើការងារ</label>
                            <input type="date" id="birth_date" name="date_of_employment">
                            <label for="birth_date">ថ្ងៃខែឆ្នាំតែងតាំងស៊ុប</label>
                            <input type="date" id="birth_date" name="date_of_soup">
                            
                            <label for="">អង្គភាពបម្រើការងារ</label>
                            <input type="text" placeholder="អង្គភាពបម្រើការងារ..." name="working_unit">

                            <div class="flex__form address">
                                <div class="block__form">
                                    <label for="">ភូមិ</label>
                                    <input type="text" placeholder="ភូមិ..." name="working_unit_add[]">
                                </div>
                                <div class="block__form">
                                    <label for="">ឃុំ</label>
                                    <input type="text" placeholder="ឃុំ..." name="working_unit_add[]">
                                </div>
                                <div class="block__form">
                                    <label for="">ស្រុក</label>
                                    <input type="text" placeholder="ស្រុក..." name="working_unit_add[]">
                                </div>
                                <div class="block__form">
                                    <label for="">ខេត្ត</label>
                                    <input type="text" placeholder="ខេត្ត..." name="working_unit_add[]">
                                </div>
                            </div>
                            <label for="">ការិយាល័យ</label>
                            <input type="text" placeholder="ការិយាល័យ..." name="office">
                            <label for="">មុខដំណែង</label>
                            <input type="text" placeholder="មុខដំណែង..." name="position">
                            <label for="">ប្រកាស</label>
                            <input type="text" placeholder="ប្រកាស..." name="anountment">
                        </div>
                    </div>


                    <!-- this is  -->

                    <div class="control__form__add">
                        <p>ឋានៈវិជ្ជាជីវៈគ្រូបង្រៀន</p>

                        
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table1" id="countrow_table1" value="2">
                    </div>
                    <!-- <div class="control__form__add"> -->
                    
                    <!-- </div> -->
                    
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table1">
                                <tr>
                                    <th class="table-width-200">ប្រភេទឋានៈវិជ្ជាជីវៈ</th>
                                    <th class="table-width-200">បរិយាយ</th>
                                    <th class="table-width-50">ប្រកាសលេខ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type1" placeholder="ប្រភេទឋានៈវិជ្ជាជីវៈ">
                                    </td>
                                    <td>
                                        <textarea name="descript1" id="" cols="30" rows="1"  placeholder="បរិយាយ"></textarea>
                                    </td><td>
                                        <input type="text" name="annount1" placeholder="ប្រកាសលេខ">
                                    </td><td>
                                        <input type="date" name="date_get1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type2" placeholder="ប្រភេទឋានៈវិជ្ជាជីវៈ">
                                    </td>
                                    <td>
                                        <textarea name="descript2" id="" cols="30" rows="1" placeholder="បរិយាយ"></textarea>
                                    </td><td>
                                        <input type="text" name="annount2" placeholder="ប្រកាសលេខ">
                                    </td><td>
                                        <input type="date" name="date_get2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row1" min = "0" class="add__row__number" placeholder="Add row" value = "1">
                        <p onclick="addRowTeacher1('add_row1', 'table1'), countRowInTable('countrow_table1', 'table1')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>

                    
                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ឋាននន្តរស័ក្តិ និងថ្នាក់</label>
                            <input type="text" placeholder="ឋាននន្តរស័ក្តិ និងថ្នាក់" name="position_rank">

                            <label for="">យោង</label>
                            <input type="text" placeholder="យោង" name="refer">

                            <label for="">លេខរៀង</label>
                            <input type="text" placeholder="លេខរៀង" name="numbering">

                            <label for="">ថ្ងៃខែឡើងការប្រាក់ចុងក្រោយ</label>
                            <input type="date" name="date_last_interest">

                            <label for="">ចុះថ្ងៃទី</label>
                            <input type="date" name="dated">

                            <label for="">បង្រៀននៅឆ្នាំសិក្សា</label>
                            <input type="text" placeholder="បង្រៀននៅឆ្នាំសិក្សា" name="teaching_in_year">                          
                        </div>

                        <div class="part">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">បង្រៀនភាសាអង់គ្លេស</label>
                                    <input type="text" placeholder="បង្រៀនភាសាអង់គ្លេស" name="english_teaching">
                                </div>
                                <div class="block__form">
                                    <label for="">ថ្នាក់គួបបីកម្រិត</label>
                                    <input type="text" placeholder="ថ្នាក់គួបបីកម្រិត" name="three_level_combine">
                                </div>
                            </div>
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ប្រធានក្រុមបច្ចេកទេស</label>
                                    <input type="text" placeholder="ប្រធានក្រុមបច្ចេកទេស" name="technic_team_leader">
                                </div>
                                <div class="block__form">
                                    <label for="">ជួយបង្រៀន</label>
                                    <input type="text" placeholder="ជួយបង្រៀន" name="help_teach">
                                </div>
                            </div>

                            <div class="flex__form">
                            
                                <div class="block__form">
                                    <label for="">ពីរថ្នាក់ណីរពេល</label>
                                    <input type="text" placeholder="ពីរថ្នាក់ណីរពេល" name="two_class">
                                </div>
                                <div class="block__form">
                                    <label for="">ទទួលបន្ទុកថ្នាក់</label>
                                    <input type="text" placeholder="ទទួលបន្ទុកថ្នាក់" name="class_charg">
                                </div>
                            </div>

                            <div class="flex__form">
                                
                                <div class="block__form">
                                    <label for="">បង្រៀនឆ្លងសាលា</label>
                                    <input type="text" placeholder="បង្រៀនឆ្លងសាលា" name="cross_school">
                                </div>
                                <div class="block__form">
                                    <label for="">ម៉ោងលើស</label>
                                    <input type="text" placeholder="ម៉ោងលើស" name="overtime">
                                </div>
                            </div>

                            <div class="flex__form">
                                
                                <div class="block__form">
                                    <label for="">ថ្នាក់គួប</label>
                                    <input type="text" placeholder="ថ្នាក់គួប" name="coupling_class">
                                </div>
                                <div class="block__form">
                                    <label for="">ពីរភាសា</label>
                                    <input type="text" placeholder="ពីរភាសា" name="two_language">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- teaching class  -->
                    <!-- <div id="control__add__row">
                        <p id="addRow">Add row</p>
                        <p>Delete row</p>
                    </div> -->
                    <!-- <div class="control__form__add">
                        
                        <table>
                            <tr>
                                <th class="table-width-100">ថ្នាក់ទី</th>
                                <th class="table-width-200">មុខវិជ្ជាបង្រៀន</th>
                                <th class="table-width-50">ថ្ងៃបង្រៀន</th>
                                <th class="table-width-50">ម៉ោងបង្រៀន</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="ថ្នាក់ទី" name="class">
                                </td>
                                <td>
                                    <input type="text" placeholder="មុខវិជ្ជាបង្រៀន" name="subject">
                                </td>
                                <td>
                                    <input type="date" name="teaching_date">
                                </td>
                                <td>
                                    <input type="time" name="teaching_time">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="ថ្នាក់ទី">
                                </td>
                                <td>
                                    <input type="text" placeholder="មុខវិជ្ជាបង្រៀន">
                                </td>
                                <td>
                                    <input type="date">
                                </td>
                                <td>
                                    <input type="time">
                                </td>
                            </tr>
                        </table>
                    </div> -->

                    <div class="control__form__add">
                        <p>ប្រវត្តិការងារបន្តបន្ទាប់</p>
                    </div>
                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ស្ថានភាព</label>
                            <input type="text" placeholder="ស្ថានភាព" name="status">
                        </div>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table2" id="countrow_table2" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table2">
                                <tr>
                                    <th class="table-width-200">ការងារបន្តបន្ទាប់</th>
                                    <th class="table-width-200">អង្គភាពបម្រើការងារបច្ចុប្បន្ន</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="follow_work1" placeholder="ការងារបន្តបន្ទាប់">
                                    </td>
                                    <td>
                                        <input type="text" name="current_unit1" placeholder="អង្គភាពបម្រើការងារបច្ចុប្បន្ន">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date1">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="follow_work2" placeholder="ការងារបន្តបន្ទាប់">
                                    </td>
                                    <td>
                                        <input type="text" name="current_unit2" placeholder="អង្គភាពបម្រើការងារបច្ចុប្បន្ន">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date2">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row2" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher2('add_row2', 'table2') , countRowInTable('countrow_table2', 'table2')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>

                    <div class="control__form__add">
                        <p>ការសរសើរ​ / ស្តីបន្ទោស</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table3" id="countrow_table3" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table3">
                                <tr>
                                    <th class="table-width-300">ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច</th>
                                    <th class="table-width-200">ផ្តល់ដោយ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type_praise_blame1" placeholder="ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច">
                                    </td>
                                    <td>
                                        <input type="text" name="provided1" placeholder="ផ្តល់ដោយ">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type_praise_blame2" placeholder="ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច">
                                    </td>
                                    <td>
                                        <input type="text" name="provided2" placeholder="ផ្តល់ដោយ">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row3" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher3('add_row3', 'table3') , countRowInTable('countrow_table3', 'table3')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>




                    <div class="control__form__add">
                        <p>កម្រិតវប្បធម៌</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table4" id="countrow_table4" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table4">
                                <tr>
                                    <th class="table-width-200">កម្រិតវប្បធម៌</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                    <th class="table-width-100">ប្រទេស</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវប្បធម៌" name="education1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major1">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រទេស" name="country1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវប្បធម៌" name="education2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major2">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រទេស" name="country2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row4" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher4('add_row4', 'table4') , countRowInTable('countrow_table4', 'table4')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <div class="control__form__add">
                        <p>វគ្គគរុកោសល្យ</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table5" id="countrow_table5" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table5">
                                <tr>
                                    <th class="table-width-200">កម្រិតវិជ្ជាជីវៈ</th>
                                    <th class="table-width-100">ឯកទេសទី១</th>
                                    <th class="table-width-100">ឯកទេសទី២</th>
                                    <th class="table-width-100">ប្រព័ន្ធបណ្តុះបណ្តាល</th>
                                    <th class="table-width-100">ថ្ងៃខែបានទទួល</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវិជ្ជាជីវៈ" name="profess_level1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី១" name="skill1_1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី២" name="skill2_1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រព័ន្ធបណ្តុះបណ្តាល" name="train_system1">
                                    </td>
                                    <td>
                                        <input type="date" name="receive_date_course1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវិជ្ជាជីវៈ" name="profess_level2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី១" name="skill1_2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី២" name="skill2_2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រព័ន្ធបណ្តុះបណ្តាល" name="train_system2">
                                    </td>
                                    <td>
                                        <input type="date" name="receive_date_course2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row5" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher5('add_row5', 'table5') , countRowInTable('countrow_table5', 'table5')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <div class="control__form__add">
                        <p>វគ្គខ្លីៗ</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table6" id="countrow_table6" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table6">
                                <tr>
                                    <th class="table-width-200">ផ្នែក</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                    <th class="table-width-200">រយៈពេល</th>
                                    <th class="table-width-200">រៀបចំដោយ</th>
                                    <th class="table-width-200">គាំទ្រដោយ</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ផ្នែក" name="section1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major1">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date_short1">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date_short1">
                                    </td>

                                    <td>
                                        <input type="text" placeholder="រយៈពេល" name="duration1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="រៀបចំដោយ" name="prepair_by1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="គាំទ្រដោយ" name="support_by1">
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ផ្នែក" name="section2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major2">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date_short2">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date_short2">
                                    </td>

                                    <td>
                                        <input type="text" placeholder="រយៈពេល" name="duration2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="រៀបចំដោយ" name="prepair_by2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="គាំទ្រដោយ" name="support_by2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row6" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher6('add_row6', 'table6') , countRowInTable('countrow_table6', 'table6')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <div class="control__form__add">
                        <p>ភាសាបរទេស</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table7" id="countrow_table7" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table7">
                                <tr>
                                    <th class="table-width-100">ភាសា</th>
                                    <th class="table-width-100">ការអាន</th>
                                    <th class="table-width-100">ការសរសេរ</th>
                                    <th class="table-width-100">ការសន្ទនា</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ភាសា" name="language1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការអាន" name="reading1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសរសេរ" name="writting1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសន្ទនា" name="talking1">
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ភាសា" name="language2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការអាន" name="reading2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសរសេរ" name="writting2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសន្ទនា" name="talking2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row7" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher7('add_row7', 'table7'), countRowInTable('countrow_table7', 'table7')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <div class="control__form__add">
                        <p>ស្ថានភាពគ្រួសារ</p>
                    </div>

                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ស្ថានភាពគ្រួសារ</label>
                            <input type="text" placeholder="ស្ថានភាពគ្រួសារ" name="family_status">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ត្រូវជា</label>
                                    <input type="text" placeholder="ត្រូវជា" name="must_be">
                                </div>
                                <div class="block__form">
                                    <label for="">មុខរបរសហព័ទ្ធ</label>
                                    <input type="text" placeholder="មុខរបរសហព័ទ្ធ" name="occupation">
                                </div>
                            </div>
                        </div>
                        <div class="part">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ឈ្មោះសហទ័ព្ធ</label>
                                    <input type="text" placeholder="ឈ្មោះសហទ័ព្ធ" name="name_confederate">
                                </div>
                                <div class="block__form">
                                    <label for="">អង្គភាពសហព័ទ្ធ</label>
                                    <input type="text" placeholder="អង្គភាពសហព័ទ្ធ" name="confederation">
                                </div>
                            </div>

                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ថ្ងៃខែឆ្នាំកំណើតសហព័ទ្ធ</label>
                                    <input type="date" name="date_birth_spouse">
                                </div>
                                <div class="block__form">
                                    <label for="">ប្រាក់ខែប្រពន្ធ</label>
                                    <input type="text" placeholder="ប្រាក់ខែប្រពន្ធ" name="wife_salary">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table8" id="countrow_table8" value="2">
                    </div>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table8">
                                <tr>
                                    <th class="table-width-200">ឈ្មោះកូន</th>
                                    <th class="table-width-50">ភេទ</th>
                                    <th class="table-width-100">ថ្ងៃខែឆ្នាំកំណើត</th>
                                    <th class="table-width-200">មុខរបរ</th>
                                    <!-- <th class="table-width-200">ប្រាក់កូន</th> -->
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះកូន" name="child_name1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ភេទ" name="gender1">
                                    </td>
                                    <td>
                                        <input type="date" name="birth_date1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="មុខរបរ" name="occupation1">
                                    </td>
                                    <!-- <td>
                                        <input type="text" placeholder="ប្រាក់កូន">
                                    </td> -->
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ឈ្មោះកូន" name="child_name2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ភេទ" name="gender2">
                                    </td>
                                    <td>
                                        <input type="date" name="birth_date2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="មុខរបរ" name="occupation2">
                                    </td>
                                    <!-- <td>
                                        <input type="text" placeholder="ប្រាក់កូន">
                                    </td> -->
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row8" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher8('add_row8', 'table8') , countRowInTable('countrow_table8', 'table8')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ទូរស័ព្ទផ្ទាល់ខ្លួន</label>
                            <input type="text" placeholder="ទូរស័ព្ទផ្ទាល់ខ្លួន" name="personal_phone">
                            <label for="">អ៊ីម៊ែល</label>
                            <input type="text" placeholder="អ៊ីម៊ែល" name="email">
                        </div>
                        <div class="part">
                            <label for="">អាសយដ្ឋានបច្ចុប្បន្ន</label>
                            <textarea name="current_address" id="" cols="30" rows="5" placeholder="អាសយដ្ឋានបច្ចុប្បន្ន"></textarea>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" name="generate_teacher"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save info</button>
                    </div>
                </form>
           </div>

           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>
        </div>
    <?php
    
    }else{     

#============================= UPDATE TEACHER INFO HERE ===========================#
        $id = $_GET['update-id'];
        $teacher = mysqli_query($conn, "SELECT * FROM teacher_info WHERE id='". $id . "'");
        if(mysqli_num_rows($teacher) > 0){
        $teacher_data = mysqli_fetch_assoc($teacher);
        
        $teacher_id = $teacher_data['teacher_id'];
        
    ?>
        <div id="main__content">
            
           <div class="top__content_title">
                <h5 class="super__title">Update teacher<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update teacher</p>
           </div>
           <div class="my-3">
                <a href="<?=SITEURL;?>teachers.php<?php
                        $url_get = 'update-id='.$_GET['update-id'];
                        if($_SERVER['QUERY_STRING'] != $url_get){
                            echo '?'.trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                        }else{
                            echo "";
                        }
                    ?>" class="btn btn-sm btn-secondary px-2"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
           </div>
           <div class="add__member">                    
                <form action="<?=SITEURL;?>teacher-action.php" method="post">
                    <input type="hidden" name="update_id" value="<?=$id;?>">
                    <input type="hidden" name="url" value="<?php
                        $url_get = 'update-id='.$_GET['update-id'];
                        if($_SERVER['QUERY_STRING'] != $url_get){
                            echo trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                        }else{
                            echo "";
                        }
                    ?>">

                    <!-- personal data form -->
                    <div class="control__form__add">
                        <p>ប្រវត្តិរូបគ្រូបង្រៀន</p>
                    </div>
                    <div class="control__form__add">
                        <div class="part">
                            <label for="teacher_nameKh" class="">នាមត្រកូល និងនាមខ្លួន</label>
                            <div class="flex__form">
                                <input type="text" name="fn_kh" id="teacher_nameKh" placeholder="នាមត្រកូល..." value="<?=$teacher_data['fn_khmer'];?>">
                                <input type="text" name="ln_kh" placeholder="នាមខ្លួន..." value="<?=$teacher_data['ln_khmer'];?>">
                            </div>
                            <label for="teacher_nameEn">ជាអក្សរឡាតាំង</label>
                            <div class="flex__form">
                                <input type="text" name="fn_en" id="teacher_nameEn" placeholder="First name..." value="<?=$teacher_data['fn_en'];?>">
                                <input type="text" name="ln_en" placeholder="Last name..." value="<?=$teacher_data['ln_en'];?>">
                            </div>

                            <label for="birth_date">ភេទ</label>
                            <select name="gender" id="">
                                <option selected disabled>សូមជ្រើសរើស</option>
                                <option value="male" <?php if($teacher_data['gender'] == 'male') echo "selected";?>>ប្រុស</option>
                                <option value="female" <?php if($teacher_data['gender'] == 'female') echo "selected";?>>ស្រី</option>
                            </select>

                            <label for="birth_date">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="date" name="teacher_birth_date" id="birth_date" value="<?=$teacher_data['birth_date'];?>">
                            
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ជនជាតិ</label>
                                    <input type="text" name="nationality" placeholder="ជនជាតិ..." value="<?=$teacher_data['nationality'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ពិការ</label>
                                    <input type="text" name="disability"  placeholder="ពិការ..." value="<?=$teacher_data['disability'];?>">
                                </div>
                            </div>
                            <label for="" class="">អត្តលេខមន្ត្រី</label>
                            <input type="text" id="" name="officer_id" placeholder="អត្តលេខមន្ត្រី..." value="<?=$teacher_data['officer_id'];?>">
                            <label for="" class="">លេខអត្តសញ្ញាណបណ្ណ</label>
                            <input type="text" id="" name="indentify_card_number" placeholder="លេខអត្តសញ្ញាណបណ្ណ..." value="<?=$teacher_data['indentify_card_number'];?>">
                            <label for="">ទីកន្លែងកំណើត</label>
                            <textarea name="place_birth" id="" cols="30" rows="4" placeholder="ភូមិ ឃុំ/សង្កាត់ ស្រុក/ខណ្ឌ ខេត្ត"><?=$teacher_data['place_birth'];?></textarea>

                        </div>
                        <div class="part">
                            
                            <label for="" class="">លេខគណនីបៀវត្ស</label>
                            <input type="text" id="" name="payroll_acc" placeholder="លេខគណនីបៀវត្ស..." value="<?=$teacher_data['payroll_acc'];?>">
                            <label for="" class="">លេខសមាជិកបសបខ</label>
                            <input type="text" id="" name="member_bcc_id" placeholder="លេខសមាជិកបសបខ..." value="<?=$teacher_data['member_bcc_id'];?>">


                            <label for="birth_date">ថ្ងៃខែឆ្នាំចូលបម្រើការងារ</label>
                            <input type="date" id="birth_date" name="date_of_employment" value="<?=$teacher_data['date_of_employment'];?>">
                            <label for="birth_date">ថ្ងៃខែឆ្នាំតែងតាំងស៊ុប</label>
                            <input type="date" id="birth_date" name="date_of_soup" value="<?=$teacher_data['date_of_soup'];?>">
                            
                            <label for="">អង្គភាពបម្រើការងារ</label>
                            <input type="text" placeholder="អង្គភាពបម្រើការងារ..." name="working_unit" value="<?=$teacher_data['working_unit'];?>">

                            <div class="flex__form address">
                                <div class="block__form">
                                    <label for="">ភូមិ</label>
                                    <input type="text" placeholder="ភូមិ..." name="working_unit_add[]" value="<?php
                                            $working_unit_add = explode(",",$teacher_data['working_unit_address']);
                                            echo $working_unit_add[0];
                                        ?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ឃុំ</label>
                                    <input type="text" placeholder="ឃុំ..." name="working_unit_add[]" value="<?php
                                            $working_unit_add = explode(",",$teacher_data['working_unit_address']);
                                            echo $working_unit_add[1];
                                        ?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ស្រុក</label>
                                    <input type="text" placeholder="ស្រុក..." name="working_unit_add[]" value="<?php
                                            $working_unit_add = explode(",",$teacher_data['working_unit_address']);
                                            echo $working_unit_add[2];
                                        ?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ខេត្ត</label>
                                    <input type="text" placeholder="ខេត្ត..." name="working_unit_add[]" value="<?php
                                            $working_unit_add = explode(",",$teacher_data['working_unit_address']);
                                            echo $working_unit_add[3];
                                        ?>">
                                </div>
                            </div>
                            <label for="">ការិយាល័យ</label>
                            <input type="text" placeholder="ការិយាល័យ..." name="office" value="<?=$teacher_data['office'];?>">
                            <label for="">មុខដំណែង</label>
                            <input type="text" placeholder="មុខដំណែង..." name="position" value="<?=$teacher_data['position'];?>">
                            <label for="">ប្រកាស</label>
                            <input type="text" placeholder="ប្រកាស..." name="anountment" value="<?=$teacher_data['anountment'];?>">
                        </div>
                    </div>


                    <!-- this is  -->

                    <div class="control__form__add">
                        <p>ឋានៈវិជ្ជាជីវៈគ្រូបង្រៀន</p>

                    <?php
                        $sql_number_table1  = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id='". $teacher_id ."'");
                        $number_table1 = mysqli_num_rows($sql_number_table1);
                        // echo $number_table1;
                    ?>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table1" id="countrow_table1" value="<?=$number_table1;?>">
                    </div>
                    <!-- <div class="control__form__add"> -->
                    
                    <!-- </div> -->
                    <?php
                        $professional_stat = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id='". $teacher_id . "'");
                        
                        if(mysqli_num_rows($professional_stat) > 0){
                            $i=1;
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table1">
                                <tr>
                                    <th class="table-width-200">ប្រភេទឋានៈវិជ្ជាជីវៈ</th>
                                    <th class="table-width-200">បរិយាយ</th>
                                    <th class="table-width-50">ប្រកាសលេខ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>
                                <?php
                                    for($i; $i <= mysqli_num_rows($professional_stat); $i++){
                                    $professional_stat_data = mysqli_fetch_assoc($professional_stat);
                                ?>  
                                        <tr>
                                            <td>
                                                <input type="text" name="type<?=$i;?>" placeholder="ប្រភេទឋានៈវិជ្ជាជីវៈ" value="<?=$professional_stat_data['type_pro_status'];?>">
                                            </td>
                                            <td>
                                                <textarea name="descript<?=$i;?>" id="" cols="30" rows="1"  placeholder="បរិយាយ"><?=$professional_stat_data['description'];?></textarea>
                                            </td><td>
                                                <input type="text" name="annount<?=$i;?>" placeholder="ប្រកាសលេខ" value="<?=$professional_stat_data['post_number'];?>">
                                            </td><td>
                                                <input type="date" name="date_get<?=$i;?>" value="<?=$professional_stat_data['date_get'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($professional_stat);
                                ?>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row1" min = "0" class="add__row__number" placeholder="Add row" value = "1">
                        <p onclick="addRowTeacher1('add_row1', 'table1'), countRowInTable('countrow_table1', 'table1')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                            
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table1">
                                <tr>
                                    <th class="table-width-200">ប្រភេទឋានៈវិជ្ជាជីវៈ</th>
                                    <th class="table-width-200">បរិយាយ</th>
                                    <th class="table-width-50">ប្រកាសលេខ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="text" name="type1" placeholder="ប្រភេទឋានៈវិជ្ជាជីវៈ">
                                    </td>
                                    <td>
                                        <textarea name="descript1" id="" cols="30" rows="1"  placeholder="បរិយាយ"></textarea>
                                    </td><td>
                                        <input type="text" name="annount1" placeholder="ប្រកាសលេខ">
                                    </td><td>
                                        <input type="date" name="date_get1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type2" placeholder="ប្រភេទឋានៈវិជ្ជាជីវៈ">
                                    </td>
                                    <td>
                                        <textarea name="descript2" id="" cols="30" rows="1" placeholder="បរិយាយ"></textarea>
                                    </td><td>
                                        <input type="text" name="annount2" placeholder="ប្រកាសលេខ">
                                    </td><td>
                                        <input type="date" name="date_get2">
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row1" min = "0" class="add__row__number" placeholder="Add row" value = "1">
                        <p onclick="addRowTeacher1('add_row1', 'table1'), countRowInTable('countrow_table1', 'table1')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>



                    
                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ឋាននន្តរស័ក្តិ និងថ្នាក់</label>
                            <input type="text" placeholder="ឋាននន្តរស័ក្តិ និងថ្នាក់" name="position_rank" value="<?=$teacher_data['rank'];?>">

                            <label for="">យោង</label>
                            <input type="text" placeholder="យោង" name="refer" value="<?=$teacher_data['refer'];?>">

                            <label for="">លេខរៀង</label>
                            <input type="text" placeholder="លេខរៀង" name="numbering" value="<?=$teacher_data['numbering'];?>">

                            <label for="">ថ្ងៃខែឡើងការប្រាក់ចុងក្រោយ</label>
                            <input type="date" name="date_last_interest" value="<?=$teacher_data['date_last_interest'];?>">

                            <label for="">ចុះថ្ងៃទី</label>
                            <input type="date" name="dated" value="<?=$teacher_data['dated'];?>">

                            <label for="">បង្រៀននៅឆ្នាំសិក្សា</label>
                            <input type="text" placeholder="បង្រៀននៅឆ្នាំសិក្សា" name="teaching_in_year" value="<?=$teacher_data['teaching_in_year'];?>">                          
                        </div>

                        <div class="part">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">បង្រៀនភាសាអង់គ្លេស</label>
                                    <input type="text" placeholder="បង្រៀនភាសាអង់គ្លេស" name="english_teaching" value="<?=$teacher_data['english_teaching'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ថ្នាក់គួបបីកម្រិត</label>
                                    <input type="text" placeholder="ថ្នាក់គួបបីកម្រិត" name="three_level_combine" value="<?=$teacher_data['three_level_combine'];?>">
                                </div>
                            </div>
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ប្រធានក្រុមបច្ចេកទេស</label>
                                    <input type="text" placeholder="ប្រធានក្រុមបច្ចេកទេស" name="technic_team_leader" value="<?=$teacher_data['technic_team_leader'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ជួយបង្រៀន</label>
                                    <input type="text" placeholder="ជួយបង្រៀន" name="help_teach" value="<?=$teacher_data['help_teach'];?>">
                                </div>
                            </div>

                            <div class="flex__form">
                            
                                <div class="block__form">
                                    <label for="">ពីរថ្នាក់ណីរពេល</label>
                                    <input type="text" placeholder="ពីរថ្នាក់ណីរពេល" name="two_class" value="<?=$teacher_data['two_class'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ទទួលបន្ទុកថ្នាក់</label>
                                    <input type="text" placeholder="ទទួលបន្ទុកថ្នាក់" name="class_charg" value="<?=$teacher_data['class_charge'];?>">
                                </div>
                            </div>

                            <div class="flex__form">
                                
                                <div class="block__form">
                                    <label for="">បង្រៀនឆ្លងសាលា</label>
                                    <input type="text" placeholder="បង្រៀនឆ្លងសាលា" name="cross_school" value="<?=$teacher_data['cross_school'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ម៉ោងលើស</label>
                                    <input type="text" placeholder="ម៉ោងលើស" name="overtime" value="<?=$teacher_data['overtime'];?>">
                                </div>
                            </div>

                            <div class="flex__form">
                                
                                <div class="block__form">
                                    <label for="">ថ្នាក់គួប</label>
                                    <input type="text" placeholder="ថ្នាក់គួប" name="coupling_class" value="<?=$teacher_data['coupling_class'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ពីរភាសា</label>
                                    <input type="text" placeholder="ពីរភាសា" name="two_language" value="<?=$teacher_data['two_language'];?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- teaching class  -->
                    <!-- <div id="control__add__row">
                        <p id="addRow">Add row</p>
                        <p>Delete row</p>
                    </div> -->
                    <!-- <div class="control__form__add">
                        
                        <table>
                            <tr>
                                <th class="table-width-100">ថ្នាក់ទី</th>
                                <th class="table-width-200">មុខវិជ្ជាបង្រៀន</th>
                                <th class="table-width-50">ថ្ងៃបង្រៀន</th>
                                <th class="table-width-50">ម៉ោងបង្រៀន</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="ថ្នាក់ទី" name="class">
                                </td>
                                <td>
                                    <input type="text" placeholder="មុខវិជ្ជាបង្រៀន" name="subject">
                                </td>
                                <td>
                                    <input type="date" name="teaching_date">
                                </td>
                                <td>
                                    <input type="time" name="teaching_time">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="ថ្នាក់ទី">
                                </td>
                                <td>
                                    <input type="text" placeholder="មុខវិជ្ជាបង្រៀន">
                                </td>
                                <td>
                                    <input type="date">
                                </td>
                                <td>
                                    <input type="time">
                                </td>
                            </tr>
                        </table>
                    </div> -->

                    <div class="control__form__add">
                        <p>ប្រវត្តិការងារបន្តបន្ទាប់</p>
                    </div>
                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ស្ថានភាព</label>
                            <input type="text" placeholder="ស្ថានភាព" name="status" value="<?=$teacher_data['status'];?>">
                        </div>
                    </div>
                    <?php
                        $sql_number_table2  = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id='". $teacher_id ."'");
                        $number_table2 = mysqli_num_rows($sql_number_table2);
                        // echo $number_table2;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table2" id="countrow_table2" value="<?=$number_table2;?>">
                    </div>
                    <?php
                        $follow_work = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($follow_work) > 0){
                    ?>

                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table2">
                                <tr>
                                    <th class="table-width-200">ការងារបន្តបន្ទាប់</th>
                                    <th class="table-width-200">អង្គភាពបម្រើការងារបច្ចុប្បន្ន</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                </tr>
                                <?php
                                    for($i=1; $i<=mysqli_num_rows($follow_work); $i++){
                                        $follow_work_data = mysqli_fetch_assoc($follow_work);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="follow_work<?=$i;?>" placeholder="ការងារបន្តបន្ទាប់" value="<?=$follow_work_data['follow_work'];?>">
                                            </td>
                                            <td>
                                                <input type="text" name="current_unit<?=$i;?>" placeholder="អង្គភាពបម្រើការងារបច្ចុប្បន្ន" value="<?=$follow_work_data['current_unit'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="start_date<?=$i;?>" value="<?=$follow_work_data['start_date'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="finish_date<?=$i;?>" value="<?=$follow_work_data['finish_date'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($follow_work);
                                ?>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row2" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher2('add_row2', 'table2') , countRowInTable('countrow_table2', 'table2')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>

                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table2">
                                <tr>
                                    <th class="table-width-200">ការងារបន្តបន្ទាប់</th>
                                    <th class="table-width-200">អង្គភាពបម្រើការងារបច្ចុប្បន្ន</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="follow_work1" placeholder="ការងារបន្តបន្ទាប់">
                                    </td>
                                    <td>
                                        <input type="text" name="current_unit1" placeholder="អង្គភាពបម្រើការងារបច្ចុប្បន្ន">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date1">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="follow_work2" placeholder="ការងារបន្តបន្ទាប់">
                                    </td>
                                    <td>
                                        <input type="text" name="current_unit2" placeholder="អង្គភាពបម្រើការងារបច្ចុប្បន្ន">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date2">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row2" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher2('add_row2', 'table2') , countRowInTable('countrow_table2', 'table2')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>
                    



                    <div class="control__form__add">
                        <p>ការសរសើរ​ / ស្តីបន្ទោស</p>
                    </div>
                    <?php
                        $sql_number_table3  = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id='". $teacher_id ."'");
                        $number_table3 = mysqli_num_rows($sql_number_table3);
                        // echo $number_table3;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table3" id="countrow_table3" value="<?=$number_table3;?>">
                    </div>

                    <?php
                        $praise_blame = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($praise_blame) > 0){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table3">
                                <tr>
                                    <th class="table-width-300">ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច</th>
                                    <th class="table-width-200">ផ្តល់ដោយ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>
                                <?php
                                    for($i=1; $i <= mysqli_num_rows($praise_blame); $i++){
                                        $praise_blame_data = mysqli_fetch_assoc($praise_blame);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="type_praise_blame<?=$i;?>" placeholder="ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច" value="<?=$praise_blame_data['type_praise_blame'];?>">
                                            </td>
                                            <td>
                                                <input type="text" name="provided<?=$i;?>" placeholder="ផ្តល់ដោយ" value="<?=$praise_blame_data['provided'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="recieve_date<?=$i;?>" value="<?=$praise_blame_data['recieve_date'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($praise_blame);
                                ?>             
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row3" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher3('add_row3', 'table3') , countRowInTable('countrow_table3', 'table3')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table3">
                                <tr>
                                    <th class="table-width-300">ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច</th>
                                    <th class="table-width-200">ផ្តល់ដោយ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type_praise_blame1" placeholder="ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច">
                                    </td>
                                    <td>
                                        <input type="text" name="provided1" placeholder="ផ្តល់ដោយ">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="type_praise_blame2" placeholder="ប្រភេទនៃការសរសើរ/ការស្តីបន្ទោស/ទទួលអធិការកិច្ច">
                                    </td>
                                    <td>
                                        <input type="text" name="provided2" placeholder="ផ្តល់ដោយ">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row3" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher3('add_row3', 'table3') , countRowInTable('countrow_table3', 'table3')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>


                    <div class="control__form__add">
                        <p>កម្រិតវប្បធម៌</p>
                    </div>

                    <?php
                        $sql_number_table4  = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id='". $teacher_id ."'");
                        $number_table4 = mysqli_num_rows($sql_number_table4);
                        // echo $number_table4;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table4" id="countrow_table4" value="<?=$number_table4;?>">
                    </div>

                    <?php
                        $education = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($education) > 0){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table4">
                                <tr>
                                    <th class="table-width-200">កម្រិតវប្បធម៌</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                    <th class="table-width-100">ប្រទេស</th>
                                    
                                </tr>
                                <?php
                                    for($i=1; $i<=mysqli_num_rows($education); $i++){
                                        $education_data = mysqli_fetch_assoc($education);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="កម្រិតវប្បធម៌" name="education<?=$i;?>" value="<?=$education_data['education'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ឈ្មោះជំនាញ" name="major<?=$i;?>" value="<?=$education_data['major'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="recieve_date<?=$i;?>" value="<?=$education_data['recieve_date'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ប្រទេស" name="country<?=$i;?>" value="<?=$education_data['country'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($education);
                                ?>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row4" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher4('add_row4', 'table4') , countRowInTable('countrow_table4', 'table4')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table4">
                                <tr>
                                    <th class="table-width-200">កម្រិតវប្បធម៌</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">កាលបរិច្ឆេទទទួល</th>
                                    <th class="table-width-100">ប្រទេស</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវប្បធម៌" name="education1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major1">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រទេស" name="country1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវប្បធម៌" name="education2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major2">
                                    </td>
                                    <td>
                                        <input type="date" name="recieve_date2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រទេស" name="country2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row4" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher4('add_row4', 'table4') , countRowInTable('countrow_table4', 'table4')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>



                    <div class="control__form__add">
                        <p>វគ្គគរុកោសល្យ</p>
                    </div>
                    <?php
                        $sql_number_table5  = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id='". $teacher_id ."'");
                        $number_table5 = mysqli_num_rows($sql_number_table5);
                        // echo $number_table5;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table5" id="countrow_table5" value="<?=$number_table5;?>">
                    </div>

                    <?php
                        $pedagogy_course = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($pedagogy_course) > 0){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table5">
                                <tr>
                                    <th class="table-width-200">កម្រិតវិជ្ជាជីវៈ</th>
                                    <th class="table-width-100">ឯកទេសទី១</th>
                                    <th class="table-width-100">ឯកទេសទី២</th>
                                    <th class="table-width-100">ប្រព័ន្ធបណ្តុះបណ្តាល</th>
                                    <th class="table-width-100">ថ្ងៃខែបានទទួល</th>
                                    
                                </tr>
                                <?php
                                    for($i=1; $i<= mysqli_num_rows($pedagogy_course); $i++){
                                        $pedagogy_course_data = mysqli_fetch_assoc($pedagogy_course);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="កម្រិតវិជ្ជាជីវៈ" name="profess_level<?=$i;?>" value="<?=$pedagogy_course_data['profess_level'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ឯកទេសទី១" name="skill1_<?=$i;?>" value="<?=$pedagogy_course_data['skill1'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ឯកទេសទី២" name="skill2_<?=$i;?>" value="<?=$pedagogy_course_data['skill2'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ប្រព័ន្ធបណ្តុះបណ្តាល" name="train_system<?=$i;?>" value="<?=$pedagogy_course_data['train_system'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="receive_date_course<?=$i;?>" value="<?=$pedagogy_course_data['receive_date'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($pedagogy_course);
                                ?>                           
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row5" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher5('add_row5', 'table5') , countRowInTable('countrow_table5', 'table5')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table5">
                                <tr>
                                    <th class="table-width-200">កម្រិតវិជ្ជាជីវៈ</th>
                                    <th class="table-width-100">ឯកទេសទី១</th>
                                    <th class="table-width-100">ឯកទេសទី២</th>
                                    <th class="table-width-100">ប្រព័ន្ធបណ្តុះបណ្តាល</th>
                                    <th class="table-width-100">ថ្ងៃខែបានទទួល</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវិជ្ជាជីវៈ" name="profess_level1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី១" name="skill1_1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី២" name="skill2_1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រព័ន្ធបណ្តុះបណ្តាល" name="train_system1">
                                    </td>
                                    <td>
                                        <input type="date" name="receive_date_course1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="កម្រិតវិជ្ជាជីវៈ" name="profess_level2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី១" name="skill1_2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឯកទេសទី២" name="skill2_2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ប្រព័ន្ធបណ្តុះបណ្តាល" name="train_system2">
                                    </td>
                                    <td>
                                        <input type="date" name="receive_date_course2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row5" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher5('add_row5', 'table5') , countRowInTable('countrow_table5', 'table5')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>
                    




                    <?php
                        $sql_number_table6  = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id='". $teacher_id ."'");
                        $number_table6 = mysqli_num_rows($sql_number_table6);
                        // echo $number_table7;
                    ?>
                    <div class="control__form__add">
                        <p>វគ្គខ្លីៗ</p>
                    </div>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table6" id="countrow_table6" value="<?=$number_table6;?>">
                    </div>
                    <?php
                        $short_course = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($short_course) > 0 ){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table6">
                                <tr>
                                    <th class="table-width-200">ផ្នែក</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                    <th class="table-width-200">រយៈពេល</th>
                                    <th class="table-width-200">រៀបចំដោយ</th>
                                    <th class="table-width-200">គាំទ្រដោយ</th>
                                    
                                </tr>

                                <?php
                                    for($i=1; $i<= mysqli_num_rows($short_course); $i++){
                                        $short_course_data = mysqli_fetch_assoc($short_course);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="ផ្នែក" name="section<?=$i;?>" value="<?=$short_course_data['section'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ឈ្មោះជំនាញ" name="major<?=$i;?>" value="<?=$short_course_data['major'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="start_date_short<?=$i;?>" value="<?=$short_course_data['start_date'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="finish_date_short<?=$i;?>" value="<?=$short_course_data['finish_date'];?>">
                                            </td>

                                            <td>
                                                <input type="text" placeholder="រយៈពេល" name="duration<?=$i;?>" value="<?=$short_course_data['duration'];?>"> 
                                            </td>
                                            <td>
                                                <input type="text" placeholder="រៀបចំដោយ" name="prepair_by<?=$i;?>" value="<?=$short_course_data['prepair_by'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="គាំទ្រដោយ" name="support_by<?=$i;?>" value="<?=$short_course_data['support_by'];?>">
                                            </td>
                                        </tr>              
                                <?php
                                    }
                                    mysqli_free_result($short_course);
                                ?>                                       
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row6" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher6('add_row6', 'table6') , countRowInTable('countrow_table6', 'table6')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table6">
                                <tr>
                                    <th class="table-width-200">ផ្នែក</th>
                                    <th class="table-width-200">ឈ្មោះជំនាញ</th>
                                    <th class="table-width-100">ថ្ងៃចាប់ផ្តើម</th>
                                    <th class="table-width-100">ថ្ងៃបញ្ចប់</th>
                                    <th class="table-width-200">រយៈពេល</th>
                                    <th class="table-width-200">រៀបចំដោយ</th>
                                    <th class="table-width-200">គាំទ្រដោយ</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ផ្នែក" name="section1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major1">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date_short1">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date_short1">
                                    </td>

                                    <td>
                                        <input type="text" placeholder="រយៈពេល" name="duration1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="រៀបចំដោយ" name="prepair_by1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="គាំទ្រដោយ" name="support_by1">
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ផ្នែក" name="section2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះជំនាញ" name="major2">
                                    </td>
                                    <td>
                                        <input type="date" name="start_date_short2">
                                    </td>
                                    <td>
                                        <input type="date" name="finish_date_short2">
                                    </td>

                                    <td>
                                        <input type="text" placeholder="រយៈពេល" name="duration2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="រៀបចំដោយ" name="prepair_by2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="គាំទ្រដោយ" name="support_by2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row6" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher6('add_row6', 'table6') , countRowInTable('countrow_table6', 'table6')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>




                    <div class="control__form__add">
                        <p>ភាសាបរទេស</p>
                    </div>

                    <?php
                        $sql_number_table7  = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id='". $teacher_id ."'");
                        $number_table7 = mysqli_num_rows($sql_number_table7);
                        // echo $number_table7;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table7" id="countrow_table7" value="<?=$number_table7;?>">
                    </div>
                    <?php
                        $foreign_language = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id='". $teacher_id . "'");
                        if(mysqli_num_rows($foreign_language) > 0){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table7">
                                <tr>
                                    <th class="table-width-100">ភាសា</th>
                                    <th class="table-width-100">ការអាន</th>
                                    <th class="table-width-100">ការសរសេរ</th>
                                    <th class="table-width-100">ការសន្ទនា</th>
                                    
                                </tr>
                                <?php
                                    for($i=1; $i<=mysqli_num_rows($foreign_language); $i++){
                                        $foreign_language_data = mysqli_fetch_assoc($foreign_language);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="ភាសា" name="language<?=$i;?>" value="<?=$foreign_language_data['language'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ការអាន" name="reading<?=$i;?>" value="<?=$foreign_language_data['reading'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ការសរសេរ" name="writting<?=$i;?>" value="<?=$foreign_language_data['writting'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ការសន្ទនា" name="talking<?=$i;?>" value="<?=$foreign_language_data['talking'];?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                    mysqli_free_result($foreign_language);
                                ?>      
                            </table>
                        </div>
                    </div>

                    
                    <div id="control__add__row">
                        <input type="number" id="add_row7" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher7('add_row7', 'table7'), countRowInTable('countrow_table7', 'table7')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table7">
                                <tr>
                                    <th class="table-width-100">ភាសា</th>
                                    <th class="table-width-100">ការអាន</th>
                                    <th class="table-width-100">ការសរសេរ</th>
                                    <th class="table-width-100">ការសន្ទនា</th>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ភាសា" name="language1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការអាន" name="reading1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសរសេរ" name="writting1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសន្ទនា" name="talking1">
                                    </td>
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ភាសា" name="language2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការអាន" name="reading2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសរសេរ" name="writting2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ការសន្ទនា" name="talking2">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row7" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher7('add_row7', 'table7'), countRowInTable('countrow_table7', 'table7')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>


                    <div class="control__form__add">
                        <p>ស្ថានភាពគ្រួសារ</p>
                    </div>

                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ស្ថានភាពគ្រួសារ</label>
                            <input type="text" placeholder="ស្ថានភាពគ្រួសារ" name="family_status" value="<?=$teacher_data['family_status'];?>">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ត្រូវជា</label>
                                    <input type="text" placeholder="ត្រូវជា" name="must_be" value="<?=$teacher_data['must_be'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">មុខរបរសហព័ទ្ធ</label>
                                    <input type="text" placeholder="មុខរបរសហព័ទ្ធ" name="occupation" value="<?=$teacher_data['occupation'];?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="part">
                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ឈ្មោះសហទ័ព្ធ</label>
                                    <input type="text" placeholder="ឈ្មោះសហទ័ព្ធ" name="name_confederate" value="<?=$teacher_data['name_confederate'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">អង្គភាពសហព័ទ្ធ</label>
                                    <input type="text" placeholder="អង្គភាពសហព័ទ្ធ" name="confederation" value="<?=$teacher_data['confederation'];?>">
                                </div>
                            </div>

                            <div class="flex__form">
                                <div class="block__form">
                                    <label for="">ថ្ងៃខែឆ្នាំកំណើតសហព័ទ្ធ</label>
                                    <input type="date" name="date_birth_spouse" value="<?=$teacher_data['date_birth_spouse'];?>">
                                </div>
                                <div class="block__form">
                                    <label for="">ប្រាក់ខែប្រពន្ធ</label>
                                    <input type="text" placeholder="ប្រាក់ខែប្រពន្ធ" name="wife_salary" value="<?=$teacher_data['wife_salary'];?>">
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <?php
                        $sql_number_table8  = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id='". $teacher_id ."'");
                        $number_table8 = mysqli_num_rows($sql_number_table8);
                        // echo $number_table8;
                    ?>
                    <div class="control__form__add">
                        <input type="hidden" placeholder="Count row in table" name="countrow_table8" id="countrow_table8" value="<?=$number_table8;?>">
                    </div>
                    <?php
                        $family = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id='". $teacher_id ."'");
                        if(mysqli_num_rows($family) > 0){
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table8">
                                <tr>
                                    <th class="table-width-200">ឈ្មោះកូន</th>
                                    <th class="table-width-50">ភេទ</th>
                                    <th class="table-width-100">ថ្ងៃខែឆ្នាំកំណើត</th>
                                    <th class="table-width-200">មុខរបរ</th>
                                    <!-- <th class="table-width-200">ប្រាក់កូន</th> -->
                                </tr>
                                <?php
                                for($i=1; $i <= mysqli_num_rows($family); $i++){
                                    $family_data = mysqli_fetch_assoc($family);
                                ?>
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="ឈ្មោះកូន" name="child_name<?=$i;?>" value="<?=$family_data['child_name'];?>">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="ភេទ" name="gender<?=$i;?>" value="<?=$family_data['gender'];?>">
                                            </td>
                                            <td>
                                                <input type="date" name="birth_date<?=$i;?>" value="<?=$family_data['birth_date'];?>">
                                            </td>
                                            <td> 
                                                <input type="text" placeholder="មុខរបរ" name="occupation<?=$i;?>" value="<?=$family_data['occupation'];?>">
                                            </td>
                                            <!-- <td>
                                                <input type="text" placeholder="ប្រាក់កូន">
                                            </td> -->
                                        </tr>
                                <?php
                                }
                                mysqli_free_result($family);
                                ?>    
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row8" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher8('add_row8', 'table8') , countRowInTable('countrow_table8', 'table8')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="control__form__add">
                        <div class="table_manage">
                            <table id="table8">
                                <tr>
                                    <th class="table-width-200">ឈ្មោះកូន</th>
                                    <th class="table-width-50">ភេទ</th>
                                    <th class="table-width-100">ថ្ងៃខែឆ្នាំកំណើត</th>
                                    <th class="table-width-200">មុខរបរ</th>
                                    <!-- <th class="table-width-200">ប្រាក់កូន</th> -->
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="ឈ្មោះកូន" name="child_name1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ភេទ" name="gender1">
                                    </td>
                                    <td>
                                        <input type="date" name="birth_date1">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="មុខរបរ" name="occupation1">
                                    </td>
                                    <!-- <td>
                                        <input type="text" placeholder="ប្រាក់កូន">
                                    </td> -->
                                </tr>
                                <tr>
                                <td>
                                        <input type="text" placeholder="ឈ្មោះកូន" name="child_name2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="ភេទ" name="gender2">
                                    </td>
                                    <td>
                                        <input type="date" name="birth_date2">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="មុខរបរ" name="occupation2">
                                    </td>
                                    <!-- <td>
                                        <input type="text" placeholder="ប្រាក់កូន">
                                    </td> -->
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="control__add__row">
                        <input type="number" id="add_row8" min = "0" class="add__row__number" placeholder="Add row" value="1">
                        <p onclick="addRowTeacher8('add_row8', 'table8') , countRowInTable('countrow_table8', 'table8')">Add row</p>
                        <!-- <p>Delete row</p> -->
                    </div>
                    <?php
                        }
                    ?>


                    <div class="control__form__add">
                        <div class="part">
                            <label for="">ទូរស័ព្ទផ្ទាល់ខ្លួន</label>
                            <input type="text" placeholder="ទូរស័ព្ទផ្ទាល់ខ្លួន" name="personal_phone" value="<?=$teacher_data['personal_phone'];?>">
                            <label for="">អ៊ីម៊ែល</label>
                            <input type="text" placeholder="អ៊ីម៊ែល" name="email" value="<?=$teacher_data['email'];?>">
                        </div>
                        <div class="part">
                            <label for="">អាសយដ្ឋានបច្ចុប្បន្ន</label>
                            <textarea name="current_address" id="" cols="30" rows="5" placeholder="អាសយដ្ឋានបច្ចុប្បន្ន"><?=$teacher_data['current_address'];?></textarea>
                        </div>
                    </div>
                    <div class="button">
                        <?php
                            if($teacher_data['active_status'] == '1'){
                        ?>

                        
                        <a href="<?=SITEURL;?>disactive-user.php?disactive-user=<?=$teacher_data['id'];?><?php
                            $url_get = 'update-id='.$_GET['update-id'];
                            if($_SERVER['QUERY_STRING'] != $url_get){
                                echo '&'.trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                            }else{
                                echo "";
                            }
                        ?>" class="disactive-btn"><i class="fa fa-ban" aria-hidden="true"></i>Disable user</a>


                        <?php
                            }else{
                        ?>
                        <a href="<?=SITEURL;?>disactive-user.php?active-user=<?=$teacher_data['id'];?><?php
                            $url_get = 'update-id='.$_GET['update-id'];
                            if($_SERVER['QUERY_STRING'] != $url_get){
                                echo '&'.trim(str_replace('update-id='.$_GET['update-id'].'&', '', $_SERVER['QUERY_STRING']));
                            }else{
                                echo "";
                            }
                        ?>" class="active-btn"><i class="fa fa-refresh" aria-hidden="true"></i>Enable user</a>

                        <?php
                            }
                        ?>
                        <button type="submit" name="update_teacher" class="btn-update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update info</button>
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
                <h5 class="super__title">Update teacher<span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Update teacher</p>
           </div>
           <div class="add__member p-2">
                <p>Data not found. <a href="<?=SITEURL;?>teachers.php">Back</a></p>
           </div>
        </div>
    <?php
            }
        }
    ?>

    </section>



    <!-- pop up message when generate data success  -->
    <?php
        if(isset($_SESSION['GENERATE'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['GENERATE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>add-teacher.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['GENERATE']);
        if(isset($_SESSION['GENERATE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['GENERATE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>add-teacher.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>

    <?php
        }
        unset($_SESSION['GENERATE_ERROR']);

    ?>
    
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>

</body>
</html>