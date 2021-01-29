<?php  
require_once '../connection.php';
//require_once '../../vendor/autoload.php';	

$birthday = htmlspecialchars($_POST['birthday']);
$date = date("Y-m-d H:i:s", strtotime($birthday));
//sanitize our inputs
$errors = 0;
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$email = htmlspecialchars($_POST['email']);
$gender_id = intval($_POST['gender_id']);
$password = htmlspecialchars($_POST['password']);
$password2 = htmlspecialchars($_POST['password2']);

//image 
$img_name = $_FILES['image']['name'];
$img_size = $_FILES['image']['size'];
$img_tmpname = $_FILES['image']['tmp_name'];
$img_path = "/assets/img/$img_name";
$img_type = pathinfo($img_name, PATHINFO_EXTENSION);

$is_img = false;

//To check wether the admin upload an image file
if($img_type == 'jpg' || $img_type == 'jpeg' || $img_type == 'png' || $img_type == "svg" || $img_type == "gif") {
	$is_img = true;
} else {
	echo "Please upload an image file";
}

//To check wether the admin fill out all fields.
foreach($_POST as $key => $value) {
	if(strlen($value) == 0 && empty($value)) {
		$errors++;
		die("Please fill out all fields");
	}
}

//password should be greater than 8 characters
if(strlen($password) < 8) {
	echo "Password must be greater than 8 characters";
	$errors++; 
}

//password and confirm password should match
if($password != $password2) {
	echo "Passwords do not match";
	$errors++;
}

//check if the email already exists
if($email) {
	$query = "SELECT * FROM users WHERE email = ?";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_all(MYSQLI_ASSOC);
	
	if($user) {
		echo "Email already exists";
		$errors++;
		$cn->close();
		$stmt->close();
	}
}

//Store the user in the database.
if($errors === 0 && $is_img && $img_size > 0) {
	move_uploaded_file($img_tmpname, $_SERVER["DOCUMENT_ROOT"].$img_path);
	$query = "INSERT INTO users (gender_id, profile_picture, firstname, lastname, birthday, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("issssss", $gender_id, $img_path, $firstname, $lastname, $date, $email, password_hash($password, PASSWORD_DEFAULT));
	$stmt->execute();
	$stmt->close();
	$cn->close();

	//send an email that says you have successfully registered.
	
	//Create the transport
	// $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
	// ->setUsername("")
	// ->setPassword("");
	
	//Create the Mailer using your created Transport
	// $mailer = new Swift_Mailer($transport);
	
	//Create a message
	// $message = (new Swift_Message("B2-ECOM Registration"))
	// ->setFrom(['emerson@forwardschool.co' => 'Emerson']) 
	// ->setTo([$email => $firstname])
	// ->setBody("Thank you for creating an account in B2-ECOM");
	
	// $mailer->send($message);

	header("Location: /");
}