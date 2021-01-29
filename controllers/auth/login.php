<?php  

require_once '../connection.php';
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = ?";
$stmt = $cn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if($user && password_verify($password, $user["password"])) {
	session_start();
	$_SESSION["user_details"] = $user;
	header("Location: /");
} else {
	echo "Please check your credentials";
	echo "<br>";
	echo "<a href='/'>Go to login </a>";
}