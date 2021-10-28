var hiddenURL = $('#hiddenURL').val();

$("#logisctic_table").DataTable({
	"serverSide": true,

	"ajax": {
		"url": hiddenURL + 'loadlogistic',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"url": ""

	}],
});

$("#rule_table").DataTable({
	"ordering": [
		[2, "asc"]
	],
	"serverSide": true,

	"ajax": {
		"url": hiddenURL + 'loadrule',
	},
	"language": {
		"infoFiltered": "",
	}
});
