<?php
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    
    function filter(){
        if(isset($_POST['filter_schedule'])){
            $deparment_id = mysqli_real_escape_string($GLOBALS['conn'], $_POST['major']);
            // $year_of_study = mysqli_real_escape_string($GLOBALS['conn'], $_POST['year_of_study']);


            if(!empty($_POST['semester']) && !empty($_POST['year_level'])){

                $semester = mysqli_real_escape_string($GLOBALS['conn'], $_POST['semester']);
                $year_level = mysqli_real_escape_string($GLOBALS['conn'], $_POST['year_level']);


                $query = "SELECT * FROM schedule_study WHERE year_semester_id ='". $semester ."' AND year_level_id = '". $year_level ."' 
                        AND department_id ='". $deparment_id ."' ORDER BY day ASC";

                $query_run = mysqli_query($GLOBALS['conn'], $query);
                $row = mysqli_num_rows($query_run);
                    return($query_run);   
                    test();                      

            }
            
        }
    }


    function test(){
        if(isset($_POST['year'])){
            $year_data = $_POST['year'];
            return($year_data);
        }
        
    }

    function select_query_order($table, $order_by){
        $query = "SELECT * FROM $table ORDER BY $order_by ASC";
        $query_run = mysqli_query($GLOBALS['conn'], $query);

        if(mysqli_num_rows($query_run) > 0){
            return($query_run);

            // test();

        }else{
            return("No data found.");
        }
    }
?>