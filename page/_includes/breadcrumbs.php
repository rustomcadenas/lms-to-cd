<div class="row" >
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>
                <?= ($uri_segments[4] == 'post.php')? "Post" : "<a href='post.php?course=". $_GET['course'] ."'> Post </a>"?> 
            </li>
            <li>
                <?= ($uri_segments[4] == 'questionnaire.php')? "Questionnaire" : "<a href='questionnaire.php?course=". $_GET['course'] ."'> Questionnaire </a>"?> 
            </li>
            <li>
            <?= ($uri_segments[4] == 'forum.php')? "Forums" : "<a href='forum.php?course=". $_GET['course'] ."'> Forums </a>"?> 
            </li>
            <li>
                <?= ($uri_segments[4] == 'message.php')? "Messages" : "<a href='message.php?course=". $_GET['course'] ."'> Messages </a>"?> 
            </li>


            <?php if($_SESSION['loggedType'] == "Faculty"){ ?>
                <li>
                    <?= ($uri_segments[4] == 'student.php')? "Students" : "<a href='student.php?course=". $_GET['course'] ."'> Students </a>"?> 
                </li>
            <?php } else {  ?>  
                <li>
                    <?= ($uri_segments[4] == 'classmate.php')? "People" : "<a href='classmate.php?course=". $_GET['course'] ."'> People </a>"?> 
                </li> 
               
            <?php } ?>

           
<?php 
    if($_SESSION['loggedID'] == 'Faculty'){
?>
            <li>
                <a href="">Students</a>
            </li>
<?php } ?>
        </ol>
    </div>
</div>
    