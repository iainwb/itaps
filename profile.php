<!doctype html>
<?php
include ('assets/inc/func.inc');
require_once ('connections/itaps_conn.php');

// define variables and set to empty/placeholder values
$brewery_name_err = $email_err = $volume_type_err = $tap_amount_err = "Required";
$brewery_name = $email = $volume_type = $tap_amount = $brewery_name_err_span = $brewery_name_err_class = $tap_amount_err_span = $tap_amount_err_class = $email_err_span = $tap_amount_err_class = $email_err_class = $update = $method = $feedback = $feedback_type = $error = $tap_count = $tap_number = "";

// Pull admin data
$query_config_info = "SELECT
config.config_id,
config.config_name,
config.config_value,
config.display_name,
config.show_on_panel
FROM
config";
$config_info = $conn->query($query_config_info);;
$row_config = $config_info->fetch(PDO::FETCH_ASSOC);

// Set simplified variables

// If update submitted, validate data
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if (empty($_POST["brewery_name"]))
		{
		$brewery_name_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
		$brewery_name_err_class = ' has-error has-feedback';
		$brewery_name_err = 'Brewery name is required';
		}
	  else
		{
		$brewery_name = test_input($_POST["brewery_name"]);
			
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ']*$/", $brewery_name))
			{
			$brewery_name_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
			$brewery_name_err_class = ' has-error has-feedback';
			$brewery_name = '';
			$brewery_name_err = 'Only letters, white space, and apostrophes allowed';
			}
		}
	if (empty($_POST["email"]))
		{
		$emailErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
		$emailErrClass = ' has-error has-feedback';
		$emailErr = "Email is required";
		}
	  else
		{
		$email = test_input($_POST["email"]);
			
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
			$email_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
			$email_err_class = ' has-error has-feedback';
			$email = '';
			$email_err = "Invalid email format";
			}
		}

	if ((!empty($emailErrSpan)) || (!empty($brewery_name_err_span)))
		{
		$feedback = 'Data not updated, please correct errors.';
		$feedbackType = 'danger';
		}
	  else
		{
		$brewery_nameFix = mysqli_real_escape_string($conn, $brewery_name);
		if ($volume_type == 'gallons') $volume_type_abbrev = 'gal.';
		if ($volume_type == 'litres') $volume_type_abbrev = 'l.';
		$sql = "UPDATE admin SET brewery_name='$brewery_nameFix',email='$email', volume_type='$volume_type', volume_type_abbrev='$volume_type_abbrev' WHERE admin_id=1";
	}
	}
	?>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Keg List</title>
   <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,700,700i" rel="stylesheet">
   <!-- Bootstrap core CSS -->
   <link href="assets/css/bootstrap.min.css" rel="stylesheet">
   <!-- Custom styles for this template -->
   <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
	<?php include("assets/inc/navbar-header.inc"); ?>
	<div class="container theme-showcase" role="main">
		<div class="page-title">
			<h1>Admin Profile</h1>
			<?php 
				if (!empty($feedback))
				echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
				?>
		</div>
		

		<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group<?php echo $brewery_name_err_class?>">
				<label class="control-label col-xs-2" for="brewery_name">Brewery Name:</label>
				<div class="col-xs-5">
					<input class="form-control" type="text" id="brewery_name" name="brewery_name" placeholder="<?php echo $brewery_name_err ?>" value="<?php echo $brewery_name;?>">
					<?php echo $brewery_name_err_span;?>
				</div>
			</div>
			<div class="form-group<?php echo $email_err_class?>">
				<label class="control-label col-xs-2" for="email">Email: </label>
				<div class="col-xs-5">
					<input class="form-control" type="text" name="email" placeholder="<?php echo $email_err ?>" value="<?php echo $email;?>">
					<?php echo $email_err_span;?>
				</div>
			</div>

			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</div>
		</form>
	</div>
	<!-- Used for diganostics, add php tag to activate
		echo "<h2>Your Input:</h2>";
		echo 'Brewery Name: '.$brewery_name;
		echo "<br>";
		echo 'Email: '.$email;
		echo "<br>";
		echo 'Tap Amount: '.$tap_amount;
		echo "<br>";
				echo 'Tap Count: '.$tap_count;
		echo "<br>";
		echo 'Volume Type: '.$volume_type;
		echo "<br>";
				echo 'Request method: '.$method;
		echo "<br>";
		echo $update;
				echo "<br>";
		echo 'error? '. $error;
				echo "<br>";
		echo 'success? '. $feedback;
		
		-->
</body>
	<!-- Bootstrap core JavaScript
		================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		window.jQuery || document.write( '<script src="assets/js/vendor/jquery.min.js"><\/script>' )
	</script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/docs.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</html>