<?php
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    // redirect to parent folder which has index that does everything 
    header("location: ".$baseUrl."login");
    exit;
}
?>

