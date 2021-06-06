<?php session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));


if($received_data->action == 'save_qstnnr'){
 
    $data = [
        'qstnnr_id' => uniqid(),
        'title'     => $received_data->title,
        'descript'  => $received_data->description,
        'types'     => $received_data->types,
        'items'     => $received_data->items,
        'expiration'=> $received_data->expiration,
        'timer'     => $received_data->timer,
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id
    ];

    $saveQstnnr = "INSERT INTO tbl_questionnaire (qstnnr_id, title, descript, types, items, expiration, timer, usr_id, crs_id) VALUES(
        :qstnnr_id, :title, :descript, :types, :items, :expiration, :timer, :usr_id, :crs_id
    )";
    $saveQstnnr = DB::query($saveQstnnr, $data);
        
    unset($data);
    if($saveQstnnr){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

    echo json_encode($data);
}
elseif($received_data->action == 'fetchAllQstnnr'){
    $data = [ 
        'crs_id'    => $received_data->crs_id
    ];

    $fetchAllQstnnr = "SELECT * FROM tbl_questionnaire WHERE crs_id=:crs_id and active='1' ORDER BY created_at DESC";
  
    $fetchAllQstnnr = DB::query($fetchAllQstnnr, $data); 
    echo json_encode($fetchAllQstnnr);
}
elseif($received_data->action == 'delete_qstnnr'){
    $data = [ 
        'qstnnr_id'    => $received_data->qstnnr_id
    ];

    $delete_qstnnr = "DELETE FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id"; 
    $delete_qstnnr = DB::query($delete_qstnnr, $data); 
    unset($data);
    if($delete_qstnnr){
        $data['success'] = true;
    }else{
        $data['success'] = false; 
    }

    echo json_encode($data);
}
elseif($received_data->action == 'getnumQuestion'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];

    $getnumQuestion = "SELECT qstnnr_id FROM tbl_question WHERE qstnnr_id=:qstnnr_id";
    $getnumQuestion = DB::query($getnumQuestion, $data); 
    $num = count($getnumQuestion);
    echo json_encode($num);
}

elseif($received_data->action == 'fetchSingle'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];

    $fetchSingle = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $fetchSingle = DB::query($fetchSingle, $data)[0];
    
    echo json_encode($fetchSingle); 
}
elseif($received_data->action == 'update_qstnnr'){
    $data = [ 
        'title'     => $received_data->title,
        'descript'  => $received_data->description,
        'types'     => $received_data->types,
        'items'     => $received_data->items,
        'expiration'=> $received_data->expiration,
        'timer'     => $received_data->timer,
        'qstnnr_id' => $received_data->qstnnr_id
    ];

    $saveQstnnr = "UPDATE tbl_questionnaire SET title=:title, descript=:descript, types=:types, items=:items, expiration=:expiration, timer=:timer WHERE qstnnr_id=:qstnnr_id";
    $saveQstnnr = DB::query($saveQstnnr, $data);
        
    unset($data);
    if($saveQstnnr){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

    echo json_encode($data);
}
elseif($received_data->action == 'updateStatus'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];
    $getStatus = "SELECT status FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $getStatus = DB::query($getStatus, $data)[0];

    $newStatus = ($getStatus['status'] == 'active') ? 'inactive' : 'active';

    $updateStatus = "UPDATE tbl_questionnaire SET status=:status WHERE qstnnr_id=:qstnnr_id";
    $updateStatus = DB::query($updateStatus, array(':status'=>$newStatus, ':qstnnr_id'=>$data['qstnnr_id']));

    unset($data);
    if($updateStatus){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

echo json_encode($data);
}
elseif($received_data->action == 'answerkey'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];
    $getAnswerkey = "SELECT answerkey FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $getAnswerkey = DB::query($getAnswerkey, $data)[0];

    $newAnswerkey = ($getAnswerkey['answerkey'] == '0') ? '1' : '0';

    $updateStatus = "UPDATE tbl_questionnaire SET answerkey=:answerkey WHERE qstnnr_id=:qstnnr_id";
    $updateStatus = DB::query($updateStatus, array(':answerkey'=>$newAnswerkey, ':qstnnr_id'=>$data['qstnnr_id']));

    unset($data);
    if($updateStatus){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

    echo json_encode($data);
}
?>