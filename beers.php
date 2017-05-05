<!DOCTYPE html>
<?php 
include ('assets/inc/func.inc');

require_once ('Connections/itaps_conn.php');

mysqli_set_charset($conn, 'utf8');

// define variables and set to empty/placeholder values

$abv = '';

// Pull beer data

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
ON `2015-bjcp-styles`.styleNumber = beers.styleNumber_fk";
$beerList = mysqli_query($conn, $query_beerList) or die(mysqli_error());
$row_beerList = mysqli_fetch_assoc($beerList);
$totalRows_beerList = mysqli_num_rows($beerList);

if (isset($_POST['action']))
	{
	$action = $_POST['action'];
	$beer_id = $_POST['beer_id'];
	if ($action == 'delete')
		{
		$beer_id = $_POST['beer_id'];
		$sql = "DELETE FROM beers
WHERE beer_id='$beer_id'";
		}

	// User feedback

	if (mysqli_query($conn, $sql))
		{
		$feedback = 'Record updated successfully';
		$feedbackType = 'success';
		header("Refresh:4; url=beers.php", true, 303);
		}
	  else
		{
		$feedback = 'Error updating record: ' . mysqli_error($conn);
		$feedbackType = 'danger';
		header("Refresh:4; url=beers.php", true, 303);
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

    <title>Beers</title>

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

	
  <!-- Modal HTML Delete Beer -->
<div id="beerProcessDelete" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Confirmation</h4>
         </div>
         <div class="modal-body">
            <p>Do you want to delete this beer?</p>
            <p class="text-warning"><small>This change cannot be undone.</small></p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="submitBeerProcess()">Delete</button>
         </div>
      </div>
   </div>
</div>
           <!-- Modal HTML Edit Beer -->
<div id="beerProcessEdit" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Confirmation</h4>
         </div>
         <div class="modal-body">
            <p>Do you want to edit this beer?</p>
            <p class="text-warning"><small>This change cannot be undone.</small></p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick=" submitBeerEdit()">Edit</button>
         </div>
      </div>
   </div>
</div>
<?php include("assets/inc/navbar-header.inc"); ?>
    <div class="container theme-showcase" role="main">
    <button type="button" class="btn new btn-primary" onclick="submitBeerNew()">New Beer</button>
		<div class=page-title><h1>Beer List</h1>
		<?php 
			if (!empty($feedback))
			echo'<div class="alert alert-'.$feedbackType.' " role="alert">'.$feedback.'</div>';
			?></div>
		<form id="beerEdit" class="beerEdit" action="beers-edit.php" method="post">
		<table class="info">
			<?php do { 
				$beer_id = $row_beerList['beer_id'];
				$beerName = $row_beerList['beerName'];
				$style = $row_beerList['styleName'];
				$styleNumber = $row_beerList['styleNumber'];
				$og = $row_beerList['og'];
				$fg = $row_beerList['fg'];
				$ibu = $row_beerList['ibu'];
				$colorName = $row_beerList['colorName'];
				$srmDecimal = $row_beerList['srmDecimal'];
				$note = $row_beerList['note'];
				$gubu = round($ibu/(($og-1)*1000),2);
				$ibuImg = (round($ibu/120,2)*100);
				$abvImg = (round(abv($og, $fg, $abv, $digits = 2)/20,2)*100);
			?>
			
			<thead>
			   <tr>
			      <th colspan="5">
			        <?php echo $beerName; ?>
			      </th>
			   </tr>
			</thead>
			<tbody>
			<tr>
				<td><?php echo $style; ?></td>
				<td>OG:&nbsp;<?php echo $og; ?></td>
				<td>FG:&nbsp;<?php echo $fg; ?></td>
				<td>IBU:&nbsp;<?php echo $ibu; ?></td>
				<td><button type="button" class="beerProcess btn btn-primary"   data-toggle="modal" data-target="#beerProcessEdit" data-beer_id="<?php echo $beer_id ?>" data-action="edit">Edit Beer</button></td>
				</tr>
				<tr>
				<td>SRM:&nbsp;<?php echo $srmDecimal; ?></td>
				<td>ABV:&nbsp;<?php echo abv($og, $fg, $abv, $digits = 2); ?>%</td>
				<td colspan="2">Note:&nbsp;<?php echo $note; ?></td>
				<td><button type="button" class="beerProcess btn btn-primary"   data-toggle="modal" data-target="#beerProcessDelete" data-beer_id="<?php echo $beer_id ?>" data-action="delete">Delete Beer</button></td>
				</tr>
				</tbody>
			<?php } while ($row_beerList = mysqli_fetch_assoc($beerList)); ?>
			</table>
			<input type="hidden" class ="action "name="action" value="">
			<input type="hidden" class="beer_id" name="beer_id" value="" >
			</form>
			
		</div>
	 </div>
	 
	  <!-- /container -->
<!-- Hidden Form to Process a Keg actions -->
<form id="beerProcess" class="beerProcess" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
   <input type="hidden" class="action" name="action" value="">
   <input type="hidden" class="beer_id" name="beer_id" value="">
</form>
<form class="hidden" id="beerNew" action="beers-edit.php" method="post">
<input type="hidden" name="action" value="new">
    <input type="hidden" name="beer_id" value="">
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
    <script type="text/javascript">
function submitBeerEdit()
{
document.getElementById("beerEdit").submit();
}
		
function submitBeerNew()
{
document.getElementById("beerNew").submit();
}

function submitBeerProcess()
{
document.getElementById("beerProcess").submit();
}

</script>
<script>								 
   // Get beer_id from beer buttons & send to Hidden Inputs 						 
      $(document).ready(function(){
          $(".beerProcess").click(function () {
			var beer_id = $(this).data('beer_id');
			var action = $(this).data('action');
			  
			$(".beerProcess .beer_id").val(beer_id);
			$(".beerProcess .action").val(action);

			$(".beerEdit .beer_id").val(beer_id);
			$(".beerEdit .action").val(action);
          })
      });							 
</script>
  </body>
</html>

<?php
mysqli_free_result( $beerList );
?>