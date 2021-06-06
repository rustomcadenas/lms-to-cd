<?php 
    session_start();

    include '../../classes/db.php';
    $received_data = json_decode(file_get_contents("php://input"));

    if($received_data->action == 'saveFaculty'){  
        $data = [
            'usr_id'    => uniqid(),
            'std_id'    => $received_data->id, 
            'firstname' => $received_data->firstname,
            'middlename'=> $received_data->middlename,
            'lastname'  => $received_data->lastname,
            'email'     => $received_data->email,
            'pass'      => password_hash($received_data->password, PASSWORD_DEFAULT),
            'profilepic'=> 'icons/user.svg', 
            'department'=> $received_data->department,
            'types'      => $received_data->type
        ];  
        $result = "INSERT INTO tbl_user(usr_id, std_id, firstname, middlename, lastname, email, pass, profilepic, department, types) VALUES(
            :usr_id, :std_id, :firstname, :middlename, :lastname, :email, :pass, :profilepic, :department, :types
        )";
        $result = DB::query($result, $data);
        mkdir("../../uploads/profiles/".$data['usr_id']);
        unset($data);
        if($result){ 
            $data = [
                'success'   => true, 
            ];
        }else{
            // $hello = $result;
            $data = [
                'success'   => false, 
            ];
        } 
        echo json_encode($data);
    }
elseif($received_data->action == 'fetch_announcements'){
    
    $fetch_announcements = "SELECT * FROM tbl_announcement ORDER BY created_at DESC"; 
    $fetch_announcements = DB::query($fetch_announcements);  
    echo json_encode($fetch_announcements);
}
elseif($received_data->action == 'delete_post'){
    $data = [
        'id'    => $received_data->post_id
    ];
    $delete_file = "SELECT uploaded FROM tbl_announcement WHERE id=:id";
    $delete_file = DB::query($delete_file, $data)[0]['uploaded'];
    unlink("../../".$delete_file);

    $delete_post = "DELETE FROM tbl_announcement WHERE id=:id";
    $delete_post = DB::query($delete_post, $data);

    unset($data);
    if($delete_post){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    } 
    echo json_encode($data); 
}
elseif($received_data->action == 'edit_post'){
    $data = [
        'id'    => $received_data->id
    ];

    $get_post = "SELECT * FROM tbl_announcement WHERE id=:id";
    $get_post = DB::query($get_post, $data)[0];

    echo json_encode($get_post);
}
?>