<div class="form-group row mt-10 ">
    <label for="jenis_ikan" class="col-sm-2 col-form-label">Pilih Jenis Ikan</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="jenis_ikan" id="jenis_ikan">
            <option value="<?= encrypt_url('1', $id_key) ?>" selected>Ikan Laut</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Ikan Air Tawar</option>
        </select>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-icon  btn-primary" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>
<div class="table-responsive mb-4 mt-4">
    <table id="table-pembenihan" class="table table-striped w-100">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">#</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Komoditas</th>
                <th rowspan="2"style="text-align: center; vertical-align: middle;">RTP</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Luas Lahan(Ha)</th>
                <th colspan="2" class="text-nowrap text-center">Jumlah Induk(Ekor) </th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Produksi(Ekor)</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
            <tr>
                <th style="text-align: center; vertical-align: middle;">Jantan</th></th>
                <th style="text-align: center; vertical-align: middle;">Betina</th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-pembenihan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_jenis= $('[name="jenis_ikan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "komoditas", searchable:false, orderable:false},
                {"data": "rtp", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "luas_lahan", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "induk_jantan", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "induk_betina", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "produksi", searchable:false, orderable:false, "sClass": "text-center align-middle"},
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