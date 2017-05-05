<!DOCTYPE html>
<?php 
	include ('assets/inc/func.inc');
	
	require_once ('Connections/itaps_conn.php');
	
	mysqli_set_charset($conn, 'utf8');
	
	// declare variables and set to empty/placeholder values
	
	$tapKick = $keg_id = $tap_id = $action = $beer_id = $feedback = $sql = '';
	$color = "fff";
	
	
	// Pull free tap data
	
	mysqli_select_db($conn, $database);
	$query_freeTaps = "SELECT
	`on-tap`.tap_id
	FROM
	`on-tap`
	WHERE
	`on-tap`.keg_id_fk IS NULL
	ORDER BY
	`on-tap`.tap_id ASC";
	$freeTaps = mysqli_query($conn, $query_freeTaps) or die(mysql_error());
	$row_freeTaps = mysqli_fetch_assoc($freeTaps);
	$totalRows_freeTaps = mysqli_num_rows($freeTaps);
	$listTapID = $row_freeTaps['tap_id'];
	
	// Pull keg data
	
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
admin.volumeTypeAbbrev,
`on-tap`.tap_id
FROM
`keg-status`
JOIN kegs
ON `keg-status`.status_id = kegs.status_id_fk 
LEFT JOIN beers
ON kegs.beer_id_fk = beers.beer_id 
LEFT JOIN `on-tap`
ON kegs.keg_id = `on-tap`.keg_id_fk,
admin
ORDER BY
kegs.keg_id ASC";
	$kegList = mysqli_query($conn, $query_kegList) or die(mysql_error());
	$row_kegList = mysqli_fetch_assoc($kegList);
	$totalRows_kegList = mysqli_num_rows($kegList);
	
	// Set status type color
	
	function statusColor($status, $color)
		{
		if ($status == "Tapped") echo ("color-tapped");
		elseif ($status == "On Deck") echo ("color-available");
		  else echo ("color-unavailable");
		return ($color);
		}
	
	if (isset($_POST['action']))
		{
		$action = $_POST['action'];
		$keg_id = $_POST['keg_id'];
		$tap_id = $_POST['tap_id'];
		if ($action == 'kick') $sql = "UPDATE
		`on-tap`, kegs
		SET
		`on-tap`.keg_id_fk = NULL,
		kegs.beer_id_fk = NULL,
		kegs.status_id_fk = 3
		WHERE
		`on-tap`.keg_id_fk = kegs.keg_id AND `on-tap`.keg_id_fk = '$keg_id'";
		if ($action == 'tap')
			{
						$sql = "UPDATE `on-tap`,
				kegs
			SET	`on-tap`.keg_id_fk = '$keg_id',
				kegs.status_id_fk = 1
			WHERE `on-tap`.tap_id = '$tap_id'
				AND kegs.keg_id = '$keg_id'";
			}
	
		if ($action == 'delete')
			{
			$keg_id = $_POST['keg_id'];
			$sql = "DELETE FROM kegs
	WHERE keg_id='$keg_id'";
			}
	
		// User feedback
	
		if (mysqli_query($conn, $sql))
			{
			$feedback = 'Record updated successfully';
			$feedbackType = 'success';
//			header("Refresh:3; url=kegs.php", true, 303);
			}
		  else
			{
			$feedback = 'Error updating record: ' . mysqli_error($conn);
			$feedbackType = 'danger';
//			header("Refresh:5; url=kegs.php", true, 303);
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
	
	<title>Kegs</title>
	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/theme.css" rel="stylesheet">
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]>
	<script src="../../assets/js/ie8-responsive-file-warning.js"></script>
	<![endif]-->
	<script src="assets/js/ie-emulation-modes-warning.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	
	<!-- Modal HTML Kick Keg -->
	<div id="kegProcessKick" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h4 class="modal-title">Confirmation</h4>
				</div>
				
				<div class="modal-body">
					<p>Do you want to kick this keg?</p>
					
					<p class="text-warning"><small>This change cannot be undone.</small></p>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<button type="button" class="btn btn-primary" onclick=" submitKegProcess()">Kick</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal HTML Tap Keg -->
	<div id="kegProcessTap" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h4 class="modal-title">Confirmation</h4>
				</div>
				
				<div class="modal-body">
					<p>Do you want to tap this keg?</p>
					
					<form>
						<select class="form-control" name="listTapId" id="listTapId">
							<option>Choose a tap:</option>
							<?php do { 
								$listTapID = $row_freeTaps['tap_id'];
								?>
							<option data-keg_id="<?php echo $listTapID ?>" value="<?php echo $listTapID ?>"><?php echo $listTapID; ?></option>
							<?php } while ($row_freeTaps = mysqli_fetch_assoc($freeTaps)); ?>	
						</select>
					</form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<button type="button" class="btn btn-primary" onclick=" submitKegProcess()">Tap</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal HTML Delete Keg -->
	<div id="kegProcessDelete" class="modal fade">
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
					
					<button type="button" class="btn btn-primary" onclick=" submitKegProcess()">Delete</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal HTML Edit Keg -->
	<div id="kegProcessEdit" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
					<h4 class="modal-title">Confirmation</h4>
				</div>
				
				<div class="modal-body">
					<p>Do you want to edit this keg?</p>
					
					<p class="text-warning"><small>This change cannot be undone.</small></p>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<button type="button" class="btn btn-primary" onclick=" submitKegEdit()">Edit</button>
				</div>
			</div>
		</div>
	</div>
	<?php include("assets/inc/navbar-header.inc"); ?>
	<div class="container theme-showcase" role="main">
	<button type="button" class="btn new btn-primary" onclick="submitNewKegRequest()">New Keg</button>
		<div class=page-title><h1>Keg List</h1>
		<?php 
			if (!empty($feedback))
			echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
			?></div>
		<form id="kegEdit" class="kegEdit" action="kegs-edit.php" method="get">
			<table class="info">
								<?php do {
									$keg_id = $row_kegList['keg_id'];		
									$type = $row_kegList['type'];
									$serial = $row_kegList['serial'];
									$status = $row_kegList['status'];
									$volume = $row_kegList['volume'];
									$volumeTypeAbbrev = $row_kegList['volumeTypeAbbrev'];
									$mfg = $row_kegList['mfg'];
									$note = $row_kegList['note'];
									$beerName = $row_kegList['beerName'];
									$beer_id = $row_kegList['beer_id'];
				$tap_id = $row_kegList['tap_id'];
									?>
								<thead>
					<tr>
						<th colspan="5">
							Keg #<?php echo $keg_id; ?>
						</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td>Type:
							<br /> <?php echo $type; ?></td>
						
						<td>Serial:
							<br /> <?php echo $serial; ?></td>
						
						<td>Volume:
							<br /> <?php echo $volume.' '.$volumeTypeAbbrev; ?></td>
						
						<td><span  class="status <?php statusColor ($status, $color); ?>"><?php echo $status.'<br/>Tap #'.$tap_id; ?></span></td>
						
						<td>
							<button type="button" class="kegProcess btn btn-primary" data-toggle="modal" data-target="#kegProcessEdit" data-keg_id="<?php echo $keg_id ?>" data-action="edit">Edit Keg</button>
						</td>
					</tr>
					
					<tr>
						<td>Mfg/Owner:
							<br /> <?php echo $mfg; ?></td>
						
						<td>Note:
							<br /><?php echo $note; ?></td>
						
						<td>Beer:
							<br /> <?php echo (!empty($beerName)) ? $beerName:'No beer'; ?></td>
						
						<td><?php if ($status == 'Tapped'){?>
							<button type="button" class="kegProcess btn btn-primary"   data-toggle="modal" data-target="#kegProcessKick" data-keg_id="<?php echo $keg_id ?>" data-action="kick">Kick Keg</button>		
							<?php }elseif ($status == 'On Deck'){ ?>
							<button type="button" class="kegProcess btn btn-primary" data-toggle="modal" data-target="#kegProcessTap" data-keg_id="<?php echo $keg_id ?>" data-action="tap">Tap Keg</button>		
							<?php	}else{ echo'&nbsp;';} ?>
						</td>
						
						<td>
							<button type="button" class="kegProcess btn btn-primary"   data-toggle="modal" data-target="#kegProcessDelete" data-keg_id="<?php echo $keg_id ?>" data-action="delete">Delete Keg</button>
						</td>
					</tr>
				</tbody>
				<?php } while ($row_kegList = mysqli_fetch_assoc($kegList)); ?>
			</table>
			
			<input type="hidden" class="action" name="action" value="" >
			
			<input type="hidden" class="keg_id" name="keg_id" value="" >
		</form>
		
		
	</div>
	<?php 
		if (!empty($feedback))
		echo'<div class="alert alert-'.$feedbackType.' col-xs-8" role="alert">'.$feedback.'</div>';
		?>
	<!-- /container -->
	<!-- Hidden Form to Process a Keg actions -->
	<form id="kegProcess" class="kegProcess" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		<input type="hidden" class="action" name="action" value="">
		
		<input type="hidden" class="keg_id" name="keg_id" value="">
		
		<input type="hidden" class="tap_id" name="tap_id" value="">
	</form>
	<!-- Hidden Form to Process a New Keg Request -->
	<form class="hidden" id="kegsNew" action="kegs-edit.php" method="get">
		<input type="hidden" name="action" value="new">
		
		<input type="hidden" id="hiddenValue" name="keg_id" value="">
	</form>
	<!-- Bootstrap core JavaScript
		================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/docs.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
	<script type="text/javascript"  src="assets/js/kegs.js"></script>
</body>
</html>