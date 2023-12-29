<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSaveTHL', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pg-token-response" name="pg-token-response">
        <div class="form-group row">
            <label for="nama_pegawai" class="col-md-2 col-form-label">Nama Pegawai Non PNS <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai">
            </div>
        </div>
        <div class="form-group row">
            <label for="jk" class="col-md-2 col-form-label">Jenis Kelamin <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="jk" id="jk">
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option value="<?= encrypt_url('L', $id_key) ?>">Laki-Laki</option>
                    <option value="<?= encrypt_url('P', $id_key) ?>">Perempuan</option>
                </select>            
            </div>
        </div>
        <div class="form-group row">
            <label for="jabatan" class="col-md-2 col-form-label">Jabatan <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="jabatan" id="jabatan">
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-md-2 col-form-label">Upload Gambar <?= label_required() ?> </label>
            <div class="col-md-10">
                <span class="text-muted font-12 mt-2">(Maksimal ukuran 1MB. Format yang didukung hanya : .jpg | .png | .jpeg | .jpg)</span><br>
                <input type="file" data-plugins="dropify" name="image" id="image" data-max-file-size="1M" accept="image/*" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                    <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                </button>
                <a href="<?= base_url($uri_mod) ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>


<script type="text/javascript">

    $('#submit-btn').click(function(e) {
        e.preventDefault();
        $('#loading-process').show();
        $('#submit-btn').attr('disabled', true);
        $('#spinner-status').show();
        $('#icon-save').hide();
        $('#button-value').html("Loading...");
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.pg-token-response').value = token;
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