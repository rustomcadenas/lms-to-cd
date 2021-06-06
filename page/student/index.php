<?php include '../_includes/header.php'; ?> 
<title>Faculty - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

?> 
 
<!-- / php  -->
 
<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="index">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
    <div class="row"> 
        <div class="col-sm-12">
            <div class="panel panel-info">
                <div class="panel-body">
                    <h3 class="text-center"> 
                    My Courses  
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
 
        <div class="row">
            <div class="col-sm-12">
                <center> 
                    <h4>Announcement</h4>
                </center>
            </div>
        </div>

        <?php 
            $announcement = "SELECT * FROM tbl_announcement WHERE audience='Students' OR audience='Students and Faculties'";
            $announcement = DB::query($announcement);

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