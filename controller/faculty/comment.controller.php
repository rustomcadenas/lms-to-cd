<?php  session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'save_comment'){
 
    $data = [
        'cmmnt_id'  => uniqid(),
        'comment'   => $received_data->comment,
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id,
        'pst_id'    => $received_data->pst_id
    ];
    echo json_encode(print_r($data));

    $saveComment = "INSERT INTO tbl_comment (cmmnt_id, comment, usr_id, crs_id, pst_id) VALUES(
        :cmmnt_id, :comment, :usr_id, :crs_id, :pst_id
    )";

    $saveComment = DB::query($saveComment, $data);

}
elseif($received_data->action == 'fetch_comments'){
    $data = [
        'pst_id'    => $received_data->pst_id
    ]; 
    $fetchComment = "SELECT * FROM tbl_comment INNER JOIN tbl_user on tbl_user.usr_id = tbl_comment.usr_id and tbl_comment.pst_id=:pst_id ORDER BY tbl_comment.created_at DESC";
    $fetchComment = DB::query($fetchComment, $data); 
    echo json_encode($fetchComment); 

}




?>
