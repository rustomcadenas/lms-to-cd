<?php session_start();

include '../../classes/db.php';

$received_data = json_decode(file_get_contents("php://input"));


if($received_data->action == 'choose'){
     
    $data = [
        'qstn_id'   => $received_data->qstn_id,
        'answer'    => $received_data->std_answer,
        'qstnnr_id' => $received_data->qstnnr_id,
        'crs_id'    => $received_data->crs_id
    ];
    
    $correctAns = "SELECT answer FROM tbl_question where qstn_id=:qstn_id";
    $correctAns = DB::query($correctAns, array('qstn_id'=>$data['qstn_id']))[0]['answer'];
    
    if($correctAns == $data['answer']){
        $correct  = '1';
    }else{
        $correct = '0';
    }  

    $checkIfExist = "SELECT * FROM tbl_answer where qstn_id = :qstn_id AND usr_id=:usr_id";
    $checkIfExist = DB::query($checkIfExist, array(':qstn_id'=>$data['qstn_id'], ':usr_id'=>$_SESSION['loggedID']));

    if(count($checkIfExist) > 0){
        $updateAnswer = "UPDATE tbl_answer SET answer=:answer, correct=:correct WHERE qstn_id = :qstn_id";
        $updateAnswerData = [
            'answer'    => $data['answer'],
            'correct'   => $correct,
            'qstn_id'   => $data['qstn_id']
        ];
        DB::query($updateAnswer, $updateAnswerData);
    }else{ 
    
        $saveAnswer = "INSERT INTO tbl_answer (ans_id, answer, correct, usr_id, crs_id, qstn_id, qstnnr_id) VALUES(
           :ans_id, :answer, :correct, :usr_id, :crs_id, :qstn_id, :qstnnr_id
        )";
    
        $saveAnswerData = [ 
            'ans_id'    => uniqid(),
            'answer'    => $data['answer'], 
            'correct'   => $correct,
            'usr_id'    => $_SESSION['loggedID'],
            'crs_id'    => $data['crs_id'],
            'qstn_id'   => $data['qstn_id'],
            'qstnnr_id' => $data['qstnnr_id']
        ]; 
        $saveAnswer = DB::query($saveAnswer, $saveAnswerData); 
    }

   
  
}
elseif($received_data->action == 'submitQuestionnaire'){
  
    $data = [
        'usr_id'    => $_SESSION['loggedID'], 
        'qstnnr_id'  => $received_data->qstnnr_id,
        'crs_id'  => $received_data->crs_id 
    ];

    $score = "SELECT * FROM tbl_answer WHERE correct = 1 and usr_id=:usr_id and qstnnr_id = :qstnnr_id";
    $scoreData = [
        'usr_id'    => $data['usr_id'],
        'qstnnr_id' => $data['qstnnr_id']
    ];
    $score = DB::query($score, $scoreData); 
    $score = count($score);
     

    // $checkItems = "SELECT qstn_id FROM tbl_question WHERE qstnnr_id=:qstnnr_id";
    // $checkItems = DB::query($checkItems, array(':qstnnr_id'=>$data['qstnnr_id']));

    // $checkAnswer = "SELECT ans_id FROM tbl_answer WHERE usr_id=:usr_id and qstnnr_id=:qstnnr_id";
    // $checkAnswer = DB::query($checkAnswer, array(':usr_id'=>$data['usr_id'], 'qstnnr_id'=>$data['qstnnr_id']));

    // if($checkAnswer < $checkItems){
    //     $success = false;
    // }else{ 
        $saveScore = "INSERT INTO tbl_score (scr_id, score, usr_id, qstnnr_id, crs_id) VALUES(
            :scr_id, :score, :usr_id, :qstnnr_id, :crs_id
        )";
        $saveScoreData = [
            'scr_id'    => uniqid(),
            'score'     => $score,
            'usr_id'    => $data['usr_id'], 
            'qstnnr_id' => $data['qstnnr_id'], 
            'crs_id'    => $data['crs_id']
        ];
        DB::query($saveScore, $saveScoreData); 
    //     $success = true;
    // // }  

    // echo json_encode($success);
}
elseif($received_data->action == 'getTimer'){
    $data = [
        'timer_date' => $received_data->timer,
        'qstnnr_id' => $received_data->qstnnr_id,
        'stud_id'    => $_SESSION['loggedID'],
        'active'    => '1'
    ];

    $checkIfExist = "SELECT * FROM tbl_timer WHERE qstnnr_id=:qstnnr_id and stud_id=:stud_id";
    $checkIfExist_data = [
        'qstnnr_id'  => $data['qstnnr_id'],
        'stud_id'  => $data['stud_id']
    ]; 
    $checkIfExist = DB::query($checkIfExist, $checkIfExist_data);


    if(! (count($checkIfExist) > 0) ){ 
        $data['timer_date'] =  $received_data->timer;
        $data['active'] = '1';
        $insertTimer = "INSERT INTO tbl_timer (timer_date, qstnnr_id, stud_id, active) VALUES (:timer_date, :qstnnr_id, :stud_id, :active)";
        $insertTimer = DB::query($insertTimer, $data);  
        echo json_encode($data['timer_date']);
    } else{
         echo json_encode($checkIfExist[0]['timer_date']);
    }



}
 

?>