<?php
$showError ="false";
if($_SERVER['REQUEST_METHOD']=="POST"){
    include "_dbconnect.php";
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];

    
    //Check whether this email exist or not
    
    $existSql = "SELECT * FROM `users` WHERE `user_email` LIKE '$user_email'"; 
    $result= mysqli_query($conn, $existSql);
    $numRows= mysqli_num_rows($result);
    if($numRows>0){
        $showError="Email already in used";
        // echo "exist";
    }
    else{
            if($pass==$cpass){
            $hash = password_hash($pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ( '$user_email', '$hash', current_timestamp())";
            $result= mysqli_query($conn, $sql);
            $showAlert= false;
            if($result){
                $showAlert= true;
                header ("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
            }
                else{
                            $showError = "Password no matched";
                            // echo " password not matched";
}
    }
    header ("Location: /forum/index.php?signupsuccess=flase&error=$showError");
}


?>