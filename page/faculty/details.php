<?php include '../_includes/header.php'; ?> 
<title>Students Score and Answers - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 

    $score_info = "SELECT * FROM tbl_score WHERE scr_id=:scr_id";
    $score_info = DB::query($score_info, array(':scr_id'=> $_GET['score']))[0];

     
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
    
    $questionnaire_info = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $questionnaire_info = DB::query($questionnaire_info, array(':qstnnr_id'=>$score_info['qstnnr_id']))[0];


    $student_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $student_info = DB::query($student_info, array('usr_id'=> $score_info['usr_id'] ))[0];
 
    $course = "SELECT descriptitle FROM tbl_course WHERE crs_id=:crs_id";
    $course = DB::query($course, array(':crs_id'=>$score_info['crs_id']))[0]['descriptitle'];

?> 
 
<!-- / php  -->
 
<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="content">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<a href="score.php?questionnaire=<?= $score_info['qstnnr_id'] ?>&&course=<?= $score_info['crs_id'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 

<div class="row">
    <div class="col-sm-12">
        <center>
            <h4 style="margin-bottom: 0px;"><u><?= $student_info['firstname'] ?> <?= $student_info['middlename'] ?> <?= $student_info['lastname'] ?></u></h4>
            <p class="paragraph"><b><?= $questionnaire_info['title'] ?></b></p> 
            <p class="paragraph"><?= $course ?></p> 
            <p class="paragraph"><?= $score_info['created_at'] ?></p> 
            <p class="paragraph"> Score:  <?= $score_info['score'] ?> / <?= $questionnaire_info['items'] ?> items</p>

            
        </center>
    </div>
</div>
<hr>
  
<?php 
    // $student_answer = "SELECT * FROM tbl_answer WHERE usr_id=:usr_id AND qstnnr_id=:qstnnr_id";
    // $student_answer_data = [
    //     'usr_id'    => $score_info['usr_id'],
    //     'qstnnr_id' => $score_info['qstnnr_id'] 
    // ];
    // $student_answer = DB::query($student_answer, $student_answer_data);

    $questions = "SELECT * FROM tbl_question WHERE qstnnr_id=:qstnnr_id";
    $questions_data = [
        'qstnnr_id'=> $score_info['qstnnr_id']
    ];
    $questions = DB::query($questions, $questions_data);
    $counter = 1;
    foreach($questions as $question){
       
        $student_answer = "SELECT * FROM tbl_answer WHERE qstn_id=:qstn_id";
        $student_answer_data = [
            'qstn_id' => $question['qstn_id']
        ];
        if($student_answer = DB::query($student_answer, $student_answer_data)){
     
?> 
    <div class="row">
        <div class="col-sm-12">
            <div class="panel <?= ($student_answer[0]['correct'] == 1) ? "panel-success": "panel-danger" ?>" style="margin-left: 10px; margin-right: 10px"> 
            <div class="panel-heading">
                <?= ($student_answer[0]['correct'] == 1) ? "Correct": "Wrong" ?>
                </div>

            <div class="panel-body">
             
                    <p <?= ($student_answer[0]['correct'] == 1) ? "class='text-success'": "class='text-danger' " ?> 
                        >  
                        <?= $counter ?>.
                        <?= $question['question'] ?>                        
                    </p> 
                    <div class="radio">
                    <?= ($question['answer'] == 'a')? '<label class="text-success">': '<label>'?>
                            <input 
                                type="radio"  
                                disabled
                                <?= ($student_answer[0]['answer'] == 'a') ? "checked": "" ?>
                                >A.  <?= $question['a'] ?>
                        </label>
                    </div>

                    <div class="radio">
                    <?= ($question['answer'] == 'b')? '<label class="text-success">': '<label>'?>
                            <input 
                                type="radio"
                                disabled  
                                <?= ($student_answer[0]['answer'] == 'b') ? "checked": "" ?>
                                >B.  <?= $question['b'] ?>
                        </label>
                    </div>

                    <div class="radio"> 
                          <?= ($question['answer'] == 'c')? '<label class="text-success">': '<label>'?>
                            <input 
                                type="radio"  
                                disabled
                                <?= ($student_answer[0]['answer'] == 'c') ? "checked": "" ?>
                                >C.  <?= $question['c'] ?>
                        </label>
                    </div>

                    <div class="radio"> 
                    <?= ($question['answer'] == 'd')? '<label class="text-success">': '<label>'?>
                            <input 
                                type="radio"  
                                disabled
                                <?= ($student_answer[0]['answer'] == 'd') ? "checked": "" ?>
                                >D.  <?= $question['d'] ?>
                        </label>
                    </div>
                </div>
                
                <!-- /content                       -->
            </div>
        </div>
    </div>
<?php   
        }else{
?>
 <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-danger" style="margin-left: 10px; margin-right: 10px">
                <div class="panel-heading">
                    No Answer
                </div>
                <div class="panel-body">
                    <?= $counter .". ". $question['question']?>
                    <div>
                        <div class="radio">
                            <?= ($question['answer'] == 'a')? '<label class="text-success text-bold">': '<label>'?>
                                <input 
                                    type="radio"
                                    disabled 
                                />A. <?= $question['a'] ?>
                            </label>
                        </div>

                        <div class="radio">
                            <?= ($question['answer'] == 'b')? '<label class="text-success text-bold">': '<label>'?>
                                <input 
                                    type="radio"
                                    disabled 
                                />B. <?= $question['b'] ?>
                            </label>
                        </div>

                        <div class="radio">
                            <?= ($question['answer'] == 'c')? '<label class="text-success text-bold">': '<label>'?>
                                <input 
                                    type="radio"
                                    disabled 
                                />C. <?= $question['c'] ?>
                            </label>
                        </div>

                        <div class="radio">
                            <?= ($question['answer'] == 'd')? '<label class="text-success text-bold">': '<label>'?>
                                <input 
                                    type="radio"
                                    disabled 
                                />D. <?= $question['d'] ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
        }
$counter++;  
    }
?> 


<div class="row">
    <div class="col-sm-12">
        <center>
            <h4 style="margin-bottom: 0px;"><u><?= $student_info['firstname'] ?> <?= $student_info['middlename'] ?> <?= $student_info['lastname'] ?></u></h4>
            <p class="paragraph"><b><?= $questionnaire_info['title'] ?></b></p> 
            <p class="paragraph">Course</p> 
            <p class="paragraph">date and time</p> 
            <p class="paragraph"> Score:  <?= $score_info['score'] ?> / <?= $questionnaire_info['items'] ?> items</p>

            
        </center>
    </div>
</div>

<a href="score.php?questionnaire=<?= $score_info['qstnnr_id'] ?>&&course=<?= $score_info['crs_id'] ?>" class="btn btn-info btn-sm pull-right"> Close</a> 

 
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