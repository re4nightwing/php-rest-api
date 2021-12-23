<?php 
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$cat->id = $data->id;

$cat->name = $data->name;

if($cat->update()){
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else{
    echo json_encode(
        array('message' => 'Category Not Updated')
    );
}