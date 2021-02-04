<?php  
require_once '../connection.php';
session_start();
$otp = intval($_POST['otp']);
$id = $_SESSION["user_details"]["user_id"];
$true = 1;

$query = "SELECT * FROM users WHERE user_id = ? AND otp = ?";
$stmt = $cn->prepare($query);
$stmt->bind_param("ii", $id,  $otp);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user) {
    session_start();
    $query = "UPDATE users SET otp_verification = ? WHERE user_id = ?";
    $stmt = $cn->prepare($query);
	$stmt->bind_param("ii", $true, $id);
	$stmt->execute();
	$stmt->close();
	$cn->close();
	$_SESSION["user_details"] = $user;
	header("Location: /"); 
} else {
	session_unset();

	session_destroy();
	
	echo "Wrong OTP";
	echo "<br>";
	echo "<a href='/'>Go to login </a>";
}