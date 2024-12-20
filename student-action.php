<?php
    require_once('ims-db-connection.php');
    include_once('login-check.php');


    // Add multi student 
    if(isset($_POST['std_auto_generate'])){
        if(!empty($_POST['number_generate'])){
            if(!empty($_POST['class'])){
                $class = mysqli_real_escape_string($conn, $_POST['class']);     
                $number_generate = mysqli_real_escape_string($conn, $_POST['number_generate']);              
                // $std_id = mysqli_real_escape_string($conn, $_POST['indentify_number']);


                $class_sql = mysqli_query($conn, "SELECT * FROM class WHERE class_id='". $class ."'");
                $class_data = mysqli_fetch_assoc($class_sql);

                // print_r($class_data);


                $class_code = $class_data['class_code'];
                $class_no = $class_code."000"; 

                $check_max_id = mysqli_query($conn, "SELECT MAX(student_id) FROM student_info WHERE student_id LIKE '%". $class_code . "%'");
                $check_max_id_data = mysqli_fetch_assoc($check_max_id);

                if(isset($check_max_id_data['MAX(student_id)'])){
                    $class_id = $check_max_id_data['MAX(student_id)'];
                }else{
                    $class_id = $class_no; 
                }                      
                
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="'.$class_data['class_code'].'".xls"');


                $file = fopen("php://output", "w");
                $headers = array('#', 'Student ID', 'Username', 'Password', 'Class code');
                fputcsv($file, $headers, "\t");

                for($i=1; $i<=$number_generate; $i++){
                    // echo substr($major_data['major'], 0, 5);
                    $class_name =  $class_data['class_code'];

                    // $random_username = strtolower($class_name."-".rand(0,100));
                    $random_username = $class_id+$i;
                    $random_std_id = $class_id+$i;

                    // if you want to has password plssease create in this $randomm_pass = php_hash_password(rand(0, 9999999));
                    $random_pass = rand(0, 9999999);
                    // $hash_random_pass =  password_hash($random_pass, PASSWORD_DEFAULT);
                    $hash_random_pass =  md5($random_pass);


                    // check id not used 
                    $check_id = mysqli_query($conn, "SELECT * FROM student_info WHERE student_id ='". $random_std_id ."'");
                    if(mysqli_num_rows($check_id) > 0){
                        $_SESSION['NO_ID'] = "Indentify number has already used.";
                        header("Location:". SITEURL . "add-multi-student.php");
                        exit(0);
                    }else{                      
                        $generate = "INSERT INTO student_info (username, password,  student_id, class_id) 
                                    VALUES('$random_username', '$hash_random_pass', '$random_std_id', '$class')";
                        $generate_run = mysqli_query($conn, $generate);

                        // $insert_slibling = mysqli_query($conn, "INSERT INTO student_sibling (student_id) VALUES ($random_std_id)");   
                        
                        

                        $primary_sql = "INSERT INTO background_education 
                        (student_id, class_level) VALUES('$random_std_id','1')";

                        $primary_sql_run = mysqli_query($conn, $primary_sql);

                        // mysqli_free_result($primary_sql_run);


                        $secondary_sql = "INSERT INTO background_education 
                        (student_id, class_level) VALUES('$random_std_id', '2')";

                        $secondary_sql_run = mysqli_query($conn, $secondary_sql);

                        // mysqli_free_result($secondary_sql_run);


                        $high_sql = "INSERT INTO background_education
                        (student_id, class_level) VALUES('$random_std_id','3')";

                        $high_sql_run = mysqli_query($conn, $high_sql);
                    }

                    $_SESSION['GENERATE'] = 'Generate information has completed.';

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="'.$class_data['class_code'].'".xls"');
    

                    $file = fopen("php://output", "w");
                
                    $data = array(
                        array($i, $random_std_id, $random_username, $random_pass, $class_name)
                    );
                    foreach ($data as $row) {
                        fputcsv($file, $row, "\t");
                    }                 
                }

                    return($_SESSION['GENERATE'] = 'Generate information has completed.') ;


                header("Location:". SITEURL . "add-multi-student.php");
                exit(0);

            }else{
                $_SESSION['NO_MAJOR'] = 'Class are reqired';
                // $_SESSION['NO_ID'] = 'Indentify number are reqired';
                header("Location:". SITEURL . "add-multi-student.php");
                exit(0);
            }
        }else{
            $_SESSION['NUMBER_GENERATE'] = 'Number generate is empty, please try again.';
            header("location:".SITEURL."add-multi-student.php");
            exit(0);
        }
    }


    // Add single student 
    if(isset($_POST['std_generate'])){

        $gender = '';

        // personal information 
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        // $std_id = mysqli_real_escape_string($conn, $_POST['indentify_number']);


        $fn_kh = mysqli_real_escape_string($conn, $_POST['fn_kh']);
        $ln_kh = mysqli_real_escape_string($conn, $_POST['ln_kh']);
        $fn_en = mysqli_real_escape_string($conn, $_POST['fn_en']);
        $ln_en = mysqli_real_escape_string($conn, $_POST['ln_en']);

        $brith_date = mysqli_real_escape_string($conn, $_POST['brith_date']);
        $national = mysqli_real_escape_string($conn, $_POST['national']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

        $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);

        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $current_place = mysqli_real_escape_string($conn, $_POST['current_place']);

        if(empty($_POST['gender'])){
            $gender = '';
        }else{
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        }
        
        

        // education background
            // primary_school 
            $primary_school_name = mysqli_real_escape_string($conn, $_POST['primary_school_name']);
            $primary_address = mysqli_real_escape_string($conn, $_POST['primary_address']);
            $primary_start = mysqli_real_escape_string($conn, $_POST['primary_start']);
            $primary_end = mysqli_real_escape_string($conn, $_POST['primary_end']);
            $primary_certificate = mysqli_real_escape_string($conn, $_POST['primary_certificate']);
            $primary_rank = mysqli_real_escape_string($conn, $_POST['primary_rank']);

            // secondary_school 
            $secondary_school_name = mysqli_real_escape_string($conn, $_POST['secondary_school_name']);
            $secondary_address = mysqli_real_escape_string($conn, $_POST['secondary_address']);
            $secondary_start = mysqli_real_escape_string($conn, $_POST['secondary_start']);
            $secondary_end = mysqli_real_escape_string($conn, $_POST['secondary_end']);
            $secondary_certificate = mysqli_real_escape_string($conn, $_POST['secondary_certificate']);
            $secondary_rank = mysqli_real_escape_string($conn, $_POST['secondary_rank']);

            // high_school 
            $high_school_name = mysqli_real_escape_string($conn, $_POST['high_school_name']);
            $high_address = mysqli_real_escape_string($conn, $_POST['high_address']);
            $high_start = mysqli_real_escape_string($conn, $_POST['high_start']);
            $high_end = mysqli_real_escape_string($conn, $_POST['high_end']);
            $high_certificate = mysqli_real_escape_string($conn, $_POST['high_certificate']);
            $high_rank = mysqli_real_escape_string($conn, $_POST['high_rank']);


    
        // familty information 
        $fatherName = mysqli_real_escape_string($conn, $_POST['fatherName']);
        $fatherAge = mysqli_real_escape_string($conn, $_POST['fatherAge']);
        $fatherOccupa = mysqli_real_escape_string($conn, $_POST['fatherOccupa']);
        $fatherPhone = mysqli_real_escape_string($conn, $_POST['fatherPhone']);
        $fatherAddress = mysqli_real_escape_string($conn, $_POST['fatherAddress']);

        $motherName = mysqli_real_escape_string($conn, $_POST['motherName']);
        $motherAge = mysqli_real_escape_string($conn, $_POST['motherAge']);
        $motherOccupa = mysqli_real_escape_string($conn, $_POST['motherOccupa']);
        $motherPhone = mysqli_real_escape_string($conn, $_POST['motherPhone']);
        $motherAddress = mysqli_real_escape_string($conn, $_POST['motherAddress']);

        $sibling = mysqli_real_escape_string($conn, $_POST['sibling']);
        $femaleSibling = mysqli_real_escape_string($conn, $_POST['femaleSibling']);
 

        
        if($username == '' || $password == ''){
            if(empty($_POST['class'])){
                $_SESSION['NO_MAJOR_M'] = 'Class are reqired';
                header("Location:". SITEURL . "add-student.php");
            }
            $_SESSION['NO_USENAME_M'] = 'Username are reqired';
            $_SESSION['NO_PASS_M'] = 'Password are reqired';
            // $_SESSION['NO_ID_M'] = 'Indentify number are reqired';
            header("Location:". SITEURL . "add-student.php");
            exit(0);

        }elseif(empty($_POST['class'])){
            $_SESSION['NO_MAJOR_M'] = 'Class are reqired';
            header("Location:". SITEURL . "add-student.php");
            exit(0);
        }else{
            $class = mysqli_real_escape_string($conn, $_POST['class']);
        
            $class_sql = mysqli_query($conn, "SELECT * FROM class WHERE class_id='". $class ."'");
            $class_data = mysqli_fetch_assoc($class_sql);

            $class_code = $class_data['class_code'];
            $class_no = $class_data['class_code']."000";

            

            $check_max_id = mysqli_query($conn, "SELECT MAX(student_id) FROM student_info WHERE student_id LIKE '%". $class_code . "%'");
            $check_max_id_data = mysqli_fetch_assoc($check_max_id);

            if(isset($check_max_id_data['MAX(student_id)'])){
                $std_id = $check_max_id_data['MAX(student_id)'] + 1;
            }else{
                $std_id = $class_no + 1; 
            }    




            $check_id = "SELECT * FROM student_info WHERE student_id ='". $std_id . "'";
            $check_id_run = mysqli_query($conn, $check_id);
            if(mysqli_num_rows($check_id_run) > 0){
                $_SESSION['NO_ID_M'] = "Indentify number has already used.";
                header("Location:". SITEURL . "add-student.php");
                exit(0);
            }else{

                $generate_std = "INSERT INTO student_info 
                                (username, 
                                password, 
                                student_id, 
                                class_id,

                                fn_khmer,
                                ln_khmer,
                                firstname,
                                lastname,
                                gender,
                                birth_date,
                                national,
                                nationality,

                                phone_number,
                                email,
                                place_of_birth,
                                current_place,

                                father_name,
                                father_age,
                                father_occupa,
                                father_phone,
                                father_address,
                                mother_name,
                                mother_age,
                                mother_occupa,
                                mother_phone,
                                mother_address,
                                sibling,
                                female_sibling)
                                
                                VALUES
                                ('$username', 
                                '$password', 
                                '$std_id', 
                                '$class',


                                '$fn_kh',
                                '$ln_kh',
                                '$fn_en',
                                '$ln_en',
                                '$gender',
                                '$brith_date',
                                '$national',
                                '$nationality',

                                '$phone_number',
                                '$email',
                                '$birth_place',
                                '$current_place',


                                '$fatherName',
                                '$fatherAge',
                                '$fatherOccupa',
                                '$fatherPhone',
                                '$fatherAddress',

                                '$motherName',
                                '$motherAge',
                                '$motherOccupa',
                                '$motherPhone',
                                '$motherAddress',

                                '$sibling',
                                '$femaleSibling');";


                                $generate_std_run = mysqli_query($conn, $generate_std);
                                if($generate_std_run == true){
                                    $incrementNumber = 1;
                                    for($incrementNumber; $incrementNumber <= $sibling; $incrementNumber++){
                                        $sibling_name= mysqli_real_escape_string($conn, $_POST['name'. $incrementNumber .'']);
                                        $sib_gender = mysqli_real_escape_string($conn, $_POST['gender'. $incrementNumber .'']);
                                        $sib_brith_date= mysqli_real_escape_string($conn, $_POST['birth_date'. $incrementNumber .'']);
                                        $sib_occupa = mysqli_real_escape_string($conn, $_POST['occupa'. $incrementNumber .'']);
                                        $sib_current_add = mysqli_real_escape_string($conn, $_POST['current_add'. $incrementNumber .'']);
                                        $sib_phone = mysqli_real_escape_string($conn, $_POST['phone'. $incrementNumber .'']);

                                    
                                        $insert_sibling = "INSERT INTO student_sibling
                                        (student_id,
                                        sibl1_name,
                                        sibl1_gender,
                                        sibl1_birth_date,
                                        sibl1_occupa,
                                        sibl1_address,
                                        sibl1_phone)
                                        VALUES( '$std_id',
                                        '$sibling_name',
                                        '$sib_gender',
                                        '$sib_brith_date',
                                        '$sib_occupa',
                                        ' $sib_current_add',
                                        '$sib_phone')";

                                        $insert_sibling_run = mysqli_query($conn, $insert_sibling);                                                                    
                                    }

                                    // mysqli_free_result($insert_sibling_run);

                                    $primary_sql = "INSERT INTO background_education (student_id,
                                    class_level,
                                    school_name,
                                    address,
                                    start_year,
                                    finish_year,
                                    certificate,
                                    rank) VALUES('$std_id',
                                    '1',
                                    '$primary_school_name',
                                    '$primary_address',
                                    '$primary_start',
                                    '$primary_end',
                                    '$primary_certificate',
                                    '$primary_rank')";

                                    $primary_sql_run = mysqli_query($conn, $primary_sql);

                                    // mysqli_free_result($primary_sql_run);



                                    $secondary_sql = "INSERT INTO background_education (student_id,
                                    class_level,
                                    school_name,
                                    address,
                                    start_year,
                                    finish_year,
                                    certificate,
                                    rank) VALUES('$std_id',
                                    '2',
                                    '$secondary_school_name',
                                    '$secondary_address',
                                    '$secondary_start',
                                    '$secondary_end',
                                    '$secondary_certificate',
                                    '$secondary_rank')";

                                    $secondary_sql_run = mysqli_query($conn, $secondary_sql);

                                    // mysqli_free_result($secondary_sql_run);

                                    

                                    $high_sql = "INSERT INTO background_education (student_id,
                                    class_level,
                                    school_name,
                                    address,
                                    start_year,
                                    finish_year,
                                    certificate,
                                    rank) VALUES('$std_id',
                                    '3',
                                    '$high_school_name',
                                    '$high_address',
                                    '$high_start',
                                    '$high_end',
                                    '$high_certificate',
                                    '$high_rank')";

                                    $high_sql_run = mysqli_query($conn, $high_sql);

                                    // mysqli_free_result($high_sql_run);


                                    $_SESSION['GENERATE_MANULE'] = 'Generate information has completed.';
                                    header("Location:". SITEURL . "add-student.php");
                                    exit(0);
                                }else{
                                    $_SESSION['GENERATE_MANULE_ERROR'] = 'Generate information has not completed.';
                                    header("Location:". SITEURL . "add-student.php");
                                    exit(0);
                                }
            }
        }
    }


    // update student here 
    if(isset($_POST['update_student'])){
        // echo "Update work";
        $gender = '';
        $url = mysqli_real_escape_string($conn , $_POST['url']);

        $update_id = $_POST['update_id'];
        $student_id_sql = mysqli_query($conn, "SELECT * FROM student_info WHERE id='". $update_id . "'");
        $result = mysqli_fetch_assoc($student_id_sql);

        $student_id = $result['student_id'];

        $fn_kh = mysqli_real_escape_string($conn, $_POST['fn_kh']);
        $ln_kh = mysqli_real_escape_string($conn, $_POST['ln_kh']);
        $fn_en = mysqli_real_escape_string($conn, $_POST['fn_en']);
        $ln_en = mysqli_real_escape_string($conn, $_POST['ln_en']);

        // $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        if(!empty($_POST['gender'])){
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        }else{
            $gender = '';
        }


        $brith_date = mysqli_real_escape_string($conn, $_POST['brith_date']);
        $national = mysqli_real_escape_string($conn, $_POST['national']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

        $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);

        // $study_lavel = mysqli_real_escape_string($conn, $_POST['study_lavel']);
        // $study_lavel = array_key_exists("study_lavel", $_POST);
        // $year_level_study = array_key_exists("year_level_study", $_POST);


        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $current_place = mysqli_real_escape_string($conn, $_POST['current_place']);

    
        $fatherName = mysqli_real_escape_string($conn, $_POST['fatherName']);
        $fatherAge = mysqli_real_escape_string($conn, $_POST['fatherAge']);
        $fatherOccupa = mysqli_real_escape_string($conn, $_POST['fatherOccupa']);
        $fatherPhone = mysqli_real_escape_string($conn, $_POST['fatherPhone']);
        $fatherAddress = mysqli_real_escape_string($conn, $_POST['fatherAddress']);

        $motherName = mysqli_real_escape_string($conn, $_POST['motherName']);
        $motherAge = mysqli_real_escape_string($conn, $_POST['motherAge']);
        $motherOccupa = mysqli_real_escape_string($conn, $_POST['motherOccupa']);
        $motherPhone = mysqli_real_escape_string($conn, $_POST['motherPhone']);
        $motherAddress = mysqli_real_escape_string($conn, $_POST['motherAddress']);

        $sibling = mysqli_real_escape_string($conn, $_POST['sibling']);
        $femaleSibling = mysqli_real_escape_string($conn, $_POST['femaleSibling']);
    
        mysqli_free_result($student_id_sql);


        // education background
            // primary_school 
            $primary_id = $_POST['primary_id'];
            $primary_school_name = mysqli_real_escape_string($conn, $_POST['primary_school_name']);
            $primary_address = mysqli_real_escape_string($conn, $_POST['primary_address']);
            $primary_start = mysqli_real_escape_string($conn, $_POST['primary_start']);
            $primary_end = mysqli_real_escape_string($conn, $_POST['primary_end']);
            $primary_certificate = mysqli_real_escape_string($conn, $_POST['primary_certificate']);
            $primary_rank = mysqli_real_escape_string($conn, $_POST['primary_rank']);

            // secondary_school 
            $secondary_id = $_POST['secondary_id'];
            $secondary_school_name = mysqli_real_escape_string($conn, $_POST['secondary_school_name']);
            $secondary_address = mysqli_real_escape_string($conn, $_POST['secondary_address']);
            $secondary_start = mysqli_real_escape_string($conn, $_POST['secondary_start']);
            $secondary_end = mysqli_real_escape_string($conn, $_POST['secondary_end']);
            $secondary_certificate = mysqli_real_escape_string($conn, $_POST['secondary_certificate']);
            $secondary_rank = mysqli_real_escape_string($conn, $_POST['secondary_rank']);

            // high_school 
            $high_id = $_POST['high_id'];
            $high_school_name = mysqli_real_escape_string($conn, $_POST['high_school_name']);
            $high_address = mysqli_real_escape_string($conn, $_POST['high_address']);
            $high_start = mysqli_real_escape_string($conn, $_POST['high_start']);
            $high_end = mysqli_real_escape_string($conn, $_POST['high_end']);
            $high_certificate = mysqli_real_escape_string($conn, $_POST['high_certificate']);
            $high_rank = mysqli_real_escape_string($conn, $_POST['high_rank']);
        // education background


        // update SQL 
        $update = "UPDATE student_info SET
                                fn_khmer = '$fn_kh',
                                ln_khmer = '$ln_kh',
                                firstname = '$fn_en',
                                lastname = '$ln_en',
                                gender = '$gender',
                                birth_date = '$brith_date',
                                national = '$national',
                                nationality = '$nationality',
                                -- level_id = '$study_lavel',
                                -- year_level_id = '$year_level_study',
                                phone_number = '$phone_number',
                                email = '$email',
                                place_of_birth = '$birth_place',
                                current_place = '$current_place',

                                father_name = '$fatherName',
                                father_age = '$fatherAge',
                                father_occupa = '$fatherOccupa',
                                father_phone = '$fatherPhone',
                                father_address = '$fatherAddress',
                                mother_name = '$motherName',
                                mother_age = '$motherAge',
                                mother_occupa = '$motherOccupa',
                                mother_phone = '$motherPhone',
                                mother_address = '$motherAddress',
                                sibling = '$sibling',
                                female_sibling = '$femaleSibling' WHERE id = '". $update_id . "'";

        $update_run = mysqli_query($conn, $update);
        if($update_run == true){


                                /*
                                    // update sibling 
                                        for($incrementNumber = 1; $incrementNumber <= $femaleSibling; $incrementNumber++){
                                            $sibling_name= mysqli_real_escape_string($conn, $_POST['name'. $incrementNumber .'']);
                                            $sib_gender = mysqli_real_escape_string($conn, $_POST['gender'. $incrementNumber .'']);
                                            $sib_brith_date= mysqli_real_escape_string($conn, $_POST['birth_date'. $incrementNumber .'']);
                                            $sib_occupa = mysqli_real_escape_string($conn, $_POST['occupa'. $incrementNumber .'']);
                                            $sib_current_add = mysqli_real_escape_string($conn, $_POST['current_add'. $incrementNumber .'']);
                                            $sib_phone = mysqli_real_escape_string($conn, $_POST['phone'. $incrementNumber .'']);

                                            // echo $sibling_name;
                                            // exit;

                                            $update_sibling = "UPDATE student_sibling SET 
                                                                        sibl1_name = '$sibling_name',
                                                                        sibl1_gender = '$sib_gender',
                                                                        sibl1_birth_date = '$sib_brith_date',
                                                                        sibl1_occupa = '$sib_occupa',
                                                                        sibl1_address = '$sib_current_add',
                                                                        sibl1_phone = '$sib_phone'  WHERE student_id='". $student_id ."'";
                                            $update_sibling_run = mysqli_query($conn, $update_sibling);
                                        }
                                    // update sibling 
                                */


            ########## Update sibling
                $check_sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id = '". $student_id ."'");
                if(mysqli_num_rows($check_sibling) > 0){
                    #delete sibling from table
                    $delete_sibling = mysqli_query($conn, "DELETE FROM student_sibling WHERE student_id = '". $student_id ."'");
                    if($delete_sibling == true){
                        #insert new sibling
                        if($sibling > 0){
                            for($i=1; $i<=$sibling; $i++){

                                $sibling_gender = '';
                                $sibling_fullname = mysqli_real_escape_string($conn, $_POST['name'. $i]);
                                if(!empty($_POST['gender'. $i])){
                                    $sibling_gender = mysqli_real_escape_string($conn, $_POST['gender'. $i]);
                                }
                                $sibling_birthdate = mysqli_real_escape_string($conn, $_POST['birth_date'. $i]);
                                $sibling_occupation = mysqli_real_escape_string($conn, $_POST['occupa'. $i]);

                                $sibling_address = mysqli_real_escape_string($conn, $_POST['current_add'. $i]);
                                $sibling_phone = mysqli_real_escape_string($conn, $_POST['phone'. $i]);



                                ####### INSERT 

                                $insert_sibling = mysqli_query($conn, "INSERT INTO student_sibling (student_id, sibl1_name, sibl1_gender, sibl1_birth_date, sibl1_occupa, sibl1_address, sibl1_phone) 
                                                                    VALUES ('$student_id', '$sibling_fullname', '$sibling_gender', '$sibling_birthdate', '$sibling_occupation', '$sibling_address', '$sibling_phone')");
                            }
                        }
                    }
                }else{
                    #insert sibling
                    if($sibling > 0){
                        for($i=1; $i<=$sibling; $i++){

                            $sibling_gender = '';
                            $sibling_fullname = mysqli_real_escape_string($conn, $_POST['name'. $i]);
                            if(!empty($_POST['gender'. $i])){
                                $sibling_gender = mysqli_real_escape_string($conn, $_POST['gender'. $i]);
                            }
                            $sibling_birthdate = mysqli_real_escape_string($conn, $_POST['birth_date'. $i]);
                            $sibling_occupation = mysqli_real_escape_string($conn, $_POST['occupa'. $i]);

                            $sibling_address = mysqli_real_escape_string($conn, $_POST['current_add'. $i]);
                            $sibling_phone = mysqli_real_escape_string($conn, $_POST['phone'. $i]);


                            ####### INSERT 
                            $insert_sibling = mysqli_query($conn, "INSERT INTO student_sibling (student_id, sibl1_name, sibl1_gender, sibl1_birth_date, sibl1_occupa, sibl1_address, sibl1_phone) 
                                                                    VALUES ('$student_id', '$sibling_fullname', '$sibling_gender', '$sibling_birthdate', '$sibling_occupation', '$sibling_address', '$sibling_phone')");
                        }
                    }
                }
            ########## Update sibling





            // update education 
                $primary_update = "UPDATE background_education SET 
                                                school_name = '$primary_school_name',
                                                address = '$primary_address',
                                                start_year = '$primary_start',
                                                finish_year = '$primary_end',
                                                certificate = '$primary_certificate',
                                                rank = '$primary_rank' WHERE id ='". $primary_id ."' AND student_id ='". $student_id ."'";
                $primary_update_run = mysqli_query($conn, $primary_update);


                $secondary_update = "UPDATE background_education SET 
                                                school_name = '$secondary_school_name',
                                                address = '$secondary_address',
                                                start_year = '$secondary_start',
                                                finish_year = '$secondary_end',
                                                certificate = '$secondary_certificate',
                                                rank = '$secondary_rank' WHERE id ='". $secondary_id ."' AND student_id ='". $student_id ."'";
                $secondary_update_run = mysqli_query($conn, $secondary_update);



                $high_update = "UPDATE background_education SET 
                                                school_name = '$high_school_name',
                                                address = '$high_address',
                                                start_year = '$high_start',
                                                finish_year = '$high_end',
                                                certificate = '$high_certificate',
                                                rank = '$high_rank' WHERE id ='". $high_id ."' AND student_id ='". $student_id ."'";
                $high_update_run = mysqli_query($conn, $high_update);

            // update education 







            $_SESSION['GENERATE'] = "Update student information has completed.";
            if($url == ''){
                header("Location:".SITEURL."students.php");
            }else{
                header("Location:".SITEURL."students.php?".$url);
            }
            exit(0);

        }else{
            $_SESSION['GENERATE_ERROR'] = "Update student information has not completed.";
            if($url == ''){
                header("Location:".SITEURL."students.php");
            }else{
                header("Location:".SITEURL."students.php?".$url);
            }
            exit(0);
        }
    }



    // delete student info 
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $student_id = mysqli_query($conn, "SELECT * FROM student_info WHERE id ='". $id ."'");
        $data = mysqli_fetch_assoc($student_id);
        $student_id = $data['student_id'];

        // print_r($data);


        $delete_student = mysqli_query($conn, "DELETE FROM student_info WHERE id ='". $id ."'");
        if($delete_student == true){
            $del_education = mysqli_query($conn, "DELETE FROM background_education WHERE student_id ='". $student_id ."'");
            if($del_education == true){
                $del_sibling = mysqli_query($conn, "DELETE FROM student_sibling WHERE student_id ='". $student_id ."'");
                if($del_sibling == true){
                    $del_request = mysqli_query($conn, "DELETE FROM requests WHERE student_id ='". $student_id ."'");
                    if($del_request == true){
                        $del_score = mysqli_query($conn, "DELETE FROM score WHERE student_id ='". $student_id ."'");
                    }
                }
            }
            

            $_SESSION['STD_DELETE'] = 'Delete student has completed.';
            header('Location:'. SITEURL .'leave-students.php');
            exit;
        }else{
            $_SESSION['STD_DELETE_ERROR'] = 'Delete student has not completed.';
            header('Location:'. SITEURL .'leave-students.php');
            exit;
        }
    }


    // Leave student recovery 
    if(isset($_GET['reco'])){
        // echo 'Recovery';
        $id = $_GET['reco'];

        $recovery = mysqli_query($conn, "UPDATE student_info SET active_status = '1' WHERE id = '". $id ."'");
        if($recovery == true){
            $_SESSION['STD_DELETE'] = 'Recovery student has completed.';
            header('Location:'. SITEURL .'leave-students.php');
            exit;
        }else{
            $_SESSION['STD_DELETE_ERROR'] = 'Recovery student has not completed.';
            header('Location:'. SITEURL .'leave-students.php');
            exit;
        }

    }


    // Leave student verify
    if(isset($_GET['leave'])){
        // echo 'Leave';
        $query_string = $_SERVER['QUERY_STRING'];
        $query_string = str_replace('&leave='. $_GET['leave'], '', $query_string);
        

        $_SESSION['LEAVE'] = $query_string."&leave-id=". $_GET['leave'];
        header('Location:'. SITEURL.'students.php?'.$query_string);
        exit;
    }


    // Leave student 
    if(isset($_GET['leave-id'])){
        $id = $_GET['leave-id'];
        $query_string = $_SERVER['QUERY_STRING'];
        $query_string = str_replace('&leave-id='. $_GET['leave-id'], '', $query_string);

        $leave = mysqli_query($conn, "UPDATE student_info SET active_status = '0' WHERE id ='". $id ."'");
        if($leave == true){
            $_SESSION['GENERATE'] = 'This student has leaved';
            header("location:". SITEURL ."students.php?". $query_string);
            exit;

        }else{
            $_SESSION['GENERATE_ERROR'] = 'Student leave has not completed.';
            header("location:". SITEURL ."students.php?". $query_string);
            exit;
        }
    }



    // Reset password 
    if(isset($_POST['btnResetPass'])){
        $reset_id = mysqli_real_escape_string($conn, $_POST['reset_id']);
        $new_pass = md5('1234');
        $resetQry = mysqli_query($conn, "UPDATE student_info SET password = '$new_pass' WHERE id ='". $reset_id ."'");
        if($resetQry == true){
            $_SESSION['RESETED'] = "Reset password has completed.";
            header("Location:". $_SERVER['HTTP_REFERER']);
            exit(0);
        }else{
            $_SESSION['RESETED_ERROR'] = "Reset password has not completed.";
            header("Location:". $_SERVER['HTTP_REFERER']);
            exit(0);
        }
    }




    mysqli_close($conn);
?>