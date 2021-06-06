<?php include '../_includes/header.php'; ?>  
<?php 

    if(isset($_POST['search'])){
        $search = $_POST['toBe_search'];
        $list_of_faculty = "SELECT * FROM tbl_user WHERE types='Faculty' AND firstname LIKE '%". $search ."%' OR lastname LIKE '%". $search ."%' OR middlename LIKE '%". $search ."%' OR email LIKE '%". $search ."%' OR std_id LIKE '". $search ."%' ";
        $list_of_faculty = DB::query($list_of_faculty); 
    }else{
        $list_of_faculty = "SELECT * FROM tbl_user WHERE types='Faculty' ORDER BY firstname ASC";
        $list_of_faculty = DB::query($list_of_faculty);  
    } 
    
    $results_per_page = 10;
    $number_of_results = count($list_of_faculty);

    $number_of_pages = ceil($number_of_results/$results_per_page);
 

    if (!isset($_GET['page'])) {
        $page = 1;
       
      } else {
        $page = $_GET['page'];
        
      }

    $this_page_first_result = ($page-1)*$results_per_page;

    if(isset($_POST['search']) && $_POST['toBe_search'] != ''){
        $search = $_POST['toBe_search'];
        $list_of_faculty = "SELECT * FROM tbl_user WHERE types='Faculty' AND firstname LIKE '%". $search ."%' OR lastname LIKE '%". $search ."%' OR middlename LIKE '%". $search ."%' OR email LIKE '%". $search ."%' OR std_id LIKE '". $search ."%' ORDER BY firstname ASC LIMIT ". $this_page_first_result .", ". $results_per_page ."";
        $list_of_faculty = DB::query($list_of_faculty);  
    }else{
        $list_of_faculty = "SELECT * FROM tbl_user WHERE types='Faculty' ORDER BY firstname ASC LIMIT ". $this_page_first_result .", ". $results_per_page ."";
        $list_of_faculty = DB::query($list_of_faculty); 
    }
 
    


?> 
<title>Admin | Faculty | SDSSU LMS</title> 
</head>

<body>

<div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    <?php include '../_includes/admin_navigation.php';  ?> 

    <!-- ========================================================================================= CONTENT  -->
<div id="content">

    <div class="row well admin-row">
        <div class="col-lg-12" style="position: static">
            <h3 class="sub-header">Faculty <button class="btn btn-primary" @click="toggleshowModal()">Add</button> </h3> 
            <hr class="hr-style">
            
            <div class="row">
                <form action="faculty.php" method="post">

                    <div class="col-sm-6"  style="position: static">  
                        <input type="text" class="form-control" placeholder="Search for..." name="toBe_search" value="<?= (isset($_POST['toBe_search']))? $_POST['toBe_search']: '' ?>"> 
                    </div>

                    <div class="col-sm-6"  style="position: static">
                        <button class="btn btn-warning" name="cancel">Cancel</button>
                        <button class="btn btn-info" name="search">Search</button>
                    </div>

                </form>
            </div>
            <!-- /row  --> <br> 

            <div class="row">
                <div class="col-sm-12"  style="position: static">

                <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>status</th>
                            <th>Profile</th>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th> 
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
    <?php foreach($list_of_faculty as $faculty){ ?>
                        <tr>

                            <td>   
                                <?= ($faculty['active'] == '1') ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Blocked</span>' ?> 
                            </td> 

                            <td>
                                <img src="../../<?= $faculty['profilepic'] ?>" class="img-circle" style="height: 20px; width: 20px;" alt="">
                            </td>

                            <td>
                                <?= $faculty['std_id'] ?>
                            </td>

                            <td>
                                <?= $faculty['firstname'] ." ". $faculty['middlename'] ." ". $faculty['lastname']?> 
                            </td>

                            <td>
                                <?= $faculty['email'] ?>
                            </td> 
                            
                            <td>
                                <a href="faculty_view.php?faculty=<?= $faculty['usr_id'] ?>" class="a_menu">View</a>
                            </td>

                        </tr> 
    <?php } ?>
                    </tbody> 
            </table> 
        <hr style="border: 1px solid gray">
            <nav aria-label="Page navigation" style="margin-top: -30px !important;">
                <ul class="pagination">
                    <li class="<?= ($page == 1) ? 'disabled': ''?>">
                        <a <?= ($page == 1) ? "": "href='faculty.php?page=". ($page-1) ."'" ?> aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a> 
                    </li>

                    <?php for($pagi=1;$pagi<=$number_of_pages;$pagi++){ ?>
                        <li class="<?= ($page == $pagi) ? 'active' : '' ?>">
                            <a href="faculty.php?page=<?= $pagi ?>"><?= $pagi ?></a>
                        </li> 
                    <?php } ?>

                    <li class="<?= ($page == $number_of_pages) ? 'disabled' : ''?>">
                        <a  <?= ($page == $number_of_pages) ? "": "href='faculty.php?page=". ($page+1) ."'" ?>  aria-label="Next">
                            <span aria-hidden="true">&raquo;</span> 
                        </a>
                    </li>
                    
                </ul>
            </nav>  
 
        </div>
                
                </div> 
            </div>
           
    </div> 
        <!-- /row well  -->
        
        <!-- modal  -->


        <template v-if="showModal">  
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="close_showModal()"><span>&times;</span></button>
                  <h4 class="modal-title">Add New Faculty</h4>
                </div>
                <div class="modal-body"> 

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

                <div class="row"> 
                      
                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label class="control-label">ID:</label>
                          <input type="text" class="form-control" v-model="id">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label>Department</label>
                          <input type="text" class="form-control" v-model="department">
                        </div>
                      </div> 
                  </div>


                  <div class="row"> 

                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label class="control-label">First Name</label>
                          <input type="email" class="form-control" v-model="firstname">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label for="email">Middle Name</label>
                          <input type="email" class="form-control" v-model="middlename">
                        </div>
                      </div> 
                  </div>

                    <div class="row"> 
                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label for="email">Last Name</label>
                            <input type="email" class="form-control" v-model="lastname">
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label for="email">User Type</label>
                            <select class="form-control" v-model="type">
                              <option>Faculty</option> 
                            </select> 
                          </div>
                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="email">
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label for="email">Password</label>
                            <input type="password" class="form-control" v-model="password">
                          </div>
                        </div> 
                    </div>
                     
                </div> 
                <!-- /. modal body  -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-sm" @click="close_showModal()">Close</button>
                  <button type="button" class="btn btn-primary btn-sm" @click="saveFaculty()">Save</button>
                </div>
                <!-- /footer  -->
                </div>
              </div>
            </div>
          </template>
</div>
<!-- /#content  --> 
<!-- ========================================================================================= /CONTENT  --> 

</div> 
<!-- /container admin--> 

<script>
    var app = new Vue({
        el: "#content",
        data: {
            id: '',
            department: '',
            showModal: false,
            firstname: '',
            middlename: '',
            lastname: '',
            type: 'Faculty',
            email: '',
            password: '',  
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },  
          
        },
        methods: {
            setDefaults_showModal: function (){
                this.id         = '';
                this.department = '';
                this.firstname  = '';
                this.middlename = '';
                this.lastname   = '';
                this.type       = 'Faculty';
                this.email      = '';
                this.password   = '';
            },
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
            close_showModal: function (){
                location.reload();
            },
            toggleshowModal: function (){
                this.showModal = !this.showModal;
            },
            saveFaculty: function (){  
                var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if(this.firstname == '' || this.lastname == '' || this.email == '' || this.password == ''){
                    this.setAlerts("Please Insert important Fields", "error", true); 
                }
                else if(!this.email.match(mailformat)){
                    this.setAlerts("Please insert a valid email address", "error", true); 
                }
                else{
                    axios.post("../../controller/admin/index.controller.php", {
                        action:     'saveFaculty',
                        id:         this.id,
                        department: this.department,
                        firstname:  this.firstname,
                        middlename: this.middlename,
                        lastname:   this.lastname,
                        type:       this.type,
                        email:      this.email,
                        password:   this.password
                    }).then(function(response){
                        if(response.data.success){ 
                            app.setDefaults_showModal();
                            app.setAlerts("New Faculty Inserted", "success", true);
                        }else{ 
                            app.setAlerts("Something Went Wrong. It's either ID or Email already exist. Please Try again later. ", "error", true);
                        } 
                    }); 
                } 
            }
        }
    });
</script>
  
<?php include '../_includes/footer.php'; ?>