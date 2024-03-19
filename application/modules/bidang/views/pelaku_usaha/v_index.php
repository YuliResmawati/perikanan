<div class="form-group row mt-10 ">
    <label for="kec" class="col-sm-2 col-form-label">Pilih Kecamatan</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="kec" id="kec">
            <?php $no = 1; foreach($kec as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->nama_kecamatan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10 ">
    <label for="bidang" class="col-sm-2 col-form-label">Pilih Bidang Usaha </label>
    <div class="col-sm-10">
        <select class="form-control select2" name="bidang" id="bidang">
            <option selected disabled>Pilih Bidang Usaha</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Pasca Panen</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Budidaya</option>
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
    <table id="table-pelaku" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Nama Pelaku Usaha</th>
                <th class="text-nowrap text-center">No Telephone
                    <hr class="m-0">Email
                </th>
                <th class="text-nowrap text-center">Jumlah Karyawan
                    <hr class="m-0">Skala Usaha
                </th>
                <th style="text-align: center; vertical-align: middle;">Alamat</th>
                <th style="text-align: center; vertical-align: middle;">status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
                
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-pelaku';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_kec= $('[name="kec"]').val();
                data.filter_bid= $('[name="bidang"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "nama_pelaku", searchable:false, orderable:false, "sClass": "text-nowrap align-middle"},
                {"data": "telp", searchable:false, orderable:false},
                {"data": "jumlah", searchable:false, orderable:false},
                {"data": "alamat", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
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