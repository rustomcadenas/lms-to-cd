var app = new Vue({
    el: "#course",  
    data: {
        modal_addCourse: false,
        error: false,
        success: false, 
        changeAccessCode: false, 
        number: '',
        section: '',
        descriptitle: '',   
        start_time: '',
        end_time: '',
        days: 'MWF',
        courses: '',
        mode: 'save',
        mode: 'update',
        hiddenID: '',
        message: '',
        accesscode: '',
        noCourse: false
    },
    methods: {
        toggle_addCourse: function(){
            this.clearData();
            this.mode = 'save';
            this.modal_addCourse = !this.modal_addCourse;
        },
        save_course: function (){ 
            if(this.number == '' || this.section == '' || this.descriptitle == ''){
                this.error = true; 
            }else{ 
                axios.post("../../controller/faculty/course.controller.php", { 
                action: 'save_course',  
                number: this.number,
                section: this.section,
                descriptitle: this.descriptitle,   
                start_time: this.start_time,
                end_time: this.end_time,
                days: this.days
            }).then(function(response){
                if(response.data.error){
                    alert("Something went wrong");
                }else{ 
                    app.clearData();
                    app.modal_addCourse = false;
                    app.success = true;
                    app.message = "New Course Successfully Created. ";
                    app.fetchAllCourse(); 
                }
            }); 

            } 
        },
        update_course: function (){  
            if(this.number == '' || this.section == '' || this.descriptitle == ''){
                this.error = true; 
            }else{ 
                axios.post("../../controller/faculty/course.controller.php", { 
                    action: 'update_course', 
                    crs_id: this.hiddenID, 
                    number: this.number,
                    section: this.section,
                    descriptitle: this.descriptitle,   
                    start_time: this.start_time,
                    end_time: this.end_time,
                    days: this.days
                }).then(function(response){
                    app.clearData();
                    app.modal_addCourse = false;
                    app.success = true;
                    app.message = "Course Successfully Updated. ";
                    app.fetchAllCourse();
                }); 

            } 
        },
        delete_course: function (id, descriptitle){
            if(confirm("Are you sure you want to delete "+ descriptitle + " course?")){
                axios.post("../../controller/faculty/course.controller.php", {
                    action: 'delete_course',
                    crs_id: id
                }).then(function(response){
                    app.success = true;
                    app.message = "Course Successfully Deleted. "; 
                    app.fetchAllCourse();
                });
            }
           
        },
        fetchAllCourse: function(){
            axios.post("../../controller/faculty/course.controller.php",{
                action: 'fetchAllCourse',
            }).then(function(response){
                if(response.data == 'empty'){
                    app.noCourse = true;
                    app.courses = '';
                }else{ 
                    app.noCourse = false;
                    app.courses = response.data; 
                }
            });
        },
        edit_Course: function(id){
            this.mode = 'update'; 
            this.hiddenID = id;
            axios.post('../../controller/faculty/course.controller.php', {
                action: 'edit_Course',
                crs_id: id
            }).then(function(response){
                app.number          = response.data.num; 
                app.section         = response.data.section;
                app.descriptitle    = response.data.descriptitle;
                app.start_time      = response.data.start_time;
                app.end_time        = response.data.end_time;
                app.days            = response.data.schedule;
                app.modal_addCourse     = true; 
            });
        },
        copyAccessCode: function (code){
            this.accesscode = code;
            let testingCodeToCopy = document.querySelector('#code');
            testingCodeToCopy.setAttribute('type', 'text');
            testingCodeToCopy.select(); 
            var successful = document.execCommand('copy');
            testingCodeToCopy.setAttribute('type', 'hidden');
        },
        showAccessCode: function(code, id){
            this.accesscode  = code;
            this.changeAccessCode = true;
            this.hiddenID = id; 
        },
        generateCode: function(){
            axios.post('../../controller/faculty/course.controller.php', {
                action: 'generateCode'
            }).then(function(response){
                app.accesscode = response.data;
            });
        },
        update_accesscode: function(){
            if(this.accesscode == ''){
                alert("Accesscode cannot be empty");
            }else{
                axios.post('../../controller/faculty/course.controller.php', {
                    action: 'update_accesscode',
                    crs_id: this.hiddenID,
                    accesscode: this.accesscode 
                }).then(function(response){
                    if(response.data == 'exist'){
                        alert("Accesscode Already Exist.");
                    }else{  
                        app.fetchAllCourse();
                        app.changeAccessCode = false;
                        app.accesscode = '';
                        app.success = true;
                        app.message = "Access Code Successfully Updated. ";
                    }
                });
            }
        },
        clearData: function(){
            this.number          = '';
            this.section         = '';
            this.descriptitle    = '';
            this.start_time      = '';
            this.end_time        = '';
            this.days            = 'MWF';
        }
    },
    created: function(){
        this.fetchAllCourse();
    }
});