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
    <table id="table-kgb" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">#</th> 
                <th>_Nip</th>
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

<!-- <div class="modal fade" id="<?= $modal_name ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Form Ajukan Kenaikan Gaji Berkala</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?>
                <input class="form-control custom-form" type="hidden" name="type" id="type" value="add" />
                <input type="hidden" class="kgb-token-response" name="kgb-token-response">
                <input type="hidden" name="guru_id" id="guru_id" class="form-control custom-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="berkas">Berkas Ajukan Kenaikan Gaji Berkala <?= label_required() ?><br><span class="text-muted font-10" style="font-size: 12px;">(Maksimal 1MB. Format yang didukung: .pdf)</span></label>
                        <input type="file" data-plugins="dropify" name="berkas" id="berkas" data-max-file-size="1M" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit-btn" class="btn btn-primary mr-2">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="icon-paper-plane mr-2" id="icon-button"></i><span id="button-value">Simpan</span>
                    </button>
                    
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="mdi mdi-cancel mr-1"></i> Batal</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div> -->

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-kgb';

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
    });

   
</script>