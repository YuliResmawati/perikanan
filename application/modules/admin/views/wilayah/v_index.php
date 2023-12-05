wilayah<div class="table-responsive mb-4 mt-4">
    <table id="table-kecamatan" class="table table-striped w-100">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Kecamatan</th>
                <th>Nama Kecamatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script type="text/javascript">

    $(document).ready(function() {
        table_name = '#table-kecamatan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            columns: [
                {"data": "kode", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "id", searchable:true, orderable:true,  "sClass": "text-nowrap"},
                {"data": "nama_kecamatan"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap"}
            ]
        }

        oTable = intiate_datatables(datatables);

    });

</script>