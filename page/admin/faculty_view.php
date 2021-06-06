<?php include '../_includes/header.php';  
 
?> 

<title></title> 
</head>

  <body>

<div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    
    <a href="faculty.php" class="btn btn-info btn-sm"><b><</b> Back</a> 
    <br><br>
    
<div id="content"> 
<!-- =================================================================== CONTENT  -->
    <div class="well">
        <div class="row admin-row"> 
            <div class="col-sm-12 col">
                <h3 class="sub-header">Details for Faculty: 
                    <span class="text-primary">
                        {{faculty.firstname}} {{faculty.middlename}} {{faculty.lastname}}
                    </span>
                </h3> 
                <hr class="hr-style">
            </div> 
        </div>

        <div class="row admin-row"> 
            <div class="col-sm-4 col">
                <center>
                    <img :src="'../../'+ faculty.profilepic" class="view-post-post" style="width: 100%; height: 200px;">
                </center>
                <br>
               
            </div> 

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">ID </label>
                    <span class="form-control" > {{faculty.std_id}} </span>
                </div> 
            </div>  

            <div class="col-sm-8 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Department </label>
                    <span class="form-control" > {{faculty.department}} </span>
                </div> 
            </div> 

            <div class="col-sm-8 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email </label>
                    <span class="form-control" > {{faculty.email}} </span>
                </div> 
            </div>   
            
        </div> 
        <!-- /.row  --> 

        <div class="row admin-row"> 

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">First Name</label>
                    <span class="form-control" > {{faculty.firstname}} </span>
                </div> 
            </div>

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Middle Name</label>
                    <span class="form-control" > {{faculty.middlename}} </span>
                </div> 
            </div>

            <div class="col-sm-4 col">
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <span class="form-control" > {{faculty.lastname}} </span>
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
                    v-bind:class    = "{'btn-success' : (faculty.active == 1), 'btn-danger': (faculty.active != 1) }"
                    @click  = "set_active()"
                    >{{(faculty.active == 1) ? 'Active': 'Block'}}
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
                    @click  = "toggle_mdl_editFaculty()"
                    >EDIT
                </button>
            </div>  
        </div>
        <!-- /.row  -->

        
            
        <hr class="hr-style">


        <div class="row admin-row"> 
            <div class="col-sm-12 col">
                <div class="panel panel-info">
                    <div class="panel-heading">Handled Courses</div>
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

<template v-if="mdl_editFaculty.toggled">  
    <div class="popup" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" @click="setDefaults_mdl_editFaculty()"><span>&times;</span></button>
            <h4 class="modal-title">Edit  {{faculty.firstname}} {{faculty.middlename}} {{faculty.lastname}} </h4>
        </div>
        <div class="modal-body">  

        <div class="row"> 
                
            <div class="col-sm-4">
                <div class="form-group"> 
                    <label class="control-label">ID:</label>
                    <input type="text" class="form-control" v-model="mdl_editFaculty.id">
                </div>
            </div> 
        </div>
        <!-- /row  --> 
        <div class="row">  
            <div class="col-sm-6">
                <div class="form-group"> 
                    <label>Department</label>
                    <input type="text" class="form-control" v-model="mdl_editFaculty.department">
                </div>
            </div> 

            <div class="col-sm-6">
                <div class="form-group"> 
                    <label for="email">Email</label>
                    <input type="email" class="form-control" v-model="mdl_editFaculty.email">
                </div>
            </div> 
            
        </div>
        <!-- /row  -->

        <div class="row">  
            <div class="col-sm-4">
                <div class="form-group"> 
                    <label class="control-label">First Name</label>
                    <input type="email" class="form-control" v-model="mdl_editFaculty.firstname">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group"> 
                    <label for="email">Middle Name</label>
                    <input type="email" class="form-control" v-model="mdl_editFaculty.middlename">
                </div>
            </div> 

            <div class="col-sm-4">
                <div class="form-group"> 
                    <label for="email">Last Name</label>
                    <input type="email" class="form-control" v-model="mdl_editFaculty.lastname">
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
                @click="setDefaults_mdl_editFaculty()"
                >Close
            </button>
            <button 
                type="button" 
                class="btn btn-primary btn-sm" 
                @click="update_faculty()"
                >Update
            </button>
        </div>
        <!-- /footer  -->
        </div>
        </div>
    </div>
</template>
<!-- /modal_edit_faculty  -->

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
    <!-- /update faculty modal  -->


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
            faculty_id: searchParams.get('faculty'),
            faculty: '', 
            courses: '',
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },  
            mdl_editFaculty: {
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
                    var status = (this.faculty.active == 1) ? '0': '1'; 
                    axios.post("../../controller/admin/faculty.controller.php", {
                        action: 'set_active',
                        usr_id:  this.faculty_id, 
                        active:  status
                    }).then(function(response){ 
                        app.faculty_details();
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
                        axios.post("../../controller/admin/faculty.controller.php", {
                            action: 'update_password',
                            password:   this.mdl_editPass.password,
                            newPassword:    this.mdl_editPass.newPassword,
                            faculty_id:     this.faculty.usr_id 
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

            //mdl_editFaculty{
                setDefaults_mdl_editFaculty: function(){
                    this.mdl_editFaculty.toggled = false;
                    this.mdl_editFaculty.id = "";
                    this.mdl_editFaculty.department ="";
                    this.mdl_editFaculty.email = "";
                    this.mdl_editFaculty.firstname = "";
                    this.mdl_editFaculty.middlename = "";
                    this.mdl_editFaculty.lastname = "";
                },
                toggle_mdl_editFaculty: function (){
                    this.setDefaults_alerts();
                    this.mdl_editFaculty.toggled = true;
                    this.mdl_editFaculty.id = this.faculty.std_id;
                    this.mdl_editFaculty.department = this.faculty.department;
                    this.mdl_editFaculty.email = this.faculty.email;
                    this.mdl_editFaculty.firstname = this.faculty.firstname;
                    this.mdl_editFaculty.middlename = this.faculty.middlename;
                    this.mdl_editFaculty.lastname = this.faculty.lastname;
                    
                },
               
            // } mdl_editFaculty

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

            // faculty {
                faculty_details: function (){
                    axios.post("../../controller/admin/faculty.controller.php", {
                        action: 'faculty_details',
                        usr_id: this.faculty_id
                    }).then(function(response){
                        app.faculty = response.data;
                    });
                },
                faculty_courses: function(){
                    axios.post("../../controller/admin/faculty.controller.php", {
                        action: 'faculty_courses',
                        usr_id: this.faculty_id
                    }).then(function(response){
                        app.courses = response.data;
                    });
                },
                update_faculty: function(){
                    var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if(this.mdl_editFaculty.email == '' || this.mdl_editFaculty.firstname == '' || this.mdl_editFaculty.lastname == ''){
                        this.setAlerts("Email, Firstname, Lastname cannot be empty.", "error", true);
                    }
                    else if(!this.mdl_editFaculty.email.match(mailformat)){
                        this.setAlerts("Please input a valid email address.", "error", true);
                    }
                    else{  
                        axios.post("../../controller/admin/faculty.controller.php", {
                            action:     'update_faculty', 
                            std_id:     this.mdl_editFaculty.id,
                            department: this.mdl_editFaculty.department,
                            email:      this.mdl_editFaculty.email,
                            firstname:  this.mdl_editFaculty.firstname,
                            middlename: this.mdl_editFaculty.middlename,
                            lastname:   this.mdl_editFaculty.lastname,
                            usr_id:     this.faculty_id
                    
                        }).then(function(response){
                            if(response.data.success){  
                                app.faculty_details();
                                app.setDefaults_mdl_editFaculty();
                                app.setAlerts("Account Successfully Updated", "success", true);
                               
                            }else{
                                app.setAlerts("Something went wrong. Faculty ID or Email may already be existed", "error", true);
                            } 
                        }); 
                    }
                },
            // } end of faculty

        },
        created: function(){
            this.faculty_details();
            this.faculty_courses();
        }
    });
</script>

  
<?php include '../_includes/footer.php'; ?>