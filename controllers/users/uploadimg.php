<?php
require_once '../connection.php';
session_start();

$id = intval($_POST['id']);

foreach($_FILES['images']['tmp_name'] as $key => $image) {
    $img_name = $_FILES['images']['name'][$key];
    $img_tmpname = $_FILES['images']['tmp_name'][$key];
    $img_path = "/assets/img/$img_name";

    // Upload file
    move_uploaded_file($img_tmpname, $_SERVER["DOCUMENT_ROOT"].$img_path);

    $query = "INSERT INTO `images` (`user_id`, `image`) VALUES (?, ?)";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("is", $id, $img_path);
    $stmt->execute();
}
$stmt->close();
$cn->close();

header("Location: ". $_SERVER["HTTP_REFERER"]);