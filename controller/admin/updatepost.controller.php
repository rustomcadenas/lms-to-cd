<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');


if(isset($_FILES['file']['name'])){
    $filename = $_FILES['file']['name'];
}else{
    $filename = '';
}  

$addpost = '';

if($filename != ""){
    
$data = [  
    'title'         => $_POST['title'],
    'announcement'  => $_POST['announcement'], 
    'uploaded'      => '',
    'filetype'      => '', 
    'audience'      => $_POST['audience'],
    'id'            => $_POST['id']
];  

    $type = $_FILES['file']['type'];
    $type = explode('/', $type);
    $data['filetype'] = $type[0]; 
  
    $foldername = 'announcement';

    $data['uploaded'] = "uploads/".$foldername."/".basename($filename);
    $target = "../../". $data['uploaded'];
    move_uploaded_file($_FILES['file']['tmp_name'], $target);   

    $addpost = "UPDATE tbl_announcement SET
    title=:title,
    announcement=:announcement, 
    uploaded=:uploaded, 
    filetype=:filetype, 
    audience=:audience
    WHERE 
    id=:id";

    $addpost = DB::query($addpost, $data);
}else{

    $data = [  
        'title'         => $_POST['title'],
        'announcement'  => $_POST['announcement'],  
        'audience'      => $_POST['audience'],
        'id'            => $_POST['id']
    ];  
    $addpost = "UPDATE tbl_announcement SET
    title=:title,
    announcement=:announcement,  
    audience=:audience
    WHERE 
    id=:id";

    $addpost = DB::query($addpost, $data);

} 

unset($data);
if($addpost){
    $data['success'] = true;
}else{
    $data['success'] = false;
}



echo json_encode($data);

