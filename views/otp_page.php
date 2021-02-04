<?php  
	$csslink = "../assets/css/style.css";
	$title = "OTP Page";
	function get_content() {
    require_once '../controllers/connection.php';

?>
    <div class="container">
	<div class="row">
		<div class="col-md-4 py-5 mx-auto">
            <div class="card">
				<div class="card-body">
                <h3 class="text-center pt-4">Enter OTP</h3>
                    <form class="mx-auto p-5" method="POST" action="/controllers/auth/otp.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>OTP Verification</label>
                            <input type="number" name="otp" class="form-control">
                        </div>
                        <button class="btn btn-primary">Register</button>
                    </form>
				</div>
            </div>
        </div>
    </div>
    </div>
<?php  
	}
	require_once 'partials/layout.php';
?>