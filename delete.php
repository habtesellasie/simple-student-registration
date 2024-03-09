<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "section3";
$pdo = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    $statement = $pdo->prepare("DELETE FROM student WHERE sid = :sid");
    $statement->bindValue("sid", $sid);
    $statement->execute();
}

header("Location: index.php");
exit();
