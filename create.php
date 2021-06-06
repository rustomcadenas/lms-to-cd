<?php include 'includes/header.php'; ?>
        <style>
            #error{
                display: none;
            }
        </style>
        <title>Create Account to SDSSU CANTILAN LMS</title> 
    </head>
    <body>

<div id="create">
            <div class="container">
<?php include 'includes/navigation.php'; ?>

            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ content  --> 
<form 
    class       ="form-signin" 
    autocomplete="off" 
    method      ="post" 
    action      ="controller/create.controller.php" 
    @submit     ="validateForm"
    onsubmit    ="return validateForm()"
    name        ="createForm"
    > 
                <h3 class="form-signin-heading">Enter Account Information</h3>  
                <input 
                type="text" 
                name="firstname" 
                class="form-control" 
                placeholder="First Name" 
                required 
                autofocus 
                value=""
                />        
                <input 
                type="text" 
                name="lastname" 
                class="form-control" 
                placeholder="Last Name" 
                required 
                autofocus
                value=""
                />
                <input 
                type="email" 
                name="email" 
                class="form-control" 
                placeholder="Email address" 
                required 
                autofocus 
                value="" 
                />
                <input 
                type="password" 
                name="pass" 
                class="form-control" 
                placeholder="Password" 
                required 
                autofocus 
                value=""
                />
                <input 
                type="password" 
                name="confirmPassword" 
                class="form-control last" 
                placeholder="Confirm Password" 
                required 
                autofocus 
                value=""
                /> 

                <div id="error">
                    <div class="alert alert-danger">Password and Confirm Password did not Match!</div>
                </div> 

    <?php if(isset($_SESSION['temp']['message'])){ ?>
                <div class="alert <?= ($_SESSION['temp']['success']) ? 'alert-success' : 'alert-danger' ?>">
                    <?= $_SESSION['temp']['message'] ?>
                </div>
    <?php } ?>


                <button class="btn btn-lg btn-success btn-block last" type="submit" name="btn_signup">Sign Up</button> 
                <br>
                <hr class="divider">
                <a href="login.php" class="deco-none text-center"><h4>Already Have an Account?</h4></a>
</form>  
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++ /content  -->
            </div>
            <!-- /.container  -->   
        </div>
        <!-- /#create  --> 
<br><br>

<script>
    function validateForm(){
        var password = document.forms['createForm']['pass'].value;
        var confirm_password = document.forms['createForm']['confirmPassword'].value; 
        var error = document.getElementById("error");

        if(password != confirm_password){ 
            document.forms['createForm']['confirmPassword'].value = "";
            document.forms['createForm']['confirmPassword'].focus();  
            error.style.display = "block";  
            return false;
         }
    } 
</script>
<?php include 'includes/footer.php'; ?>
 