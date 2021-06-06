<?php session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'save_course'){
    $data = [
        'crs_id'        => uniqid(), 
        'num'           => $received_data->number,
        'section'       => $received_data->section, 
        'descriptitle'  => $received_data->descriptitle, 
        'start_time'    => $received_data->start_time, 
        'end_time'      => $received_data->end_time,  
        'schedule'      => $received_data->days, 
        'accesscode'    => uniqid(), 
        'usr_id'        => $_SESSION['loggedID']
    ]; 

    $saveCourse = "INSERT INTO tbl_course(crs_id, num, section, descriptitle, start_time, end_time, schedule, accesscode, usr_id) VALUES(
            :crs_id, :num, :section, :descriptitle, :start_time, :end_time, :schedule, :accesscode, :usr_id
    )";

    $saveCourse = DB::query($saveCourse, $data);  
    if($saveCourse){
        $success = true; 
        mkdir("../../uploads/".$data['crs_id']);
    }else{
        $success = false; 
    }
    echo json_encode($success);
    
}
elseif($received_data->action == 'fetchAllCourse'){
    $fetchAllCourses = "SELECT * FROM tbl_course WHERE  usr_id = :usr_id ORDER BY created_at DESC";
    $fetchAllCourses = DB::query($fetchAllCourses, array(':usr_id'=>$_SESSION['loggedID']));
    
    if(count($fetchAllCourses) > 0){ 
        echo json_encode($fetchAllCourses);
    }else{
        echo json_encode('empty');
    }



}
elseif($received_data->action == 'edit_Course'){
    $data = [
        'crs_id' => $received_data->crs_id
    ];

    $fetchSingle = "SELECT * FROM tbl_course WHERE crs_id = :crs_id";
    $fetchSingle = DB::query($fetchSingle, $data)[0];
  
    echo json_encode($fetchSingle);
}
elseif($received_data->action == 'update_course'){  
    $data = [  
        'num'           => $received_data->number,
        'section'       => $received_data->section, 
        'descriptitle'  => $received_data->descriptitle, 
        'start_time'    => $received_data->start_time, 
        'end_time'      => $received_data->end_time,  
        'schedule'      => $received_data->days,  
        'crs_id'        => $received_data->crs_id
    ]; 

    $updateCourse = "UPDATE tbl_course SET num=:num, section=:section, descriptitle=:descriptitle, start_time=:start_time, end_time=:end_time, schedule=:schedule WHERE crs_id = :crs_id";
    $updateCourse = DB::query($updateCourse, $data);
 
    echo json_encode($updateCourse);

}
elseif($received_data->action == 'delete_course'){
    $data = [
        'crs_id' => $received_data->crs_id
    ];
    $deleteCourse = "DELETE FROM tbl_course WHERE crs_id = :crs_id";
    $deleteCourse = DB::query($deleteCourse, $data); 
    if($deleteCourse){
        $error = false; 
        rmdir("../../uploads/".$data['crs_id']);
    }else{
        $error = true;
    }
    echo json_encode($error);
}
elseif($received_data->action == 'generateCode'){
    echo json_encode(uniqid());
}
elseif($received_data->action == 'update_accesscode'){
    $data = [
        'accesscode'    => $received_data->accesscode, 
        'crs_id'        => $received_data->crs_id 
    ];

    $checkIfAccessCodeExist = "SELECT accesscode from tbl_course WHERE accesscode=:accesscode";
    $checkIfAccessCodeExist = DB::query($checkIfAccessCodeExist, array(':accesscode'=>$data['accesscode']));
    if(count($checkIfAccessCodeExist) > 0){
        echo json_encode("exist");
    }else{
        $updateAccessCode = "UPDATE tbl_course SET accesscode=:accesscode WHERE crs_id=:crs_id";
        $updateAccessCode = DB::query($updateAccessCode, $data);
    }
}



?>