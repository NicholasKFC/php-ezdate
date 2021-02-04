<?php
require_once '../connection.php';
session_start();

$id = intval($_POST['id']);
$true = 1;

if($_FILES["image"]["name"] != "") {
    $query = "UPDATE users SET user_verification = ? WHERE user_id = ?";
    $stmt = $cn->prepare($query);
	$stmt->bind_param("ii", $true, $id);
	$stmt->execute();
	$stmt->close();
	$cn->close();
	$_SESSION["user_details"]["user_verification"] = 1;
}
header("Location: ". $_SERVER["HTTP_REFERER"]);