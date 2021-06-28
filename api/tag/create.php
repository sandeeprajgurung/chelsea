<?php
include_once '../partials/display_errors.php';
include_once '../headers/POST.php';
include_once '../../config/Database.php';
include_once '../../models/Tag.php';

$database = new Database;
$conn = $database->connection();

$table_name = 'tags';
$tag = new Tag($conn, $table_name);

$data = json_decode(file_get_contents("php://input"));
$tag->name = $data->name;

if ($tag->create()) {
    echo json_encode(
        array('message' => 'Tag created')
    );
} else {
    echo json_encode(
        array('message' => 'Tag Not created')
    );
}
