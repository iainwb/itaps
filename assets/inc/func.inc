<?php

$rawfilepath = $_SERVER['SCRIPT_FILENAME'];
$filepath_array = explode('/', $rawfilepath);
$arraylen = count($filepath_array);
$dirlevel = $arraylen-2;
$currentdir = $filepath_array[$dirlevel];
$currentsec = $filepath_array[4]; //was 5
$pagename = (basename($rawfilepath, '.php'));
$dirpath_array = array_slice($filepath_array, '0',$arraylen-1);
date_default_timezone_set('America/Chicago');

//Determine ABV
function abv($og, $fg, $abv, $digits = 2) { 
	
	$abv=(76.08 * ($og-$fg) / (1.775-$og)) * ($fg / 0.794);

    //provide the real number, and the number of 
    //digits right of the decimal you want to keep. 

    $shift = pow(10, $digits); 
    return ((floor($abv * $shift)) / $shift); 
}

//Determine kCals
function kCal($og, $fg, $kCal, $digits = 1) {
	
	$kCal = (851 * ($og - 1) * ($og + 3));
	
	//provide the real number, and the number of 
    //digits right of the decimal you want to keep. 

    $shift = pow(10, $digits); 
    return ((floor($kCal * $shift)) / $shift); 
}

//Set links in navbar
function navbar($pagename){	
	
if ($pagename == 'kegs') $activeSection = 
  	   	  '<li><a href="admin.php">Admin</a></li>
            <li class="active"><a href="#">Kegs</a></li>
            <li><a href="beers.php">Beers</a></li>
            <li><a href="taplist.php?preview=yes">Taplist Preview</a></li>';
	
elseif
	($pagename == 'beers') $activeSection =  
			'<li><a href="admin.php">Admin</a></li>
            <li><a href="kegs.php">Kegs</a></li>
            <li class="active"><a href="#">Beers</a></li>
            <li><a href="taplist.php?preview=yes">Taplist Preview</a></li>';
	
elseif
	($pagename == 'admin') $activeSection =  
			'<li class="active"><a href="#">Admin</a></li>
            <li><a href="kegs.php">Kegs</a></li>
            <li><a href="beers.php">Beers</a></li>
            <li><a href="taplist.php?preview=yes">Taplist Preview</a></li>';
	
elseif
	($pagename == 'taplist') $activeSection =  
			'<li><a href="admin.php">Admin</a></li>
            <li><a href="kegs.php">Kegs</a></li>
            <li><a href="beers.php">Beers</a></li>
            <li class="active"><a href="taplist.php?preview=yes">Taplist Preview</a></li>';
	
else ($activeSection = 
	  		'<li><a href="admin.php">Admin</a></li>
            <li><a href="kegs.php">Kegs</a></li>
            <li><a href="beers.php">Beers</a></li>
            <li><a href="taplist.php?preview=yes">Taplist Preview</a></li>');

echo $activeSection;
}

//Choose relevant pull-down menu
function dropdown($pagename){	
	
if ($pagename == 'kegs') $dropdownMenu = '
<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></a>
<ul class="dropdown-menu">
                <li class="dropdown-header">Choose Action</li>
				<li> <a href="#" onclick="submitEditKegRequest()">Edit</a> </li>
                <li><a href="#" onclick="submitNewKegRequest()">Add</a></li>
                <li><a href="#" onclick="submitDeleteKegRequest()">Delete</a></li>
              </ul>';
elseif
	($pagename == 'beers') $dropdownMenu =  '
	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></a>
	<ul class="dropdown-menu">
                <li class="dropdown-header">Choose Action</li>
				 <li><a href="#" onclick="submitEdit()">Edit</a></li>
                <li><a href="#" onclick="submitNew()">Add</a></li>
                <li><a href="beers-delete.php">Delete</a></li>
              </ul>';
elseif
	($pagename == 'admin') $dropdownMenu =  '
	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions<span class="caret"></span></a>
	<ul class="dropdown-menu">
                <li class="dropdown-header">Choose Action</li>
                <li>Noe Available</li>
              </ul>';
elseif
	($pagename == 'taplist-p') $dropdownMenu =  ' ';
else ($dropdownMenu = '<li></li></ul> ');

echo $dropdownMenu;
}


//Set tap/kick button
function tapKick($status, $tapKick) {
	if ($status == "Tapped")
		 echo'			
				
					<button type="button" class="btn btn-primary"  >Kick Keg</button>		
				
			';
	elseif ($status == "On Deck")
		echo'			
				
					<button type="button" class="btn btn-primary" >Tap Keg</button>		
				
			';
	else echo'&nbsp;';
}

//Test from input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}








?>