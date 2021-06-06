<?php 
    session_start();
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);  
    $data = [];
    if(isset($uri_segments[3])) {
        if( 
            (($uri_segments[3] == 'admin' || $uri_segments[3] == 'Admin') && $_SESSION['loggedType'] != 'Admin') ||
            (($uri_segments[3] == 'faculty' || $uri_segments[3] == 'Faculty') && $_SESSION['loggedType'] != 'Faculty') ||
            (($uri_segments[3] == 'student' || $uri_segments[3] == 'Student') && $_SESSION['loggedType'] != 'Student')
        ){
            header("location: ../". $_SESSION['loggedType']);
        } 

    }

    if(isset($_SESSION['loggedType'])){
        if(
            $uri_segments[2] == 'login.php' ||
            $uri_segments[2] == 'create.php' || 
            $uri_segments[2] == 'index.php' || 
            $uri_segments[2] == 'forgotpass.php' ||
            $uri_segments[2] == ''
        ){
            header("location: page/". $_SESSION['loggedType'] ."/");
        }
    }
    elseif(!isset($_SESSION['loggedType'])){
        if(isset($uri_segments[3])){
            
           $data['message'] = "Please Log in first.";  
           $data['success'] = false;
           
           $_SESSION['temp2'] = $data; 

            header("location: ../../login.php");
        }
    }

    
    
?>
 