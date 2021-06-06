<?php 
    session_start();
    include '../../classes/db.php';

    if(isset($_POST['btn_send_message'])){

        if(isset($_FILES['attached_file']['name'])){
            $filename = $_FILES['attached_file']['name'];
        }else{
            $filename = '';
        }
        $type = '';

        $data = [ 
            'msg'   => $_POST['message'],
            'attached_file' => $filename, 
            'name_file'     => '',
            'file_type'     => '', 
            'from_usr_id'  => $_SESSION['loggedID'],
            'to_usr_id'    => $_POST['to'],
            'crs_id'    => $_POST['crs_id']
        ];
 
        
        if($data['attached_file'] != ""){
            $type = $_FILES['attached_file']['type'];
            $type = explode('/', $type);
            $data['file_type'] = $type[0];
            $data['name_file'] = $filename; 
        
            $foldername = $data['crs_id'];
            
            if(!file_exists("../../uploads/".$foldername."/messages/". $data['from_usr_id'])){
                mkdir("../../uploads/".$foldername."/messages/". $data['from_usr_id']);
            }
               
             

            $data['attached_file'] = "uploads/".$foldername."/messages/". $data['from_usr_id']."/".basename($filename);
            $target = "../../". $data['attached_file'];
            move_uploaded_file($_FILES['attached_file']['tmp_name'], $target);  
        }
    
        $insertMessage = "INSERT INTO tbl_message 
        (msg, attached_file, name_file, file_type, from_usr_id, to_usr_id, crs_id)
        VALUES
        (:msg, :attached_file, :name_file, :file_type, :from_usr_id, :to_usr_id, :crs_id)";

        $insertMessage = DB::query($insertMessage, $data);

        header("location: ../../page/faculty/message_view.php?course=".$data['crs_id']."&&student=".$data['to_usr_id']);


    }

?>