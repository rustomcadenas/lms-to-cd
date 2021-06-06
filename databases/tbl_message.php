<?php 

include 'db.php';

$tablename = "tbl_message";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key, 
    title varchar(255),
    message varchar(255),  
    attached_file varchar(255),
    active varchar(2) default '1',
    from_usr_id varchar(255) not null,
    to_usr_id varchar(255) not null, 
    crs_id varchar(255) not null, 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 
$result = DB::query($result); 
echo print_r($result); 

?>