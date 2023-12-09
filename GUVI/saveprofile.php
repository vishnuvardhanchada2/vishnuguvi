<?php
$jsonData=file_get_contents('php://input');
$id=$_POST["_id"];
$dob=$_POST["dob"];
$phno=$_POST["phno"];
$address=$_POST["address"];
$gender=$_POST["gender"];

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(['_id' => $id],['$set'=>['address'=>$address,'phno'=>$phno,'gender'=>$gender,'dob'=>$dob]],['multi' => false, 'upsert' => false]);
$manager->executeBulkWrite('mydb.user', $bulk);
$data ="Updation sucessfull";
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>