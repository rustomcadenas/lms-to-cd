<?php include 'includes/header.php'; ?>
        <title>Login to SDSSU CANTILAN LMS</title> 
    </head>
    <body>
        <div id="index">
            <div class="container">
<?php include 'includes/navigation.php'; ?>
 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ content  -->
<form class="form-signin" action="controller/login.controller.php" method="post" autocomplete=" " >
                <h2 class="form-signin-heading">Please sign in</h2>

                <input  
                class="form-control" 
                placeholder="Email Address or ID" 
                required  
                name = "email"  
                <?= (isset($_SESSION['temp']['email'])) ? "value='". $_SESSION['temp']['email'] ."'" : 'autofocus' ?> 
                />  

                <input 
                type="password"
                class="form-control" 
                placeholder="Password" 
                required 
                name="pass" 
                autofocus        
                />

                <div class="checkbox"> 

                </div>
                <button class="btn btn-lg btn-primary btn-block last" type="submit" name="btn_signin">Sign in</button>

                <br>
<?php if(isset($_SESSION['temp']['message'])){ ?>
                <div class="alert <?= ($_SESSION['temp']['success'] == true) ? 'alert-success' : 'alert-danger' ?>">
                    <?= $_SESSION['temp']['message'] ?>
                </div>
<?php } ?>

<?php if(isset($_SESSION['temp2']['message'])){ ?>
                <div class="alert <?= ($_SESSION['temp2']['success']) ? 'alert-success' : 'alert-danger' ?>">
                    <?= $_SESSION['temp2']['message'] ?>
                </div>
<?php } 
unset($_SESSION['temp2']);
?>
                <a href="forgotpass.php">Forgot password? </a>
                <hr class="divider">
                <a href="create.php" class="deco-none text-center"><h4>Create Student Account?</h4></a>
            </form> 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++ /content  -->
            </div>
            <!-- /.container  -->   
        </div>
        <!-- /#index  --> 
<br><br>
<?php include 'includes/footer.php'; ?>
