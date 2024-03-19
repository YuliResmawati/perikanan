<div class="form-group row mt-10 ">
    <label for="tahun" class="col-sm-2 col-form-label">Pilih Tahun</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="tahun" id="tahun">
            <?php $no = 1; foreach($tahun as $row): ?>
                <option value="<?= encrypt_url($row->tahun, $id_key) ?>"><?= $no. ' - ' .$row->tahun ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-icon  btn-primary" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <button type="button" class="btn btn-danger" id="cetak">
            <i class="icon-printer"></i> Cetak</a>
        </button>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>
<div class="table-responsive mb-4 mt-4">
    <table id="table-panel-ikan" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Komoditas</th>
                <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                <th style="text-align: center; vertical-align: middle;">Harga Eceran</th>
                <th style="text-align: center; vertical-align: middle;">Volume(Kg)</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-panel-ikan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_tahun = $('[name="tahun"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "komoditas", searchable:false, orderable:false},
                {"data": "tanggal", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "harga", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "volume", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }
        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

    });

    $(document).on("click", '#cetak', function(e) {
        e.preventDefault();

        let base_url = '<?= base_url($uri_mod) ?>';
        newWindow = window.open(base_url + '/report/' + $('#tahun').val(),
            "open", 'height=600,width=800');
        if (window.focus) {
            newWindow.focus()
        }

        return false;
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