<?php session_start();

include '../../classes/db.php';

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action =='add_comment'){
    $data = [
        'cmmnt_id'  => uniqid(),
        'comment'   => $received_data->comment,
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id,
        'pst_id'    => $received_data->pst_id 
    ];

    $add_comment = "INSERT INTO tbl_comment (cmmnt_id, comment, usr_id, crs_id, pst_id) VALUES(
        :cmmnt_id, :comment, :usr_id, :crs_id, :pst_id
    )";

    $add_comment = DB::query($add_comment, $data);
    unset($data);
    if($add_comment){
        $data['success'] = true;
    }else{
        $datap['success'] = false;
    }

    echo json_encode($data);
}
elseif($received_data->action == 'fetch_allComment')
{
    $data = [  
        'pst_id'    => $received_data->pst_id 
    ];
    
    $fetch_allComment = "SELECT * FROM tbl_comment INNER JOIN tbl_user on tbl_user.usr_id = tbl_comment.usr_id AND tbl_comment.pst_id=:pst_id ORDER BY tbl_comment.created_at DESC";
    $fetch_allComment = DB::query($fetch_allComment, $data);

    echo json_encode($fetch_allComment);

}