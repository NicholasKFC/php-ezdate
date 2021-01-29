<?php
require_once '../connection.php';

$id = intval($_GET['id']);

$query = "DELETE FROM users WHERE user_id = $id";
mysqli_query($cn, $query);
mysqli_close($cn);

session_start();
session_unset();
session_destroy();

header("Location: /");