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
 
?> 

<title>Students - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
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
            <h4>Students</h4>
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

    <?php 
        foreach($studentcourse as $stdCourse){
            $classmates = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
            $classmates_data = [
                'usr_id'  => $stdCourse['usr_id']
            ];

            $classmates = DB::query($classmates, $classmates_data)[0]; 
    
    ?>
    <div class="row">
        <div class="col-sm-6">
            <img src="../../<?= $classmates['profilepic'] ?>" alt="Prifile Pic" class="cmmnt-pp">
             <label>
                <?= $classmates['firstname'] ?> 
                <?= $classmates['middlename'] ?> 
                <?= $classmates['lastname'] ?>   
                <button class="btn btn-info btn-sm" style="margin-left: 10px;" @click="open_modal_message('<?= $classmates['usr_id'] ?>', '<?= $classmates['firstname'] ." ". $classmates['lastname'] ?>')">Message</button>
            </label>
        </div>
        
        
        <div class="col-sm-4">
            <button 
                class="btn btn-danger btn-sm" 
                @click="remove_student('<?= $classmates['usr_id'] ?>', '<?= $classmates['firstname']." ". $classmates['lastname'] ?>')"
                >Remove
            </button>
        </div>
    </div>  
    <hr>   
<?php } ?>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   


<form action="../../controller/faculty/message.controller.php" method="POST" enctype="multipart/form-data">
<template v-if="modal_message.toggled"> 
    <div class="popup" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="default_modal_message()"><span>&times;</span></button>
                    <h4 class="modal-title">
                        Message  <span class="text-primary">{{modal_message.fullname}}</span>
                    </h4>
                </div>
                <input type="hidden" name="to" v-model="modal_message.hidden_id">
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
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },
            modal_message: {
                'toggled': false,
                'hidden_id': '',
                'fullname': ''
            },
          },
          methods: {
            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 

            remove_student: function(id, fullname){
                if(confirm("Are you sure you want to remove "+ fullname)){
                    axios.post("../../controller/faculty/student.controller.php", {
                        action: 'remove_student',
                        usr_id: id
                    }).then(function(response){
                        if(response.data.success){
                            location.reload();
                        }else{
                            app.setAlerts("Something went wrong. Please try again later. ", "error", true); 
                        }
                    });
                }
            },
            open_modal_message: function(id, fullname){ 
                this.modal_message.toggled = true;
                this.modal_message.hidden_id = id;
                this.modal_message.fullname = fullname;
            },

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
