<?php  
	$csslink = "/assets/css/style.css";
	$title = "Home";
	function get_content() {
	require_once 'controllers/connection.php';
	if(isset($_SESSION["user_details"])) {
		$id = $_SESSION["user_details"]["user_id"];
		if($_SESSION["user_details"]["gender_id"] == 1) {
			$gender_id = 2;
		} elseif($_SESSION["user_details"]["gender_id"] == 2) {
			$gender_id = 1;
		}
	}

	$query = "SELECT `user_id2` FROM `match` WHERE `user_id1` = ?";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$matches = $result->fetch_all(MYSQLI_ASSOC);

	$match_items = array();
	foreach($matches as $match) {
		$match_array = array_values($match);
		$match_implode = implode("", $match_array);
		$match_items[] = $match_implode;
	}
	if(count($match_items) == 0) {
		$in1 = "?";
		$types1 = "i";
		$match_items = array(0);
	} else {
		$in1  = str_repeat('?,', count($match_items) - 1) . '?';
		$types1 = str_repeat('i', count($match_items));
	}

	$query = "SELECT `user_id2` FROM `dislike` WHERE `user_id1` = ?";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$dislikees = $result->fetch_all(MYSQLI_ASSOC);

	$dislike_items = array();
	foreach($dislikees as $dislike) {
		$dislike_array = array_values($dislike);
		$dislike_implode = implode("", $dislike_array);
		$dislike_items[] = $dislike_implode;
	}
	if(count($dislike_items) == 0) {
		$in2 = "?";
		$types2 = "i";
		$dislike_items = array(0);
	} else {
		$in2  = str_repeat('?,', count($dislike_items) - 1) . '?';
		$types2 = str_repeat('i', count($dislike_items));
	}

	$types = "$types1$types2";

	$query = "SELECT * FROM users WHERE gender_id = ? AND user_id NOT IN ($in1) AND user_id NOT IN ($in2)";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("i$types", $gender_id, ...$match_items, ...$dislike_items);
	$stmt->execute();
	$result = $stmt->get_result();
	$users = $result->fetch_all(MYSQLI_ASSOC);

	$query = "SELECT * FROM genders";
	$stmt = $cn->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$genders = $result->fetch_all(MYSQLI_ASSOC);

	$number = 0;
?>
	<?php if(!isset($_SESSION["user_details"])): ?>
	<header class="d-flex justify-content-center align-items-center">
		<div>
			<h1 class="text-center fw-bold pb-4">EZDate<small>©</small></h1>
			<button class="btn btn-outline-success btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">Create Account</button>
		</div>	

		<div class="modal fade" id="registerModal">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content">
					<div class="modal-body">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							<h3 class="text-center pt-4">Create An Account</h3>
							<form class="mx-auto p-5" method="POST" action="/controllers/auth/register.php" enctype="multipart/form-data">
								<div class="mb-3">
									<label>Profile Picture</label>
									<input type="file" name="image" class="form-control">
								</div>
								<div class="mb-3">
									<label>Firstname</label>
									<input type="text" name="firstname" class="form-control">
								</div>
								<div class="mb-3">
									<label>Lastname</label>
									<input type="text" name="lastname" class="form-control">
								</div>
								<div class="mb-3">
									<label>Gender</label>
									<select name="gender_id" class="form-select">
										<?php foreach($genders as $gender): ?>
											<option value="<?php echo $gender['gender_id'] ?>">
												<?php echo $gender["name"]; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mb-3">
									<label>Birthday</label>
									<input type="date" name="birthday" class="form-control">
								</div>
								<div class="mb-3">
									<label>Email</label>
									<input type="email" name="email" class="form-control">
								</div>
								<div class="mb-3">
									<label>Password</label>
									<input type="password" name="password" class="form-control">
								</div>
								<div class="mb-3">
									<label>Confirm Password</label>
									<input type="password" name="password2" class="form-control">
								</div>
								<button class="btn btn-primary">Register</button>
							</form>
						</div>
					</div>
				</div>
			</div>
	</header>
	<?php endif; ?>

	<?php if(isset($_SESSION["user_details"])): ?>
	<?php 
	$query = "SELECT `user_id2` FROM `match` WHERE `user_id1` = ?";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$matches1 = $result->fetch_all(MYSQLI_ASSOC);

	$match1_items = array();
	foreach($matches1 as $match1) {
		$match1_array = array_values($match1);
		$match1_implode = implode("", $match1_array);
		$match1_items[] = $match1_implode;
	}

	$query = "SELECT `user_id1` FROM `match` WHERE `user_id2` = ?";
	$stmt = $cn->prepare($query);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$matches2 = $result->fetch_all(MYSQLI_ASSOC);

	$match2_items = array();
	foreach($matches2 as $match2) {
		$match2_array = array_values($match2);
		$match2_implode = implode("", $match2_array);
		$match2_items[] = $match2_implode;
	}

	if(!empty($match1_items) && !empty($match2_items) && $match1_items == $match2_items): 
	?>
		<div class="alert alert-primary alert-dismissible fade show" role="alert">
			<strong>You have a match!</strong>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>
	<div class="container">
	<div class="row">
		<div class="col-md-4 py-5 mx-auto">
            <div class="card">
                <img src="<?php echo $users[$number]['profile_picture'] ?>" class="card-img-top mx-auto mt-3" id="myprofile-img">
				<div class="card-body">
					<p class="card-text text-center"><?php echo $users[$number]['firstname'] ?> <?php echo $users[$number]['lastname'] ?></p>
					<p class="card-text text-center">Birthday: <?php echo $users[$number]['birthday'] ?></p>
				</div>
				<div class="card-footer">
					<a class="btn btn-danger" href="/controllers/match/dislike.php?id=<?php echo $users[$number]['user_id']; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
					<a class="btn btn-success" href="/controllers/match/like.php?id=<?php echo $users[$number]['user_id']; ?>"><i class="fa fa-heart" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
	</div>
	<?php endif; ?>

<?php  
	}
	require_once 'views/partials/layout.php';
?>