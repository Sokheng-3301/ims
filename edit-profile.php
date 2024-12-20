<?php

    # Connection to DATABASE
    require_once('../ims-db-connection.php');
    
    #Check login 
    include_once('std-login-check.php');

    $student_info = mysqli_query($conn, "SELECT * FROM student_info WHERE student_id ='" .$_SESSION['LOGIN_STDID']."'");
    if(mysqli_num_rows($student_info) > 0){
        $student_data = mysqli_fetch_assoc($student_info);
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
                <h3>Edit your profile</h3>
                    <div class="shadow-bg shadow-course">
                        <div class="background-content">
                        
                            <div id="edit-profile">
                                <form action="<?=SITEURL;?>ims-student/profile-action.php" method="post" enctype="multipart/form-data">
                                    <div class="manager">
                                        <label for="img_profile" class="profile">
                                            <div class="your-profile" id="profile_preview">
                                                <?php
                                                    if($student_data['profile_image'] != ''){
                                                ?>
                                                    <img width="100%" src="<?=SITEURL;?>ims-assets/ims-images/<?=$student_data['profile_image'];?>" alt="">
                                                <?php
                                                    }else{
                                                        echo ' <i class="fa fa-camera" aria-hidden="true"></i>';
                                                    }
                                                ?>
                                            
                                            </div>                       
                                        </label>
                                        <small style="display:block; margin:auto; text-align:center;">Upload your profile</small>

                                        <input type="file" class="d-none" name="student_profile" id="img_profile"  onchange=" preview(event)" accept="image/*">
                                        <input type="hidden" name="old_profile" value="<?=$student_data['profile_image'];?>">

                                        <h5 class="title"><i class="fa fa-user" aria-hidden="true"></i> Personal information</h5>
                                        <div class="edit-container">
                                            <div class="content">
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="fn_kh">Firstname <sup>KH</sup></label>
                                                        <input type="text" id="fn_kh" name="fn_kh" placeholder="នាមត្រកូល"  value="<?=$student_data['fn_khmer'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="ln_kh">Lastname <sup>KH</sup></label>
                                                        <input type="text" id="ln_kh" name="ln_kh" placeholder="នាមខ្លួន"  value="<?=$student_data['ln_khmer'];?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="fn_en">Firstname <sup>EN</sup></label>
                                                        <input type="text" id="fn_en" name="fn_en" placeholder="Firstname"  value="<?=$student_data['firstname'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="ln_en">Lastname <sup>EN</sup></label>
                                                        <input type="text" id="ln_en" name="ln_en" placeholder="Lastname"  value="<?=$student_data['lastname'];?>">
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="gender">Gender</label>
                                                        <select name="gender" id="gender">
                                                            <option disabled selected>Select gender</option>
                                                            <option value="male" <?php echo ($student_data['gender'] == 'male')? 'selected' : '';?>>Male</option>
                                                            <option value="female" <?php echo ($student_data['gender'] == 'female')? 'selected' : '';?>>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="box">
                                                        <label for="datepicker">Birth date</label>
                                                        <input type="text" id="datepicker" name="birth_date" value="<?=$student_data['birth_date'];?>" placeholder="dd-M-yyyy">
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="national">National</label>
                                                        <input type="text" id="national" name="national" placeholder="National" value="<?=$student_data['national'];?>">

                                                    </div>
                                                    <div class="box">
                                                        <label for="nationality">Nationality</label>
                                                        <input type="text" id="nationality" name="nationality" placeholder="Nationality" value="<?=$student_data['nationality'];?>">
                                                    </div>
                                                </div>

                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="phone_number">Phone number</label>
                                                        <input type="text" id="phone_number" name="phone_number" placeholder="0xx-xxx-xxx" value="<?=$student_data['phone_number'];?>">

                                                    </div>
                                                    <div class="box">
                                                        <label for="email">Email address</label>
                                                        <input type="email" id="email" name="email" placeholder="Email address" value="<?=$student_data['email'];?>">
                                                    </div>
                                                </div>

                                                <label for="birth_address">Place of birth</label>
                                                <textarea name="birth_address" rows="3" id="birth_address" placeholder="Place of birth"><?=$student_data['place_of_birth'];?></textarea>
                                                
                                                <label for="current_address">Current address</label>
                                                <textarea name="current_address" rows="3" id="current_address" placeholder="Current address"><?=$student_data['current_place'];?></textarea>
                                            </div>
                                        </div>
                                        

                                        <h5 class="title"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Edcutaion background</h5>
                                        <div class="edit-container">
                                            <div class="table">
                                                <table>
                                                    <tr>
                                                        <th>កម្រិតថ្នាក់</th>
                                                        <th>ឈ្មោះសាលារៀន</th>
                                                        <th>ខេត្ត/រាជធានី</th>
                                                        <th>ពីឆ្នាំណាដល់ឆ្នាំណា</th>
                                                        <th>សញ្ញាបត្រទទួលបាន</th>
                                                        <th>និទ្ទេសរួម</th>
                                                    </tr>
                                                    <tr>
                                                    
                                                        <?php       

                                                            $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '1' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                            if(mysqli_num_rows($secondary) > 0){
                                                                $secondary_result = mysqli_fetch_assoc($secondary);
                                                            }

                                                        ?>
                                                        <td>បឋមសិក្សា</td>

                                                        <td><input type="text" name="schoolname1" placeholder="ឈ្មោះសាលារៀន" value="<?=$secondary_result['school_name'];?>"></td>
                                                        <td><input type="text" name="school_add1" placeholder="ខេត្ត/រាជធានី" value="<?=$secondary_result['address'];?>"></td>
                                                        <td>
                                                            <div class="d-flex" style="align-items: center;">
                                                                <input type="number" min="0" name="start_year1" placeholder="ឆ្នាំចាប់ផ្តើម" value="<?=$secondary_result['start_year'];?>"> - <input type="number" min="0" name="finish_year1" placeholder="ឆ្នាំបញ្ចប់" value="<?=$secondary_result['finish_year'];?>">
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="certificate1" placeholder="សញ្ញាបត្រទទួលបាន" value="<?=$secondary_result['certificate'];?>"></td>
                                                        <td><input type="text" name="total_rank1" placeholder="និទ្ទេសរួម" value="<?=$secondary_result['rank'];?>"></td>
                                                    </tr>

                                                    <tr>
                                                        <?php     
                                                            mysqli_free_result($secondary);         
                                                            $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '2' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                            if(mysqli_num_rows($secondary) > 0){
                                                                $secondary_result = mysqli_fetch_assoc($secondary);
                                                            }

                                                        ?>
                                                        <td>បឋមភូមិ​</td>
                                                        <td><input type="text" name="schoolname2" placeholder="ឈ្មោះសាលារៀន" value="<?=$secondary_result['school_name'];?>"></td>
                                                        <td><input type="text" name="school_add2" placeholder="ខេត្ត/រាជធានី" value="<?=$secondary_result['address'];?>"></td>
                                                        <td>
                                                            <div class="d-flex" style="align-items: center;">
                                                                <input type="number" min="0" name="start_year2" placeholder="ឆ្នាំចាប់ផ្តើម" value="<?=$secondary_result['start_year'];?>"> - <input type="number" min="0" name="finish_year2" placeholder="ឆ្នាំបញ្ចប់" value="<?=$secondary_result['finish_year'];?>">
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="certificate2" placeholder="សញ្ញាបត្រទទួលបាន" value="<?=$secondary_result['certificate'];?>"></td>
                                                        <td><input type="text" name="total_rank2" placeholder="និទ្ទេសរួម" value="<?=$secondary_result['rank'];?>"></td>
                                                    </tr>

                                                    <tr>
                                                        <?php   
                                                            mysqli_free_result($secondary);         

                                                            $secondary = mysqli_query($conn, "SELECT * FROM background_education WHERE class_level = '3' AND student_id ='" .$_SESSION['LOGIN_STDID'] ."'");
                                                            if(mysqli_num_rows($secondary) > 0){
                                                                $secondary_result = mysqli_fetch_assoc($secondary);
                                                            }

                                                        ?>
                                                        <td>ទុតិយភូមិ</td>
                                                        <td><input type="text" name="schoolname3" placeholder="ឈ្មោះសាលារៀន" value="<?=$secondary_result['school_name'];?>"></td>
                                                        <td><input type="text" name="school_add3" placeholder="ខេត្ត/រាជធានី" value="<?=$secondary_result['address'];?>"></td>
                                                        <td>
                                                            <div class="d-flex" style="align-items: center;">
                                                                <input type="number" min="0" name="start_year3" placeholder="ឆ្នាំចាប់ផ្តើម" value="<?=$secondary_result['start_year'];?>"> - <input type="number" min="0" name="finish_year3" placeholder="ឆ្នាំបញ្ចប់" value="<?=$secondary_result['finish_year'];?>">
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="certificate3" placeholder="សញ្ញាបត្រទទួលបាន" value="<?=$secondary_result['certificate'];?>"></td>
                                                        <td><input type="text" name="total_rank3" placeholder="និទ្ទេសរួម" value="<?=$secondary_result['rank'];?>"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                                        mysqli_free_result($secondary);         

                                        ?>




                                        <h5 class="title"><i class="fa fa-users" aria-hidden="true"></i> Family information</h5>

                                        <div class="edit-container">
                                            <div class="content">
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="father_name">Father name</label>
                                                        <input type="text" id="father_name" name="father_name" placeholder="ឈ្មោះរបស់ឪពុក" value="<?=$student_data['father_name'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="father_age">Father age</label>
                                                        <input type="number" min="0" id="father_age" name="father_age" placeholder="អាយុរបស់ឪពុក" value="<?=$student_data['father_age'];?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="father_occupatioin">Father occupation</label>
                                                        <input type="text" id="father_occupatioin" name="father_occupatioin" placeholder="មុខរបររបស់ឪពុក" value="<?=$student_data['father_occupa'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="father_phone">Father phone</label>
                                                        <input type="text" id="father_phone" name="father_phone" placeholder="លេខទូរស័ព្ទរបស់ឪពុក" value="<?=$student_data['father_phone'];?>">
                                                    </div>
                                                </div>

                                                <label for="father_current_address">Father address</label>
                                                <textarea name="father_current_address" rows="5" id="father_current_address" placeholder="អាសយដ្ឋានបច្ចុប្បន្នរបស់ឪពុក"><?=$student_data['father_address'];?></textarea>
                                            </div>
                                        </div>

                                        <div class="edit-container">
                                            <div class="content">
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="mother_name">Mother name</label>
                                                        <input type="text" id="mother_name" name="mother_name" placeholder="ឈ្មោះរបស់ម្តាយ" value="<?=$student_data['mother_name'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="mother_age">Mother age</label>
                                                        <input type="number" min="0" id="mother_age" name="mother_age" placeholder="អាយុរបស់ម្តាយ" value="<?=$student_data['mother_age'];?>">
                                                    </div>
                                                    
                                                </div>
                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="mother_occupatioin">Mother occupation</label>
                                                        <input type="text" id="mother_occupatioin" name="mother_occupatioin" placeholder="មុខរបររបស់ម្តាយ" value="<?=$student_data['mother_occupa'];?>">
                                                    </div>
                                                    <div class="box">
                                                        <label for="mother_phone">Mother phone</label>
                                                        <input type="text" id="mother_phone" name="mother_phone" placeholder="លេខទូរស័ព្ទរបស់ម្តាយ" value="<?=$student_data['mother_phone'];?>">
                                                    </div>
                                                </div>

                                                <label for="mother_current_address">Mother address</label>
                                                <textarea name="mother_current_address" rows="5" id="mother_current_address" placeholder="អាសយដ្ឋានបច្ចុប្បន្នរបស់ម្តាយ"><?=$student_data['mother_address'];?></textarea>

                                                <div class="d-flex">
                                                    <div class="box">
                                                        <label for="your_sibling">Your sibling</label>
                                                        <input type="number" min="0" id="your_sibling" name="your_sibling" placeholder="ចំនួនបងប្អូនបង្កើត" value="<?=$student_data['sibling'];?>">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="edit-container" id="sibling_list">
                                            <div class="table">                                    
                                                <?php
                                                    // print_r($_SESSION);
                                                    $sibling = mysqli_query($conn, "SELECT * FROM student_sibling WHERE student_id = '". $_SESSION['LOGIN_STDID'] ."'");
                                                    if(mysqli_num_rows($sibling) > 0){
                                                ?>
                                                    <table>
                                                        <tr>
                                                            <th>Fullname</th>
                                                            <th>Gender</th>
                                                            <th>Date of birth</th>
                                                            <th>Occupation</th>
                                                            <th>Address</th>
                                                            <th>Phone</th>
                                                        </tr>
                                                <?php
                                                    $i = 1;
                                                    while($reslut = mysqli_fetch_assoc($sibling)){
                                                ?>
                                                        <tr>
                                                            <td><input type="text" name="sibling_fullname<?=$i;?>" placeholder="Fullname" value="<?=$reslut['sibl1_name'];?>"></td>
                                                            <td>
                                                                <select name="sibling_gender<?=$i;?>" id="">
                                                                    <option disabled selected>Select gender</option>
                                                                    <option value="male" <?php echo ($reslut['sibl1_gender'] == 'male')? 'selected' : '';?>>Male</option>
                                                                    <option value="female" <?php echo ($reslut['sibl1_gender'] == 'female')? 'selected' : '';?>>Female</option>
                                                                </select>
                                                            </td>
                                                            
                                                            <td><input type="text" id="sibling_date<?=$i;?>" name="sibling_birthdate<?=$i;?>" value="<?=$reslut['sibl1_birth_date'];?>" placeholder="dd-M-yyyy"></td>
                                                            <td><input type="text" name="sibling_occupation<?=$i;?>" placeholder="Occupation" value="<?=$reslut['sibl1_occupa'];?>"></td>
                                                            <td><textarea name="sibling_address<?=$i;?>" rows="1" placeholder="Address"></textarea></td>
                                                            <td><input type="number" name="sibling_phone<?=$i;?>" placeholder="Phone number" value="<?=$reslut['sibl1_phone'];?>" min="0"></td>
                                                        </tr>
                                                <?php   
                                                        $i++;
                                                    }
                                                    echo '</table>';
                                                    }
                                                ?>  
                                            </div>
                                        </div>

                                        <div class="edit-container">
                                            <div class="content">
                                                <button class="edit-btn" type="submit" name="edit_profile"><i class="fa fa-save" aria-hidden="true"></i> Edit profile</button>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>

    <!-- footer of system  -->
    <?php include_once('../ims-include/footer.php');?>

    <!-- include JavaScript in web page  -->
    <?php include_once('../ims-include/script-tage.php');?>
        
    <script>
        $(document).ready(function(){
            $('#your_sibling').on('input', function(){
                var your_sibling = $(this).val();
                if(your_sibling){
                    $.ajax({
                        type:'POST',
                        url:'student-ajax.php',
                        data:'your_sibling='+your_sibling,
                        success:function(html){
                            $('#sibling_list').html(html);
                        }
                    }); 
                }else{
                    $.ajax({
                        success:function(html){
                            $('#sibling_list').html('');
                        }
                    }); 
                }
                      
            });
            

            // $(function() {
            //     $("#datepicker").datepicker({
            //         showAnim: "slideDown",
            //         minDate: 0,
            //         maxDate: "+1M",
            //         dateFormat: "dd/mmm/yy"
            //     });
            // });
           
        });


        function preview(evt){
            // alert("hello");
            let img = "";
            let src = URL.createObjectURL(evt.target.files[0]);
            img += "<img src ='"+ src +"' width = '100%'>";
            document.getElementById("profile_preview").innerHTML = img;
            // alert("Hi");
        }
    </script>

</body>
</html>
