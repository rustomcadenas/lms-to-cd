<?php include '../_includes/header.php'; ?> 
<title>Faculty - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0];

    $fetchAllQstnnr = "SELECT * FROM tbl_questionnaire WHERE usr_id=:usr_id and active='1' ORDER BY created_at DESC";
    $fetchAllQstnnr = DB::query($fetchAllQstnnr, array(':usr_id'=> $_SESSION['loggedID'])); 
 

?> 
 
<!-- / php  -->
 
<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="index">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<h3>Recent Activities</h3>
<div class="row"> 

        <?php 
            foreach($fetchAllQstnnr as $qstnnr){
                $courseName = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
                $courseName = DB::query($courseName, array(':crs_id'=> $qstnnr['crs_id']))[0]; 

                $answered = "select * from tbl_score where crs_id=:crs_id and qstnnr_id=:qstnnr_id";
                $answered = DB::query($answered, array(':crs_id'=> $qstnnr['crs_id'], ':qstnnr_id' => $qstnnr['qstnnr_id']));
                $answered = count($answered);
            }
        ?>

        <div class="col-sm-4">
            <div class="panel panel-info">
                <div class="panel-body">
                <center>
                    <h4><?= $qstnnr['title'] ?></h4>
                    <p style="margin-bottom: 0px"><?= $courseName['descriptitle'] ?></p>
                    <p style="margin-bottom: 0px"><?= $courseName['num'] ?></p>
                    <h6 class="margin-bottom: 0px <?= ($qstnnr['active'] == '1') ? 'text-success': 'text-danger' ?>"><?= ($qstnnr['active'] == '1') ? 'Active': 'Expired' ?></h6>
                    <h6><?= $answered ?> student/s answered</h6>
                </center>
                </div> 

                <div class="panel-footer">  
                    <center>
                    <a href="score.php?questionnaire=<?=$qstnnr['qstnnr_id']?>&&course=<?=$qstnnr['crs_id']?>" class="btn btn-success btn-sm">
                        View
                    </a>
                    </center>
                </div>
            </div>
        </div>
         


    </div>











<hr>

<!-- Handle COurses =========================================================== -->
    <div class="row"> 
        <div class="col-sm-12">
            <div class="panel panel-info">
                <div class="panel-body">
                    <h3 class="text-center"> 
                    Handled Courses  
                    </h3>
                </div> 

                <div class="panel-footer">
                    <center>
                    <a href="course.php" class="btn btn-info">
                    View
                    </a>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <hr> 

        <?php 
            $announcement = "SELECT * FROM tbl_announcement WHERE audience='Faculties' OR audience='Students and Faculties'";
            $announcement = DB::query($announcement);

            if($announcement){
                echo '
                <div class="row">
                    <div class="col-sm-12">
                        <center> 
                            <h4>Announcement</h4>
                        </center>
                    </div>
                </div>
        ';
            }

            foreach($announcement as $post){ 
        ?>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default" style="margin-right: 50px; margin-left: 50px;">  
                    <div class="panel-heading">
                        <label for=""> <?= $post['title'] ?> </label>
                    </div>
                    <div class="panel-body">
                        <?= $post['announcement'] ?>
                        <br>
                        <center>
                            <?php if($post['filetype'] == 'image'){ ?>
                                    <img src="../../<?= $post['uploaded'] ?>" alt="" style="height: 200px;">
                            <?php }
                                elseif($post['filetype'] == 'application' || $post['filetype'] == 'text'){ 
                            ?>
                                    <br>
                                    <img src="../../icons/document.svg" alt="" style="height: 50px;">
                                    <br>
                                    <a href="../../icons/document.svg">download</a>
                            <?php } ?>
                        </center> 
                    </div>
                </div>
            </div> 
        </div>
        <?php 
            }
        ?>

<!-- /.row  -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
    
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
  
</script> 
<?php include '../_includes/footer.php'; ?>