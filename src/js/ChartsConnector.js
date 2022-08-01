import Chart from 'chart.js';
import ProgressBar from 'progressbar.js'
import Datamap from 'datamaps';
import { formatDataToMap, exampleMapData } from './helpers/mapHelper.js';

/**
 * Common class for connecting charts on page
 */
class ChartsConnector {
	constructor() {
		this.chartJs();
		this.progressBarJs()
		this.datamaps();
	}
	
	/**
	 * High Order Function for getting HTML container
	 * 
	 * @param  {string}   selector [description]
	 * @param  {Function} callback [description]
	 * @return {void}
	 */
	getChart(selector, callback) {
		const chart = document.querySelector(selector);

		if (chart) 
			callback(chart);
	}

	// Chart.js docs: 
	// https://www.chartjs.org/docs/latest/
	chartJs() {
		this.getChart('#chartJs1', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
			        datasets: [{
			            data: [12, 15, 3, 5, 2, 3, 10],
			            fill: true,
			            backgroundColor: '#cde0ff',
			            borderColor: '#3884ff',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
			    	legend: {
		    	        display: false
		    	    },
			        scales: {
			            xAxes: [{
			            	display: false
	                    }],
			            yAxes: [{
			            	display: false
	                    }]
		            }
			    }
			});
		})

		this.getChart('#chartJs2', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'sunday'],
			        datasets: [{
			            data: [7, 10, 5, 1, 19, 5, 4],
			            backgroundColor: '#cef0cd',
			            borderColor: '#38c12f',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
			    	legend: {
		    	        display: false
		    	    },
			        scales: {
			            xAxes: [{
			            	display: false
	                    }],
			            yAxes: [{
			            	display: false
	                    }]
		            }
			    }
			});
		});

		this.getChart('#chartJs3', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'sunday'],
			        datasets: [{
			            data: [1, 7, 3, 5, 7, 12, 10],
			            backgroundColor: '#fce0cb',
			            borderColor: '#f48423',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
			    	tooltips: {
			    	  	mode: 'index',
			    	  	intersect: false,
			    	},
			    	legend: {
		    	        display: false
		    	    },
			        scales: {
			            xAxes: [{
			            	display: false
	                    }],
			            yAxes: [{
			            	display: false
	                    }]
		            }
			    }
			});
		});

		this.getChart('#chartJs4', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'sunday'],
			        datasets: [{
			            data: [7, 6, 4, 8, 9, 4, 12],
			            backgroundColor: '#eec6c9',
			            borderColor: '#ba1823',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
			    	tooltips: {
			    	  	mode: 'index',
			    	  	intersect: false,
			    	},
			    	legend: {
		    	        display: false
		    	    },
			        scales: {
			            xAxes: [{
			            	display: false,
	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0)'
	                        },
	                        ticks: {
	                            display: false
	                        }
	                    }],
			            yAxes: [{
			            	display: false,
	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0)'
	                        },
	                        ticks: {
	                            display: false
	                        }
	                    }]
		            }
			    }
			});
		})

		this.getChart('#areaChartJs', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'sunday'],
			        datasets: [{
			        	label: 'Sales',
			            data: [8, 5, 9, 4, 5, 7, 4],
			            backgroundColor: 'rgba(56, 132, 255, 0.8)',
			            borderColor: 'rgba(56, 132, 255, 1)',
			            pointBackgroundColor: 'rgba(56, 132, 255, 1)',
			            borderWidth: 3,
			            pointRadius: 3,
			        },{
			        	label: 'Clients',
			            data: [7, 6, 10, 6, 7, 7, 5],
			            backgroundColor: 'rgba(205, 224, 255, 0.8)',
			            borderColor: 'rgba(205, 224, 255, 1)',
			            pointBackgroundColor: 'rgba(205, 224, 255, 1)',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
		    	    tooltips: {
		    	      	mode: 'index',
		    	      	intersect: false,
		    	    },
			        scales: {
			            xAxes: [{

	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0)'
	                        },
	                    }],
			            yAxes: [{
	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0.04)'
	                        },
	                    }]
		            }
			    }
			});
		});

		this.getChart('#pieChartJs', chart => {
			new Chart(chart, {
				type: 'pie',
			    data: {
			        labels: ['Chrome', 'Firefox', 'Opera', 'IE', 'Other'],
			        datasets: [{
			            data: [75, 16, 5, 3, 2],
			            backgroundColor: [
			            	'rgba(56, 132, 255, 0.8)', 
			            	'rgba(66, 185, 255, 0.8)',
			            	'rgba(56, 193, 47, 0.8)', 
			            	'rgba(245, 132, 35, 0.8)',
			            	'rgba(186, 24, 35, 0.8)',
			            ],
			            borderWidth: 3,
			            pointRadius: 3,
			        }]
			    },
			    options: {
			    	// responsive: false,
			    	legend: {position: 'right'},
		    	    tooltips: {
		    	      	callbacks: {
		    	      	    label: function(tooltipItem, data) {
								const dataset = data.datasets[tooltipItem.datasetIndex];
								const total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
									return previousValue + currentValue;
								});
								const currentValue = dataset.data[tooltipItem.index];
								const percentage = Math.floor(((currentValue/total) * 100)+0.5);
								const placeholder = data.labels[tooltipItem.index];

								return `${placeholder} ${percentage}%`;
		    	      	    }
		    	      	}
		    	    },
			        scales: {
			            xAxes: [{
	                        display: false
	                    }],
			            yAxes: [{
			            	display: false
	                    }]
		            }
			    }
			});
		})

		this.getChart('#lineChartJs', chart => {
			new Chart(chart, {
				type: 'line',
			    data: {
			        labels: ['Sep, 15', 'Sep, 16', 'Sep, 17', 'Sep, 18', 'Sep, 19', 'Sep, 20', 'Sep, 21'],
			        datasets: [{
			        	label: 'Sales',
			            data: [3, 10, 15, 14, 16, 12, 17],
			            backgroundColor: 'rgba(0,0,0,0)',
			            borderColor: 'rgba(56, 132, 255, 1)',
			            pointBackgroundColor: 'rgba(56, 132, 255, 1)',
			            borderWidth: 3,
			            pointRadius: 3,
			        },{
			        	label: 'Refunds',
			            data: [0, 1, 0, 0, 2, 0, 0],
			            backgroundColor: 'rgba(0,0,0,0)',
			            borderColor: 'rgba(186, 24, 35, 1.000)',
			            pointBackgroundColor: 'rgba(186, 24, 35, 1.000)',
			            borderWidth: 2,
			            pointRadius: 2
			        }]
			    },
			    options: {
		    	    tooltips: {
		    	      	mode: 'index',
		    	      	intersect: false,
		    	    },
			        scales: {
			            xAxes: [{

	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0)'
	                        },
	                    }],
			            yAxes: [{
	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0.04)'
	                        },
	                    }]
		            }
			    }
			});
		})

		this.getChart('#barChartJs', chart => {
			new Chart(chart, {
				type: 'bar',
			    data: {
			        labels: ['Sep, 15', 'Sep, 16', 'Sep, 17', 'Sep, 18', 'Sep, 19', 'Sep, 20', 'Sep, 21'],
			        datasets: [{
			        	label: 'Visits',
			            data: [90, 95, 97, 105, 84, 85, 91],
			            backgroundColor: 'rgba(205, 224, 255, 1.000)',
			            borderColor: 'rgba(205, 224, 255, 1.000)',
			            borderWidth: 2
			        },{
			        	label: 'Clients',
			            data: [35, 10, 71, 45, 19, 17, 51],
			            backgroundColor: 'rgba(56, 193, 47, 1)',
			            borderColor: 'rgba(56, 193, 47, 1.000)',
			            borderWidth: 2
			        }]
			    },
			    options: {
		    	    tooltips: {
		    	      	mode: 'index',
		    	      	intersect: false,
		    	    },
			        scales: {
			            xAxes: [{

	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0)'
	                        },
	                    }],
			            yAxes: [{
	                        gridLines: {
	                            color: 'rgba(0, 0, 0, 0.04)'
	                        },
	                    }]
		            }
			    }
			});
		});
	}

	// ProgressBar.js docs: 
	// http://progressbarjs.readthedocs.org/en/1.0.0/
	progressBarJs() {
		console.log(new ProgressBar.Shape);
		this.getChart('#barChart1', chart => {
			var bar = new ProgressBar.Line(chart, {
				strokeWidth: 2,
			  	easing: 'easeInOut',
			  	duration: 1400,
			  	color: '#3884ff',
			  	trailColor: '#f5f7f9',
			  	trailWidth: 2,
			  	strokeWidth: 2,
			  	svgStyle: {width: '100%', height: '100%', borderRadius: '5px'}
			});
			bar.animate(0.97);
		});

		this.getChart('#barChart2', chart => {
			var bar = new ProgressBar.Line(chart, {
				strokeWidth: 2,
			  	easing: 'easeInOut',
			  	duration: 1400,
			  	color: '#38c12f',
			  	trailColor: '#f5f7f9',
			  	trailWidth: 2,
			  	svgStyle: {width: '100%', height: '100%', borderRadius: '5px'}
			});
			bar.animate(0.5);
		});	

		this.getChart('#barChart3', chart => {
			var bar = new ProgressBar.Line(chart, {
				strokeWidth: 2,
			  	easing: 'easeInOut',
			  	duration: 1400,
			  	color: '#f58423',
			  	trailColor: '#f5f7f9',
			  	trailWidth: 2,
			  	svgStyle: {width: '100%', height: '100%', borderRadius: '5px'},
			});
			bar.animate(0.25);
		});		

		this.getChart('#circleChart1', chart => {
			var bar = new ProgressBar.Circle(chart, {
				color: '#3884ff',
				strokeWidth: 20,
				trailWidth: 7,
				easing: 'easeInOut',
				duration: 1400,
				from: { color: '#3884ff', width: 7 },
				to: { color: '#3884ff', width: 7 },
				step: function(state, circle) {
					circle.path.setAttribute('stroke', state.color);
					circle.path.setAttribute('stroke-width', state.width);
					var value = Math.round(circle.value() * 100);
					if (value === 0) {
						circle.setText('');
					} else {
						circle.setText(value);
					}

				}
			});
			bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
			bar.text.style.fontSize = '24px';
			bar.animate(0.75);
		})

		this.getChart('#circleChart2', chart => {
			var bar = new ProgressBar.Circle(chart, {
				color: '#38c12f',
				strokeWidth: 20,
				trailWidth: 7,
				easing: 'easeInOut',
				duration: 1400,
				from: { color: '#38c12f', width: 7 },
				to: { color: '#38c12f', width: 7 },
				step: function(state, circle) {
					circle.path.setAttribute('stroke', state.color);
					circle.path.setAttribute('stroke-width', state.width);
					var value = Math.round(circle.value() * 100);
					if (value === 0) {
						circle.setText('');
					} else {
						circle.setText(value);
					}

				}
			});
			bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
			bar.text.style.fontSize = '24px';
			bar.animate(0.50);
		})

		this.getChart('#circleChart3', chart => {
			var bar = new ProgressBar.Circle(chart, {
				color: '#f58423',
				strokeWidth: 20,
				trailWidth: 7,
				easing: 'easeInOut',
				duration: 1400,
				from: { color: '#f58423', width: 7 },
				to: { color: '#f58423', width: 7 },
				step: function(state, circle) {
					circle.path.setAttribute('stroke', state.color);
					circle.path.setAttribute('stroke-width', state.width);
					var value = Math.round(circle.value() * 100);
					if (value === 0) {
						circle.setText('');
					} else {
						circle.setText(value);
					}

				}
			});
			bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
			bar.text.style.fontSize = '24px';
			bar.animate(0.25);
		})
	}

	// Datamaps docs:
	// https://github.com/markmarkoh/datamaps/
	datamaps() {
		this.getChart('#vectorMap', map => {
			const mapData = formatDataToMap(exampleMapData);
			new Datamap({
				element: map,
				fills: {
		            HIGH: 'rgba(56, 132, 255, 1)',
		            MEDIUM: 'rgba(56, 132, 255, 0.75)',
		            LOW: 'rgba(56, 132, 255, 0.5)',
		            UNKNOWN: 'rgb(0,0,0)',
		            defaultFill: 'rgba(200, 205, 210, 1.000)'
		        },
		        data: mapData,
		        geographyConfig: {
	                popupTemplate: function(geo, data) {
	                    return ['<div class="hoverinfo"><strong>',
	                            `${geo.properties.name}: ${data.visitors} visitors`,
	                            '</strong></div>'].join('');
	                }
	            }
			})
		});
	}
}

export default ChartsConnector;