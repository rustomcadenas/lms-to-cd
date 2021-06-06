<?php session_start();

include '../../classes/db.php';

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action =='btn_upAcc'){
    $data = [  
        'firstname'     => $received_data->firstname,
        'middlename'    => $received_data->middlename,
        'lastname'      => $received_data->lastname,
        'email'         => $received_data->email,
        'usr_id'        => $_SESSION['loggedID']
    ]; 
    
    $updateAccount = "UPDATE tbl_user SET firstname=:firstname, middlename=:middlename, lastname=:lastname, email=:email WHERE usr_id=:usr_id";
    $updateAccount = DB::query($updateAccount, $data);
    unset($data);
    if($updateAccount){
        $data['success']    = true; 
        $data['message'] = "Account Successfully Updated. "; 
    }else{
        $data['success']    = false; 
    }
    $_SESSION['temp'] = $data;
    echo json_encode($data); 
}
elseif($received_data->action == 'btn_upPass'){
    $data = [
        'password'  => $received_data->password,
        'newPass'   => password_hash($received_data->newPassword, PASSWORD_DEFAULT)
    ];

    $currentPassword = "SELECT pass from tbl_user WHERE usr_id=:usr_id";
    $currentPassword = DB::query($currentPassword, array(':usr_id'=>$_SESSION['loggedID']))[0]['pass'];

    if(password_verify($data['password'], $currentPassword)){
        $updatePassword = "UPDATE tbl_user SET pass=:newPass WHERE usr_id=:usr_id";
        $updatePassword = DB::query($updatePassword, array(':newPass'=>$data['newPass'], ':usr_id'=>$_SESSION['loggedID']));

        unset($data);
        $data['success'] = true; 

    }else{
        unset($data);
        $data['success'] = false; 
    }

    echo json_encode($data);
}
 