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
        <div class="col-sm-12 margin-b-20">   
            <h4>Questionnaire</h4>
        </div>
    </div> 

    <?php  

    $fclty_id = "SELECT usr_id FROM tbl_course WHERE crs_id=:crs_id";
    $fclty_id = DB::query($fclty_id, array(':crs_id'=>$_GET['course']))[0]['usr_id'];

    $questionnaires = "SELECT * FROM tbl_questionnaire WHERE usr_id=:fclty_id and crs_id=:crs_id and status = 'active' ORDER BY created_at DESC";
    $questionnairesData = [
        'fclty_id'  => $fclty_id,
        'crs_id'    => $_GET['course']
    ];
    $questionnaires = DB::query($questionnaires, $questionnairesData);
    
    if(count($questionnaires) == 0){
        echo "No Questionnaire Available";
    }else{ 
        foreach($questionnaires as $questionnaire){ 

            // $check_if_timer_started = "SELECT * FROM tbl_timer WHERE stud_id=:stud_id and qstnnr_id=:qstnnr_id";
            // $check_if_timer_started_data = [
            //     'stud_id'  => $_SESSION['loggedID'],
            //     'qstnnr_id'  => $questionnaire['qstnnr_id']
            // ];
            // $check_if_timer_started = DB::query($check_if_timer_started, $check_if_timer_started_data);
         
?> 
    <div class="row">
            <div class="col-sm-12">
                <div class="panel"
                    v-bind:class="[validateExpiration('<?= $questionnaire['expiration'] ?>') ? 'panel-danger': 'panel-default']"
                    > 
                    <div class="panel-heading">  
                        <p style="margin-bottom: -5px; "> 
                        <span class="qstnnr_title">
                            <?= $questionnaire['title']?>
                         {{validateExpiration('<?= $questionnaire['expiration'] ?>') ? ' (Expired)': ''}} 
                        </span>
                    </p> 

                    </div> 

                    <div class="panel-body"> 
                        <p class="paragraph"> Description&emsp;- &emsp; <?= $questionnaire['descript']?></p>
                        <p class="paragraph"> Type &emsp;&emsp;&emsp; &nbsp;- &emsp; <?= $questionnaire['types']?></p> 
                        <p class="paragraph"
                        v-bind:class="[validateExpiration('<?= $questionnaire['expiration'] ?>') ? 'text-danger': '']"
                            > Due Date &emsp; &nbsp;- &emsp; {{format_date('<?= $questionnaire['expiration'] ?>')}} 
                        </p> 
                        <p class="paragraph">
                            Timer &emsp; &nbsp;&emsp; &nbsp;- &emsp; <?= $questionnaire['timer'] ?> Minutes  
                        </p> 
<?php 
    $studentProgress = "SELECT * FROM tbl_answer WHERE qstnnr_id = :qstnnr_id and usr_id=:usr_id";
    $studentProgress = DB::query($studentProgress, array(':qstnnr_id'=>$questionnaire['qstnnr_id'], ':usr_id'=>$user_info['usr_id']));
    $studentProgress = count($studentProgress);

    $questionItems = "SELECT * FROM tbl_question WHERE qstnnr_id=:qstnnr_id and usr_id=:faculty";
    $questionItems = DB::query($questionItems, array('qstnnr_id'=>$questionnaire['qstnnr_id'], 'faculty'=>$questionnaire['usr_id']));
    $questionItems = count($questionItems);

    $checkIfAnswered = "SELECT * FROM tbl_score WHERE qstnnr_id=:qstnnr_id and usr_id=:usr_id";
    $checkIfAnswered = DB::query($checkIfAnswered, array('qstnnr_id'=>$questionnaire['qstnnr_id'], 'usr_id'=>$_SESSION['loggedID'])); 
    $checkIfAnswered = count($checkIfAnswered);
    
?>

<?php if($questionnaire['answerkey'] == '1'){ 
        if($checkIfAnswered != 0){    
    ?> 
        <a href="answerkey.php?questionnaire=<?= $questionnaire['qstnnr_id'] ?>&&course=<?= $crs_id ?>" class="btn btn-info btn-sm">Answer Key</a>
    <?php }} ?>
</div>


                    <div class="panel-footer"> 
        <?php  if($checkIfAnswered == 0){ ?>
                <?php if($questionItems > 0){ ?>
                        <template v-if="!validateExpiration('<?= $questionnaire['expiration'] ?>')">
                            <a href="take.php?course=<?= $_GET['course']?>&&questionnaire=<?= $questionnaire['qstnnr_id'] ?>" class="btn btn-primary">
                                <?= ($studentProgress == $questionItems)? 'View and Submit': 'Take'?>
                            </a>
                        </template> 

                        <span style="margin-left: 20px;">Progress: <?= $studentProgress ?> / <?= $questionItems ?> items</span>
                        <span style="float: right; margin-top: 5px;">{{format_date('<?= $questionnaire['created_at'] ?>')}}</span>
                <?php } ?>
        <?php }else{ 

            ?>
                            <a class="btn btn-success" @click="showScore('<?= $questionnaire['qstnnr_id'] ?>')">
                                Show Score
                            </a>
                            <label for="">(Completed)</label>
        <?php } ?>
                    </div>  
                </div>  
            </div>
        </div>

<?php  }   } ?>
   


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
      var app = new Vue({
          el: "#content",
          methods: {
            showScore: function(id){
                axios.post("../../controller/students/questionnaire.controller.php", {
                    action: 'showScore',
                    qstnnr_id: id
                }).then(function(response){
                    alert(response.data);
                });
            },
            //date 
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
            validateExpiration: function(date){
                if(date == ''){
                    return;
                }
                var currentDate = new Date();  
                var date = new Date(date);
                if(currentDate > date){
                    return true;
                } 
            },
          }
      });
  
</script>

 
<?php include '../_includes/footer.php'; ?>
