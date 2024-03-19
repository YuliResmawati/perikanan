<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pm-token-response" name="pm-token-response">
        <div class="form-group row">
            <label for="jenis" class="col-md-2 col-form-label">Pilih Jenis Ikan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="jenis" id="jenis">
                    <option selected disable>Pilih Jenis Ikan</option>
                    <option value="<?= encrypt_url('1', 'app') ?>">Ikan Laut</option>
                    <option value="<?= encrypt_url('2', 'app') ?>">Ikan Tawar</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="komoditas" class="col-md-2 col-form-label">Pilih Komoditas <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="komoditas" id="komoditas"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="rtp" class="col-md-2 col-form-label">RTP <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="rtp" id="rtp" placeholder="Jumlah RTP">
            </div>
        </div>
        <div class="form-group row">
            <label for="lahan" class="col-md-2 col-form-label">Luas lahan <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="lahan" id="lahan" placeholder="Luas Lahan (Ha)">
            </div>
        </div>
        <div class="form-group row">
            <label for="jum_jantan" class="col-md-2 col-form-label">Jumlah Induk Jantan <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="jum_jantan" id="induk_j" placeholder="Jumlah Induk Jantan (Ekor)">
            </div>
        </div>
        <div class="form-group row">
            <label for="jum_betina" class="col-md-2 col-form-label">Jumlah Induk Betina <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="jum_betina" id="induk_b" placeholder="Jumlah Induk Betina (Ekor)">
            </div>
        </div>
        <div class="form-group row">
            <label for="produksi" class="col-md-2 col-form-label">Produksi <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="produksi" id="produksi" placeholder="Produksi (Ekor)">
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
        $( ".flatpickr" ).flatpickr({
            disableMobile : true
        });

        var induk_jantan = document.getElementById("induk_j");
            induk_jantan.addEventListener("keyup", function(e) {
                induk_jantan.value = formatRupiah(this.value);
        });

        var induk_betina = document.getElementById("induk_b");
            induk_betina.addEventListener("keyup", function(e) {
                induk_betina.value = formatRupiah(this.value);
        });

        var produksi = document.getElementById("produksi");
            produksi.addEventListener("keyup", function(e) {
                produksi.value = formatRupiah(this.value);
        });

        $('#jenis').on('change', function() {
            value_option = $('#jenis').val();
            init_autocomplete_komoditas(value_option);
        });

    });

    function init_autocomplete_komoditas(value_option) {
        ajax_get_komoditas = {
            element: $('#komoditas'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetKomoditas/') ?>" + value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Komoditas',
        }

        init_ajax_select2_paging(ajax_get_komoditas);
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
                document.querySelector('.pm-token-response').value = token;
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