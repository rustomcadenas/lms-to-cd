<?php session_start();

include '../../classes/db.php';
$received_data = json_decode(file_get_contents("php://input"));

if($received_data->action == 'sendMessage'){
    $data = [
        'msg'   => $received_data->message,
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id
    ];

    $sendMessage = "INSERT INTO tbl_forum (msg, usr_id, crs_id) VALUES(
            :msg, :usr_id, :crs_id
    )";
    $sendMessage = DB::query($sendMessage, $data); 

    echo json_encode(print_r($sendMessage));
}
elseif($received_data->action == 'fetchMessage'){
    $data = [
        'crs_id'    => $received_data->crs_id 
    ];

    $messages = "SELECT * FROM tbl_forum INNER JOIN tbl_user on tbl_user.usr_id = tbl_forum.usr_id and crs_id = :crs_id ORDER BY tbl_forum.created_at DESC LIMIT 30";
    $messages = DB::query($messages, $data);

    echo json_encode($messages);

}

?>