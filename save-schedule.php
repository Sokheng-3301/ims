<?php
    #Connection to DATABASE

// use Mpdf\Tag\Em;

    require_once('../ims-db-connection.php');
    
    #Check login 
    include_once('std-login-check.php');



#################### Test generate schedule not done ###################
    /*
        if(!empty($_GET['']))
        require_once __DIR__ . '/vendor/autoload.php';
        
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/fonts',
            ]),
            'fontdata' => $fontData + [ // lowercase letters only in font key
                'frutiger' => [
                    'R' => 'KhmerOSsiemreap.ttf',
                    'I' => 'NotoSansKhmer-Bold.ttf',
                ]
            ],
            'default_font' => 'frutiger',
            'fomat' => 'A4-P'
        ]);
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="Voeurn Sokheng">
            <title>Khmer font export</title>
            <style>
                @font-face {
                    font-family: "NotoSansKhmer-Bold";
                    src: url("fonts/NotoSansKhmer-Bold.ttf");
                }
                @font-face {
                    font-family: "KhmerOSsiemreap";
                    src: url("fonts/KhmerOSsiemreap.ttf");
                }
                *{
                    font-family:"KhmerOSsiemreap", "NotoSansKhmer-Bold",  sans-serif;
                    margin: 0;
                    padding: 0;
                    box-shizing: border-box;
                    
                }
        
            </style>
        </head>
        <body>
            <p>កម្ពុជា ព្រះរាជាណាចក្រអឆ្ឆរិយៈ PDf</p>
        </body>
        </html>';
        
        $mpdf -> WriteHTML($html);
        $file = "report.pdf";
        // $mpdf -> Output($file, 'D');
        $mpdf -> Output();
    */
#################### Test generate schedule not done ###################
    $class_qry = mysqli_query($conn, "SELECT * FROM student_info
                                    INNER JOIN class ON student_info.class_id = class.class_id
                                    INNER JOIN major ON class.major_id = major.major_id
                                    INNER JOIN department ON major.department_id = department.department_id
                                    INNER JOIN schedule_study ON student_info.class_id = schedule_study.class_id
                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id 
                                    WHERE student_id = '". $_SESSION['LOGIN_STDID'] ."'");
    $class_data = mysqli_fetch_assoc($class_qry);
    $class_id = $class_data['class_id'];
    
    if(!empty($_GET['semester']) && !empty($_GET['year'])){

        $semester_id = mysqli_real_escape_string($conn, $_GET['semester']);
        $year = mysqli_real_escape_string($conn, $_GET['year']);

        $check_semester = mysqli_query($conn, "SELECT * FROM year_of_study WHERE year_semester_id = '". $semester_id ."' AND year_of_study ='". $year ."'" );
        if(mysqli_num_rows($check_semester) > 0){
?>
        <!DOCTYPE html>
        <html lang="en">
            <head>  
                <?php include_once('../ims-include/head-tage.php');?>
                <style>
                    .print_button{
                        display: block;
                        width: max-content;
                        margin-left: auto;
                        margin-top: 15px;
                    }
                    .print_button button{
                        border: unset;
                        background-color: #198754;
                        padding: 5px 15px;
                        color: white;
                        transition: all 0.2s;
                        border-radius: 3px;
                    }
                    .print_button button:hover{
                        background-color: #198774;
                    }
                </style>
            </head>

            <body>
                <div id="schedule_generate">
                    <!-- <h1>កាលវិភាគសិក្សា</h1> -->
                    <div id="top_schedule">
                        <div class="box">
                            <div class="flex">
                                <div class="left">
                                    <img src="<?=SITEURL;?>ims-assets/ims-images/KSIT-LOGO.png" alt="">
                                </div>
                                <div class="right">
                                    <p class="bold">វិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ</p>
                                    <p class="small">កាលវិភាគសិក្សា</p>
                                </div>
                            </div>
                            <div class="flex mt-2">
                                <div class="left">
                                    <p class="fw-bold">ឆមាសទី <?=$class_data['semester'];?></p>
                                </div>
                                <div class="right">
                                    <p class="bold">ឆ្នាំសិក្សា  <?=$class_data['year_of_study'];?></p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="left">
                                    <p>កម្រិត</p>
                                </div>
                                <div class="right">
                                    <p><?=$class_data['level_study'];?> ឆ្នាំទី <?=$class_data['year_level'];?></p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="left">
                                    <p>ដេប៉ាតឺម៉ង់</p>
                                </div>
                                <div class="right">
                                    <p><?=$class_data['department'];?></p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="left">
                                    <p>ជំនាញ</p>
                                </div>
                                <div class="right">
                                    <p><?=$class_data['major'];?></p>
                                </div>
                            </div>
                        </div>
                        <div class="box table_width">
                            <div class="table_container">
                                <table>
                                    <tr>
                                        <th>លេខកូដ</th>
                                        <th>មុខវិជ្ជា</th>
                                        <th>ក្រេឌីត</th>
                                        <th>ទ្រឹស្តី</th>
                                        <th>ប្រតិបត្តិ</th>
                                        <th>អនុវត្ត</th>
                                        <th>គ្រូបង្រៀន</th>
                                        <th>បន្ទប់</th>
                                    </tr>
                                    <?php
                                        $credit = 0;
                                        $theory = 0;
                                        $execute = 0;
                                        $apply = 0;
                                        $schedule_qry = mysqli_query($conn, "SELECT DISTINCT s.subject_code, s.instructor_id, room  FROM  schedule_study s
                                                                            -- INNER JOIN course c ON s.subject_code = c.subject_code
                                                                            -- INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                            WHERE s.class_id = '". $class_id ."' AND s.done_status = '1'");
                                        if(mysqli_num_rows($schedule_qry) > 0){
                                            while($schedule_data = mysqli_fetch_assoc($schedule_qry)){
                                                $subject_qry = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE c.subject_code = '". $schedule_data['subject_code'] ."'");
                                                $subject_data = mysqli_fetch_assoc($subject_qry);

                                    ?>
                                    <tr>
                                        <td><?=$subject_data['subject_code'];?></td>
                                        <td class="course_name"><?=$subject_data['subject_name'];?></td>
                                        <td class="credit text-center"><?=$subject_data['credit'];?></td>
                                        <td class="credit text-center"><?=$subject_data['theory'];?></td>
                                        <td class="credit text-center"><?=$subject_data['execute'];?></td>
                                        <td class="credit text-center"><?=$subject_data['apply'];?></td>
                                        <td class="teacher"><?=$subject_data['fn_khmer'] . " " . $subject_data['ln_khmer'];?></td>
                                        <td class="room"><?=$subject_data['room'];?></td>
                                    </tr>
                                    <?php
                                                $credit += $subject_data['credit'];
                                                $theory += $subject_data['theory'];
                                                $execute += $subject_data['execute'];
                                                $apply += $subject_data['apply'];
                                            }
                                        }
                                    ?>
                                  
                                    <tr class="fw-bold">
                                        <td colspan="2" class="text-center">សរុប</td>
                                        <td class="credit text-center"><?=$credit;?></td>
                                        <td class="credit text-center"><?=$theory;?></td>
                                        <td class="credit text-center"><?=$execute;?></td>
                                        <td class="credit text-center"><?=$apply;?></td>
                                        <td colspan="2"></td>
                                        
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="schedule_content" class="mt-4">
                        <div class="schedule_table" style="border: 1px solid grey;">
                            <table >
                                <tr>
                                    <th>ថ្ងៃ\ម៉ោង</th>

                                    <th class="flage">07:30-08:00</th>
                                    <th>08:00-09:00</th>
                                    <th>09:00-10:00</th>
                                    <th>10:00-11:00</th>
                                    <th>11:00-12:00</th>

                                    <th>12:00-13:00</th>

                                    <th>13:00-14:00</th>
                                    <th>14:00-15:00</th>
                                    <th>15:00-16:00</th>
                                    <th>16:00-16:30</th>
                                </tr>

                                <tr>
                                    <td>ចន្ទ</td>
                                        <?php

                                            // mysqli_free_result()

                                            ##################
                                            ### START 1
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                WHERE s.day = 'Monday' 
                                                                                AND s.start_time >= '07:00:00' 
                                                                                AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);
                                        ?>
                                            <td class="flage"><?=$day_data['subject_name'];?></td>
                                        <?php
                                            }else{
                                                echo '<td class="flage">
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START 2
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Monday' 
                                                                                AND s.start_time >= '08:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START 3
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '09:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START 4
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '10:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START 5
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '11:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                    <!-- except here .........  -->
                                    <td rowspan="5"></td>
                                    <!-- except here .........  -->

                                    
                                    <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START AFTERNOON 1
                                            ##################

                                            $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Monday' 
                                                                                AND s.start_time >= '13:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($dat_afternoon) > 0){
                                                $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 2
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '14:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 3
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '15:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 4
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Monday' 
                                                                                    AND s.start_time >= '16:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    // echo '<td>
                                                                
                                                    //     </td>';
                                                }
                                            }else{
                                               // echo '<td>
                                                                
                                                    //     </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>




                                    
                                    
                                </tr>



                                <!-- Tuesday  -->
                                <!-- <tr>
                                    <td>អង្គារ</td>
                                    <td class="flage">គោរពទង់ជាតិ</td>
                                    <td colspan="2">Fundamantal Machine Learning</td>

                                    <td></td>
                                    <td></td>

                                    <td colspan="4">Fundamantal Machine Learning</td>
                                    
                                    
                                </tr> -->

                                <tr>
                                        <td>អង្គារ</td>
                                        <?php

                                            // mysqli_free_result()

                                            ##################
                                            ### START 1
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                WHERE s.day = 'Tuesday' 
                                                                                AND s.start_time >= '07:30:00' 
                                                                                AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);
                                        ?>
                                            <td class="flage"><?=$day_data['subject_name'];?></td>
                                        <?php
                                            }else{
                                                echo '<td class="flage">
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START 2
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Tuesday' 
                                                                                AND s.start_time = '08:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START 3
                                            ##################

                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '09:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '10:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START 5
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '11:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                    <!-- except here .........  -->
                                    <!-- <td rowspan="5"></td> -->
                                    <!-- except here .........  -->

                                    
                                    
                                        <?php
                                            // mysqli_free_result($day_morning);

                                            ##################
                                            ### START AFTERNOON 1
                                            ##################
                                            mysqli_free_result($day_morning);
                                            $colspan = 1;
                                            $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Tuesday' 
                                                                                AND s.start_time = '13:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($dat_afternoon) > 0){
                                                $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                        
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php

                                            ##################
                                            ### START AFTERNOON 2
                                            ##################
                                            
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '14:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }else{
                                                
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 3
                                            ##################
                                            if($colspan <= '1'){

                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '15:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            
                                            ##################
                                            ### START AFTERNOON 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Tuesday' 
                                                                                    AND s.start_time = '16:00:00' 
                                                                                    -- AND s.end_time <= '16:30:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                               
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                            mysqli_free_result($dat_afternoon);
                                        ?>

                                </tr>



                                







                                <!-- Wednesday  -->

                                <tr>
                                        <td>ពុធ</td>
                                        <?php

                                            // mysqli_free_result()

                                            ##################
                                            ### START 1
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                WHERE s.day = 'Wednesday' 
                                                                                AND s.start_time >= '07:30:00' 
                                                                                AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);
                                        ?>
                                            <td class="flage"><?=$day_data['subject_name'];?></td>
                                        <?php
                                            }else{
                                                echo '<td class="flage">
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START 2
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Wednesday' 
                                                                                AND s.start_time = '08:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START 3
                                            ##################

                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '09:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '10:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START 5
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '11:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                    <!-- except here .........  -->
                                    <!-- <td rowspan="5"></td> -->
                                    <!-- except here .........  -->

                                    
                                    
                                        <?php
                                            // mysqli_free_result($day_morning);

                                            ##################
                                            ### START AFTERNOON 1
                                            ##################
                                            mysqli_free_result($day_morning);
                                            $colspan = 1;
                                            $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Wednesday' 
                                                                                AND s.start_time = '13:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($dat_afternoon) > 0){
                                                $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                        
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php

                                            ##################
                                            ### START AFTERNOON 2
                                            ##################
                                            
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '14:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }else{
                                                
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 3
                                            ##################
                                            if($colspan <= '1'){

                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '15:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            
                                            ##################
                                            ### START AFTERNOON 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Wednesday' 
                                                                                    AND s.start_time = '16:00:00' 
                                                                                    -- AND s.end_time <= '16:30:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                               
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                            mysqli_free_result($dat_afternoon);
                                        ?>

                                </tr>


                                <!-- Thursday  -->
                                <tr>
                                        <td>ព្រហស្បតិ៍</td>
                                        <?php

                                            // mysqli_free_result()

                                            ##################
                                            ### START 1
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                WHERE s.day = 'Thursday' 
                                                                                AND s.start_time >= '07:30:00' 
                                                                                AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);
                                        ?>
                                            <td class="flage"><?=$day_data['subject_name'];?></td>
                                        <?php
                                            }else{
                                                echo '<td class="flage">
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START 2
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Thursday' 
                                                                                AND s.start_time = '08:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START 3
                                            ##################

                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '09:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '10:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START 5
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '11:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                    <!-- except here .........  -->
                                    <!-- <td rowspan="5"></td> -->
                                    <!-- except here .........  -->

                                    
                                    
                                        <?php
                                            // mysqli_free_result($day_morning);

                                            ##################
                                            ### START AFTERNOON 1
                                            ##################
                                            mysqli_free_result($day_morning);
                                            $colspan = 1;
                                            $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Thursday' 
                                                                                AND s.start_time = '13:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($dat_afternoon) > 0){
                                                $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                        
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php

                                            ##################
                                            ### START AFTERNOON 2
                                            ##################
                                            
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '14:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }else{
                                                
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 3
                                            ##################
                                            if($colspan <= '1'){

                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '15:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            
                                            ##################
                                            ### START AFTERNOON 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Thursday' 
                                                                                    AND s.start_time = '16:00:00' 
                                                                                    -- AND s.end_time <= '16:30:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                               
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                            mysqli_free_result($dat_afternoon);
                                        ?>

                                </tr>

                                

                                <!-- Friday  -->

                                <tr>
                                        <td>សុក្រ</td>
                                        <?php

                                            // mysqli_free_result()

                                            ##################
                                            ### START 1
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                WHERE s.day = 'Friday' 
                                                                                AND s.start_time >= '07:30:00' 
                                                                                AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);
                                        ?>
                                            <td class="flage"><?=$day_data['subject_name'];?></td>
                                        <?php
                                            }else{
                                                echo '<td class="flage">
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            mysqli_free_result($day_morning);

                                            ##################
                                            ### START 2
                                            ##################

                                            $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Friday' 
                                                                                AND s.start_time = '08:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($day_morning) > 0){
                                                $day_data = mysqli_fetch_assoc($day_morning);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                            
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                        ?>

                                        <?php
                                            

                                            ##################
                                            ### START 3
                                            ##################

                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '09:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '10:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            

                                            ##################
                                            ### START 5
                                            ##################
                                            if($colspan == '1'){

                                            
                                                $day_morning = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '11:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'am' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($day_morning) > 0){
                                                    $day_data = mysqli_fetch_assoc($day_morning);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                    <!-- except here .........  -->
                                    <!-- <td rowspan="5"></td> -->
                                    <!-- except here .........  -->

                                    
                                    
                                        <?php
                                            // mysqli_free_result($day_morning);

                                            ##################
                                            ### START AFTERNOON 1
                                            ##################
                                            mysqli_free_result($day_morning);
                                            $colspan = 1;
                                            $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                INNER JOIN teacher_info t ON s.instructor_id = t.teacher_id
                                                                                WHERE s.day = 'Friday' 
                                                                                AND s.start_time = '13:00:00' 
                                                                                -- AND s.end_time <= '08:00:00' 
                                                                                AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                            if(mysqli_num_rows($dat_afternoon) > 0){
                                                $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                    $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>
                                        <?php
                                            }else{
                                                $colspan = 1;
                                                echo '<td>
                                                        
                                                    </td>';
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>

                                        <?php

                                            ##################
                                            ### START AFTERNOON 2
                                            ##################
                                            
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '14:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }else{
                                                
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>


                                        <?php
                                            

                                            ##################
                                            ### START AFTERNOON 3
                                            ##################
                                            if($colspan <= '1'){

                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '15:00:00' 
                                                                                    -- AND s.end_time <= '08:00:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                                
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################
                                        ?>



                                        <?php
                                            
                                            ##################
                                            ### START AFTERNOON 4
                                            ##################
                                            if($colspan <= '1'){

                                            
                                                $dat_afternoon = mysqli_query($conn, "SELECT * FROM schedule_study s
                                                                                    INNER JOIN course c ON s.subject_code = c.subject_code
                                                                                    WHERE s.day = 'Friday' 
                                                                                    AND s.start_time = '16:00:00' 
                                                                                    -- AND s.end_time <= '16:30:00' 
                                                                                    AND s.done_status = '1' AND s.at = 'pm' AND s.class_id ='". $class_id ."'");
                                                if(mysqli_num_rows($dat_afternoon) > 0){
                                                    $day_data = mysqli_fetch_assoc($dat_afternoon);

                                                        $colspan = intval($day_data['end_time']) - intval($day_data['start_time']);
                                        ?>
                                            <td colspan="<?php echo($colspan > '1')? $colspan : ''; ?>"><?=$day_data['subject_name'] ." " .$day_data['credit']."(.". $day_data['theory'] . ".". $day_data['execute']. ".". $day_data['apply']. ") ". $day_data['fn_khmer']. " " . $day_data['ln_khmer'];?></td>

                                        <?php
                                                }else{
                                                    $colspan = 1;
                                                    echo '<td>
                                                               
                                                        </td>';
                                                }
                                            }
                                            ##################
                                            ### END 
                                            ##################

                                            mysqli_free_result($dat_afternoon);
                                        ?>

                                </tr>
                            </table>
                        </div>
                        <div class="print_button">
                            <button value="print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                        </div>
                    </div>

                   
                </div>
            </body>
        </html>

<?php
        }else{
            header("Location:".SITEURL."ims-student/schedule.php");
            exit(0);
        }
    }else{
        header("Location:".SITEURL."ims-student/schedule.php");
        exit(0);
    }
?>