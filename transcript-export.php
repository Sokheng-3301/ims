<?php
    #DB connection
    require_once('ims-db-connection.php');
    require_once('vendor/autoload.php');

    use Dompdf\Dompdf;
    use Dompdf\Options;


    // $Option = new Options();
    // $Option -> set('chroot', realpath(''));
    // $dompdf = new Dompdf($Option);


    ############ EXPORT STUDENT LIST IN CLASS ##############
    if(isset($_GET['class'])){
        $class_id = $_GET['class'];
        $student_query = mysqli_query($conn, "SELECT * FROM student_info 
                                            INNER JOIN class ON student_info.class_id = class.class_id
                                            INNER JOIN major ON class.major_id = major.major_id
                                            INNER JOIN department ON major.department_id = department.department_id
                                            WHERE student_info.class_id ='". $class_id ."'");
        if(mysqli_num_rows($student_query) > 0){

            $count_student = mysqli_num_rows($student_query);
            $student_result = mysqli_fetch_assoc($student_query);
            $class_code = $student_result['class_code'];
            $department = $student_result['department'];
            $major      = $student_result['major'];
            $study_level = $student_result['level_study'];
            $year_level = $student_result['year_level'];
            $academy_year = $student_result['year_of_study'];


            
            $html = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <style>
                            @font-face {
                                font-family: "Noto Sans Khmer";
                                src: url(../ims-font/fonts/NotoSansKhmer-VariableFont_wdth\,wght.ttf) format("truetype");
                            }
                            @font-face {
                                font-family: "Poppins";
                                src: url(../ims-font/fonts/Poppins-Regular.ttf) format("truetype");
                            }

                            *{
                                font-family: "Poppins", "Noto Sans Khmer", sans-serif;
                                box-sizing: border-box;
                                padding: 0;
                                margin: 0;
                                text-decoration: none;
                                transition: all 0.2s;
                                font-size: 10px;
                            }

                            #flex{
                                width: 100%;
                                display: flex;
                                flex-direction: row;   
                            }
                            .block{
                                width: fit-content;
                                display: block;
                                float: left;
                            }
                            .block:last-child{
                                float: right;
                            }
                            
                            h1{
                                font-size: 18px;
                                text-align: center;
                                margin: 10px auto;
                                margin-bottom: 20px;
                                padding-bottom: 10px;
                                border-bottom: 1px solid lightgray;
                                
                            }
                           

                            p{
                                font-size: 14px;
                                margin: 3px 0;
                                width: fit-content;
                            }
                            .clear{
                                float: unset;
                                clear: both;
                            }
                            .table_container{
                                padding: 30px;
                            }
                            table{
                                width: 100%;
                                border-collapse: collapse;   
                                margin: 20px 0;
                            }
                            table tr th{
                                background-color: lightgray;
                            }
                            table tr th,
                            table tr td{
                                padding: 5px;
                                border: 1px solid gray;
                                text-align: left;

                            }
                            table .score{
                                width: 40px;
                                text-align: center;
                            }
                            table .date{
                                text-align: center;
                                width: 70px;
                            }
                            table .gender{
                                width: 40px;
                            }
                            table .id{
                                text-align: center;
                            }
                            .note{
                                width: fit-content;
                                display: block;
                                float: right;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <div class = "table_container">
                            <h1>Export student list in class</h1>
                            <div id="flex">
                                <div class="block">
                                    <p>Class: '.$class_code.' </p>
                                    <p>Department: '.$department.'</p>
                                    <p>Major: '.$major.'</p>
                                    <p>Total student: '.$count_student.'</p>                                   
                                </div>

                                <div class="block">
                                    <p>Study level: '.$study_level.'</p>
                                    <p>Year level: '.$year_level.'</p>
                                    <p>Academy year: '.$academy_year.'</p>
                                </div>
                            </div>
                            <div class = "clear"></div>

                            <table>
                                <tr>
                                    <th class="id">No</th>
                                    <th>Student ID</th>
                                    <th>Fullname (KH)</th>
                                    <th>Fullname (EN)</th>
                                    <th class="gender">Gender</th>
                                    <th>Date of birth</th>
                                    <th class="score">Other</th>
                                </tr>';
            $i = 1;
            while($row = mysqli_fetch_assoc($student_query)){
                
                $html .= '<tr>';
                $html .= '<td class="id">'.$i++.'</td>
                        <td>'.$row["student_id"].'</td>
                        <td>'.$row["fn_khmer"]. " " .$row['ln_khmer'].'</td>
                        <td>'.$row["firstname"]. " " .$row['lastname'].'</td>
                        <td class="gender">'.$row["gender"].'</td>
                        <td class="date">'.$row["birth_date"].'</td>
                        <td class="score"> </td>';
                $html .= '</tr>';
                // $i++;
            }

            $dompdf = new Dompdf;
            $dompdf -> loadHtml($html);
            $dompdf -> setPaper('A4', 'portrait');
            $dompdf -> render();
            $dompdf -> stream('export-pdf-for-'.$class_code.'.pdf');
            mysqli_close($conn);
            exit;

        }        
    }




    ############ EXPORT TRANSCIPT ##############
    if(isset($_GET['id'])){
        // 
        $date = date('d-M-Y');
        $id = $_GET['id'];
        $student_sql = mysqli_query($conn, "SELECT * FROM student_info 
                                            -- INNER JOIN student_sibling ON student_info.student_id = student_sibling.student_id
                                            -- INNER JOIN background_education ON student_info.student_id = background_education.student_id
                                            INNER JOIN class ON student_info.class_id = class.class_id
                                            INNER JOIN major ON class.major_id = major.major_id
                                            INNER JOIN department ON major.department_id = department.department_id
                                            -- INNER JOIN schedule_study ON class.class_id = schedule_study.class_id
                                            WHERE student_info.id = '". $id ."'");
        $transcript = '';
                                    
        $total = 0;
        $count_n = 1;
        if(mysqli_num_rows($student_sql) > 0){
            $student_info = mysqli_fetch_assoc($student_sql);
            $student_id = $student_info['student_id'];
            $class_id = $student_info['class_id'];

            // while($data = mysqli_fetch_assoc($student_info)){
            //     print_r($data);
            // }

           

            $transcript='
           
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="shortcut icon" href="ims-assets/ims-images/export-logo.jpg" type="image/x-icon">
                        <title>IMS | Export transcript</title>
                        <style>
                            @font-face {
                                font-family: "Noto Sans Khmer";
                                src: url(../ims-font/fonts/NotoSansKhmer-VariableFont_wdth\,wght.ttf) format("truetype");
                            }
                            @font-face {
                                font-family: "Poppins";
                                src: url(../ims-font/fonts/Poppins-Regular.ttf) format("truetype");
                            }

                            *{
                                font-family: "Popins", "Noto Sans Khmer", sans-serif;
                                box-sizing: border-box;
                                padding: 0;
                                margin: 0;
                                text-decoration: none;
                                transition: all 0.2s;
                                color: #003666;
                                border-collapse: collapse;
                            }
                            .container{
                                padding: 2% 3.5%;
                                display: block;
                                width: 100%;
                            }
                            table th,
                            table td{
                                padding: 5px 20px;
                            }
                            
                            .top{
                                text-align: center;
                            }
                            .top h1{
                                font-size: 100%;
                            }
                            .top h2{
                                font-size: 90%;
                            }
                            img.tacteing{
                                width: 12%;
                            }
                            .logo-top{
                                margin-top: -2%;
                                width: fit-content;
                            }
                            .logo-top .center{
                                width: 33%;
                                font-weight: bold;
                            }
                            .logo-top img{
                                width: 25%;
                                display: block;
                                margin: auto;
                                margin-left: 25%;
                            }
                            .logo-top .line{
                                width: 80%;
                                display: inline-block;
                            }


                            .logo-top .line p.left{
                                float: left;
                            }
                            .logo-top  .line p.right{
                                float: right;
                            }

                            .clear{
                                float: unset;
                                clear: both;
                            }

                            .content{
                                margin-top: 20px;
                            }
                            .content h2{
                                text-transform: uppercase;
                                text-align: center;
                                font-size: 90%;
                                margin-bottom: 1%;
                            }

                            .content .d-flex{
                                margin-bottom: 1%;
                            }

                            .content .d-flex .part-left{
                                width: 50%;
                                float: left;
                                font-size: 80%;
                            }
                            .content .d-flex .part-right{
                                width: 50%;
                                float: right;
                                font-size: 80%;

                            }
                            .content .d-flex .part-right p,
                            .content .d-flex .part-left p{
                                line-height: 25px;
                                display: flex;

                            }

                            .content .d-flex .part-right p span.title,
                            .content .d-flex .part-left p span.title
                            {
                                width: 28%;
                                display: inline-block;
                            }
                            .content .d-flex .part-right p span.value,
                            .content .d-flex .part-left p span.value{
                                display: inline-block;
                                margin-left: 5%;
                                width: 67%%;
                                display: inline-block;
                            }






                            .content .section{
                                width: 50%;
                                float: left;
                            }
                            .content .section table.fixed_height{
                                width: 100%;
                                border: 1px solid #003666;
                                font-size: 80%;
                                text-align: start;
                                height: 500px;

                            }
                                .content .section table.no_left{
                                    border-left: 0;
                                }
                            
                            .content .section table th,
                            .content .section table td{
                                padding:0.5% 1%;
                                text-align: left;
                                font-size: 90%;
                            }
                            .content .section table thead th{
                                border-bottom: 1px solid #003666;            
                            }
                            .content .section table td.title{
                                font-size: 90%;
                                font-weight: bold;
                                text-decoration: underline;
                                padding: 0.7% 3%;
                            }
                            .content .section table td.text-center{
                                text-align: center;
                            }


                            .content .table-bottom{
                                width: 40%;
                                float: left;
                                margin-top: 2%;
                                font-size: 60%;

                            }
                            .content .table-bottom table{
                                width: 100%;
                                text-align: start;
                                border: 1px solid #003666;
                            }
                            .content .table-bottom table th,
                            .content .table-bottom table td{
                                text-align: start;
                                padding: 0.5% 2%;
                                border: 1px solid #003666;
                            }
                            .content .table-bottom table th.text-center{
                                text-align: center;
                            }
                            .text-center{
                                 text-align: center;
                            }
                            .content .table-bottom table td.text-center{
                               
                            }
                            .content .table-bottom table td span{
                                padding: 0 2%;
                                width: 3%;
                                display: inline;
                            }
                            .content .table-bottom table td{
                                border: unset;
                                border-right:  1px solid #003666;
                            }
                            .content .sign-right{
                                margin-top: 1%;
                                width: 60%;
                                height: auto;
                                text-align: center;
                                float: right;
                            }
                            .content .sign-right p.director{
                                font-weight: bold;
                            }
                            .content .sign-right p.signature{
                                margin-top: 15%;
                                font-weight: bold;
                                margin-left: 20%;
                            }
                            footer{
                                border-top: 1px solid #003666;
                                width: 100%;
                                margin-top: 2%;
                                padding: 1% 0;
                                text-align: center;
                                font-size: 90%;
                            }
                            footer p{
                                font-size: 12px;
                            }
                            .text{
                                font-size: 10px;
                            }
                                
                        </style>

                    </head>
                    <body>
                        <div class="container">
                            <div class="top">
                                <h1>Kingdom of Cambodia</h1>
                                <h2>Nation Relegion King</h2>
                                <p><img src="ims-assets/ims-images/bottom.jpg" class="tacteing" alt=""></p>
                            </div>
                            <div class="logo-top">
                            <div class="center">
                                    <p><img src="ims-assets/ims-images/export-logo.jpg" alt=""></p>
                                    <p class="text">Kampong Speu Institute of Technology</p>
                                    <div class="line text">
                                        <p class="left">No.</p> <p class="right">KSIT</p></p>    
                                        
                                    </div>
                                    <div class="clear"></div>  
                                </div>     
                            </div>
                            <div class="content">
                                <h2>Official academic transcript</h2>
                                <div class="d-flex">
                                    <div class="part-left">
                                        <p><span class="title">Name</span> <span>:</span> <span class="value">'.$student_info["firstname"]." ". $student_info["lastname"].'</span></p>
                                        <p><span class="title">Student ID</span> <span>:</span> <span class="value">'.$student_info["student_id"].'</span></p>
                                        <p><span class="title">Nationality</span> <span>:</span> <span class="value">'.$student_info["nationality"].'</span></p>
                                        <p><span class="title">Date of Birth  </span> <span>:</span> <span class="value">'.$student_info["birth_date"].'</span></p>
                                        <p><span class="title">Place of Birth  </span> <span>:</span> <span class="value">'.$student_info["place_of_birth"].'</span></p>
                                    </div>
                                    <div class="part-right">
                                        <p><span class="title">Department</span> <span>:</span> <span class="value">'.$student_info["department"].'</span></p>
                                        <p><span class="title">Degree</span> <span>:</span> <span class="value">Associate in '.$student_info["major"].' </span></p>
                                        <p><span class="title">Major subject</span> <span>:</span> <span class="value">'.$student_info["major"].'</span></p>

                                        <p><span class="title">Date of Admission  </span> <span>:</span> <span class="value"></span></p>
                                        <p><span class="title">Date of Graduation  </span> <span>:</span> <span class="value"></span></p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            
                                <div class ="d-flex" style ="padding: 0 55px 0 0;">
                                    <div class="section">
                                        <table class="fixed_height">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Subject</th>
                                                    <th>Credit</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="title">
                                                <td class="title">First year</td>
                                                <td class="title" colspan="3">1st Semester</td>
                                            </tr>';
                                            


                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                
                                                                                INNER JOIN student_info ON schedule_study.class_id = student_info.class_id
                                
                                
                                                                                WHERE schedule_study.year_level = '1' 
                                                                                AND schedule_study.class_id ='". $class_id ."' 
                                                                                AND year_of_study.semester = '1'
                                                                                AND student_info.id ='". $id."'");
                                    
                                                    if(mysqli_num_rows($first_semester_year) > 0){
                                                        $count_n = mysqli_num_rows($first_semester_year);

                                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){


                                                            $transcript .= '<tr>';

                                                                $transcript .= '<td>'.$result_data["subject_code"].'</td>
                                                                                <td>'.$result_data["subject_name"].'</td>
                                                                                <td>'.$result_data["credit"].'('.$result_data["theory"].'.'. $result_data["execute"].'.'.$result_data["apply"].')</td>';
                                                                $transcript .= '<td class="last">';
                                                
                                                                                $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                            INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                            WHERE score.student_id ='". $student_id ."' 
                                                                                                            AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                            AND score_submitted.submit_status ='1'");
                                                
                                                                                if(mysqli_num_rows($grade) > 0){
                                                                                    $grade_data = mysqli_fetch_assoc($grade);
                                                                                    echo $grade_data["grade"];
                                                                                }                                                                                
                                                                $transcript .= '</td>';
                                                            $transcript .= '</tr>';
                                        
                                                        }
                                                    }
                                                    $transcript .= '<tr>
                                                                        <td colspan="2" class="title text-center">Grade Point Average</td>
                                                                        <td colspan="2" class="title text-center">'.$total/$count_n.'</td>
                                                                    </tr>';


                                                    $transcript .= '<tr>
                                                                        <td class="title">First year</td>
                                                                        <td class="title" colspan="3">2nd Semester</td>
                                                                    </tr>';

                                                                    $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                                                INNER JOIN student_info ON schedule_study.class_id = student_info.class_id
                                                                
                                                                
                                                                                                                WHERE schedule_study.year_level = '1' 
                                                                                                                AND schedule_study.class_id ='". $class_id ."' 
                                                                                                                AND year_of_study.semester = '2'
                                                                                                                AND schedule_study.done_status = '1'
                                                                                                                AND student_info.id ='". $id."'");
                        
                                        if(mysqli_num_rows($first_semester_year) > 0){
                                            $count_n = mysqli_num_rows($first_semester_year);

                                            while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                                $subject_type = $result_data['type_name'];

                                                $transcript .= '<tr>';

                                                    $transcript .= '<td>'.$result_data["subject_code"].'</td>
                                                                    <td>'.$result_data["subject_name"].'</td>
                                                                    <td>'.$result_data["credit"].'('.$result_data["theory"].'.'. $result_data["execute"].'.'.$result_data["apply"].')</td>';
                                                    $transcript .= '<td class="last">';
                                    
                                                                    $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                WHERE score.student_id ='". $student_id ."' 
                                                                                                AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                AND score_submitted.submit_status ='2'");
                                    
                                                                    if(mysqli_num_rows($grade) > 0){
                                                                        $grade_data = mysqli_fetch_assoc($grade);
                                                                        if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                                            $total_grade = $grade_data['s_u'];
                                                                        }else{

                                                                            $total_grade = $grade_data["grade"];
                                                                        }

                                                                    }                                                                                
                                                    $transcript .=  $total_grade. '</td>';
                                                $transcript .= '</tr>';
                            
                                            }
                                        }
                                        $transcript .= '<tr>
                                                            <td colspan="2" class="title text-center">Grade Point Average</td>
                                                            <td colspan="2" class="title text-center">'.$total/$count_n.'</td>
                                                        </tr> </tbody>';



                                            
                                    $transcript .='</table>    
                                    </div>


                                    <div class="section">
                                        <table class="fixed_height no_left">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Subject</th>
                                                    <th>Credit</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tr class="title">
                                                <td class="title">Second year</td>
                                                <td class="title" colspan="3">1st Semester</td>
                                            </tr>';


                                            
                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                    
                                                                    INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                    WHERE schedule_study.year_level = '2' 
                                                                    AND schedule_study.class_id ='". $class_id ."' 
                                                                    AND year_of_study.semester = '1'
                                                                    AND student_info.id ='". $id."'");

                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                $count_n = mysqli_num_rows($first_semester_year);

                                                while($result_data = mysqli_fetch_assoc($first_semester_year)){


                                                    $transcript .= '<tr>';

                                                        $transcript .= '<td>'.$result_data["subject_code"].'</td>
                                                                        <td>'.$result_data["subject_name"].'</td>
                                                                        <td>'.$result_data["credit"].'('.$result_data["theory"].'.'. $result_data["execute"].'.'.$result_data["apply"].')</td>';
                                                        $transcript .= '<td class="last">';
                                        
                                                                        $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                    INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                    WHERE score.student_id ='". $student_id ."' 
                                                                                                    AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                    AND score_submitted.submit_status ='1'");
                                        
                                                                        if(mysqli_num_rows($grade) > 0){
                                                                            $grade_data = mysqli_fetch_assoc($grade);
                                                                            echo $grade_data["grade"];
                                                                        }                                                                                
                                                        $transcript .= '</td>';
                                                    $transcript .= '</tr>';
                                
                                                }
                                            }
                                            $transcript .= '<tr>
                                                                <td colspan="2" class="title text-center">Grade Point Average</td>
                                                                <td colspan="2" class="title text-center">'.$total/$count_n.'</td>
                                                            </tr>';


                                            $transcript .= '<tr>
                                                                <td class="title">Second year</td>
                                                                <td class="title" colspan="3">2nd Semester</td>
                                                            </tr>';

                                                            $first_semester_year = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                                        INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                        INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                        
                                                                        INNER JOIN student_info ON schedule_study.class_id = student_info.class_id


                                                                        WHERE schedule_study.year_level = '2' 
                                                                        AND schedule_study.class_id ='". $class_id ."' 
                                                                        AND year_of_study.semester = '2'
                                                                        AND student_info.id ='". $id."'");

                                                            if(mysqli_num_rows($first_semester_year) > 0){
                                                                    $count_n = mysqli_num_rows($first_semester_year);

                                                                    while($result_data = mysqli_fetch_assoc($first_semester_year)){


                                                                        $transcript .= '<tr>';

                                                                            $transcript .= '<td>'.$result_data["subject_code"].'</td>
                                                                                            <td>'.$result_data["subject_name"].'</td>
                                                                                            <td>'.$result_data["credit"].'('.$result_data["theory"].'.'. $result_data["execute"].'.'.$result_data["apply"].')</td>';
                                                                            $transcript .= '<td class="last">';

                                                                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                                                                        AND score_submitted.submit_status ='1'");

                                                                                            if(mysqli_num_rows($grade) > 0){
                                                                                                $grade_data = mysqli_fetch_assoc($grade);
                                                                                                echo $grade_data["grade"];
                                                                                            }                                                                                
                                                                            $transcript .= '</td>';
                                                                        $transcript .= '</tr>';

                                                                    }
                                                                }
                                    $transcript .= '<tr>
                                                        <td colspan="2" class="title text-center">Grade Point Average</td>
                                                        <td colspan="2" class="title text-center">'.$total/$count_n.'</td>
                                                    </tr>';



                                        

                                        $transcript .='</table>    
                                    </div>
                                </div>

                                <div class="clear"></div>
                            
                                <div class="table-bottom">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="text-center">Grade</th>
                                                <th colspan="2" class="text-center">Mention</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">A</td>
                                                <td><span>4.0</span> <span>85-100</span> <span>Excellent</span></td>
                                                <td>S = Satisfactory</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">B+</td>
                                                <td><span>3.50</span> <span>80-84</span> <span>Very Good</span></td>
                                                <td>I = Incomplete</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">B</td>
                                                <td><span>3.00</span> <span>70-79</span> <span>Good</span></td>
                                                <td>U = Unsatisfactory</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">C+</td>
                                                <td><span>2.50</span> <span>65-69</span> <span>Fairly Good</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">C</td>
                                                <td><span>2.00</span> <span>50-64</span> <span>Fair</span></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">D</td>
                                                <td><span>1.50</span> <span>45-49</span> <span>Poor</span></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">E</td>
                                                <td><span>1.00</span> <span>40-44</span> <span>Very poor</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">F</td>
                                                <td><span>0.00</span> <span><40</span> <span>Failure</span></td>
                                                <td></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="sign-right">
                                    <p>Kampong Spue, '.$date.'</p>
                                    <p class="director">Director</p>
                                    <p class="signature">HONG Kimcheang,PhD</p>
                                </div>
                                <div class="clear"></div>
                            </div> 
                            <div class="clear"></div>
                            <div style ="padding: 0 55px 0 0";>
                                <footer>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, soluta.</p>
                                </footer>
                            </div>
                            <div class="clear"></div>
                        </div>
                        
                    </body>
                </html>
    
                        ';

          
                                                    
        

            $option = new Options();
            $option -> set('chroot', realpath(''));
            $dompdf = new Dompdf($option);
            $dompdf -> loadHtml($transcript);
            $dompdf -> setPaper('A4', 'portrait');
            $dompdf -> render();
            $dompdf -> stream('export-pdf.pdf', array("Attachment" => false));
            mysqli_close($conn);
            exit;

        }else{
            $transcript = 'No transcript';
        }
    }


























    // ############ EXPORT STUDENT INFORMATION ##############
    // if(isset($_GET['info-id'])){
    //     // echo 'info';
    //     $id = $_GET['info-id'];

    //     $student_info = mysqli_query($conn, "SELECT * FROM student_info WHERE id ='". $id ."'");
    //     if(mysqli_num_rows($student_info) > 0){
    //         $student_info_result = mysqli_fetch_assoc($student_info);
            

    //         $html = '
    //         <!DOCTYPE html>
    //     <html lang="en">
    //     <head>
    //         <meta charset="UTF-8">
    //         <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //         <link rel="shortcut icon" href="ims-assets/ims-images/export-logo.jpg" type="image/x-icon">
    //         <title>IMS | Print profile</title>

    //         <style>
    //             @font-face {
    //                 font-family: "Noto Sans Khmer";
    //                 src: url(../ims-font/fonts/NotoSansKhmer-VariableFont_wdth\,wght.ttf) format("truetype");
    //             }
    //             @font-face {
    //                 font-family: "Poppins";
    //                 src: url(../ims-font/fonts/Poppins-Regular.ttf) format("truetype");
    //             }

    //             *{
    //                 font-family: "Poppins", "Noto Sans Khmer", sans-serif;
    //                 box-sizing: border-box;
    //                 padding: 0;
    //                 margin: 0;
    //                 text-decoration: none;
    //                 transition: all 0.2s;
    //                 color: #224a8a;
    //                 border-collapse: collapse;
    //             }
    //             body{
    //                 padding: 15px;
    //             }
    //             .header img{
    //                 width: 6%;
    //                 display: block;
    //                 margin: auto;
    //             }.content h2{
    //                 padding: 0 0 10px 0;
    //                 border-bottom: 1px solid #224a8a;
    //                 font-size: 100%;
    //             }.content .float{
    //                 float: left;
    //                 width: 50%;
    //                 padding: 10px 0;
    //             }
    //             .content .float p{
    //                 display: inline-block;
    //                 width: 100%;
    //             }
    //             .content .float span.title{
    //                 width: 160px;
    //                 /* padding: 0 50px; */
    //                 display: inline-block;
    //             }
    //             .content .float span.value{
    //                 padding-right: 15px;
    //             }
    //             .content .table-content table{
    //                 width: 100%;
    //                 text-align: start;
    //                 margin: 15px 0;
    //             }
    //             .content .table-content table th,
    //             .content .table-content table td{
    //                 border: 1px solid #224a8a;
    //                 text-align: start;
    //                 padding: 5px 10px;
    //                 font-weight: normal;
    //             }

    //         </style>

    //     </head>
    //     <body>
    //         <div class="header">
    //             <img src="ims-assets/ims-images/export-logo.jpg" alt="">
    //         </div>
    //         <div class="content">
    //             <h2>ព័ត៌មានផ្ទាល់ខ្លួនរបស់និស្សិត</h2>

    //             <div class="float">
    //                 <p><span class="title">គោត្តនាម និងនាម</span><span class="value">:</span> - </p>
    //                 <p><span class="title">អក្សរឡាតាំង</span><span class="value">:</span > - </p>

    //                 <p><span class="title">អត្តលេខនិស្សិត</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ភេទ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">ថ្ងៃខែឆ្នាំកំណើត</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ជនជាតិ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">សញ្ជាតិ</span><span class="value">:</span> - </p>
    //             </div>

    //             <div class="float">
    //                 <p><span class="title">កម្រិតសិក្សា</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ដេប៉ាតឺម៉ង់</span><span class="value">:</span > - </p>

    //                 <p><span class="title">ជំនាញសិក្សា</span><span class="value">:</span> - </p>
    //                 <p><span class="title">លេខទូរស័ព្ទ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">អ៊ីម៊ែល</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ទីកន្លែងកំណើត</span><span class="value">:</span > - </p>

    //                 <p><span class="title">ទីកន្លែងបច្ចុប្បន្ន</span><span class="value">:</span> - </p>
    //             </div>

    //             <h2>ប្រវត្តិការសិក្សា</h2>
    //             <div class="table-content">
    //                 <table>
    //                     <thead>
    //                         <tr>
    //                             <th>កម្រិតថ្នាក់</th>
    //                             <th>ឈ្មោះសាលារៀន</th>
    //                             <th>ខេត្ត/រាជធានី</th>
    //                             <th>ពីឆ្នាំណាដល់ឆ្នាំណា</th>
    //                             <th>សញ្ញាបត្រទទួលបាន</th>
    //                             <th>និទ្ទេសរួម</th>
    //                         </tr>
    //                     </thead>
    //                     <tbody>
    //                         <tr>
    //                             <td>បឋមសិក្សា</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                         <tr>
    //                             <td>បឋមភូមិ</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                         <tr>
    //                             <td>ទុតិយភូមិ</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                     </tbody>
    //                 </table>
    //             </div>


    //             <h2>ព័ត៌មានគ្រួសារ</h2>

    //             <div class="float">
    //                 <p><span class="title">ឈ្មោះឪពុក</span><span class="value">:</span> - </p>
    //                 <p><span class="title">អាយុឪពុក</span><span class="value">:</span > - </p>

    //                 <p><span class="title">មុខរបរឪពុក</span><span class="value">:</span> - </p>
    //                 <p><span class="title">លេខទូរស័ព្ទ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">ទីកន្លែងបច្ចុប្បន្នឪពុក</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ចំនួនបងប្អូនបង្កើត</span><span class="value">:</span > - </p>
    //             </div>

    //             <div class="float">
    //                 <p><span class="title">ឈ្មោះម្តាយ</span><span class="value">:</span> - </p>
    //                 <p><span class="title">អាយុម្តាយ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">មុខរបរម្តាយ</span><span class="value">:</span> - </p>
    //                 <p><span class="title">លេខទូរស័ព្ទ</span><span class="value">:</span > - </p>

    //                 <p><span class="title">ទីកន្លែងបច្ចុប្បន្នម្តាយ</span><span class="value">:</span> - </p>
    //                 <p><span class="title">ចំនួនបងប្អូនស្រី</span><span class="value">:</span > - </p>
    //             </div>



    //             <div class="table-content">
    //                 <table>
    //                     <thead>
    //                         <tr>
    //                             <th>ឈ្មោះបងប្អូន</th>
    //                             <th>ភេទ</th>
    //                             <th>ថ្ងៃខែឆ្នាំកំណើត</th>
    //                             <th>មុខរបរ</th>
    //                             <th>អាសយដ្ឋាន</th>
    //                             <th>លេខទូរស័ព្ទ</th>
    //                         </tr>
    //                     </thead>
    //                     <tbody>
    //                         <tr>
    //                             <td>បឋមសិក្សា</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                         <tr>
    //                             <td>បឋមភូមិ</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                         <tr>
    //                             <td>ទុតិយភូមិ</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                             <td>-</td>
    //                         </tr>
    //                     </tbody>
    //                 </table>
    //             </div>
    //         </div>
    //     </body>
    //     </html>
    //                 ';


    //         $myHTML = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

    //         $option = new Options();
    //         $option -> set('chroot', realpath(''));

    //         $option -> setChroot(__DIR__);

    //         // $option -> setDefaultFont('Noto Sans Khmer');
    //         $option->setIsRemoteEnabled(true);
    //         $option->setIsFontSubsettingEnabled(true);

    //         $dompdf = new Dompdf($option);  
            
            
    //         $dompdf -> loadHtml($myHTML);
    //         $dompdf -> setPaper('A4', 'portrait');
    //         $dompdf -> render();
    //         $dompdf -> stream('export-pdf-for.pdf',  ['Attachment' => false]);


    //         // Register the Khmer font
    //         $dompdf->getCanvas()->get_cpdf()->addFont('Noto Sans Khmer', '', 'NotoSansKhmer-VariableFont_wdth\,wght.ttf');

    //         mysqli_close($conn);
    //         exit;                       
    //     }
    // }


?>