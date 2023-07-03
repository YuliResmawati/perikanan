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
    <table id="table-users" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Tingkat</th>
                <th style="vertical-align: middle;">Nama Sekolah</th>
                <th style="vertical-align: middle;">Username</th>
                <th class="text-center">Nama Operator <hr class="m-0">Email</th>                
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Reset Password</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-users';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_tipe_sekolah = $('[name="filter_tipe_sekolah"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "tipe_sekolah"},
                {"data": "nama_sekolah", "sClass": "text-nowrap"},
                {"data": "username"},
                {"data": "two_row", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "reset_pass", searchable:false, orderable:false, "sClass": "text-nowrap"},
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
        });

        $(document).on("click", ".button-reset_pass", function (e) {
            e.preventDefault();
            aOption = {
                title: "Reset Password",
                message: "Yakin ingin mereset password akun ini ? Password baru : silatpendidikan_pass",
                url: "<?= base_url($uri_mod.'/AjaxResetPass/')?>" + $(this).attr('data-id'),
                table: oTable,
            };
            
            btn_confirm_action(aOption);
        });

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