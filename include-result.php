<div class="student-information">
    <div class="info-left-right">
        <div class="control-info">
            <p class="title">Student ID</p><span>:</span><p><?=$result['student_id'];?></p>
        </div>
        <div class="control-info">
            <p class="title">Student name</p><span>:</span><p><?=ucfirst($result['firstname']). " ".ucfirst($result['lastname']);?></p>
        </div>
        <div class="control-info">
            <p class="title">Date of birth</p><span>:</span><p><?php
                if($result['birth_date'] == '0000-00-00'){
                    echo '';
                }else{
                    $birth_date = date_create($result['birth_date']); echo date_format($birth_date, "d-M-Y");
                }
                ?>
            </p>
        </div>
        
    </div>
    <div class="info-left-right">
        <div class="control-info">
            <p class="title">Department</p><span>:</span><p><?=$result['department'];?></p>
        </div>
        <div class="control-info">
            <p class="title">Major</p><span>:</span><p><?=$result['major'];?></p>
        </div>
        <div class="control-info">
            <p class="title">Degree</p><span>:</span><p><?=$result['level_study'];?></p>
        </div>
    </div>
</div>


<div class="manage-semester">
    <?php
        if($result['level_study'] == "Associate Degree"){
    ?>
    <!-- ASSOCIATE DEGREE START  -->
            
        <div class="semester-part">
            <!-- 1 semester start -->
                <h4>1<sup>st</sup> Semester, 1<sup>st</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit1 = 0;
                                    $creditxpoint1 = 0;
                                    $passCredit = 0;
                                    $projectCredit = 0;

                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '1' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '1'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];
                                            



                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint1 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint1 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint1 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint1 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint1 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint1 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint1 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint1 += 0* $result_data['credit'];
                                                    }

                                                    


                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint1 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint1 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint1 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint1 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint1 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint1 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint1 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint1 += 0* $result_data['credit'];
                                                    }
                                                }
                                                
                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $credit1 += $result_data['credit'];
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }                                                                   
                                                }

                                                
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){
                                            //     $credit1 += $result_data['credit'];

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //     }                                                                   
                                            // }

                                        }
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="total-marks">
                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit1;?></span>
                        <p>GPA :</p><span> <?php echo $gpa1 = ($creditxpoint1 != '0')? $creditxpoint1 / $credit1 : '0'; echo substr($gpa1,0, 4)?></span>
                        


                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 1 semester end  -->


            <!-- 2 semester  -->
                <h4>2<sup>nd</sup> Semester, 1<sup>st</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit2 = 0;
                                    $creditxpoint2 = 0;
                                    $creditSemester2Year1 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '1' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '2'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                            // echo $result_data['credit'];
                                            if($subject_type != 'ចុះកម្មសិក្សា'){
                                                $creditSemester2Year1 +=  $result_data['credit'];
                                            }

                                            // if($subject_type != 'គម្រោង'){
                                            
                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint2 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint2 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint2 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint2 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint2 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint2 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint2 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint2 += 0* $result_data['credit'];
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint2 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint2 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint2 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint2 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint2 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint2 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint2 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint2 += 0* $result_data['credit'];
                                                    }
                                                    
                                                    
                                                }

                                                
                                                if($subject_type != 'ចុះកម្មសិក្សា'){

                                                    $credit2 += $result_data['credit'];

                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }
                                                }
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            
                                                // if($subject_type != 'ចុះកម្មសិក្សា'){

                                                //     $credit2 += $result_data['credit'];

                                                //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                //         $passCredit += $result_data['credit'];
                                                //     }
                                                // }


                                            // }else{
                                            //     $projectCredit = $result_data['credit'];
                                            // }
                                        }
                                        
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">

                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit2;?></span>
                        <!-- <p>GPA :</p><span> < echo ($total / $count_n);?></span> -->
                        <p>GPA :</p><span> <?php $gpa2 = ($creditxpoint2 != '0')? $creditxpoint2 / $credit2 : '0'; echo substr($gpa2, 0, 4)?></span>
                        <p class="text-danger"> GPAX : </p> <span><?php 
                            if($credit1+$credit2 == '0'){
                                $gpax = 0;
                            }else{
                                $gpax = ($creditxpoint1+$creditxpoint2)/($credit1+$credit2); 
                            }
                            echo substr($gpax, 0, 4)?></span>

                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 2 semester end -->

        </div>

        <div class="semester-part">
            <!-- 1 semester start -->

                <h4>1<sup>st</sup> Semester, 2<sup>nd</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit3 = 0;
                                    $creditxpoint3 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '2' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '1'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint3 += 4.0* ($result_data['credit']);
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint3 += 3.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint3 += 3* ($result_data['credit']);
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint3 += 2.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint3 += 2* ($result_data['credit']);
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint3 += 1.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint3 += 1* ($result_data['credit']);
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint3 += 0* ($result_data['credit']);
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint3 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint3 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint3 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint3 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint3 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint3 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint3 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint3 += 0* $result_data['credit'];
                                                    }

                                                }
                                                

                                                if($subject_type != 'ចុះកម្មសិក្សា'){

                                                    // $credit3 += $result_data['credit']+$projectCredit;
                                                    $credit3 += $result_data['credit'];
    
                                                    
                                                
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                        // $projectCredit = $projectCredit;
                                                    }
                                                }
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){

                                            //     $credit3 += $result_data['credit']+$projectCredit;

                                                
                                            

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //         $projectCredit = $projectCredit;
                                            //     }
                                            // }
                                        }
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">
                        <p class="text-bold text-danger">Total</p>
                        <!-- <p>Credit :</p><span> <php  $credit3 = $credit3+$projectCredit; echo $credit3?></span> -->

                        <p>Credit :</p><span> <?php  $credit3 = $credit3; echo $credit3?></span>

                        <!-- <p>GPA :</p><span> < echo ($total / $count_n);?></span> -->
                        <!-- <p>GPA :</p><span> < $gpa3 = ($creditxpoint3 != '0')? $creditxpoint3 / ($credit3+$projectCredit) : '0'; echo substr($gpa3, 0, 4)?></span> -->
                        <p>GPA :</p><span> <?php $gpa3 = ($creditxpoint3 != '0')? $creditxpoint3 / ($credit3) : '0'; echo substr($gpa3, 0, 4)?></span>
                        <p class="text-danger"> GPAX : </p> <span><?php 
                            if($credit1+$credit2+$credit3 == '0'){
                                $gpax = 0;
                            }else{

                                $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3)/($credit1+$credit2+$credit3); 
                            }
                            echo substr($gpax, 0, 4)?></span>


                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 1 semester end -->
            

            <!-- 2 semester start -->
                <h4>2<sup>nd</sup> Semester, 2<sup>nd</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit4 = 0;
                                    $creditxpoint4 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '2' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '2'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    // echo $grade_data['s_u'];
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint4 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint4 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint4 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint4 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint4 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint4 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint4 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint4 += 0* $result_data['credit'];
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint4 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint4 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint4 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint4 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint4 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint4 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint4 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint4 += 0* $result_data['credit'];
                                                    }
                                                }

                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $credit4 += $result_data['credit'];
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }
                                                }
                                                
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){
                                            //     $credit4 += $result_data['credit'];

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //     }
                                            // }
                                        }
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">
                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit4;?></span>

                        <p>GPA :</p><span> <?php $gpa4 = ($creditxpoint4 != '0')? $creditxpoint4 / ($credit4) : '0'; echo substr($gpa4, 0, 4)?></span>
                        <p class="text-danger"> GPAX : </p> <span><?php 
                            if($credit1+$credit2+$credit3+$credit4 == '0'){
                                $gpax = 0;
                            }else{

                                $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3+$creditxpoint4)/($credit1+$credit2+$credit3+$credit4); 
                            }
                            echo substr($gpax, 0, 4)?></span>


                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 2 semester end -->
            
        </div>

        <div class="total-all">
            <h4>Total for first and second semester</h4>
            <div class="control-total">
                <p>Number of Credits Studied</p>
                <p><?php
                    $tranferred  = 0;
                    echo ($passCredit) - $tranferred;?>
                </p> 
                
            </div>
            <div class="control-total">
                <p>Number of Credits Tranferred</p> 
                <p>
                    <?php
                        if($tranferred == 0){
                            echo '00';
                        }else{
                            echo $tranferred;
                        }
                    ?>
                </p>
            </div>
            <div class="control-total">
                <p>Total Number of Credits Earned</p> 
                <p><?=$credit1 + $credit2 + $credit3 + $credit4;?></p>
            </div>
            <div class="control-total">
                <p>Cumulative grade point averrage</p>
                <p><?=
                    substr($gpax, 0, 4);
                ?></p>
            </div>
        </div>


    <!-- ASSOCIATE DEGREE END  -->
    <?php
        }elseif($result['level_study'] == "Bachelor's Degree"){
    ?>

    <!-- BACHELOR'S DEGREE START -->

        <div class="semester-part">
            <!-- 1 semester start -->
                <h4>1<sup>st</sup> Semester, 3<sup>rd</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit1 = 0;
                                    $creditxpoint1 = 0;
                                    $passCredit = 0;
                                    $projectCredit = 0;

                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '3' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '1'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];
                                            



                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint1 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint1 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint1 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint1 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint1 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint1 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint1 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint1 += 0* $result_data['credit'];
                                                    }

                                                    


                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint1 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint1 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint1 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint1 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint1 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint1 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint1 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint1 += 0* $result_data['credit'];
                                                    }
                                                }
                                                
                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $credit1 += $result_data['credit'];
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }                                                                   
                                                }
                                                

                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){
                                            //     $credit1 += $result_data['credit'];

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //     }                                                                   
                                            // }

                                        }
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="total-marks">
                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit1;?></span>
                        <p>GPA :</p><span> <?php echo $gpa1 = ($creditxpoint1 != '0')? $creditxpoint1 / $credit1 : '0'; echo substr($gpa1,0, 4)?></span>
                        


                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 1 semester end  -->


            <!-- 2 semester  -->
                <h4>2<sup>nd</sup> Semester, 3<sup>rd</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit2 = 0;
                                    $creditxpoint2 = 0;
                                    $creditSemester2Year1 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '3' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '2'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                            // echo $result_data['credit'];
                                            if($subject_type != 'ចុះកម្មសិក្សា'){
                                                $creditSemester2Year1 +=  $result_data['credit'];
                                            }

                                            // if($subject_type != 'គម្រោង'){
                                            
                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint2 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint2 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint2 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint2 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint2 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint2 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint2 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint2 += 0* $result_data['credit'];
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint2 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint2 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint2 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint2 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint2 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint2 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint2 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint2 += 0* $result_data['credit'];
                                                    }
                                                    
                                                    
                                                }

                                                
                                                if($subject_type != 'ចុះកម្មសិក្សា'){

                                                    $credit2 += $result_data['credit'];

                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }
                                                }
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            
                                                // if($subject_type != 'ចុះកម្មសិក្សា'){

                                                //     $credit2 += $result_data['credit'];

                                                //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                //         $passCredit += $result_data['credit'];
                                                //     }
                                                // }
                                            // }else{
                                            //     $projectCredit = $result_data['credit'];
                                            // }
                                        }
                                        
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">

                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit2;?></span>
                        <!-- <p>GPA :</p><span> < echo ($total / $count_n);?></span> -->
                        <p>GPA :</p><span> <?php $gpa2 = ($creditxpoint2 != '0')? $creditxpoint2 / $credit2 : '0'; echo substr($gpa2, 0, 4)?></span>
                        <!-- <P><php
                            echo 'តួរចែក​ = '. $credit1+$credit2;
                            exit;
                        ?></P> -->
                        <p class="text-danger"> GPAX : </p> <span><?php if($credit1+$credit2 == '0'){
                            $gpax = 0;
                        }else{
                            $gpax = ($creditxpoint1+$creditxpoint2)/($credit1+$credit2);
                        }
                        echo substr($gpax, 0, 4)?></span>

                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 2 semester end -->

        </div>

        <div class="semester-part">
            <!-- 1 semester start -->

                <h4>1<sup>st</sup> Semester, 4<sup>th</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit3 = 0;
                                    $creditxpoint3 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '4' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '1'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint3 += 4.0* ($result_data['credit']);
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint3 += 3.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint3 += 3* ($result_data['credit']);
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint3 += 2.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint3 += 2* ($result_data['credit']);
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint3 += 1.50* ($result_data['credit']);
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint3 += 1* ($result_data['credit']);
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint3 += 0* ($result_data['credit']);
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint3 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint3 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint3 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint3 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint3 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint3 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint3 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint3 += 0* $result_data['credit'];
                                                    }

                                                }

                                                if($subject_type != 'ចុះកម្មសិក្សា'){

                                                    $credit3 += $result_data['credit'];
    
                                                    
                                                
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                        // $projectCredit = $projectCredit;
                                                    }
                                                }
                                                
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){

                                            //     $credit3 += $result_data['credit']+$projectCredit;

                                                
                                            

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //         $projectCredit = $projectCredit;
                                            //     }
                                            // }

                                            
                                            
                                        }
                                        

                                    }

                                
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">

                        <p class="text-bold text-danger">Total

                                    
                        </p>
                        <!-- <p>Credit :</p><span> <php  $credit3 = $credit3+$projectCredit; echo $credit3?></span> -->
                        <p>Credit :</p><span> <?php  $credit3 = $credit3; echo $credit3?></span>

                        <!-- <p>GPA :</p><span> < echo ($total / $count_n);?></span> -->
                        <p>GPA :</p><span> <?php $gpa3 = ($creditxpoint3 != '0')? $creditxpoint3 / ($credit3) : '0'; echo substr($gpa3, 0, 4)?></span>
                        <p class="text-danger"> GPAX : </p> <span><?php 
                            if($credit1+$credit2+$credit3 == '0'){
                                $gpax = 0;
                            }else{
                                $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3)/($credit1+$credit2+$credit3); 
                            }
                            echo substr($gpax, 0, 4)?></span>

                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 1 semester end -->
            

            <!-- 2 semester start -->
                <h4>2<sup>nd</sup> Semester, 4<sup>th</sup> Year</h4>
                <div class="control-content-result">
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Credit</th>
                                    <th class="last">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // mysqli_free_result($first_semester_year);
                                    
                                    $count_n = 1;
                                    $credit4 = 0;
                                    $creditxpoint4 = 0;
                                    $first_semester_year = mysqli_query($conn,  "SELECT DISTINCT schedule_study.subject_code,
                                                                                schedule_study.year_semester_id,
                                                                                -- schedule_study.schedule_id,
                                                                                
                                                                                course.subject_code,
                                                                                course.subject_name,
                                                                                course.credit,
                                                                                course.theory,
                                                                                course.execute,
                                                                                course.apply,
                                                                                course.subject_type,

                                                                                subject_type.type_name

                                                                                FROM schedule_study 
                                                                                INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                WHERE schedule_study.year_level = '4' 
                                                                                AND schedule_study.class_id ='". $class_id ."'
                                                                                AND year_of_study.semester = '2'
                                                                                AND schedule_study.done_status = '1'");
                                                                                
                                    if(mysqli_num_rows($first_semester_year) > 0){
                                        $count_n = mysqli_num_rows($first_semester_year);
                                        while($result_data = mysqli_fetch_assoc($first_semester_year)){
                                            $subject_code = $result_data['subject_code'];

                                            $subjectQry = mysqli_query($conn, "SELECT * FROM schedule_study
                                                                                    INNER JOIN year_of_study ON schedule_study.year_semester_id = year_of_study.year_semester_id
                                                                                    INNER JOIN course ON schedule_study.subject_code = course.subject_code
                                                                                    INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                                    WHERE schedule_study.subject_code = '". $subject_code ."'");
                                            $result_data = mysqli_fetch_assoc($subjectQry);
                                            $subject_type = $result_data['type_name'];

                                ?>
                                <tr>
                                    <td><?=$result_data['subject_code'];?></td>
                                    <td><?=$result_data['subject_name'];?></td>
                                    <td><?=$result_data['credit']."(".$result_data['theory'].".". $result_data['execute'].".".$result_data['apply'].")" ;?></td>
                                    <td class="last">
                                        <?php
                                            $grade = mysqli_query($conn, "SELECT * FROM score 
                                                                        INNER JOIN score_submitted ON score.schedule_id = score_submitted.schedule_id
                                                                        WHERE score.student_id ='". $student_id ."' 
                                                                        AND score.schedule_id = '". $result_data['schedule_id'] ."' 
                                                                        AND score_submitted.submit_status ='2'");
                                            if(mysqli_num_rows($grade) > 0){
                                                $grade_data = mysqli_fetch_assoc($grade);
                                                if($subject_type == 'គម្រោង' || $subject_type == 'ចុះកម្មសិក្សា'){
                                                    // echo $grade_data['s_u'];
                                                    $su_grade = $grade_data['s_u'];
                                                    echo $su_grade;

                                                    if($su_grade == 'A'){
                                                        $creditxpoint4 += 4.0* $result_data['credit'];
                                                    }elseif($su_grade == 'B+'){
                                                        $creditxpoint4 += 3.50* $result_data['credit'];
                                                    }elseif($su_grade == 'B'){
                                                        $creditxpoint4 += 3* $result_data['credit'];
                                                    }elseif($su_grade == 'C+'){
                                                        $creditxpoint4 += 2.50* $result_data['credit'];
                                                    }elseif($su_grade == 'C'){
                                                        $creditxpoint4 += 2* $result_data['credit'];
                                                    }elseif($su_grade == 'D'){
                                                        $creditxpoint4 += 1.50* $result_data['credit'];
                                                    }elseif($su_grade == 'E'){
                                                        $creditxpoint4 += 1* $result_data['credit'];
                                                    }elseif($su_grade == 'F'){
                                                        $creditxpoint4 += 0* $result_data['credit'];
                                                    }
                                                }else{

                                                    $grade_total = $grade_data['grade'];
                                                    echo $grade_total;

                                                    if($grade_total == 'A'){
                                                        $creditxpoint4 += 4.0* $result_data['credit'];
                                                    }elseif($grade_total == 'B+'){
                                                        $creditxpoint4 += 3.50* $result_data['credit'];
                                                    }elseif($grade_total == 'B'){
                                                        $creditxpoint4 += 3* $result_data['credit'];
                                                    }elseif($grade_total == 'C+'){
                                                        $creditxpoint4 += 2.50* $result_data['credit'];
                                                    }elseif($grade_total == 'C'){
                                                        $creditxpoint4 += 2* $result_data['credit'];
                                                    }elseif($grade_total == 'D'){
                                                        $creditxpoint4 += 1.50* $result_data['credit'];
                                                    }elseif($grade_total == 'E'){
                                                        $creditxpoint4 += 1* $result_data['credit'];
                                                    }elseif($grade_total == 'F'){
                                                        $creditxpoint4 += 0* $result_data['credit'];
                                                    }
                                                }

                                                if($subject_type != 'ចុះកម្មសិក្សា'){
                                                    $credit4 += $result_data['credit'];
    
                                                    if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                                        $passCredit += $result_data['credit'];
                                                    }
                                                }

                                                
                                            }
                                        ?>
                                    
                                    </td>
                                </tr>    
                                <?php
                                            // if($subject_type != 'ចុះកម្មសិក្សា'){
                                            //     $credit4 += $result_data['credit'];

                                            //     if(($grade_data['grade'] != 'F') && ($grade_data['s_u'] != 'F') || ($grade_data['grade'] != '') && ($grade_data['s_u'] != '')){
                                            //         $passCredit += $result_data['credit'];
                                            //     }
                                            // }
                                        }
                                        

                                    }
                                ?>
                                                            
                            </tbody>
                        </table>
                    </div>
                    <div class="total-marks ">
                        <p class="text-bold text-danger">Total</p>
                        <p>Credit :</p><span> <?=$credit4;?></span>

                        <p>GPA :</p><span> <?php $gpa4 = ($creditxpoint4 != '0')? $creditxpoint4 / ($credit4) : '0'; echo substr($gpa4, 0, 4)?></span>
                        <p class="text-danger"> GPAX : </p> <span><?php 
                            if($credit1+$credit2+$credit3+$credit4 == '0'){
                                $gpax = 0;
                            }else{

                                $gpax = ($creditxpoint1+$creditxpoint2+$creditxpoint3+$creditxpoint4)/($credit1+$credit2+$credit3+$credit4); 
                            }
                            echo substr($gpax, 0, 4)?></span>

                        <!-- <p>Grade :</p><span> B</span> -->
                    </div>
                </div>
            <!-- 2 semester end -->
            
        </div>

        <div class="total-all">
            <h4>Total for first and second semester</h4>
            <div class="control-total">
                <p>Number of Credits Studied</p>
                <p><?php
                    $tranferred  = 0;
                    echo ($passCredit) - $tranferred;?></p> 
                
            </div>
            <div class="control-total">
                <p>Number of Credits Tranferred</p> 
                <p>
                    <?php
                        if($tranferred == 0){
                            echo '00';
                        }else{
                            echo $tranferred;
                        }
                    ?>
                </p>
            </div>
            <div class="control-total">
                <p>Total Number of Credits Earned</p> 
                <p><?=$credit1 + $credit2 + $credit3 + $credit4;?></p>
            </div>
            <div class="control-total">
                <p>Cumulative grade point averrage</p>
                <p><?=
                    $gpax
                ?></p>
            </div>
        </div>

    <!-- BACHELOR'S DEGREE END -->

    <?php
        }
    ?>
</div>