<?php 

include '../../classes/db.php';

    $questionnaire_id = $_GET['questionnaire']; 
    $course_id = $_GET['course'];

    $course_info = "select * from tbl_course where crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=> $course_id))[0];

     
    $questionnaire_info = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $questionnaire_info = DB::query($questionnaire_info, array(':qstnnr_id'=>$questionnaire_id))[0];

    // SELECT * FROM tbl_forum INNER JOIN tbl_user on tbl_user.usr_id = tbl_forum.usr_id and crs_id = 6 ORDER BY tbl_forum.created_at ASC

    $student_score_infos = "SELECT * FROM tbl_score INNER JOIN tbl_user ON tbl_user.usr_id = tbl_score.usr_id and tbl_score.qstnnr_id=:qstnnr_id";
    $student_score_infos = DB::query($student_score_infos, array(':qstnnr_id'=> $questionnaire_id));




function filterData ($str) {
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}
 

$fileName  = "lmsdata-" . date('Ymd') . ".xls"; 


// Column names 
$fieldsHeaderTop = array('Course Number: ', $course_info['num'], '', 'Description: ', $course_info['descriptitle'], '', '');
$fieldsHeader = array('Title: ', $questionnaire_info['title'], '', 'Items: ', $questionnaire_info['items'], '', '');
$fields = array('#', 'STUDENT ID', 'FIRSTNAME', 'LASTNAME', 'SCORE', 'PERCENT', 'REMARKS'); 

// Display column names as first row 
$excelData = implode("\t", array_values($fieldsHeaderTop)) . "\n";  
$excelData .= implode("\t", array_values($fieldsHeader)) . "\n"; 
$excelData .= implode("\t", array_values($fields)) . "\n"; 

$num = 0;
if(count($student_score_infos) > 0){
    foreach($student_score_infos as $student_score_info){ 
        $num++;
        $excelPercent = ($student_score_info['score']/$questionnaire_info['items'])*100; 
        $remarks = ($excelPercent>50) ? 'Pass' : 'Fail';
        $score = $student_score_info['score'];
        $percent = $student_score_info['score']*.100;
        $rowData = array($num, $student_score_info['std_id'], $student_score_info['firstname'], $student_score_info['lastname'], $student_score_info['score'], $excelPercent. "%", $remarks);
        array_walk($rowData, 'filterData');
        $excelData .= implode("\t", array_values($rowData)). "\n"; 
    } 
}else{
    $excelData .= "No records Found...". "\n";

}  

header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Content-Type: application/vnd.ms-excel"); 

echo $excelData; 
 

?>