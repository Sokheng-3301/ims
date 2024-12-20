<?php
# Connection to DATABASE
require_once('../ims-db-connection.php');

function searchCourses($searchQuery) {
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
    );

    // Filter courses based on search query
    $filteredCourses = array_filter($courses, function($course) use ($searchQuery) {
        return stripos($course['id'], $searchQuery) !== false || stripos($course['name'], $searchQuery) !== false;
    });

    return $filteredCourses;
}

if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $searchResults = searchCourses($searchQuery);
} else {
    $searchResults = array(); 
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
            <div class="course-control p-4">
                <h3>Course Description</h3>
                <form method="POST" action="">
                    <div class="control-search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="search" name="search" id="" placeholder="Enter course ID or course name..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                        <button type="submit">Search</button>
                    </div>
                </form>

                <?php if (!empty($searchResults) && !empty($_POST['search'])): ?>
                    <div class="result-title">
                        <h4><i class="fa fa-search" aria-hidden="true"></i> Your search result </h4>
                    </div>
                    <?php foreach ($searchResults as $result): ?>
                        <div class="search-result">
                            <div class="short-title">
                                <p><strong>Subject Code:</strong> <?= $result['id']; ?></p>
                                <p><strong>Subject Name:</strong> <?= $result['name']; ?></p>
                                <p><strong>Credit:</strong> <?= $result['credit']; ?></p>
                                <p><strong>Type of Subject:</strong> <?= $result['type']; ?></p>
                                <p><strong>Description:</strong> <?= $result['description']; ?></p>
                                <p><strong>Purpose:</strong> <?= $result['Purpose']; ?></p>
                                <p><strong>Expected Outcome:</strong> <?= $result['Expected Outcome']; ?></p>
                            </div>
                            <div class="read-more">
                                <a onclick="toggleDescription(this)">Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php elseif (isset($_POST['search']) && empty($searchResults)): ?>
                    <p style="text-align: left; margin-left: 16%;margin-top: 2%;">No results found.</p>
                    <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- footer of system  -->
    <?php include_once('../ims-include/footer.php');?>

    <!-- include javaScript in web page  -->
    <?php include_once('../ims-include/script-tage.php');?>
    <script>
        function toggleDescription(link) {
            var searchResult = link.closest('.search-result');
            searchResult.classList.toggle('expanded');
            if (searchResult.classList.contains('expanded')) {
                link.innerHTML = 'Read less <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
            } else {
                link.innerHTML = 'Read more <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
            }
        }
    </script>
</body>
</html>
