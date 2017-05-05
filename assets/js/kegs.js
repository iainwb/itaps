function submitKegEdit() {
	document.getElementById("kegEdit").submit();
}

function submitNewKegRequest() {
	document.getElementById("kegsNew").submit();
}

function submitKegProcess() {
	var tap_id = document.getElementById('listTapId').value;
	$(".kegProcess .tap_id").val(tap_id);
	document.getElementById("kegProcess").submit();
}
						 						 
// Get keg_id from Keg buttons & send to Hidden Inputs 						 
	$(document).ready(function() {
	$(".kegProcess").click(function() {
	var keg_id = $(this).data('keg_id');
	var action = $(this).data('action');
	$(".kegProcess .keg_id").val(keg_id);
	$(".kegProcess .action").val(action);
	$(".kegEdit .keg_id").val(keg_id);
	$(".kegEdit .action").val(action);
	})
	});	