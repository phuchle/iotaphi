function createResponsiveTableHeaders() {
	var headertext = [];
	var tableHeaders = document.querySelectorAll(".show-table th");
	var tablebody = document.querySelectorAll(".show-table tbody");

	collectTableHeaders(headertext, tableHeaders);

	for (var tableCount = 0; tableCount < tablebody.length; tableCount++) {
		for (var i = 0, row; row = tablebody[tableCount].rows[i]; i++) {
			for (var j = 0, col; col = row.cells[j]; j++) {
				col.setAttribute("data-th", headertext[j]);
			}
		}
	}

}

function collectTableHeaders(headertext, tableHeaders) {
	for(var i = 0; i < tableHeaders.length; i++) {
		var current = tableHeaders[i];
		headertext.push( current.textContent.replace( /\r?\n|\r/,"") );
	}
}

createResponsiveTableHeaders();
