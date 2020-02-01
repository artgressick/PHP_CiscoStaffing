document.write('<script type="text/javascript" src="'+ BF + 'includes/forms.js"></script>');
var totalErrors = 0;
function error_check() {
	if(totalErrors != 0) { reset_errors(); }  
	
	totalErrors = 0;

		if(errEmpty('idZone', "You must select a Zone.")) { totalErrors++; }
		if(errEmpty('idStation', "You must select a Station.")) { totalErrors++; }
		if(errEmpty('idMarcomLead', "You must select a Marcom Lead.")) { totalErrors++; }
		
	return (totalErrors == 0 ? true : false);
}