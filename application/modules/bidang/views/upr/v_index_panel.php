<div class="table-responsive mb-4 mt-4">
    <table id="table-panel-upr" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Komoditas</th>
                <th style="text-align: center; vertical-align: middle;">Jumlah UPR(Unit)</th>
                <th style="text-align: center; vertical-align: middle;">luas Lahan(Ha)</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-panel-upr';
        let id ='<?= encrypt_url($id, $id_key) ?>';

        url_get_data = "<?= base_url($uri_mod.'/AjaxGetPanel/list/') ?>" + id;

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "komoditas", searchable:false, orderable:false},
                {"data": "jumlah_upr", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "luas_lahan", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }
        oTable = intiate_datatables(datatables);

    });

    $(document).on("click", ".button-hapus", function (e) {
        e.preventDefault();
        aOption = {
            title: "Hapus Data?",
            message: "Yakin ingin hapus data?",
            url: "<?= base_url($uri_mod.'/AjaxDel/')?>" + $(this).attr('data-id'),
            table: oTable,
        };
        
        btn_confirm_action(aOption);
    })

    $(document).on("click", ".button-status", function (e) {
        e.preventDefault();
        aOption = {
            title: "Ubah status?",
            message: "Yakin ingin ubah status data?",
            url: "<?= base_url($uri_mod.'/AjaxActive/')?>" + $(this).attr('data-id'),
            table: oTable,
        };

        btn_confirm_action(aOption);
    });

</script>