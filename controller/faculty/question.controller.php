<?php session_start();
include '../../classes/db.php'; 

$received_data = json_decode(file_get_contents("php://input"));


if($received_data->action == 'fetchAllQuestion'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];
    $fetchAllQuestion = "SELECT * FROM tbl_question WHERE qstnnr_id=:qstnnr_id ORDER BY created_at DESC";
    $fetchAllQuestion = DB::query($fetchAllQuestion, $data);

    echo json_encode($fetchAllQuestion);
}

elseif($received_data->action == 'fetchQuestionnaire'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id
    ];
    $fetchQuestionnaire = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id ORDER BY created_at DESC";
    $fetchQuestionnaire = DB::query($fetchQuestionnaire, $data)[0];

    echo json_encode($fetchQuestionnaire);
}

elseif($received_data->action == 'save_question'){
    $data = [
        'qstn_id'   => uniqid(),
        'question'  => $received_data->question,
        'a'         => $received_data->a,
        'b'         => $received_data->b,
        'c'         => $received_data->c,
        'd'         => $received_data->d, 
        'answer'    => $received_data->answer,
        'usr_id'    => $_SESSION['loggedID'],
        'crs_id'    => $received_data->crs_id,
        'qstnnr_id' => $received_data->qstnnr_id
    ];

    $save_question = "INSERT INTO tbl_question (qstn_id, question, a, b, c, d, answer, usr_id, crs_id, qstnnr_id) VALUES(
        :qstn_id, :question, :a, :b, :c, :d, :answer, :usr_id, :crs_id, :qstnnr_id
    )"; 
    $save_question = DB::query($save_question, $data);
    unset($data);
    if($save_question){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    } 
    echo json_encode($data);
}

elseif($received_data->action == 'viewAnswer'){
    $data = [
        'qstn_id' => $received_data->qstn_id
    ];

    $viewAnswer = "SELECT answer FROM tbl_question WHERE qstn_id=:qstn_id";
    $viewAnswer = DB::query($viewAnswer, $data)[0]['answer'];

    echo json_encode($viewAnswer); 
}elseif($received_data->action == 'deleteQuestion'){
    $data = [
        'qstn_id' => $received_data->qstn_id
    ]; 

    $old_locale = "SELECT file_locale from tbl_question where qstn_id = :qstn_id";
    $old_locale = DB::query($old_locale, $data)[0][0];

    if($old_locale){ 
        unlink('../../'. $received_data->file_locale);
    }
 
   

    $deleteQuestion = "DELETE FROM tbl_question WHERE qstn_id=:qstn_id";
    $deleteQuestion = DB::query($deleteQuestion, $data);
    unset($data);
    if($deleteQuestion){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }
    echo json_encode($data); 
}
elseif($received_data->action == 'editQuestion'){
    $data = [
        'qstn_id'   => $received_data->qstn_id
    ];

    $editQuestion = "SELECT * FROM tbl_question WHERE qstn_id=:qstn_id";
    $editQuestion = DB::query($editQuestion, $data)[0];

    echo json_encode($editQuestion); 
}
elseif($received_data->action == 'update_question'){
    $data = [ 
        'question'  => $received_data->question,
        'a'  => $received_data->a,
        'b'  => $received_data->b,
        'c'  => $received_data->c,
        'd'  => $received_data->d,
        'answer'  => $received_data->answer,
        'qstn_id'  => $received_data->qstn_id
    ];

    $update_question = "UPDATE tbl_question SET question=:question, a=:a, b=:b, c=:c, d=:d, answer=:answer WHERE qstn_id=:qstn_id";
    $update_question = DB::query($update_question, $data);

    unset($data);
    if($update_question){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }
   
    echo json_encode($data);

}
 