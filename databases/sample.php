<?php 

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lms";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM tbl_forum INNER JOIN tbl_user on tbl_user.usr_id = tbl_forum.usr_id and crs_id = 6 ORDER BY tbl_forum.created_at ASC";
$statement = $conn->prepare($sql);
$statement->execute();
$data = $statement->fetchAll();

print("<pre>");
echo json_encode($data);
print("</pre>");
?>