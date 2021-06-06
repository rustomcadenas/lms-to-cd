<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');

if(isset($_POST['action']) == "save_question"){ 
  
    $data = [
        'qstn_id' =>  uniqid(),
        'question' => $_POST['question'],
        'a' => $_POST['a'],
        'b' => $_POST['b'],
        'c' => $_POST['c'],
        'd' => $_POST['d'], 
        'answer' => $_POST['answer'],
        'file_locale' => '',  
        'file_names' => $_POST['filename'],
        'file_types' => $_POST['filetype'],
        'usr_id' =>  $_SESSION['loggedID'],
        'crs_id' => $_POST['crs_id'],
        'qstnnr_id' => $_POST['qstnnr_id']
    ];  

    $foldername = $data['crs_id']; 
    $data['file_locale'] = "uploads/".$foldername."/".basename($data['file_names']); 
    $target = "../../". $data['file_locale'];
    try {
        move_uploaded_file($_FILES['thefile']['tmp_name'], $target);   
    } catch (\Throwable $th) {
        //throw $th;
    }
       
    $save_question = "INSERT INTO tbl_question (qstn_id, question, a, b, c, d, answer, file_locale, file_names, file_types, usr_id, crs_id, qstnnr_id) VALUES(
        :qstn_id, :question, :a, :b, :c, :d, :answer, :file_locale, :file_names, :file_types, :usr_id, :crs_id, :qstnnr_id
    )";

    $save_question = DB::query($save_question, $data);   

    // echo json_encode($data);
    unset($data);
    if($update_question){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

    echo json_encode($data);

}else if(isset($_POST['actioni']) == 'update_question'){

        // echo json_encode($_POST);

        if(isset($_FILES['thefile'])){ 
            
            $old_locale = "SELECT file_locale, crs_id from tbl_question where qstn_id = :qstn_id";
            $old_locale = DB::query($old_locale, array(':qstn_id' => $_POST['qstn_id']))[0];

            if(!empty($old_locale['file_locale'])){ 
                unlink('../../'. $old_locale['file_locale']);  
            }

            $data = [
                'question' => $_POST['question'],
                'a' => $_POST['a'],
                'b' => $_POST['b'],
                'c' => $_POST['c'],
                'd' => $_POST['d'],
                'answer' => $_POST['answer'],
                'file_locale' => '',
                'file_names' => $_POST['file_name'],
                'file_types' => $_POST['file_types'],
                'qstn_id' => $_POST['qstn_id'] 
            ];

            $foldername = $old_locale['crs_id']; 
            $data['file_locale'] = "uploads/".$foldername."/".basename($data['file_names']); 
            $target = "../../". $data['file_locale'];
            try { 
                move_uploaded_file($_FILES['thefile']['tmp_name'], $target); 
            } catch (\Throwable $th) { 
                $data['success'] = false;
            }
                
            $update_question = "UPDATE tbl_question SET question=:question, a=:a, b=:b, c=:c, d=:d, answer=:answer, file_locale=:file_locale, file_names=:file_names, file_types=:file_types WHERE qstn_id=:qstn_id";
            $update_question = DB::query($update_question, $data);
            
            unset($data);
            if($update_question){
                $data['success'] = true;
            }else{
                $data['success'] = false;
            } 
            
            echo json_encode($data); 

        }else{
            $data = [
                'question' => $_POST['question'],
                'a' => $_POST['a'],
                'b' => $_POST['b'],
                'c' => $_POST['c'],
                'd' => $_POST['d'],
                'answer' => $_POST['answer'], 
                'qstn_id' => $_POST['qstn_id'] 
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

        // unlink("../../". $_POST['']);


        // $data = [ 
        //     'question'  => $received_data->question,
        //     'a'  => $received_data->a,
        //     'b'  => $received_data->b,
        //     'c'  => $received_data->c,
        //     'd'  => $received_data->d,
        //     'answer'  => $received_data->answer,
        //     'qstn_id'  => $received_data->qstn_id
        // ];
    
        // $update_question = "UPDATE tbl_question SET question=:question, a=:a, b=:b, c=:c, d=:d, answer=:answer WHERE qstn_id=:qstn_id";
        // $update_question = DB::query($update_question, $data);
    
        // unset($data);
        // if($update_question){
        //     $data['success'] = true;
        // }else{
        //     $data['success'] = false;
        // }
       
        // echo json_encode($data);



}else if(isset($_POST['removefile']) == "true"){
    $old_locale = "SELECT file_locale, crs_id from tbl_question where qstn_id = :qstn_id";
    $old_locale = DB::query($old_locale, array(':qstn_id' => $_POST['qstn_id']))[0];

    unlink('../../'. $old_locale['file_locale']); 

    $data = [ 
        'file_locale' => '',
        'file_names' => '',
        'file_types' => '',
        'qstn_id' => $_POST['qstn_id']
    ];
    $update_question = "UPDATE tbl_question SET file_locale=:file_locale, file_names=:file_names, file_types=:file_types WHERE qstn_id=:qstn_id";
    $update_question = DB::query($update_question, $data); 

    

    unset($data);
    if($update_question){
        $data['success'] = true;
    }else{
        $data['success'] = false;
    }

    echo json_encode($data);
}else{
    echo json_encode("nothing");
}
?>
