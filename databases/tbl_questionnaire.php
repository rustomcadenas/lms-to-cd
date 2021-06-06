<?php 

include 'db.php';

$tablename = "tbl_questionnaire";

$result = "create table ". $tablename ." (
    id int(11) unsigned auto_increment primary key,
    qstnnr_id varchar(255) not null,
    title varchar(255),
    descript varchar(255),
    types varchar(100), 
    items int(11),
    expiration varchar(255),
    timer int(11),
    answerkey varchar(1) default '0',
    status varchar(100) default 'inactive',
    usr_id varchar(255) not null,
    crs_id varchar(255) not null, 
    active varchar(1) default '1',
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>