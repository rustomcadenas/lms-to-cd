<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');


if(isset($_POST['action']) == 'btn_upProfile'){
    $filename = $_FILES['file']['name'];
    $data = [
        'profilepic' => '',
        'usr_id'    => $_SESSION['loggedID']
    ]; 
    
    $data['profilepic'] = "uploads/profiles/".$data['usr_id']."/".basename($filename);
    $target = "../../".  $data['profilepic'];
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target)){
        $deleteFile = "SELECT profilepic FROM tbl_user WHERE usr_id=:usr_id";
        $deleteFile = DB::query($deleteFile, array(':usr_id'=>$data['usr_id']))[0]['profilepic']; 
        if($deleteFile != 'icons/user.svg'){ 
            unlink("../../". $deleteFile); 
        }
        $upProfile = "UPDATE tbl_user SET profilepic=:profilepic WHERE usr_id=:usr_id";
        $upProfile = DB::query($upProfile, $data);
        if($upProfile){
            unset($data);
            $data['success'] = true;
            $data['message'] = "Profile Picture Successfully Updated. ";

        }else{
            $data['success'] = false;
        } 
    }else{
        $data['success'] = false;
    }

    $_SESSION['temp'] = $data;
    echo json_encode($data);
}

 