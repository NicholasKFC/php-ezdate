<?php  
session_start();
require_once '../connection.php';

$user_id1 = $_SESSION["user_details"]["user_id"];
$user_id2 = intval($_GET["id"]);

$query = "INSERT INTO `dislike`(`user_id1`, `user_id2`) VALUES (?, ?)";
$stmt = $cn->prepare($query);
$stmt->bind_param("ii", $user_id1, $user_id2);
$stmt->execute();
$stmt->close();
$cn->close();

header("Location: /");