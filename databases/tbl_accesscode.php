<?php 

include 'db.php';

$tablename = "tbl_accesscode";

$result = "create table ". $tablename ." (
    access_id int(11) unsigned auto_increment primary key,
    accesscode text unique,
    crs_id int(11) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>