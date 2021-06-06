<?php  session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'get_posts'){
    $data = [
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id,
        'active'    => '1'
    ];
    $fetchAllPost = "SELECT * FROM tbl_post WHERE usr_id=:usr_id AND crs_id=:crs_id AND active=:active ORDER BY created_at DESC";
    $fetchAllPost = DB::query($fetchAllPost, $data); 
    echo json_encode($fetchAllPost);
}
elseif($received_data->action == 'delete_post'){
    $data = [
        'active'    => '0',
        'pst_id'    => $received_data->pst_id
    ]; 
    $deleteComment = "DELETE FROM tbl_comment WHERE pst_id=:pst_id";
    DB::query($deleteComment, array(':pst_id'=>$data['pst_id']));

    $deletePost = "UPDATE tbl_post SET active=:active WHERE pst_id=:pst_id";
    $deletePost = DB::query($deletePost, $data);  

    unset($data); 
    if($deletePost){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }  
    echo json_encode($data);
}
elseif($received_data->action == 'save_post'){
    $data = [
        'title'=>$received_data->title,
        'description'=> $received_data->description
    ];
    echo json_encode($data);
}

elseif($received_data->action == 'get_post'){
    $data = [
        'pst_id' => $received_data->pst_id
    ]; 
    $fetchPost = "SELECT * FROM tbl_post WHERE pst_id = :pst_id";
    $fetchPost = DB::query($fetchPost, $data)[0];  
   
        echo json_encode($fetchPost);
  
}
elseif($received_data->action == 'fetch_userInfo'){ 
    $userInfo = "SELECT usr_id, firstname, lastname, types FROM tbl_user WHERE usr_id=:usr_id";
    $userInfo = DB::query($userInfo, array(':usr_id'=>$_SESSION['loggedID']))[0];

    echo json_encode($userInfo);

} 
?>