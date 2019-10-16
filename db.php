<?
//подключаем конфигирационный файл где указаны логин и пароль базы данных
include_once "dbconfig.php";

//соединяем базы данных
$conn=new mysqli("$dbhost", "$dbuser", "$dbpass","$dbname");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//переключаем кодировку на UTF8
$conn->set_charset("utf8");

?>