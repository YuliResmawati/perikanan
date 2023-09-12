<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxTerima/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="msiswa-token-response" name="msiswa-token-response">
            <div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_siswa" class="col-form-label">Nama Siswa</label>
                        <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nisn" class="col-form-label">NISN</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" readonly>
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="sekolah_awal" class="col-form-label">Sekolah Sekarang</label>
                        <input type="text" class="form-control" name="sekolah_awal" id="sekolah_awal" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_rombel_awal" class="col-form-label">Kelas</label>
                        <input type="text" class="form-control" name="nama_rombel_awal" id="nama_rombel_awal" readonly>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="sekolah_tujuan" class="col-form-label">Sekolah Tujuan</label>
                        <input type="text" class="form-control" name="sekolah_tujuan" id="sekolah_tujuan" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_rombel_tujuan" class="col-form-label">Kelas</label>
                        <input type="text" class="form-control" name="nama_rombel_tujuan" id="nama_rombel_tujuan" readonly>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="link" class="col-form-label">Link Dokumen (GDrive)</label>
                    <input type="text" class="form-control" name="link" id="link"  placeholder="Link dokumen" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="image" class="col-md-3 col-form-label">Thumbnail <?= label_required() ?></label>
                    <input type="file" class="form-control" id="berkas" name="berkas" data-plugins="dropify">
                    <p class="text-muted font-13 mt-2">Silahkan upload bukti persetujuan dengan tipe file pdf ukuran maksimal 1 MB</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Terima Mutasi</span>
                    </button>
                    <a href="<?= base_url($uri_mod) ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        let id ='<?= encrypt_url($id, $id_key) ?>';

        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
        }

        data = get_data_by_id(aOption);

        if (data != false) {
            $('#nama_siswa').val(data.data.nama_siswa);
            $('#nisn').val(data.data.nisn);
            $('#sekolah_awal').val(data.data.sekolah_awal);
            $('#sekolah_tujuan').val(data.data.sekolah_tujuan);
            $('#nama_rombel_awal').val(data.data.rombel_awal);
            $('#nama_rombel_tujuan').val(data.data.rombel_tujuan);
            $('#link').val(data.data.link);

        }
    });   

    $('#submit-btn').click(function(e) {
        e.preventDefault();
        $('#loading-process').show();
        $('#submit-btn').attr('disabled', true);
        $('#spinner-status').show();
        $('#icon-save').hide();
        $('#button-value').html("Loading...");
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.msiswa-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        option_save = {
            async: true,
            enctype: 'multipart/form-data',
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: $(this).attr('action'),
            data: formData,
            redirect: "<?= base_url($uri_mod) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>