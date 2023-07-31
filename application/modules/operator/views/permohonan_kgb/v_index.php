<div class="form-group row mt-10">
    <label for="filter_bulan" class="col-md-2 col-form-label">Pilih Bulan</label>
    <div class="col-sm-10">
        <select id="filter_bulan" name="filter_bulan" class="form-control select2" data-search="false" required>
        <option value="#" selected disabled>Pilih Bulan</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Januari</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Februari</option>
            <option value="<?= encrypt_url('3', $id_key) ?>">Maret</option>
            <option value="<?= encrypt_url('4', $id_key) ?>">April</option>
            <option value="<?= encrypt_url('5', $id_key) ?>">Mei</option>
            <option value="<?= encrypt_url('6', $id_key) ?>">Juni</option>
            <option value="<?= encrypt_url('7', $id_key) ?>">Juli</option>
            <option value="<?= encrypt_url('8', $id_key) ?>">Agustus</option>
            <option value="<?= encrypt_url('9', $id_key) ?>">September</option>
            <option value="<?= encrypt_url('10', $id_key) ?>">Oktober</option>
            <option value="<?= encrypt_url('11', $id_key) ?>">November</option>
            <option value="<?= encrypt_url('12', $id_key) ?>">Desember</option>
        </select>
    </div>
</div>


<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-blue" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>

<div class="table-responsive mb-4 mt-4">
    <table id="table-permohonan_kgb" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">#</th> <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th style="vertical-align: middle;">Jenis Kelamin</th>             
                <th style="vertical-align: middle;">Bidang Studi</th>             
                <th style="vertical-align: middle;">Tanggal KGB</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-permohonan_kgb';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_bulan = $('[name="filter_bulan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nip", "visible": false},
                {"data": "nama_guru","visible": false},
                {"data": "nama", searchable: false},
                {"data": "jk", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "bidang_studi_pendidikan", searchable:false, orderable:false},
                {"data": "tanggal", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });


        $(document).on("click", ".button-batal", function (e) {
            e.preventDefault();
            aOption = {
                title: "Batalkan Pengajuan?",
                message: "Yakin ingin membatalkan?",
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
    });
</script>