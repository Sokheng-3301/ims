<?php
    // #Connection to DATABASE
    // require_once('ims-db-connection.php');

    if(empty($_SESSION['LOGIN_STDID']) || empty($_SESSION['STD_LOGIN_STATUS']) || empty($_SESSION['STD_TYPE'])){
        header("Location:".SITEURL."ims-login.php");
        exit;

    }else{
        #check if has teacher or admin 
        
        if(!empty($_SESSION['LOGIN_TYPE'])){
            header("Location:".SITEURL);
            exit;
        }
        
    }
?>
