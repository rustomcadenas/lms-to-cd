<?php  include '../../validation/validate.php';
include '../../classes/db.php';
$loggedInfo = "SELECT * FROM tbl_user where usr_id=:usr_id";
$loggedInfo = DB::query($loggedInfo, array(':usr_id'=>$_SESSION['loggedID']))[0];

 ?>

<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../icons/logo.png">
        <link rel="stylesheet" href="../../assets/css/turner.css"> 
        <link rel="stylesheet" href="../../assets/css/tomas.css">
        <script src="../../assets/js/vue.js"></script>
        <script src="../../assets/js/axios.js"></script>


 