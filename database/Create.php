<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';

include_once 'tables/users.php';
include_once 'tables/tags.php';
include_once 'tables/categories.php';
include_once 'tables/articles.php';
include_once 'tables/users_articles.php';
include_once 'tables/articles_tags.php';
include_once 'tables/articles_categories.php';

$database = new Database();
$db = $database->connection();

$users = new Users($db);
$users->up();

$tags = new Tags($db);
$tags->up();

$categories = new Categories($db);
$categories->up();

$articles = new Articles($db);
$articles->up();

$users_articles = new Users_articles($db);
$users_articles->up();

$articles_tags = new Articles_tags($db);
$articles_tags->up();

$articles_categories = new Articles_categories($db);
$articles_categories->up();
