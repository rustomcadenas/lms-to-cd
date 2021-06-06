<div class="container">
            <footer class="footer"> 
                <p class="text-center"> 
                    <label for="">
                        <?= $loggedInfo['firstname'] ." ". $loggedInfo['lastname']?> 
                         | 
                         <span>
                             <?= $loggedInfo['types'] ?>
                         </span>
                         | 
                         <span>
                             <a href="account.php">Account</a>
                         </span>
                         | 
                        <span>
                            <a href="../../controller/logout.controller.php">Logout</a>
                        </span>
                        
                    </label>
                </p>
                <p class="text-center">2020 &copy; SDSSU Cantilan Learning Management System.</p>

            </footer>
        </div>
    </body>
</html>

<?php unset($_SESSION['temp']) ?>