<?php
    include_once "config.php";
    session_start();
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    
    if(!empty($email) && !empty($password)){
        //let check user enter email is match to the db and it is already in db
        $sql = mysqli_query($conn,"SELECT * FROM users WHERE email='{$email}' && password='{$password}'");
        if(mysqli_num_rows($sql) > 0){//if users credentials matched
            $row = mysqli_fetch_assoc($sql);
            $status = "Active now";
            $sql2 = mysqli_query($conn,"UPDATE users SET status = '{$status}' WHERE unique_id={$row['unique_id']}");
            if($sql2){
                $_SESSION['unique_id']=$row['unique_id'];
            }
            echo "success";
        }else{
            echo "Email or Password is incorrect";
        }

    } else {
        echo "All input are required";
    }
?>