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

<title>FORUM - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
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
        <h4>Forum</h4>
    </div>
</div>
 
 <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-header">
                <div class="input-group">
                    <textarea class="form-control" cols="3" rows="1" style="resize: none;"  v-model="comment.message" v-on:keyup.enter="sendMessage()"></textarea> 
                    <span class="input-group-btn"> 
                    <button class="btn btn-primary" type="button" @click="sendMessage()">Send</button>
                                                    
                    </span>
                </div><!-- /input-group -->     
            </div>

            
            <div class="panel-body" style="height: 700px; overflow-y:scroll;">  
                <div v-for="message in comment.messages">
                        <template v-if="message.usr_id == '<?= $_SESSION['loggedID'] ?>'">
                            <div class="well well-sm" style="background-color: #428bca; color: white; margin: 10px;"> 
                                <p style="padding-left: 5px">{{message.msg}}</p> 
                                <small>{{formatDateTime(message.created_at)}}</small> 
                            </div> 
                        </template>  
                        <template v-else> 
                            <div class="well well-sm">
                                <p style="margin-bottom: -5px; padding: -2px;">
                                    <img class="cmmnt-pp"  v-bind:src="'../../' + message.profilepic" > <label> {{message.firstname}} {{message.lastname}}</label></p> 
                                    <small>{{formatDateTime(message.created_at)}}</small></p> 
                                <p style="padding-left: 5px">{{message.msg}}</p> 
                            </div> 
                        </template> 
                </div>
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
    var app = new Vue({
        el: "#content",
        data: {
            comment: {
                'message': '',
                'messages': ''
            }
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
                return (date.getMonth()+1) + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
 
                
            },
            fetchMessage: function(){
                axios.post("../../controller/students/forum.controller.php", {
                    action: 'fetchMessage', 
                    crs_id: '<?= $_GET['course'] ?>'
                }).then(function(response){  
                    app.comment.messages = response.data;  

                });
            },
            sendMessage: function(){
                 if(this.comment.message != ''){
                    axios.post("../../controller/students/forum.controller.php", {
                        action: 'sendMessage',
                        message: this.comment.message,
                        crs_id: '<?= $_GET['course']?>'
                    }).then(function(response){ 
                        if(response.data){
                            app.comment.message = ''; 
                            app.fetchMessage();
                        }
                    });
                 } 
            }, 
        },
        created: function(){
            this.fetchMessage();
        } 
       
    }); 

    var timerID = setInterval(app.fetchMessage, 1000); 
    app.fetchMessage();
    
</script> 
 
<?php include '../_includes/footer.php'; ?>