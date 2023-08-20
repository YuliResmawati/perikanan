<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?>
            <input type="hidden" class="ar-token-response" name="ar-token-response">
            <div class="form-group row">
                <label for="title" class="col-md-3 col-form-label">Judul <?= label_required() ?></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="title" id="title">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-md-3 col-form-label">Deskripsi <?= label_required() ?></label>
                <div class="col-md-9">
                    <div id="description" class="wel-custom-textarea"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-md-3 col-form-label">Thumbnail <?= label_required() ?></label>
                <div class="col-md-9">
                    <input type="file" class="form-control" id="image" name="image" data-plugins="dropify">
                    <p class="text-muted font-13 mt-2">Maksimal 1MB dengan rekomendasi ukuran <b>850 x 427</b>. Format yang didukung: .jpg | .gif | .png | .jpeg | .jpg | .png</p>
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
                document.querySelector('.ar-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        isi_content = $('#description').summernote('code');
        formData = new FormData(this);
        formData.append('isi_content', isi_content);
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