<?php


if(isset($_POST['btnSubmit'])){
    extract($_POST);
    $stmt = "SELECT * FROM users WHERE username = '$username' and password='$password'";
    $result = mysqli_query($con, $stmt);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['member_type'] = $row['usertype'];
        $_SESSION['member_id'] = $row['User_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['img'] = $row['profile'];
        $_SESSION['fname'] = $row['Fullname'];
        $_SESSION['dat'] = $row['regdate'];
        $_SESSION['groupID'] = $row['groupID'];
        header('location: index');
    }else{
       $_SESSION['msg'] = 'Invalid username or password';
    }
}


function disp_msg(){
    if(isset($_SESSION['msg'])){
        
        echo  " <p class='alert alert-danger text-light'> " . $_SESSION['msg'] . "</p> " ;
        unset($_SESSION['msg']);
    }
}





?>