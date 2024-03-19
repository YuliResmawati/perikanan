<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pl-token-response" name="pl-token-response">
        <div class="form-group row">
            <label for="kecamatan" class="col-md-2 col-form-label">Pilih Kecamatan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="kecamatan" id="kecamatan"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="pelaku" class="col-md-2 col-form-label">Nama Pelaku Usaha<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="pelaku" id="pelaku" placeholder="Nama Pelaku Usaha">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">Email<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="email" name="email" id="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="telp" class="col-md-2 col-form-label">No Telephone<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control" type="text" name="telp" id="telp" data-toggle="input-mask" data-mask-format="0000-0000-0000" placeholder="Contoh Penulisan 0813-XXXX-XXX" />
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat<?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="jum" class="col-md-2 col-form-label">Jumlah Karyawan<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jum" id="jum" placeholder="Jumlah Karyawan">
            </div>
        </div>
        <div class="form-group row">
            <label for="skala" class="col-md-2 col-form-label">Skala Usaha <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="skala" id="skala">
                    <option selected disabled>Pilih Skala Usaha</option>
                    <option value="<?= encrypt_url('1', $id_key) ?>">Kecil</option>
                    <option value="<?= encrypt_url('2', $id_key) ?>">Menengah</option>
                    <option value="<?= encrypt_url('3', $id_key) ?>">Besar</option>
                </select>            
            </div>
        </div>
        <div class="form-group row">
            <label for="bidang" class="col-md-2 col-form-label">Pilih Bidang Usaha <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="bidang" id="bidang">
                    <option selected disabled>Pilih Bidang Usaha</option>
                    <option value="<?= encrypt_url('1', $id_key) ?>">Budidaya</option>
                    <option value="<?= encrypt_url('2', $id_key) ?>">Pasca Panen</option>
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

    $(document).ready(function(e) {

        ajax_get_kecamatan = {
            element: $('#kecamatan'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetDistrict') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Kecamatan',
        }

        
        init_ajax_select2_paging(ajax_get_kecamatan);
        
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
                document.querySelector('.pl-token-response').value = token;
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