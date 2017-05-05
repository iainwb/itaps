<?php 
	include('assets/inc/func.inc');
	require_once('Connections/itaps_conn.php');
	mysqli_set_charset($conn, 'utf8');
	
	// declare variables and set to empty/placeholder values
	
	$beerNameErr = $ogErr = $fgErr = $styleErr = $srmDecimalErr = $ibuErr = 'Required';
	$beerName = $beerNameErrSpan = $beerNameErrClass = '';
	$styleName = $styleNameErrSpan = $styleNameErrClass = '';
	$og = $ogErrSpan = $ogErrClass = '';
	$fg = $fgErrSpan = $fgErrClass = '';
	$ibu = $ibuErrSpan = $ibuErrClass = '';
	$srmValue = $srmDecimal = $srmDecimalErrSpan = $srmDecimalErrClass = '';
	$beer_id = $formAction = $action = $styleNumber = $note = $update = $method = $feedback = $feedbackType = $reload = '';
	
	if (isset($_POST['action']) && (isset($_POST['beer_id']))){
	$beer_id = $_POST['beer_id'];
	$action = $_POST['action'];
	//}else{header('Location: beers.php');}
	}
	if (isset($_POST['formAction'])){$formAction = $_POST['formAction'];}
	
	// Pull styles for drop down menu
	
	mysqli_select_db($conn, $database);
	$query_styles = "SELECT
	`2015-bjcp-styles`.styleNumber,
	`2015-bjcp-styles`.styleName
	FROM
	`2015-bjcp-styles`";
	$styles = mysqli_query($conn, $query_styles) or die(mysqli_error());
	$row_styles = mysqli_fetch_assoc($styles);
	$totalRows_styles = mysqli_num_rows($styles);
	$listStyleNumber = $row_styles['styleNumber'];
	$listStyle = $row_styles['styleName'];
	
	if (isset($_POST['action']) && $_POST['action'] != 'new'){
	$beer_id = $_POST['beer_id'];
	$actionTitle = '<h1 class="action-title">Edit Your Beer</h1>';
		
	// Pull data for filling form
	
	mysqli_select_db($conn, $database);
	$query_beerList = "SELECT
	beers.beer_id,
	beers.beerName,
	`2015-bjcp-styles`.styleName,
	`2015-bjcp-styles`.styleNumber,
	beers.og,
	beers.fg,
	beers.ibu,
	beers.srmDecimal,
	beers.srmValue_fk,
	srm.colorName,
	srm.hexColor,
	beers.note
	FROM
	srm
	JOIN beers
	ON srm.srmValue = beers.srmValue_fk 
	JOIN `2015-bjcp-styles`
	ON `2015-bjcp-styles`.styleNumber = beers.styleNumber_fk
	WHERE
	beers.beer_id ='$beer_id'";
	$beerList = mysqli_query($conn, $query_beerList) or die(mysqli_error());
	
	// Set simple variables
	
	$totalRows_beerList = mysqli_num_rows($beerList);
		while ($varSet = mysqli_fetch_assoc($beerList))
			{
			$beer_id = $varSet['beer_id'];
			$beerName = $varSet['beerName'];
			$styleName = $varSet['styleName'];
			$styleNumber = $varSet['styleNumber'];
			$og = $varSet['og'];
			$fg = $varSet['fg'];
			$ibu = $varSet['ibu'];
			$colorName = $varSet['colorName'];
			$srmDecimal = $varSet['srmDecimal'];
			$note = $varSet['note'];
			}
	}else{$actionTitle = '<h1 class="action-title">Add A New Beer</h1>';}
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">
		<title>Add/Edit Beers</title>
		<!-- Bootstrap core CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Bootstrap theme -->
		<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
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
		<?php
			// If data submitted, validate data	  
			if ((isset($_POST)) && array_key_exists('action',$_POST) && $formAction == 'update')
				
				{
			// Check if Beer Name has been entered
					if (empty($_POST["beerName"]))
					{
					$beerNameErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
					$beerNameErrClass = ' has-error has-feedback';
					$beerNameErr = 'Beer name is required';
					}
				  else
					{
					$beerName = test_input($_POST["beerName"]);
			
			// Check if Beer Name only contains valid cahracters
					if (!preg_match("/^[a-zA-Z\W\d]*$/", $beerName))
						{
						$beerNameErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
						$beerNameErrClass = ' has-error has-feedback';
						$beerName = '';
						$beerNameErr = 'Only letters, white space, and apostrophes allowed';
						}
					}
					
			// Check if OG has been entered
				if (empty($_POST["og"]))
					{
					$ogErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
					$ogErrClass = ' has-error has-feedback';
					$ogErr = "OG is required";
					}
				  else
					{
					unset($og);
					$og = test_input($_POST["og"]);
			
			// Check if OG is well-formed
					if (!preg_match("/^[1-9].[0-9]\d{2}$/", $og))
						{
						$ogErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
						$ogErrClass = ' has-error has-feedback';
						$og = '';
						$ogErr = "OG must be in #.### format";
						}
					}
					
			// Check if FG has been entered
				if (empty($_POST["fg"]))
					{
					$fgErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
					$fgErrClass = ' has-error has-feedback';
					$fgErr = "FG is required";
					}
				  else
					{
					unset($fg);
					$fg = test_input($_POST["fg"]);
			
			// Check if FG is well-formed
					if (!preg_match("/^[1-9].[0-9]\d{2}$/", $fg))
						{
						$fgErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
						$fgErrClass = ' has-error has-feedback';
						$fg = '';
						$fgErr = "FG must be in #.### format";
						}
					}
					
			// Check if IBU has been entered
						if (empty($_POST["ibu"]))
					{
					$ibuErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
					$ibuErrClass = ' has-error has-feedback';
					$ibuErr = "IBU is required";
					}
				  else
					{
					$ibu = test_input($_POST["ibu"]);
			
			// Check if IBU is well-formed
					if (!preg_match("/^[1-9]{1}[0-9]?[.]{1}[0-9]{2}$/", $ibu))
						{
						$ibuErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
						$ibuErrClass = ' has-error has-feedback';
						$ibu = '';
						$ibuErr = "IBU be entered in ##.## format";
						}
					}
				
			// Check if SRM has been entered
				if (empty($_POST["srmDecimal"]))
					{
					$srmDecimalErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
					$srmDecimalErrClass = ' has-error has-feedback';
					$srmDecimalErr = "SRM is required";
					}
				  else
					{
					$srmDecimal = test_input($_POST["srmDecimal"]);
			
			// Check if SRM is well-formed
					if (!preg_match("/^[1-9]{1}[0-9]?[.]{1}[0-9]{2}$/", $srmDecimal))
						{
						$srmDecimalErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
						$srmDecimalErrClass = ' has-error has-feedback';
						$srmDecimal = '';
						$srmDecimalErr = "SRM be entered in ##.## format";
						}
					}
					
			// Process note input
				if (empty($_POST["note"]))
					{
					$comment = "";
					}
				  else
					{
					$comment = test_input($_POST["note"]);
					}
			
			// Check for errors and set error messages
					if ((!empty($beerNameErrSpan)) || (!empty($ogErrSpan)) || (!empty($fgErrSpan)) || (!empty($ibuErrSpan)) || (!empty($srmDecimalErrSpan)))
					{
					
					$reload = 'yes';
					$_POST['beer_id'] = $beer_id;
					$feedback = 'Data not updated, please correct errors.';
					$feedbackType = 'danger';
					}
				  else
			
			 // If no errors, the set variables for data update/insert
					{
					$beerNameFix = mysqli_real_escape_string($conn, $beerName);
					$styleNumber = $_POST["listStyleNumber"];
					$note = $_POST["note"];
					$srmValue = round($srmDecimal);}
			// If an edit, update record			
					if ($action == 'edit');
						{
						$beer_id = $_POST['beer_id'];
						$sql = "UPDATE beers SET beerName='$beerNameFix', styleNumber_fk='$styleNumber', og='$og', fg='$fg', ibu='$ibu',  srmDecimal='$srmDecimal', srmValue_fk='$srmValue', note='$note' WHERE beer_id='$beer_id'";
					}
			// If new, insert a record
					if ($action == 'new')
						{
							$sql = "INSERT INTO beers (beerName, styleNumber_fk, og, fg, ibu, srmDecimal, srmValue_fk, note) VALUES ('$beerNameFix', '$styleNumber', '$og', '$fg', '$ibu', '$srmDecimal', '$srmValue', '$note')";
						   }
						
			// User feedback
					if (mysqli_query($conn, $sql))
						{
						$feedback = 'Record updated successfully';
						$feedbackType = 'success';
						header("Refresh:3; url=beers.php", true, 303);
						}
						
					  else
						{
						$feedback = 'Error updating record: ' . mysqli_error($conn);
						$feedbackType = 'danger';
						header("Refresh:5; url=beers.php", true, 303);
						}
						
				  }
				
			?>
		<?php include("assets/inc/navbar-header.inc"); ?>
		<div class="container theme-showcase" role="main">
			<div class=page-title><?php echo $actionTitle; ?>
				<?php 
					if (!empty($feedback))
					echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
					?>
			</div>
			<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group<?php echo $beerNameErrClass?>">
					<label class="control-label col-xs-2" for="beerName">Beer Name:</label>
					<div class="col-xs-5">
						<input class="form-control" type="text" id="beerName" name="beerName" placeholder="<?php echo $beerNameErr ?>" value="<?php echo $beerName;?>">
						<?php echo $beerNameErrSpan;?>
					</div>
				</div>
				<div class="form-group<?php echo $styleNameErrClass?>">
					<label class="control-label col-xs-2" for="style">Style: </label>
					<div class="col-xs-5">
						<select class="form-control" name="listStyleNumber" id="listStyleNumber">
							<?php do { 
								$listStyle = $row_styles['styleName'];
								$listStyleNumber = $row_styles['styleNumber'];
								?>
							<option value="<?php echo $listStyleNumber ?>"<?php if($styleNumber == $listStyleNumber) echo 'selected' ?>><?php echo $listStyle.'&#8212;'.$listStyleNumber; ?></option>
							<?php } while ($row_styles = mysqli_fetch_assoc($styles)); ?>	
						</select>
						<?php echo $styleNameErrSpan;?>
					</div>
				</div>
				<div class="form-group<?php echo $ogErrClass?>">
					<label class="control-label col-xs-2" for="og">OG: </label>
					<div class="col-xs-5">
						<input class="form-control" type="text" id="og" name="og" placeholder="<?php echo $ogErr ?>" value="<?php echo $og;?>">
						<?php echo $ogErrSpan;?>
					</div>
				</div>
				<div class="form-group<?php echo $fgErrClass?>">
					<label class="control-label col-xs-2" for="fg">FG:</label>
					<div class="col-xs-5">
						<input class="form-control" type="text" id="fg" name="fg" placeholder="<?php echo $fgErr ?>" value="<?php echo $fg;?>">
						<?php echo $fgErrSpan;?>
					</div>
				</div>
				<div class="form-group<?php echo $ibuErrClass?>">
					<label class="control-label col-xs-2" for="ibu">IBU:</label>
					<div class="col-xs-5">
						<input class="form-control" type="text" id="ibu" name="ibu" placeholder="<?php echo $ibuErr ?>" value="<?php echo $ibu;?>">
						<?php echo $ibuErrSpan;?>
					</div>
				</div>
				<div class="form-group<?php echo $srmDecimalErrClass?>">
					<label class="control-label col-xs-2" for="srmDecimal">SRM:</label>
					<div class="col-xs-5">
						<input class="form-control" type="text" id="srmDecimal" name="srmDecimal" placeholder="<?php echo $srmDecimalErr ?>" value="<?php echo $srmDecimal;?>">
						<?php echo $srmDecimalErrSpan;?>
					</div>
				</div>
				<div class="form-group ">
					<label class="control-label col-xs-2" for="note">Note:</label>
					<div class="col-xs-5">
						<textarea class="form-control " rows="5" id="note" name="note" placeholder="Tell us about your beer" ><?php echo $note; ?></textarea>
					</div>
				</div>
				<input type="hidden" name="formAction" value="update">
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="beer_id" value="<?php echo $beer_id;?>">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-10">
						<button type="submit" class="btn btn-primary">
						<?php if($action == 'new')
							echo 'Add Beer'; 
							elseif
								
								($action == 'update' || 'edit') echo 'Update';
								else echo 'No Actions';			
											
											?></button>
					</div>
				</div>
			</form>
		</div>
		<!-- /container -->
		<!-- For diagnostics, add php tags to activate
			echo "<h2>Your Input:</h2>";
			echo 'Action: '.$action;
			echo "<br>";	  
			echo 'Form Action: '.$formAction;	  
			echo "<br>";
				echo 'beer_id: '.$beer_id;
			echo "<br>";
			echo 'Beer Name: '.$beerName;
			echo "<br>";
			echo 'OG: '.$og;
			echo "<br>";
			echo 'FG: '.$fg;
			echo "<br>";
				echo 'IBU: '.$ibu;
			echo "<br>";
			
			echo 'SRM Decimal: '.$srmDecimal;
			echo "<br>";
			echo 'Style: '.$styleName;
			echo "<br>";
			echo 'Style #: '.$styleNumber;
			echo "<br>";
			echo $update;
			echo "<br>";
			echo 'error? '. $reload;
			echo "<br>";
			echo 'success? '. $success;
			-->
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/docs.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>