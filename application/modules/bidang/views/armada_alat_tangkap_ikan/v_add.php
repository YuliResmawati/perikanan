<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="at-token-response" name="at-token-response">
        <div class="form-group row">
            <label for="type" class="col-md-2 col-form-label">Pilih Perairan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="type" id="type">
                    <option selected disable>Pilih Armada</option>
                    <option value="<?= encrypt_url('1', 'app') ?>">Perairan Laut</option>
                    <option value="<?= encrypt_url('2', 'app') ?>">Perairan PUD</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="armada" class="col-md-2 col-form-label">Pilih Armada <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="armada" id="armada"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_a" class="col-md-2 col-form-label">Jumlah Armada <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_a" id="jumlah_a" placeholder="Jumlah Armada">
            </div>
        </div>
        <div class="form-group row">
            <label for="alat_tangkap" class="col-md-2 col-form-label">Pilih Alat Tangkap</label>
            <div class="col-md-10">
                <select class="form-control select2" name="alat_tangkap" id="alat_tangkap"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_b" class="col-md-2 col-form-label">Jumlah Alat Tangkap</label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_b" id="jumlah_b" placeholder="Jumlah Alat Tangkap">
            </div>
        </div>
        <div class="form-group row">
            <label for="alat_bantu" class="col-md-2 col-form-label">Pilih Alat Bantu Penangkapan</label>
            <div class="col-md-10">
                <select class="form-control select2" name="alat_bantu" id="alat_bantu"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_c" class="col-md-2 col-form-label">Jumlah Alat Bantu Penangkapan</label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_c" id="jumlah_c" placeholder="Jumlah Alat Bantu">
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
        $('#type').on('change', function() {
            value_option = $('#type').val();

            init_autocomplete_armada(value_option);
            init_autocomplete_alat_tangkap(value_option);
            init_autocomplete_alat_bantu(value_option);
        });
    });

    function init_autocomplete_armada(value_option) {
        let choise = 'armada';
        ajax_get_armada = {
            element: $('#armada'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Armada',
        }

        init_ajax_select2_paging(ajax_get_armada);
    }

    function init_autocomplete_alat_tangkap(value_option) {
        let choise = 'alat_tangkap';
        ajax_get_alat_tangkap = {
            element: $('#alat_tangkap'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Alat Tangkap',
        }

        init_ajax_select2_paging(ajax_get_alat_tangkap);
    }

    function init_autocomplete_alat_bantu(value_option) {
        let choise = 'alat_bantu';
        ajax_get_alat_bantu = {
            element: $('#alat_bantu'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Alat Bantu',
        }

        init_ajax_select2_paging(ajax_get_alat_bantu);
    }

    $('#submit-btn').click(function(e) {
        e.preventDefault();
        $('#loading-process').show();
        $('#submit-btn').attr('disabled', true);
        $('#spinner-status').show();
        $('#icon-save').hide();
        $('#button-value').html("Loading...");
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.at-token-response').value = token;
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