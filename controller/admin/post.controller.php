<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');


if(isset($_FILES['file']['name'])){
    $filename = $_FILES['file']['name'];
}else{
    $filename = '';
} 

$data = [  
    'title'         => $_POST['title'],
    'announcement'  => $_POST['announcement'], 
    'uploaded'      => '',
    'filetype'      => '',
    'usr_id'        => $_SESSION['loggedID'],
    'audience'      => $_POST['audience'] 
];  



if($filename != ""){
    $type = $_FILES['file']['type'];
    $type = explode('/', $type);
    $data['filetype'] = $type[0]; 
  
    $foldername = 'announcement';

    $data['uploaded'] = "uploads/".$foldername."/".basename($filename);
    $target = "../../". $data['uploaded'];
    move_uploaded_file($_FILES['file']['tmp_name'], $target);  
}

$addpost = "INSERT INTO 
    tbl_announcement (
        title,
        announcement, 
        uploaded,
        filetype,
        usr_id,
        audience
    ) VALUES (
        :title,
        :announcement, 
        :uploaded,
        :filetype,
        :usr_id,
        :audience
    )";

$addpost = DB::query($addpost, $data);

unset($data);
if($addpost){
    $data['success'] = true;
}else{
    $data['success'] = false;
}



echo json_encode($data);

