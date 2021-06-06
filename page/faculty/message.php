<?php include '../_includes/header.php'; ?>
<?php 
    $crs_id = $_GET['course'];
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$crs_id ))[0]; 


    if(count($course_info) == 0){
        header("location: course.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

    $studentcourse = "SELECT * FROM tbl_studentcourse WHERE crs_id=:crs_id";
    $studentcourse_data = [
        'crs_id'  => $crs_id
    ];
    $studentcourse = DB::query($studentcourse, $studentcourse_data);  

    $instructor_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $instructor_info = DB::query($instructor_info, array('usr_id'=>$course_info['usr_id']))[0];

    $messages = "SELECT * FROM tbl_message WHERE from_usr_id=:from_usr_id AND to_usr_id=:to_usr_id AND crs_id=:crs_id ORDER BY created_at DESC";
    $messages_data = [ 
        'from_usr_id'  => $user_info['usr_id'],
        'to_usr_id'  => $instructor_info['usr_id'],
        'crs_id'  => $crs_id
    ];
    $messages = DB::query($messages, $messages_data);
 
?> 

<title>Questionnaire - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <?php include '../_includes/studentnav.php' ?>
    <?php include '../_includes/breadcrumbs.php'; ?>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   
 
<div class="row">
    <div class="col-sm-12">
        <h4>Inbox</h4>
    </div>
</div>
<!-- /.row  -->

<?php 

// $students_with_message = 
// "SELECT DISTINCT from_usr_id
// FROM 
// tbl_message 
// WHERE 
// to_usr_id=:to_usr_id AND 
// crs_id=:crs_id AND 
// from_usr_id!=:to_usr_id 
// ORDER BY created_at DESC";

$students_with_message = 
"SELECT DISTINCT std_id
FROM 
tbl_message 
WHERE  
crs_id=:crs_id  
ORDER BY created_at DESC";

$students_with_message_data = [ 
    'crs_id'    => $crs_id
];

// $students_with_message = "SELECT * 
// FROM tbl_message 
// WHERE from_usr_id IN (SELECT MAX(created_at) FROM tbl_message 
// WHERE 
// to_usr_id=:to_usr_id AND 
// crs_id=:crs_id AND 
// from_usr_id!=:to_usr_id
// GROUP BY created_at)";

// $students_with_message = 
// "SELECT DISTINCT from_usr_id, created_at 
// (SELECT max(created_at) 
// FROM tbl_message 
// WHERE 
// to_usr_id=:to_usr_id AND 
// crs_id=:crs_id AND 
// from_usr_id!=:to_usr_id)
// ORDER BY created_at ASC";

$students_with_message = DB::query($students_with_message, $students_with_message_data);
// echo "<pre>";
// print_r($students_with_message);
// echo "</pre>"; 

?>


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   



<div class="row"> 
    <div class="col-sm-12">
        <div class="form-group"> 

        
<?php 

foreach($students_with_message as $message){   

    $list_of_students_message = "SELECT * FROM tbl_user WHERE usr_id='". $message['std_id'] ."'";
    $list_of_students_message = DB::query($list_of_students_message);

    $student_message_one = "SELECT * FROM tbl_message WHERE 
                            std_id='". $message["std_id"] ."' AND 
                            crs_id='". $crs_id ."' 
                            ORDER BY created_at DESC 
                            Limit 1";

    $student_message_one = DB::query($student_message_one); 

    // echo "<pre>";
    // print_r($student_message_one);
    // echo "</pre>";

    // echo "<label>". $list_of_students_message[0]['firstname'] ."</label>";
    // echo "<label>". $student_message_one[0]['msg'] ."</label>"; 

    

?> 

                <p class="comment-form" style="margin-top: 10px;">  
                   
                        <img src="../../<?= $list_of_students_message[0]['profilepic'] ?>" style="height: 25px; width: 25px" class="pp">
                        <b style="color: rgb(51, 122, 183)"><?= $list_of_students_message[0]['firstname'] ." ". $list_of_students_message[0]['lastname'] ?> : </b>
            
                        <span class="paragraph"> 
                            <span style="color: #337ab7">
                                <?= ($_SESSION['loggedID'] == $student_message_one[0]['from_usr_id'] ) ? 'You:': '' ?>
                            </span>
                            <?= $student_message_one[0]['msg']?>
                        </span>
                        <br><span class="paragraph"><small> {{format_date('<?= $student_message_one[0]['created_at'] ?>')}}</small> 
                        </span>
                 
                        <a href="message_view.php?course=<?= $crs_id ?>&&student=<?= $list_of_students_message[0]['usr_id'] ?>" class="btn btn-info pull-right" style="margin-top: -18px">View All Message</a>
     
                </p>   
                
<?php  
    }
?>
         </div>
    </div> 
</div>
<!-- /.row  -->


<!-- ============================================================================================= /CONTENT  -->




</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   
<br>

<script>
     
     var app = new Vue({
          el: "#content",
          data: {
          
          },
          methods: {
            
            format_date: function (date){
                if(date == ''){
                    return;
                }

                var date = new Date(date); 

                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
            },
          }
      });
  
</script>

 
<?php include '../_includes/footer.php'; ?>
