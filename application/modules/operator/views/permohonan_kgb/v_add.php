<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="kgb-token-response" name="kgb-token-response">
        <input type="hidden" class="form-control" name="guru_id" id="guru_id" >

        <div class="form-group row">
            <label for="nama_guru" class="col-md-2 col-form-label">Nama Guru <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_guru" id="nama_guru" readonly>
            </div>
        </div>

        <div class="form-group row">
            <label for="tmt_awal" class="col-md-2 col-form-label">KGB Terakhir <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="tmt_awal" id="tmt_awal" readonly>
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
            $('#guru_id').val(id);
            $('#nama_guru').val(data.data.nama_guru);
            $('#tmt_awal').val(data.data.tmt_awal);
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
                document.querySelector('.kgb-token-response').value = token;
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