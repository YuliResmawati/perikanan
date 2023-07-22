<div class="form-group row mt-10">
    <label for="filter_hari" class="col-md-2 col-form-label">Hari</label>
    <div class="col-sm-10">
        <select id="filter_hari" name="filter_hari" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua Jenis</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
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
    <table id="table-jadwal" class="table table-striped w-100">
        <thead>
            <tr>
            <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Mata Pelajaran</th>
                <th style="vertical-align: middle;">Guru</th>
                <th style="vertical-align: middle;">Durasi (Menit)</th>
                <th style="vertical-align: middle;">Jadwal</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-jadwal';
        let id ='<?= encrypt_url($id, $id_key) ?>';

        url_get_data = "<?= base_url($uri_mod.'/AjaxGetJadwal/list/') ?>" + id;

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_hari = $('[name="filter_hari"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nama_mapel", "sClass": "text-nowrap"},
                {"data": "nama_guru", "sClass": "text-nowrap"},
                {"data": "lama_pembelajaran", "sClass": "text-nowrap"},
                {"data": "jadwal_format", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"}
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
                url: "<?= base_url($uri_mod.'/AjaxDelJadwal/')?>" + $(this).attr('data-id'),
                table: oTable,
            };
            
            btn_confirm_action(aOption);
        });

        $(document).on("click", ".button-status", function (e) {
            e.preventDefault();
            aOption = {
                title: "Ubah status?",
                message: "Yakin ingin ubah status data?",
                url: "<?= base_url($uri_mod.'/AjaxActiveJadwal/')?>" + $(this).attr('data-id'),
                table: oTable,
            };

            btn_confirm_action(aOption);
        });

    });

</script>