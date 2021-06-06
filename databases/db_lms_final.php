<?php 

include 'db.php';

$database = "lms_final";

$result = DB::query("create database ".$database);
if($result){
    echo "Database successfully created.";
}else{
    print_r($result);
}

?>