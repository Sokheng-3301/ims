<?php
    #DB connection
    require_once('ims-db-connection.php');
    include_once('login-check.php');

    $back_page = '';
    if(!empty($_SERVER['PHP_REFERER'])){
        $back_page = $_SERVER['PHP_REFFERER'];
    }else{
        $back_page = SITEURL."theme.php";
    }

    if(isset($_POST['save_logo'])){
        $logo_name = '';
        $path = 'ims-assets/ims-images/';

        $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
        $old_image = mysqli_real_escape_string($conn, $_POST['old_logo']);
        $system_name = mysqli_real_escape_string($conn, $_POST['system_name']);
        $new_logo = $_FILES['logo_name'];
        

        if(!empty($_FILES['logo_name']['name'])){

            $new_logo = $_FILES['logo_name']['name'];
            $new_logo_tmp = $_FILES['logo_name']['tmp_name'];
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $new_logo);


            $imageExtension = strtolower(end($imageExtension));
            $logo_name = uniqid();
            $logo_name .= '.'. $imageExtension;

            move_uploaded_file($new_logo_tmp, $path.'/'.$logo_name);

            if(file_exists($path.$old_image) ){
                unlink($path.$old_image);                    
            }        
        }else{  
            $logo_name = $old_image;
        }

        $logo_update = mysqli_query($conn, "UPDATE logo SET logo_name = '$logo_name', system_name = '$system_name' WHERE logo_id ='". $update_id ."'");
        if($logo_update == true){
            $_SESSION['ADD_DONE'] = 'Update logo has completed.';
            header("Location:". $back_page);
            exit;
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Update logo has not completed.';
            header("Location:". $back_page);
            exit;
        }

    }

    if(isset($_POST['save_color'])){
        $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
        $header_footer = mysqli_real_escape_string($conn, $_POST['header_footer']);
        $sidebar = mysqli_real_escape_string($conn, $_POST['sidebar']);

        $color = mysqli_query($conn, "UPDATE theme_color SET color_header_footer = '$header_footer', color_sidebar = '$sidebar' WHERE color_id='". $update_id ."'");
        if($color == true){
            $_SESSION['ADD_DONE'] = 'Update color has completed.';
            header("Location:". $back_page);
            exit;
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Update color has not completed.';
            header("Location:". $back_page);
            exit;
        }
    }
    if(isset($_POST['default_color'])){
        // echo 'Default';
        $update_id = mysqli_real_escape_string($conn, $_POST['update_id']);
        $header_footer = mysqli_real_escape_string($conn, '#034d3e');
        $sidebar = mysqli_real_escape_string($conn, '#323232');

        $color = mysqli_query($conn, "UPDATE theme_color SET color_header_footer = '$header_footer', color_sidebar = '$sidebar' WHERE color_id='". $update_id ."'");
        if($color == true){
            $_SESSION['ADD_DONE'] = 'Update color to detault has completed.';
            header("Location:". $back_page);
            exit;
        }else{
            $_SESSION['ADD_NOT_DONE'] = 'Update color to detault has not completed.';
            header("Location:". $back_page);
            exit;
        }
    }
?>