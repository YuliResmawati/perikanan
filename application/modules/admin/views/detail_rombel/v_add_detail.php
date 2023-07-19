<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSaveDetail', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="ds-token-response" name="ds-token-response">
        <input type="hidden" class="form-control" name="detail_rombel_id" id="detail_rombel_id" value="<?= encrypt_url($id, $id_key) ?>" readonly>

        <div class="form-group row">
            <label for="tahun_ajaran_id" class="col-md-2 col-form-label">Tahun Ajaran </label>
            <div class="col-md-10">
                <input type="hidden" class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id" value="<?= encrypt_url($rombel->tahun_ajaran_id, $id_key) ?>">
                <input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="<?= $rombel->tahun_ajaran?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="walas_id" class="col-md-2 col-form-label">Nama Wali Kelas</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="walas_id" id="walas_id" value="<?= name_degree($rombel->gelar_depan,$rombel->nama_guru,$rombel->gelar_belakang)?>" readonly>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="siswa_multiple" class="col-md-2 col-form-label">Nama Siswa</label>
            <div class="col-md-10">
                <select id="siswa_multiple" class="selectpicker"  multiple data-selected-text-format="count > 4" 
                    data-style="btn-light" title="Pilih Siswa" data-live-search="true" name="siswa_multiple[]">
                    <?php foreach ($siswa as $rows) { ?>
                        <option value="<?= encrypt_url($rows->id, $id_key) ?>">
                                <?= $rows->nama_siswa." - NISN : ".$rows->nisn ?>
                        </option>
                    <?php }?>
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
                document.querySelector('.ds-token-response').value = token;
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
            redirect: "<?= base_url($uri_mod.'/index_detail/').encrypt_url($id, $this->id_key) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>