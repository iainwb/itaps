<!doctype html>
<?php
include ('assets/inc/func.inc');
require_once ('connections/itaps_conn.php');

// define variables and set to empty/placeholder values

$header_text = $number_of_taps = 'Required';
$header_text_err_input = $header_text_err_state = $header_text_err = '';
$number_of_taps_err_input = $number_of_taps_err_state =  $number_of_taps_err = '';

// Get current tap count

$query_tap_count = "SELECT COUNT(tap_status.tap_id)
	AS tap_count
	FROM tap_status";
$tap_count = $conn->query($query_tap_count);
$row_tap_count = $tap_count->fetch(PDO::FETCH_ASSOC);
$tap_count = $row_tap_count['tap_count'];
//echo 'Tap count: ' . $tap_count . '<br/>';

// Pull settings data

$query_config_info = "SELECT
 config.config_id,
 config.config_name,
 config.config_value,
 config.display_name,
 config.show_on_panel
 FROM
 config
 ORDER BY
 config.config_id ASC";
$config_info = $conn->query($query_config_info);
$result = $config_info->fetchAll(PDO::FETCH_ASSOC);


$header_text =  $result[9]['config_value'];
$number_of_taps = $result[10]['config_value'];
$current_theme = $result[14]['config_value'];
//echo 'number_of_taps-config---'.$number_of_taps.'<br/>';
//echo 'current_theme---'.$current_theme.'<br/>';

// If update submitted, validate data

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
	
	$number_of_taps = $_POST['number_of_taps'];
	$header_text = $_POST['header_text'];
	$current_theme = $_POST['current_theme'];
	
	// if post with name is posted, set value to 1, else to 0
	    $show_tap_num_col = isset($_POST['show_tap_num_col']) ? 1 : 0;
	    	$sqltap = "UPDATE config SET config_value = '$show_tap_num_col' WHERE config_id = '1'";
	    		$stmttap = $conn->prepare($sqltap);
	    			$stmttap->execute();
	    
	    $show_srm_col = isset($_POST['show_srm_col']) ? 1 : 0;
		    $sql_srm_col = "UPDATE config SET config_value = '$show_srm_col' WHERE config_id = '2'";
		    	$stmt_srm_col = $conn->prepare($sql_srm_col);
		    		$stmt_srm_col->execute();
		    		
		$show_ibu_col = isset($_POST['show_ibu_col']) ? 1 : 0;
			$sql_ibu_col = "UPDATE config SET config_value = '$show_ibu_col' WHERE config_id = '3'";
				$stmt_ibu_col = $conn->prepare($sql_ibu_col);
					$stmt_ibu_col->execute();
					
		$show_abv_col = isset($_POST['show_abv_col']) ? 1 : 0;
			$sql_abv_col = "UPDATE config SET config_value = '$show_srm_col' WHERE config_id = '4'";
				$stmt_abv_col = $conn->prepare($sql_abv_col);
					$stmt_abv_col->execute();
					
		$show_abv_img = isset($_POST['show_abv_img']) ? 1 : 0;
			$sql_abv_img = "UPDATE config SET config_value = '$show_abv_col' WHERE config_id = '5'";
				$stmt_abv_img = $conn->prepare($sql_abv_img);
					$stmt_abv_img->execute();
					
		 if (isset($_POST['current_theme']) ){
			$sql_current_theme = "UPDATE config SET config_value = '$current_theme' WHERE config_id = '15'";
				$stmt_current_theme = $conn->prepare($sql_current_theme);
					$stmt_current_theme->execute();		}	
					
	
	if (empty($_POST['header_text']))
		{
		$header_text_err_input = 'inputHorizontalDanger';
		$header_text_err_state = 'danger';
		$header_text_err = 'Header text is required';
		}
	  else
		{
		$header_text = test_input($_POST['header_text']);
			
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ']*$/", $header_text))
			{
			$header_text_err_input = 'inputHorizontalWarning';
			$header_text_err_state = 'warning';
			$header_text_err = 'Only letters, white space, and apostrophes allowed';
			$header_text = '';
			
			}
		}
	
			if (empty($_POST['number_of_taps']))
		{
		$number_of_taps_err_input = 'inputHorizontalDanger';
		$number_of_taps_err_state = 'danger';
		$number_of_taps_err = 'Tap Amount is required';
		}
	  else
		{
		$number_of_taps = test_input($_POST['number_of_taps']);

		// check if tap amount is only numbers

		if (!preg_match("/^[1-9]\d{0,3}$/", $number_of_taps))
			{
			$number_of_taps_err_input = 'inputHorizontalWarning';
			$number_of_taps_err_state = 'warning';
			$number_of_taps_err = 'Only numbers allowed';
			$number_of_taps = '';
			}
		}

	if ((!empty($number_of_taps_err_input)) || (!empty($header_text_err_input)))
		{
		$feedback = 'Data not updated, please correct errors.';
		$feedback_type = 'danger';
		}
	  else
		{
		
		try
			{

			// set the PDO error mode to exception

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		
		$sql = "UPDATE config SET config_value = '$header_text' WHERE config_id = '10'";
		
		// Prepare statement
		
						$stmt = $conn->prepare($sql);
		
						// execute the query
		
						$stmt->execute();
		
						// echo a message to say the UPDATE succeeded
		
						$feedback = 'UPDATED successfully';
						$feedback_type = 'success';
		
						 header("Refresh:2; url=settings.php", true, 303);
		
						}
		
					catch(PDOException $e)
						{
						$feedback = $sql . "<br />" . $e->getMessage();
						$feedback_type = 'danger';
		
						 header("Refresh:5; url=settings.php", true, 303);
		
						}

		// Get number of required taps

		$taps_required = $number_of_taps;
		$taps_difference = $taps_required - $tap_count;

		//		Used for diagnostics

	//	echo 'Taps Difference: ' . $taps_difference, '<br/>';
	//	echo ($taps_difference < 0 ? 'negative-true<br/>' : 'positive or 0<br/>');

		// If there is a change, add or delete rows in taps table

		if ($taps_difference != 0)
			{

			// If positive number, add tap difference

			if ($taps_difference > 0)
				{
		//		echo 'Adding taps<br>';
				$number_of_taps = $taps_required;
				for ($x = 1; $x <= $taps_difference; $x++)
					{
					try
						{

						// set the PDO error mode to exception

						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						echo 'add ' . $number_of_taps = $x + $tap_count;
						$sql = "INSERT INTO tap_status(tap_id) VALUES ($number_of_taps)";

						// use exec() because no results are returned

						$conn->exec($sql);
						$feedback = 'Record created successfully';
						$feedback_type = 'success';

						 header("Refresh:3; url=settings.php", true, 303);

						}

					catch(PDOException $e)
						{
						$feedback = $sql . "<br />" . $e->getMessage();
						$feedback_type = 'danger';

						 header("Refresh:5; url=settings.php", true, 303);

						}
					}
				}

			// If negative number, delete tap difference

			if ($taps_difference < 0)
				{
//				echo 'Deleting taps<br>';
				$number_of_taps = $taps_required;
				$taps_difference = abs($taps_difference);
				for ($x = 1; $x <= $taps_difference; $x++)
					{

					// set the PDO error mode to exception
echo 'delete tap#---'.$x;
					try
						{
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$number_of_taps = $x + $taps_required;
	//					echo 'delete ' . $number_of_taps.' ';
						$sql = "DELETE FROM tap_status WHERE tap_id=$number_of_taps";

						// use exec() because no results are returned

						$conn->exec($sql);
						$feedback = 'Record updated successfully';
						$feedback_type = 'success';

		//				   header("Refresh:2; url=settings.php", true, 303);

						}

					catch(PDOException $e)
						{
						$feedback = 'Error updating record: ';
						$feedback_type = 'danger';
						echo $sql . "<br />" . $e->getMessage();

						  header("Refresh:4; url=settings.php", true, 303);

						}
					}
				}

			// Update tap amount in admin table

			if (abs($taps_difference) > 0)
				{
				try
					{
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE config SET config_value='$taps_required' WHERE config_id=11";

					// Prepare statement

					$stmt = $conn->prepare($sql);

					// execute the query

					$stmt->execute();

					// echo a message to say the UPDATE succeeded

					$feedback = 'UPDATED successfully';
					$feedback_type = 'success';

					 header("Refresh:3; url=settings.php", true, 303);

					}

				catch(PDOException $e)
					{
					$feedback = $sql . "<br />" . $e->getMessage();
					$feedback_type = 'danger';

					 header("Refresh:5; url=settings.php", true, 303);

					}
				}
			}
		}
	}
	
	//define page title
	$title = 'Settings';
	
	//include html header template
	require('assets/inc/html-header.php');
	?>
<body>
	<?php include("assets/inc/navbar-header.inc"); ?>
	<div class="container">
	
		<div class="page-title">
			<h1>Settings</h1>
			<?php 
				if (!empty($feedback))
				echo'<div class="alert alert-'.$feedback_type.' " role="alert">'.$feedback.'</div>';
				?>
		</div>
		<div class="row">
		<h2>Select to Show/Deselect to Hide</h2>
		</div>
		<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<div class="form-group row">
		
			<div class="form-check col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_tap_num_col" type="checkbox" value="1" <?php if ($result[0]['config_value'] == 1) echo 'checked'; ?>>
			    Tap Column
			  </label>
			</div>
			
			<div class="form-check col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_srm_col" type="checkbox" value="1" <?php if ($result[1]['config_value'] == 1) echo 'checked'; ?>>
			    SRM Column</label>
			</div>
			
			<div class="form-check col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_ibu_col" type="checkbox" value="1" <?php if ($result[2]['config_value'] == 1) echo 'checked'; ?>>
			    IBU Column
			  </label>
			</div>
			
			<div class="form-check col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_abv_col" type="checkbox" value="1" <?php if ($result[3]['config_value'] == 1) echo 'checked'; ?>>
			    ABV Column
			  </label>
			</div>
		</div>
		
		
		<div class="form-group row">
		
			<div class="form-check col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_abv_img" type="checkbox" value="1" <?php if ($result[4]['config_value'] == 1) echo 'checked'; ?>>
			    ABV Images
			  </label>
			</div>
			
			<div class="form-check disabled col-3">
			  <label class="form-check-label">
			    <input class="form-check-input" name="show_keg_col" type="checkbox" value="1" <?php if ($result[5]['config_value'] == 1) echo 'checked'; ?> disabled>
			    Keg Column
			  </label>
			</div>
			
			<div class="form-check disabled col-3">
			  <label for="disabledTextInput" class="form-check-label">
			    <input class="form-check-input" name="use_high_res" id="disabledTextInput" type="checkbox" value="1" <?php if ($result[6]['config_value'] == 1) echo 'checked' ?> disabled>
			    4k Monitor Support
			  </label>
			</div>
			
			<div class="form-check disabled col-3">
			  <label for="disabledTextInput"  class="form-check-label">
			    <input class="form-check-input" name="use_flow_meter" id="disabledTextInput" type="checkbox" value="1" <?php if ($result[13]['config_value'] == 1) echo 'checked' ?>disabled>
			    Use Flow Monitoring
			  </label>
			</div>
		
		</div>
					
		<div class="form-group row has-<?php echo $header_text_err_state?>">
			<label for="<?php echo $header_text_err_input ?>" class="col-2 col-form-label" for="header_text">Header Text: </label>
			<div class="col-10">
				<input id="<?php echo $header_text_err_input ?>" class="form-control form-control-<?php echo $header_text_err_state?>" type="text" name="header_text" placeholder="<?php
				 echo $header_text_err ?>" value="<?php echo $header_text?>">
			</div>
		</div>
		
		
		<div class="form-group row has-<?php echo $number_of_taps_err_state?>">
		
		<label for="<?php echo $number_of_taps_err_input ?>" class="col-2 col-form-label">Number of Taps</label>
		  <div class="col-10">
		    <input id="<?php echo $number_of_taps_err_input ?>" class="form-control form-control-<?php echo $number_of_taps_err_state?>" type="text" name="number_of_taps" placeholder="<?php
		    echo $number_of_taps_err ?>" value="<?php echo $number_of_taps; ?>">
		  </div>
		</div>
		
		
		<div class="form-group row">
		<label for="choose-theme" class="col-2 col-form-label">Choose Theme</label>
		<div class="custom-controls-stacked form-group col-10">
		
		  <label class="custom-control custom-radio">
		    <input id="radioStacked1" name="current_theme" type="radio" class="custom-control-input" value="0" <?php if ($result[14]['config_value'] == 0) echo 'checked' ?>>
		    <span class="custom-control-indicator"></span>
		    <span class="custom-control-description">Classic Theme</span>
		  </label>
		  <label class="custom-control custom-radio">
		    <input id="radioStacked2" name="current_theme" type="radio" class="custom-control-input" value="1" <?php if ($result[14]['config_value'] == 1) echo 'checked' ?>>
		    <span class="custom-control-indicator"></span>
		    <span class="custom-control-description">Modern Theme</span>
		  </label>
		</div>
		</div>
		
		
		<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		
		
		<div class="row">
		<p>Version: <?php echo $result[11]['config_value']; ?></p>
		</div>

	<!-- Used for diganostics, add php tag to activate
		echo "<h2>Your Input:</h2>";
		echo 'Brewery Name: '.$header_text;
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
<?php    //include html footer template
    require('assets/inc/html-footer.php');   
    ?>
</html>