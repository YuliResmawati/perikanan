<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSaveMateri/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="mt-token-response" name="mt-token-response">
        <input type="hidden" class="form-control" name="mapel_id" id="mapel_id">

        <div class="form-group row">
            <label for="nama_materi" class="col-md-2 col-form-label">Nama Materi</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_materi" id="nama_materi">
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_jam" class="col-md-2 col-form-label">Jumlah Jam</label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="jumlah_jam" id="jumlah_jam">
            </div>
        </div>
        <div class="form-group row">
            <label for="sks" class="col-md-2 col-form-label">Jumlah SKS</label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="sks" id="sks">
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
    $(document).ready(function() {
        let id ='<?= encrypt_url($id, $id_key) ?>';

        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGetMateri/det/') ?>" + id,
        }

        data = get_data_by_id(aOption);
        if (data != false) {
            $('#mapel_id').val(data.data.mapel_id);
            $('#nama_mapel').val(data.data.nama_mapel);
            $('#nama_materi').val(data.data.nama_materi);
            $('#jumlah_jam').val(data.data.jumlah_jam);
            $('#sks').val(data.data.sks);
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
                document.querySelector('.mt-token-response').value = token;
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
            redirect: "<?= base_url($uri_mod.'/index_materi/').encrypt_url($id, $this->id_key) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>