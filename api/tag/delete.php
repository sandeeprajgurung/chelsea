<?php
include_once '../partials/display_errors.php';
include_once '../headers/DELETE.php';
include_once '../../config/Database.php';
include_once '../../models/Tag.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'tags';
$tag = new Tag($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$tag->id = $data->id;

if ($tag->destroy()) {
    echo json_encode(
        array('message' => 'Tag deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Tag Not deleted')
    );
}
