<?php include '../_includes/header.php'; ?>
<?php 
    $qstnnr_id = $_GET['questionnaire'];
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0]; 

    $questionnaire_info = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $questionnaire_info = DB::query($questionnaire_info, array(':qstnnr_id'=>$_GET['questionnaire']))[0]; 

    if(count($course_info) == 0 || count($questionnaire_info) == 0){
        header("location: index.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
     
    $score = "SELECT * FROM tbl_score WHERE usr_id=:usr_id and qstnnr_id=:qstnnr_id";
    $score_data = [
        'usr_id' => $_SESSION['loggedID'],
        'qstnnr_id' => $qstnnr_id
    ];
    $score = DB::query($score, $score_data)[0];

 
?> 

<title>Answer Key - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title>  
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <a href="questionnaire.php?course=<?= $_GET['course'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 
    <br><br>
    <hr>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->    

<div class="row">
    <div class="col-sm-12">
        <center>
               <p class="paragraph"><b><?= $questionnaire_info['title'] ?></b></p> 
            <p class="paragraph"><?= $course_info['descriptitle'] ?></p> 
            <p class="paragraph">{{formatDateTime('<?= $score['created_at'] ?>')}}</p> 
            <p class="paragraph"> Score:  <?= $score['score'] ?> / <?= $questionnaire_info['items'] ?> items</p>  
        </center>
    </div>
</div>
<hr> 

<?php 
    $questions = "SELECT * FROM tbl_question WHERE qstnnr_id=:qstnnr_id";
    $questions_data = [
        'qstnnr_id'=> $score['qstnnr_id']
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
                    <?= ($question['answer'] == 'a')? '<label class="text-success text-bold">': '<label>'?>
                            <input 
                                type="radio"  
                                disabled
                                <?= ($student_answer[0]['answer'] == 'a') ? "checked": "" ?>
                                >A.  <?= $question['a'] ?>
                        </label>
                    </div>

                    <div class="radio">
                    <?= ($question['answer'] == 'b')? '<label class="text-success text-bold">': '<label>'?>
                            <input 
                                type="radio"
                                disabled  
                                <?= ($student_answer[0]['answer'] == 'b') ? "checked": "" ?>
                                >B.  <?= $question['b'] ?>
                        </label>
                    </div>

                    <div class="radio"> 
                          <?= ($question['answer'] == 'c')? '<label class="text-success text-bold">': '<label>'?>
                            <input 
                                type="radio"  
                                disabled
                                <?= ($student_answer[0]['answer'] == 'c') ? "checked": "" ?>
                                >C.  <?= $question['c'] ?>
                        </label>
                    </div>

                    <div class="radio"> 
                    <?= ($question['answer'] == 'd')? '<label class="text-success text-bold">': '<label>'?>
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
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
    var app = new Vue({
        el: "#content", 
        data: {

        },
        methods: {
            formatDateTime: function(date){
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
                var m = (date.getMonth()+1 < 10) ? '0'+date.getMonth()+1 : date.getMonth()+1;
                var d = (date.getDate() < 10)? '0'+date.getDate() : date.getDate();
                return m + "/" + d + "/" + date.getFullYear() + "  " + strTime;
 
                
            },
        }
    });

</script>
 
 
<?php include '../_includes/footer.php'; ?>