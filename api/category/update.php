<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/PUT.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database;
$connection = $database->connection();

$table_name = 'categories';
$category = new Category($connection, $table_name);

$data = json_decode(file_get_contents("php://input"));
$category->name = $data->name;
$category->id = $data->id;

if ($category->update()) {
    echo json_encode(
        array('message' => 'Category Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not updated')
    );
}
