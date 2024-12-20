<?php
    session_start();


    // $php_file = basename($_SERVER['PHP_SELF']);
    date_default_timezone_set("Asia/Bangkok");

    // echo $php_file;
    // exit;
    
    // print_r($_SESSION);
    // exit;

    // URL and SYSTEM NAME

    // define('SITEURL', 'http://192.168.130.117/ims/');
    define('SITEURL', 'http://localhost/ims/');


    // define('SITEURL', 'https://192.168.67.172/ims/');
    // define('SITEURL', 'https://www.ims.ksit.edu.kh');

    


    /*
        ##########Test local 


        $useragent=$_SERVER['HTTP_USER_AGENT'];
        $pos = str_contains($useragent, 'Windows');

        if(str_contains($useragent, 'Windows')){
            // WHEN HOSTING "SITEURL" MUST CHANGE HERE.
            // define('SITEURL', 'http://localhost/ims/');
            define('SITEURL', 'https://192.168.0.101/ims/');

            
        }elseif(str_contains($useragent, 'iPhone')){
            define('SITEURL', 'https://192.168.0.101/ims/');
        }
        else{       
            define('SITEURL', 'https://192.168.0.101/ims/');
        }

    */

        

    // pagination define defualt data limit 
    // define('RESULT_PER_PAGE', '5');
    $result_per_page = 50;

    $delete_message_done = "Delete data has completed.";
    $delete_message_error = "Delete data has not completed.";

    $insert_message_done = "Insert data has completed.";
    $insert_message_error = "Insert data has not completed.";

    $update_message_done = "Update data has completed.";
    $update_message_error = "Update data has not completed.";


    // menu mange name 
    define('schedule', 'Time schedule');
    define('result', 'Result');
    define('course', 'Course description');
    define('request', 'Request letter');


    // profile manage title name 
    define('profile', 'My profile');
    define('family', 'Family information');
    define('education', 'Education background');

    // password title 
    define('ch-pass', 'Change your password');




    $ims_server = "localhost";    //Server Name
    $ims_user = "root";           //Server user
    $ims_pass = "";               // Server Password
    $ims_db_name = "db_ims";      //Server Database name

    // mysql function connect to DB 
    $conn = mysqli_connect($ims_server, $ims_user, $ims_pass, $ims_db_name);
    // Check if not connected to database 
    if($conn == false){
        die("Connection to databse fialed") . mysqli_connect_error();
    }
    mysqli_set_charset($conn, "UTF8");



###########################################
###  ADD YEAR SCRIPT START
###########################################
    $year_now = date("Y");
    $year_incre4 = intval($year_now) + 4;
    // echo $year_incre4;
    $select_year = mysqli_query($conn, "SELECT * FROM year WHERE year = '". $year_incre4 ."'");

    if(!mysqli_num_rows($select_year) > 0){
        for($i=1; $i<=4; $i++){
            $add_year = intval($year_now) + $i;
            $add_year = mysqli_query($conn, "INSERT INTO year (year) VALUES ('$add_year')");
        }
    }
###########################################
###  ADD YEAR SCRIPT END
###########################################




################################################
###  INCRESE YEAR LEVEL FOR EACH CLASS START
################################################

// គួរណាស់តែ កើនឡើងនៅពេលថ្ងៃបញ្ចប់ឆមាសទី ២ ឆ្នាំនីមួយៗ ត្រូវបានមកដល់

    if(!empty($_SESSION['CLASS_ID'])){
        $classID = $_SESSION['CLASS_ID'];
        $class_year_study = mysqli_query($conn, "SELECT * FROM class WHERE class_id = '". $classID ."'");
        if(mysqli_num_rows($class_year_study) > 0){
            $class_fetch = mysqli_fetch_assoc($class_year_study);
            $degree = $class_fetch['level_study'];
            $yearLevel = $class_fetch['year_level'];


            if($degree == 'Associate Degree'){
                // $checkSchedule = mysqli_query($conn, "SELECT * FROM schedule_study WHERE class_id ='". $classID ."' AND year_level = '2'");
                // if(mysqli_num_rows($checkSchedule) > 0){
                //     $checkScheduleFetch = mysqli_fetch_assoc($checkSchedule);

                //     $semesterID = $checkScheduleFetch['year_semester_id'];

                //     $finishSemester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id =". $semesterID ."'");
                //     if(mysqli_num_rows($finishSemester) > 0){
                //         $finishSemesterFetch = mysqli_fetch_assoc($finishSemester);

                //         $finishDate = $finishSemesterFetch['finish_semester'];

                //         if($yearLevel <= '2'){
                //             // if($finishDate == date('Y-m-d')){
                //             //     $new_year_level = $yearLevel+1;

                //             //     $update_year_level = mysqli_query($conn, "UPDATE class SET year_level = '$new_year_level'");

                //             // }else{
                //             //     echo 'No update';
                //             // }

                //             echo date('Y-m-d');
                //         }
                //     }else{
                //         echo 'No update';
                //     }

                // }

                $finishSemester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE semester = '2'");
                if(mysqli_num_rows($finishSemester) > 0){
                    

                    

                    if($yearLevel < '2'){
                        while($finishSemesterFetch = mysqli_fetch_assoc($finishSemester)){
                            $finishDate = $finishSemesterFetch['finish_semester'];

                            if($finishDate <= date('Y-m-d')){
                                $new_year_level = $yearLevel+1;

                                $update_year_level = mysqli_query($conn, "UPDATE class SET year_level = '$new_year_level' WHERE class_id = '". $classID ."'");

                            }else{
                                echo 'No update year level';
                            }
                        }
                        
                    }
                }

            }elseif($degree == "Bachelor's Degree"){
                $finishSemester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE semester = '2'");
                if(mysqli_num_rows($finishSemester) > 0){

                    if($yearLevel < '4'){
                        while($finishSemesterFetch = mysqli_fetch_assoc($finishSemester)){
                            $finishDate = $finishSemesterFetch['finish_semester'];

                            if($finishDate <= date('Y-m-d')){
                                $new_year_level = $yearLevel+1;

                                $update_year_level = mysqli_query($conn, "UPDATE class SET year_level = '$new_year_level' WHERE class_id = '". $classID ."'");

                            }else{
                                echo 'No update year level';
                            }
                        }
                        
                    }
                }
            }
        }

    }

    // $class_year_study = mysqli_query($conn, "SELECT * FROM class");
    // while($class_year_study_data = mysqli_fetch_assoc($class_year_study)){
    //     $year_level = $class_year_study_data['year_level'];

    //     if($year_now > $class_year_study_data['year_of_study']){
    //         $new_year_level = $year_level+1;

    //         $update_year_level = mysqli_query($conn, "UPDATE class SET year_level = '$new_year_level'");
    //     }
    // }




################################################
###  INCRESE YEAR LEVEL FOR EACH CLASS END
################################################
    // echo date("d-m-Y:h:m:s");



################################################
###  SCRIPT UPDATE SEMESTER STATUS
################################################

    $semesterQuery = mysqli_query($conn, "SELECT * FROM year_of_study");
    if(mysqli_num_rows($semesterQuery) > 0){
        $date_now = date('Y-m-d');
        while($semester_data = mysqli_fetch_assoc($semesterQuery)){

            $finish_semester = $semester_data['finish_semester'];
            if( $date_now > $finish_semester){
                // echo ' update | ';
                
                $update_status = mysqli_query($conn, "UPDATE year_of_study SET status = '0' WHERE finish_semester < '". $date_now ."'");

            }
        }
    }

################################################
###  SCRIPT UPDATE SEMESTER STATUS END
################################################



// logo 
    $system_logo = '';
    $system_name = '';

    $system_logo_qry = mysqli_query($conn, "SELECT * FROM logo");
    if(mysqli_num_rows($system_logo_qry) > 0){
        $logo_qry_fetch = mysqli_fetch_assoc($system_logo_qry);
        $system_logo = $logo_qry_fetch['logo_name'];
        $system_name = $logo_qry_fetch['system_name'];
    }

    define('systemname', ucwords($system_name));



// color 
    $system_header_footer = '';
    $system_sidebar = '';

    $system_color_qry = mysqli_query($conn, "SELECT * FROM theme_color");
    if(mysqli_num_rows($system_color_qry) > 0){
        $system_color_fetch = mysqli_fetch_assoc($system_color_qry);
        $system_header_footer = $system_color_fetch['color_header_footer'];
        $system_sidebar = $system_color_fetch['color_sidebar'];
    }
?>