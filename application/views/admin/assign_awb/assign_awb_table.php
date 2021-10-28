<div class="example-wrap">
    <h4 class="example-title">Assign Airwaybill To customer</h4>
    <button type="button" style="float: right;" id="export"
        class="btn btn-primary waves-effect waves-classic">Excel</button>
        <input type="hidden" name="api_name" id="api_name" value="<?= @$api_name; ?>">
    <div class="example">
        <table class="table table-hover" data-plugin="selectable" data-row-selectable="true" id="assing_awb_number">
            <thead>
                <tr>
                    <th  rowspan="1" colspan="1" style="width: 12.984px" aria-label="">
                    <input type="checkbox" class="select-item" id="select_all" value="1" style="margin-left:135px"></th>
                    <th>Airwaybill Number</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    // $(document).delegate('#assign_awb_btn', 'click', function() {
        var hiddenURL = $('#hiddenURL').val();
        var api_name = $('#api_name').val();
        $("#assing_awb_number").DataTable({
            "serverSide": true,
            "pageLength": 100,
            "lengthMenu": [
                [100, 500, 1000, -1],
                [100, 500, 1000, "All"]
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],
            "order": [
                [1, "desc"]
            ],
            
            "ajax": {
                "url": hiddenURL + 'assign_awb_list/'+api_name,
            },
            "language": {
                "infoFiltered": "",
            },
            
        
    });
});
</script>