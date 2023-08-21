<div class="form-group row mt-10">
    <label for="filter_sekolah" class="col-md-2 col-form-label">Sekolah Awal</label>
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

<div class="table-responsive mb-4 mt-3">
    <table id="table-verifikasi-kgb" class="table table-striped w-100">
    <thead>
            <tr>
                <th style="vertical-align: middle;">#</th> 
                <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th>_Npsn</th>
                <th>_NamaSekolah</th>
                <th class="text-nowrap text-center">Nama Sekolah
                    <hr class="m-0">NPSN
                </th>
                <th style="vertical-align: middle;">Jenis Kelamin</th>             
                <th style="vertical-align: middle;">Bidang Studi</th>             
                <th style="vertical-align: middle;">Tanggal KGB</th>
                <th style="vertical-align: middle;">File</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<!-- Verifikasi Tolak Modal -->
<div class="modal fade" id="modal-tolak" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Form Tolak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open($uri_mod.'/AjaxTolak', 'id="form-tolak" data-id="" class=""');?>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Alasan Ditolak</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="5" rows="3" placeholder="Alasan Ditolak"></textarea>
                    </div>
                </div>
                <input type="hidden" class="form-control" name="data_verifikasi" id="data_verifikasi">
                <div class="modal-footer">
                    <div id="spinner-status" class="spinner-border spinner-border-sm text-success mr-2"role="status" style="display:none"></div>
                    <button id="submit-btn" type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="mdi mdi-content-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i class="mdi mdi-cancel mr-1"></i> Batal</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function() {
    table_name = '#table-verifikasi-kgb';
    url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

    datatables = {
        table: $(table_name),
        ordering: true,
        url: url_get_data,
        data: function (data){
            data.silatpendidikan_c_token = csrf_value;
            data.filter_sekolah = $('[name="filter_sekolah"]').val();
        }, 
        columns: [
            {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nip", "visible": false},
                {"data": "nama_guru","visible": false},
                {"data": "nama", searchable: false},
                {"data": "npsn", "visible": false},
                {"data": "nama_sekolah","visible": false},
                {"data": "sekolah", searchable: false},
                {"data": "jk", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "bidang_studi_pendidikan", searchable:false, orderable:false},
                {"data": "tanggal", searchable:false, orderable:false},
                {"data": "berkas", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status_", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"},
        ]
    }

    oTable = intiate_datatables(datatables);

    $("#cari").click(function() {
        oTable.ajax.reload();
    });

    $(document).on("click", ".button-verif", function (e) {
        e.preventDefault();
        aOption = {
            title: "Verifikasi Data ini?",
            message: "Yakin ingin menerima usulan mutasi ini?",
            url: "<?= base_url($uri_mod.'/AjaxTerima/')?>" + $(this).attr('data-id'),
            table: oTable,
            data: {
                silatpendidikan_c_token: csrf_value
            },
        };

        btn_confirm_action(aOption);
    });

    $(document).on("click", ".button-ditolak", function (e) {
        $('#form-tolak').addClass('form-tolak');
        $('#data_verifikasi').val($(this).data('id')); //id
        $('#modal-tolak').modal('show');
    });

    $(document).on("submit", ".form-tolak", function (e) {
        e.preventDefault();
        aOption = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            url: "<?= base_url($uri_mod. '/AjaxTolak/')?>" + $('#data_verifikasi').val(),
            table: oTable,
            data: $(this).serialize()
        };

        aksi = btn_save_form(aOption);

        if (aksi == true) {
            $('#modal-tolak').modal('hide'); 
        }
    });

    $('.modal').on('hidden.bs.modal', function() {
        $('form').each(function() {
            $(this)[0].reset();
            $(this).attr('data-id', '');      
        });
        $(modal_name + ' .form-group label.error').hide();
        $(modal_name + ' .form-control').removeClass('valid').removeClass('error');
    });

});

</script>