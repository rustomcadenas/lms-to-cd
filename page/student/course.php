<?php include '../_includes/header.php'; ?>
    <title>Welcome to SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

    $studentsCourses = "SELECT * FROM tbl_course, tbl_studentcourse where tbl_course.crs_id =  tbl_studentcourse.crs_id and tbl_studentcourse.usr_id = :usr_id";
    $studentsCourses = DB::query($studentsCourses, array(':usr_id'=>$_SESSION['loggedID']));  

?> 



<!-- / php  -->


<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="index">
    <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
            <div class="row">  
                <div class="col-sm-12 margin-b-20">   
                    <h3>Enrolled Courses: 
                        <button 
                            class="btn btn-primary btn-sm"
                            @click="toggleShowAccess()"
                        >Add
                        </button>
                    </h3>
                </div>
            </div> 
            <!-- /.row  --> 
            <div class="row">
<?php 
    if(count($studentsCourses)>0){
        foreach($studentsCourses as $studentCourse){ 
    ?> 
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body"> 
<?php 
    $getFaculty = "SELECT usr_id from tbl_course where crs_id = :crs_id";
    $getFaculty = DB::query($getFaculty, array(':crs_id'=> $studentCourse['crs_id']))[0];

    $faculty = "SELECT * FROM tbl_user where usr_id = :faculty_id";
    $faculty = DB::query($faculty, array(':faculty_id' => $getFaculty['usr_id']))[0]; 
?>
                                <center> 
                                    <img src='../../<?= $faculty['profilepic'] ?>' style='width: 45px; height: 45px;' class="pp">
                                    <p class='paragraph'><?= $faculty['firstname'] ?> <?= $faculty['lastname'] ?></p>
                                    <h4 style="margin: 0px"><?= $studentCourse['descriptitle'] ?></h4> 
                                    <p class="paragraph"><?= $studentCourse['num'] ?></p>
                                </center>  
                        </div> 

                        <div class="panel-footer">
                            <center>
                            <a href="post.php?course=<?= $studentCourse['crs_id'] ?>" class="btn btn-info">
                                View Course
                            </a>
                            </center>
                        </div>
                    </div>
                </div> 
<?php }  }else{?>
                <div class="col-sm-12">
                    <center>
                        <h1>You have not yet enrolled to any Course.</h1> 
                    </center>
                </div>
            </div>
            <!-- /row  -->
<?php } ?>
    <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 

    
<template v-if="showAccess">  
            <div class="popup" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">

                <div class="modal-header">
                    <button 
                        type="button" 
                        class="close" 
                        @click="toggleShowAccess()"
                        > <span>&times;</span>
                    </button>
                    <h4 class="modal-title">Join Course</h4>
                </div>
                <!-- /.header  -->

                <div class="modal-body">   
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Access Code: </label>
                            <input 
                                type    = "text" 
                                class   = "form-control"
                                v-model = "accesscode"
                            />
                            <template v-if="accessError"> 
                                <p class="text-danger p-error"> {{ accessMessage }} </p>
                            </template>
                        </div>
                    </div>
                </div> 
                <!-- /. modal body  -->

                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-default btn-sm" 
                        @click="toggleShowAccess()"
                        >Close
                    </button> 
                    <button
                        type    = "button"
                        class   = "btn btn-primary btn-sm" 
                        @click  = "addCourse()"
                        > Add
                    </button>
                </div>
                <!-- /footer  -->

                </div>
              </div>
            </div> 
          <!-- /modal  -->  
</template> 
    </div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
    var app = new Vue({
        el: "#index",
        data: {
            showAccess: false,
            accesscode: '',
            accessError: false,
            accessMessage: ''
        },
        methods: {
            toggleShowAccess: function (){
                this.showAccess = !this.showAccess;
            },
            addCourse: function(){
                if(this.accesscode == ''){
                    this.accessError = true;
                    this.accessMessage = "Cannot Be Empty"
                }else{
                    axios.post("../../controller/students/index.controller.php", {
                        action: 'addCourse',
                        accesscode: this.accesscode
                    }).then(function(response){
                        if(response.data.error){ 
                            app.accessError = true;
                            app.accessMessage = "Invalid Access Code.";
                        }else{
                            window.location.replace(response.data.link);
                        }  
                    });
                }
            }
        }
    });
</script>



<?php include '../_includes/footer.php'; ?>