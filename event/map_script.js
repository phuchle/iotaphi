(function(window, google))
{
	//map options
	var options = {

		center: { 
			lat: 37.88899,
			long: -12.66
		},

		zoom: '10'

	},

	element = documents.getElementById('map-canvas'),
	//the map itself
	map = new google.maps.Map(element, options);

}(window, google));