<?php 

include 'db.php';

$tablename = "tbl_announcement";

$result = "create table ". $tablename ." (
    id int(6) unsigned auto_increment primary key,
    announcement varchar(255) not null,  
    usr_id varchar(255) not null,  
    audience varchar(255) not null, 
    active varchar(2) default '1', 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 

$result = DB::query($result); 
echo print_r($result); 

?>