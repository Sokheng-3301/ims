<?php
    #Connection to DATABASE
    require_once('../ims-db-connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>  
        <?php include_once('../ims-include/head-tage.php');?>
    </head>
    <body>
        <!-- include preload for web page  -->
        <?php #include_once('../ims-include/preload.php');?>

        <!-- top header - header of system  -->
        <?php include_once('../ims-include/header.php'); ?>

        <section id="main-content" id="closeDetial" onclick="closeDetial()">
            <div class="container-ims py-5">
                <div class="schedule p-4">
                    <h3><?=schedule;?></h3>
                    <div class="semester-year">
                        <div class="semester">
                            <p class="active" id="first-semester-click" onclick="firstScheduleShow()">First semester</p>
                            <p id="second-semester-click" onclick="secondScheduleShow()">Second semester</p>
                        </div>
                        <div class="year">
                            <select name="" id="">
                                <option value="">ឆ្នាំសិក្សា 2022</option>
                                <option value="">ឆ្នាំសិក្សា​ 2023</option>
                                <option value="">ឆ្នាំសិក្សា 2024</option>
                            </select>
                        </div>
                    </div>
                    <div class="schedule-title">
                        <h4 class="text-center">វិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ</h4>
                        <h5 class="text-center">កាលវិភាគ</h5>
                        <div class="title">
                            <p class="main">ឆមាសទី ១</p>
                            <span>ឆ្នាំសិក្សា ២០២២​ - ២០២៣</span>
                        </div>
                        <div class="title">
                            <p class="main">កម្រិត</p>
                            <span>ឆ្នាំសិក្សា ២០២២​ - ២០២៣</span>
                        </div>
                        <div class="title">
                            <p class="main">ដេប៉ាតឺម៉ង់</p>
                            <span>ឆ្នាំសិក្សា ២០២២​ - ២០២៣</span>
                        </div>
                        <div class="title">
                            <p class="main">ជំនាញ</p>
                            <span>ឆ្នាំសិក្សា ២០២២​ - ២០២៣</span>
                        </div>
                        <div class="title">
                            <p class="main">គ្រូដឹកនាំ</p>
                            <span>ឆ្នាំសិក្សា ២០២២​ - ២០២៣</span>
                        </div>
                    </div>
                    
                    <div class="table-schedule" id="first-semester">
                        <h3>First semester</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>ថ្ងៃ\ម៉ោង</th>
                                    <th>07:30 - 08:00</th>
                                    <th>08:00 - 09:00</th>
                                    <th>09:00 - 10:00</th>
                                    <th>10:00 - 11:00</th>
                                    <th>11:00 - 12:00</th>

                                    <th>13:00 - 14:00</th>
                                    <th>14:00 - 15:00</th>
                                    <th>15:00 - 16:00</th>
                                    <th>16:00 - 16:30</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $monday = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                    INNER JOIN teacher_info ON schedule_study.instructor_id = teacher_info.teacher_id
                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                    WHERE schedule_study.class_id = '".$class_id."'
                                                                    AND year_of_study.semester = '2'
                                                                    AND schedule_study.day ='Monday'");
                                    if(mysqli_num_rows($monday) > 0){
                                        $monday_data = mysqli_fetch_assoc($monday);

                                    }
                                    
                                ?>
                                <tr>
                                    <td>ចន្ទ</td>
                                    <td></td>
                                    <td colspan="<?php
                                       echo intval($monday_data['end_time']) - intval($monday_data['start_time']);
                                    ?>"><?=$monday_data['subject_name']." " .$monday_data['fn_khmer']." ".$monday_data['ln_khmer']." ".$monday_data['credit']."(". $monday_data['theory'].".". $monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                    <td><?=$monday_data['subject_name']." " .$monday_data['fn_khmer']." ".$monday_data['ln_khmer']." ".$monday_data['credit']."(". $monday_data['theory'].".". $monday_data['execute'].".".$monday_data['apply'].")";?></td>
                                    <td></td>
                                    <td>ពលកម្ម</td>
                                </tr>
                                <tr>
                                    <td>អង្គារ</td>
                                    <td></td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="2">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ពុធ</td>
                                    <td></td>
                                    <td colspan="3">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td colspan="2">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ព្រហស្បតិ៍</td>
                                    <td></td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="4">សកម្មភាពពិសេស</td>
                                </tr>
                                <tr>
                                    <td>សុក្រ</td>
                                    <td>គោរពទង់ជាតិ</td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="4"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>



                    <div class="table-schedule" id="second-semester">
                    <h3>Second semester</h3>

                        <table>
                            <thead>
                                <tr>
                                    <th>ថ្ងៃ\ម៉ោង</th>
                                    <th>07:30 - 08:00</th>
                                    <th>08:00 - 09:00</th>
                                    <th>09:00 - 10:00</th>
                                    <th>10:00 - 11:00</th>
                                    <th>11:00 - 12:00</th>

                                    <th>13:00 - 14:00</th>
                                    <th>14:00 - 15:00</th>
                                    <th>15:00 - 16:00</th>
                                    <th>16:00 - 16:30</th>
                                </tr>
                            </thead>
                            <tbody>
                                <
                                <tr>
                                    <td>ចន្ទ</td>
                                    <td></td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="2">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td>ពលកម្ម</td>
                                </tr>
                                <tr>
                                    <td>អង្គារ</td>
                                    <td></td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="2">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ពុធ</td>
                                    <td></td>
                                    <td colspan="3">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td colspan="2">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>ព្រហស្បតិ៍</td>
                                    <td></td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="4">សកម្មភាពពិសេស</td>
                                </tr>
                                <tr>
                                    <td>សុក្រ</td>
                                    <td>គោរពទង់ជាតិ</td>
                                    <td colspan="4">មុខវិជ្ជា គ្រូបង្រៀន និងក្រេឌីត</td>
                                    <td colspan="4"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>


        <!-- footer of system  -->
        <?php include_once('../ims-include//footer.php');?>

        <!-- include javaScript in web page  -->
        <?php include_once('../ims-include/script-tage.php');?>
</body>
</html>

