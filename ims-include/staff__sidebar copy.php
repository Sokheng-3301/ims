
<?php

    if(!empty($_SESSION['LOGIN_ID'])){
        $user_role_check = mysqli_query($conn, "SELECT * FROM users WHERE id =". $_SESSION['LOGIN_ID'] ."'");
        $user_role_result = mysqli_fetch_assoc($user_role_check);
        if($user_role_result['role'] != 'admin'){       

?>






<div id="side__bar">
    <!-- <h3 class="text-white text-center mb-2">IMS</h3> -->
    
    <div class="menu__bar">
        
        <ul>
        <?php
            $function = mysqli_query($conn, "SELECT * FROM role_permission WHERE role_name ='". $_SESSION['LOGIN_TYPE'] ."'");


            while($function_result = mysqli_fetch_assoc($function)){
                $function_ex = explode(',', $function_result['func_id']);
                $sub_func = explode(',', $function_result['sub_func_id']);

                

                foreach($function_ex as $row){
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
        ?>
            <li>
                <div class="main__menu"  onclick="submenu('<?=$func_row['func_name'];?>__menu', 'icon<?=$func_row['func_id'];?>')" id="main_menu">
                    <p><i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon<?=$func_row['func_id'];?>"></i>
                </div>


                <ul id="<?=$func_row['func_name'];?>__menu">
                    <?php
                        foreach($sub_func as $sub_row){
                        
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
        }
            if(!empty($_SESSION['LOGIN_TYPE']) != 'admin'){
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
                    <i class="fa fa-crosshairs" aria-hidden="true"></i>Role permission
                </a>
            </li>
        <?php
            }
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
<div id="side__bar">
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
            </a>
        </li>
        <?php
                    
                }else{
        ?>
            <li>
                <div class="main__menu"  onclick="submenu('<?=$func_row['func_name'];?>__menu', 'icon<?=$func_row['func_id'];?>')" id="main_menu">
                    <p><i class="<?=$func_row['func_icon'];?>" aria-hidden="true"></i><?=$func_row['func_name'];?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" id="icon<?=$func_row['func_id'];?>"></i>
                </div>


                <ul id="<?=$func_row['func_name'];?>__menu">
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
                    <i class="fa fa-crosshairs" aria-hidden="true"></i>Role&User permission
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
    }
?>

