<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/PUT.php';
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
