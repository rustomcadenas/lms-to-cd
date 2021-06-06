<?php session_start();
include '../../classes/db.php';  

header('Access-Control-Allow-Origin: *');


if(isset($_POST['req']) == 'update'){  
    $types = '';
    if(empty($_FILES['file'])){
        $data = [
            'title'         => $_POST['title'],
            'descript'   => $_POST['description'], 
            'pst_id'        => $_POST['pst_id'] 
        ];
        $updatePost = "UPDATE tbl_post SET title=:title, descript=:descript WHERE pst_id=:pst_id";
        $updatePost = DB::query($updatePost, $data);  
    }else{     
            $filename  = $_FILES['file']['name'];
            $data = [
                'title'         => $_POST['title'],
                'descript'   => $_POST['description'], 
                'locale'    => '',
                'types'     => '',
                'namefile'  => '', 
                'pst_id'        => $_POST['pst_id'],
            ]; 
            $type = $_FILES['file']['type'];
            $type = explode('/', $type);
            $data['types'] = $type[0]; //types
            $data['namefile'] = $filename; //namefile 

            $foldername = $_POST['crs_id'];

            $data['locale'] = "uploads/".$foldername."/".basename($filename); //location
            $target = "../../". $data['locale'];
            move_uploaded_file($_FILES['file']['tmp_name'], $target);  

            $updatePost = "Update tbl_post set title=:title, descript=:descript, locale=:locale, types=:types, namefile=:namefile WHERE pst_id=:pst_id";
            $updatePost = DB::query($updatePost, $data);  
            $types = $data['types'];
    } 
        unset($data);
        if($updatePost){
            $data['success'] = true;
            $data['types'] = $types;
        }else{
            $data['success'] = false;
            $data['types'] = $types;
        } 
        echo json_encode($data);   

}

?>

