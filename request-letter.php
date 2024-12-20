<?php
    # Connection to DATABASE
    require_once('../ims-db-connection.php');

    #Check login 
    include_once('std-login-check.php');
    $student_id = $_SESSION['LOGIN_STDID'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['submit_request'])){
            // print_r($_POST);

            // exit;
            if(empty($_POST['request-type'])){
                $_SESSION['REQUEST_ERROR'] = 'Please select letter.';
                header("Location:". SITEURL ."ims-student/request-letter.php");
                exit;
            }else{
                $request = $_POST['request-type'];
                $request_type = implode(",", $request);
                                
                $query = "INSERT INTO requests (student_id, request_type) VALUES ('$student_id', '$request_type')";
                $query_run = mysqli_query($conn, $query);
                if($query_run == true){
                    $_SESSION['REQUEST_DONE'] = 'Request has submited.';
                    header("Location:". SITEURL ."ims-student/request-letter.php");
                    exit;
                }else{
                    $_SESSION['REQUEST_ERROR'] = 'Request has not submited.';
                    header("Location:". SITEURL ."ims-student/request-letter.php");
                    exit;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../ims-include/head-tage.php');?>
</head>
<body>
    <!-- top header - header of system  -->
    <?php include_once('../ims-include/header.php'); ?>
        

    <!-- main content of system  -->
    <section id="main-content" id="closeDetial" onclick="closeDetial()">
        <div class="container-ims py-5">
            <div class="control-result p-4">
                <h3>Your request</h3>
                <div class="request-content" >
                    <div class="student-information">
                        <div class="info-left-right">
                            <div class="control-info">
                                <p class="title">Student ID</p><span>:</span><p><?=$result['student_id'];?></p>
                            </div>
                            <div class="control-info">
                                <p class="title">Student name</p><span>:</span><p class="text-uppercase"><?=ucfirst($result['firstname']). " ".ucfirst($result['lastname']);?></p>
                            </div>
                            <div class="control-info">
                                <p class="title">Date of birth</p><span>:</span><p><?php 
                                // $birth_date = date_create($result['birth_date']); echo date_format($birth_date, "d-m-Y");
                                    if($result['birth_date'] == '0000-00-00'){
                                        echo '';
                                    }else{
                                        $birth_date = date_create($result['birth_date']); echo date_format($birth_date, "d-M-Y");
                                    }                                
                                ?></p>
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
                    <div class="control-content-result control-form-request">               
                        <?php
                            include_once('request-history.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer of system  -->
    <?php include_once('../ims-include/footer.php');?>



<!-- popup start  -->
    <?php
        if(isset($_SESSION['REMOVE_REQUEST'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                 Do you want to remove your request?
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>ims-student/request-action.php?delete=<?=$_SESSION['REMOVE_REQUEST'];?>" class="ok btn btn-sm btn-secondary px-4">Ok</a>
                <a href="<?=SITEURL;?>ims-student/request-letter.php" class="ok btn btn-sm btn-warning px-4 ms-2">Cencel</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['REMOVE_REQUEST']);
    ?>

<!-- popup end  -->


<!-- popup start  -->
<?php
        if(isset($_SESSION['ADD_DONE'])){
    ?>
    <div id="popUp">
        <div class="form__verify border-success text-center">
            <p class="text-center icon text-success"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_DONE'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>ims-student/request-letter.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE']);
        if(isset($_SESSION['ADD_DONE_ERROR'])){
    ?>
    <div id="popUp">
        <div class="form__verify text-center">
            <p class="text-center icon text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></p>
            <p>
                <?=$_SESSION['ADD_DONE_ERROR'];?>
            </p>
            <p class="mt-4">
                <a href="<?=SITEURL;?>ims-student/request-letter.php" class="ok btn btn-sm btn-secondary px-5">Ok</a>
            </p>
        </div>
    </div>
    <?php
        }
        unset($_SESSION['ADD_DONE_ERROR']);

    ?>
<!-- popup end  -->



    <!-- include JavaScript in web page  -->
    <?php include_once('../ims-include/script-tage.php');?>
             
            <!-- <script>
                function validateForm() {
                    var studentId = document.getElementById('student-id').value;
                    if (studentId.trim() === '') {
                        alert('Please enter the Student ID.');
                        return false;
                    }
                    return true;
                }
            </script> -->
</body>
</html>
