<?php
# Connection to DATABASE
require_once('../ims-db-connection.php');

#Check login 
include_once('std-login-check.php');


$GLOBALS['conn'] = $conn;

/*
function searchCourses($searchQuery) {

    $course_sql =  mysqli_query($GLOBALS['conn'], "SELECT * FROM course");
    if(mysqli_num_rows($course_sql) > 0){
        $courses = mysqli_fetch_assoc($course_sql);
        print_r($courses);
        
    }


    // print_r($data);


    // exit;
    // if(mysq)

    
    $courses = array(
        array(
            'id' =>          '108113',
            'name' =>        'IOT',
            'credit' =>      '3 (2.0.0)',
            'type' =>        'Ipsum available, but the majority have suffered',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t',
            'Purpose' =>     'but the majority have suffered alteration\'t',
            'Expected Outcome' => 'Lorem Ipsum available, but the majority have suffered\'t'
        ),

        array(
            'id' =>          '108114',
            'name' =>        'Data Mining',
            'credit' =>      '3 (2.0.0)',
            'type' =>        'Ipsum available, but the majority have suffered',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t',
            'Purpose' =>     'but the majority have suffered alteration\'t',
            'Expected Outcome' => 'Lorem Ipsum available, but the majority have suffered\'t'
        ),
        array(
            'id' =>          '108115',
            'name' =>        'Web Development',
            'credit' =>      '3 (2.0.0)',
            'type' =>        'Ipsum available, but the majority have suffered',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t',
            'Purpose' =>     'but the majority have suffered alteration\'t',
            'Expected Outcome' => 'Lorem Ipsum available, but the majority have suffered\'t'
        ),
        array(
            'id' =>          '108116',
            'name' =>        'Database Management',
            'credit' =>      '3 (2.0.0)',
            'type' =>        'Ipsum available, but the majority have suffered',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t',
            'Purpose' =>     'but the majority have suffered alteration\'t',
            'Expected Outcome' => 'Lorem Ipsum available, but the majority have suffered\'t'
        ),
        array(
            'id' =>          '108117',
            'name' =>        'Network Security',
            'credit' =>      '3 (2.0.0)',
            'type' =>        'Ipsum available, but the majority have suffered',
            'description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t',
            'Purpose' =>     'but the majority have suffered alteration\'t',
            'Expected Outcome' => 'Lorem Ipsum available, but the majority have suffered\'t'
        )
    );
    


    // $filteredCourses = array_filter($courses, function($course) use ($searchQuery) {
    $filteredCourses = array_filter($courses, function($searchQuery) {
        return stripos($searchQuery['subject_code'], $searchQuery) !== false || stripos($searchQuery['subject_name'], $searchQuery) !== false;
    });

    return $filteredCourses;
}
*/


// if (isset($_POST['search'])) {
//     $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
//     // $searchResults = searchCourses($searchQuery);
//     $course_sql =  mysqli_query($conn, "SELECT * FROM course WHERE subject_name LIKE '%$searchQuery%' OR subject_code LIKE '%$searchQuery%'");
//     if(mysqli_num_rows($course_sql) > 0){
//         $searchResults = mysqli_fetch_assoc($course_sql);
//         // print_r($searchResults);
//     }
// } else {
//     $searchResults = array(); 
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('../ims-include/head-tage.php');?>
<style>
    .search-result {
        overflow: hidden;
        transition: max-height 0.8s; 
        max-height: 87px; 
        border: 1px solid #ccc; 
        padding: 10px; 
    }

    .search-result.expanded {
        max-height: 400px; 
        
    }

    .search-result.collapsed {
        max-height: 100px; 
    }

</style>
</head>
<body>
    <!-- top header - header of system  -->
    <?php include_once('../ims-include/header.php'); ?>
        

    <!-- main content of system  -->
    <section id="main-content" id="closeDetial" onclick="closeDetial()">
        <div class="container-ims py-5">
            <div class="course-control p-4">
                <h3>Course Description</h3>
                <div class="shadow-bg shadow-course">
                    <div id="background-header">
                        <form method="POST" action="">
                            <div class="control-search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <input type="search" name="search" id="" placeholder="Enter course ID or course name..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                                <button type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="background-content">                    
                        <?php
                            if (!empty($_POST['search'])) {
                                
                                    
                                $searchQuery = mysqli_real_escape_string($conn, $_POST['search']);
                                if($searchQuery != ''){
                                    echo '<div class="result-title">
                                        <h4><i class="fa fa-search" aria-hidden="true"></i> Your search result </h4>
                                    </div>';
                                
                                // $searchResults = searchCourses($searchQuery);
                                    $course_sql =  mysqli_query($conn, "SELECT * FROM course 
                                                                        INNER JOIN subject_type ON course.subject_type = subject_type.id
                                                                        LEFT JOIN teacher_info On course.teaching_by = teacher_info.teacher_id
                                                                        WHERE course.subject_name LIKE '%$searchQuery%' OR subject_code LIKE '%$searchQuery%'");
                                    if(mysqli_num_rows($course_sql) > 0){
                                        while($result = mysqli_fetch_assoc($course_sql)){
                                    ?>
                                    <div class="search-result" onclick="toggleDescription(this)">
                                        <div class="short-title">
                                            <p><strong>Subject Code</strong></p> <p class="text-secondary">:</p> <p class="text-primary"><?= $result['subject_code']; ?></p>
                                            <p><strong>Subject Name</strong></p> <p class="text-secondary">:</p> <p><?= $result['subject_name']; ?></p>

                                            <p><strong>Instructor</strong></p> <p class="text-secondary">:</p> <p><?= $result['fn_en']. " ". $result['ln_en']; ?></p>
                                            <p><strong>Credit</strong></p> <p class="text-secondary">:</p> <p><?= $result['credit']; ?></p>
                                            <p><strong>Type of Subject</strong></p> <p class="text-secondary">:</p> <p> <?= $result['type_name']; ?></p>
                                            <p><strong>Description</strong></p> <p class="text-secondary">:</p> <p><?= $result['description']; ?></p>
                                            <p><strong>Purpose</strong></p> <p class="text-secondary">:</p> <p><?= $result['purpose']; ?></p>
                                            <p><strong>Expected Outcome</strong></p> <p class="text-secondary">:</p> <p><?= $result['anticipated_outcome']; ?></p>
                                        </div>
                                        <!-- <div class="read-more">
                                            <a onclick="toggleDescription(this)">Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div>
                                    <?php
                                        }
                                    }else{
                                        echo '<p style="text-align: left; margin-left: 1%;margin-top: 1%;">No results found.</p>';
                                    }
                                }else{

                                }
                            } 
                            
                            else {
                                
                            ?>
                                <p class="text-secondary">Search courses above <i class="fa fa-level-up" aria-hidden="true"></i>. </p>
                            <?php
                            }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer of system  -->
    <?php include_once('../ims-include/footer.php');?>

    <!-- include javaScript in web page  -->
    <?php include_once('../ims-include/script-tage.php');?>
    <script>
        // function toggleDescription(link) {
        //     var searchResult = link.closest('.search-result');
        //     searchResult.classList.toggle('expanded');
        //     if (searchResult.classList.contains('expanded')) {
        //         link.innerHTML = 'Read less <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        //     } else {
        //         link.innerHTML = 'Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        //     }
        // }
        function toggleDescription(link) {
            var searchResult = link.closest('.search-result');
            searchResult.classList.toggle('expanded');
            if (searchResult.classList.contains('expanded')) {
                // link.innerHTML = 'Read less <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
            } else {
                // link.innerHTML = 'Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
            }
        }
    </script>

</body>
</html>
