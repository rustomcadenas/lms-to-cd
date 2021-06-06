<?php session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));


if($received_data->action == 'remove_student'){
    $data = [
        'usr_id' => $received_data->usr_id
    ];

    $remove_student_to_course = "DELETE 
    FROM tbl_studentcourse WHERE usr_id=:usr_id";

    $remove_student_to_course = DB::query($remove_student_to_course, $data);
    unset($data);
    if($remove_student_to_course){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }
    echo json_encode($data);
}