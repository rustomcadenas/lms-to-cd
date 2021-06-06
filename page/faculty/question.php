<?php include '../_includes/header.php'; ?> 
<title>Questions - SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0];  
?> 
 
<!-- / php  -->
 
<div class="container">
    <?php include '../_includes/navigation.php'; ?>


    <div id="content">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<a href="questionnaire.php?course=<?= $_GET['course'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 

<div class="row">
    <div class="col-sm-12">
        <center>
            <p class="paragraph"><b>{{questionnaire_info.title}}</b></p> 
            <p class="paragraph">{{questionnaire_info.descript}} </p> 
            <p class="paragraph">{{questionnaire_info.types}} </p> 
            <p class="paragraph">{{questions.length}} / {{questionnaire_info.items}} Items</p>  
        </center>
    </div>
</div>
<hr>
<div class="row">  
    <div class="col-sm-12 margin-b-20">   
        <h4>Questions <button class="btn btn-primary btn-sm" @click="modal_addQuestion.toggled = true"> Add + </button> </h4>
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


<template v-for="(question, index) in questions"> 
    <div class="row">  
        <div class="col-sm-12">  
            <div class="well well-sm">
                <p> {{(questions.length+1) - (index+1) }}. {{ question.question }} </p>
                <img :src="'../../'+question.file_locale" alt="" style="margin-bottom: 10px; height: 200px">
                <p style="margin-top: -5px; margin-left: 20px; margin-bottom: 2px;">A. {{question.a}}</p> 
                <p style="margin-top: -5px; margin-left: 20px; margin-bottom: 2px;">B. {{question.b}}</p> 
                <p style="margin-top: -5px; margin-left: 20px; margin-bottom: 2px;">C. {{question.c}}</p> 
                <p style="margin-top: -5px; margin-left: 20px; margin-bottom: 2px;">D. {{question.d}}</p> 

                <button class="hover-primary" @click="viewAnswer(question.qstn_id)">View Answer</button> 
                <button class="hover-success" @click="editQuestion(question.qstn_id, (questions.length+1) - (index+1))">Edit</button> 
                <button class="hover-danger" @click="deleteQuestion(question.qstn_id,(questions.length+1) - (index+1), question.file_locale)">Delete</button>

            </div>
        <div> 
    </div> 
</template>

<template v-if="!questions.length"> 
    <div class="row">  
        <div class="col-sm-12">  
            <center>
                <h1>No Questionniare was made. </h1>
            </center>
        <div> 
    </div> 
</template> 
<!-- MODAL  -->
 <template v-if="modal_addQuestion.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="modal_addQuestion_close"><span>&times;</span></button>
                        <h4 class="modal-title">Create Question</h4>
                    </div> 

                    <div class="modal-body">    
                                        
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


 <template v-if="questions.length < questionnaire_info.items">
                <div class="row"> 
                      <div class="col-sm-12">
                        <div class="form-group"> 
                          <label># : {{questions.length+1}}</label> 
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group"> 
                            <label for="email">Question</label> 
                            <textarea name="pst_description" cols="30" rows="4" class="form-control" v-model="modal_addQuestion.question"></textarea> 
                        </div> 
                    </div> 
                </div>

                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">   
                        <label for="email">Attached Image File.</label> 
                            <input type="file" class="form-control" @change="handleFileUpload" ref="file"  accept="image/*">
                        </div> 
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">   
                            <label for="email">Image Preview</label><br>
                            <center>
                                <img v-bind:src="file.preview" style="height: 100px">  
                            </center>
                        </div> 
                    </div>

                </div> 

                

                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control" placeholder="A." v-model="modal_addQuestion.a">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control" placeholder="B." v-model="modal_addQuestion.b">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control"  placeholder="C." v-model="modal_addQuestion.c">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control"  placeholder="D." v-model="modal_addQuestion.d">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group"> 
                            <label>Answer</label> 
                            <select name="" class="form-control" v-model="modal_addQuestion.answer">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div> 
                    </div> 
                </div> 
</template>  

<template v-if="questions.length+1 > questionnaire_info.items"> 
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"> 
                    <label>You have reached the maximum number of questions.</label>  
                </div> 
            </div> 
        </div>
</template>
 
                </div>
                <!-- /. modal body  -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="modal_addQuestion_close() "> Close </button>
                        <template v-if="questions.length < questionnaire_info.items">
                            <button type="button" class="btn btn-primary btn-sm" @click="save_question()">Add</button>  
                        </template>
                    </div>
                    <!-- /footer  -->
                </div>
            </div>
        </div> 
</template> 


<!-- MODAL  -->
<template v-if="modal_editQuestion.toggled"> 
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="close_editQuestion()"><span>&times;</span></button>
                        <h4 class="modal-title">Edit Question</h4>
                    </div>

                    <div class="modal-body">   

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
                          <label># : {{modal_editQuestion.number}}</label> 
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group"> 
                            <label for="email">Question</label> 
                            <textarea name="pst_description" cols="30" rows="4" class="form-control" v-model="modal_editQuestion.question"></textarea> 
                        </div> 
                    </div> 
                </div> 

                    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">   
                        <label for="email">Attached Image File.</label> 
                            <input type="file" class="form-control" @change="edit_handleFileUpload" ref="edit_file"  accept="image/*">
                            <div style="margin-top: 10px" v-if="edit_file.preview">
                              <button style="color: red" @click="removeFile(modal_editQuestion.qstn_id)">Remove File</button> 
                            </div>
                        </div> 
                    </div> 

                    <div class="col-sm-6">
                        <div class="form-group">   
                            <label for="email">Image Preview</label><br>
                            <center v-if="!edit_file.isPreview">
                                <img :src="'../../'+edit_file.preview" style="height: 100px">  
                            </center>
                            <center v-else>
                                <img :src="edit_file.preview" style="height: 100px"> 
                            </center>
                        </div> 
                    </div>

                </div> 

                
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control" placeholder="A." v-model="modal_editQuestion.a">
                        </div> 
                    </div> 
                </div>  

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control" placeholder="B." v-model="modal_editQuestion.b">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control"  placeholder="C." v-model="modal_editQuestion.c">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">   
                            <input type="text" class="form-control"  placeholder="D." v-model="modal_editQuestion.d">
                        </div> 
                    </div> 
                </div> 

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group"> 
                            <label>Answer</label> 
                            <select name="" class="form-control" v-model="modal_editQuestion.answer">
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div> 
                    </div> 
                </div>  
 
                </div>
                <!-- /. modal body  -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="close_editQuestion()">Close</button> 
                        <button type="button" class="btn btn-primary btn-sm" @click="update_question()">update</button>   
                    </div>
                    <!-- /footer  -->
                </div>
            </div>
        </div> 
</template> 
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
            questions: '', 
            crs_id: searchParams.get('course'),
            qstnnr_id: searchParams.get('questionnaire'),
            questionnaire_info: '', 
            modal_addQuestion: {  
                'toggled': false,
                'question': '',
                'image_file': '',
                'a': '',
                'b': '',
                'c': '',
                'd': '',
                'answer': 'a' 
            },
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },
            modal_editQuestion: {
                'toggled': false,
                'qstn_id': '',
                'question': '',
                'a': '',
                'b': '',
                'c': '',
                'd': '',
                'answer': 'a'
            },
            file: {
                preview: '',
                thefile: '',
                type: '',
                filename: '',
            },
            edit_file: {
                isPreview: false,
                preview: '',
                thefile: '',
                type: '',
                filename: ''
            }
        },
        methods: {
            update_question: function(){
                if(this.modal_editQuestion.question == '' || 
                    this.modal_editQuestion.a == '' || 
                    this.modal_editQuestion.b == '' ||
                    this.modal_editQuestion.c == '' || 
                    this.modal_editQuestion.d == ''){ 
                        app.setAlerts("Please Fill up the form!. ", "error", true); 
                 }else{
                    // {
                    //     action: 'update_question',
                    //     qstn_id:    this.modal_editQuestion.qstn_id,
                    //     question:   this.modal_editQuestion.question,
                    //     a:          this.modal_editQuestion.a,
                    //     b:          this.modal_editQuestion.b,  
                    //     c:          this.modal_editQuestion.c,  
                    //     d:          this.modal_editQuestion.d,
                    //     answer:     this.modal_editQuestion.answer
                    //  }
                    let formData = new FormData();
                    formData.append('actioni', 'update_question'), 
                    formData.append('qstn_id', this.modal_editQuestion.qstn_id), 
                    formData.append('question', this.modal_editQuestion.question), 
                    formData.append('a', this.modal_editQuestion.a),
                    formData.append('b', this.modal_editQuestion.b),
                    formData.append('c', this.modal_editQuestion.c),
                    formData.append('d', this.modal_editQuestion.d),
                    formData.append('answer', this.modal_editQuestion.answer) 
                    formData.append('thefile', this.edit_file.thefile);
                    formData.append('file_name', this.edit_file.filename);
                    formData.append('file_types', this.edit_file.type); 


                     axios.post("../../controller/faculty/newquestion.php", formData).then(function(response){
                        if(response.data.success){
                            app.close_editQuestion();
                            app.fetchAllQuestion(); 
                            app.fetchQuestionnaire(); 
                            app.setAlerts("New Data Updated!. ", "success", true);
                        }else{
                            app.setAlerts("Something went wrong. Please try again later!. ", "error", true);
                            app.close_editQuestion(); 
                        }  
                     });
                 }
            },
            
            editQuestion: function (id, num){
                this.modal_editQuestion.toggled = true;
                this.modal_editQuestion.number = num;
                this.modal_editQuestion.qstn_id = id;
                axios.post("../../controller/faculty/question.controller.php", {
                    action: 'editQuestion',
                    qstn_id: id
                }).then(function(response){
                    app.modal_editQuestion.question = response.data.question;
                    app.modal_editQuestion.a = response.data.a;
                    app.modal_editQuestion.b = response.data.b;
                    app.modal_editQuestion.c = response.data.c;
                    app.modal_editQuestion.d = response.data.d;
                    app.modal_editQuestion.answer = response.data.answer;  
                    app.edit_file.preview = response.data.file_locale;

                });
            },
            close_editQuestion: function (id){ 
                this.modal_editQuestion.toggled = false;
                this.modal_editQuestion.qstn_id = '';
                this.modal_editQuestion.question =  '';
                this.modal_editQuestion.a = '';
                this.modal_editQuestion.b = '';
                this.modal_editQuestion.c =  '';
                this.modal_editQuestion.d = '';
                this.modal_editQuestion.answer = 'a';
                this.edit_file.isPreview = false,
                this.edit_file.preview = '';
                this.edit_file.thefile = '';
                this.edit_file.type = '';
                this.edit_file.filename  = '';
            },

            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 

            save_question: function (){
                 if(this.modal_addQuestion.question == '' || 
                    this.modal_addQuestion.a == '' || 
                    this.modal_addQuestion.b == '' ||
                    this.modal_addQuestion.c == '' || 
                    this.modal_addQuestion.d == ''){ 
                        app.setAlerts("Please Fill up the form!. ", "error", true); 
                 }else{
                //     let formData = new FormData(); 
                // formData.append('file', this.modal_post.file);
                // formData.append('title', this.modal_post.title);
                // formData.append('description', this.modal_post.description);
                // formData.append('crs_id', this.crs_id);
                let formData = new FormData();
                formData.append('action', 'save_question'), 
                formData.append('qstnnr_id', this.qstnnr_id), 
                formData.append('question', this.modal_addQuestion.question), 
                formData.append('a', this.modal_addQuestion.a),
                formData.append('b', this.modal_addQuestion.b),
                formData.append('c', this.modal_addQuestion.c),
                formData.append('d', this.modal_addQuestion.d),
                formData.append('answer', this.modal_addQuestion.answer),
                formData.append('crs_id', this.crs_id), 
                formData.append('thefile', this.file.thefile);
                formData.append('filename', this.file.filename);
                formData.append('filetype', this.file.type);
                // {
                        // action: 'save_question',
                        // qstnnr_id: this.qstnnr_id,
                        // question: this.modal_addQuestion.question,
                        // a: this.modal_addQuestion.a,
                        // b: this.modal_addQuestion.b,
                        // c: this.modal_addQuestion.c,
                        // d: this.modal_addQuestion.d,
                        // answer: this.modal_addQuestion.answer,
                        // crs_id: this.crs_id,
                        // qstnnr_id: this.qstnnr_id
                    // }

                    axios.post("../../controller/faculty/newquestion.php", formData).then(function(response){
                        if(response.data){ 
                            app.clearFile();
                            app.fetchAllQuestion();
                            app.$refs.file.value = "";
                            app.clear(); 
                            app.setAlerts("Question successfully created!. ", "success", true); 
                        }else{
                            alert("ERROR");
                        }
                    });
                 }
            },
            
            viewAnswer: function (id){
                axios.post("../../controller/faculty/question.controller.php", {
                    action: 'viewAnswer',
                    qstn_id: id
                }).then(function(response){
                    alert("Correct answer: "+ response.data); 
                });
            },
            deleteQuestion: function(id, title, locale){  
                if(confirm("Are you sure you want to delete question number "+ title)){
                    axios.post("../../controller/faculty/question.controller.php", {
                        action: 'deleteQuestion',
                        qstn_id: id,
                        file_locale: locale
                    }).then(function(response){
                        if(response.data.success){
                            app.fetchAllQuestion(); 
                            app.fetchQuestionnaire();
                            app.setAlerts("Questionnaire successfully Deleted!. ", "success", true);
                        }else{
                            app.fetchAllQuestion(); 
                            app.fetchQuestionnaire();
                            app.setAlerts("An error occure. Please try again later. ", "danger", true);
                        } 
                        console.log(response.data);
                    });
                }
            },

            fetchAllQuestion: function(){
                axios.post("../../controller/faculty/question.controller.php", {
                    action: 'fetchAllQuestion',
                    qstnnr_id: this.qstnnr_id 
                }).then(function(response){
                    app.questions = response.data; 
                });
            },
            fetchQuestionnaire: function (){
                axios.post("../../controller/faculty/question.controller.php", {
                    action: 'fetchQuestionnaire',
                    qstnnr_id: this.qstnnr_id 
                }).then(function(response){
                    app.questionnaire_info = response.data;
                });
            },
            clear: function(){ 
                this.modal_addQuestion.question = '';
                this.modal_addQuestion.a = '';
                this.modal_addQuestion.b = '';
                this.modal_addQuestion.c = '';
                this.modal_addQuestion.d = '';   
                this.modal_addQuestion.answer = 'a';
            },
            clearFile: function(){
                this.file.preview = '';
                this.file.thefile = '';
                this.file.type = '';
                this.file.filename = '';
            },



            handleFileUpload: function(e){  
                this.file.preview =  URL.createObjectURL(e.target.files[0]); 
                this.file.thefile = this.$refs.file.files[0];
                this.file.type = this.file.thefile.type.split('/')[0];
                this.file.filename = this.file.thefile.name; 
                 
            },
            modal_addQuestion_close: function () {
                this.modal_addQuestion.toggled = false
                this.file.preview = '';
            },
            edit_handleFileUpload: function(e) {
                this.edit_file.isPreview = true;
                this.edit_file.preview =  URL.createObjectURL(e.target.files[0]); 
                this.edit_file.thefile = this.$refs.edit_file.files[0];
                this.edit_file.type = this.edit_file.thefile.type.split('/')[0];
                this.edit_file.filename = this.edit_file.thefile.name; 
            },
            removeFile: function(id){
                if(confirm("Are you sure you want to remove the file? ")){

                    let formData = new FormData();
                    formData.append('removefile', "true");
                    formData.append('qstn_id', id);
                    axios.post("../../controller/faculty/newquestion.php", formData).then(function(response) {
                        if(response.data.success){
                            app.close_editQuestion();
                            app.fetchAllQuestion(); 
                        }else{
                            app.setAlerts("An error occu. Please try again later. ", "danger", true);
                        }
                    });
 
                    
                } 
            }

            
        },
        created: function (){
            this.fetchAllQuestion(); 
            this.fetchQuestionnaire();
        }
    });
  
</script> 
<?php include '../_includes/footer.php'; ?>