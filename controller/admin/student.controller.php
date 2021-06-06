<?php  session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'student_details'){
    $data = [
        'usr_id' => $received_data->usr_id
    ];
    
    $student_details = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $student_details = DB::query($student_details, $data)[0];

    echo json_encode($student_details); 
}
elseif($received_data->action == 'student_courses'){
    $data = [
        'usr_id' => $received_data->usr_id
    ];
    $mycourses = [];

    $courses = "SELECT crs_id FROM tbl_studentcourse WHERE usr_id=:usr_id";
    $courses = DB::query($courses, $data);
 
    foreach($courses as $course){
        $student_courses = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
        $student_courses = DB::query($student_courses, array(':crs_id'=>$course['crs_id']));
        
        $mycourses = $student_courses;
    }
   

    echo json_encode($mycourses);
}
elseif($received_data->action == 'update_password'){
    $data = [
        'password'  => $received_data->password,
        'newPass'   => password_hash($received_data->newPassword, PASSWORD_DEFAULT),
        'usr_id'    => $received_data->student_id 
    ];

    $currentPassword = "SELECT pass from tbl_user WHERE usr_id=:usr_id";
    $currentPassword = DB::query($currentPassword, array(':usr_id'=>$_SESSION['loggedID']))[0]['pass'];

    if(password_verify($data['password'], $currentPassword)){
        $updatePassword = "UPDATE tbl_user SET pass=:newPass WHERE usr_id=:usr_id";
        $updatePassword = DB::query($updatePassword, array(':newPass'=>$data['newPass'], ':usr_id'=>$data['usr_id']));

        unset($data);
        $data['success'] = true; 

    }else{
        unset($data);
        $data['success'] = false; 
    }

    echo json_encode($data);
}
elseif($received_data->action == 'set_active'){
    $data = [
        'active' => $received_data->active,
        'usr_id'    => $received_data->usr_id
    ];

    $set_active = "UPDATE tbl_user SET active=:active WHERE usr_id=:usr_id";
    $set_active = DB::query($set_active, $data);
 
}
elseif($received_data->action == 'update_student'){
    $data = [ 
        'std_id' => $received_data->std_id ,
        'department' => $received_data->department ,
        'email' => $received_data->email ,
        'firstname' => $received_data->firstname ,
        'middlename' => $received_data->middlename ,
        'lastname' => $received_data->lastname , 
        'usr_id'    => $received_data->usr_id
    ]; 

    $update_student = "UPDATE tbl_user SET 
                            std_id=:std_id, 
                            firstname=:firstname, 
                            middlename=:middlename, 
                            lastname=:lastname, 
                            email=:email,
                            department=:department
                            WHERE usr_id=:usr_id";
    $update_student = DB::query($update_student, $data); 

    if($update_student){
        unset($data);
        $data['success'] = true;
    }else{
        unset($data);
        $data['success'] = false;
    }

    echo json_encode($data);
}

 
?>