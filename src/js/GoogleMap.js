class GoogleMap {
	constructor() {
		this.styles = [
		    {
		        "stylers": [
		            {
		                "hue": "#007fff"
		            },
		            {
		                "saturation": 89
		            }
		        ]
		    },
		    {
		        "featureType": "water",
		        "stylers": [
		            {
		                "color": "#ffffff"
		            }
		        ]
		    },
		    {
		        "featureType": "administrative.country",
		        "elementType": "labels",
		        "stylers": [
		            {
		                "visibility": "off"
		            }
		        ]
		    }
		];

		this.getMapContainer('#map', this.defaultMap);
	}

	/**
	 * High Order Function for getting HTML container
	 * 
	 * @param  {string}   selector [description]
	 * @param  {Function} callback [description]
	 * @return {void}
	 */
	getMapContainer(selector, callback) {
		const element = document.querySelector(selector);

		if (element) 
			callback(element);
	}

	/**
	 * Initializing default map
	 * 
	 * @param  {Object}   DOM node
	 * @return {void}
	 */
	defaultMap = (element) =>{
		const mapOptions = {
			center: {lat: 55.754391, lng: 37.611562},
			zoom: 16,
			disableDefaultUI: true,
			styles: this.styles
		}

		const map = new google.maps.Map(element, mapOptions);
	}
}

export default GoogleMap;
