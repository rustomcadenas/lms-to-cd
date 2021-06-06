<?php session_start();

include '../classes/db.php';


if(isset($_POST['btn_signup'])){
    $data = [
        'usr_id'    => uniqid(),
        'firstname' => $_POST['firstname'],
        'lastname'  => $_POST['lastname'],
        'email'     => $_POST['email'],
        'pass'  => password_hash($_POST['pass'], PASSWORD_DEFAULT),
        'profilepic'=> 'icons/user.svg',
        'types'      => 'Student'
    ]; 

    $checkEmail = "SELECT * FROM tbl_user where email = :email";
    $checkEmail = DB::query($checkEmail, array(':email'=>$data['email']));

    if(count($checkEmail) != 0){
        $data['message'] = "Email Already Exist in our Database."; 
        $data['success'] = false; 
        $_SESSION['temp'] = $data; 
        header("location: ../create.php");
    }
    else{ 
        $create = "INSERT INTO tbl_user(usr_id, firstname, lastname, email, pass, profilepic, types) VALUES(
            :usr_id, :firstname, :lastname, :email, :pass, :profilepic, :types
        )"; 
        $create = DB::query($create, $data);
         
        if($create){
            mkdir("../uploads/profiles/".$data['usr_id']);
            unset($data); 
            $data['message'] = "Account Successfully Created. Please Log in"; 
            $data['success'] = true;
            $_SESSION['temp'] = $data;
            header("location: ../login.php");

        }else{
            $data['message'] = "Something Went Wrong. Please Try Again Later. ";
            $data['success'] = false; 
            $_SESSION['temp'] = $data; 
            header("location: ../create.php");
        }
    }  
 
}

?>