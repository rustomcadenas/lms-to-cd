<?php session_start();

include '../../classes/db.php';

$received_data = json_decode(file_get_contents("php://input")); 
 
if($received_data->action == 'showScore'){
    $data = [
        'qstnnr_id' => $received_data->qstnnr_id,
        'usr_id'    => $_SESSION['loggedID']
    ];

    $score = "SELECT score FROM tbl_score WHERE qstnnr_id=:qstnnr_id and usr_id=:usr_id";
    $score = DB::query($score, $data)[0]['score'];

    $getQuestionnaireTitle = "SELECT title FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $getQuestionnaireTitle = DB::query($getQuestionnaireTitle, array('qstnnr_id'=>$data['qstnnr_id']))[0]['title'];

    echo json_encode("Questionnaire: ". $getQuestionnaireTitle ."\n". "Score: ". $score);
}
?>