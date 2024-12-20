<?php
    # Connection to DATABASE
    require_once('../ims-db-connection.php');

    
    #Check login 
    include_once('std-login-check.php');
    

    if(isset($_POST['edit_profile'])){
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        $student_id = $_SESSION['LOGIN_STDID'];
        $path = '../ims-assets/ims-images/';
        $old_profile = mysqli_real_escape_string($conn, $_POST['old_profile']);
        $newImagename = '';

        if(!empty($_FILES['student_profile']['name'])){
            $profile = $_FILES['student_profile']['name'];
            $profile_tmp = $_FILES['student_profile']['tmp_name'];
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $profile);
    
            $imageExtension = strtolower(end($imageExtension));
            $newImagename = uniqid();
            $newImagename .= '.'. $imageExtension;
    
            move_uploaded_file($profile_tmp, $path.'/'.$newImagename);
    
    
            if(file_exists($path.$old_profile) ){
                unlink($path.$old_profile);                    
            }
        }else{
            $newImagename = $old_profile;
        }



        $gender = '';
        if(!empty($_POST['gender'])){
            $gender = $_POST['gender'];
        }


        $fn_kh = mysqli_real_escape_string($conn, $_POST['fn_kh']);
        $ln_kh = mysqli_real_escape_string($conn, $_POST['ln_kh']);
        $fn_en = mysqli_real_escape_string($conn, $_POST['fn_en']);
        $ln_en = mysqli_real_escape_string($conn, $_POST['ln_en']);
        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
        $national = mysqli_real_escape_string($conn, $_POST['national']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);

        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $birth_address = mysqli_real_escape_string($conn, $_POST['birth_address']);
        $current_address = mysqli_real_escape_string($conn, $_POST['current_address']);


        ######## 1
        $schoolname1 = mysqli_real_escape_string($conn, $_POST['schoolname1']);
        $school_add1 = mysqli_real_escape_string($conn, $_POST['school_add1']);

        $start_year1 = mysqli_real_escape_string($conn, $_POST['start_year1']);
        $finish_year1 = mysqli_real_escape_string($conn, $_POST['finish_year1']);

        $certificate1 = mysqli_real_escape_string($conn, $_POST['certificate1']);
        $total_rank1 = mysqli_real_escape_string($conn, $_POST['total_rank1']);


        ######## 2

        $schoolname2 = mysqli_real_escape_string($conn, $_POST['schoolname2']);
        $school_add2 = mysqli_real_escape_string($conn, $_POST['school_add2']);

        $start_year2 = mysqli_real_escape_string($conn, $_POST['start_year2']);
        $finish_year2 = mysqli_real_escape_string($conn, $_POST['finish_year2']);

        $certificate2 = mysqli_real_escape_string($conn, $_POST['certificate2']);
        $total_rank2 = mysqli_real_escape_string($conn, $_POST['total_rank2']);

        
        ######## 3

        $schoolname3 = mysqli_real_escape_string($conn, $_POST['schoolname3']);
        $school_add3 = mysqli_real_escape_string($conn, $_POST['school_add3']);
       
        $start_year3 = mysqli_real_escape_string($conn, $_POST['start_year3']);
        $finish_year3 = mysqli_real_escape_string($conn, $_POST['finish_year3']);

        $certificate3 = mysqli_real_escape_string($conn, $_POST['certificate3']);
        $total_rank3 = mysqli_real_escape_string($conn, $_POST['total_rank3']);



        ################

        $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
        $father_age = mysqli_real_escape_string($conn, $_POST['father_age']);
        $father_occupatioin = mysqli_real_escape_string($conn, $_POST['father_occupatioin']);
        $father_phone = mysqli_real_escape_string($conn, $_POST['father_phone']);
        $father_current_address = mysqli_real_escape_string($conn, $_POST['father_current_address']);


        ###############
        $mother_name = mysqli_real_escape_string($conn, $_POST['mother_name']);
        $mother_age = mysqli_real_escape_string($conn, $_POST['mother_age']);
        $mother_occupatioin = mysqli_real_escape_string($conn, $_POST['mother_occupatioin']);
        $mother_phone = mysqli_real_escape_string($conn, $_POST['mother_phone']);
        $mother_current_address = mysqli_real_escape_string($conn, $_POST['mother_current_address']);


        $your_sibling = mysqli_real_escape_string($conn, $_POST['your_sibling']);


        $update_student_info = "UPDATE student_info SET 
                                profile_image = '$newImagename',
                                fn_khmer = '$fn_kh',
                                ln_khmer = '$ln_kh',
                                firstname = '$fn_en',
                                lastname = '$ln_en',
                                gender = '$gender',
                                birth_date = '$birth_date',
                                national = '$national',
                                nationality = '$nationality',
                                phone_number = '$phone_number',
                                email = '$email',
                                place_of_birth = '$birth_address',
                                current_place = '$current_address',

                                father_name = '$father_name',
                                father_age = '$father_age',
                                father_occupa = '$father_occupatioin',
                                father_phone = '$father_phone',
                                father_address = '$father_current_address',

                                
                                mother_name = '$mother_name',
                                mother_age = '$mother_age',
                                mother_occupa = '$mother_occupatioin',
                                mother_phone = '$mother_phone',
                                mother_address = '$mother_current_address',
                                sibling = '$your_sibling'

                                WHERE student_id = '". $student_id ."'";

            $query_run = mysqli_query($conn, $update_student_info);

            if($query_run == true){
                ########  Update student education background 
                // check eductaion background 
                $education = mysqli_query($conn, "SELECT * FROM background_education WHERE student_id ='". $student_id ."'");
                if(mysqli_num_rows($education) > 0){
                    $education1 = mysqli_query($conn, "UPDATE background_education SET 
                                                        school_name = '$schoolname1',
                                                        address = '$school_add1',
                                                        start_year = '$start_year1',
                                                        finish_year = '$finish_year1',
                                                        certificate = '$certificate1',
                                                        rank = '$total_rank1' WHERE class_level = '1' AND 
                                                        student_id ='" . $student_id ."'");

                    $education2 = mysqli_query($conn, "UPDATE background_education SET 
                                                        school_name = '$schoolname2',
                                                        address = '$school_add2',
                                                        start_year = '$start_year2',
                                                        finish_year = '$finish_year2',
                                                        certificate = '$certificate2',
                                                        rank = '$total_rank2' WHERE class_level = '2' AND 
                                                        student_id ='" . $student_id ."'");

                    $education3 = mysqli_query($conn, "UPDATE background_education SET 
                                                        school_name = '$schoolname3',
                                                        address = '$school_add3',
                                                         start_year = '$start_year3',
                                                        finish_year = '$finish_year3',
                                                        certificate = '$certificate3',
                                                        rank = '$total_rank3' WHERE class_level = '3' AND 
                                                        student_id ='" . $student_id ."'");

                }else{
                
                    $education1 = mysqli_query($conn, "INSERT INTO background_education (student_id, class_level, school_name, address, start_year, finish_year, certificate, rank, student_id)
                                                    VALUES ('$student_id', '1','$schoolname1', '$school_add1', '$start_year1', '$finish_year1', '$certificate1', '$total_rank1')");


                    $education2 = mysqli_query($conn, "INSERT INTO background_education (student_id, class_level, school_name, address, start_year, finish_year, certificate, rank, student_id)
                                                    VALUES ('$student_id', '2','$schoolname2', '$school_add2', '$start_year2', '$finish_year2', '$certificate2', '$total_rank2')");


                    $education3 = mysqli_query($conn, "INSERT INTO background_education (student_id, class_level, school_name, address, start_year, finish_year, certificate, rank, student_id)
                                                    VALUES ('$student_id', '3','$schoolname3', '$school_add3', '$start_year3', '$finish_year3', '$certificate3', '$total_rank3')");

                }



                ########## Update sibling
                    $check_sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id = '". $student_id ."'");
                    if(mysqli_num_rows($check_sibling) > 0){
                        #delete sibling from table
                        $delete_sibling = mysqli_query($conn, "DELETE FROM student_sibling WHERE student_id = '". $student_id ."'");
                        if($delete_sibling == true){
                            #insert new sibling
                            if($your_sibling > 0){
                                for($i=1; $i<=$your_sibling; $i++){
                                    $sibling_gender = '';

                                    $sibling_fullname = mysqli_real_escape_string($conn, $_POST['sibling_fullname'. $i]);
                                    if(!empty($_POST['sibling_gender'. $i])){
                                        $sibling_gender = mysqli_real_escape_string($conn, $_POST['sibling_gender'. $i]);
                                    }
                                    $sibling_birthdate = mysqli_real_escape_string($conn, $_POST['sibling_birthdate'. $i]);
                                    $sibling_occupation = mysqli_real_escape_string($conn, $_POST['sibling_occupation'. $i]);

                                    $sibling_address = mysqli_real_escape_string($conn, $_POST['sibling_address'. $i]);
                                    $sibling_phone = mysqli_real_escape_string($conn, $_POST['sibling_phone'. $i]);



                                    ####### INSERT 

                                    $insert_sibling = mysqli_query($conn, "INSERT INTO student_sibling (student_id, sibl1_name, sibl1_gender, sibl1_birth_date, sibl1_occupa, sibl1_address, sibl1_phone) 
                                                                        VALUES ('$student_id', '$sibling_fullname', '$sibling_gender', '$sibling_birthdate', '$sibling_occupation', '$sibling_address', '$sibling_phone')");

                                }
                            }
                        }

                    }else{
                        #insert sibling

                        if($your_sibling > 0){
                            for($i=1; $i<=$your_sibling; $i++){
                                $sibling_gender = '';

                                $sibling_fullname = mysqli_real_escape_string($conn, $_POST['sibling_fullname'. $i]);
                                if(!empty($_POST['sibling_gender'. $i])){
                                    $sibling_gender = mysqli_real_escape_string($conn, $_POST['sibling_gender'. $i]);
                                }
                                $sibling_birthdate = mysqli_real_escape_string($conn, $_POST['sibling_birthdate'. $i]);
                                $sibling_occupation = mysqli_real_escape_string($conn, $_POST['sibling_occupation'. $i]);

                                $sibling_address = mysqli_real_escape_string($conn, $_POST['sibling_address'. $i]);
                                $sibling_phone = mysqli_real_escape_string($conn, $_POST['sibling_phone'. $i]);


                                ####### INSERT 

                                $insert_sibling = mysqli_query($conn, "INSERT INTO student_sibling (student_id, sibl1_name, sibl1_gender, sibl1_birth_date, sibl1_occupa, sibl1_address, sibl1_phone) 
                                                                    VALUES ('$student_id', '$sibling_fullname', '$sibling_gender', '$sibling_birthdate', '$sibling_occupation', '$sibling_address', '$sibling_phone')");

                            }
                        }
                    }
                ########## Update sibling
 

                $_SESSION['ADD_DONE'] = 'Update your profile have done';
                header("Location:". SITEURL ."ims-student/profile.php");
                exit;
                // echo 'Update student information done';


            }else{
                $_SESSION['ADD_DONE_ERROR'] = 'Update your profile have not done';
                header("Location:". SITEURL ."ims-student/profile.php");
                exit;
            }
    }
?>