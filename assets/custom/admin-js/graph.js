var hiddenurl = $('#hiddenURL').val();

//------------------------- Spider Chart Start -----------------------------------
$.ajax({
	type: "post",
	url: hiddenurl + 'get_chart_all_order',
	dataType: "json",
	success: function (response) {
		// console.log(response);
		var barChartData = {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [{
				label: "Orders",
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(54, 162, 235)',
					'rgb(255, 205, 86)',
					'rgb(102, 204, 255)',
					'rgb(203, 135, 12)',
					'rgb(220, 20, 60)',
					'rgb(75, 192, 192)',
					'rgb(169, 126, 246)',
					'rgb(255, 228, 196)',
					'rgb(255, 160, 122)',
					'rgb(119, 136, 153)',
				],
				borderWidth: 2,
				data: [response.January, response.February, response.March, response.April, response.May, response.June, response.July, response.August, response.September, response.October, response.November, response.December]
			}, ]
		};

		var myBar = new Chart(document.getElementById("exampleChartjsBar").getContext("2d"), {
			type: 'bar',
			data: barChartData,
			options: {
				responsive: true,
				scales: {
					xAxes: [{
						display: true
					}],
					yAxes: [{
						display: true
					}]
				}
			}
		});
	}
});
//------------------------- end spider chart --------------------------------------------


//------------------------------ Start bar chart  -----------------------------------
// $.ajax({
// 	type: "post",
// 	url: hiddenurl + 'get_chart_get',
// 	dataType: "json",
// 	success: function (response) {
// 		// console.log(response);
// 		var radarChartData = {
// 			labels: ["Created", "In Transit", "OFD", "NDR", "Delivered", "RTO Intransit", "RTO Delivered"],
// 			pointLabelFontSize: 14,
// 			datasets: [{
// 				label: "All",
// 				pointRadius: 4,
// 				borderDashOffset: 2,
// 				backgroundColor: "rgba(98, 168, 234, .15)",
// 				borderColor: "rgba(0,0,0,0)",
// 				pointBackgroundColor: Config.colors("primary", 600),
// 				pointBorderColor: "#fff",
// 				pointHoverBackgroundColor: "#fff",
// 				pointHoverBorderColor: Config.colors("primary", 600),
// 				data: [response.all.created_order_count_result, response.all.intransit_count_result, response.all.ofd_count_result, response.all.ndr_count_result, response.all.delivered_count_result, response.all.rto_intransit_count_result, response.all.rto_delivered_count_result]
// 			}, {
// 				label: "Today",
// 				pointRadius: 4,
// 				borderDashOffset: 2,
// 				backgroundColor: "rgba(250,122,122,0.25)",
// 				borderColor: "rgba(0,0,0,0)",
// 				pointBackgroundColor: Config.colors("red", 500),
// 				pointBorderColor: "#fff",
// 				pointHoverBackgroundColor: "#fff",
// 				pointHoverBorderColor: Config.colors("red", 500),
// 				data: [response.today.created_order_count_result, response.today.intransit_count_result, response.today.ofd_count_result, response.today.ndr_count_result, response.today.delivered_count_result, response.today.rto_intransit_count_result, response.today.rto_delivered_count_result]
// 			}]
// 		};

// 		var myRadar = new Chart(document.getElementById("exampleChartjsRadar").getContext("2d"), {
// 			type: 'radar',
// 			data: radarChartData,
// 			options: {
// 				responsive: true,
// 				scale: {
// 					ticks: {
// 						beginAtZero: true,
// 					}
// 				}
// 			}
// 		});

// 	}
// });
// ---------------------------- End bar chart  --------------------------------------


//------------------------------ Start bar chart  -----------------------------------


$.ajax({
	type: "post",
	url: hiddenurl + 'get_cod_chart',
	dataType: "json",
	success: function (response) {
		// console.log(response);
		var barChartData2 = {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [{
				label: "COD",
				// borderColor: Config.colors("primary", 600),
				borderWidth: 2,
				backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(54, 162, 235)',
					'rgb(255, 205, 86)',
					'rgb(102, 204, 255)',
					'rgb(203, 135, 12)',
					'rgb(220, 20, 60)',
					'rgb(75, 192, 192)',
					'rgb(169, 126, 246)',
					'rgb(255, 228, 196)',
					'rgb(255, 160, 122)',
					'rgb(119, 136, 153)',
				],
				data: [response.January, response.February, response.March, response.April, response.May, response.June, response.July, response.August, response.September, response.October, response.November, response.December]
			}, ]
		};

		var myBar2 = new Chart(document.getElementById("exampleChartjsBar2").getContext("2d"), {
			type: 'pie',
			data: barChartData2,
			options: {
				responsive: true,
			}
		});
	}
});
// ---------------------------- End bar chart  --------------------------------------
