<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/POST.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database;
$conn = $database->connection();

$table_name = 'categories';
$category = new Category($conn, $table_name);

$data = json_decode(file_get_contents("php://input"));
$category->name = $data->name;

if ($category->create()) {
    echo json_encode(
        array('message' => 'Category created')
    );
} else {
    echo json_encode(
        array('message' => 'Category Not created')
    );
}
