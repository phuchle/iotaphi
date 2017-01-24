// just do it in PHP and store it lmao????

function activatePositiveHours(checked, positiveHours) {	
	positiveHours.disabled = checked;
}

function calculateServiceHours(positiveHours, reportedHours, totalHours) {
	if (positiveHours === "") { return totalHours.value = ""; }
	var reportedHours = document.getElementById(reportedHours).value;
	var totalHours = document.getElementById(totalHours);

	if (!totalHours.disabled && positiveHours != "") {
		totalHours.value = reportedHours - positiveHours;
	}	
}

function clearDisabledInput(totalInput, positiveInput) {
	var totalHours = document.getElementById(totalInput);
	var positiveHours = document.getElementById(positiveInput);

	if (totalHours.disabled) {
		totalHours.value = "";
		positiveHours.value = "";
	}
}

