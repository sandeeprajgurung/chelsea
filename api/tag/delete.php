<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once '../../config/Database.php';
include_once '../../models/Tag.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'tags';
$tag = new Tag($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$tag->id = $data->id;

if($tag->destroy()) {
    echo json_encode(
        array('message' => 'Tag deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Tag Not deleted')
    );
}