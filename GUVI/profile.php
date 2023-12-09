<?php
$userid=$_GET["userid"];
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$filter = ['_id' => ['$eq' => $userid]];
$options = [];
$response = [];
$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('mydb.user', $query);
foreach ($cursor as $document) {
    $response['_id'] = $document->_id;
    $response['fullname'] = $document->fullname;
    $response['address'] = $document->address;
    $response['phno'] = $document->phno;
    $response['dob'] = $document->dob;
    $response['gender'] = $document->gender;
    
}
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
?>
<?php
// $userid = $_GET["userid"];
// $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
// $filter = ['_id' => ['$eq' => $userid]];
// $options = [];

// $query = new MongoDB\Driver\Query($filter, $options);
// $cursor = $manager->executeQuery('mydb.user', $query);

// $response = []; // Initialize an array to hold the response data

// foreach ($cursor as $document) {
//     $response['_id'] = $document->_id;
//     $response['fullname'] = $document->fullname;
// }

// header('Content-Type: application/json; charset=utf-8');
// echo json_encode($response);
// ?>
