<!DOCTYPE html>
<?php 
   include('assets/inc/func.inc');
   require_once('Connections/itaps_conn.php');
   mysqli_set_charset($conn, 'utf8');
   
   // declare variables and set to empty/placeholder values
   
   $keg_idErr = 'Required';
   $keg_id = $keg_idErrSpan = $keg_idErrClass = '';
   $type = $typeErrSpan = $typeErrClass = '';
   $beer = $beer_id = $beerErrSpan = $beerErrClass = '';
   $serial = $serialErrSpan = $serialErrClass = '';
   $status_id = $status = $statusErrSpan = $statusErrClass = '';
   $volume = $volumeErrSpan = $volumeErrClass = '';
   $mfg = $mfg = $mfgErrSpan = $mfgErrClass = '';
   $keg_id = $new_keg_id = $formAction = $action = $actionTitle = $styleNumber = $note = $update = $method = $feedback = $feedbackType = $kegIDsArray = '';
   


   if (isset($_GET['action']) && (isset($_GET['keg_id']))){
   $keg_id = $_GET['keg_id'];
   $action = $_GET['action'];
 //  echo 'first GET action is '.$action.'<br/>';
//  	echo 'first GET keg_id is: '.$keg_id;
	   
   //}else{header('Location: beers.php');}
   }
   if (isset($_POST['formAction'])){$formAction = $_POST['formAction'];}
   if (isset($_POST['new_keg_id'])){$new_keg_id = $_POST['new_keg_id'];}
   
   // Pull status for drop down menu
   
   mysqli_select_db($conn, $database);
   $query_kegStatus = "SELECT
   `keg-status`.status_id,
   `keg-status`.`status`
   FROM
   `keg-status`
   ORDER BY
   `keg-status`.status_id ASC";
   $kegStatus = mysqli_query($conn, $query_kegStatus) or die(mysqli_error());
   $row_kegStatus = mysqli_fetch_assoc($kegStatus);
   $totalRows_kegStatus = mysqli_num_rows($kegStatus);
   $listStatusId = $row_kegStatus['status_id'];
   $listStatus = $row_kegStatus['status'];
   
   // Pull beers for drop down menu
   
   mysqli_select_db($conn, $database);
   $query_beers = "SELECT
   beers.beer_id,
   beers.beerName
   FROM
   beers
   ORDER BY
   beers.beerName ASC";
   $beers = mysqli_query($conn, $query_beers) or die(mysqli_error());
   $row_beers = mysqli_fetch_assoc($beers);
   $totalRows_beers = mysqli_num_rows($beers);
   $listBeerID = $row_beers['beer_id'];
   $listBeerName = $row_beers['beerName'];
   
   if ((isset($_GET['action']) && !empty($_GET['keg_id'])) || (isset($_POST['formAction']))){
   if ($_SERVER['REQUEST_METHOD'] === 'GET'){$keg_id = $_GET['keg_id'];$action = $_GET['action'];}
   if ($_SERVER['REQUEST_METHOD'] === 'POST'){$keg_id = $_POST['keg_id'];$formAction  = $_POST['formAction'];}
  
   	
   // Pull data for filling form
   
   mysqli_select_db($conn, $database);
   $query_kegList = "SELECT
   kegs.keg_id,
   kegs.volume,
   kegs.type,
   kegs.serial,
   kegs.mfg,
   kegs.note,
   kegs.fill,
   `keg-status`.`status`,
   `keg-status`.status_id,
   beers.beerName,
   beers.beer_id,
   admin.volumeType,
   admin.volumeTypeAbbrev
   FROM
   `keg-status`
   JOIN kegs
   ON `keg-status`.status_id = kegs.status_id_fk 
   LEFT JOIN beers
   ON kegs.beer_id_fk = beers.beer_id,
   admin
   WHERE
   kegs.keg_id ='$keg_id'
   ORDER BY
   kegs.keg_id ASC";
   $kegList = mysqli_query($conn, $query_kegList) or die(mysqli_error());
   
   // Set simple variables
   
   $totalRows_kegList = mysqli_num_rows($kegList);
   	
   	while ($varSet = mysqli_fetch_assoc($kegList))
   		{
   		$keg_id = $varSet['keg_id'];
   		$type = $varSet['type'];
   		$serial = $varSet['serial'];
   		$status = $varSet['status'];
   		$status_id = $varSet['status_id'];
   		$beerName = $varSet['beerName'];
   		$beer_id = $varSet['beer_id'];
   		$volume = $varSet['volume'];
   		$mfg = $varSet['mfg'];
   		$note = $varSet['note'];
   		}
	   
	if ($action == 'delete') $actionTitle ='<h1 class="action-title">Delete a Keg</h1>';
	if ($action == 'edit') $actionTitle ='<h1 class="action-title">Edit a Keg</h1>';
   }elseif (isset($_GET['action']) && $_GET['action'] == 'new'){
   	$actionTitle = '<h1 class="action-title">Add a Keg</h1>';}
   else
   
   {$actionTitle = '<h1 class="action-title">Error: Please select a keg to edit or delete</h1><br?><a type="button" class="btn btn-primary" href="kegs.php"  >
         Back</a>';}

// If delete, then delete record
	   
	   if ((isset($_POST)) && array_key_exists('formAction', $_POST) && $formAction == 'delete')
	   
	   {
		   $keg_id = $_POST['keg_id'];
		   $sql = 
		   "DELETE FROM kegs
WHERE keg_id='$keg_id'";
	   if (mysqli_query($conn, $sql))
         			{
         			$feedback = 'Record deleted successfully';
         			$feedbackType = 'success';
         			}
         		  else
         			{
         			$feedback = 'Error deleting record: ' . mysqli_error($conn);
         			$feedbackType = 'danger';
         			}
	   }
	   
         // If data submitted, validate data
         
         if ((isset($_POST)) && array_key_exists('action', $_POST) && $formAction == 'update')
         	{
         $action = $_POST['action'];
         	// Get keg_id array
         
         	mysqli_select_db($conn, $database);
         	$query_kegID = "SELECT
         kegs.keg_id
         FROM
         kegs";
         	$kegIDs = mysqli_query($conn, $query_kegID) or die(mysqli_error());
         	$kegIDsArray = array();
         	while (($row = mysqli_fetch_assoc($kegIDs)))
         		{
         		$kegIDsArray[] = $row['keg_id'];
         		}
         
         	// Check if new keg id has been entered
         
         	if (empty($_POST["new_keg_id"]) && $action == 'new')
         		{
         		$keg_idErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
         		$keg_idErrClass = ' has-error has-feedback';
         		$keg_idErr = 'Keg Number is required';
         		}
         	  else
         		{
         		$keg_id = test_input($_POST["keg_id"]);
         		$new_keg_id = test_input($_POST["new_keg_id"]);
         		//echo (in_array($new_keg_id, $kegIDsArray) ? 'INARRAY' : 'NOT INARRAY');
         
         		// Check if keg number only contains numbers
         
         		if (!preg_match("/^[1-9]*$/", $new_keg_id))
         			{
         			$keg_idErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
         			$keg_idErrClass = ' has-error has-feedback';
         			$keg_id = '';
         			$keg_idErr = 'Only numbers allowed';
         			}
         		  else
         			{
						
         			if (in_array($new_keg_id, $kegIDsArray) && $action == 'new')
         				{
         				$keg_idErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
         				$keg_idErrClass = ' has-error has-feedback';
         				$keg_id = '';
         				$keg_idErr = 'Keg number in use, please choose another';
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
         
         	// Check if volume has been entered
         
         	if (empty($_POST["volume"]))
         		{
         		$volume = '0.0';
         		}
         	  else
         		{
         		$volume = test_input($_POST["volume"]);
         
         		// Check if volume is well-formed
         
         		if (!preg_match("/^[1-9]*[.]{1}[0-9]{1,5}$/", $volume))
         			{
         			$volumeErrSpan = '<span class="error glyphicon glyphicon-remove form-control-feedback"></span>';
         			$volumeErrClass = ' has-error has-feedback';
         			$volume = '';
         			$volumeErr = "Volume must be entered in #.# decimal format";
         			}
         		}
         
         	// Check if mfg has been entered
         
         	if (empty($_POST["mfg"]))
         		{
         		$mfg = '';
         		}
         	  else
         		{
         		$mfg = test_input($_POST["mfg"]);
         		}
                  	// Check if type has been entered
         
         	if (empty($_POST["type"]))
         		{
         		$type = '';
         		}
         	  else
         		{
         		$type = test_input($_POST["type"]);
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
         
         	if ((!empty($keg_idErrSpan)) || (!empty($volumeErrSpan)))
         		{
         		$_POST['keg_id'] = $keg_id;
         		$feedback = 'Data not updated, please correct errors.';
         		$feedbackType = 'danger';
         		}
         	  else
         
         	// If no errors, the set variables for data update/insert
         
         		{
         		$listStatusId = $_POST["listStatusID"];
					if ($_POST['beer_id'] === ''){ $beer_id = 'NULL';
				}else{
				$beer_id = $_POST['beer_id'];}
         		$note = $_POST['note'];
         		$keg_id = $_POST['keg_id'];
         		// If an edit, update record
         
         		if ($action == 'edit');
	//				echo $beer_id;
         			{
         			$sql = "UPDATE kegs SET serial='$serial', status_id_fk='$listStatusId', volume='$volume', type='$type',  mfg='$mfg', note='$note', beer_id_fk=$beer_id WHERE keg_id='$new_keg_id'";
         			}
         
         		// If new, insert a record
         
         		if ($action == 'new')
         			{
         			$sql = "INSERT INTO kegs (keg_id, serial, status_id_fk, volume, mfg, note) VALUES ('$new_keg_id', '$serial', '$listStatusId', '$volume', '$mfg', '$note')";
         			}
         
         		// User feedback
         
         		if (mysqli_query($conn, $sql))
         			{
         			$feedback = 'Record updated successfully';
         			$feedbackType = 'success';
					header( "Refresh:3; url=kegs.php", true, 303);
         			}
         		  else
         			{
         			$feedback = 'Error updating record: ' . mysqli_error($conn);
         			$feedbackType = 'danger';
					header( "Refresh:5; url=kegs.php", true, 303);
         			}
         		}
         	}

   ?>

<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../favicon.ico">
      <title>Add/Edit Kegs</title>
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
      <div class="container theme-showcase" role="main">
      <div class=page-title><?php echo $actionTitle; ?>
      <?php 
      	if (!empty($feedback))
      	echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
      	?></div>
         <?php if ($action == 'new'  || $action == 'edit' || $formAction == 'update'){?>
         <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <?php if ($action == 'edit'){?>
            <div class="form-group<?php echo $keg_idErrClass?>">
               <label class="control-label col-xs-2" for="keg_id">Keg #:</label>
               <div class="col-xs-5">
                  <input type="hidden" name="new_keg_id" value="<?php echo $keg_id;?>">
                  <p class="form-control-static"><?php echo $keg_id;?></p>
               </div>
            </div>
            <?php ;}else{?>
            <div class="form-group<?php echo $keg_idErrClass?>">
               <label class="control-label col-xs-2" for="keg_id">Keg #:</label>
               <div class="col-xs-5">
                  <input class="form-control" type="text" id="new_keg_id" name="new_keg_id" placeholder="<?php echo $keg_idErr ?>" value="<?php echo $keg_id;?>">
                  <?php echo $keg_idErrSpan;?>
               </div>
            </div>
            <?php ;} ?>
            <div class="form-group<?php echo $statusErrClass?>">
               <label class="control-label col-xs-2" for="style">Status: </label>
               <div class="col-xs-5">
                  <select class="form-control" name="listStatusID" id="listStatusId">
                     <?php do { 
                        $listStatus = $row_kegStatus['status'];
                        $listStatusId = $row_kegStatus['status_id'];
                        ?>
                     <option value="<?php echo $listStatusId ?>"<?php if($status_id == $listStatusId) echo 'selected' ?>><?php echo $listStatus; ?></option>
                     <?php } while ($row_kegStatus = mysqli_fetch_assoc($kegStatus)); ?>	
                  </select>
                  <?php echo $typeErrSpan;?>
               </div>
            </div>
            <div class="form-group<?php echo $beerErrClass?>">
               <label class="control-label col-xs-2" for="style">Beer: </label>
               <div class="col-xs-5">
                  <select class="form-control" name="beer_id" id="beer_id">
                    <option value="">None</option>
                     <?php do { 
                        $listBeerName = $row_beers['beerName'];
                        $listBeerID = $row_beers['beer_id'];
                        ?>
                     <option value="<?php echo $listBeerID ?>"<?php if($beer_id == $listBeerID) echo 'selected' ?>><?php echo $listBeerName; ?></option>
                     <?php } while ($row_beers = mysqli_fetch_assoc($beers)); ?>	
                  </select>
                  <?php echo $beerErrSpan;?>
               </div>
            </div>
                        <div class="form-group<?php echo $volumeErrClass?>">
               <label class="control-label col-xs-2" for="volume">Volume:</label>
               <div class="col-xs-5">
                  <input class="form-control" type="text" id="volume" name="volume" placeholder="Optional, numbers only" value="<?php echo $volume;?>">
                  <?php echo $volumeErrSpan;?>
               </div>
            </div>
            <div class="form-group<?php echo $serialErrClass?>">
               <label class="control-label col-xs-2" for="serial">Serial #: </label>
               <div class="col-xs-5">
                  <input class="form-control" type="text" id="serial" name="serial" placeholder="Optional" value="<?php echo $serial;?>">
                  <?php echo $serialErrSpan;?>
               </div>
            </div>
           <div class="form-group<?php echo $typeErrClass?>">
               <label class="control-label col-xs-2" for="serial">Type: </label>
               <div class="col-xs-5">
                  <input class="form-control" type="text" id="type" name="type" placeholder="Optional" value="<?php echo $type;?>">
                  <?php echo $typeErrSpan;?>
               </div>
            </div>
            <div class="form-group<?php echo $mfgErrClass?>">
               <label class="control-label col-xs-2" for="mfg">MFG/Owner:</label>
               <div class="col-xs-5">
                  <input class="form-control" type="text" id="mfg" name="mfg" placeholder="Optional" value="<?php echo $mfg;?>">
                  <?php echo $mfgErrSpan;?>
               </div>
            </div>
            <div class="form-group ">
               <label class="control-label col-xs-2" for="note">Note:</label>
               <div class="col-xs-5">
                  <textarea class="form-control " rows="5" id="note" name="note" placeholder="Optional" ><?php echo $note; ?></textarea>
               </div>
            </div>
            <input type="hidden" name="formAction" value="update">
            <input type="hidden" name="action" value="<?php echo $action;?>">
            <input type="hidden" name="keg_id" value="<?php echo $keg_id;?>">
            <div class="form-group">
               <div class="col-xs-offset-2 col-xs-10">
                  <button type="<?php echo ($action == 'delete') ? 'button':'submit'; ?>" class="btn btn-primary" <?php if($action == 'delete') echo 'data-toggle="modal" data-target="#myModal"'  ?>>
                  <?php if($action == 'new')
                     echo 'Add Keg';
                     if ($action == 'edit' || $formAction == 'update') echo 'Update'; ?></button>
               </div>
            </div>
         </form>
         <?php }?>
      </div>
      <!-- /container -->
      
      
    <!-- Debug info
    
         echo "<h2>Your Input:</h2>";
         echo 'Action: '.$action;
         echo "<br>";	  
         echo 'Form Action: '.$formAction;	  
         echo "<br>";
         	  echo 'beer_id: '.$beer_id;
         echo "<br>";
         echo 'keg_id: '.$keg_id;
         echo "<br>";
         echo 'new_keg_id: '.$new_keg_id;
         echo "<br>";
         echo 'Status: '.$listStatus;
         echo "<br>";
         echo 'StatusID: '.$listStatusId;
         echo "<br>";
         echo 'Keg Type: '.$type;
         echo "<br>";
         echo 'Serial: '.$serial;
         echo "<br>";
         echo 'mfg: '.$mfg;
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