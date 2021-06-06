<div id="navigation">  
            <div class="header clearfix">
                <ul class="nav nav-pills pull-right"> 
                    <li role="presentation" class="active hamburger_menu">
                        <a class="a_menu" @click="toggleShowDropNav()">
                            <img src="../../icons/menu.svg">
                        </a>
                    </li> 
                </ul>  
                <h3 class="text-muted" style="color: #428bca">
                    <a href="index.php" class="deco-none">
                        <img src="../../icons/logo.png" class="logo">  
                        SDSSU Cantilan LMS
                    </a>
                </h3>  
            </div> 

    <template v-if="showDropNav"> 
        <div class="row">
            <div class="col-sm-12">
                <div class="list-group" style="margin-bottom: 10px; border-top: 1px solid #EEEEEE; margin-top: -30px; "  >  
                    <!-- <a href="#" class="list-group-item active">Home</a>
                    <a href="#" class="list-group-item mymenu">Services</a>
                    <a href="#" class="list-group-item mymenu">Accounts</a> -->
                    <a href="account.php" class="list-group-item mymenu">Account</a>
                    <a href="../../controller/logout.controller.php" class="list-group-item mymenu">Log Out</a>
                </div> 
            </div> 
        </div> 
    </template>
</div>
<!-- /#navigation  -->

<script>    
    var navi = new Vue({
        el: "#navigation",
      data: {
         showDropNav: false
      },
      methods:{
         toggleShowDropNav: function() {
            this.showDropNav = !this.showDropNav;
         }
      }
    });
</script>