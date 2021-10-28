$(function () {
    var hiddenurl = $('#hiddenURL').val();
    $("#next_cod_remittance_list_table").DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        "columnDefs": [{
            "targets": [0],
            "searchable": false,
            "orderable": false,
        }],
        "language": {
            "infoFiltered": "",
        },
        "order": [
            [3, "desc"]
        ]
    });
    $("#next_cod_remittance_data_table").DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        "columnDefs": [{
            "targets": [0],
            "searchable": false,
            "orderable": false,
        }],
        "language": {
            "infoFiltered": "",
        },
        "order": [
            [3, "desc"]
        ]
    });
    $(document).delegate('#select_all_cod_remmitance_cus', 'click', function () {
        if ($(this).prop("checked") == true) {
            $('.select_single_cod_remmitance_cus').prop('checked', true);
            $("#submit_cod_remmitance").removeAttr("disabled");
        } else {
            $('.select_single_cod_remmitance_cus').prop('checked', false);
            $("#submit_cod_remmitance").attr("disabled", true);
        }
    });

    $(document).delegate(".select_single_cod_remmitance_cus", "change", function (e) {

        e.stopImmediatePropagation();
        e.preventDefault();
        var all_pro = $("#select_all_cod_remmitance_cus").prop('checked');
        if (all_pro == true) {
            $("#select_all_cod_remmitance_cus").prop('checked', false);
        }
        var check_array = [];
        if ($('#next_cod_remittance_list_table').length > 0) {
            $.each($("input[name='checkbox_cod_remmitance[]']:checked"), function () {
                check_array.push($(this).data('id'));
            });
        }
        if (check_array.length > 0) {
            $("#submit_cod_remmitance").removeAttr("disabled");
        } else {
            $("#submit_cod_remmitance").attr("disabled", true);
        }
    });
    $(document).delegate('#select_all_cod_remmitance_cus_delete', 'click', function () {
        if ($(this).prop("checked") == true) {
            $('.select_single_cod_remmitance_cus_delete').prop('checked', true);
            $("#delete_cod_remmitance").removeAttr("disabled");
        } else {
            $('.select_single_cod_remmitance_cus_delete').prop('checked', false);
            $("#delete_cod_remmitance").attr("disabled", true);
        }
    });
    $(document).delegate(".select_single_cod_remmitance_cus_delete", "change", function (e) {

        e.stopImmediatePropagation();
        e.preventDefault();
        var all_pro = $("#select_all_cod_remmitance_cus_delete").prop('checked');
        if (all_pro == true) {
            $("#select_all_cod_remmitance_cus_delete").prop('checked', false);
        }
        var check_array = [];
        if ($('#next_cod_remittance_data_table').length > 0) {
            $.each($("input[name='checkbox_cod_delete[]']:checked"), function () {
                check_array.push($(this).data('id'));
            });
        }
        if (check_array.length > 0) {
            $("#delete_cod_remmitance").removeAttr("disabled");
        } else {
            $("#delete_cod_remmitance").attr("disabled", true);
        }
    });
});