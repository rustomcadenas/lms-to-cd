<?php 

include 'db.php';

$tablename = "tbl_timer";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    timer_date varchar(255),
    stud_id varchar(255),
    qstnnr_id varchar(255),
    active varchar(1),
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)"; 
$result = DB::query($result); 
echo print_r($result); 

?>