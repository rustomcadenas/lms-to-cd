<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0];

    if(count($course_info) == 0){
        header("location: course.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
 
?> 

<title>POST - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
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
        <h4>Post</h4>
    </div>
</div> 

<?php 

    $posts = "SELECT * FROM tbl_post WHERE crs_id=:crs_id and active=:active ORDER BY created_at DESC";
    $posts = DB::query($posts, array(':crs_id'=>$_GET['course'], ':active'=>'1')); 
    
    if(count($posts) != 0){ 
        foreach($posts as $post){
?> 
    <div class="row"> 
        <div class="col-sm-12">
            <div class="panel panel-default"> 
                <div class="panel-heading">
                    
                <p class="paragraph"><small><?= $post['created_at'] ?></small> </p>  
                    <p class="paragraph"><b><h4><?= $post['title'] ?></h4></b></p>
                    <p class="paragraph"><?= $post['descript'] ?></p>
                </div> 
                <!-- image  --> 
                
                    <center>
                        <?php if($post['types'] == 'image'){ ?>
                            <div class="panel-body">  
                                <a href="../../<?= $post['locale'] ?>" target="_blank"> 
                                    <img src="../../<?= $post['locale'] ?>" style="height: 200px"> 
                                </a> 
                            </div> 
                        <?php }elseif($post['types'] == 'application'){ ?>  
                            <div class="panel-body">   
                                    <img src="../../icons/document.svg" alt="" width="10%">
                                    <p class="paragraph"><?= $post['namefile'] ?></p> 
                            </div>     
                        <?php }elseif($post['types'] == 'video'){ ?> 
                            <div class="panel-body">  
                                <video width="50%"controls>
                                        <source src="../../<?= $post['locale'] ?>" type="video/mp4">
                                </video>
                            </div>  
                        <?php } ?>
                    </center> 

                <div class="panel-footer">
                    <a href="post_view.php?course=<?= $_GET['course'] ?>&&post=<?= $post['pst_id'] ?>" target="_blank" class="btn btn-default btn-sm" style="padding-left: 20px; padding-right: 20px"><img src="../../icons/chat.svg" alt="" width="20px"></a>  
                </div>   
            </div>
        </div> 
    </div> 
<?php 
}    
    }else{ 
?>
    <div class="row">
        <div class="col-sm-16">
            <center>
                <h2>No Post Yet.</h2>
            </center>
        </div>
    </div>
<?php 
    } 
 ?>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
      
  
</script>

 
<?php include '../_includes/footer.php'; ?>
