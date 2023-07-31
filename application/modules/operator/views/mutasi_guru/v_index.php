<div class="form-group row mt-10">
    <label for="filter_tipe" class="col-md-2 col-form-label">Jenis Mutasi</label>
    <div class="col-sm-10">
        <select id="filter_tipe" name="filter_tipe" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua Jenis</option>
            <option value="<?= encrypt_url('0', $id_key) ?>">Mutasi Keluar Kota Bukittinggi</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Mutasi Antar Sekolah di Kota Bukittinggi</option>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_status" class="col-md-2 col-form-label">Status Mutasi</label>
    <div class="col-sm-10">
        <select id="filter_status" name="filter_status" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Status</option>
            <option value="<?= encrypt_url('0', $id_key) ?>">Dalam Proses</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Diterima</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Ditolak</option>
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

<div class="table-responsive mb-4 mt-3">
    <table id="table-mutasi_guru" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th style="text-align: center; vertical-align: middle;">Tipe</th>
                <th style="text-align: center; vertical-align: middle;">Sekolah Asal</th>
                <th class="text-nowrap text-center">Usulan mutasi
                    <hr class="m-0">Sekolah Tujuan
                </th>
                <th style="text-align: center; vertical-align: middle;">Link</th>
                <th style="text-align: center; vertical-align: middle;">Status Usulan</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">

$(document).ready(function() {
    table_name = '#table-mutasi_guru';
    url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

    datatables = {
        table: $(table_name),
        ordering: true,
        url: url_get_data,
        data: function (data){
            data.silatpendidikan_c_token = csrf_value;
            data.filter_tipe = $('[name="filter_tipe"]').val();
            data.filter_status = $('[name="filter_status"]').val();
        }, 
        columns: [
            {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
            {"data": "nip", "visible": false},
            {"data": "nama_guru","visible": false},
            {"data": "nama", searchable: false},
            {"data": "tipe", "sClass": "text-center",searchable: false},
            {"data": "sekolah_awal", "sClass": "text-center",searchable: false},
            {"data": "tujuan", "sClass": "text-center",searchable: false},
            {"data": "link", searchable: false},
            {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
            {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
        ]
    }

    oTable = intiate_datatables(datatables);

    $("#cari").click(function() {
        oTable.ajax.reload();
    });

    $(document).on("click", ".button-hapus", function (e) {
        e.preventDefault();
        aOption = {
            title: "Hapus Data?",
            message: "Yakin ingin hapus data?",
            url: "<?= base_url($uri_mod.'/AjaxDel/')?>" + $(this).attr('data-id'),
            table: oTable,
            data: {
                silatpendidikan_c_token : csrf_value
            },
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
            data: {
                silatpendidikan_c_token: csrf_value
            },
        };

        btn_confirm_action(aOption);
    });

});

</script>