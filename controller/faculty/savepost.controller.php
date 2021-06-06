<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');

if(isset($_FILES['file']['name'])){
    $filename = $_FILES['file']['name'];
}else{
    $filename = '';
}
$types = '';
$data = [ 
    'pst_id'        => uniqid(),
    'title'         => $_POST['title'],
    'descript'      => $_POST['description'],
    'locale'        => '',
    'types'         => '', 
    'namefile'      => $filename, 
    'usr_id'        => $_SESSION['loggedID'],
    'crs_id'        => $_POST['crs_id']
];  

 
if($filename != ""){
    $type = $_FILES['file']['type'];
    $type = explode('/', $type);
    $data['types'] = $type[0];
    $data['namefile'] = $filename;
 

    $foldername = $data['crs_id'];

    $data['locale'] = "uploads/".$foldername."/".basename($filename);
    $target = "../../". $data['locale'];
    move_uploaded_file($_FILES['file']['tmp_name'], $target);  
}

$savePost = "INSERT INTO tbl_post (pst_id, title, descript, locale, types, namefile, usr_id, crs_id) VALUES(
    :pst_id, :title, :descript, :locale, :types, :namefile, :usr_id, :crs_id
)";

$savePost = DB::query($savePost, $data);  
$types = $data['types'];
unset($data);
if($savePost){
    $data['success'] = 'true';
    $data['types'] = $types;
}else{
    $data['success'] = 'false';
    $data['types'] = $types;
} 
echo json_encode($data);
?>