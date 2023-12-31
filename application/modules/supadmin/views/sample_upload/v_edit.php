<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="su-token-response" name="su-token-response">
        <div class="form-group row">
            <label for="judul" class="col-md-2 col-form-label">Judul <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="judul" id="judul">
            </div>
        </div>
        <div class="form-group row">
            <label for="deskripsi" class="col-md-2 col-form-label">Deskripsi <?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="files" class="col-md-2 col-form-label">File <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="file" data-plugins="dropify" name="berkas" id="berkas" data-max-file-size="1M" />
                <code>*Maksimal 1MB. Format yang didukung: .pdf</code> 
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                    <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                </button>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
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
            $('#judul').val(data.data.judul);
            $('#deskripsi').val(data.data.deskripsi);

            if (data.data.files != undefined) {
                $("[name='berkas']").attr('data-default-file', data.data.files);
                reinit_dropify($("[name='berkas']"));
            }
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
                document.querySelector('.su-token-response').value = token;
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