<!doctype html>
<?php
include ('assets/inc/func.inc');
require_once ('Connections/itaps_conn.php');
mysqli_set_charset($conn, 'utf8');
$adminID = 1;

// define variables and set to empty/placeholder values
$breweryNameErr = $emailErr = $volumeTypeErr = $tapAmountErr = "Required";
$breweryName = $email = $volumeType = $tapAmount = $breweryNameErrSpan = $breweryNameErrClass = $tapAmountErrSpan = $tapAmountErrClass = $emailErrSpan = $tapAmountErrClass = $emailErrClass = $update = $method = $feedback = $feedbackType = $error = $tapCount = $tapNumber = "";

// Get current tap cout
$query_tapCount = "SELECT COUNT(`on-tap`.tap_id)
	AS tapCount
	FROM `on-tap`";
$tapCount = mysqli_query($conn, $query_tapCount) or die(mysqli_error());
$row_tapCount = mysqli_fetch_assoc($tapCount);
$tapCount = $row_tapCount['tapCount'];

// Pull admin data
mysqli_select_db($conn, $database);
$query_adminInfo = "SELECT
	admin.admin_id,
	admin.breweryName,
	admin.firstName,
	admin.lastName,
	admin.username,
	admin.`password`,
	admin.email,
	admin.tapAmount,
	admin.volumeType,
	admin.volumeTypeAbbrev
	FROM
	admin
	WHERE
	admin.admin_id = $adminID";
$adminInfo = mysqli_query($conn, $query_adminInfo) or die(mysqli_error());
$totalRows_adminInfo = mysqli_num_rows($adminInfo);

// Set simplified variables
while ($varSet = mysqli_fetch_assoc($adminInfo))
	{
	$breweryName = $varSet['breweryName'];
	$firstName = $varSet['firstName'];
	$lastName = $varSet['lastName'];
	$tapAmount = $varSet['tapAmount'];
	$volumeType = $varSet['volumeType'];
	$volumeTypeAbbrev = $varSet['volumeTypeAbbrev'];
	$username = $varSet['username'];
	$email = $varSet['email'];
	}

// If update submitted, validate data
if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if (empty($_POST["breweryName"]))
		{
		$breweryNameErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
		$breweryNameErrClass = ' has-error has-feedback';
		$breweryNameErr = 'Brewery name is required';
		}
	  else
		{
		$breweryName = test_input($_POST["breweryName"]);
			
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ']*$/", $breweryName))
			{
			$breweryNameErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
			$breweryNameErrClass = ' has-error has-feedback';
			$breweryName = '';
			$breweryNameErr = 'Only letters, white space, and apostrophes allowed';
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
			$emailErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
			$emailErrClass = ' has-error has-feedback';
			$email = '';
			$emailErr = "Invalid email format";
			}
		}
	if (empty($_POST["tapAmount"]))
		{
		$tapAmountErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
		$tapAmountErrClass = ' has-error has-feedback';
		$tapAmount = "Tap Amount is required";
		}
	  else
		{
		$tapAmount = test_input($_POST["tapAmount"]);
			
		// check if tap amount is only numbers
		if (!preg_match("/^[1-9]\d{0,3}$/", $tapAmount))
			{
			$tapAmountErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
			$tapAmountErrClass = ' has-error has-feedback';
			$tapAmount = '';
			$tapAmountErr = "Only numbers allowed";
			}
		}
	if (empty($_POST["volumeType"]))
		{
		$errSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
		$errClass = ' has-error has-feedback';
		$volumeTypeErr = "Volume type is required";
		}
	  else
		{
		$volumeType = test_input($_POST["volumeType"]);
		}
	if ((!empty($tapAmountErrSpan)) || (!empty($emailErrSpan)) || (!empty($breweryNameErrSpan)))
		{
		$feedback = 'Data not updated, please correct errors.';
		$feedbackType = 'danger';
		}
	  else
		{
		$breweryNameFix = mysqli_real_escape_string($conn, $breweryName);
		if ($volumeType == 'gallons') $volumeTypeAbbrev = 'gal.';
		if ($volumeType == 'litres') $volumeTypeAbbrev = 'l.';
		$sql = "UPDATE admin SET breweryName='$breweryNameFix',email='$email', volumeType='$volumeType', volumeTypeAbbrev='$volumeTypeAbbrev' WHERE admin_id=1";
			
		// Get number of required taps
		$tapR = $tapAmount;
		$tapD = $tapR - $tapCount;
		//		Used for diagnostics
		//		echo $tapD,'<br/>';
		//	echo ($tapD < 0 ? 'negative-true<br/>':'positive or 0<br/>');
			
		// If there is a change, determine whether to add or delete rows in taps table
		if ($tapD != 0)
			{
			// If positive number, add tap difference
			if ($tapD > 0)
				{
				$tapAmount = $tapR;
				for ($x = 1; $x <= $tapD; $x++)
					{
					// insert rows
					echo 'add ' . $tapNumber = $x + $tapCount;
					$result = mysqli_query($conn, "INSERT INTO `on-tap`(tap_id) VALUES($tapNumber)") or die(mysqli_error());
					}
				}
				
			// If negative number, delete tap difference
			if ($tapD < 0)
				{
				$tapAmount = $tapR;
				$tapD = abs($tapD);
				for ($x = 1; $x <= $tapD; $x++)
					{
					// delete rows
					$tapNumber = $x + $tapR;
					$result = mysqli_query($conn, "DELETE FROM `on-tap` WHERE tap_id=$tapNumber") or die(mysqli_error());
					}
				}
				
			// Update tap amount in admin table
			if (abs($tapD) > 0)
				{
				$sql = "UPDATE admin SET tapAmount='$tapAmount' WHERE admin_id=1";
				}
			}
		if (mysqli_query($conn, $sql))
			{
			$feedback = "Record updated successfully";
			$feedbackType = 'success';
			//		header("Refresh:3; url=admin.php", true, 303);
			}
		  else
			{
			$feedback = "Error updating record: " . mysqli_error($conn);
			$feedbackType = 'danger';
			//		header("Refresh:3; url=admin.php", true, 303);
			}
		}
	}
	
	?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/theme.css" rel="stylesheet">
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="assets/js/ie-emulation-modes-warning.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
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
		<br/>
		<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group<?php echo $breweryNameErrClass?>">
				<label class="control-label col-xs-2" for="breweryName">Brewery Name:</label>
				<div class="col-xs-5">
					<input class="form-control" type="text" id="breweryName" name="breweryName" placeholder="<?php echo $breweryNameErr ?>" value="<?php echo $breweryName;?>">
					<?php echo $breweryNameErrSpan;?>
				</div>
			</div>
			<div class="form-group<?php echo $emailErrClass?>">
				<label class="control-label col-xs-2" for="email">Email: </label>
				<div class="col-xs-5">
					<input class="form-control" type="text" name="email" placeholder="<?php echo $emailErr ?>" value="<?php echo $email;?>">
					<?php echo $emailErrSpan;?>
				</div>
			</div>
			<div class="form-group<?php echo $tapAmountErrClass?>">
				<label class="control-label col-xs-2" for="tapAmount">Tap Amount: </label>
				<div class="col-xs-5">
					<input class="form-control" type="text" name="tapAmount" placeholder="<?php echo $tapAmountErr ?>" value="<?php echo $tapAmount;?>">
					<?php echo $tapAmountErrSpan;?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2" for="volumeType">Volume Type: </label>
				<div class="col-sm-offset-2 col-sm-12">
					<div class="input-group"><span class="input-group-addon">
						<input type="radio" name="volumeType" value="gallons" id="volumeType_0" <?php if (isset($volumeType) && $volumeType=="gallons") echo "checked";?>>
						</span>
						<input type="text" class="form-control" placeholder="Gallons">
					</div>
					<div class="input-group"><span class="input-group-addon">
						<input type="radio" name="volumeType" value="litres" id="volumeType_0" <?php if (isset($volumeType) && $volumeType=="litres") echo "checked";?>>
						</span>
						<input type="text" class="form-control" placeholder="Litres
							">
					</div>
					<!-- /input-group -->
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
		echo 'Brewery Name: '.$breweryName;
		echo "<br>";
		echo 'Email: '.$email;
		echo "<br>";
		echo 'Tap Amount: '.$tapAmount;
		echo "<br>";
				echo 'Tap Count: '.$tapCount;
		echo "<br>";
		echo 'Volume Type: '.$volumeType;
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