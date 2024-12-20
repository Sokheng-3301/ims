
<?php

    if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] != 'admin' && !empty($_SESSION['TEACHER'])) {

##########################################
##### sidebar  FOR OFFICER AND TEACHER
#########################################

?>

<div id="side__bar" style="background: <?=$system_sidebar;?>;">
    <!-- <h3 class="text-white text-center mb-2">IMS</h3> -->
    
    <div class="menu__bar">
        
        <ul>
        <?php
            // $function = mysqli_query($conn, "SELECT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");
            $function = mysqli_query($conn, "SELECT DISTINCT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");


            while($function_result = mysqli_fetch_assoc($function)){ #while1          
                
                $fun1 = $function_result['func_id'];
                $sub_fun1 = $function_result['sub_func_id'];

            }


            $function = mysqli_query($conn, "SELECT DISTINCT * FROM role_permission WHERE role_name ='". $_SESSION['TEACHER'] ."'");
            while($function_result = mysqli_fetch_assoc($function)){ #while1
                 
                $fun2 = $function_result['func_id'];
                $sub_fun2 = $function_result['sub_func_id'];

            }
                // --------------------- //

            $sum_fun = $fun1. ",". $fun2;
            $sum_fun_ex = explode(',', $sum_fun);
            $last_sum_fun = array_unique($sum_fun_ex);

                // --------------------- //

            $sum_sub_fun = $sub_fun1 . "," . $sub_fun2;
            $sum_sub_fun_ex = explode(',', $sum_sub_fun);
            $last_sum_sub_fun = array_unique($sum_sub_fun_ex);

                // --------------------- //

            // echo "main <br>";
            // print_r($last_sum_fun);
            // echo "Sub <br>";
            // print_r($last_sum_sub_fun);
            // exit;


                foreach($last_sum_fun as $row){
                    $each_func = mysqli_query($conn, "SELECT * FROM function WHERE func_id ='". $row ."'");
                    $func_row = mysqli_fetch_assoc($each_func);
               
                    if($func_row['func_link'] != ''){

                
        ?>
        <li>
            <a href="<?=SITEURL?><?=$func_row['func_link'];?>.php" class="<?php 
                $php_self = $func_row['func_link']. '.php';
                if(basename($_SERVER['PHP_SELF']) == $php_self){
                    echo "active";
                }else{
                    echo "no-active";
                }
                ?>">
                <i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?>
            </a>
        </li>
        <?php
                    
                }else{
                    $replace_name = str_replace(" ", "__", $func_row['func_name']);
                    
        ?>
            <li>
                <div class="main__menu"  onclick="submenu('<?=$replace_name;?>__menu', 'icon<?=$func_row['func_id'];?>')" id="main_menu">
                    <p><i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon<?=$func_row['func_id'];?>"></i>
                </div>


                <ul id="<?=$replace_name;?>__menu">
                    <?php
                        foreach($last_sum_sub_fun as $sub_row){
                        
                        $sub_function = mysqli_query($conn, "SELECT * FROM sub_function WHERE func_id='". $func_row['func_id'] ."' AND sub_id ='". $sub_row ."'" );
                        while($sub_row = mysqli_fetch_assoc($sub_function)){
                    ?>
                    <li>
                        <a href="<?=SITEURL?><?=$sub_row['sub_link'];?>.php" class="<?php 
                            $link_name = $sub_row['sub_name'].".php";
                            if(basename($_SERVER['PHP_SELF']) == $link_name){
                                echo "active";
                            }else{
                                echo "no-active";
                            }
                        ?>" id="active<?=$sub_row['sub_id'];?>"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active<?=$sub_row['sub_id'];?>"></i> <?=$sub_row['sub_name'];?>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                                       
                </ul>
            </li>

        <?php
                }
            }
            // if(!empty($_SESSION['LOGIN_TYPE']) != 'admin'){}
        ?>   
            
        </ul>
    </div>
</div>



<?php
    }elseif(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] == 'teacher'){


#####################################
#####  sidebar FRO TEACHER ONLY 
#####################################
       
?>



<div id="side__bar" style="background: <?=$system_sidebar;?>;">
    <!-- <h3 class="text-white text-center mb-2">IMS</h3> -->
    
    <div class="menu__bar">
        
        <ul>
        <?php
            // $function = mysqli_query($conn, "SELECT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");
            $function = mysqli_query($conn, "SELECT DISTINCT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");


            while($function_result = mysqli_fetch_assoc($function)){ #while1          
                
                $fun1 = $function_result['func_id'];
                $sub_fun1 = $function_result['sub_func_id'];

                $last_sum_fun = explode(',', $fun1);
                $last_sum_sub_fun = explode(',', $sub_fun1);

            }



                foreach($last_sum_fun as $row){
                    $each_func = mysqli_query($conn, "SELECT * FROM function WHERE func_id ='". $row ."'");
                    $func_row = mysqli_fetch_assoc($each_func);
               
                    if($func_row['func_link'] != ''){

                
        ?>
        <li>
            <a href="<?=SITEURL?><?=$func_row['func_link'];?>.php" class="<?php 
                $php_self = $func_row['func_link']. '.php';
                if(basename($_SERVER['PHP_SELF']) == $php_self){
                    echo "active";
                }else{
                    echo "no-active";
                }
                ?>">
                <i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?>
            </a>
        </li>
        <?php
                    
                }else{
                    $replace_name = str_replace(" ", "__", $func_row['func_name']);
        ?>
            <li>
                <div class="main__menu"  onclick="submenu('<?=$replace_name;?>__menu', 'icon<?=$func_row['func_id'];?>')" id="main_menu">
                    <p><i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon<?=$func_row['func_id'];?>"></i>
                </div>


                <ul id="<?=$replace_name;?>__menu">
                    <?php
                        foreach($last_sum_sub_fun as $sub_row){
                        
                        $sub_function = mysqli_query($conn, "SELECT * FROM sub_function WHERE func_id='". $func_row['func_id'] ."' AND sub_id ='". $sub_row ."'" );
                        while($sub_row = mysqli_fetch_assoc($sub_function)){
                    ?>
                    <li>
                        <a href="<?=SITEURL?><?=$sub_row['sub_link'];?>.php" class="<?php 
                            $link_name = $sub_row['sub_name'].".php";
                            if(basename($_SERVER['PHP_SELF']) == $link_name){
                                echo "active";
                            }else{
                                echo "no-active";
                            }
                        ?>" id="active<?=$sub_row['sub_id'];?>"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active<?=$sub_row['sub_id'];?>"></i> <?=$sub_row['sub_name'];?>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                                       
                </ul>
            </li>

        <?php
                }
            }
            // if(!empty($_SESSION['LOGIN_TYPE']) != 'admin'){}
        ?>                        
        </ul>
    </div>
</div>





<?php
    }else{
###############################
##### admin sidebar 
###############################
?>
<div id="side__bar" style="background: <?=$system_sidebar;?>;">
    <!-- <h3 class="text-white text-center mb-2">IMS</h3> -->
    
    <div class="menu__bar">
        
        <ul>
        <?php
            $function = mysqli_query($conn, "SELECT * FROM function");
            // $function_result = mysqli_fetch_assoc($function);

            while($func_row = mysqli_fetch_assoc($function)){
                if($func_row['func_link'] != ''){

                
        ?>
        <li>
            <a href="<?=SITEURL?><?=$func_row['func_link'];?>.php" class="<?php 
                $php_self = $func_row['func_link']. '.php';
                if(basename($_SERVER['PHP_SELF']) == $php_self){
                    echo "active";
                }else{
                    echo "no-active";
                }
                ?>">
                <i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?>
                <?php
                    if($func_row['func_name'] == 'Request'){
                        $request_count = mysqli_query($conn, "SELECT * FROM requests WHERE notification = '1'");
                        if(mysqli_num_rows($request_count) > 0){
                            echo '<sup class="ms-1 bg-light text-dark rounded" style="padding: 0 3px; font-size: 10px;">New</sup>';
                        }
                        mysqli_free_result($request_count);
                    }
                    elseif($func_row['func_name'] == 'Score submitted'){
                        $score_submit = mysqli_query($conn, "SELECT * FROM score_submitted WHERE submit_status = '1'");
                        if(mysqli_num_rows($score_submit) > 0){
                            echo '<sup class="ms-1 bg-light text-dark rounded" style="padding: 0 3px; font-size: 10px;">New</sup>';
                        }
                        mysqli_free_result($score_submit);
                    }
                ?>
                

            </a>
        </li>
        <?php
                    
                }else{
                    $replace_name = str_replace(" ", "__", $func_row['func_name']);

        ?>
            <li>
                <div class="main__menu"  onclick="submenu('<?=$replace_name;?>__menu', 'icon<?=$func_row['func_id'];?>')" id="main_menu">
                    <p><i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon<?=$func_row['func_id'];?>"></i>
                </div>


                <ul id="<?=$replace_name;?>__menu">
                    <?php

                        
                        $sub_function = mysqli_query($conn, "SELECT * FROM sub_function WHERE func_id='". $func_row['func_id'] ."'" );
                        while($sub_row = mysqli_fetch_assoc($sub_function)){
                    ?>
                    <li>
                        <a href="<?=SITEURL?><?=$sub_row['sub_link'];?>.php" class="<?php 
                            $link_name = $sub_row['sub_name'].".php";
                            if(basename($_SERVER['PHP_SELF']) == $link_name){
                                echo "active";
                            }else{
                                echo "no-active";
                            }
                        ?>" id="active<?=$sub_row['sub_id'];?>"><i class="fa fa-circle-o" aria-hidden="true" id="icon_active<?=$sub_row['sub_id'];?>"></i> <?=$sub_row['sub_name'];?>
                        </a>
                    </li>
                    <?php
                        }
                    
                    ?>
                                       
                </ul>
            </li>

        <?php
                }
            
        }
            if(!empty($_SESSION['LOGIN_TYPE']) && $_SESSION['LOGIN_TYPE'] == 'admin'){
        ?>      
        
            <li>
                <a href="<?=SITEURL?>permission.php" class="<?php 
                    $php_self = 'permission.php';
                    if(basename($_SERVER['PHP_SELF']) == $php_self){
                        echo "active";
                    }else{
                        echo "no-active";
                    }
                    ?>">
                    <i class="fa fa-cogs" aria-hidden="true"></i>Role&User permission
                </a>
            </li>
        <?php
            }
        ?> 
        </ul>
    </div>
</div>
<?php
        
    }
?>

