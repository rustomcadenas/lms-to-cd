<?php 

include 'db.php';

$tablename = "tbl_post";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    pst_id varchar(255) not null unique,
    title varchar(255),
    descript varchar(255),
    locale varchar(255),
    types varchar(100),
    namefile varchar(255),
    active varchar(2) default '1',
    usr_id varchar(255) not null,
    crs_id varchar(255) not null, 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 
$result = DB::query($result); 
echo print_r($result); 

?>