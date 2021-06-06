<?php 

include 'db.php';

$tablename = "tbl_answer";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    ans_id varchar(255) not null,
    answer varchar(100) not null,
    correct varchar(10) not null,
    usr_id  varchar(255) not null,
    crs_id  varchar(255) not null,
    qstn_id  varchar(255) not null, 
    qstnnr_id  varchar(255) not null, 
    active varchar(2) default '1',
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>