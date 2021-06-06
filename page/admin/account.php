<?php include '../_includes/header.php'; ?>
<?php  

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
 
?> 

<title>Accounts | <?=$user_info['firstname']?> <?=$user_info['lastname']?> | SDSSU LMS</title> 
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?>  
    <a href="index.php" class="btn btn-info btn-sm"> HOME </a> 
<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
    <div class="row">
        <div class="col-sm-12">
            <h3>Account</h3>
        </div>
    </div>
 
<div class="well">
    <div class="row">
        <div class="col-sm-12">
            <center><img src="../../<?= $user_info['profilepic'] ?>" style="width: 120px; height: 120px; border-radius: 50%;">  
            <br><br>
            <button @click="mdl_upProfile.toggled = true">Change Profile</button>
            </center>
        </div> 
    </div>

     <br>

     <div class="row">  
         <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email </label>
                    <span class="form-control" ><?= $user_info['email'] ?></span>
                </div> 
         </div>   
     </div>

     <div class="row"> 
         <div class="col-sm-4">
                <div class="form-group">
                    <label>First Name</label>
                    <span class="form-control" > <?= $user_info['firstname'] ?> </span>
                </div> 
         </div> 
         <div class="col-sm-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Middle Name</label>
                    <span class="form-control" > <?= $user_info['middlename'] ?> </span>
                </div> 
         </div>  
         <div class="col-sm-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <span class="form-control" > <?= $user_info['lastname'] ?> </span>
                </div> 
         </div>  
    </div> 

    <?php if(isset($_SESSION['temp']['message'])){ ?> 
                <div class="alert <?= ($_SESSION['temp']['success']) ? 'alert-success' : 'alert-danger' ?>">
                <a class="close" @click="reload()">&times;</a>
                    <?= $_SESSION['temp']['message'] ?>
                </div>
    <?php } ?>
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


        
 
    <div class="row"> 
        <div class="col-sm-12">
            <div class="form-group"> 
                <button class="btn btn-primary btn-sm m-r-20" @click="mdl_upAcc.toggled = true">Edit</button>
                <button class="btn btn-info btn-sm" @click="mdl_upPass.toggled = true">Change Password</button> 
            </div> 
        </div>  
    </div>

     </div>
     <!-- /well  -->

     <!-- /modal edit  -->  
<template v-if="mdl_upAcc.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="close_mdl_UpAcc()"><span>&times;</span></button>
                  <h4 class="modal-title">Edit Account</h4>
                </div>
                <div class="modal-body">  
                <div class="row"> 
        
         <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email </label>
                    <input type="email" class="form-control" v-model="mdl_upAcc.email">
                </div> 
         </div>   
     </div>

     <div class="row"> 
         <div class="col-sm-4">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" v-model="mdl_upAcc.firstname" >
                </div> 
         </div> 
         <div class="col-sm-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Middle Name</label>
                    <input type="text" class="form-control" v-model="mdl_upAcc.middlename">
                </div> 
         </div>  
         <div class="col-sm-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Last Name</label>
                    <input type="text" class="form-control" v-model="mdl_upAcc.lastname">
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
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm"
                            @click="close_mdl_UpAcc()"
                            >Close
                        </button>   
                        <button 
                            type="button"  
                            @click="btn_upAcc()"
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

    <!-- modal change password  -->
     <!-- /modal edit  -->  
<template v-if="mdl_upPass.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="close_mdl_upPass()"><span>&times;</span></button>
                  <h4 class="modal-title">Update Password</h4>
                </div>
                <div class="modal-body">  
                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Current Password</label>
                            <input type="password" class="form-control" v-model="mdl_upPass.password">
                        </div> 
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" class="form-control" v-model="mdl_upPass.newPassword">
                        </div> 
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm New Password</label>
                            <input type="password" class="form-control" v-model="mdl_upPass.cNewPassword">
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
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm"
                            @click="close_mdl_upPass()"
                            >Close
                        </button>   
                        <button 
                            type="button"  
                            @click="btn_upPass()"
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

    <!-- modal Change Profile  -->
    <template v-if="mdl_upProfile.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="default_mdl_upProfile()"><span>&times;</span></button>
                  <h4 class="modal-title">Edit Account</h4>
                </div>
                <div class="modal-body">  

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                            <center>
                                <template v-if="mdl_upProfile.profileShow">
                                    <img :src="'../../'+ mdl_upProfile.profilepic" style="width: 120px; height: 120px; border-radius: 50%;">
                                </template>
                                <template v-else>
                                    <img :src="mdl_upProfile.profilepic" style="width: 120px; height: 120px; border-radius: 50%;">
                                </template>
                              </center>  
                        </div> 
                     </div>
                 </div> 
        <br>
                 <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                             <input type="file" class="form-control" @change="handleFileUpload" ref="file"  accept="image/*">
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
                        <button 
                            type="button" 
                            class="btn btn-default btn-sm"
                            @click="default_mdl_upProfile()"
                            >Close
                        </button>   
                        <button 
                            type="button"  
                            @click="btn_upProfile"
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
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#content  --> 

</div>
<!-- /.container  -->   

<script>
    var app = new Vue({
        el: "#content",
        data: { 
            mdl_upProfile: {
                'toggled': false,
                'profilepic': '<?= $user_info['profilepic'] ?>',
                'profileShow': true,
                'file': ''
            },
            mdl_upPass: {
                'toggled':  false,
                'password': '',
                'newPassword': '',
                'cNewPassword':  '' 
            },
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },  
            mdl_upAcc: {
                'toggled':      false,
                'usr_id':       '<?= $user_info['usr_id'] ?>',
                'email':        '<?=$user_info['email']?>',
                'firstname':    '<?=$user_info['firstname']?>',
                'middlename':   '<?=$user_info['middlename']?>',
                'lastname':     '<?=$user_info['lastname']?>',
            }
        },  
        methods: {
            btn_upProfile: function(){
                let formData = new FormData(); 
                formData.append('action', 'btn_upProfile');
                formData.append('file', this.mdl_upProfile.file);

                axios.post("../../controller/admin/profile.controller.php", formData, {  

                }).then(function(response){  
                    if(response.data.success){
                        app.reload();
                    }else{
                        app.setAlerts("Something went wrong. Please try again later. ", "error", true); 
                     
                    } 
                });

            },
            default_mdl_upProfile: function(){ 
                this.mdl_upProfile.toggled = false;
                this.mdl_upProfile.profilepic = '<?= $user_info['profilepic'] ?>',
                this.mdl_upProfile.profileShow = true;
                this.mdl_upProfile.file = '';
            },
            handleFileUpload: function(e){ 
                this.mdl_upProfile.profilepic   =  URL.createObjectURL(e.target.files[0]); 
                this.mdl_upProfile.profileShow  = false;
                this.mdl_upProfile.file = this.$refs.file.files[0]; 

            },
            reload: function(){
                location.reload();
            },
            mdl_upPass_defaults: function(){ 
                this.mdl_upPass.toggled = false;
                this.mdl_upPass.password = '';
                this.mdl_upPass.newPassword = '';
                this.mdl_upPass.cNewPassword = '';
                
            },
            close_mdl_upPass: function(){
                this.mdl_upPass.toggled = false;
                this.mdl_upPass.password = '';
                this.mdl_upPass.newPassword = '';
                this.mdl_upPass.cNewPassword = '' 
                this.setAlerts_default();
            },
            btn_upPass: function (){  
                if(this.mdl_upPass.password == '' || this.mdl_upPass.newPassword == '' || this.mdl_upPass.cNewPassword == ''){
                    this.setAlerts("Fill up the form properly.", "error", true);
                }
                else if(this.mdl_upPass.newPassword != this.mdl_upPass.cNewPassword){
                    this.setAlerts("New Password and Confirm Password did not match", "error", true);
                }else{  
                    axios.post("../../controller/admin/account.controller.php", {
                        action: 'btn_upPass',
                        password:   this.mdl_upPass.password,
                        newPassword:    this.mdl_upPass.newPassword 
                    }).then(function(response){
                        if(response.data.success){
                            app.setAlerts("Password Successfully Updated", "success", true);
                            app.mdl_upPass_defaults();
                        }else{
                            app.setAlerts("You've entered a wrong password.", "error", true);
                            app.mdl_upPass.password = '';
                        }
                    });
                }
            },
            close_mdl_UpAcc: function(){
                this.mdl_upAcc_defaults();
                this.setAlerts_default(); 
            },
            mdl_upAcc_defaults: function(){
                this.mdl_upAcc.toggled = false;
                this.mdl_upAcc.usr_id = '<?= $user_info['usr_id'] ?>';
                this.mdl_upAcc.email =      '<?=$user_info['email']?>';
                this.mdl_upAcc.firstname =  '<?=$user_info['firstname']?>';
                this.mdl_upAcc.middlename = '<?=$user_info['middlename']?>';
                this.mdl_upAcc.lastname =   '<?=$user_info['lastname']?>'; 
            },
            btn_upAcc: function(){
                var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if(this.mdl_upAcc.email == '' || this.mdl_upAcc.firstname == '' || this.mdl_upAcc.lastname == ''){
                    this.setAlerts("Email, Firstname, Lastname cannot be empty.", "error", true);
                }
                else if(!this.mdl_upAcc.email.match(mailformat)){
                    this.setAlerts("Please input a valid email address.", "error", true);
                }
                else{ 
                    axios.post("../../controller/admin/account.controller.php", {
                        action:     'btn_upAcc', 
                        usr_id:     this.mdl_upAcc.usr_id,
                        email:      this.mdl_upAcc.email,
                        firstname:  this.mdl_upAcc.firstname,
                        middlename: this.mdl_upAcc.middlename,
                        lastname:   this.mdl_upAcc.lastname
                    }).then(function(response){
                        if(response.data.success){  
                            location.reload(); 
                           
                        }else{
                            app.setAlerts("Something went wrong. Student ID or Email may already be exist", "error", true);
                           
                        }
                        
                    }); 
                }
            },
            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 
            setAlerts_default: function(){
                this.alerts.message = '';
                this.alerts.type = '';
                this.alerts.toggled = false; 
            }
        },
        created: function(){
             
        }
    });
  
</script>

 
<?php include '../_includes/footer.php'; ?>
