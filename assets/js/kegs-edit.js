function submitEditKeg()
{
document.getElementById('hiddenAction').value = "edit";
document.getElementById("kegsEdit").submit();
}
		
function submitNewKeg()
{
document.getElementById("kegsNew").submit();
}
			
function submitDeleteKeg()
{
document.getElementById("deleteKeg").submit();
}