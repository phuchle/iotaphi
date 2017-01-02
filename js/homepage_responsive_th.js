var headertext = [];
var headers = document.querySelectorAll(".show-table th");
var tablebody = document.querySelectorAll(".show-table tbody");

for(var i = 0; i < headers.length; i++) {
	var current = headers[i];
	headertext.push( current.textContent.replace( /\r?\n|\r/,"") );
}

for (var tableCount = 0; tableCount < tablebody.length; tableCount++) {
	for (var i = 0, row; row = tablebody[tableCount].rows[i]; i++) {
		for (var j = 0, col; col = row.cells[j]; j++) {
			col.setAttribute("data-th", headertext[j]);
		}
	}
}