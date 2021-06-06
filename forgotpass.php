<?php include 'includes/header.php'; 
      include 'classes/db.php';

?>

        <title>Login to SDSSU CANTILAN LMS</title> 
    </head>
    <body>
        <div id="index">
            <div class="container">
<?php include 'includes/navigation.php'; ?>
<?php 
    $admin_email = "SELECT email from tbl_user WHERE types='Admin'";
    $admin_email = DB::query($admin_email)[0]['email'];

?>
 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ content  -->
<form class="form-signin" action=" " method="post" autocomplete=" " >
                <h2 class="form-signin-heading text-center">Recovery</h2>
                <br>
                <h4 class="text-center">Please Contact your Administrator</h4>  
                <br>
                <br>
                
      <center>
                <label 
                type="email" 
                style="color: #337ab7; border: none !important; font-size: 20px; border-bottom: 1px solid #337ab7 !important;" 
                placeholder="Email Address" 
                required  
                name = "email"  
                <?= (isset($_SESSION['temp']['email'])) ? "value='". $_SESSION['temp']['email'] ."'" : 'autofocus' ?> 
                ><?= $admin_email ?></label>  
               

                <label type="submit" name="">Administrator Email</label> 

      </center>
                <br>  
                <br>
                <br>
                <a href="login.php" class="deco-none text-center text-success"><h4>Log in</h4></a>
                <hr>
                <a href="create.php" class="deco-none text-center"><h4>Create Student Account?</h4></a>
            </form> 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++ /content  -->
            </div>
            <!-- /.container  -->   
        </div>
        <!-- /#index  --> 
<br><br>
<?php include 'includes/footer.php'; ?>
