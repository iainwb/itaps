<?php 
	require ('assets/inc/config.php');
	include ('assets/inc/func.inc');
  	require_once ('connections/itaps_conn.php');
   	
   // declare variables and set to empty/placeholder values
   
   $tapKick = $keg_id = $tap_id = $action = $beer_id = $feedback = $feedback_type = $sql = '';
   $color = "fff";
   
   
   // Pull free tap data
   
   $query_free_taps = "SELECT
   tap_status.tap_id
   FROM
   tap_status
   WHERE
   tap_status.keg_id_fk IS NULL
   ORDER BY
   tap_status.tap_id ASC";
   $free_taps = $conn->query($query_free_taps);
     $row_free_taps = $free_taps->fetch(PDO::FETCH_ASSOC);
   $list_tap_id = $row_free_taps['tap_id'];
   
   // Pull keg data
   
   $query_keglist = "SELECT
   kegs.keg_id,
   keg_types.display_name,
   keg_status.status_code,
   beers.beer_name,
   beers.beer_id,
   kegs.serial,
   kegs.make,
   kegs.model,
   kegs.note,
   tap_status.tap_id
   FROM
   keg_types
   RIGHT JOIN kegs
   ON keg_types.keg_type_id = kegs.keg_type_id_fk 
   LEFT JOIN beers
   ON beers.beer_id = kegs.beer_id_fk 
   JOIN keg_status
   ON keg_status.status_id = kegs.status_id_fk 
   LEFT JOIN tap_status
   ON tap_status.keg_id_fk = kegs.keg_id
   ORDER BY
   kegs.keg_id ASC";
   $keglist = $conn->query($query_keglist);
   $row_keglist = $keglist->fetch(PDO::FETCH_ASSOC);
				

   
   if (isset($_POST['action'])){
   	
   	$action = $_POST['action'];
   	$keg_id = $_POST['keg_id'];
   	$tap_id = $_POST['tap_id'];
   			
   	if ($action == 'kick') {
   	
   			try		{
   	
   					// set the PDO error mode to exception
   	
   					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   	
   	$sql = "UPDATE
   	tap_status, kegs
   	SET
   	tap_status.keg_id_fk = NULL,
   	kegs.beer_id_fk = NULL,
   	kegs.status_id_fk = 3
   	WHERE
   	tap_status.keg_id_fk = kegs.keg_id AND tap_status.keg_id_fk = '$keg_id'";
   	
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
   			
   							 header("Refresh:4; url=kegs.php", true, 303);
   							}
   	}
   
   						if ($action == 'tap'){
   			
   			try{
   	
   					// set the PDO error mode to exception
   	
   					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   					$sql = "UPDATE tap_status,
   			kegs
   		SET	tap_status.keg_id_fk = '$keg_id',
   			kegs.status_id_fk = 1
   		WHERE tap_status.tap_id = '$tap_id'
   			AND kegs.keg_id = '$keg_id'";
   			
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
   			
   							 header("Refresh:4; url=kegs.php", true, 303);
   			
   							}
   					}
   			
   	
   
   	if ($action == 'delete')
   		{
   		// set the PDO error mode to exception
   		   try { $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   		
   		$keg_id = $_POST['keg_id'];
   		$sql = "DELETE FROM kegs
   				WHERE keg_id='$keg_id'";
   				
   				// use exec() because no results are returned
   				    $conn->exec($sql);
   				    $feedback = 'Record updated successfully';
   				    $feedbackType = 'success';
   				    header("Refresh:2; url=kegs.php", true, 303);
   				    }
   				catch(PDOException $e)
   				    {
   				    $feedback = 'Error updating record: ';
   				    $feedbackType = 'danger';
   				    echo $sql . "<br>" . $e->getMessage();
   				    header("Refresh:4; url=kegs.php", true, 303);
   				    }
   				
   				
   		}
   }
   	// User feedback
   
  //define page title
  $title = 'Keg List';
  
  //include html header template
  require('assets/inc/html-header.php'); 			
   ?>
   <body>
      <!-- Modal HTML Kick Keg -->
      <div id="keg-process-kick" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
      <div id="keg-process-tap" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body">
                  <p>Do you want to tap this keg?</p>
                  <form>
                     <select class="form-control" name="list-tap-id" id="list-tap-id">
                        <option>Choose a tap:</option>
                        <?php do { 
                           $list_tap_id = $row_free_taps['tap_id'];
                           ?>
                        <option data-keg_id="<?php echo $list_tap_id ?>" value="<?php echo $list_tap_id ?>"><?php echo $list_tap_id; ?></option>
                        <?php } while ($row_free_taps = $free_taps->fetch(PDO::FETCH_ASSOC)); ?>	
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
      <div id="keg-process-delete" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
      <div id="keg-process-edit" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Confirmation</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               </div>
               <div class="modal-body">
                  <p>Do you want to edit this keg?<br>
                  Currently tapped kegs will be kicked.</p>
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
      <div class="container">
         <div class="page-title">
            <h1>Keg List</h1>
            <?php 
               if (!empty($feedback))
               echo'<div class="alert alert-'.$feedback_type.' " role="alert">'.$feedback.'</div>';
               ?>
         </div>
         <form id="keg-edit" class="keg-edit" action="kegs-edit.php" method="post">
            <div class="info">
               <?php do {
                  $keg_id = $row_keglist['keg_id'];		
                  $type = $row_keglist['display_name'];
                  $keg_status_code = $row_keglist['status_code'];
                  $beer_name = $row_keglist['beer_name'];
                  $beer_id = $row_keglist['beer_id'];
                  $serial = $row_keglist['serial'];
                $make = $row_keglist['make'];
                $model = $row_keglist['model'];
                  $note = $row_keglist['note'];
                  $tap_id = $row_keglist['tap_id'];
                  ?>
               <div class="row">
                  <div class="col-md kegnum">Keg #<?php echo $keg_id; ?><br/><span class="beer-name"><?php echo (!empty($beer_name)) ? $beer_name:'No beer'; ?></span>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3 hidden-sm-down type">Type:&nbsp;<?php echo $type; ?></div>
                  <div class="col-md-3 hidden-sm-down serial">Serial:&nbsp;<?php echo $serial; ?></div>
                  <div class="col-md-3 keg-status-code">
                     <div class="card card-inverse h-25 text-center <?php statusColor ($keg_status_code, $color); ?>">
                        <div class="card-block">
                           <?php echo $keg_status_code;
                              if ($keg_status_code == 'Tapped'){
                              	echo '&#8212;Tap #'.$tap_id;
                              	}
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 tap-action"><?php if ($keg_status_code == 'Tapped'){?>
                     <button type="button" class="keg-process btn btn-outline-warning" data-toggle="modal" data-target="#keg-process-kick" data-keg_id="<?php echo $keg_id ?>" data-action="kick"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span>Kick Keg</button>	
                     <?php }elseif ($keg_status_code == 'On Deck'){ ?>
                     <button type="button" class="keg-process btn btn-outline-primary" data-toggle="modal" data-target="#keg-process-tap" data-keg_id="<?php echo $keg_id ?>" data-action="tap"><span class="fa fa-beer" aria-hidden="true"></span>Tap Keg</button>
                     <?php	}else{ echo'&nbsp;';} ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3 hidden-sm-down make">Make:&nbsp;<?php echo $make; ?></div>
                  <div class="col-md-3 hidden-sm-down mfg">Model:&nbsp;<?php echo $model; ?></div>
                  <div class="col-md-3 edit">
                     <button type="button" class="keg-process btn btn-outline-success" data-toggle="modal" data-target="#keg-process-edit" data-keg_id="<?php echo $keg_id ?>" data-action="edit"><span class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></span>Edit Keg</button>
                  </div>
                  
                  <div class="col-md-3 delete">
                     <button type="button" class="keg-process btn btn-outline-danger"  data-toggle="modal" data-target="#keg-process-delete" data-keg_id="<?php echo $keg_id ?>" data-action="delete"><span class="fa fa-trash-o fa-lg" aria-hidden="true"></span>Delete Keg</button>
                  </div>
               </div>
               <div class="row">
               <div class="col-md-6 hidden-sm-down note">Note:&nbsp;<?php echo $note; ?></div>
                  
               </div>
               <?php } while ($row_keglist = $keglist->fetch(PDO::FETCH_ASSOC)); ?>
            </div>
            <input type="hidden" class="action" name="action" value="" >
            <input type="hidden" class="keg-id" name="keg_id" value="" >
         </form>
      </div>
      <!-- /container -->
      <!-- Hidden Form to Process a Keg actions -->
      <form id="keg-process" class="keg-process" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
         <input type="hidden" class="action" name="action" value="">
         <input type="hidden" class="keg-id" name="keg_id" value="">
         <input type="hidden" class="tap-id" name="tap_id" value="">
      </form>
      <!-- Hidden Form to Process a New Keg Request -->
      <form class="hidden" id="keg-new" action="kegs-edit.php" method="post">
         <input type="hidden" name="action" value="new">
         <input type="hidden" id="hiddenValue" name="keg_id" value="">
      </form>
      <?php    //include html footer template
          require('assets/inc/html-footer.php');   
          ?>   </body>
</html>