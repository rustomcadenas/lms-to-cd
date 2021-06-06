<?php include '../_includes/header.php'; ?> 
<title>Faculty Courses - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

?>  

<div class="container">
    <?php include '../_includes/navigation.php'; ?>


<div id="course">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<a href="index.php" class="btn btn-info btn-sm"><b><</b> Back</a>

    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Enrolled Courses: 
                <button 
                    class="btn btn-primary btn-sm"
                    @click="toggle_addCourse()">
                    Add
                </button>
            </h3>
        </div>
    </div>
    <!-- /.row   -->

    <template v-if="success">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                <a class="close" @click="success=false">&times;</a>
                    {{ message }}
                </div>
            </div> 
        </div>
        <!-- /.row  --> 
    </template>   

<template v-for="course in courses">
    <div class="row"> 
        <div class="col-sm-12">
            <div class="panel panel-success"> 

                <div class="panel-body">
                    <h3 class="text-center"> 
                        {{course.descriptitle}}
                    </h3>
                    <p class="text-center paragraph">
                        {{course.num}} | {{course.section}}
                    </p>
                    <p class="text-center paragraph">
                        {{course.start_time}} - {{course.end_time}} | {{course.schedule}}
                    </p>
                    <p class="text-center paragraph">
                        Accesscode: <strong>{{course.accesscode}}</strong> <button @click="copyAccessCode(course.accesscode)">Copy</button>
                    </p> 
                </div>  
                <input type="hidden" id="code" v-model="accesscode">

                <div class="panel-footer">
                    <button class="btn btn-sm btn-danger" @click="delete_course(course.crs_id, course.descriptitle)">Delete</button> 
                    <a :href="'post.php?course='+ course.crs_id" class="pull-right btn btn-sm btn-primary">View</a> 
                    <button class="pull-right btn btn-sm btn-success m-r-15" @click="edit_Course(course.crs_id)">Edit</button> 
                    <button class="pull-right btn btn-sm btn-info m-r-15" @click="showAccessCode(course.accesscode, course.crs_id)">Change AccessCode</button>
                </div>
                
            </div>
        </div>
    </div>
<!-- /.row  --> 
</template>

<template v-if="noCourse">  
<center>
    <h1> No Course Yet. </h1>
</center>
</template>  

<template v-if="modal_addCourse"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="toggle_addCourse()"><span>&times;</span></button>
                  <h4 class="modal-title">{{ (mode=='save') ? 'Add New Course' : 'Update Course'}}</h4>
                </div>
                <div class="modal-body">  
                  <div class="row"> 
                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label>Course Number</label>
                          <input 
                            type="text" 
                            class="form-control" 
                            v-model="number"
                            required
                            >
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label>Course Section</label>
                          <input 
                            type="text" 
                            class="form-control" 
                            v-model="section"
                            required
                            >
                        </div>
                      </div> 
                  </div>

                    <div class="row"> 
                        <div class="col-sm-12">
                          <div class="form-group"> 
                            <label>Descriptive Title</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                v-model="descriptitle"
                                required
                                >
                          </div>
                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label>Time (Start - End)</label> 
                                <div class="row">
                                    <div class="col-sm-6">  
                                        <input 
                                            type="time" 
                                            class="form-control" 
                                            v-model="start_time" 
                                            >
                                    </div>  
                                    
                                    <div class="col-sm-6">  
                                        <input 
                                            type="time" 
                                            class="form-control"
                                            v-model="end_time" 
                                            >
                                    </div>
                                </div> 
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label>Days</label>
                                <select v-model="days" class="form-control">
                                    <option>MWF</option>
                                    <option>TTH</option>
                                    <option>S</option>
                                </select>
                          </div>
                        </div> 
                    </div> 
                    <input 
                        type="hidden" 
                        v-model="hiddenID"
                        >

                    <template v-if="error">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger">
                                <a class="close" @click="error=false">&times;</a>
                                    <strong>Error!</strong> Please Fill up the following.
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
                            @click="toggle_addCourse()"
                            >Close
                        </button>  
                        <template v-if="mode=='save'">  
                            <button 
                                type="button"  
                                @click="save_course()"
                                class="btn btn-primary btn-sm"
                                >
                                Save
                            </button>   
                        </template>
                        <template v-if="mode=='update'">  
                            <button 
                                type="button"  
                                @click="update_course(hiddenID)"
                                class="btn btn-info btn-sm"
                                >
                                Update
                            </button>   
                        </template>
                    </div> 
                
                <!-- /footer  -->
                </div>
              </div>
            </div> 
          <!-- /end add modal  -->
          <!-- </form>  -->
</template>


<template v-if="changeAccessCode">  
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">

                <div class="modal-header">
                    <button 
                        type="button" 
                        class="close" 
                        @click="changeAccessCode = false"
                        > <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Change Accesscode</h4>

                </div>
                <!-- /.header  -->

                <div class="modal-body">   
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Access Code: </label>
                            <p>
                                <button class="btn btn-sm btn-success" @click="generateCode()">Generate</button>
                            </p>
                            
                            <input 
                                type    = "text" 
                                class   = "form-control"
                                v-model = "accesscode"
                            /> 
                        </div>
                    </div>
                </div> 
                <!-- /. modal body  -->

                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm" 
                        @click="changeAccessCode = false"
                        >Close
                    </button> 
                    <button
                        type    = "button"
                        class   = "btn btn-primary btn-sm" 
                        @click  = "update_accesscode()"
                        > Update
                    </button>
                </div>
                <!-- /footer  -->

                </div>
              </div>
            </div> 
          <!-- /modal  -->  
</template> 

<!-- /.modal  -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
    
</div>
    <!-- /#course  --> 

</div>
<!-- /.container  -->   

<script src="vue/course.js"> 

</script> 
<?php include '../_includes/footer.php'; ?>