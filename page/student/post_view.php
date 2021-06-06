<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0];

    $post_info = "SELECT * FROM tbl_post WHERE pst_id=:pst_id";
    $post_info = DB::query($post_info, array(':pst_id'=>$_GET['post']))[0];

    $post_facultyInfo = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $post_facultyInfo = DB::query($post_facultyInfo, array(':usr_id'=>$post_info['usr_id']))[0]; 


    if(count($course_info) == 0 || count($post_info) == 0){
        header("location: course.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
 
?> 

<title>View Post - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
 
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <a href="post.php?course=<?= $_GET['course'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 
    

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->    
    <div 
        class="row view-post-center">
         
            <div class="col-sm-10" >
                <div class="panel panel-default"> 
                    <div class="panel-heading">
                            <p class="paragraph">
                                <img class="pp" src="../../<?= $post_facultyInfo['profilepic'] ?>" style="width: 35px; height: 35px;  margin-top: 10px !important;">
                                <span style="font-weight: bold; font-size: 15px;"><?= $post_facultyInfo['firstname'] ?> <?= $post_facultyInfo['lastname']?></span>
                                <img src="../../icons/right-arrow.svg" style="width: 15px;">
                                <?= $course_info['descriptitle'] ?> | <?= $course_info['num'] ?>
                            <p class="paragraph" style="margin-left: 40px !important; margin-top: -10px !important;">
                                <small><?= $post_info['created_at'] //DATE ?></small> 
                            </p>
                            <h4><?= $post_info['title'] ?></h4>
                            <p><?= $post_info['descript'] ?></p>
                            <center>
<?php if($post_info['types'] == 'image'){ ?>
                            <a href="../../<?= $post_info['locale'] ?>" target="_blank"> 
                                <img src="../../<?= $post_info['locale'] ?>" alt="" height="250px" class="view-post-post"> 
                            </a>
<?php }elseif($post_info['types'] == 'application'){ ?>
                            <img src="../../icons/document.svg" alt="" width="10%">
                            <p class="paragraph"><?= $post_info['namefile'] ?></p> 

<?php }elseif($post_info['types'] == 'video'){ ?>
                            <video width="50%"controls>
                                    <source src="../../<?= $post_info['locale'] ?>" type="video/mp4">
                            </video>
<?php } ?>
                            </center> 
                            <?php if($post_info['types'] != ''){ ?>
                                <a href="../../<?= $post_info['locale'] ?>" class="btn btn-default btn-sm" style="margin-top: 10px;">download</a>
                            <?php } ?>
                    </div>
                    <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group"> 
                                <input type="text" class="form-control" v-model="comment" v-on:keyup.enter="add_comment()"> 
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" @click="add_comment()" >Comment</button>
                                </span>
                            </div>
                        </div>
                    </div>
                           
                    <hr>  
                        <div class="row"> 
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <template v-for="comment in comments"> 
                                        <p class="comment-form" style="margin-top: 10px;">
                                                <img :src="'../../'+ comment.profilepic" style="height: 25px; width: 25px" class="pp"> 
                                                <template v-if="comment.usr_id == '<?= $user_info['usr_id'] ?>'">
                                                    <b style="color: rgb(51, 122, 183);">{{comment.firstname}} {{comment.lastname}} :</b>  
                                                </template>
                                                <template v-else>
                                                    <b>{{comment.firstname}} {{comment.lastname}} :</b> 
                                                </template>
                                                
                                                <span class="paragraph">{{comment.comment}}</span>
                                                <br><span class="paragraph"><small>{{comment.created_at}}</small></span>
                                        </p>
                                    </template> 
                                </div>
                            </div> 
                        </div>
                         <!-- / row  -->
                    </div>
                </div>
            </div>
   
    </div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search); 


    var app = new Vue({
        el: "#content",
        data: {
            comment: '',
            crs_id: searchParams.get('course'),            
            pst_id: searchParams.get('post'),
            comments: ''
        },
        methods: { 
            fetch_allComment: function(){
                axios.post("../../controller/students/viewpost.controller.php", {
                    action: 'fetch_allComment', 
                    pst_id: this.pst_id
                }).then(function(response){
                    app.comments = response.data; 
                });  
            }, 
            add_comment: function(){
                if(this.comment == ""){

                }else{
                    axios.post("../../controller/students/viewpost.controller.php", {
                        action: 'add_comment',
                        comment: this.comment,
                        crs_id: this.crs_id,
                        pst_id: this.pst_id 
                    }).then(function(response){  
                    }); 
                    this.comment = '';
                    this.fetch_allComment();
                }
               
            } 
        },
        created: function(){
            this.fetch_allComment();
        }
    });
      
  
</script>

 
<?php include '../_includes/footer.php'; ?>