<?php 

include 'db.php';

$tablename = "tbl_course";

$result = "create table ". $tablename ." (
    id int(6) unsigned auto_increment primary key,
    crs_id varchar(255) not null unique,
    num varchar(100),
    section varchar(100),
    descriptitle varchar(255) not null,
    start_time varchar(20),
    end_time varchar(20),
    schedule varchar(10),
    accesscode varchar(150),
    usr_id varchar(255) not null, 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 

$result = DB::query($result); 
echo print_r($result); 

?>