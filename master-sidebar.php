<p><i class="fa fa-bars" aria-hidden="true"></i> Other master data</p>
<ul class="sub__menu">
    <li><a href="<?=SITEURL;?>manage-class.php" class="<?php 
        echo (basename($_SERVER['PHP_SELF']) == 'master-data.php' || basename($_SERVER['PHP_SELF']) == 'manage-class.php') ? 'active' : '';
    ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>Manage class</a></li>

    <li><a href="<?=SITEURL;?>manage-semester.php" class="<?php 
        echo (basename($_SERVER['PHP_SELF']) == 'manage-semester.php') ? 'active' : '';
    ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>Manage semester</a></li>

    <li><a href="<?=SITEURL;?>manage-major.php" class="<?php 
        echo (basename($_SERVER['PHP_SELF']) == 'manage-major.php') ? 'active' : '';
    ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>Manage major</a></li>

    <li><a href="<?=SITEURL;?>manage-department.php" class="<?php 
        echo (basename($_SERVER['PHP_SELF']) == 'manage-department.php') ? 'active' : '';
    ?>"><i class="fa fa-caret-right" aria-hidden="true"></i>Manage department</a></li>
</ul>