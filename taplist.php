<?php
	include('assets/inc/func.inc');
	require_once('Connections/itaps_conn.php');
	
	mysqli_select_db($conn, $database);
	$query_tapList = "SELECT
	beers.beerName,
	beers.og,
	beers.fg,
	beers.ibu,
	beers.note,
	srm.srmValue,
	srm.hexColor,
	srm.colorName,
	`2015-bjcp-styles`.styleNumber,
	`2015-bjcp-styles`.styleName,
	`keg-status`.`status`,
	`on-tap`.tap_id
	FROM
	srm
	JOIN beers
	ON srm.srmValue = beers.srmValue_fk 
	JOIN `2015-bjcp-styles`
	ON `2015-bjcp-styles`.styleNumber = beers.styleNumber_fk 
	JOIN kegs
	ON beers.beer_id = kegs.beer_id_fk 
	JOIN `keg-status`
	ON `keg-status`.status_id = kegs.status_id_fk 
	JOIN `on-tap`
	ON kegs.keg_id = `on-tap`.keg_id_fk
	WHERE
	`keg-status`.`status` ='Tapped'
	ORDER BY
	`on-tap`.tap_id ASC";
	
	$tapList = mysqli_query($conn, $query_tapList) or die(mysqli_error());
	$row_tapList = mysqli_fetch_assoc($tapList);
	$totalRows_tapList = mysqli_num_rows($tapList);
	?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Taplist</title>
		<!-- Bootstrap core CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Bootstrap theme -->
		<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="assets/css/taplist.css" rel="stylesheet" type="text/css">
		<!-- <link href="assets/css/high-res.css" rel="stylesheet" type="text/css"> -->
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway|Roboto+Condensed" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<?php
				if (isset($_GET['preview']) && $_GET['preview'] == 'yes')
					include("assets/inc/navbar-header.inc");
				?>
			<div class="row now-serving">
				<div>Currently on Tap</div>
			</div>
			<div class="row headings">
				<div class=" col-md-1">Tap	<br/>#</div>
				<div class="col-md-1">
					Gravity
					<hr>
					Color 
				</div>
				<div class=" col-md-1">
					Balance
					<hr />
					Bitterness 
				</div>
				<div class=" col-md-8">
					Beer Name &amp; Style
					<hr>
					Tasting Notes
				</div>
				<div class=" col-md-1">
					Calories
					<hr>
					Alcohol 
				</div>
			</div>
			<div class="grid">
				<?php 
					do {
					$og=$row_tapList['og'];
					$fg=$row_tapList['fg'];
					$ibu=$row_tapList['ibu'];
					$gubu = round($ibu/(($og-1)*1000),2);
					$abv=$kCal=$ibuImg=$abvImg=0;
					$abv=abv($og, $fg, $abv, $digits = 2);
					$kCal=kCal($og, $fg, $kCal, $digits = 1);
					$ibuImg = (round($ibu/120,2)*100);
					$abvImg = (round($abv*100,2)/15);
					?>
				<div class="beer-info row row-eq-height">
					<div class="tap-num col col-md-1 "><span class="tapcircle"><?php echo $row_tapList['tap_id'];?></span></div>
					<div class="og-color col col-md-1 ">
						<h3><?php echo $row_tapList['og'];?> OG</h3>
						<div class="srm-container">
							<div class="srm-indicator" style="background-color: <?php echo $row_tapList['hexColor']?>; ">
								<div class="srm-stroke"></div>
							</div>
						</div>
						<h3><?php echo $row_tapList['srmValue'] ?> SRM<br/> <?php echo $row_tapList['colorName'] ?></h3>
					</div>
					<div class="ibu col col-md-1 ">
						<h3><?php echo $gubu;?> GU:BU</h3>
						<div class="ibu-container">
							<div class="ibu-indicator">
								<div class="ibu-full" style="height: <?php echo $ibuImg ?>%"></div>
							</div>
						</div>
						<h3><?php echo $ibu; ?> IBU</h3>
					</div>
					<div class="name col col-md-8">
						<h1 class="beer-name"><?php echo $row_tapList['beerName'];?></h1>
						<h2 class="beer-style"><?php echo $row_tapList['styleName'];?></h2>
						<p class="tasting-notes"><?php echo $row_tapList['note'];?></p>
					</div>
					<div class="abv col col-md-1 ">
						<h3><?php echo $kCal;?> kCal</h3>
						<div class="abv-container">
							<div class="abv-indicator">
								<div class="abv-full" style="height: <?php echo $abvImg ?>%"></div>
							</div>
						</div>
						<h3><?php echo $abv; ?> ABV</h3>
					</div>				</div>
				<?php } while ($row_tapList = mysqli_fetch_assoc($tapList)); ?>
			</div>
		</div>
</html>
<?php
	mysqli_free_result($tapList);
	?>