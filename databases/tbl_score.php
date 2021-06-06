<?php 

include 'db.php';

$tablename = "tbl_score";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    scr_id varchar(255) not null,
    score int(11),
    usr_id varchar(255) not null,
    qstnnr_id varchar(255) not null,
    crs_id varchar(255) not null,  
    active varchar(2) default '1', 
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>