<div class="form-group row mt-10">
    <label for="filter_guru" class="col-md-2 col-form-label">Guru</label>
    <div class="col-sm-10">
        <select id="filter_guru" name="filter_guru" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Guru</option>
            <?php foreach($guru as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= name_degree($row->gelar_depan,$row->nama_guru,$row->gelar_belakang) ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_status_permohonan" class="col-md-2 col-form-label">Status Permohonan</label>
    <div class="col-sm-10">
        <select id="filter_status_permohonan" name="filter_status_permohonan" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Status Permohonan</option>
            <option value="<?= encrypt_url('0', $id_key) ?>">Menunggu Persetujuan</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Permohonan Disetujui</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Permohonan Diterima</option>
            <option value="<?= encrypt_url('3', $id_key) ?>">Permohonan Dibatalkan</option>
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
    <table id="table-permohonan_cuti" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Guru</th>
                <th style="text-align: center; vertical-align: middle;">Tahun Ajaran</th>
                <th style="text-align: center; vertical-align: middle;">Lama Cuti</th>
                <th style="text-align: center; vertical-align: middle;">File</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-permohonan_cuti';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_guru = $('[name="filter_guru"]').val();
                data.filter_status_permohonan = $('[name="filter_status_permohonan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_guru", "sClass": "text-center align-middle"},
                {"data": "tahun_ajaran", "sClass": "text-center align-middle"},
                {"data": "lama_cuti", "sClass": "text-center align-middle"},
                {"data": "files", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
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