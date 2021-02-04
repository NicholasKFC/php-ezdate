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
$id = $user["user_id"];
if($user && password_verify($password, $user["password"]) && $user['otp_verification'] == 1) {
	session_start();
	$_SESSION["user_details"] = $user;
	header("Location: /");
} elseif($user && password_verify($password, $user["password"]) && $user['otp_verification'] == 0) {
	session_start();
	$_SESSION["user_details"] = $user;
	header("Location: /views/otp_page.php?id={$id}");
} else {
	echo "Please check your credentials";
	echo "<br>";
	echo "<a href='/'>Go to login </a>";
}