<?php
    require_once('../ims-db-connection.php');

    session_destroy();
    
    header("Location:".SITEURL."ims-login.php");
    exit(0);
?>