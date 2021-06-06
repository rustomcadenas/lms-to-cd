<?php 

include 'db.php';

$tablename = "tbl_comment";

$result = "create table ". $tablename ." (
    id int(6) unsigned auto_increment primary key,
    cmmnt_id varchar(255) not null unique,
    comment varchar(255),  
    usr_id varchar(255) not null, 
    crs_id varchar(255) not null,
    pst_id varchar(255) not null, 
    active varchar(2) default '1',
    repliedto_id varchar(255),
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 

$result = DB::query($result); 
echo print_r($result); 

?>