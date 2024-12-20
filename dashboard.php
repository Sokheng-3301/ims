<?php
    #DB connection
    require_once('ims-db-connection.php');
    // print_r($_SESSION);
    // $php_file = $_SERVER['PHP_SELF'];
    include_once('login-check.php');

    // print_r($_SESSION);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once('ims-include/head-tage.php');
        # link to teacher style 
        include_once('ims-include/staff__head_tage.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
        include_once('ims-include/staff__topheader.php');
    ?>

    <section id="sidebar__content" onclick="closeProfileDash(), topNotication()">
        
    <!-- sidebar  -->
    <?php
        include_once('ims-include/staff__sidebar.php');
    ?>

        <div id="main__content">
           <div class="top__content_title">
                <h5 class="super__title">Dashboard <span><?=systemname?></span></h5>
                <p><i class="fa fa-tachometer" aria-hidden="true"></i><a href="<?=SITEURL?>dashboard.php">Home</a> > Dashboard</p>
           </div>
           <?php
                if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'teacher'){
           ?>
           <div class="manage__total__data mb-5">
                <?php
                    // $major = mysqli_query($conn, "SELECT * FROM major 
                    //                                 INNER JOIN department ON major.department_id = department.department_id");

                        $major = mysqli_query($conn, "SELECT * FROM department");
                    if(mysqli_num_rows($major) > 0){
                        while($major_data = mysqli_fetch_assoc($major)){
                ?>

                    <div class="main__total">
                        <!-- <p class="number_count">
                            <php
                                $course = mysqli_query($conn, "SELECT * FROM course");
                                if(mysqli_num_rows($course) > 0){
                                    echo mysqli_num_rows($course);
                                }else{
                                    echo '0';
                                }
                            ?> 
                        </p> -->
                        <div class="d-flex" id="dashboard">
                            <p>
                                <small>Dep.</small> <?=$major_data['department'];?> <br>
                                <small>Total major: </small> <span>
                                <?php
                                    $cout_major = mysqli_query($conn, "SELECT * FROM major WHERE department_id = '". $major_data['department_id']."'");
                                    echo mysqli_num_rows($cout_major);
                                ?></span>
                                <!-- <small>Maj.</small> <=$major_data['major'];?> -->
                                <?php
                                    $major_image = $major_data['icon_name'];
                                ?>
                            </p>
                            <div id="logo__circle" style="background-image: url('<?=SITEURL?>ims-assets/ims-images/<?=$major_image?>');">
                            </div>
                        </div>
                        <a href="<?=SITEURL;?>major.php?dep=<?=$major_data['department_id'];?>">More info <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
                    </div>
                <?php
                        }
                    }
                ?>
           </div>
           <?php
                }
           ?>
           <!-- <div class="manage__plot">
                <div class="bar__plot">
                    <canvas id="myChart" width="400" height="300"></canvas>
                </div>
                <div class="pie__plot">
                    <canvas id="myPie" width="400" height="300"></canvas>
                </div>
                
           </div> -->
           
            <?php

                ############## Check user role [ONLY TEACHER] ###############
                if(isset($_SESSION['TEACHER_ID'])){
                    echo '<div class="all__teacher student__score">';
                        echo '<div class ="show__subject">';
                        ######### Include current subject fo teacher ################
                        include_once('current-subject.php');
                        echo '</div>';
                    echo '</div>';
                }
            ?>
           
           <!-- footer  -->
           <?php include_once('ims-include/staff__footer.php');?>

        </div>
    </section>
    <!-- include javaScript in web page  -->
    <?php include_once('ims-include/script-tage.php');?>


    <script>
        // Get the data from MySQL using PHP
        <?php

        // Query to retrieve data from the table
        $query = "SELECT * FROM student_info";
        $result = mysqli_query($conn, $query);

        // Fetch data from the result set and store it in arrays
        $categories = array();
        $values = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['department_id'];
            $values[] = $row['generation_id'];
        }

        // Close the database connection
        // mysqli_close($conn);
        ?>

        // Create the bar plot using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            // type: 'pie',
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Value',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
    </script>


    <script>
        // Get the data from MySQL using PHP
        <?php
        // Connect to MySQL database
        // $conn = mysqli_connect("localhost", "username", "password", "database");

        // Query to retrieve data from the table
        $query = "SELECT * FROM student_info";
        $result = mysqli_query($conn, $query);

        // Fetch data from the result set and store it in arrays
        $categories = array();
        $values = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['department_id'];
            $values[] = $row['generation_id'];
        }

        // Close the database connection
        mysqli_close($conn);
        ?>


        // Create the bar plot using Chart.js
        var ctx = document.getElementById('myPie').getContext('2d');
        var myChart = new Chart(ctx, {
            // type: 'pie',
            type: 'pie',
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Value',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: 'orange',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>