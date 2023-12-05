<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="usr-token-response" name="usr-token-response">
        <div class="form-group row" >
            <label for="bidang" class="col-md-2 col-form-label">Bidang <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="bidang" id="bidang">
                    <option selected disabled>Pilih Bidang</option>
                    <?php $no = 1; $no_id = 3; foreach($bidang as $row): ?>
                        <option value="<?= encrypt_url($no_id, $id_key) ?>"><?= $no. ' - ' .$row->nama_jabatan ?></option>
                    <?php $no++; $no_id++; endforeach; ?>
                </select>      
            </div>
        </div>
        <div class="form-group row" >
            <label for="pegawai_id" class="col-md-2 col-form-label">Pegawai <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="pegawai_id" id="pegawai_id">
                    <option selected disabled>Pilih Pegawai</option>
                    <?php $no = 1; foreach($pegawai as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->nip ?> || <?= $row->nama_pegawai?></option>
                    <?php $no++; endforeach; ?>
                </select>      
            </div>
        </div>
        <div class="form-group row" id="_username">
            <label for="username" class="col-md-2 col-form-label">Username <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="username" id="username" placeholder ="Username tidak boleh ada spasi, Ex: Bidang_perikanan">
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
                document.querySelector('.usr-token-response').value = token;
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