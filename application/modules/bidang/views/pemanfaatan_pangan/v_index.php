<div class="table-responsive mb-4 mt-4">
    <table id="table-pemanfaatan" class="table table-striped w-100">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">#</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Kecamatan</th>
                <th colspan="4" style="text-align: center; vertical-align: middle;">Berat Badan (BB)</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
                
            <tr>
                <th style="text-align: center; vertical-align: middle;">Sangat Kurang</th>
                <th style="text-align: center; vertical-align: middle;">Kurang</th>
                <th style="text-align: center; vertical-align: middle;">Normal</th>
                <th style="text-align: center; vertical-align: middle;">Risiko Lebih</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-pemanfaatan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_kecamatan", searchable:false, orderable:false},
                {"data": "bb_sangat_kurang", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "bb_kurang", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "bb_normal", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "risiko_bb_lebih", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }
        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });
        
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