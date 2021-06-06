<?php 

include 'db.php';

$tablename = "tbl_studentcourse";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    stdcrse_id varchar(255) not null,
    usr_id varchar(255) not null,
    crs_id varchar(255) not null,
    active varchar(10),
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>