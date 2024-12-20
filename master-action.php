<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');



##############################
### Class start
##############################

    if(isset($_POST['save_class'])){
        if(!empty($_POST['major']) && !empty($_POST['study_level']) && !empty($_POST['year_level']) && $_POST['class_code'] != '' && !empty($_POST['academy_year'])){
            $class_code    = strtoupper(mysqli_real_escape_string($conn, $_POST['class_code']));
            $major         = mysqli_real_escape_string($conn, $_POST['major']);
            $study_level   = mysqli_real_escape_string($conn, $_POST['study_level']);
            $year_level    = mysqli_real_escape_string($conn, $_POST['year_level']);
            $year_of_study = mysqli_real_escape_string($conn, $_POST['academy_year']);

            
            $add_class     = mysqli_query($conn, "INSERT INTO class (class_code, major_id, level_study, year_level, year_of_study)
                                                  VALUES ('$class_code', '$major', '$study_level', '$year_level', '$year_of_study')");
            if($add_class == true){
                $_SESSION['ADD_DONE'] = 'Add class has completed.';
                header("Location:".SITEURL."master-data.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Add class has not completed.';
                header("Location:".SITEURL."master-data.php");
                exit(0);
            }
        }else{
            $_SESSION['REQUIRED'] = 'All fields are required.';
            header("Location:".SITEURL."master-data.php");
            exit(0);
        }
    }elseif(isset($_POST['update_class'])){
        $update_id = $_POST['update_id'];
        if(!empty($_POST['major']) && !empty($_POST['study_level']) && !empty($_POST['year_level']) && $_POST['class_code'] != '' && !empty($_POST['academy_year'])){
            $class_code    = strtoupper(mysqli_real_escape_string($conn, $_POST['class_code']));
            $major         = mysqli_real_escape_string($conn, $_POST['major']);
            $study_level   = mysqli_real_escape_string($conn, $_POST['study_level']);
            $year_level    = mysqli_real_escape_string($conn, $_POST['year_level']);
            $year_of_study = mysqli_real_escape_string($conn, $_POST['academy_year']);




            $add_class     = mysqli_query($conn, "UPDATE class SET 
                                                    class_code = '$class_code', 
                                                    major_id =  '$major',
                                                    level_study = '$study_level',
                                                    year_level = '$year_level',
                                                    year_of_study = '$year_of_study' WHERE class_id ='". $update_id ."'");

            if($add_class == true){
                $_SESSION['ADD_DONE'] = 'Update class has completed.';
                header("Location:".SITEURL."master-data.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Update class has not completed.';
                header("Location:".SITEURL."master-data.php");
                exit(0);
            }
        }else{
            $_SESSION['REQUIRED'] = 'All fields are required.';
            header("Location:".SITEURL."manage-class.php");
            exit(0);
        }
    }elseif(isset($_POST['delete_class'])){
        $delete_id = $_POST['delete_id'];
        $delete = mysqli_query($conn, "DELETE FROM class WHERE class_id ='". $delete_id ."'");
        if($delete == true){
            $_SESSION['ADD_DONE'] = 'Delete class has completed.';
            header("Location:".SITEURL."manage-class.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Delete class has not completed.';
            header("Location:".SITEURL."manage-class.php");
            exit(0);
        }
    }

##############################
### Class end
##############################




##############################
### Semester start
##############################

    if(isset($_POST['save_semester'])){
        if(!empty($_POST['semester']) && !empty($_POST['start_semester']) && !empty($_POST['finish_semester']) && !empty($_POST['academy_year'])){
            $semester           = mysqli_real_escape_string($conn, $_POST['semester']);
            $start_semester     = mysqli_real_escape_string($conn, $_POST['start_semester']);
            $finish_semester    = mysqli_real_escape_string($conn, $_POST['finish_semester']);
            $year_study         = mysqli_real_escape_string($conn, $_POST['academy_year']);


            $add_semester       = mysqli_query($conn, "INSERT INTO year_of_study (semester, start_semester, finish_semester, year_of_study)
                                                        VALUES ('$semester', '$start_semester', '$finish_semester', '$year_study')");

            if($add_semester == true){
                $_SESSION['ADD_DONE'] = 'Add semester has completed.';
                header("Location:".SITEURL."manage-semester.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Add semester has not completed.';
                header("Location:".SITEURL."manage-semester.php");
                exit(0);
            }

        }else{
            $_SESSION['REQUIRED'] = 'All fields are required.';
            header("Location:".SITEURL."manage-semester.php");
            exit(0);
        }
    }elseif(isset($_POST['edit_semester'])){
        if(!empty($_POST['semester']) && !empty($_POST['start_semester']) && !empty($_POST['finish_semester']) && !empty($_POST['update_id']) && !empty($_POST['academy_year'])){
            $semester           = mysqli_real_escape_string($conn, $_POST['semester']);
            $start_semester     = mysqli_real_escape_string($conn, $_POST['start_semester']);
            $finish_semester    = mysqli_real_escape_string($conn, $_POST['finish_semester']);
            $year_study         = mysqli_real_escape_string($conn, $_POST['academy_year']);
            
            $edit_id            = $_POST['update_id'];


            $update_semester    = mysqli_query($conn, "UPDATE year_of_study SET
                                                    semester = '$semester', 
                                                    start_semester = '$start_semester', 
                                                    finish_semester = '$finish_semester',
                                                    year_of_study = '$year_study'
                                                    WHERE year_semester_id ='". $edit_id ."'");
            if($update_semester == true){
                $_SESSION['ADD_DONE'] = 'Update semester has completed.';
                header("Location:".SITEURL."manage-semester.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Update semester has not completed.';
                header("Location:".SITEURL."manage-semester.php");
                exit(0);
            }

        }else{
            $_SESSION['REQUIRED'] = 'All fields are required.';
            header("Location:".SITEURL."manage-semester.php");
            exit(0);
        }
    }elseif(isset($_POST['delete_semester'])){
        $delete_id = $_POST['delete_id'];
        $delete = mysqli_query($conn, "DELETE FROM year_of_study WHERE year_semester_id ='". $delete_id ."'");
        if($delete == true){
            $_SESSION['ADD_DONE'] = 'Delete semester has completed.';
            header("Location:".SITEURL."manage-semester.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Delete semester has not completed.';
            header("Location:".SITEURL."manage-semester.php");
            exit(0);
        }
    }


##############################
### Semester end
##############################



##############################
### Major start
##############################


    if(isset($_POST['save_major'])){
        if(!empty($_POST['major']) && !empty($_POST['department']) && !empty($_POST['major_code'])){
            $major = mysqli_real_escape_string($conn, $_POST['major']);
            $department = $_POST['department'];
            $major_code = mysqli_real_escape_string($conn, $_POST['major_code']);

            
            $add_major = mysqli_query($conn, "INSERT INTO major (major, department_id, major_code)
                                            VALUES ('$major', '$department', '$major_code')");

            if($add_major == true){
                $_SESSION['ADD_DONE'] = 'Add major has completed.';
                header("Location:".SITEURL."manage-major.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Add major has not completed.';
                header("Location:".SITEURL."manage-major.php");
                exit(0);
            }
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'All fields are required.';
            header("Location:".SITEURL."manage-major.php");
            exit(0);
        }
    }

    if(isset($_POST['update_major'])){
        if(!empty($_POST['major']) && !empty($_POST['department_id']) && !empty($_POST['update_id']) && !empty($_POST['major_code'])){
            $major = mysqli_real_escape_string($conn, $_POST['major']);
            $department = $_POST['department_id'];
            $update_id  = $_POST['update_id'];
            $major_code = $_POST['major_code'];

            
            
            $update_major = mysqli_query($conn, "UPDATE major SET
                                                major = '$major',
                                                department_id = '$department',
                                                major_code = '$major_code'
                                                WHERE major_id = '". $update_id ."'");
            if($update_major == true){

                $_SESSION['ADD_DONE'] = 'Update major has completed.';
                header("Location:".SITEURL."manage-major.php");
                exit(0);
            }else{

                $_SESSION['ADD_NOT_DONE'] = 'Update major has not completed.';
                header("Location:".SITEURL."manage-major.php");
                exit(0);
            }
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'All fields are required.';
            header("Location:".SITEURL."manage-major.php");
            exit(0);
        }
    }

    if(isset($_POST['delete_major'])){
        $delete_id = $_POST['delete_id'];
        $delete_major = mysqli_query($conn, "DELETE FROM major WHERE major_id ='". $delete_id ."'");
        if($delete_major == true){
            $_SESSION['ADD_DONE'] = 'Delete major has completed.';
            header("Location:".SITEURL."manage-major.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Delete major has not completed.';
            header("Location:".SITEURL."manage-major.php");
            exit(0);
        }
    }

##############################
### Major end
##############################



##############################
### Department start
##############################
    if(isset($_POST['save_department'])){
        if(!empty($_POST['department'])){
            $path = 'ims-assets/ims-images/';

            $department_code = mysqli_real_escape_string($conn, $_POST['department_code']);
            $department = mysqli_real_escape_string($conn, $_POST['department']);

            $logo       = $_FILES['department_logo']['name'];
            $logo_tmp = $_FILES['department_logo']['tmp_name'];
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $logo);


            $imageExtension = strtolower(end($imageExtension));
            $newImagename = uniqid();
            $newImagename .= '.'. $imageExtension;

            move_uploaded_file($logo_tmp, $path.'/'.$newImagename);

            if(file_exists($path.$old_profile) ){
                unlink($path.$old_profile);                    
            }




            $add_department = mysqli_query($conn, "INSERT INTO department (department, icon_name, department_code)
                                                    VALUES ('$department', '$newImagename', '$department_code')");
            if($add_department == true){
                $_SESSION['ADD_DONE'] = 'Add department has completed.';
                header("Location:".SITEURL."manage-department.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Add department has not completed.';
                header("Location:".SITEURL."manage-department.php");
                exit(0);
            }
        }else{
            $_SESSION['REQUIRED_DATA'] = 'Department is required.';
            header("Location:".SITEURL."manage-department.php");
            exit(0);
        }
    }


    if(isset($_POST['update_department'])){
        if(!empty($_POST['department']) && !empty($_POST['update_id']) && !empty($_POST['department_code'])){
            $department = mysqli_real_escape_string($conn, $_POST['department']);
            $department_code = mysqli_real_escape_string($conn, $_POST['department_code']);
            $update_id  = $_POST['update_id'];

            $old_logo   = mysqli_real_escape_string($conn, $_POST['old_logo']);

            $newImagename = '';
            $path = 'ims-assets/ims-images/';

            if(!empty($_FILES['department_logo']['name'])){

                $department_logo = $_FILES['department_logo']['name'];
                $department_logo_tmp = $_FILES['department_logo']['tmp_name'];
                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $department_logo);


                $imageExtension = strtolower(end($imageExtension));
                $newImagename = uniqid();
                $newImagename .= '.'. $imageExtension;

                move_uploaded_file($department_logo_tmp, $path.'/'.$newImagename);

                if(file_exists($path.$old_logo) ){
                    unlink($path.$old_logo);                    
                }
            
        }else{  
            $newImagename = $old_logo;
        }


            $update_department = mysqli_query($conn, "UPDATE department SET 
                                                    department = '$department',
                                                    department_code = '$department_code',
                                                    icon_name = '$newImagename'
                                                    WHERE department_id ='". $update_id ."'");
            if($update_department == true){
                $_SESSION['ADD_DONE'] = 'Update department has completed.';
                header("Location:".SITEURL."manage-department.php");
                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Update department has not completed.';
                header("Location:".SITEURL."manage-department.php");
                exit(0);
            }
        }else{
            $_SESSION['REQUIRED'] = 'Department is required.';
            header("Location:".SITEURL."manage-department.php");
            exit(0);
        }
    }

    if(isset($_POST['delete_department'])){
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        $delete_department = mysqli_query($conn, "DELETE FROM department WHERE department_id ='". $delete_id ."'");

        if($delete_department == true){
            $_SESSION['ADD_DONE'] = 'Delete department has completed.';
            header("Location:".SITEURL."manage-department.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Delete department has not completed.';
            header("Location:".SITEURL."manage-department.php");
            exit(0);
        }
    }
##############################
### Department end
##############################





##############################
### Room start
##############################

    if(isset($_POST['save_room'])){
        if(!empty($_POST['room'])){
            $room    = strtoupper(mysqli_real_escape_string($conn, $_POST['room']));
            $checkRoom = mysqli_query($conn, "SELECT * FROM room WHERE room ='". $room. "'");
            if(mysqli_num_rows($checkRoom) > 0){
                $_SESSION['ADD_NOT_DONE'] = 'Room has add already.';
                header("Location:". SITEURL. "manage-room.php");
                exit(0);

            }else{
                $add_room     = mysqli_query($conn, "INSERT INTO room (room) VALUES ('$room')");

                if($add_room == true){
                    $_SESSION['ADD_DONE'] = 'Add room has completed.';
                    header("Location:".SITEURL."manage-room.php");
                    exit(0);
                }else{
                    $_SESSION['ADD_NOT_DONE'] = 'Add room has not completed.';
                    header("Location:".SITEURL."manage-room.php");
                    exit(0);
                }
            }
        }else{
            $_SESSION['REQUIRED'] = 'Room is required.';
            header("Location:".SITEURL."manage-room.php");
            exit(0);
        }
    }elseif(isset($_POST['update_room'])){
        $update_id = $_POST['update_id'];
        if(!empty($_POST['room'])){
            $room    = strtoupper(mysqli_real_escape_string($conn, $_POST['room']));

            $update_room  = mysqli_query($conn, "UPDATE room SET room = '$room' WHERE id ='". $update_id ."'");

            if($update_room == true){
                $_SESSION['ADD_DONE'] = 'Update room has completed.';
                header("Location:".SITEURL."manage-room.php");

                exit(0);
            }else{
                $_SESSION['ADD_NOT_DONE'] = 'Update room has not completed.';
                header("Location:".SITEURL."manage-room.php");

                exit(0);
            }
        }else{
            $_SESSION['REQUIRED'] = 'Room is required.';
            header("Location:".SITEURL."manage-room.php");

            exit(0);
        }
    }elseif(isset($_POST['delete_room'])){
        $delete_id = $_POST['delete_id'];
        $delete = mysqli_query($conn, "DELETE FROM room WHERE id ='". $delete_id ."'");
        if($delete == true){
            $_SESSION['ADD_DONE'] = 'Delete class has completed.';
            header("Location:".SITEURL."manage-room.php");
            exit(0);
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Delete class has not completed.';
            header("Location:".SITEURL."manage-room.php");
            exit(0);
        }
    }

##############################
### Room end
##############################

?>