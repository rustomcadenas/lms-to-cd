<?php include '../_includes/header.php'; ?>  
<?php 

    if(isset($_POST['search'])){
        $search = $_POST['toBe_search'];
        $list_of_student = "SELECT * FROM tbl_user WHERE types='Student' AND (firstname LIKE '%". $search ."%' OR lastname LIKE '%". $search ."%' OR middlename LIKE '%". $search ."%' OR email LIKE '%". $search ."%' OR std_id LIKE '". $search ."%' )";
        $list_of_student = DB::query($list_of_student); 
    }else{
        $list_of_student = "SELECT * FROM tbl_user WHERE types='Student' ORDER BY firstname ASC";
        $list_of_student = DB::query($list_of_student);  
    } 
    
    $results_per_page = 10;
    $number_of_results = count($list_of_student);
    
    $number_of_pages = ceil($number_of_results/$results_per_page);
 

    if (!isset($_GET['page'])) {
        $page = 1;
       
      } else {
        $page = $_GET['page'];
        
      }

    $this_page_first_result = ($page-1)*$results_per_page;

    if(isset($_POST['search']) && $_POST['toBe_search'] != ''){
        $search = $_POST['toBe_search'];
        $list_of_student = "SELECT * FROM tbl_user WHERE types='Student' AND (firstname LIKE '%". $search ."%' OR lastname LIKE '%". $search ."%' OR middlename LIKE '%". $search ."%' OR email LIKE '%". $search ."%' OR std_id LIKE '". $search ."%') ORDER BY firstname ASC LIMIT ". $this_page_first_result .", ". $results_per_page ."";
        $list_of_student = DB::query($list_of_student);  
    }else{
        $list_of_student = "SELECT * FROM tbl_user WHERE types='Student' ORDER BY firstname ASC LIMIT ". $this_page_first_result .", ". $results_per_page ."";
        $list_of_student = DB::query($list_of_student); 
    } 

?> 
<title>Admin | Student | SDSSU LMS</title> 
</head>

<body>

<div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    <?php include '../_includes/admin_navigation.php';  ?> 

    <!-- ========================================================================================= CONTENT  -->
<div id="content">

    <div class="row well admin-row">
        <div class="col-lg-12" style="position: static">
            <h3 class="sub-header">student</h3> 
            <hr class="hr-style">
            
            <div class="row">
                <form action="student.php" method="post"> 
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
    <?php foreach($list_of_student as $student){ ?>
                        <tr>

                            <td>   
                                <?= ($student['active'] == '1') ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Blocked</span>' ?> 
                            </td> 

                            <td>
                                <img src="../../<?= $student['profilepic'] ?>" class="img-circle" style="height: 20px; width: 20px;" alt="">
                            </td>

                            <td>
                                <?= $student['std_id'] ?>
                            </td>

                            <td>
                                <?= $student['firstname'] ." ". $student['middlename'] ." ". $student['lastname']?> 
                            </td>

                            <td>
                                <?= $student['email'] ?>
                            </td> 
                            
                            <td>
                                <a href="student_view.php?student=<?= $student['usr_id'] ?>" class="a_menu">View</a>
                            </td>

                        </tr> 
    <?php } ?>
                    </tbody> 
            </table> 
        <hr style="border: 1px solid gray">
            <nav aria-label="Page navigation" style="margin-top: -30px !important;">
                <ul class="pagination">
                    <li class="<?= ($page == 1) ? 'disabled': ''?>">
                        <a <?= ($page == 1) ? "": "href='student.php?page=". ($page-1) ."'" ?> aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a> 
                    </li>

                    <?php for($pagi=1;$pagi<=$number_of_pages;$pagi++){ ?>
                        <li class="<?= ($page == $pagi) ? 'active' : '' ?>">
                            <a href="student.php?page=<?= $pagi ?>"><?= $pagi ?></a>
                        </li> 
                    <?php } ?>

                    <li class="<?= ($page >= $number_of_pages) ? 'disabled' : ''?>">
                        <a  <?= ($page >= $number_of_pages) ? "": "href='student.php?page=". ($page+1) ."'" ?>  aria-label="Next">
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
        
         
</div>
<!-- /#content  --> 
<!-- ========================================================================================= /CONTENT  --> 

</div> 
<!-- /container admin--> 

<script>
    var app = new Vue({
        el: "#content",
        data: {
         
          
        },
        methods: {
        }
    });
</script>
  
<?php include '../_includes/footer.php'; ?>