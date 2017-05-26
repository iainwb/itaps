<!doctype html>
<?php
	include('assets/inc/func.inc');
	require_once('connections/itaps_conn.php');
	
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
	$config_list = $config_info->fetchAll(PDO::FETCH_ASSOC);
	
	$show_tap_num_col = $config_list[0]['config_value'];
	$show_srm_col = $config_list[1]['config_value'];
	$show_ibu_col = $config_list[2]['config_value'];
	$show_abv_col = $config_list[3]['config_value'];
	$show_abv_img = $config_list[4]['config_value'];
	$header_text = $config_list[9]['config_value'];
	$current_theme = $config_list[14]['config_value'];
	$a = $b = $c = $d = 0;
	$name_width = '';
	
	$query_taplist = "SELECT
	tap_status.tap_id,
	beers.beer_name,
	beers.og,
	beers.fg,
	beers.ibu,
	beers.note,
	srm.srm_value,
	srm.hex_color,
	srm.color_name,
	bjcp_styles.style_number,
	bjcp_styles.style_name,
	keg_status.status_code
	FROM
	srm
	JOIN beers
	ON srm.srm_value = beers.srm_value_fk 
	JOIN bjcp_styles
	ON bjcp_styles.style_number = beers.style_number_fk 
	JOIN kegs
	ON beers.beer_id = kegs.beer_id_fk 
	JOIN keg_status
	ON keg_status.status_id = kegs.status_id_fk 
	JOIN tap_status
	ON kegs.keg_id = tap_status.keg_id_fk
	WHERE
	keg_status.status_code ='Tapped'
	ORDER BY
	tap_status.tap_id ASC";
	$taplist = $conn->query($query_taplist);
	
	$row_taplist = $taplist->fetch(PDO::FETCH_ASSOC);
	
	 if ($show_tap_num_col == 0) $a = 1; 
	 if ($show_srm_col == 0) $b = 2;
	 if ($show_ibu_col == 0) $c = 2;
	 if ($show_abv_col == 0) $d = 2;
	 
	 $name_width = (($a + $b + $c + $d)+5);
	?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Taplist</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="assets/css/<?php  echo ($current_theme == 0 ? 'taplist.css' : 'taplist-modern.css'); ?>" rel="stylesheet" type="text/css">
		<!-- <link href="assets/css/high-res.css" rel="stylesheet" type="text/css"> -->
			<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway|Roboto+Condensed|Cabin|Poppins" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid">
			<?php
				if (isset($_GET['preview']) && $_GET['preview'] == 'yes')
				include("assets/inc/navbar-header.inc");
			?>
			<div class="row top">
				<p class="now-serving"><?php echo $header_text; ?></p>
			</div>
			<div class="row headings">
				<div class="tap-num col-1 <?php if ($show_tap_num_col == 0) echo 'no-show';?>">Tap<br>#</div>
				<div class="og-color col-2  <?php if ($show_srm_col == 0) echo 'no-show';?>">
					<span class="top-ident">Gravity</span>
					<span class="bottom-ident">Color</span> 
				</div>
				<div class="ibu col-2 <?php if ($show_ibu_col == 0) echo 'no-show';?>">
					<span class="top-ident">Balance</span>
					<span class="bottom-ident">Bitterness</span>
				</div>
				<div class="name col-<?php echo $name_width; ?>">
					<span class="top-ident">Beer Name &amp; Style</span>
					<span class="bottom-ident">Tasting Notes</span>
				</div>
				<div class="abv col-2">
					<span class="top-ident">Calories</span>
					<span class="bottom-ident">Alcohol</span>
				</div>
			</div>
			<?php 
				do {
				$tap_num = $row_taplist['tap_id'];
				$srm_value = $row_taplist['srm_value'];
				$color_name = $row_taplist['color_name'];
				$hex_color = $row_taplist['hex_color'];
				$og=$row_taplist['og'];
				$fg=$row_taplist['fg'];
				$ibu=$row_taplist['ibu'];
				$gubu = round($ibu/(($og-1)*1000),2);
				$abv=$kCal=$ibuImg=$abvImg=0;
				$abv=abv($og, $fg, $abv, $digits = 2);
				$kCal=kCal($og, $fg, $kCal, $digits = 1);
				$ibu_img = (round($ibu/120,2)*100);
				$abv_img = (round($abv*100,2)/15);
				?>
			<div class="row beer-info">
				<div class="tap-num col-1 <?php if ($show_tap_num_col == 0) echo 'no-show';?>"><span class="tapcircle rounded-circle"><?php echo $tap_num;?></span></div>
				<div class="og-color col-2 <?php if ($show_srm_col == 0) echo 'no-show';?>">
					<h3><?php echo $og;?> OG</h3>
					<div class="srm-container hidden-sm-down rounded-circle">
						<div class="srm-indicator" style="background-color: <?php echo $hex_color;?> ">
							<div class="srm-stroke"></div>
						</div>
					</div>
					<h3><?php echo $srm_value; ?> SRM<br> <?php echo $color_name; ?></h3>
				</div>
				<div class="ibu col-2 <?php if ($show_ibu_col == 0) echo 'no-show';?>">
					<h3><?php echo $gubu;?> GU:BU</h3>
					<div class="ibu-container hidden-sm-down">
						<div class="ibu-indicator">
							<div class="ibu-full" style="height: <?php echo $ibu_img ?>%"></div>
						</div>
					</div>
					<h3><?php echo $ibu; ?> IBU</h3>
				</div>
				<div class="name col-<?php echo $name_width; ?>">
					<h1 class="beer-name"><?php echo $row_taplist['beer_name'];?></h1>
					<h2 class="beer-style"><?php echo $row_taplist['style_name'];?></h2>
					<p class="tasting-notes hidden-sm-down"><?php echo $row_taplist['note'];?></p>
				</div>
				<div class="abv col-2 <?php if ($show_abv_col == 0) echo 'no-show';?>">
					<h3><?php echo $kCal;?> kCal</h3>
					<div class="abv-container hidden-sm-down <?php if ($show_abv_img == 0) echo 'no-show';?>">
						<div class="abv-indicator">
							<div class="abv-full" style="height: <?php echo $abv_img ?>%"></div>
						</div>
					</div>
					<h3><?php echo $abv; ?> ABV</h3>
				</div>
			</div>
			<?php } while ($row_taplist = $taplist->fetch(PDO::FETCH_ASSOC)); ?>
		</div>
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