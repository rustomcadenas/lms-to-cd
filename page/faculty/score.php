<?php include '../_includes/header.php'; 
 

?> 
<title>Students Score and Answers - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $questionnaire_id = $_GET['questionnaire'];
    $course_id = $_GET['course'];

    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
    
    $questionnaire_info = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $questionnaire_info = DB::query($questionnaire_info, array(':qstnnr_id'=>$questionnaire_id))[0];

    // SELECT * FROM tbl_forum INNER JOIN tbl_user on tbl_user.usr_id = tbl_forum.usr_id and crs_id = 6 ORDER BY tbl_forum.created_at ASC

    $student_score_infos = "SELECT * FROM tbl_score INNER JOIN tbl_user ON tbl_user.usr_id = tbl_score.usr_id and tbl_score.qstnnr_id=:qstnnr_id";
    $student_score_infos = DB::query($student_score_infos, array(':qstnnr_id'=> $questionnaire_id));
    

 
?> 
 
<!-- / php  -->
 
<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="content">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<a href="questionnaire.php?course=<?= $_GET['course'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 

<div class="row">
    <div class="col-sm-12">
        <center>
            <p class="paragraph"><b><?= $questionnaire_info['title'] ?></b></p>  
            <p class="paragraph"><?= $questionnaire_info['items'] ?> items</p>
        </center>
    </div>
</div>
<hr>
<div class="row">  
    <div class="col-sm-12 margin-b-20">   
        <h4>Students Score</h4>
    </div>
</div>   

<?php 
    foreach($student_score_infos as $student_score_info){  
        $percent = ($student_score_info['score']/$questionnaire_info['items'])*100;

?>

    <div class="row">
        <div class="col-sm-4">
            <img src="../../<?= $student_score_info['profilepic'] ?>" alt="Prifile Pic" class="cmmnt-pp">
             <label>
                 <?= $student_score_info['firstname'] ?>
                 <?= $student_score_info['middlename'] ?>
                 <?= $student_score_info['lastname'] ?>
            </label>
        </div>
        <div class="col-sm-4">
            <label><?= $student_score_info['score'] ?> points | <?= (($percent) >=50) ? $percent.'% | Pass' : ($student_score_info['score']*100).'% | Fail'?></label>
        </div>
        <div class="col-sm-4">
            <a class="btn btn-info btn-sm" href="details.php?score=<?= $student_score_info['scr_id'] ?>">View Details</a>
        </div>
        <br>
        <hr> 

        <!-- <form action="" method="post">
            <button type="submit" href="" name="exportToExcel" class="btn btn-success btn-sm">Export to Excel</button> 
        </form>
         -->

        <a class="btn btn-success btn-sm" href="fileToExcel.php?questionnaire=<?= $_GET['questionnaire'] ?>&&course=<?= $_GET['course'] ?>"> Export to Excel </a>

    </div> 
<?php  
}
if(!count($student_score_infos) > 0){
    echo "Students not yet submitted their answer in this questionniare.";
}

?>
 
 
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
    
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<br>

<script> 
    // let url = new URL(window.location.href);
    // let searchParams = new URLSearchParams(url.search);  

    var app = new Vue({
        el: "#content",
        data: { 
            
        },
        methods: {
          
        },
        created: function (){
            
        }
    });
  
</script> 
<?php include '../_includes/footer.php'; ?>





