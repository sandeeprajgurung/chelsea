<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once 'tables/tags.php';
include_once 'tables/news.php';

$database = new Database();
$db = $database->connection();

$tags = new Tags($db);
$tags->up();

$news = new News($db);
$news->up();
