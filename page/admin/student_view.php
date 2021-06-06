<?php include '../_includes/header.php';  
 
?> 

<title></title> 
</head>

  <body>

<div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    
    <a href="student.php" class="btn btn-info btn-sm"><b><</b> Back</a> 
    <br><br>
    
<div id="content"> 
<!-- =================================================================== CONTENT  -->
    <div class="well">
        <div class="row admin-row"> 
            <div class="col-sm-12 col">
                <h3 class="sub-header">Details for student: 
                    <span class="text-primary">
                        {{student.firstname}} {{student.middlename}} {{student.lastname}}
                    </span>
                </h3> 
                <hr class="hr-style">
            </div> 
        </div>

        <div class="row admin-row"> 
            <div class="col-sm-4 col">
                <center>
                    <img :src="'../../'+ student.profilepic" class="view-post-post" style="width: 100%; height: 200px;">
                </center>
                <br>
               
            </div> 

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">ID </label>
                    <span class="form-control" > {{student.std_id}} </span>
                </div> 
            </div>  

            <div class="col-sm-8 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Department </label>
                    <span class="form-control" > {{student.department}} </span>
                </div> 
            </div> 

            <div class="col-sm-8 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email </label>
                    <span class="form-control" > {{student.email}} </span>
                </div> 
            </div>   
            
        </div> 
        <!-- /.row  --> 

        <div class="row admin-row"> 

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name</label>
                    <span class="form-control" > {{student.firstname}} </span>
                </div> 
            </div>

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Middle Name</label>
                    <span class="form-control" > {{student.middlename}} </span>
                </div> 
            </div>

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <span class="form-control" > {{student.lastname}} </span>
                </div> 
            </div>

        </div>
        <!-- /.row  --> 

    <!-- ALERTS  -->
        <template v-if="alerts.toggled">
            <div class="row admin-row" >
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
        <!-- /alerts -->



        <div class="row admin-row">  
            <div class="col-sm-2 col">
                <button 
                    type    = "button" 
                    class   = "btn btn-lg btn-block"
                    v-bind:class    = "{'btn-success' : (student.active == 1), 'btn-danger': (student.active != 1) }"
                    @click  = "set_active()"
                    >{{(student.active == 1) ? 'Active': 'Block'}}
                </button>
            </div>
            <div class="col-sm-4 col">
                <button 
                    type    = "button" 
                    class   = "btn btn-warning btn-lg btn-block"
                    @click  = "toggle_mdl_editPass()"
                    >Change Password
                </button>
            </div>
            <div class="col-sm-6 col">
                <button 
                    type="button" 
                    class="btn btn-info btn-lg btn-block"
                    @click  = "toggle_mdl_editstudent()"
                    >EDIT
                </button>
            </div>  
        </div>
        <!-- /.row  -->

        
            
        <hr class="hr-style">


        <div class="row admin-row"> 
            <div class="col-sm-12 col">
                <div class="panel panel-info">
                    <div class="panel-heading">Enrolled Courses</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Section</th>
                                            <th>Descriptitle</th>
                                            <th>Accesscode</th>
                                            <th>Schedule</th> 
                                            
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr v-for="course in courses">
                                            <td>{{course.num}}</td>
                                            <td>{{course.section}}</td>
                                            <td>{{course.descriptitle}}</td>
                                            <td>{{course.accesscode}}</td>
                                            <td>{{course.schedule}}</td>  
                                        </tr>
                                        <template v-if="!courses.length"> 
                                            <tr>
                                                <td colspan="6" class="text-center">No Course Yet</td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- /.row  -->  
         
    </div>
    <!-- /.well  -->
        

<!-- =============== MODALS  -->

<template v-if="mdl_editstudent.toggled">  
    <div class="popup" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" @click="setDefaults_mdl_editstudent()"><span>&times;</span></button>
            <h4 class="modal-title">Edit  {{student.firstname}} {{student.middlename}} {{student.lastname}} </h4>
        </div>
        <div class="modal-body">  

        <div class="row"> 
                
            <div class="col-sm-4">
                <div class="form-group"> 
                    <label class="control-label">ID:</label>
                    <input type="text" class="form-control" v-model="mdl_editstudent.id">
                </div>
            </div> 
        </div>
        <!-- /row  --> 
        <div class="row">  
            <div class="col-sm-6">
                <div class="form-group"> 
                    <label>Department</label>
                    <input type="text" class="form-control" v-model="mdl_editstudent.department">
                </div>
            </div> 

            <div class="col-sm-6">
                <div class="form-group"> 
                    <label for="email">Email</label>
                    <input type="email" class="form-control" v-model="mdl_editstudent.email">
                </div>
            </div> 
            
        </div>
        <!-- /row  -->

        <div class="row">  
            <div class="col-sm-4">
                <div class="form-group"> 
                    <label class="control-label">First Name</label>
                    <input type="email" class="form-control" v-model="mdl_editstudent.firstname">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group"> 
                    <label for="email">Middle Name</label>
                    <input type="email" class="form-control" v-model="mdl_editstudent.middlename">
                </div>
            </div> 

            <div class="col-sm-4">
                <div class="form-group"> 
                    <label for="email">Last Name</label>
                    <input type="email" class="form-control" v-model="mdl_editstudent.lastname">
                </div>
            </div> 

        </div>
        <!-- /row  -->

        <template v-if="alerts.toggled">
            <div class="row">
                <div class="col-sm-12">
                    <div 
                        class="alert"
                        v-bind:class="{'alert-danger': (alerts.type == 'error'), 'alert-success': (alerts.type == 'success')}"
                        >
                        <a class="close" @click="setDefaults_alerts()">&times;</a>
                        <strong>{{(alerts.type == 'success')? 'Success: ': 'Error: '}} </strong> {{ alerts.message }}
                    </div>
                </div> 
            </div>
            <!-- /.row  --> 
        </template>   
             
        </div> 
        <!-- /. modal body  -->
        <div class="modal-footer">
            <button 
                type="button" 
                class="btn btn-default btn-sm" 
                @click="setDefaults_mdl_editstudent()"
                >Close
            </button>
            <button 
                type="button" 
                class="btn btn-primary btn-sm" 
                @click="update_student()"
                >Update
            </button>
        </div>
        <!-- /footer  -->
        </div>
        </div>
    </div>
</template>
<!-- /modal_edit_student  -->

<!-- modal updatepassword  -->
<template v-if="mdl_editPass.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="setDefaults_mdl_editPass()"><span>&times;</span></button>
                  <h4 class="modal-title">Update Password</h4>
                </div>
                <div class="modal-body">  
                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Admin Password</label>
                            <input type="password" class="form-control" v-model="mdl_editPass.password">
                        </div> 
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" class="form-control" v-model="mdl_editPass.newPassword">
                        </div> 
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm New Password</label>
                            <input type="password" class="form-control" v-model="mdl_editPass.cNewPassword">
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
                                <a class="close" @click="setDefaults_alerts()">&times;</a>
                                <strong>{{(alerts.type == 'success')? 'Success: ': 'Error: '}} </strong> {{ alerts.message }}
                            </div>
                        </div> 
                    </div>
                    <!-- /.row  --> 
                </template>   
                

        </div>  
        
                <!-- /. modal body  -->
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm"
                            @click="setDefaults_mdl_editPass()"
                            >Close
                        </button>   
                        <button 
                            type="button"  
                            @click="update_password()"
                            class="btn btn-info btn-sm"
                            >
                            Update
                        </button>   
                       
                    </div> 
                
                <!-- /footer  -->
                </div>
              </div>
            </div> 
          <!-- /end add modal  --> 
    </template>
    <!-- /update student modal  --> 

<!-- ======================================================================= /CONTENT  -->
</div>
<!-- /#content  -->


<!-- ========================================================================== SCRIPT  -->
<script>
    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search); 


    var app = new Vue({
        el: "#content",
        data: {
            student_id: searchParams.get('student'),
            student: '', 
            courses: '',
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },  
            mdl_editstudent: {
                'toggled': false,
                'id': '',
                'department': '',
                'email': '',
                'firstname': '',
                'middlename': '',
                'lastname': ''
            },
            mdl_editPass: {
                'toggled': false,
                'password': '',
                'newPassword': '',
                'cNewPassword': ''
            }
            
        },
        methods: {
            // active {
                set_active: function(){
                    var status = (this.student.active == 1) ? '0': '1'; 
                    axios.post("../../controller/admin/student.controller.php", {
                        action: 'set_active',
                        usr_id:  this.student_id, 
                        active:  status
                    }).then(function(response){ 
                        app.student_details();
                    });
                },

            // }
            //mdl_editPass{
                update_password: function (){
                    if(this.mdl_editPass.password == '' || this.mdl_editPass.newPassword == '' || this.mdl_editPass.cNewPassword == ''){
                        this.setAlerts("Fill up the form properly.", "error", true);
                    }
                    else if(this.mdl_editPass.newPassword != this.mdl_editPass.cNewPassword){
                        this.setAlerts("New Password and Confirm Password did not match", "error", true);
                    }else{  
                        axios.post("../../controller/admin/student.controller.php", {
                            action: 'update_password',
                            password:   this.mdl_editPass.password,
                            newPassword:    this.mdl_editPass.newPassword,
                            student_id:     this.student.usr_id 
                        }).then(function(response){
                            if(response.data.success){
                                app.setAlerts("Password Successfully Updated", "success", true);
                                app.setDefaults_mdl_editPass();
                            }else{
                                app.setAlerts("You've entered a wrong password.", "error", true);
                                app.mdl_editPass.password = '';
                            }  
                        });
                    }
                    },
                toggle_mdl_editPass: function(){
                    this.setDefaults_alerts();
                    this.mdl_editPass.toggled = true;
                },
                setDefaults_mdl_editPass: function(){
                    this.mdl_editPass.toggled       = false;
                    this.mdl_editPass.password      = "";
                    this.mdl_editPass.newPassword   = "";
                    this.mdl_editPass.cNewPassword  = "";
                },
            // }

            //mdl_editstudent{
                setDefaults_mdl_editstudent: function(){
                    this.mdl_editstudent.toggled = false;
                    this.mdl_editstudent.id = "";
                    this.mdl_editstudent.department ="";
                    this.mdl_editstudent.email = "";
                    this.mdl_editstudent.firstname = "";
                    this.mdl_editstudent.middlename = "";
                    this.mdl_editstudent.lastname = "";
                },
                toggle_mdl_editstudent: function (){
                    this.setDefaults_alerts();
                    this.mdl_editstudent.toggled = true;
                    this.mdl_editstudent.id = this.student.std_id;
                    this.mdl_editstudent.department = this.student.department;
                    this.mdl_editstudent.email = this.student.email;
                    this.mdl_editstudent.firstname = this.student.firstname;
                    this.mdl_editstudent.middlename = this.student.middlename;
                    this.mdl_editstudent.lastname = this.student.lastname;
                    
                },
               
            // } mdl_editstudent

            // alerts{
                setAlerts: function(message, type, toggled){
                    this.alerts.message = message;
                    this.alerts.type = type;
                    this.alerts.toggled = toggled; 
                }, 
                setDefaults_alerts: function(){
                    this.alerts.message = '';
                    this.alerts.type = '';
                    this.alerts.toggled = false; 
                },
            // } end of alerts 

            // student {
                student_details: function (){
                    axios.post("../../controller/admin/student.controller.php", {
                        action: 'student_details',
                        usr_id: this.student_id
                    }).then(function(response){
                        app.student = response.data; 
                    });
                },
                student_courses: function(){
                    axios.post("../../controller/admin/student.controller.php", {
                        action: 'student_courses',
                        usr_id: this.student_id
                    }).then(function(response){
                        app.courses = response.data;
                        // alert(response.data)  
                    });
                },
                update_student: function(){
                    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if(this.mdl_editstudent.email == '' || this.mdl_editstudent.firstname == '' || this.mdl_editstudent.lastname == ''){
                        this.setAlerts("Email, Firstname, Lastname cannot be empty.", "error", true);
                    }
                    else if(!this.mdl_editstudent.email.match(mailformat)){
                        this.setAlerts("Please input a valid email address.", "error", true);
                    }
                    else{  
                        axios.post("../../controller/admin/student.controller.php", {
                            action:     'update_student', 
                            std_id:     this.mdl_editstudent.id,
                            department: this.mdl_editstudent.department,
                            email:      this.mdl_editstudent.email,
                            firstname:  this.mdl_editstudent.firstname,
                            middlename: this.mdl_editstudent.middlename,
                            lastname:   this.mdl_editstudent.lastname,
                            usr_id:     this.student_id
                    
                        }).then(function(response){
                            if(response.data.success){  
                                app.student_details();
                                app.setDefaults_mdl_editstudent();
                                app.setAlerts("Account Successfully Updated", "success", true);
                               
                            }else{
                                app.setAlerts("Something went wrong. student ID or Email may already be existed", "error", true);
                            } 
                        }); 
                    }
                },
            // } end of student

        },
        created: function(){
            this.student_details();
            this.student_courses();
        }
    });
</script>

  
<?php include '../_includes/footer.php'; ?>