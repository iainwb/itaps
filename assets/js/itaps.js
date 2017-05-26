function submitKegEdit()
	{
	document.getElementById('keg-edit').submit();
	}

function submitKegNew()
	{
	document.getElementById('keg-new').submit();
	}
			
function submitDeleteKeg()
	{
	document.getElementById('keg-delete').submit();
	}

function submitKegProcess()
	{
	var tap_id = document.getElementById('list-tap-id').value;
	$('.keg-process .tap-id').val(tap_id);
	document.getElementById('keg-process').submit();
	}
						 						 
// Get keg_id from Keg buttons & send to Hidden Inputs 						 
	$(document).ready(function() {
	$('.keg-process').click(function() {
	var keg_id = $(this).data('keg_id');
	var action = $(this).data('action');
		
	$('.keg-process .keg-id').val(keg_id);
	$('.keg-process .action').val(action);
		
	$('.keg-edit .keg-id').val(keg_id);
	$('.keg-edit .action').val(action);
	})
	});

   	
function submitBeerEdit()
   {
   document.getElementById('beer-edit').submit();
   }
   		
function submitBeerNew()
   {
   document.getElementById('beer-new').submit();
   }
   
function submitBeerProcess()
   {
   document.getElementById('beer-process').submit();
   }

function submitBeerImport()
  	{
  	document.getElementById('beer-import').submit();
  	}
  	
  	
  	// Get beer_id from beer buttons & send to Hidden Inputs 						 
  	$(document).ready(function(){
  	$('.beer-process').click(function () {
  	 var beer_id = $(this).data('beer_id');
  	 var action = $(this).data('action');
  	   
  	 $('.beer-process .beer-id').val(beer_id);
  	 $('.beer-process .action').val(action);
  	 
  	 $('.beer-edit .beer-id').val(beer_id);
  	 $('.beer-edit .action').val(action);
  		})
  		});	
  	