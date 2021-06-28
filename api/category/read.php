<?php
include_once '../config/partials/display_errors.php';
include_once '../config/headers/GET.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database;
$conn = $database->connection();

$table_name = 'categories';
$category = new Category($conn, $table_name);
$result = $category->read();
$num = $result->rowCount();

if ($num > 0) {
    $cat_arr = array();
    $cat_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $reg_date
        );
        array_push($cat_arr['data'], $cat_item);
    }

    echo json_encode($cat_arr);
} else {
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}
