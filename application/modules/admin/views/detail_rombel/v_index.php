<?php
    if($this->logged_level !== "3"){ ?>
        <div class="form-group row mt-10">
            <label for="filter_sekolah" class="col-md-2 col-form-label">Sekolah</label>
            <div class="col-sm-10">
                <select id="filter_sekolah" name="filter_sekolah" class="form-control select2" required>
                <option value="ALL" selected>Tampilkan Semua Sekolah</option>
                    <?php foreach($sekolah as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
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
<?php    } ?>

<div class="table-responsive mb-4 mt-4">
    <table id="table-detail-rombel" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Sekolah</th>
                <th style="vertical-align: middle;">Rombel</th>
                <th style="vertical-align: middle;">Wali Kelas</th>
                <th style="vertical-align: middle;">Jumlah Siswa</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-detail-rombel';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_sekolah = $('[name="filter_sekolah"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nama_sekolah", "sClass": "text-nowrap"},
                {"data": "nama_rombel", "sClass": "text-nowrap"},
                {"data": "nama_guru", "sClass": "text-nowrap"},
                {"data": "jumlah_siswa", "sClass": "text-nowrap"},
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