<ol class="breadcrumb sticky navigation-admin">
    <li>
        <?= ($uri_segments[4] == 'index.php')? "Dashboard" : "<a href='index.php'> Dashboard </a>"?>  
    </li>
    <li>
        <?= ($uri_segments[4] == 'faculty.php')? "Faculty" : "<a href='faculty.php'> Faculty </a>"?>  
    </li>
    <li>
        <?= ($uri_segments[4] == 'student.php')? "Student" : "<a href='student.php'> Student </a>"?> 
    </li> 
</ol> 

