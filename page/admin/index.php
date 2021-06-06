<?php include '../_includes/header.php'; 

    $faculty = "SELECT * FROM tbl_user WHERE types='Faculty'";
    $faculty = DB::query($faculty); 
    $number_of_faculty = count($faculty);

    $student = "SELECT * FROM tbl_user WHERE types='Student'";
    $student = DB::query($student);
    $number_of_student = count($student);


?>  

<title>Admin LMS SDSSU Cantilan </title> 
</head>

  <body>

    <div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    <?php include '../_includes/admin_navigation.php';  ?>
    
<!-- =============================================================================  -->
<div id="content">
 
      <div class="row text-center"> 
        <div class="col-sm-6" style="position: static">
          <div class="well">
          <img src="../../icons/avatar_faculty.svg" style="width: 100px; height: 100px !important;">
          <h2>Faculty</h2> 
          <p class="lead"><span class="label label-default"><?= $number_of_faculty ?></span></p>
          
          <p><a class="btn btn-lg btn-success" href="faculty.php" role="button">View Faculties</a></p>
          </div>
        </div>

        <div class="col-sm-6" style="position: static">
        <div class="well">
          <img src="../../icons/student.svg" style="width: 100px; height: 100px !important;">
          <h2>Student</h2> 
          <p class="lead"><span class="label label-default"><?= $number_of_student ?></span></p>
          <p><a class="btn btn-lg btn-success" href="student.php" role="button">View Students</a></p>
          </div>
        </div> 
      </div>
      <!-- /row  -->
     

      <div class="row">
        <div class="col-lg-12" style="position: static">
            <h3 class="sub-header">Announcement 
              <button 
                class="btn btn-primary"
                @click="open_modal_post()"
                >Add
              </button>
            </h3>
      </div> 
    </div> <!-- /container -->

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

<template v-for="post in announcements">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            <label>{{post.title}}</label>
        </div>
        <div class="panel-body">
          <p>
            {{post.announcement}} 
          </p>

          <center>
            <template v-if="post.filetype == 'image'">  
              <img :src="'../../'+ post.uploaded" height="300px;"/>  
            </template>   

            <template v-if="post.filetype == 'application' || post.filetype == 'text'">  
                    <a :href="'../../'+ post.uploaded" taget="_blank">
                        <img src="../../icons/document.svg" alt="" width="10%">
                        <p class="paragraph">Download</p>
                    </a> 
            </template> 

            <template v-if="post.filetype == 'video'">  
                  <video width="50%"controls>
                          <source :src="'../../'+ post.uploaded" type="video/mp4">
                  </video> 
            </template>  
          </center> 

        </div>

        <div class="panel-footer">
            <button 
              class="btn btn-primary btn-sm"
              @click="edit_post(post.id)"
              >Edit
            </button>
            <button 
              class  = "btn btn-danger btn-sm"
              @click = "delete_post(post.id)"
              >Delete
            </button>
        </div>
      </div>
    </div>
  </div>
</template> 

    <!-- ====================================================================  -->

    

<!-- modal post  --> 
<template v-if="modal_post.toggled">
 
    <div class="popup" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" @click="default_modal_post()"><span>&times;</span></button>
            <h4 class="modal-title">ADD POST</h4>
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
                   
                      <template v-if="modal_post.mode=='add'"> 
                            <img :src="modal_post.url" style="height: 50px;"/>  
                        </template>
                    
                        <template v-if="modal_post.filetype == 'image'"> 
                            <template v-if="modal_post.modez=='add'"> 
                                <img :src="modal_post.url" style="height: 50px;"/>  
                            </template>

                            <template v-else> 
                                <img :src="'../../'+ modal_post.uploaded" style="height: 50px;"/>  
                            </template> 
                        </template> 
                        
                        <template v-if="modal_post.filetype == 'application'">  
                            <img src="../../icons/document.svg" style="height: 50px;"/>  
                        </template> 
                        <template v-if="modal_post.filetype == 'video'">  
                            <img src="../../icons/video.svg" style="height: 50px;"/>  
                        </template> 
                    </center> 
                </div> 

            </div>   
           
            <hr>

            <div class="row"> 
              <div class="col-sm-6">
                <div class="form-group"> 
                    <label for="email">Audience</label> 
                    <select class="form-control" v-model="modal_post.audience">
                        <option>Students</option>
                        <option>Faculties</option>
                        <option>Students and Faculties</option>
                    </select>
                </div>
              </div>  
            </div>
            <!-- /.row  -->

            <div class="row"> 
                <div class="col-sm-12">
                <div class="form-group"> 
                    <label>Title</label>
                    <input type="text" class="form-control" v-model="modal_post.title">
                </div>
                </div>

                <div class="col-sm-12">
                <div class="form-group"> 
                    <label for="email">Announcement</label> 
                    <textarea v-model="modal_post.announcement" cols="30" rows="5" class="form-control"></textarea>
                </div>
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


        </div> 



        <!-- /. modal body  -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" @click="default_modal_post()">Close</button> 
            <template v-if="modal_post.mode == 'update'">
               <button type="button" class="btn btn-info btn-sm" @click="update_post(modal_post.id)">Update</button> 
            </template>

            <template v-else>
              <button type="button" class="btn btn-primary btn-sm" @click="save_post()">Post</button> 
            </template>
           
        </div>
        <!-- /footer  -->
        </div>
        </div>
    </div>  
</template> 
<!-- /modal post  -->



 
</div>
<!-- /#content  -->
 
  
<script>
  var app = new Vue({
    el: "#content",
    data: {
      announcements: '',
      modal_post: {
        'toggled': false,
        'modez': '',
        'url': '',
        'mode': 'add',
        'audience': 'Students and Faculties',
        'title': '',
        'announcement': '',
        'uploaded': '',
        'filetype': '',
        'id': ''

      },
      alerts: {
        'message': '',
        'type'  : '',
        'toggled': false 
      }
    },
    methods: {

      // modal post
      edit_post: function(id){
        this.modal_post.id = id;
        axios.post("../../controller/admin/index.controller.php", {
          action: 'edit_post',
          id: id
        }).then(function(response){
          app.modal_post.toggled = true; 
          app.modal_post.audience = response.data.audience;
          app.modal_post.title = response.data.title;
          app.modal_post.announcement = response.data.announcement;
          app.modal_post.mode = 'update';
          app.modal_post.uploaded = response.data.uploaded;
          app.modal_post.filetype = response.data.filetype; 
          app.open_modal_post(); 

        });

      },

      open_modal_post: function(){
        this.modal_post.toggled = true;

      },
      default_modal_post: function(){
        this.modal_post.toggled = false;  
        this.modal_post.uploaded = '';
        this.modal_post.filetype = '';
        this.modal_post.mode = 'add';
        this.modal_post.audience = 'Students and Faculties';
        this.modal_post.title = '';
        this.modal_post.announcement = '';
        this.modal_post.url = ''; 
      },
      save_post: function(){
        if(this.modal_post.title == '' || this.modal_post.title == ''){
          this.setAlerts("Please fill up the title and description", "error", true);
        }else{
          let formData = new FormData(); 
          formData.append('file', this.modal_post.file);
          formData.append('title', this.modal_post.title);
          formData.append('announcement', this.modal_post.announcement); 
          formData.append('audience', this.modal_post.audience);

          axios.post("../../controller/admin/post.controller.php", formData, {  

          }).then(function(response){  
            app.setAlerts("Announcement successfully added!", "success", true);
            app.fetch_announcements();
          });
        }
        
        this.default_modal_post();
      },
      delete_post: function(id){ 
        if(confirm("Are you sure you want to delete announcement?")){
          axios.post("../../controller/admin/index.controller.php", {
            action: 'delete_post',
            post_id: id
          }).then(function(response){
              if(response.data.success){
                app.fetch_announcements();
                app.setAlerts("Announcement successfully deleted!", "success", true);
              }else{
                app.setAlerts("Something went wrong. please try again later", "error", true)
              }   
          });
        } 
      },
      update_post: function(id){
        if(this.modal_post.title == '' || this.modal_post.title == ''){
          this.setAlerts("Please fill up the title and description", "error", true);
        }else{
          let formData = new FormData(); 
          formData.append('file', this.modal_post.file);
          formData.append('title', this.modal_post.title);
          formData.append('announcement', this.modal_post.announcement); 
          formData.append('audience', this.modal_post.audience);
          formData.append('id', id)

          axios.post("../../controller/admin/updatepost.controller.php", formData, {  

          }).then(function(response){  
            app.setAlerts("Announcement successfully added!", "success", true);
            app.fetch_announcements();
          });
        }
        
        this.default_modal_post();
      },
      fetch_announcements: function(){
        axios.post("../../controller/admin/index.controller.php", {
          action: 'fetch_announcements'
        }).then(function(response){
          app.announcements = response.data;
        });
      },

      //file upload
      handleFileUpload: function (e){
        this.modal_post.modez = 'add';
        this.modal_post.url = URL.createObjectURL(e.target.files[0]);  
        this.modal_post.file = this.$refs.file.files[0]; 
      },
      //alerts
      setAlerts: function(message, type, toggled){
          this.alerts.message = message;
          this.alerts.type = type;
          this.alerts.toggled = toggled; 
      }, 
    },

    created: function(){
      this.fetch_announcements();
    }
  });

</script>

  
<?php include '../_includes/footer.php'; ?>