<div class="table-responsive mb-4 mt-4">
    <table id="table-pendataan-pelaku" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Nama Pelaku Usaha</th>
                <th style="text-align: center; vertical-align: middle;">Bidang</th>
                <th style="text-align: center; vertical-align: middle;">Kuesioner</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-pendataan-pelaku';
        let id ='<?= encrypt_url($id, $id_key) ?>';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet/') ?>" + id;

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_pelaku", searchable:false, orderable:false},
                {"data": "bidang", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "total", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

    });


</script>