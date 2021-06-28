<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Tag.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'tags';
$tag = new Tag($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$tag->name = $data->name;
$tag->id = $data->id;

if ($tag->update()) {
    echo json_encode(
        array('message' => 'Tag Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Tag Not updated')
    );
}
