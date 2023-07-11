<div class="form-group row mt-10">
    <label for="filter_kecamatan" class="col-md-2 col-form-label">Kecamatan</label>
    <div class="col-sm-10">
        <select id="filter_kecamatan" name="filter_kecamatan" class="form-control select2" data-search="false" required>
        <option value="ALL" selected>Tampilkan Semua Kecamatan</option>
            <?php foreach($kecamatan as $row): ?>
                <option value="<?= encrypt_url($row->kecamatan_id, $id_key) ?>"><?= $row->nama_kecamatan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row mt-10">
    <label for="filter_tipe_sekolah" class="col-md-2 col-form-label">Tingkatan Sekolah</label>
    <div class="col-sm-10">
        <select id="filter_tipe_sekolah" name="filter_tipe_sekolah" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua Tingkatan</option>
            <?php foreach($tipe_sekolah as $row): ?>
                <option value="<?= $row->tipe_sekolah ?>"><?= $row->tipe_sekolah ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_status_sekolah" class="col-md-2 col-form-label">Status Sekolah</label>
    <div class="col-sm-10">
        <select id="filter_status_sekolah" name="filter_status_sekolah" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua Status</option>
            <option value="Swasta">Swasta</option>
            <option value="Negeri">Negeri</option>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_akreditasi" class="col-md-2 col-form-label">Akreditasi</label>
    <div class="col-sm-10">
        <select id="filter_akreditasi" name="filter_akreditasi" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua Akreditasi</option>
            <option value="A">A - Unggul</option>
            <option value="B">B - Baik</option>
            <option value="C">C - Cukup Baik</option>
            <option value="TT">TT - Tidak Terakreditasi</option>
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
    <table id="table-sekolah" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Tingkat</th>
                <th style="vertical-align: middle;">Nama Sekolah</th>
                <th style="vertical-align: middle;">NPSN</th>
                <th class="text-center">Status Sekolah <hr class="m-0">Kepemilikan</th>                
                <th class="text-center">SK Pendirian - Tgl SK<hr class="m-0">SK Izin - Tgl SK</th>                
                <th class="text-center">Akreditasi <hr class="m-0">Kurikulum</th>                
                <th style="vertical-align: middle;">Alamat</th>
                <th style="vertical-align: middle;">Link</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-sekolah';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_kecamatan = $('[name="filter_kecamatan"]').val();
                data.filter_tipe_sekolah = $('[name="filter_tipe_sekolah"]').val();
                data.filter_status_sekolah = $('[name="filter_status_sekolah"]').val();
                data.filter_akreditasi = $('[name="filter_akreditasi"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "tipe_sekolah"},
                {"data": "nama_sekolah"},
                {"data": "npsn"},
                {"data": "status_sekolah_kepemilikan", searchable:false, orderable:false},
                {"data": "sk", searchable:false, orderable:false},
                {"data": "akre", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "alamat", searchable:false, orderable:false},
                {"data": "link", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"},
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