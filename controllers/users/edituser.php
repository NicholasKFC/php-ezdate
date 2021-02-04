<?php
require_once '../connection.php';
session_start();

$id = intval($_POST['id']);
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$email = htmlspecialchars($_POST['email']);

if($_FILES["image"]["name"] != "") {
    $img_name = $_FILES["image"]["name"];
    $img_path = "/assets/img/$img_name";

    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"].$img_path);
    $query = "UPDATE users SET firstname = ?, lastname = ?, email = ?, profile_picture = ? WHERE user_id = ?";
    $stmt = $cn->prepare($query);
	$stmt->bind_param("ssssi", $firstname, $lastname, $email, $img_path, $id);
	$stmt->execute();
	$stmt->close();
	$cn->close();
	$_SESSION["user_details"]["profile_picture"] = $img_path;
} else {
    $query = "UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE user_id = ?";
    $stmt = $cn->prepare($query);
	$stmt->bind_param("sssi", $firstname, $lastname, $email, $id);
	$stmt->execute();
	$stmt->close();
	$cn->close();
}
header("Location: ". $_SERVER["HTTP_REFERER"]);