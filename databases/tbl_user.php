<?php 

include 'db.php';

$tablename = "tbl_user";

$result = "CREATE TABLE ". $tablename ." (
    id int(6) unsigned auto_increment primary key,
    usr_id varchar(255) not null unique,
    std_id varchar(255) unique,
    firstname varchar(100) not null,
    middlename varchar(100),
    lastname varchar(100) not null,
    email varchar(150) not null,
    pass varchar(255) not null,
    profilepic varchar(255),
    department varchar(255),
    types varchar(50) not null,
    active varchar(2) default '1',
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo $result;

?>  