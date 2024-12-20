<?php
    #DB connection
    require_once('ims-db-connection.php');
    require_once('vendor/autoload.php');

    use Dompdf\Dompdf;


    // if(empty($_GET['subject'])){
    //     header("location:".SITEURL."score-submitted.php");
    //     exit(0);
    // }
    
    if(isset(($_GET['subject']))){
        $schedule_id= $_GET['subject'];
        $schedule_check = mysqli_query($conn, "SELECT * FROM schedule_study 
                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                INNER JOIN class ON schedule_study.class_id = class.class_id
                                                INNER JOIN major ON class.major_id = major.major_id
                                                INNER JOIN department ON major.department_id = department.department_id
                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                WHERE schedule_id='". $schedule_id ."'");



        if(!mysqli_num_rows($schedule_check) >  0){
            header("location:".SITEURL."score-submitted.php");
            exit(0);

        }else{
            $data = mysqli_fetch_assoc($schedule_check);
            $class_id = $data['class_id'];

            $subject_code = $data['subject_code'];
            $subject_name = $data['subject_name'];
            $credit = $data['credit']."(".$data['theory'].".".$data['execute'].".".$data['apply'].")";
            $teacher_name = $data['fn_en']. " " .$data['ln_en'];


            $department =    $data['department'];
            $major =         $data['major'];
            $level =         ($data['level_study'] == 'បរិញ្ញាបត្រ') ? 'Bachelor Degree' : 'Associated Degree';
            $year_level =    $data['year_level'];
            $year_of_study = $data['year_of_study'];
            $semester      = $data['semester'];

            
        }
        $count_student = mysqli_query($conn, "SELECT * FROM score WHERE schedule_id ='". $schedule_id ."'");
        $count_student = mysqli_num_rows($count_student);

        // echo 'PDF Generate';



        $score_list = mysqli_query($conn, "SELECT * FROM score
                                            INNER JOIN student_info ON score.student_id = student_info.student_id
                                            WHERE schedule_id ='". $schedule_id ."' ORDER BY total_score ASC");
        if(mysqli_num_rows($score_list) > 0){

        
            

            $html = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <style>
                            @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer&family=Poppins&display=swap");
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
                            <h1>Export student scores</h1>
                            <div id="flex">
                                <div class="block">
                                    <p>Subject name: '.$subject_name.' </p>
                                    <p>Suject code: '.$subject_code.'</p>
                                    <p>Credit: '.$credit.'</p>
                                    <p>Instructor: '.$teacher_name.'</p>
                                    <p>Total student: '.$count_student.'</p>
                                    <p>Year of study: '.$year_of_study.'</p>
                                </div>

                                <div class="block">
                                    <p>Department: '.$department.'</p>
                                    <p>Major: '.$major.'</p>
                                    <p>Degree: '.$level.'</p>
                                    <p>Level year: '.$year_level.'</p>
                                    <p>Semester: '.$semester.'</p>
                                </div>
                            </div>
                            <div class = "clear"></div>

                            <table>
                                <tr>
                                    <th class="id">#</th>
                                    <th>Student ID</th>
                                    <th>Fullname</th>
                                    <th class="gender">Gender</th>
                                    <th class="date">Date of birth</th>
                                    <th class="score">Attendence</th>
                                    <th class="score">Assignment</th>
                                    <th class="score">Midterm</th>
                                    <th class="score">Final</th>
                                    <th class="score">Total</th>
                                    <th class="score">Grade</th>
                                </tr>';
            $i=1;
            while($row = mysqli_fetch_assoc($score_list)){
                $brith_date = date_create($row['birth_date']);
                $html .= '<tr>';
                $html .= '<td class="id">'.$i++.'</td>
                        <td>'.$row["student_id"].'</td>
                        <td>'.$row["firstname"]. " " .$row['lastname'].'</td>
                        <td class="gender">'.$row["gender"].'</td>
                        <td class="date">'.date_format($brith_date, "d-m-Y").'</td>
                        <td class="score">'.$row["attendence"].'</td>
                        <td class="score">'.$row["assignment"].'</td>
                        <td class="score">'.$row["midterm_exam"].'</td>
                        <td class="score">'.$row["final_exam"].'</td>
                        <td class="score">'.$row["total_score"].'</td>
                        <td class="score">'.$row["grade"].'</td>';
                $html .= '</tr>';
                // $i++;
            }

            $html .= '
                            </table>
                            <div class = "note">
                                <p>Date: Day......................... Month........................ Year '.$year_of_study.'</p>
                                <br>
                                <p>Reciever</p>

                                <br>
                                <br>
                                <br>
                                <p>..........................................</p>
                            </div>
                            <div class = "clear"></div>

                        </div>
                    </body>
                </html>';

            $dompdf = new Dompdf;
            $dompdf -> loadHtml($html);
            $dompdf -> setPaper('A4', 'portrait');
            $dompdf -> render();
            $dompdf -> stream('export-pdf-for-'.$subject_code.'.pdf');
            mysqli_close($conn);
            exit;
        }
    }    
?>

    <!-- <style>
        #flex{
            display: flex;
            flex-direction: row;
        }

    </style>  -->
    
