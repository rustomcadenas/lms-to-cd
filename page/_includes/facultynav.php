<div id="facultynav"> 
        <div class="buttons">
            <a href="course.php" class="btn btn-info btn-sm"><b><</b> Back</a> 
            <button @click="toggleShowJumbo()" class="btn btn-warning btn-sm float-r">
                <template v-if="showJumbo">
                    <img src="../../icons/hide.svg" class="icon_visibility">
                </template>
                <template v-if="!showJumbo">
                    <img src="../../icons/show.svg" class="icon_visibility">
                </template> 
            </button> 
        </div> 

        <template v-if="showJumbo">
            <div class="row">
                <div class="col-sm-12">
                    <div class="jumbotron" style="padding: 2px; margin: 2px !important;">
                        <h3 style="margin-bottom: 2px"><?= $course_info['descriptitle'] ?></h3> 
                        <p style="padding: -10px !important; font-size: 14px;"><?= $course_info['num']?></p>
                    </div>
                </div>  
            </div> 
        </template> 
</div>

<script>
    var appNavigation = new Vue({
        el: "#facultynav",
        data: {
            showJumbo: true,
        },
        methods: {
            toggleShowJumbo: function(){
                this.showJumbo = !this.showJumbo;
            }
        }
        
    });
</script>