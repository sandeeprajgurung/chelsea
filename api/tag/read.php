<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../../config/Database.php';
include_once '../../models/Tag.php';


$database = new Database;
$conn = $database->connection();

$table_name = 'tags';
$tag = new Tag($conn, $table_name);

$result = $tag->read();
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
