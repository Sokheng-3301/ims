<?php

// use function PHPSTORM_META\type;

    require_once('ims-db-connection.php');
        
    
    #======================= INSERT DATA IN TABLE TEACHER INFO =========================#
    if(isset($_POST['generate_teacher'])){
        // $insert1 = '';
        // $insert2 = '';
        // $insert3 = '';
        // $insert4 = '';
        // $insert5 = '';
        // $insert6 = '';
        // $insert7 = '';
        // $insert8 = '';

        // print_r($_POST);
        // exit;
        $url        =     trim($_POST['url']);
        $username   =     mysqli_real_escape_string($conn, $_POST['username']);
        $password   =     mysqli_real_escape_string($conn, $_POST['password']);
        $teacher_id =     mysqli_real_escape_string($conn, $_POST['teacher_id']);


        #TEACHER INFORMATION DECLAIR VARIABLE#

        $fn_kh = mysqli_real_escape_string($conn, $_POST['fn_kh']);
        $ln_kh = mysqli_real_escape_string($conn, $_POST['ln_kh']);
        
        $fn_en = mysqli_real_escape_string($conn, $_POST['fn_en']);
        $ln_en = mysqli_real_escape_string($conn, $_POST['ln_en']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);

        $teacher_birth_date = mysqli_real_escape_string($conn, $_POST['teacher_birth_date']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
        $disability = mysqli_real_escape_string($conn, $_POST['disability']);


        $officer_id = mysqli_real_escape_string($conn, $_POST['officer_id']);
        $indentify_card_number = mysqli_real_escape_string($conn, $_POST['indentify_card_number']);
        $place_birth = mysqli_real_escape_string($conn, $_POST['place_birth']);

        $payroll_acc = mysqli_real_escape_string($conn, $_POST['payroll_acc']);
        $member_bcc_id = mysqli_real_escape_string($conn, $_POST['member_bcc_id']);
        $date_of_employment = mysqli_real_escape_string($conn, $_POST['date_of_employment']);

        $date_of_soup = mysqli_real_escape_string($conn, $_POST['date_of_soup']);
        $working_unit = mysqli_real_escape_string($conn, $_POST['working_unit']);


        // array here 
        // $working_unit_add = mysqli_real_escape_string($conn, $_POST['working_unit_add']);
        $working_unit_add = implode(",", $_POST['working_unit_add']);

        $office = mysqli_real_escape_string($conn, $_POST['office']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $anountment = mysqli_real_escape_string($conn, $_POST['anountment']);








        $position_rank = mysqli_real_escape_string($conn, $_POST['position_rank']);
        $refer = mysqli_real_escape_string($conn, $_POST['refer']);
        $numbering = mysqli_real_escape_string($conn, $_POST['numbering']);


        $date_last_interest = mysqli_real_escape_string($conn, $_POST['date_last_interest']);
        $dated = mysqli_real_escape_string($conn, $_POST['dated']);
        $teaching_in_year = mysqli_real_escape_string($conn, $_POST['teaching_in_year']);


        $english_teaching = mysqli_real_escape_string($conn, $_POST['english_teaching']);
        $three_level_combine = mysqli_real_escape_string($conn, $_POST['three_level_combine']);
        $technic_team_leader = mysqli_real_escape_string($conn, $_POST['technic_team_leader']);



        $help_teach = mysqli_real_escape_string($conn, $_POST['help_teach']);
        $two_class = mysqli_real_escape_string($conn, $_POST['two_class']);
        $class_charg = mysqli_real_escape_string($conn, $_POST['class_charg']);


        $cross_school = mysqli_real_escape_string($conn, $_POST['cross_school']);
        $overtime = mysqli_real_escape_string($conn, $_POST['overtime']);
        $coupling_class = mysqli_real_escape_string($conn, $_POST['coupling_class']);
        $two_language = mysqli_real_escape_string($conn, $_POST['two_language']);


        $status = mysqli_real_escape_string($conn, $_POST['status']);



        $family_status = mysqli_real_escape_string($conn, $_POST['family_status']);
        $must_be = mysqli_real_escape_string($conn, $_POST['must_be']);
        $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
        $name_confederate = mysqli_real_escape_string($conn, $_POST['name_confederate']);

        $confederation = mysqli_real_escape_string($conn, $_POST['confederation']);
        $date_birth_spouse = mysqli_real_escape_string($conn, $_POST['date_birth_spouse']);
        $wife_salary = mysqli_real_escape_string($conn, $_POST['wife_salary']);



        $personal_phone = mysqli_real_escape_string($conn, $_POST['personal_phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $current_address = mysqli_real_escape_string($conn, $_POST['current_address']);





        // Done for ប្រកាសអញ្ញត្តនៃតារាង ឋានៈវិជ្ជាជីវៈគ្រូបង្រៀន
                $countrow_table1 = $_POST['countrow_table1'];

        // Done for ប្រកាសអញ្ញត្តនៃតារាង ប្រវត្តិការងារបន្តបន្ទាប់
                $countrow_table2 = $_POST['countrow_table2'];
                
        // Done for ប្រកាសអញ្ញត្តនៃតារាង ការសរសើរ​ / ស្តីបន្ទោស
                $countrow_table3 = $_POST['countrow_table3'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង កម្រិតវប្បធម៌
                $countrow_table4 = $_POST['countrow_table4'];
        
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង វគ្គគរុកោសល្យ
                $countrow_table5 = $_POST['countrow_table5'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង វគ្គខ្លីៗ
                $countrow_table6 = $_POST['countrow_table6'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង ភាសាបរទេស
                $countrow_table7 = $_POST['countrow_table7'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង កូនរបស់គ្រូបង្រៀន
                $countrow_table8 = $_POST['countrow_table8'];
       


        if($username == ''){
            $_SESSION['NO_USERNAME'] = 'Username are required.';
            if($password == '' && $teacher_id == ''){
                $_SESSION['NO_PASSWORD'] = 'Password are required.';
                $_SESSION['NO_ID'] = 'Indentify number are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }elseif($password != '' && $teacher_id == ''){
                // $_SESSION['NO_PASSWORD'] = 'Password are required.';
                $_SESSION['NO_ID'] = 'Indentify number are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }elseif($password == '' && $teacher_id != ''){
                $_SESSION['NO_PASSWORD'] = 'Password are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }else{
                header("Location:".SITEURL.$url);
                exit(0);
            }
        }elseif($username != ''){
            if($password == '' && $teacher_id == ''){
                $_SESSION['NO_PASSWORD'] = 'Password are required.';
                $_SESSION['NO_ID'] = 'Indentify number are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }elseif($password != '' && $teacher_id == ''){
                // $_SESSION['NO_PASSWORD'] = 'Password are required.';
                $_SESSION['NO_ID'] = 'Indentify number are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }elseif($password == '' && $teacher_id != ''){
                $_SESSION['NO_PASSWORD'] = 'Password are required.';
                header("Location:".SITEURL.$url);
                exit(0);
            }else{
                if(!isset($_POST['teacher_department'])){
                    $_SESSION['NO_DEPARTMENT'] = 'Department are required.';
                    header("Location:". SITEURL . $url);
                    exit(0);
                }else{

                    $teacher_department =     mysqli_real_escape_string($conn, $_POST['teacher_department']);
                        
                    $password   =  md5($password);
                    // $password   =     password_hash($password, PASSWORD_DEFAULT);
                    $check_teacher_id = "SELECT * FROM teacher_info WHERE teacher_id ='". $teacher_id . "'";
                    $check_run = mysqli_query($conn, $check_teacher_id);
                    if(mysqli_num_rows($check_run) > 0){
                        $_SESSION['GENERATE_ERROR'] = '<span class = "fw-bold">Note!</span> Indentify number has already used.';
                        header("Location:". SITEURL . $url);
                        exit(0);
                    }else{
                        $generate_teacher = "INSERT INTO teacher_info
                        (teacher_id,
                        -- username,
                        -- password,
                        department_id,

                        fn_khmer,
                        ln_khmer,
                        fn_en,
                        ln_en,

                        gender,
                        birth_date,
                        nationality,
                        disability,

                        officer_id,
                        indentify_card_number,
                        place_birth,
                        payroll_acc,
                        member_bcc_id,

                        date_of_employment,
                        date_of_soup,
                        working_unit,
                        working_unit_address,

                        office,
                        position,
                        anountment,
                        rank,

                        refer,
                        numbering,
                        date_last_interest,
                        dated,

                        teaching_in_year,
                        english_teaching,
                        three_level_combine,
                        technic_team_leader,

                        help_teach,
                        two_class,
                        class_charge,
                        cross_school,

                        overtime,
                        coupling_class,
                        two_language,
                        status,

                        family_status,
                        must_be,
                        occupation,
                        name_confederate,

                        confederation,
                        date_birth_spouse,
                        wife_salary,
                        personal_phone,

                        email,
                        current_address)
                        VALUES('$teacher_id',
                        -- '$username',
                        -- '$password',
                        '$teacher_department',

                        '$fn_kh',
                        '$ln_kh',
                        '$fn_en',
                        '$ln_en',

                        '$gender',
                        '$teacher_birth_date',
                        '$nationality',
                        '$disability',

                        '$officer_id',
                        '$indentify_card_number',
                        '$place_birth',
                        '$payroll_acc',
                        '$member_bcc_id',

                        '$date_of_employment',
                        '$date_of_soup',
                        '$working_unit',
                        '$working_unit_add',

                        '$office',
                        '$position',
                        '$anountment',
                        '$position_rank',

                        '$refer',
                        '$numbering',
                        '$date_last_interest',
                        '$dated',

                        '$teaching_in_year',
                        '$english_teaching',
                        '$three_level_combine',
                        '$technic_team_leader',

                        '$help_teach',
                        '$two_class',
                        '$class_charg',
                        '$cross_school',

                        '$overtime',
                        '$coupling_class',
                        '$two_language',
                        '$status',

                        '$family_status',
                        '$must_be',
                        '$occupation',
                        '$name_confederate',

                        '$confederation',
                        '$date_birth_spouse',
                        '$wife_salary',
                        '$personal_phone',
                        '$email',
                        '$current_address')";
                        
                        $generate_teacher_run = mysqli_query($conn, $generate_teacher);

                        if($generate_teacher_run == TRUE){  
                            // Add to table users 
                            $creator = $_SESSION['LOGIN_TYPE'];
                            $users = "INSERT INTO users (user_id, username, password, role, create_by)
                                    VALUES ('$teacher_id', '$username', '$password', 'teacher', '$creator')";
                            $users = mysqli_query($conn, $users);
                            






                            // ============== START FOR LOOP FOR ALL TABLE RELATED TO TEACHER INFORAMTION =====================//

                                //================ INSERT DATA IN TABLE1 teacher_professional_stat  ================//
                                for($increment1=1; $increment1 <= $countrow_table1; $increment1++){
                                    
                                    $type = mysqli_real_escape_string($conn, $_POST['type'. $increment1]);
                                    $descript = mysqli_real_escape_string($conn, $_POST['descript'. $increment1]);
                                    $annount = mysqli_real_escape_string($conn, $_POST['annount'. $increment1]);
                                    $date_get = mysqli_real_escape_string($conn, $_POST['date_get'. $increment1]);

                                    $insert1 = "INSERT INTO teacher_professional_stat
                                    (teacher_id,
                                    type_pro_status,
                                    description,
                                    post_number,
                                    date_get) VALUES(
                                    '$teacher_id',
                                    '$type',
                                    '$descript',
                                    '$annount',
                                    '$date_get')";
                                    $insert_run1 = mysqli_query($conn, $insert1); 
                                }

                                //================ INSERT DATA IN TABLE2 t_history_work  ================//
                                for($increment2=1; $increment2 <= $countrow_table2; $increment2++){
                                    $follow_work = mysqli_real_escape_string($conn, $_POST['follow_work'.$increment2]);
                                    $current_unit = mysqli_real_escape_string($conn, $_POST['current_unit'.$increment2]);
                                    $start_date = mysqli_real_escape_string($conn, $_POST['start_date'.$increment2]);
                                    $finish_date = mysqli_real_escape_string($conn, $_POST['finish_date'.$increment2]);
                
                                    $insert2 = "INSERT INTO t_history_work
                                                (teacher_id,
                                                follow_work,
                                                current_unit,
                                                start_date,
                                                finish_date) 
                                                VALUES
                                                ('$teacher_id',
                                                '$follow_work',
                                                '$current_unit',
                                                '$start_date',
                                                '$finish_date')";
                                    $insert_run2 = mysqli_query($conn, $insert2);
                                }


                                //================ INSERT DATA IN TABLE3 t_praise_blame  ================//
                                for($increment3=1; $increment3 <= $countrow_table3; $increment3++){
                                    $type_praise_blame =  mysqli_real_escape_string($conn, $_POST['type_praise_blame'. $increment3]);
                                    $provided =  mysqli_real_escape_string($conn, $_POST['provided'. $increment3]);
                                    $recieve_date =  mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment3]);

                                    $insert3 = "INSERT INTO t_praise_blame
                                    (teacher_id,
                                    type_praise_blame,
                                    provided,
                                    recieve_date)
                                    VALUES 
                                    ('$teacher_id',
                                    '$type_praise_blame',
                                    '$provided',
                                    '$recieve_date')";
                                    $insert_run3 = mysqli_query($conn, $insert3);
                                }
                                        
                                //================ INSERT DATA IN TABLE4 t_education_level  ================//
                                for($increment4=1; $increment4 <= $countrow_table4; $increment4++){
                                    $education = mysqli_real_escape_string($conn, $_POST['education'. $increment4]);
                                    $major = mysqli_real_escape_string($conn, $_POST['major'. $increment4]);
                                    $recieve_date = mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment4]);
                                    $country = mysqli_real_escape_string($conn, $_POST['country'. $increment4]);

                                    $insert4 = "INSERT INTO t_education_level
                                    (teacher_id,
                                    education,
                                    major,
                                    recieve_date,
                                    country) VALUES 
                                    ('$teacher_id',
                                    '$education',
                                    '$major',
                                    '$recieve_date',
                                    '$country')";

                                    $insert_run4 = mysqli_query($conn, $insert4);

                                }       

                                //================ INSERT DATA IN TABLE5 t_pedagogy_course  ================//
                                for($increment5=1; $increment5 <= $countrow_table5; $increment5++){
                                    $profess_level = mysqli_real_escape_string($conn, $_POST['profess_level'. $increment5]);
                                    $skill1_ = mysqli_real_escape_string($conn, $_POST['skill1_'. $increment5]);
                                    $skill2_ = mysqli_real_escape_string($conn, $_POST['skill2_'. $increment5]);
                                    $train_system = mysqli_real_escape_string($conn, $_POST['train_system'. $increment5]);
                                    $receive_date_course = mysqli_real_escape_string($conn, $_POST['receive_date_course'. $increment5]);

                                    $insert5 = "INSERT INTO t_pedagogy_course
                                    (teacher_id,
                                    profess_level,
                                    skill1,
                                    skill2,
                                    train_system,
                                    receive_date)
                                    VALUES
                                    ('$teacher_id',
                                    '$profess_level',
                                    '$skill1_',
                                    '$skill2_',
                                    '$train_system',
                                    '$receive_date_course')";

                                    $insert_run5 = mysqli_query($conn, $insert5);

                                }

                                    //================ INSERT DATA IN TABLE6 t_short_course  ================//
                                                        
                                    for($increment6=1; $increment6 <= $countrow_table6; $increment6++){
                                        $section = mysqli_real_escape_string($conn, $_POST['section'. $increment6]);
                                        $major = mysqli_real_escape_string($conn, $_POST['major'. $increment6]);
                                        $start_date_short = mysqli_real_escape_string($conn, $_POST['start_date_short'. $increment6]);
                                        $finish_date_short = mysqli_real_escape_string($conn, $_POST['finish_date_short'. $increment6]);
                                        $duration = mysqli_real_escape_string($conn, $_POST['duration'. $increment6]);
                                        $prepair_by = mysqli_real_escape_string($conn, $_POST['prepair_by'. $increment6]);
                                        $support_by = mysqli_real_escape_string($conn, $_POST['support_by'. $increment6]);

                                        $insert6 = "INSERT INTO t_short_course
                                        (teacher_id,
                                        section,
                                        major,
                                        start_date,
                                        finish_date,
                                        duration,
                                        prepair_by,
                                        support_by) 
                                        VALUES
                                        ('$teacher_id',
                                        '$section',
                                        '$major',
                                        '$start_date_short',
                                        '$finish_date_short',
                                        '$duration',
                                        '$prepair_by',
                                        '$support_by')";

                                        $insert_run6 = mysqli_query($conn, $insert6);
                                    }


                                    //================ INSERT DATA IN TABLE7 t_foreign_language  ================//
                                    for($increment7=1; $increment7 <= $countrow_table7; $increment7++){
                                        $language = mysqli_real_escape_string($conn, $_POST['language'. $increment7]);
                                        $reading = mysqli_real_escape_string($conn, $_POST['reading'. $increment7]);
                                        $writting = mysqli_real_escape_string($conn, $_POST['writting'. $increment7]);
                                        $talking = mysqli_real_escape_string($conn, $_POST['talking'. $increment7]);

                                        $insert7 = "INSERT INTO t_foreign_language
                                                    (teacher_id,language,reading,writting, talking)
                                                    VALUES('$teacher_id', '$language', '$reading', '$writting', '$talking')";

                                        $insert_run7 = mysqli_query($conn, $insert7);
                                    }

                                    //================ INSERT DATA IN TABLE7 t_family  ================//
                                    for($increment8=1; $increment8 <= $countrow_table8; $increment8++){
                                        $child_name = mysqli_real_escape_string($conn, $_POST['child_name'. $increment8]);
                                        $gender = mysqli_real_escape_string($conn, $_POST['gender'. $increment8]);
                                        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date'. $increment8]);
                                        $occupation = mysqli_real_escape_string($conn, $_POST['occupation'. $increment8]);

                                        $insert8 = "INSERT INTO t_family
                                        (teacher_id,child_name, gender,birth_date,occupation)
                                        VALUES('$teacher_id', '$child_name', '$gender', '$birth_date', '$occupation')";

                                        $insert_run8 = mysqli_query($conn, $insert8);
                                    }

                            // ============== END OF FOR LOOP FOR ALL TABLE RELATED TO TEACHER INFORAMTION =====================//
                            
                            $_SESSION['GENERATE'] = 'Generate information has completed.';
                            header("Location:". SITEURL . $url);
                            // header("Location:". SITEURL . "table2-action.php?method=".$_SERVER['REQUEST_METHOD']);
                            exit(0);
                        }else{
                            $_SESSION['GENERATE_ERROR'] = 'Generate information has not completed.';
                            header("Location:". SITEURL . $url);
                            exit(0);
                        }                         
                    }     
                }          
            }
        }
    }




    #======================= DELETE DATA IN TABLE TEACHER INFO =========================#
    elseif(isset($_GET['delete-id'])){
        $id = $_GET['delete-id'];
        $sql_teacher_id = mysqli_query($conn, "SELECT teacher_id, id FROM teacher_info WHERE id='". $id ."'");
        $teacher_id_result = mysqli_fetch_assoc($sql_teacher_id);
        $teacher_id_delete = $teacher_id_result['teacher_id'];

        $delete = mysqli_query($conn, "DELETE FROM teacher_info WHERE id='". $id."'");

        if($delete == TRUE){

                // table 1
                $delete1 = mysqli_query($conn, "DELETE FROM teacher_professional_stat WHERE teacher_id='".$teacher_id_delete ."'");
                

                // table2 
                $delete2 = mysqli_query($conn, "DELETE FROM t_history_work WHERE teacher_id='".$teacher_id_delete ."'");

                // table3
                $delete3 = mysqli_query($conn, "DELETE FROM t_praise_blame WHERE teacher_id='".$teacher_id_delete ."'");

                // table4
                $delete4 = mysqli_query($conn, "DELETE FROM t_education_level WHERE teacher_id='".$teacher_id_delete ."'");

                // table5
                $delete5 = mysqli_query($conn, "DELETE FROM t_pedagogy_course WHERE teacher_id='".$teacher_id_delete ."'");

                // table6
                $delete6 = mysqli_query($conn, "DELETE FROM t_short_course WHERE teacher_id='".$teacher_id_delete ."'");


                // table7
                $delete7 = mysqli_query($conn, "DELETE FROM t_foreign_language WHERE teacher_id='".$teacher_id_delete ."'");

                // table8
                $delete8 = mysqli_query($conn, "DELETE FROM t_family WHERE teacher_id='".$teacher_id_delete ."'");


            $_SESSION['MESSAGE_SQL'] = $delete_message_done;
            $url = $_SERVER['QUERY_STRING'];
            $new_url = trim(str_replace("delete-id=".$id."&", "", $url));

            header("Location:".SITEURL."teachers.php?".$new_url);
            exit(0);
        }else{
            $_SESSION['MESSAGE_SQL_ERROR'] = $delete_message_error;
            $url = $_SERVER['QUERY_STRING'];
            $new_url = trim(str_replace("delete-id=".$id."&", "", $url));

            header("Location:".SITEURL."teachers.php?".$new_url);
            exit(0);
        }
        
    }







    #======================= UPDATE DATA IN TABLE TEACHER INFO =========================#
    elseif(isset($_POST['update_teacher'])){

        $update_id = $_POST['update_id'];
        $url = $_POST['url'];

        $teacher_id_old = mysqli_query($conn, "SELECT * FROM teacher_info WHERE id='". $update_id ."'");
        $update_teacher_id_old_data = mysqli_fetch_assoc($teacher_id_old);
        $update_teacher_id = $update_teacher_id_old_data['teacher_id'];

        // echo $update_teacher_id;
        // exit;
        // echo "Update tacher.";
        $fn_kh = mysqli_real_escape_string($conn, $_POST['fn_kh']);
        $ln_kh = mysqli_real_escape_string($conn, $_POST['ln_kh']);
        
        $fn_en = mysqli_real_escape_string($conn, $_POST['fn_en']);
        $ln_en = mysqli_real_escape_string($conn, $_POST['ln_en']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);

        $teacher_birth_date = mysqli_real_escape_string($conn, $_POST['teacher_birth_date']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
        $disability = mysqli_real_escape_string($conn, $_POST['disability']);


        $officer_id = mysqli_real_escape_string($conn, $_POST['officer_id']);
        $indentify_card_number = mysqli_real_escape_string($conn, $_POST['indentify_card_number']);
        $place_birth = mysqli_real_escape_string($conn, $_POST['place_birth']);

        $payroll_acc = mysqli_real_escape_string($conn, $_POST['payroll_acc']);
        $member_bcc_id = mysqli_real_escape_string($conn, $_POST['member_bcc_id']);
        $date_of_employment = mysqli_real_escape_string($conn, $_POST['date_of_employment']);

        $date_of_soup = mysqli_real_escape_string($conn, $_POST['date_of_soup']);
        $working_unit = mysqli_real_escape_string($conn, $_POST['working_unit']);


        // array here 
        // $working_unit_add = mysqli_real_escape_string($conn, $_POST['working_unit_add']);
        $working_unit_add = implode(",", $_POST['working_unit_add']);

        $office = mysqli_real_escape_string($conn, $_POST['office']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $anountment = mysqli_real_escape_string($conn, $_POST['anountment']);








        $position_rank = mysqli_real_escape_string($conn, $_POST['position_rank']);
        $refer = mysqli_real_escape_string($conn, $_POST['refer']);
        $numbering = mysqli_real_escape_string($conn, $_POST['numbering']);


        $date_last_interest = mysqli_real_escape_string($conn, $_POST['date_last_interest']);
        $dated = mysqli_real_escape_string($conn, $_POST['dated']);
        $teaching_in_year = mysqli_real_escape_string($conn, $_POST['teaching_in_year']);


        $english_teaching = mysqli_real_escape_string($conn, $_POST['english_teaching']);
        $three_level_combine = mysqli_real_escape_string($conn, $_POST['three_level_combine']);
        $technic_team_leader = mysqli_real_escape_string($conn, $_POST['technic_team_leader']);



        $help_teach = mysqli_real_escape_string($conn, $_POST['help_teach']);
        $two_class = mysqli_real_escape_string($conn, $_POST['two_class']);
        $class_charg = mysqli_real_escape_string($conn, $_POST['class_charg']);


        $cross_school = mysqli_real_escape_string($conn, $_POST['cross_school']);
        $overtime = mysqli_real_escape_string($conn, $_POST['overtime']);
        $coupling_class = mysqli_real_escape_string($conn, $_POST['coupling_class']);
        $two_language = mysqli_real_escape_string($conn, $_POST['two_language']);


        $status = mysqli_real_escape_string($conn, $_POST['status']);



        $family_status = mysqli_real_escape_string($conn, $_POST['family_status']);
        $must_be = mysqli_real_escape_string($conn, $_POST['must_be']);
        $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
        $name_confederate = mysqli_real_escape_string($conn, $_POST['name_confederate']);

        $confederation = mysqli_real_escape_string($conn, $_POST['confederation']);
        $date_birth_spouse = mysqli_real_escape_string($conn, $_POST['date_birth_spouse']);
        $wife_salary = mysqli_real_escape_string($conn, $_POST['wife_salary']);



        $personal_phone = mysqli_real_escape_string($conn, $_POST['personal_phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $current_address = mysqli_real_escape_string($conn, $_POST['current_address']);


        // Done for ប្រកាសអញ្ញត្តនៃតារាង ឋានៈវិជ្ជាជីវៈគ្រូបង្រៀន
                $countrow_table1 = $_POST['countrow_table1'];

        // Done for ប្រកាសអញ្ញត្តនៃតារាង ប្រវត្តិការងារបន្តបន្ទាប់
                $countrow_table2 = $_POST['countrow_table2'];
                
        // Done for ប្រកាសអញ្ញត្តនៃតារាង ការសរសើរ​ / ស្តីបន្ទោស
                $countrow_table3 = $_POST['countrow_table3'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង កម្រិតវប្បធម៌
                $countrow_table4 = $_POST['countrow_table4'];
        
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង វគ្គគរុកោសល្យ
                $countrow_table5 = $_POST['countrow_table5'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង វគ្គខ្លីៗ
                $countrow_table6 = $_POST['countrow_table6'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង ភាសាបរទេស
                $countrow_table7 = $_POST['countrow_table7'];
        
        // Done for ប្រកាសអញ្ញត្តនៃតារាង កូនរបស់គ្រូបង្រៀន
                $countrow_table8 = $_POST['countrow_table8'];




        $update_teacher = "UPDATE teacher_info SET
        fn_khmer = '$fn_kh',
        ln_khmer = '$ln_kh',
        fn_en = '$fn_en',
        ln_en = '$ln_en',

        gender = '$gender',
        birth_date = '$teacher_birth_date',
        nationality = '$nationality',
        disability = '$disability',

        officer_id = '$officer_id',
        indentify_card_number = ' $indentify_card_number',
        place_birth = '$place_birth',
        payroll_acc = '$payroll_acc',
        member_bcc_id = '$member_bcc_id',

        date_of_employment = '$date_of_employment',
        date_of_soup = '$date_of_soup',
        working_unit = '$working_unit',
        working_unit_address = '$working_unit_add',

        office = '$office',
        position = '$position',
        anountment = '$anountment',
        rank = '$position_rank',

        refer = '$refer',
        numbering = '$numbering',
        date_last_interest = '$date_last_interest',
        dated = '$dated',

        teaching_in_year = '$teaching_in_year',
        english_teaching = '$english_teaching',
        three_level_combine = '$three_level_combine',
        technic_team_leader = '$technic_team_leader',

        help_teach = '$help_teach',
        two_class = '$two_class',
        class_charge = '$class_charg',
        cross_school = '$cross_school',

        overtime = '$overtime',
        coupling_class = '$coupling_class',
        two_language = '$two_language',
        status = '$status',

        family_status = '$family_status',
        must_be = '$must_be',
        occupation = '$occupation',
        name_confederate = '$name_confederate',

        confederation = '$confederation',
        date_birth_spouse = '$date_birth_spouse',
        wife_salary = '$wife_salary',
        personal_phone = '$personal_phone',

        email = '$email',
        current_address = '$current_address' WHERE id ='". $update_id ."'";

        $update_teacher_run = mysqli_query($conn, $update_teacher);
        if($update_teacher_run == TRUE){  

            // ============== START FOR LOOP FOR ALL TABLE RELATED TO TEACHER INFORAMTION =====================//

            //================ UPDATE DATA IN TABLE1 teacher_professional_stat  ================//

                $count_data_table1 = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table1 = mysqli_num_rows($count_data_table1);


                if($number_data_table1 == $countrow_table1){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    
                    for($increment1=1 ; $increment1 <= $count_id_to_update; $increment1++){
                        $type = mysqli_real_escape_string($conn, $_POST['type'. $increment1]);
                        $descript = mysqli_real_escape_string($conn, $_POST['descript'. $increment1]);
                        $annount = mysqli_real_escape_string($conn, $_POST['annount'. $increment1]);
                        $date_get = mysqli_real_escape_string($conn, $_POST['date_get'. $increment1]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table1 =  $data_id_to_update['id'];

                        $update1 = "UPDATE teacher_professional_stat SET
                                    type_pro_status = '$type',
                                    description = '$descript',
                                    post_number = '$annount',
                                    date_get = '$date_get' WHERE id = '". $id_to_update_table1 . "'";

                        $update_run1 = mysqli_query($conn, $update1); 
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM teacher_professional_stat WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment1=1 ; $increment1 <= $count_id_to_update; $increment1++){
                        $type = mysqli_real_escape_string($conn, $_POST['type'. $increment1]);
                        $descript = mysqli_real_escape_string($conn, $_POST['descript'. $increment1]);
                        $annount = mysqli_real_escape_string($conn, $_POST['annount'. $increment1]);
                        $date_get = mysqli_real_escape_string($conn, $_POST['date_get'. $increment1]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table1 =  $data_id_to_update['id'];

                        $update1 = "UPDATE teacher_professional_stat SET
                                    type_pro_status = '$type',
                                    description = '$descript',
                                    post_number = '$annount',
                                    date_get = '$date_get' WHERE id = '". $id_to_update_table1 . "'";

                        $update_run1 = mysqli_query($conn, $update1); 
                    }


                    // insert data in table1 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table1 - $number_data_table1;
                    for($increment1=1; $increment1 <= $number_for_loop; $increment1++){

                        $number_data_table1 = $number_data_table1+1;

                        $type = mysqli_real_escape_string($conn, $_POST['type'. $number_data_table1]);
                        $descript = mysqli_real_escape_string($conn, $_POST['descript'. $number_data_table1]);
                        $annount = mysqli_real_escape_string($conn, $_POST['annount'. $number_data_table1]);
                        $date_get = mysqli_real_escape_string($conn, $_POST['date_get'. $number_data_table1]);

                        $insert1 = "INSERT INTO teacher_professional_stat
                                (teacher_id,
                                type_pro_status,
                                description,
                                post_number,
                                date_get) VALUES(
                                '$update_teacher_id',
                                '$type',
                                '$descript',
                                '$annount',
                                '$date_get')";
                        $insert_run1 = mysqli_query($conn, $insert1);       
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table1);
            //================ UPDATE DATA IN TABLE1  END ================//
                       






            //================ UPDATE DATA IN TABLE2 t_history_work  ================//
                
                $count_data_table2 = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table2 = mysqli_num_rows($count_data_table2);


                if($number_data_table2 == $countrow_table2){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    
                    for($increment2=1 ; $increment2 <= $count_id_to_update; $increment2++){
                        $follow_work = mysqli_real_escape_string($conn, $_POST['follow_work'.$increment2]);
                        $current_unit = mysqli_real_escape_string($conn, $_POST['current_unit'.$increment2]);
                        $start_date = mysqli_real_escape_string($conn, $_POST['start_date'.$increment2]);
                        $finish_date = mysqli_real_escape_string($conn, $_POST['finish_date'.$increment2]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table2 =  $data_id_to_update['id'];

                        $update2 = "UPDATE t_history_work SET
        
                                follow_work = '$follow_work',
                                current_unit = '$current_unit',
                                start_date = '$start_date',
                                finish_date = '$finish_date' WHERE id='". $id_to_update_table2 ."'";  
                               
                        $update_run2 = mysqli_query($conn, $update2);
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_history_work WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment2=1 ; $increment2 <= $count_id_to_update; $increment2++){
                        $follow_work = mysqli_real_escape_string($conn, $_POST['follow_work'.$increment2]);
                        $current_unit = mysqli_real_escape_string($conn, $_POST['current_unit'.$increment2]);
                        $start_date = mysqli_real_escape_string($conn, $_POST['start_date'.$increment2]);
                        $finish_date = mysqli_real_escape_string($conn, $_POST['finish_date'.$increment2]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table2 =  $data_id_to_update['id'];

                        $update2 = "UPDATE t_history_work SET
        
                                follow_work = '$follow_work',
                                current_unit = '$current_unit',
                                start_date = '$start_date',
                                finish_date = '$finish_date' WHERE id='". $id_to_update_table2 ."'";  
                               
                        $update_run2 = mysqli_query($conn, $update2);
                    }


                    // insert data in table2 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table2 - $number_data_table2;
                    for($increment2=1; $increment2 <= $number_for_loop; $increment2++){

                        $number_data_table2 = $number_data_table2+1;

                        $follow_work = mysqli_real_escape_string($conn, $_POST['follow_work'.$number_data_table2]);
                        $current_unit = mysqli_real_escape_string($conn, $_POST['current_unit'.$number_data_table2]);
                        $start_date = mysqli_real_escape_string($conn, $_POST['start_date'.$number_data_table2]);
                        $finish_date = mysqli_real_escape_string($conn, $_POST['finish_date'.$number_data_table2]);

                        $insert2 = "INSERT INTO t_history_work
                                            (teacher_id,
                                            follow_work,
                                            current_unit,
                                            start_date,
                                            finish_date) 
                                            VALUES
                                            ('$update_teacher_id',
                                            '$follow_work',
                                            '$current_unit',
                                            '$start_date',
                                            '$finish_date')";
                        $insert_run2 = mysqli_query($conn, $insert2);          
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table2);

            //================ UPDATE DATA IN TABLE2  END ================//
                       





            
            //================ UPDATE DATA IN TABLE3 t_praise_blame  ================//
                
                $count_data_table3 = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table3 = mysqli_num_rows($count_data_table3);


                if($number_data_table3 == $countrow_table3){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    
                    for($increment3=1 ; $increment3 <= $count_id_to_update; $increment3++){
                        $type_praise_blame =  mysqli_real_escape_string($conn, $_POST['type_praise_blame'. $increment3]);
                        $provided =  mysqli_real_escape_string($conn, $_POST['provided'. $increment3]);
                        $recieve_date =  mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment3]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table3 =  $data_id_to_update['id'];

                        $update3 = "UPDATE t_praise_blame SET
                                    type_praise_blame = '$type_praise_blame',
                                    provided = '$provided',
                                    recieve_date = '$recieve_date' WHERE id ='". $id_to_update_table3 ."'";
                                
                        $update_run3 = mysqli_query($conn, $update3);
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_praise_blame WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment3=1 ; $increment3 <= $count_id_to_update; $increment3++){
                        $type_praise_blame =  mysqli_real_escape_string($conn, $_POST['type_praise_blame'. $increment3]);
                        $provided =  mysqli_real_escape_string($conn, $_POST['provided'. $increment3]);
                        $recieve_date =  mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment3]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table3 =  $data_id_to_update['id'];

                        $update3 = "UPDATE t_praise_blame SET
                                    type_praise_blame = '$type_praise_blame',
                                    provided = '$provided',
                                    recieve_date = '$recieve_date' WHERE id ='". $id_to_update_table3 ."'";
                                
                        $update_run3 = mysqli_query($conn, $update3);
                    }


                    // insert data in table3 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table3 - $number_data_table3;
                    for($increment3=1; $increment3 <= $number_for_loop; $increment3++){

                        $number_data_table3 = $number_data_table3+1;

                        $type_praise_blame =  mysqli_real_escape_string($conn, $_POST['type_praise_blame'. $number_data_table3]);
                        $provided =  mysqli_real_escape_string($conn, $_POST['provided'. $number_data_table3]);
                        $recieve_date =  mysqli_real_escape_string($conn, $_POST['recieve_date'. $number_data_table3]);


                        $insert3 = "INSERT INTO t_praise_blame
                                (teacher_id,
                                type_praise_blame,
                                provided,
                                recieve_date)
                                VALUES 
                                ('$update_teacher_id',
                                '$type_praise_blame',
                                '$provided',
                                '$recieve_date')";
                                $insert_run3 = mysqli_query($conn, $insert3);               
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table3);

            //================ UPDATE DATA IN TABLE3  END ================//
                       
                





            //================ UPDATE DATA IN TABLE4 t_education_level  ================//

                $count_data_table4 = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table4 = mysqli_num_rows($count_data_table4);


                if($number_data_table4 == $countrow_table4){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    
                    for($increment4=1 ; $increment4 <= $count_id_to_update; $increment4++){
                        $education = mysqli_real_escape_string($conn, $_POST['education'. $increment4]);
                        $major = mysqli_real_escape_string($conn, $_POST['major'. $increment4]);
                        $recieve_date = mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment4]);
                        $country = mysqli_real_escape_string($conn, $_POST['country'. $increment4]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table4 =  $data_id_to_update['id'];

                        $update4 = "UPDATE t_education_level SET
                                    education = '$education',
                                    major = '$major',
                                    recieve_date = '$recieve_date',
                                    country = '$country' WHERE id='". $id_to_update_table4 ."'";
                                    
                        $update_run4 = mysqli_query($conn, $update4);
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_education_level WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment4=1 ; $increment4 <= $count_id_to_update; $increment4++){
                        $education = mysqli_real_escape_string($conn, $_POST['education'. $increment4]);
                        $major = mysqli_real_escape_string($conn, $_POST['major'. $increment4]);
                        $recieve_date = mysqli_real_escape_string($conn, $_POST['recieve_date'. $increment4]);
                        $country = mysqli_real_escape_string($conn, $_POST['country'. $increment4]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table4 =  $data_id_to_update['id'];
                        
                        $update4 = "UPDATE t_education_level SET
                                    education = '$education',
                                    major = '$major',
                                    recieve_date = '$recieve_date',
                                    country = '$country' WHERE id='". $id_to_update_table4 ."'";
                                    
                        $update_run4 = mysqli_query($conn, $update4);
                    }


                    // insert data in table4 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table4 - $number_data_table4;
                    for($increment4=1; $increment4 <= $number_for_loop; $increment4++){

                        $number_data_table4 = $number_data_table4+1;

                        $education = mysqli_real_escape_string($conn, $_POST['education'. $number_data_table4]);
                        $major = mysqli_real_escape_string($conn, $_POST['major'. $number_data_table4]);
                        $recieve_date = mysqli_real_escape_string($conn, $_POST['recieve_date'. $number_data_table4]);
                        $country = mysqli_real_escape_string($conn, $_POST['country'. $number_data_table4]);


                        $insert4 = "INSERT INTO t_education_level
                                (teacher_id,
                                education,
                                major,
                                recieve_date,
                                country) VALUES 
                                ('$update_teacher_id',
                                '$education',
                                '$major',
                                '$recieve_date',
                                '$country')";

                        $insert_run4 = mysqli_query($conn, $insert4);                    
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table4);

            //================ UPDATE DATA IN TABLE4  END ================//







            //================ UPDATE DATA IN TABLE5 t_pedagogy_course  ================//

                $count_data_table5 = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table5 = mysqli_num_rows($count_data_table5);


                if($number_data_table5 == $countrow_table5){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    // echo $count_id_to_update;
                    // exit;
                    
                    for($increment5=1 ; $increment5 <= $count_id_to_update; $increment5++){
                        $profess_level = mysqli_real_escape_string($conn, $_POST['profess_level'. $increment5]);
                        $skill1_ = mysqli_real_escape_string($conn, $_POST['skill1_'. $increment5]);
                        $skill2_ = mysqli_real_escape_string($conn, $_POST['skill2_'. $increment5]);
                        $train_system = mysqli_real_escape_string($conn, $_POST['train_system'. $increment5]);
                        $receive_date_course = mysqli_real_escape_string($conn, $_POST['receive_date_course'. $increment5]);


                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table5 =  $data_id_to_update['id'];

                        $update5 = "UPDATE t_pedagogy_course SET
                                    profess_level = '$profess_level',
                                    skill1 = '$skill1_',
                                    skill2 = '$skill2_',
                                    train_system = '$train_system',
                                    receive_date = '$receive_date_course' WHERE id='". $id_to_update_table5 ."'";
                        
                        $update_run5 = mysqli_query($conn, $update5);
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_pedagogy_course WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment5=1 ; $increment5 <= $count_id_to_update; $increment5++){
                        $profess_level = mysqli_real_escape_string($conn, $_POST['profess_level'. $increment5]);
                        $skill1_ = mysqli_real_escape_string($conn, $_POST['skill1_'. $increment5]);
                        $skill2_ = mysqli_real_escape_string($conn, $_POST['skill2_'. $increment5]);
                        $train_system = mysqli_real_escape_string($conn, $_POST['train_system'. $increment5]);
                        $receive_date_course = mysqli_real_escape_string($conn, $_POST['receive_date_course'. $increment5]);

                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table5 =  $data_id_to_update['id'];
                        
                        $update5 = "UPDATE t_pedagogy_course SET
                                    profess_level = '$profess_level',
                                    skill1 = '$skill1_',
                                    skill2 = '$skill2_',
                                    train_system = '$train_system',
                                    receive_date = '$receive_date_course' WHERE id='". $id_to_update_table5 ."'";
                        
                        $update_run5 = mysqli_query($conn, $update5);
                    }


                    // insert data in table5 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table5 - $number_data_table5;
                    for($increment5=1; $increment5 <= $number_for_loop; $increment5++){

                        $number_data_table5 = $number_data_table5+1;

                        $profess_level = mysqli_real_escape_string($conn, $_POST['profess_level'. $number_data_table5]);
                        $skill1_ = mysqli_real_escape_string($conn, $_POST['skill1_'. $number_data_table5]);
                        $skill2_ = mysqli_real_escape_string($conn, $_POST['skill2_'. $number_data_table5]);
                        $train_system = mysqli_real_escape_string($conn, $_POST['train_system'. $number_data_table5]);
                        $receive_date_course = mysqli_real_escape_string($conn, $_POST['receive_date_course'. $number_data_table5]);

                        $insert5 = "INSERT INTO t_pedagogy_course
                                (teacher_id,
                                profess_level,
                                skill1,
                                skill2,
                                train_system,
                                receive_date)
                                VALUES
                                ('$update_teacher_id',
                                '$profess_level',
                                '$skill1_',
                                '$skill2_',
                                '$train_system',
                                '$receive_date_course')";

                        $insert_run5 = mysqli_query($conn, $insert5);                     
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table5);


            //================ UPDATE DATA IN TABLE5  END ================//








            //================ UPDATE DATA IN TABLE6 t_short_course  ================//

                   $count_data_table6 = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id ='". $update_teacher_id ."'");
                   $number_data_table6 = mysqli_num_rows($count_data_table6);
   
   
                   if($number_data_table6 == $countrow_table6){
                       $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id='". $update_teacher_id ."'");
                       $count_id_to_update = mysqli_num_rows($sql_id_to_update);
   
                       // echo $count_id_to_update;
                       // exit;
                       
                       for($increment6=1 ; $increment6 <= $count_id_to_update; $increment6++){
                            $section = mysqli_real_escape_string($conn, $_POST['section'. $increment6]);
                            $major = mysqli_real_escape_string($conn, $_POST['major'. $increment6]);
                            $start_date_short = mysqli_real_escape_string($conn, $_POST['start_date_short'. $increment6]);
                            $finish_date_short = mysqli_real_escape_string($conn, $_POST['finish_date_short'. $increment6]);
                            $duration = mysqli_real_escape_string($conn, $_POST['duration'. $increment6]);
                            $prepair_by = mysqli_real_escape_string($conn, $_POST['prepair_by'. $increment6]);
                            $support_by = mysqli_real_escape_string($conn, $_POST['support_by'. $increment6]);
   
                           $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                           $id_to_update_table6 =  $data_id_to_update['id'];
      
                            $update6 = "UPDATE t_short_course SET
                                        section = '$section',
                                        major = '$major',
                                        start_date = '$start_date_short',
                                        finish_date = '$finish_date_short',
                                        duration = '$duration',
                                        prepair_by = '$prepair_by',
                                        support_by = '$support_by' WHERE id ='". $id_to_update_table6 ."'";

                            $update_run6 = mysqli_query($conn, $update6);
   
                       }
                   }else{
   
                       $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_short_course WHERE teacher_id='". $update_teacher_id ."'");
                       $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                       
                       for($increment6=1 ; $increment6 <= $count_id_to_update; $increment6++){
                            $section = mysqli_real_escape_string($conn, $_POST['section'. $increment6]);
                            $major = mysqli_real_escape_string($conn, $_POST['major'. $increment6]);
                            $start_date_short = mysqli_real_escape_string($conn, $_POST['start_date_short'. $increment6]);
                            $finish_date_short = mysqli_real_escape_string($conn, $_POST['finish_date_short'. $increment6]);
                            $duration = mysqli_real_escape_string($conn, $_POST['duration'. $increment6]);
                            $prepair_by = mysqli_real_escape_string($conn, $_POST['prepair_by'. $increment6]);
                            $support_by = mysqli_real_escape_string($conn, $_POST['support_by'. $increment6]);
   

                           $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                           $id_to_update_table6 =  $data_id_to_update['id'];
                           

                           $update6 = "UPDATE t_short_course SET
                                        section = '$section',
                                        major = '$major',
                                        start_date = '$start_date_short',
                                        finish_date = '$finish_date_short',
                                        duration = '$duration',
                                        prepair_by = '$prepair_by',
                                        support_by = '$support_by' WHERE id ='". $id_to_update_table6 ."'";

                            $update_run6 = mysqli_query($conn, $update6);
                       }
   
   
                       // insert data in table6 if user add row in edit form using for loop.
                       $number_for_loop = $countrow_table6 - $number_data_table6;
                       for($increment6=1; $increment6 <= $number_for_loop; $increment6++){
   
                           $number_data_table6 = $number_data_table6+1;
   
                            $section = mysqli_real_escape_string($conn, $_POST['section'. $number_data_table6]);
                            $major = mysqli_real_escape_string($conn, $_POST['major'. $number_data_table6]);
                            $start_date_short = mysqli_real_escape_string($conn, $_POST['start_date_short'. $number_data_table6]);
                            $finish_date_short = mysqli_real_escape_string($conn, $_POST['finish_date_short'. $number_data_table6]);
                            $duration = mysqli_real_escape_string($conn, $_POST['duration'. $number_data_table6]);
                            $prepair_by = mysqli_real_escape_string($conn, $_POST['prepair_by'. $number_data_table6]);
                            $support_by = mysqli_real_escape_string($conn, $_POST['support_by'. $number_data_table6]);
   
   
                            // ====
                            $insert6 = "INSERT INTO t_short_course
                                        (teacher_id,
                                        section,
                                        major,
                                        start_date,
                                        finish_date,
                                        duration,
                                        prepair_by,
                                        support_by) 
                                        VALUES
                                        ('$update_teacher_id',
                                        '$section',
                                        '$major',
                                        '$start_date_short',
                                        '$finish_date_short',
                                        '$duration',
                                        '$prepair_by',
                                        '$support_by')";
                           $insert_run6 = mysqli_query($conn, $insert6);                     
                       }
                   }
   
                   mysqli_free_result($sql_id_to_update);
                   mysqli_free_result($count_data_table6);
   
                   // exit;   

            //================ UPDATE DATA IN TABLE6 END  ================//








            //================ UPDATE DATA IN TABLE7 t_foreign_language  ================//

                $count_data_table7 = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table7 = mysqli_num_rows($count_data_table7);


                if($number_data_table7 == $countrow_table7){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);

                    // echo $count_id_to_update;
                    // exit;
                    
                    for($increment7=1 ; $increment7 <= $count_id_to_update; $increment7++){
                        $language = mysqli_real_escape_string($conn, $_POST['language'. $increment7]);
                        $reading = mysqli_real_escape_string($conn, $_POST['reading'. $increment7]);
                        $writting = mysqli_real_escape_string($conn, $_POST['writting'. $increment7]);
                        $talking = mysqli_real_escape_string($conn, $_POST['talking'. $increment7]);

                        // echo $increment7;

                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table7 =  $data_id_to_update['id'];


                        $update7 = "UPDATE t_foreign_language SET
                                language = '$language',
                                reading = '$reading',
                                writting = '$writting' WHERE id = '". $id_to_update_table7 ."'";
                        $update_run7 = mysqli_query($conn, $update7);

                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_foreign_language WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment7=1 ; $increment7 <= $count_id_to_update; $increment7++){
                        $language = mysqli_real_escape_string($conn, $_POST['language'. $increment7]);
                        $reading = mysqli_real_escape_string($conn, $_POST['reading'. $increment7]);
                        $writting = mysqli_real_escape_string($conn, $_POST['writting'. $increment7]);
                        $talking = mysqli_real_escape_string($conn, $_POST['talking'. $increment7]);

                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table7 =  $data_id_to_update['id'];
                        
                        $update7 = "UPDATE t_foreign_language SET
                                language = '$language',
                                reading = '$reading',
                                writting = '$writting' WHERE id = '". $id_to_update_table7 ."'";
                        $update_run7 = mysqli_query($conn, $update7);
                    }


                    // insert data in table7 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table7 - $number_data_table7;
                    for($increment7=1; $increment7 <= $number_for_loop; $increment7++){

                        $number_data_table7 = $number_data_table7+1;

                        $language = mysqli_real_escape_string($conn, $_POST['language'. $number_data_table7]);
                        $reading = mysqli_real_escape_string($conn, $_POST['reading'. $number_data_table7]);
                        $writting = mysqli_real_escape_string($conn, $_POST['writting'. $number_data_table7]);
                        $talking = mysqli_real_escape_string($conn, $_POST['talking'. $number_data_table7]);


                        $insert7 = "INSERT INTO t_foreign_language
                                                (teacher_id,language,reading,writting, talking)
                                                VALUES('$update_teacher_id', '$language', '$reading', '$writting', '$talking')";
                        $insert_run7 = mysqli_query($conn, $insert7);                     
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table7);

                // exit;
            //================ UPDATE DATA IN TABLE7  END ================//












            //================ UPDATE DATA IN TABLE8 t_family  ================//
                $count_data_table8 = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id ='". $update_teacher_id ."'");
                $number_data_table8 = mysqli_num_rows($count_data_table8);


                if($number_data_table8 == $countrow_table8){
                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment8=1 ; $increment8 <= $count_id_to_update; $increment8++){
                        $child_name = mysqli_real_escape_string($conn, $_POST['child_name'. $increment8]);
                        $gender = mysqli_real_escape_string($conn, $_POST['gender'. $increment8]);
                        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date'. $increment8]);
                        $occupation = mysqli_real_escape_string($conn, $_POST['occupation'. $increment8]);

                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table8 =  $data_id_to_update['id'];
                        
                        $update8 = "UPDATE t_family SET
                                    child_name = '$child_name',
                                    gender = '$gender',
                                    birth_date = '$birth_date',
                                    occupation = '$occupation' WHERE id = '". $id_to_update_table8 ."'";
                        $update_run8 = mysqli_query($conn, $update8);
                    }
                }else{

                    $sql_id_to_update = mysqli_query($conn, "SELECT * FROM t_family WHERE teacher_id='". $update_teacher_id ."'");
                    $count_id_to_update = mysqli_num_rows($sql_id_to_update);
                    
                    for($increment8=1 ; $increment8 <= $count_id_to_update; $increment8++){
                        $child_name = mysqli_real_escape_string($conn, $_POST['child_name'. $increment8]);
                        $gender = mysqli_real_escape_string($conn, $_POST['gender'. $increment8]);
                        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date'. $increment8]);
                        $occupation = mysqli_real_escape_string($conn, $_POST['occupation'. $increment8]);

                        $data_id_to_update = mysqli_fetch_assoc($sql_id_to_update);
                        $id_to_update_table8 =  $data_id_to_update['id'];
                        
                        $update8 = "UPDATE t_family SET
                                    child_name = '$child_name',
                                    gender = '$gender',
                                    birth_date = '$birth_date',
                                    occupation = '$occupation' WHERE id = '". $id_to_update_table8 ."'";
                        $update_run8 = mysqli_query($conn, $update8);
                    }


                    // insert data in table8 if user add row in edit form using for loop.
                    $number_for_loop = $countrow_table8 - $number_data_table8;
                    for($increment8=1; $increment8 <= $number_for_loop; $increment8++){

                        $number_data_table8 = $number_data_table8+1;

                        $child_name = mysqli_real_escape_string($conn, $_POST['child_name'. $number_data_table8]);
                        $gender = mysqli_real_escape_string($conn, $_POST['gender'. $number_data_table8]);
                        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date'. $number_data_table8]);
                        $occupation = mysqli_real_escape_string($conn, $_POST['occupation'. $number_data_table8]);
                        
                        $insert8 = "INSERT INTO t_family (teacher_id, child_name, gender, birth_date, occupation)
                                                    VALUES ('$update_teacher_id', '$child_name', '$gender', '$birth_date', '$occupation')";
                        $insert8_run = mysqli_query($conn, $insert8);
                    }
                }

                mysqli_free_result($sql_id_to_update);
                mysqli_free_result($count_data_table8);
            //================ UPDATE DATA IN TABLE8 t_family  END ================//

            // ============== END OF FOR LOOP FOR ALL TABLE RELATED TO TEACHER INFORAMTION =====================//
            
            $_SESSION['GENERATE'] = 'Update information has completed.';
            header("Location:". SITEURL ."teachers.php?". $url);
            exit(0);
        }else{
            $_SESSION['GENERATE_ERROR'] = 'Update information has not completed.';
            header("Location:". SITEURL ."teachers.php?". $url);
            exit(0);
        }                         
          
    }



    ################################
    ## RESET PASSWORD
    ################################

    if(isset($_GET['reset-id'])){
        $reset_id = $_GET['reset-id'];
        $query_string = $_SERVER['QUERY_STRING'];

        $teacher_id = mysqli_query($conn, "SELECT * FROM teacher_info WHERE id ='". $reset_id ."'");
        $result_id = '';
        $url = '';

        if(mysqli_num_rows($teacher_id) > 0){
            $result_id = mysqli_fetch_assoc($teacher_id);
            $t_id = $result_id['teacher_id'];
            $full_name = $result_id['fn_en'] . " ". $result_id['ln_en'];
        }
        if($query_string != "reset-id=". $reset_id){
            $return_url = str_replace("reset-id=". $reset_id."&", "", $query_string);
            if($return_url != ''){
                $url = "?".$return_url;
    
            }
        }

        $_SESSION['RESET_PASS'] = "teacher-id=". $t_id;
        $_SESSION['TEACHER_FULLNAME'] = $full_name;
        
        // echo $_SESSION['RESET_PASS'];
        // exit;
        header("Location: ".SITEURL."teachers.php". $url);
        exit;
    }

    if(isset($_GET['teacher-id'])){
        $teacher_id = $_GET['teacher-id'];
        $query_string = $_SERVER['QUERY_STRING'];
        
        $password = md5('1234');

        $url = '';
        
        if($query_string != "teacher-id=". $teacher_id){
            $return_url = str_replace("teacher-id=". $teacher_id."&", "", $query_string);
            if($return_url != ''){
                $url = "?".$return_url;
            }
        }


        $reset_password = mysqli_query($conn, "UPDATE users SET password ='$password' WHERE user_id ='". $teacher_id ."'");
        if($reset_password == true){
            $_SESSION['GENERATE'] = 'Password has reset completed.';
            header("Location:". SITEURL."teachers.php" .$url);
            exit;
        }else{
            echo 'No teacher';
        }
    }