<?php 

require "./app/core/init.php";
session_start();
$url = $_GET['url'] ?? 'home';
$url = explode("/",$url);

$page_name = trim($url[0]);
$page_name = strtolower($page_name);
$filename = "./app/pages/".$page_name.".php";

$filename_api = "./app/pages/api/".$page_name.".php";
if(file_exists($filename_api))
{
    require_once $filename_api;
    return;
}
if(file_exists($filename))
{
    require_once $filename;
}
else
{
    require_once "./app/pages/404.php";
}