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

<title>Faculty - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <?php include '../_includes/facultynav.php' ?>
    <?php include '../_includes/breadcrumbs.php'; ?>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   
<div class="row">  
    <div class="col-sm-12 margin-b-20">   
        <h3>Posts <button class="btn btn-primary btn-sm" @click="modal_post.toggled=true"> Add + </button></h3>
    </div>
</div>   

<template v-if="alerts.toggled">
    <div class="row">
        <div class="col-sm-12">
            <div 
                class="alert"
                v-bind:class="{'alert-danger': (alerts.type == 'error'), 'alert-success': (alerts.type == 'success')}"
                >
                <a class="close" @click="alerts.toggled=false">&times;</a>
                <strong>{{(alerts.type == 'success')? 'Success: ': 'Error: '}} </strong> {{ alerts.message }}
            </div>
        </div> 
    </div>
    <!-- /.row  --> 
</template>  


<template v-for="post in posts"> 
    <div class="row"> 
            <div class="col-sm-12">
                <div class="panel panel-default"> 
                    <div class="panel-heading">
                        <p class="paragraph"><small>{{formatDateTime(post.created_at)}}</small> </p> 
                        <p class="paragraph"><b><h4>{{post.title}}</h4></b></p>
                        <p class="paragraph">{{post.descript}}</p>
                    </div> 
                    <!-- image  -->
                   
                        <center>
                            <template v-if="post.types == 'image'">
                                <div class="panel-body">  
                                    <img v-bind:src="'../../'+ post.locale" style="height: 200px"> 
                                </div> 
                            </template> 

                            <template v-if="post.types == 'application'">  
                                <div class="panel-body">  
                                    <a :href="'../../'+ post.locale" taget="_blank">
                                        <img src="../../icons/document.svg" alt="" width="10%">
                                        <p class="paragraph">{{post.namefile}}</p>
                                    </a> 
                                </div>     
                            </template> 

                            <template v-if="post.types == 'video'"> 
                                <div class="panel-body">  
                                    <video width="50%"controls>
                                            <source :src="'../../'+ post.locale" type="video/mp4">
                                    </video>
                                </div>     
                            </template> 
                        </center>
                    
                    <div class="panel-footer"> 
                    <button class="btn btn-danger btn-sm" @click="delete_post(post.pst_id, post.title)">Delete</button>  

                    <button class="btn btn-primary btn-sm pull-right" @click="toggle_viewComment(post.pst_id, post.title)">View Comments</button>  
                    <button class="btn btn-info btn-sm pull-right m-r-15" @click="edit_post(post.pst_id)">Edit</button>   
                </div>   
                </div>
            </div> 
    </div> 
    <!-- /.row  -->    
</template>

<template v-if="!posts.length">
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <center>
                <h1>No post available.</h1>
            </center>
        </div>
    </div>   
</template>



<!-- modal post  -->
<template v-if="modal_post.toggled">  
    <div class="popup" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" @click="setModalPost()"><span>&times;</span></button>
            <h4 class="modal-title">{{(modal_post.mode=='add') ? 'Add New Post': 'Edit Post'}}</h4>
        </div>
        
        <div class="modal-body">   

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">  
                            <label>Upload File</label>
                            <input type="file" class="form-control" @change="handleFileUpload" ref="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf, video/*, image/*"> 
                     </div>
                </div>

                <div class="col-sm-6">
                    <label>Preview: </label><br>  
                    <center>
                        <template v-if="modal_post.type == 'image'"> 
                            <template v-if="modal_post.modez=='add'"> 
                                <img :src="modal_post.url" style="height: 50px;"/>  
                            </template>

                            <template v-if="modal_post.modez=='edit'"> 
                                <img :src="'../../'+modal_post.url" style="height: 50px;"/>  
                            </template> 
                        </template> 
                        <template v-if="modal_post.type == 'application'">  
                            <img src="../../icons/document.svg" style="height: 50px;"/>  
                        </template> 
                        <template v-if="modal_post.type == 'video'">  
                            <img src="../../icons/video.svg" style="height: 50px;"/>  
                        </template> 
                        
                        <small class="paragraph">{{modal_post.filename}}</small>
                    </center> 
                </div> 
            </div>  
            <!-- / row v-if="modal_post.url"  -->
            <hr>

            <div class="row"> 
                <div class="col-sm-12">
                <div class="form-group"> 
                    <label>Title</label>
                    <input type="text" class="form-control" v-model="modal_post.title">
                </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group"> 
                    <label for="email">Post Description</label> 
                    <textarea v-model="modal_post.description" cols="30" rows="5" class="form-control"></textarea>
                </div>
                </div> 
            </div> 
        </div> 
        <!-- /. modal body  -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" @click="setModalPost()">Close</button>
            <template v-if="modal_post.mode=='add'"> 
                <button type="button" class="btn btn-primary btn-sm" @click="save_post()">Post</button>
            </template>
            <template v-if="modal_post.mode=='edit'"> 
                <button type="button" class="btn btn-info btn-sm" @click="update_post()">update</button>
            </template>
        </div>
        <!-- /footer  -->
        </div>
        </div>
    </div>
</template>
<!-- /modal post  -->


<!-- Modal view COmments  -->
<template v-if="modal_comment.toggled">  
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="modal_comment.toggled=false"><span>&times;</span></button>
                  <h4 class="modal-title">View Comments for <b>{{modal_comment.title}}</b></h4>
                </div>
              
                <div class="modal-body">     
                    <!-- /.row  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="modal_comment.comment" v-on:keyup.enter="save_comment()">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click="save_comment()">Comment</button>
                                </span>
                            </div><!-- /input-group -->
                        </div>  
                    </div>
                    <hr>
                    <!-- /.row  -->
                    <p class="paragraph">Comments: </p>
                    <br>
                    <template v-for="comment in comments">
                        <div class="row"> 
                            <div class="col-sm-12"> 
                                <div class="form-group"> 
                                    <template v-if="comment.usr_id == userInfo.usr_id"> 
                                        <p class="comment-form" style="margin-top: -10px">
                                            <img :src="'../../'+comment.profilepic" class="cmmnt-pp"> 
                                            <b style="color: #337ab7">{{comment.firstname}} {{comment.lastname}} : </b>
                                            <span class="paragraph" >{{comment.comment}}</span>
                                        </p> 
                                    </template>
                                    <template v-else> 
                                    <p class="comment-form" style="margin-top: -10px">
                                        <img :src="'../../'+comment.profilepic" class="cmmnt-pp"> 
                                        <b>{{comment.firstname}} {{comment.lastname}} : </b>
                                        <span>{{comment.comment}}</span>
                                    </p> 
                                    </template>  
                                </div>
                            </div>  
                        </div> 
                    </template>

                    <template v-if="!comments.length">
                        <div class="row">
                            <div class="col-sm-12"> 
                                No comments yet. 
                            </div>  
                        </div> 
                    </template>
                    <!-- /.comments  -->
                </div> 
                <!-- /. modal body  -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-sm" @click="modal_comment.toggled=false">Close</button>
                </div>
                <!-- /footer  -->
                </div>
              </div>
            </div>
</template>
<!-- /view comments  -->

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
            posts: '', 
            comments: '',
            userInfo: '',
            crs_id: searchParams.get('course'),
            modal_post: {
                'mode': 'add',
                'toggled': false,
                'title': '',
                'description': '',
                'url': null,
                'file': '',
                'type': '',
                'filename': '',
                'pst_id': '',
                'modez': 'add'  
            },
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },
            modal_comment: {
                'toggled': false,
                'comment': '', 
                'crs_id': this.crs_id,
                'pst_id': '', 
                'title': ''
            }
        },
        methods: {
            fetch_userInfo: function(){
                axios.post("../../controller/faculty/post.controller.php", {
                    action: 'fetch_userInfo', 
                }).then(function(response){
                    app.userInfo = response.data; 
                });  
            },
            get_posts: function(){   
                axios.post('../../controller/faculty/post.controller.php', {
                    action: 'get_posts',
                    crs_id: this.crs_id
                }).then(function(response){ 
                    app.posts = response.data;  
                });
            },
            delete_post: function (id, title){
                if(confirm("Are you sure you want to delete "+ title + " ?")){
                    axios.post('../../controller/faculty/post.controller.php', {
                        action: 'delete_post',
                        pst_id: id
                    }).then(function(response){ 
                       if(response.data.success){ 
                            app.setAlerts("Post successfully deleted!", "success", true); 
                            app.get_posts();
                       }else{
                           alert("Something went wrong");
                       }
                    });
                } 
            },
            save_post: function(){
                let formData = new FormData(); 
                formData.append('file', this.modal_post.file);
                formData.append('title', this.modal_post.title);
                formData.append('description', this.modal_post.description);
                formData.append('crs_id', this.crs_id);
                axios.post("../../controller/faculty/savepost.controller.php", formData, {  

                }).then(function(response){  
                    if(response.data.types == 'video'){
                        app.posts = '';
                    } 
                    if(response.data.success){                            
                        app.setAlerts("New post Added!", "success", true);  
                        app.setModalPost();
                        app.get_posts();  
                    }else{
                        alert("Something went wrong");
                    }
                });
            },
            edit_post: function (id){ 
                this.modal_post.mode = 'edit';   
                this.modal_post.pst_id = id;  
                this.modal_post.modez = 'edit';

                axios.post("../../controller/faculty/post.controller.php", {
                    action: 'get_post',
                    pst_id: id
                }).then(function(response){ 
                    app.modal_post.title = response.data.title;
                    app.modal_post.description = response.data.descript; 
                    app.modal_post.toggled = true;  
                    app.modal_post.type = response.data.types;
                    app.modal_post.filename = response.data.namefile;
                    app.modal_post.url = response.data.locale; 
                });  
            },
            update_post: function(){
                let formData = new FormData(); 
                formData.append('req', 'update');
                formData.append('file', this.modal_post.file);
                formData.append('title', this.modal_post.title);
                formData.append('description', this.modal_post.description); 
                formData.append('pst_id', this.modal_post.pst_id);
                formData.append('crs_id', this.crs_id);
                axios.post("../../controller/faculty/updatepost.controller.php", formData, {  

                }).then(function(response){  
                    if(response.data.types == 'video'){
                        app.posts = '';
                    } 
                    if(response.data.success){  
                        app.setAlerts("Post successfully updated!", "success", true); 
                        app.setModalPost(); 
                        app.get_posts();      
                    }else{
                        app.setAlerts("Something went wrong!", "danger", true); 
                    } 
                }); 
            },

            handleFileUpload: function (e){   
                this.modal_post.modez = 'add';
                this.modal_post.url = URL.createObjectURL(e.target.files[0]);  
                this.modal_post.file = this.$refs.file.files[0]; 
                this.modal_post.type = this.modal_post.file.type.split("/")[0]; 
                this.modal_post.filename = this.modal_post.file.name; 
            },

            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 
            setModalPost: function (){
                this.modal_post.mode = 'add';
                this.modal_post.title = '';
                this.modal_post.description = '';
                this.modal_post.url = null;
                this.modal_post.file = '';
                this.modal_post.type = '';
                this.modal_post.toggled = false; 
                this.modal_post.filename = ''; 
                this.modal_post.pst_id = ''; 
                this.modal_post.modez = 'add'; 
            },

            toggle_viewComment: function(id, title){ 
                this.modal_comment.pst_id = id;
                this.modal_comment.title = title;  

                this.fetch_comments();  

                this.modal_comment.toggled = true;
            },
            save_comment: function (){
                axios.post("../../controller/faculty/comment.controller.php", {
                    action: 'save_comment',
                    comment: this.modal_comment.comment,
                    pst_id: this.modal_comment.pst_id, 
                    crs_id: this.crs_id 
                }).then(function(response){
                    app.modal_comment.comment = ''; 
                    app.fetch_comments(); 
                });  
            },
            fetch_comments: function(){
                axios.post("../../controller/faculty/comment.controller.php", {
                    action: 'fetch_comments', 
                    pst_id: this.modal_comment.pst_id
                }).then(function(response){ 
                    app.comments = response.data; 
                }); 
            },
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
                return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
 
                
            },

        },
        created: function (){
            this.get_posts();
            this.fetch_userInfo(); 
        }
    });  
</script>

 
<?php include '../_includes/footer.php'; ?>