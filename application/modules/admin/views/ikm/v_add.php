<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="ikm-token-response" name="ikm-token-response">
        <div class="form-group row">
            <label for="ikm" class="col-md-2 col-form-label">Index Kepuasan <?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="ikm" id="ikm" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="poin" class="col-md-2 col-form-label">Pilih Poin Nilai <?= label_required() ?></label>
            <div class="col-md-10">
                <select id="poin" class="selectpicker" data-actions-box="true"  multiple data-selected-text-format="count > 4" data-style="btn-light" 
                    title="Pilih Poin" data-live-search="true" name="poin[]">
                        <?php foreach($kategori as $row): ?>
                            <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_kategori ?></option>
                        <?php endforeach; ?>
                </select>
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
                document.querySelector('.ikm-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        option_save = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            redirect: "<?= base_url($uri_mod) ?>"
        }

        btn_save_form(option_save);
    });
</script>