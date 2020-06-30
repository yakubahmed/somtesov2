<?php 
session_start();
unset($_SESSION['member_type']) ;
unset($_SESSION['member_id']) ;
unset($_SESSION['username']) ;
unset($_SESSION['img']);
unset($_SESSION['fname']);
unset($_SESSION['dat']) ;
unset($_SESSION['groupID']);
header('location: login');

?>