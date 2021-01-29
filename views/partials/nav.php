<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
	<a class="navbar-brand" href="/">
		<img src="../../assets/img/72a31c34-c391-48fc-bbeb-5131f4e48747_200x200.png" id="logo">
	</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
		<ul class="navbar-nav">
			<?php if(isset($_SESSION["user_details"])): ?>
			<div class="dropstart">
				<img src="<?php echo $_SESSION["user_details"]["profile_picture"]; ?>" id="profile-pic-small" class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<li><a class="dropdown-item" href="/views/myprofile.php">My Profile</a></li>
				<li><a class="dropdown-item" href="/controllers/auth/logout.php">Logout</a></li>
			</ul>
			</div>
			<?php else: ?>
			<li class="nav-item">
				<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#loginModal">LOG IN</button>

				<div class="modal fade" id="loginModal">
					<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
						<div class="modal-content">
							<div class="modal-body">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								<h3 class="text-center pt-4">Login</h3>
								<form class="mx-auto p-5" method="POST" action="/controllers/auth/login.php">
									<div class="mb-3">
										<label>Email</label>
										<input type="text" name="email" class="form-control">
									</div>
									<div class="mb-3">
										<label>Password</label>
										<input type="password" name="password" class="form-control">
									</div>
									<button class="btn btn-primary">Login</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</li>
			<?php endif; ?>
		</ul>
	</div>
	</div>
</nav>