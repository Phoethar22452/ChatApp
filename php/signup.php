<?php
    include_once "config.php";
    session_start();
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if(!empty($fname) && !empty($lname) &&  !empty($email) && !empty($password) ){
        //lets check user email is valid or not
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){//if email is valid
            $sql  = mysqli_query($conn,"SELECT * FROM users WHERE email = '{$email}' ");
            if(mysqli_num_rows($sql) > 0 ){//if email is already exist
                echo "$email - this email already exist";
            }else{
                //lets check user upload file or not
                if(isset($_FILES['image'])){//if file is uploaded
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    //let'explode image and get the last extension like jpg png
                    $img_explode = explode(".",$img_name);
                    $img_ext = end($img_explode);//we get the extension of uploaded image 

                    $extensions = ['png','jpeg','jpg'];//these are some valid img ext and in array
                    if(in_array($img_ext,$extensions)==true){//if user upload img ext is match with our permitted type
                        $time = time();//this will return us current time
                        //we need this time to compare the user's file uploaded time and then to generate a unique name

                        //movingthe image
                        $new_image_name = $time.$img_name;
                        move_uploaded_file($tmp_name,"images/". $new_image_name);

                        $status = "Active now";// once user signin he will be active
                        $random_id = rand(time(),10000000);//creating random id for user
                        //let's insert all user data insert table
                        $sql2 = mysqli_query($conn,"INSERT INTO `users`(`unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`) VALUES ('{$random_id}','{$fname}','{$lname}','{$email}','{$password}','{$new_image_name}','{$status}') ");

                        if($sql2){
                            $sql3 = mysqli_query($conn,"SELECT * FROM users WHERE email='{$email}'");
                            if(mysqli_num_rows($sql3) > 0){
                                $row = mysqli_fetch_assoc($sql3);
                                $_SESSION['unique_id']=$row['unique_id'];//using this session we used user unique_id in other php file
                            }
                        }
                    }else{
                        echo "Please select an image file - jpeg jpg png"; 
                    }

                }else{
                    echo "Please select an image file";
                }
            }
        }else{
            echo "$email - This is not an email";
        }
        
    }else{
        echo "All input field are required";
    }
?>