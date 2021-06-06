<?php 

include 'db.php';

$tablename = "tbl_question";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    qstn_id varchar(255) not null unique,
    question text,
    a varchar(100),
    b varchar(100),
    c varchar(100), 
    d varchar(100), 
    answer varchar(100),
    file_locale varchar(255),
    file_names varchar(255),
    file_types varchar(255),
    usr_id varchar(255) not null,
    crs_id varchar(255) not null, 
    qstnnr_id varchar(255) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>