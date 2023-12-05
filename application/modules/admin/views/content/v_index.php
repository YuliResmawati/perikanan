<div class="form-group row mt-4">
    <label for="filter_kategori" class="col-sm-2 col-form-label">Kategori</label>
    <div class="col-sm-10">
        <select id="filter_kategori" name="filter_kategori" class="form-control select2" required>
        <option value="<?= encrypt_url('ALL', $id_key) ?>">TAMPILKAN SEMUA KATEGORI</option>
            <?php $no = 1; foreach($kategori as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>" <?= ($no == 1) ? 'selected' : '' ?>><?= $no. ' - ' .$row->nama_kategori ?></option>
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
    <table id="table-konten" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th>_judul</th>
                <th>_tgl</th>
                <th class="text-nowrap text-center">Judul Konten
                    <hr class="m-0">Tanggal
                </th>
                <th style="text-align: center; vertical-align: middle;">Kategori</th>
                <th style="text-align: center; vertical-align: middle;">Dilihat</th>
                <th style="text-align: center; vertical-align: middle;">Lihat Artikel</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-konten';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_kategori = $('[name="filter_kategori"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "judul_konten","visible": false},
                {"data": "tgl_konten","visible": false},
                {"data": "judul", searchable: false},
                {"data": "nama_kategori", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "hits", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "link", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
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