
    <!-- main content of system  -->
    <?php
    
        #Check login 
        include_once('std-login-check.php');


        $request_history = mysqli_query($conn, "SELECT * FROM requests WHERE student_id ='". $student_id ."' ORDER BY  request_status ASC");
        if(mysqli_num_rows($request_history) > 0){
    ?>
    <div class="control-result control-history margin-top">
        <?php
            if(isset($_SESSION['REQUEST_DONE'])){
                echo '<div class="alert alert-primary" role="alert"><span class="fw-bold pe-2">Note!</span>'.$_SESSION['REQUEST_DONE'].'</div>';
            }
            unset($_SESSION['REQUEST_DONE']);

            if(isset($_SESSION['REQUEST_ERROR'])){
                echo '<div class="alert alert-danger" role="alert"><span class="fw-bold pe-2">Note!</span>'.$_SESSION['REQUEST_ERROR'].'</div>';
            }
            unset($_SESSION['REQUEST_ERROR']);

        ?>
        <!-- <h3><=request; echo ' history';?></h3> -->
        <!-- <h4>Your request</h4> -->
        <div class="control-table">
            <table>
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <!-- <th>Student name</th> -->
                        <!-- <th>Student ID</th> -->
                        <th class="text-center" id="width_fit">លិ.បញ្ជាក់ការសិក្សា</th>
                        <th class="text-center" id="width_fit">ប្រតិបត្តិពិន្ទុ</th>
                        <th class="text-center" id="width_fit">ស.បណ្តោះអាសន្ន</th>
                        <th class="text-center" id="width_fit">Request date</th>
                        <!-- <th>Feedback</th> -->
                        <th class="text-center">Status</th>
                        <!-- <th class="text-center">Comment</th> -->
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        while($reqest_data = mysqli_fetch_assoc($request_history)){
                    ?>
                    <tr>
                        <td class="text-center"><?=$i++;?></td>
                        <!-- <td><=$result['firstname']. " ".$result['lastname'];?></td> -->

                        <td class="text-center" id="width_fit">
                            <?php
                                $verify_study = explode(',', $reqest_data['request_type']);
                                foreach($verify_study as $verify){
                                    if($verify == 'លិខិតបញ្ជាក់ការសិក្សា'){
                                        echo '<i class="fa fa-check fs-6 text-success" aria-hidden="true"></i>';
                                    }
                                }
                            ?>
                        </td>
                        
                        <td class="text-center" id="width_fit">
                            <?php
                                $certificate = explode(',', $reqest_data['request_type']);
                                foreach($certificate as $certi){
                                    if($certi == 'ប្រតិបត្តិពិន្ទុ'){
                                        echo '<i class="fa fa-check fs-6 text-success" aria-hidden="true"></i>';
                                    }
                                }
                            ?>
                        </td>

                        <td class="text-center" id="width_fit">
                            <?php
                                $transcript = explode(',', $reqest_data['request_type']);
                                foreach($transcript as $tran){
                                    if($tran == 'សញ្ញាបត្របណ្តោះអាសន្ន'){
                                        echo '<i class="fa fa-check fs-6 text-success" aria-hidden="true"></i>';
                                    }
                                }
                            ?>
                        </td>


                        <td class="text-center" id="width_fit"><?php
                            $request_date = date_create($reqest_data['request_date']);
                            echo date_format($request_date, "d-M-Y");
                        ?></td>
                        <!-- <td><=$reqest_data['feedback'];?></td> -->
                       
                        <td class="processing" style="width: 20px;" >
                            <?php
                                if($reqest_data['request_status'] == '0' && $reqest_data['feedback'] == 'accepted'){
                                    echo '<p class ="accepted"><i class="fa fa-check"></i><span>Accepted</span></p>';

                                }elseif($reqest_data['request_status'] == '2' && $reqest_data['feedback'] == 'rejected'){
                                    echo '<p class ="rejected"><i class="fa fa-ban"></i><span>Rejected</span></p>';

                                }elseif($reqest_data['request_status'] == '0' && $reqest_data['feedback'] == ''){
                                    echo '<p class ="process"><i class="fa fa-spinner" aria-hidden="true"></i><span>Reqesting</span></p>';

                                }else{
                                    echo '<p class ="done"><i class="fa fa-check-circle"></i><span>Done</span></p>';
                                }
                            ?>
                        </td>
                        <!-- <td><?=$reqest_data['comment'];?></td> -->
                        <td class="text-center" style="width: 20px;">
                            <?php
                                if($reqest_data['request_status'] == '0' && $reqest_data['feedback'] == ''){
                                    echo '<a class="cancel" href="'.SITEURL.'ims-student/request-action.php?remove='.$reqest_data['id'].'"><i class="fa fa-trash p-0" aria-hidden="true"></i></a>';

                                }else{
                            ?>
                                <a class="cancel view" type="button" data-bs-toggle="modal" data-bs-target="#update_<?=$reqest_data['id'];?>"><i class="fa fa-eye p-0" aria-hidden="true"></i></a>


                            <?php
                                }
                            ?>
                            
                        </td>
                    </tr>
                        <!-- Update form pop up  -->
                        <div class="modal fade" id="update_<?=$reqest_data['id'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="update_<?=$reqest_data['id'];?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="update_<?=$result['class_id'];?>">View request</h5>
                                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div> 
                                    <div class="modal-body fs-small">
                                        <div id="control-flow">
                                            <!-- <div class="arrow">
                                                <span class="corner"></span>
                                                <span class="right"></span>
                                            </div>

                                            <div class="arrow">
                                                <span class="corner1"></span>
                                                <span class="right1"></span>

                                            </div>
                                            <div class="arrow">
                                                <span class="corner1"></span>
                                                <span class="right1"></span>

                                            </div> -->
                                            <p class="fw-bold">Request</p> <p>:</p>
                                            <p>
                                                <?php
                                                    $request_letter = explode(',', $reqest_data['request_type']);
                                                    $length_arr = count($request_letter);
                                                    if($length_arr == 1){
                                                        echo $request_letter[0];

                                                    }else{
                                                        echo $request_letter[0]. " & ". $request_letter[1];

                                                    }
                                                    // foreach($request_letter as $request){
                                                    //     echo $request ." ";
                                                    // }
                                                ?>
                                            </p>
 
                                            <p class="fw-bold">Request date</p> <p>:</p>
                                            <p>
                                                <?php
                                                    $date_request = date_create($reqest_data['request_date']); 
                                                    echo date_format($date_request, "d-m-Y");
                                                ?>
                                            </p>
                                            <p class="fw-bold">Status</p> <p>:</p>

                                            <?php
                                                if($reqest_data['request_status'] == '0' && $reqest_data['feedback'] == 'accepted'){
                                                    echo '<p class ="accepted"><i class="fa fa-check"></i><span>Accepted</span></p>';

                                                }elseif($reqest_data['request_status'] == '2' && $reqest_data['feedback'] == 'rejected'){
                                                    echo '<p class ="rejected"><i class="fa fa-ban"></i><span>Rejected</span></p>';

                                                }elseif($reqest_data['request_status'] == '0' && $reqest_data['feedback'] == ''){
                                                    echo '<p class ="process"><i class="fa fa-spinner" aria-hidden="true"></i><span>Reqesting</span></p>';

                                                }else{
                                                    echo '<p class ="done"><i class="fa fa-check-circle"></i><span>Done</span></p>';
                                                }
                                            ?>

                                            <p class="fw-bold">Feedback</p> <p>:</p>
                                            <p>
                                                <i><?php
                                                    echo $reqest_data['comment']; 
                                                ?></i>
                                            </p>
                                        </div>                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        }
    ?>





