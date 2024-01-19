<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="nl-token-response" name="nl-token-response">
        <div class="form-group row">
            <label for="nama_koperasi" class="col-md-2 col-form-label">Nama Koperasi <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_koperasi" id="nama_koperasi" placeholder ="nama KUB atau koperasi">
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_ketua" class="col-md-2 col-form-label">Nama Ketua <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_ketua" id="nama_ketua" placeholder ="nama ketua">
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat Koperasi<?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder ="alamat"></textarea>
            </div>
        </div> 
        <div class="form-group row">
            <label for="jumlah" class="col-md-2 col-form-label">Jumlah Anggota <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder ="jumlah anggota">
            </div>
        </div>
        <div class="form-group row">
            <label for="tahun" class="col-md-2 col-form-label">Tahun Berdiri <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="tahun" id="tahun" placeholder ="tahun berdiri">
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
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
        }

        data = get_data_by_id(aOption);

        if (data != false) {
            $('#nama_koperasi').val(data.data.nama_koperasi);
            $('#nama_ketua').val(data.data.nama_ketua);
            $('#alamat').val(data.data.alamat);
            $('#jumlah').val(data.data.jumlah_anggota);
            $('#tahun').val(data.data.tahun_berdiri);
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
                document.querySelector('.nl-token-response').value = token;
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