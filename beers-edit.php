<!DOCTYPE html>
<?php 
	include('assets/inc/func.inc');
	require_once('Connections/itaps_conn.php');
		
	// declare variables and set to empty/placeholder values
	
	$beer_name_err = $og_err = $fg_err = $style_err = $srm_decimal_err = $ibu_err = '';
	$beer_name = $beer_name_err_input = $beer_name_err_state = '';
	$style_name = $style_name_err_input = $style_name_err_state = '';
	$og = $og_err_input = $og_err_state = '';
	$fg = $fg_err_input = $fg_err_state = '';
	$ibu = $ibu_err_input = $ibu_err_state = '';
	$srm_value = $srm_decimal = $srm_decimal_err_input = $srm_decimal_err_state = '';
	$beer_id = $form_action = $action = $action_title = $style_number = $note = $update = $method = $feedback = $feedback_type = $reload = '';
	
// Have an action and beer id been posted: yes-carry on, no return to beer list with an error

if (isset($_POST['action']) && (isset($_POST['beer_id'])))
	{
	$beer_id = $_POST['beer_id'];
	$action = $_POST['action'];
//	echo 'POST action= ' . $_POST['action'].'<br/>';
//	echo 'POST beer_id= ' . $_POST['beer_id'].'<br/>';
	}
//else
//	{

	//	header('Location: beers.php');

//	echo 'I have nothing to do, return me to the beers list';
//	exit;
//	}

// if action is delete, then delete or carry on

if ($action == 'delete')
	{
		
		$action = $_POST['action'];
		$beer_id = $_POST['beer_id'];
			
			// set the PDO error mode to exception
			   try { $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    
			    $sql = "DELETE FROM beers
						WHERE beer_id='$beer_id'";
						
						   					 // use exec() because no results are returned
						    $conn->exec($sql);
						    $feedback = 'Record updated successfully';
						    $feedback_type = 'success';
						    header("Refresh:4; url=beers.php?feedback=<?php  ?>", true, 303);
						    }
						catch(PDOException $e)
						    {
						    $feedback = 'Error updating record: ';
						    $feedback_type = 'danger';
						    echo $sql . "<br>" . $e->getMessage();
						    header("Refresh:4; url=beers.php", true, 303);
						    }
			}

// if form action is set, set variable

if (isset($_POST['form_action']))
	{
	$form_action = $_POST['form_action'];
		
//	echo 'POST form action= ' . $_POST['form_action'].'<br/>';
	}

	// If data submitted, validate data

	if ((isset($_POST)) && array_key_exists('action', $_POST) && $form_action == 'update')
	 	{
	
//	echo 'I haz data to do something with new data<br/>';
	

		// Check if Beer Nameerr_state been entered

		if (empty($_POST['beer_name']))
			{
			$beer_name_err_input = 'inputHorizontalDanger';
			$beer_name_err_state = 'danger';
			$beer_name_err = 'Beer name is required';
			}
		  else

		// Check if Beer Name only contains valid cahracters

			{
			$beer_name = test_input($_POST['beer_name']);
			if (!preg_match("/^[a-zA-Z\W\d]*$/", $beer_name))
				{
				$beer_name_err_input = 'inputHorizontalWarning';
				$beer_name_err_state = 'warning';
				$beer_name = '';
				$beer_name_err = 'Only letters, white space, and apostrophes allowed';
				}
			}

		// Check if OGerr_state been entered

		if (empty($_POST['og']))
			{
			$og_err_input = 'inputHorizontalDanger';
			$og_err_state = 'danger';
			$og_err = "OG is required";
			}
		  else
			{
			unset($og);
			$og = test_input($_POST['og']);

			// Check if OG is well-formed

			if (!preg_match("/^[1-9].[0-9]\d{2}$/", $og))
				{
				$og_err_input = 'inputHorizontalWarning';
				$og_err_state = 'warning';
				$og = '';
				$og_err = "OG must be in #.### format";
				}
			}

		// Check if FGerr_state been entered

		if (empty($_POST['fg']))
			{
			$fg_err_input = 'inputHorizontalDanger';
			$fg_err_state = 'danger';
			$fg_err = "FG is required";
			}
		  else
			{
			unset($fg);
			$fg = test_input($_POST['fg']);

			// Check if FG is well-formed

			if (!preg_match("/^[1-9].[0-9]\d{2}$/", $fg))
				{
				$fg_err_input = 'inputHorizontalWarning';
				$fg_err_state = 'warning';
				$fg = '';
				$fg_err = "FG must be in #.### format";
				}
			}

		// Check if IBUerr_state been entered

		if (empty($_POST['ibu']))
			{
			$ibu_err_input = 'inputHorizontalDanger';
			$ibu_err_state = 'danger';
			$ibu_err = "IBU is required";
			}
		  else
			{
			$ibu = test_input($_POST['ibu']);

			// Check if IBU is well-formed

			if (!preg_match("/^[1-9]{1}[0-9]?[.]{1}[0-9]{2}$/", $ibu))
				{
				$ibu_err_input = 'inputHorizontalWarning';
				$ibu_err_state = 'warning';
				$ibu = '';
				$ibu_err = "IBU be entered in ##.## format";
				}
			}

		// Check if SRMerr_state been entered

		if (empty($_POST['srm_decimal']))
			{
			$srm_decimal_err_input = 'inputHorizontalDanger';
			$srm_decimal_err_state = 'danger';
			$srm_decimal_err = "SRM is required";
			}
		  else
			{
			$srm_decimal = test_input($_POST['srm_decimal']);

			// Check if SRM is well-formed

			if (!preg_match("/^[1-9]{1}[0-9]?[.]{1}[0-9]{2}$/", $srm_decimal))
				{
				$srm_decimal_err_input = 'inputHorizontalWarning';
				$srm_decimal_err_state = 'warning';
				$srm_decimal = '';
				$srm_decimal_err = "SRM be entered in ##.## format";
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

		if ((!empty($beer_name_err_input)) || (!empty($og_err_input)) || (!empty($fg_err_input)) || (!empty($ibu_err_input)) || (!empty($srm_decimal_err_input)))
			{
			$_POST['beer_id'] = $beer_id;
			$feedback = 'Data not updated, please correct errors.';
			$feedback_type = 'danger';
			}
		  else

		// If no errors, the set variables for data update/insert

			{
			$beer_id = $_POST['beer_id'];
			$beer_name = $_POST['beer_name'];
			$style_number = $_POST['list_style_number'];
			$srm_decimal = $_POST['srm_decimal'];
			$srm_value = round($srm_decimal);
			$note = $_POST['note'];
			

		// If an edit, update record

		if ($action == 'edit'){
			
			try
				{

				// set the PDO error mode to exception

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE beers
								SET beer_name='$beer_name',
								style_number_fk='$style_number',
								og='$og',
								fg='$fg',
								ibu='$ibu', 
								srm_decimal='$srm_decimal',
								srm_value_fk='$srm_value',
								note='$note'
								WHERE beer_id='$beer_id'";

				// Prepare statement

				$stmt = $conn->prepare($sql);

				// execute the query

				$stmt->execute();

				// echo a message to say the UPDATE succeeded

				$feedback = $stmt->rowCount() . " records UPDATED successfully";
				$feedback_type = 'success';

				// header("Refresh:3; url=beers.php", true, 303);

				}

			catch(PDOException $e)
				{
				$feedback = $sql . "<br />" . $e->getMessage();
				$feedback_type = 'danger';

				// header("Refresh:5; url=beers.php", true, 303);

				}
		}

		// If new, insert a record

		if ($action == 'new')
			{
			
			try
				{

				// set the PDO error mode to exception

				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO beers (beer_name, style_number_fk, og, fg, ibu, srm_decimal, srm_value_fk, note) VALUES ('$beer_name', '$style_number', '$og', '$fg', '$ibu', '$srm_decimal', '$srm_value', '$note')";

				// use exec() because no results are returned

				$conn->exec($sql);
				$feedback = 'Record created successfully';
				$feedback_type = 'success';

				// header("Refresh:3; url=beers.php", true, 303);

				}

			catch(PDOException $e)
				{
				$feedback = $sql . "<br />" . $e->getMessage();
				$feedback_type = 'danger';

				// header("Refresh:5; url=beers.php", true, 303);

				}
			}
	
			}
			
			}
		   // Pull styles for drop down menu
	   
	   $query_styles = "SELECT
	   bjcp_styles.style_name,
	   bjcp_styles.style_number
	   FROM
	   bjcp_styles
	   ORDER BY
	   bjcp_styles.style_name ASC";
	   $styles = $conn->query($query_styles);
	   $row_styles = $styles->fetch(PDO::FETCH_ASSOC);
	   $list_style_id = $row_styles['style_number'];
	   $list_style_name = $row_styles['style_name'];
	   
	   if (isset($_POST['action']) && $_POST['action'] != 'new'){
	   $beer_id = $_POST['beer_id'];
	   $action_title = '<h1 class="action-title">Edit Your Beer</h1>';
	  
	   // Pull data for filling form
	   
	   $query_beerlist = "SELECT
	   beers.beer_id,
	   beers.beer_name,
	   bjcp_styles.style_name,
	   bjcp_styles.style_number,
	   beers.og,
	   beers.fg,
	   beers.ibu,
	   beers.srm_decimal,
	   beers.srm_value_fk,
	   srm.color_name,
	   srm.hex_color,
	   beers.note
	   FROM
	   srm
	   JOIN beers
	   ON srm.srm_value = beers.srm_value_fk 
	   JOIN bjcp_styles
	   ON bjcp_styles.style_number = beers.style_number_fk
	   WHERE
	   beers.beer_id = '$beer_id'";
	   $beerlist = $conn->query($query_beerlist);
	   
	   // Set simple variables
	      	
	   	while ($var_set = $beerlist->fetch(PDO::FETCH_ASSOC))
	   		{
	   		$beer_id = $var_set['beer_id'];
	   		$beer_name = $var_set['beer_name'];
	   		$style_name = $var_set['style_name'];
	   		$style_number = $var_set['style_number'];
	   		$og = $var_set['og'];
	   		$fg = $var_set['fg'];
	   		$ibu = $var_set['ibu'];
			$srm_decimal = $var_set['srm_decimal'];
	   		$srm_value_fk = $var_set['srm_value_fk'];
	   		$color_name = $var_set['color_name'];
	   		$hex_color = $var_set['hex_color'];
	   		$note = $var_set['note'];
	   		}		   
		
	
	}else{$actionTitle = '<h1 class="action-title">Add A New Beer</h1>';}
	
	?>

<html lang="en">
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
		<div class="container">
			<div class="page-title"><?php echo $action_title; ?>
				<?php 
					if (!empty($feedback))
					echo'<div class="alert alert-'.$feedback_type.' " role="alert">'.$feedback.'</div>';
					?>
			</div>
			<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				
				    
				<div class="form-group row has-<?php echo $beer_name_err_state?>">
					<label for="<?php echo $beer_name_err_input ?>" class="col-md-3 col-form-label" for="beer_name">Beer Name: </label>
					<div class="col-md-8">
						<input id="<?php echo $beer_name_err_input ?>" class="form-control form-control-<?php echo $beer_name_err_state?>" type="text" name="beer_name" placeholder="<?php
						 echo $beer_name_err ?>" value="<?php
						 if ((empty($beer_name_err)))
						  echo $beer_name;?>">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-3 col-form-label" for="style">Style: </label>
					<div class="col-md-8">
						<select class="form-control custom-select" name="list_style_number" id="list_style_number">
							<?php do { 
								$list_style = $row_styles['style_name'];
								$list_style_number = $row_styles['style_number'];
								?>
							<option value="<?php echo $list_style_number ?>"<?php if($style_number == $list_style_number) echo 'selected' ?>><?php echo $list_style.'&#8212;'.$list_style_number; ?></option>
							<?php } while ($row_styles = $styles->fetch(PDO::FETCH_ASSOC)); ?>	
						</select>
					</div>
				</div>
				
			
				    
				    
				    
				<div class="form-group row has-<?php echo $og_err_state?>">
					<label for="<?php echo $og_err_input ?>" class="col-md-3 col-form-label" for="og">OG: </label>
					<div class="col-md-8">
						<input id="<?php echo $og_err_input ?>" class="form-control form-control-<?php echo $og_err_state?>" type="text" name="og" placeholder="<?php
						 echo $og_err ?>" value="<?php
						 if ((empty($og_err)))
						  echo $og;?>">
					</div>
				</div>
				
								    
				<div class="form-group row has-<?php echo $fg_err_state?>">
					<label for="<?php echo $fg_err_input ?>" class="col-md-3 col-form-label" for="fg">FG: </label>
					<div class="col-md-8">
						<input id="<?php echo $fg_err_input ?>" class="form-control form-control-<?php echo $fg_err_state?>" type="text" name="fg" placeholder="<?php
						 echo $fg_err ?>" value="<?php
						 if ((empty($fg_err)))
						  echo $fg;?>">
					</div>
				</div>
				
								    
				<div class="form-group row has-<?php echo $ibu_err_state?>">
					<label for="<?php echo $ibu_err_input ?>" class="col-md-3 col-form-label" for="ibu">IBU: </label>
					<div class="col-md-8">
						<input id="<?php echo $ibu_err_input ?>" class="form-control form-control-<?php echo $ibu_err_state?>" type="text" name="ibu" placeholder="<?php
						 echo $ibu_err ?>" value="<?php
						 if ((empty($ibu_err)))
						  echo $ibu;?>">
					</div>
				</div>
				
								    
				<div class="form-group row has-<?php echo $srm_decimal_err_state?>">
					<label for="<?php echo $srm_decimal_err_input ?>" class="col-md-3 col-form-label" for="srm_decimal">SRM: </label>
					<div class="col-md-8">
						<input id="<?php echo $srm_decimal_err_input ?>" class="form-control form-control-<?php echo $srm_decimal_err_state?>" type="text" name="srm_decimal" placeholder="<?php
						 echo $srm_decimal_err ?>" value="<?php
						 if ((empty($srm_decimal_err)))
						  echo $srm_decimal;?>">
					</div>
				</div>
				
				
				
				<div class="form-group row">
					<label class="col-md-3 col-form-label" for="note">Note:</label>
					<div class="col-md-8">
						<textarea class="form-control " rows="5" id="note" name="note" placeholder="Tell us about your beer" ><?php echo $note; ?></textarea>
					</div>
				</div>
				<input type="hidden" name="form_action" value="update">
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="beer_id" value="<?php echo $beer_id;?>">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-10">
						<button type="submit" class="btn btn-primary form">
						<?php if($action == 'new')
							echo 'Add Keg';
							if ($action == 'edit') echo 'Update'; ?></button>
						<a class="btn btn-primary form" href="beers.php">Cancel</a>
					</div>
				</div>
			</form>
		</div>
		<!-- /container -->
		<!-- For diagnostics, add php tags to activate
			echo "<h2>Your Input:</h2>";
			echo 'Action: '.$action;
			echo "<br>";	  
			echo 'Form Action: '.$form_action;	  
			echo "<br>";
				echo 'beer_id: '.$beer_id;
			echo "<br>";
			echo 'Beer Name: '.$beer_name;
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
			echo 'Style #: '.$style_number;
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