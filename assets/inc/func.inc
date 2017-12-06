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
	
	
if ($pagename == 'kegs' || $pagename == 'kegs-edit') $activeSection = 
  	   	  '<li class="nav-item active"><a class="nav-link" href="kegs.php">Kegs</a></li>
            <li class="nav-item"><a class="nav-link" href="beers.php">Beers</a></li>
            <li class="nav-item"><a class="nav-link" href="taplist.php?preview=yes">Taplist Preview</a></li>
            ';
	
elseif
	($pagename == 'beers' || $pagename == 'beers-edit') $activeSection =  
			'<li class="nav-item"><a class="nav-link" href="kegs.php">Kegs</a></li>
            <li class="nav-item active"><a class="nav-link" href="beers.php">Beers</a></li>
            <li class="nav-item"><a class="nav-link" href="taplist.php?preview=yes">Taplist Preview</a></li>
            ';
	
elseif
	($pagename == 'taplist') $activeSection =  
			'<li class="nav-item"><a class="nav-link" href="kegs.php">Kegs</a></li>
            <li class="nav-item"><a class="nav-link" href="beers.php">Beers</a></li>
            <li class="nav-item active"><a class="nav-link" href="taplist.php?preview=yes">Taplist Preview</a></li>
            ';
	
else ($activeSection = 
	  		'<li class="nav-item"><a class="nav-link" href="kegs.php">Kegs</a></li>
            <li class="nav-item"><a class="nav-link" href="beers.php">Beers</a></li>
            <li class="nav-item"><a class="nav-link" href="taplist.php?preview=yes">Taplist Preview</a></li>
            
            ');

echo $activeSection;
}

//Set tap/kick button
function tapKick($status, $tapKick) {
	if ($status == "Tapped")
		 echo'<button type="button" class="btn btn-primary">Kick Keg</button>';
	elseif ($status == "On Deck")
		echo'<button type="button" class="btn btn-primary">Tap Keg</button>	';
	else echo'&nbsp;';
}

//Test form input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function new_button($pagename){
	
	if($pagename == 'beers'){
    echo '<button type="button" class="btn new btn-primary" onclick="submitBeerNew()">New Beer</button>';
    
}elseif ($pagename == 'kegs'){
    echo '<button type="button" class="btn new btn-primary" onclick="submitKegNew()">New Keg</button>';
    	}
	else{ echo '';}
}

   // Set status type color
   
   function statusColor($status_code, $color)
   	{
   	if ($status_code == "Tapped") echo ('card-success');
   	elseif ($status_code == "On Deck") echo ('card-info');
		elseif ($status_code == "Empty—Clean") echo ('card-warning');
		elseif ($status_code == "Conditioning") echo ('card-warning');
   	  else echo ('card-danger');
   	return ($color);
   	}
	
?>