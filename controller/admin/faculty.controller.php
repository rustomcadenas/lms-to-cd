<?php  session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'faculty_details'){
    $data = [
        'usr_id' => $received_data->usr_id
    ];
    
    $faculty_details = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $faculty_details = DB::query($faculty_details, $data)[0];

    echo json_encode($faculty_details); 
}
elseif($received_data->action == 'faculty_courses'){
    $data = [
        'usr_id' => $received_data->usr_id
    ];

    $faculty_courses = "SELECT * FROM tbl_course WHERE usr_id=:usr_id";
    $faculty_courses = DB::query($faculty_courses, $data);

    echo json_encode($faculty_courses);
}
elseif($received_data->action == 'update_password'){
    $data = [
        'password'  => $received_data->password,
        'newPass'   => password_hash($received_data->newPassword, PASSWORD_DEFAULT),
        'usr_id'    => $received_data->faculty_id 
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
elseif($received_data->action == 'update_faculty'){
    $data = [ 
        'std_id' => $received_data->std_id ,
        'department' => $received_data->department ,
        'email' => $received_data->email ,
        'firstname' => $received_data->firstname ,
        'middlename' => $received_data->middlename ,
        'lastname' => $received_data->lastname , 
        'usr_id'    => $received_data->usr_id
    ]; 

    $update_faculty = "UPDATE tbl_user SET 
                            std_id=:std_id, 
                            firstname=:firstname, 
                            middlename=:middlename, 
                            lastname=:lastname, 
                            email=:email,
                            department=:department
                            WHERE usr_id=:usr_id";
    $update_faculty = DB::query($update_faculty, $data); 

    if($update_faculty){
        unset($data);
        $data['success'] = true;
    }else{
        unset($data);
        $data['success'] = false;
    }

    echo json_encode($data);
}

 
?>