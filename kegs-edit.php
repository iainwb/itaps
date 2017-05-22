<!DOCTYPE html>
<?php 
	include('assets/inc/func.inc');
	require_once('Connections/itaps_conn.php');
	
	// declare variables and set to empty/placeholder values
	
	$keg_id_err = 'Required';
	$keg_id = $keg_id_err_span = $keg_id_err_class = '';
	$type = $type_err_span = $type_err_class = '';
	$beer = $beer_id = $beer_err_span = $beer_err_class = '';
	$serial = $serial_err_span = $serial_err_class = '';
	$make = $make_err_span = $make_err_class = '';
	$model = $model_err_span = $model_err_class = '';
	$status_id = $status = $status_err_span = $status_err_class = '';
	$volume = $volume_err_span = $volume_err_class = '';
	$keg_id = $new_keg_id = $form_action = $action = $action_title = $style_number = $note = $update = $method = $feedback = $feedback_type = $keg_ids_array = $keg_type_id = $row_keg_type = $form_action = '';
	
	// Have an action and keg id been posted: yes-carry on, no return to keg list with an error
	
	if (isset($_POST['action']) && (isset($_POST['keg_id'])))
	{
	$keg_id = $_POST['keg_id'];
	$action = $_POST['action'];
	}
	//   else {
		
			//	header('Location: kegs.php');
		
	//   		echo 'I have nothing to do, return me to the kegs list';
	//  		exit;
	//  }
	
	// if action is delete, then delete or carry on
	
	if ($action == 'delete')
	{
		
		$action = $_POST['action'];
		$keg_id = $_POST['keg_id'];
			
			// set the PDO error mode to exception
			   try { $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    
			    $sql = "DELETE FROM kegs
						WHERE keg_id='$keg_id'";
						
						   					 // use exec() because no results are returned
						    $conn->exec($sql);
						    $feedback = 'Record updated successfully';
						    $feedback_type = 'success';
						    header("Refresh:4; url=kegs.php", true, 303);
						    }
						catch(PDOException $e)
						    {
						    $feedback = 'Error updating record: ';
						    $feedback_type = 'danger';
						    echo $sql . "<br>" . $e->getMessage();
						    header("Refresh:4; url=kegs.php", true, 303);
						    }
			}
	  
	  // if form action is set, set variable
	  
	  if (isset($_POST['form_action']))
	  	{
	  	$form_action = $_POST['form_action'];}
	  		  
	// If data submitted, validate data
	     
	     if ((isset($_POST)) && array_key_exists('action', $_POST) && $form_action == 'update')
	     	{
	     	     	
	     	// Get keg_id array
	     
	     	$query_keg_ids = "SELECT
	     kegs.keg_id
	     FROM
	     kegs";
	     	$keg_ids = $conn->query($query_keg_ids);
	     	$keg_ids_array = array();
	     	while (($row = $keg_ids->fetch(PDO::FETCH_ASSOC)))
	     		{
	     		$keg_ids_array[] = $row['keg_id'];
	     		}
	     
	     	// Check if new keg id has been entered
	     
	     	if (empty($_POST["new_keg_id"]) && $action == 'new')
	     		{
	     		$keg_id_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
	     		$keg_id_err_class = ' has-danger';
	     		$keg_id_err = 'Keg Number is required';
	     		}
	     	  else
	     		{
	     		$keg_id = test_input($_POST["keg_id"]);
	     		$new_keg_id = test_input($_POST["new_keg_id"]);
	     //		echo (in_array($new_keg_id, $keg_ids_array) ? 'INARRAY' : 'NOT INARRAY');
	     
	     		// Check if keg number only contains numbers
	     
	     		if (!preg_match("/^[1-9]*$/", $new_keg_id))
	     			{
	     			$keg_id_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
	     			$keg_id_err_class = ' has-warning';
	     			$keg_id = '';
	     			$keg_id_err = 'Only numbers allowed';
	     			}
	     		  else
	     			{
						
	     			if (in_array($new_keg_id, $keg_ids_array) && $action == 'new')
	     				{
	     				$keg_id_err_span = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
	     				$keg_id_err_class = ' has-warning';
	     				$keg_id = '';
	     				$keg_id_err = 'Keg number in use, please choose another';
	     				}
	     			}
	     		}
	     
	     	// Check if serial # has been entered
	     
	     	if (empty($_POST["serial"]))
	     		{
	     		$serial = '';
	     		}
	     	  else
	     		{
	     		unset($serial);
	     		$serial = test_input($_POST["serial"]);
	     		}
	     
	     	
	     
	     	// Process make input
	     
	     	if (empty($_POST['make']))
	     		{
	     		$make = '';
	     		}
	     	  else
	     		{
	     		$make = test_input($_POST['make']);
	     		}
	              	        	
        	// Process model input
        	
        		if (empty($_POST['model']))
        			{
        			$model = '';
        			}
        		  else
        			{
        			$model = test_input($_POST['model']);
        			}
        	
        	// Process note input
	     
	     	if (empty($_POST['note']))
	     		{
	     		$comment = "";
	     		}
	     	  else
	     		{
	     		$comment = test_input($_POST['note']);
	     		}
	     
	     	// Check for errors and set error messages
	     
	     	if ((!empty($keg_id_err_span)) || (!empty($volumeerr_span)))
	     		{
	     		$_POST['keg_id'] = $keg_id;
	     		$feedback = 'Data not updated, please correct errors.';
	     		$feedback_type = 'danger';
	     		}
	     	  else
	     
	     	// If no errors, the set variables for data update/insert
	     
	     		{
	     		$keg_id = $_POST['keg_id'];
	     		$keg_type_id = $_POST['keg_type_id'];
	     		$status_id = $_POST['status_id'];
	     		$note = $_POST['note'];
				if ($_POST['beer_id'] === ''){ $beer_id = 'NULL'; }else{ $beer_id = $_POST['beer_id']; }
	     		
	     		// If an edit, update record
	     
	     		if ($action == 'edit'){

	     			try
	     							{
	     			
	     							// set the PDO error mode to exception
	     			
	     			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	     			$sql = "UPDATE kegs
	     				 SET keg_type_id_fk='$keg_type_id',
	     				 status_id_fk='$status_id',
	     				 beer_id_fk=$beer_id,
	     				 serial='$serial',
	     				 make='$make',
	     				 model='$model',
	     				 note='$note'
	     				 WHERE keg_id='$new_keg_id'";
	     			
	     			// Prepare statement
	     			
	     							$stmt = $conn->prepare($sql);
	     			
	     							// execute the query
	     			
	     							$stmt->execute();
	     			
	     							// echo a message to say the UPDATE succeeded
	     			
	     							$feedback = $stmt->rowCount() . " records UPDATED successfully";
	     							$feedback_type = 'success';
	     			
	     							 header("Refresh:2; url=kegs.php", true, 303);
	     			
	     							}
	     							catch(PDOException $e)
	     											{
	     											$feedback = $sql . "<br />" . $e->getMessage();
	     											$feedback_type = 'danger';
	     							
	     											 header("Refresh:5; url=kegs.php", true, 303);
	     							
	     											}
	     			
	     			}
	     
	     		// If new, insert a record
	     
	     		if ($action == 'new')
	     			{
	     			
	     			try
	     							{
	     			
	     							// set the PDO error mode to exception
	     			
	     							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	     			$sql = "INSERT INTO kegs (keg_id, keg_type_id_fk, status_id_fk, beer_id_fk, make, model, serial, note) VALUES ('$new_keg_id', '$keg_type_id', '$status_id', $beer_id, '$make', '$model', '$serial', '$note')";
	     			
	     			// use exec() because no results are returned
	     			
	     							$conn->exec($sql);
	     							$feedback = 'Record created successfully';
	     							$feedback_type = 'success';
	     			
	     							 header("Refresh:3; url=kegs.php", true, 303);
	     			
	     							}
	     							catch(PDOException $e)
	     											{
	     											$feedback = $sql . "<br />" . $e->getMessage();
	     											$feedback_type = 'danger';
	     							
	     											 header("Refresh:5; url=kegs.php", true, 303);
	     							
	     											}
	     			
	     			}
	     
	     		
	     		}
	     	}
	
	
	// Pull status for drop down menu
	
	$query_keg_status = "SELECT
	keg_status.status_id,
	keg_status.status_code
	FROM
	keg_status
	WHERE
	keg_status.status_id != 1
	ORDER BY
	keg_status.status_id ASC";
	$keg_status = $conn->query($query_keg_status);
	$row_keg_status = $keg_status->fetch(PDO::FETCH_ASSOC);   
	$list_status_id = $row_keg_status['status_id'];
	$list_status = $row_keg_status['status_code'];
	
	// Pull keg type for drop down menu
	
	$query_keg_types = "SELECT
	keg_types.keg_type_id,
	keg_types.display_name
	FROM
	keg_types
	ORDER BY
	keg_types.keg_type_id ASC";
	$keg_types = $conn->query($query_keg_types);
	$row_keg_types = $keg_types->fetch(PDO::FETCH_ASSOC);   
	$list_keg_type_id = $row_keg_types['keg_type_id'];
	$list_keg_type = $row_keg_types['display_name'];
	
	// Pull beers for drop down menu
	
	$query_beers = "SELECT
	beers.beer_id,
	beers.beer_name
	FROM
	beers
	ORDER BY
	beers.beer_name ASC";
	$beers = $conn->query($query_beers);
	$row_beers = $beers->fetch(PDO::FETCH_ASSOC);
	$list_beer_id = $row_beers['beer_id'];
	$list_beer_name = $row_beers['beer_name'];
	
	if (isset($_POST['action']) && $_POST['action'] != 'new'){
	$keg_id = $_POST['keg_id'];
	$action_title = '<h1 class="action-title">Edit Your Keg</h1>';
	
	// Pull data for filling form
	
	$query_keglist = "SELECT
	kegs.keg_id,
	keg_types.display_name,
	kegs.keg_type_id_fk,
	keg_status.status_code,
	keg_status.status_id,
	beers.beer_name,
	beers.beer_id,
	kegs.serial,
	kegs.make,
	kegs.model,
	kegs.note,
	admin.volume_type,
	admin.volume_type_abbrev
	FROM
	keg_status
	JOIN kegs
	ON keg_status.status_id = kegs.status_id_fk 
	LEFT JOIN beers
	ON kegs.beer_id_fk = beers.beer_id 
	JOIN keg_types
	ON kegs.keg_type_id_fk = keg_types.keg_type_id,
	admin
	WHERE
	kegs.keg_id = '$keg_id'";
	$keglist = $conn->query($query_keglist);
	
	// Set simple variables
	   	
		while ($var_set = $keglist->fetch(PDO::FETCH_ASSOC))
			{
			$keg_id = $var_set['keg_id'];
			$type = $var_set['display_name'];
			$keg_type_id = $var_set['keg_type_id_fk'];
			$status_code = $var_set['status_code'];
			$status_id = $var_set['status_id'];
			$beer_name = $var_set['beer_name'];
			$beer_id = $var_set['beer_id'];
	$serial = $var_set['serial'];
	$make = $var_set['make'];
	$model = $var_set['model'];
			$note = $var_set['note'];
			}
			
	}else{$actionTitle = '<h1 class="action-title">Add A New Keg</h1>';}
	 
	      
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
		<!-- Modal HTML -->
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Confirmation</h4>
					</div>
					<div class="modal-body">
						<p>Do you want to delete this keg?</p>
						<p class="text-warning"><small>This change cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" onclick=" submitDeleteKeg()">Delete</button>
					</div>
				</div>
			</div>
		</div>
		<?php include("assets/inc/navbar-header.inc"); ?>
		<div class="container">
			<div class="page-title"><?php echo $action_title; ?>
				<?php 
					if (!empty($feedback))
					echo'<div class="alert alert-'.$feedback_type.' " role="alert">'.$feedback.'</div>';
					?>
			</div>
			<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<?php if ($action == 'edit'){?>
				<div class="form-group row <?php echo $keg_id_err_class?>">
					<label  class="col-3 col-form-label" for="keg_id">Keg #:</label>
					<div class="col-8">
						<input type="hidden" name="new_keg_id" value="<?php echo $keg_id;?>">
						<p class="form-control-static"><?php echo $keg_id;?></p>
					</div>
				</div>
				<?php ;}else{?>
				<div class="form-group row <?php echo $keg_id_err_class?>">
					<label  class="col-3 col-form-label" for="keg_id">Keg #:</label>
					<div class="col-8">
						<input class="form-control" type="text" id="new-keg-id" name="new_keg_id" placeholder="<?php echo $keg_id_err ?>" value="<?php echo $keg_id;?>">
						<?php echo $keg_id_err_span;?>
					</div>
				</div>
				<?php ;} ?>
				<div class="form-group row">
					<label  class="col-3 col-form-label" for="type">Type:</label>
					<div class="col-8">
						<select class="form-control" name="keg_type_id" id="keg-type-id">
							<?php do { 
								$list_keg_type = $row_keg_types['display_name'];
								$list_keg_type_id = $row_keg_types['keg_type_id'];
								?>
							<option value="<?php echo $list_keg_type_id ?>" <?php if($keg_type_id == $list_keg_type_id) echo 'selected' ?>><?php echo $list_keg_type ?></option>
							<?php } while ($row_keg_types = $keg_types->fetch(PDO::FETCH_ASSOC)); ?>	
						</select>
					</div>
				</div>
				<div class="form-group row <?php echo $status_err_class?>">
					<label class="col-3 col-form-label" for="style">Status: </label>
					<div class="col-8">
						<select class="form-control" name="status_id" id="status-id">
							<?php do { 
								$list_status = $row_keg_status['status_code'];
								$list_status_id = $row_keg_status['status_id'];
								?>
							<option value="<?php echo $list_status_id ?>"<?php if($status_id == $list_status_id) echo 'selected' ?>><?php echo $list_status; ?></option>
							<?php } while ($row_keg_status = $keg_status->fetch(PDO::FETCH_ASSOC)); ?>	
						</select>
						<?php echo $type_err_span;?>
					</div>
				</div>
				<div class="form-group row <?php echo $beer_err_class?>">
					<label class="col-3 col-form-label" for="style">Beer: </label>
					<div class="col-8">
						<select class="form-control" name="beer_id" id="beer-id">
							<option value="">None</option>
							<?php do { 
								$list_beer_name = $row_beers['beer_name'];
								$list_beer_id = $row_beers['beer_id'];
								?>
							<option value="<?php echo $list_beer_id ?>"<?php if($beer_id == $list_beer_id) echo 'selected' ?>><?php echo $list_beer_name; ?></option>
							<?php } while ($row_beers = $beers->fetch(PDO::FETCH_ASSOC)); ?>	
						</select>
						<?php echo $beer_err_span;?>
					</div>
				</div>
				<div class="form-group row <?php echo $serial_err_class?>">
					<label  class="col-3 col-form-label" for="serial">Serial #: </label>
					<div class="col-8">
						<input class="form-control" type="text" id="serial" name="serial" placeholder="Optional" value="<?php echo $serial;?>">
						<?php echo $serial_err_span;?>
					</div>
				</div>
				<div class="form-group row <?php echo $make_err_class?>">
					<label  class="col-3 col-form-label" for="make">Make: </label>
					<div class="col-8">
						<input class="form-control" type="text" id="make" name="make" placeholder="Optional" value="<?php echo $make;?>">
					</div>
				</div>
				<div class="form-group row <?php echo $model_err_class?>">
					<label  class="col-3 col-form-label" for="model">Model: </label>
					<div class="col-8">
						<input class="form-control" type="text" id="model" name="model" placeholder="Optional" value="<?php echo $model;?>">
					</div>
				</div>
				<div class="form-group row">
					<label  class="col-3 col-form-label" for="note">Note:</label>
					<div class="col-8">
						<textarea class="form-control" rows="5" id="note" name="note" placeholder="Optional" ><?php echo $note; ?></textarea>
					</div>
				</div>
				<input type="hidden" name="form_action" value="update">
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="keg_id" value="<?php echo $keg_id;?>">
				<div class="form-group">
					<div class="col-xs-offset-2 col-xs-10">
						<button type="submit" class="btn btn-primary form">
						<?php if($action == 'new')
							echo 'Add Keg';
							if ($action == 'edit') echo 'Update'; ?></button>
						<a class="btn btn-primary form" href="kegs.php">Cancel</a>
					</div>
				</div>
			</form>
		</div>
		<!-- /container -->
		<!-- Debug info
			echo "<h2>Your Input:</h2>";
			echo 'Action: '.$action;
			echo "<br>";	  
			echo 'Form Action: '.$form_action;	  
			echo "<br>";
				  echo 'beer_id: '.$beer_id;
			echo "<br>";
			echo 'keg_id: '.$keg_id;
			echo "<br>";
			echo 'new_keg_id: '.$new_keg_id;
			echo "<br>";
			echo 'Status: '.$list_status;
			echo "<br>";
			echo 'StatusID: '.$list_status_id;
			echo "<br>";
			echo 'Keg Type: '.$type;
			echo "<br>";
			echo 'Serial: '.$serial;
			echo "<br>";
			echo 'make: '.$make;
			echo "<br>";
			echo $update;
			echo "<br>";
			
			echo 'success? '. $feedback;
				  echo "<br>";
			
			-->
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.goserialleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/docs.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
		<script type="text/javascript" src="assets/js/kegs-edit.js"></script>
	</body>
</html>