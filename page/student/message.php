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

    $studentcourse = "SELECT * FROM tbl_studentcourse WHERE crs_id=:crs_id";
    $studentcourse_data = [
        'crs_id'  => $crs_id
    ];
    $studentcourse = DB::query($studentcourse, $studentcourse_data);  

    $instructor_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $instructor_info = DB::query($instructor_info, array('usr_id'=>$course_info['usr_id']))[0];

    $messages = "SELECT * FROM tbl_message WHERE 
    crs_id='". $crs_id ."' AND 
    from_usr_id='". $user_info['usr_id'] ."' || 
    (from_usr_id='". $instructor_info['usr_id'] ."' AND to_usr_id='". $user_info['usr_id'] ."') 
    ORDER BY created_at DESC";



    // $messages = "SELECT * FROM tbl_message WHERE 
    // from_usr_id=:from_usr_id AND to_usr_id=:to_usr_id AND crs_id=:crs_id ORDER BY created_at DESC";
    // $messages_data = [ 
    //     'from_usr_id'  => $user_info['usr_id'],
    //     'to_usr_id'  => $instructor_info['usr_id'],
    //     'crs_id'  => $crs_id
    // ];
    $messages = DB::query($messages);
 
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
        <h3>Message Instructor</h3>
    </div>
</div> 
<!-- /.row  -->


<div class="row">
    <div class="col-sm-12">
        <img src="../../<?= $instructor_info['profilepic'] ?>" alt="Prifile Pic" class="cmmnt-pp">
        <label><?= $instructor_info['firstname'] . " ". $instructor_info['middlename'] ." ". $instructor_info['lastname'] ?></label>
        <button class="btn btn-success btn-sm" style="margin-left: 50px;" @click="modal_message.toggled=true">Message</button>
    </div> 
</div>
<!-- /.row  -->

<hr>
<div class="row">
    <div class="col-sm-12">
        <h4>Inbox</h4>
    </div>
</div>
<!-- /.row  -->


<div class="row"> 
    <div class="col-sm-12">
        <div class="form-group"> 
            <?php foreach($messages as $message){ ?>
                <p class="comment-form" style="margin-top: 10px; <?= ($message['from_usr_id'] == $user_info['usr_id']) ? 'border-color: rgb(51, 122, 183)!important;': ''?>">

                     
 
                            <!-- ($message['from_usr_id'] == $user_info['usr_id']) 
                            ? 
                            '<b style="color: rgb(51, 122, 183);">'. $user_info["firstname"] .' '. $user_info["lastname"].'  : </b '
                            : 
                            ' <b>'. $instructor_info["firstname"] .' '. $instructor_info["lastname"] .'  :</b> ' 
                        -->
                             
                        <?php 
                            if($message['from_usr_id'] == $user_info['usr_id']){                            
                        ?> 
                            <img src="../../<?= $user_info['profilepic'] ?>" style="height: 25px; width: 25px" class="pp">
                            <b style="color: rgb(51, 122, 183)"><?= $user_info['firstname'] ." ". $user_info['lastname'] ?> : </b>

                        <?php     
                            }else{ 
                         ?>
                            <img src="../../<?= $instructor_info['profilepic'] ?>" style="height: 25px; width: 25px" class="pp">
                            <b> <?= $instructor_info['firstname'] ." ". $instructor_info['lastname'] ?> : </b>
                         <?php  
                        }
                         ?>
                     
                        
                        <span class="paragraph"><?= $message['msg'] ?></span>
                        <br><span class="paragraph"><small> {{format_date('<?= $message['created_at'] ?>')}}</small> 
                        <?= 
                            ($message['attached_file']!='') ? '| Attached File : <a href="../../'. $message['attached_file'] .'">'. $message['name_file'] .'</a>':''
                        ?>   
                        </span>
                </p> 
            <?php } ?>
        </div>
    </div> 
</div>
<!-- /.row  -->



<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  


<form action="../../controller/students/message.controller.php" method="POST" enctype="multipart/form-data">
<template v-if="modal_message.toggled"> 
    <div class="popup" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="default_modal_message()"><span>&times;</span></button>
                    <h4 class="modal-title">
                        Message 
                        <span class="text-primary">
                            <?= $instructor_info['firstname'] . " ". $instructor_info['middlename'] ." ". $instructor_info['lastname'] ?>
                        </span>
                    </h4>
                </div>
                <input type="hidden" name="to" value="<?= $instructor_info['usr_id'] ?>">
                <input type="hidden" name="crs_id"  value="<?= $crs_id ?>">
                
                <div class="modal-body">   

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea cols="30" rows="5" class="form-control" name="message"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.row  -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="attached_file">Attached File</label>
                                    <input name="attached_file" type="file" class="form-control" ref="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf, video/*, image/*"> 
                                </div>
                            </div>
                        </div> 
                </div>  
                <!-- /. modal body  -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm pull-left" @click="default_modal_message()">Cancel</button>  
                    <input type="submit" class="btn btn-primary btn-sm" name="btn_send_message" value="Send"/> 
                </div>
            <!-- /footer  -->
            </div>
        </div>
</div>   
</template>
 
</form>




</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   
<br>

<script>
     var app = new Vue({
          el: "#content",
          data: {
            modal_message: {
                'toggled': false
            }
          },
          methods: {
            default_modal_message: function(){
                this.modal_message.toggled = false;
            },
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
          }
      });
  
  
</script>

 
<?php include '../_includes/footer.php'; ?>
