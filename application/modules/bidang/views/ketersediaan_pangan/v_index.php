<div class="form-group row mt-10 ">
    <label for="bulan" class="col-sm-2 col-form-label">Pilih Tahun</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="bulan" id="bulan">
            <?php $no = 1; foreach($bulan as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->bulan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div><div class="form-group row mt-10 ">
    <label for="tahun" class="col-sm-2 col-form-label">Pilih Tahun</label>
    <div class="col-sm-10">
    <select id="tahun" name="tahun" class="form-control select2" required>
            <!-- <option selected="selected" disabled>Pilih Tahun</option> -->
            <?php for($i=2024; $i <= date('Y')+1; $i++) {?>
                <option value="<?= encrypt_url($i, $id_key) ?>"><?= $i ?></option>
            <?php } ?>
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
    <table id="table-ketersediaan" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Nama Kecamatan</th>
                <th style="text-align: center; vertical-align: middle;">Luas Tanam Padi</th>
                <th style="text-align: center; vertical-align: middle;">Luas Puso Padi</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-ketersediaan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.tahun= $('[name="tahun"]').val();
                data.bulan= $('[name="bulan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_kecamatan", searchable:false, orderable:false},
                {"data": "luas_tanam_padi", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "luas_puso_padi", searchable:false, orderable:false, "sClass": "text-center align-middle"},
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
        newWindow = window.open(base_url + '/report/' + $('#bulan').val() + '/' + $('#tahun').val(),
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