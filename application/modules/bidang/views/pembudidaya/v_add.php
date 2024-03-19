<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pub-token-response" name="pub-token-response">
        <div class="form-group row">
            <label for="kecamatan" class="col-md-2 col-form-label">Pilih Kecamatan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="kecamatan" id="kecamatan"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="aktif" class="col-md-2 col-form-label">Jumlah AKtif<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="aktif" id="aktif" placeholder="Jumlah Aktif (Kelompok)">
            </div>
        </div>
        <div class="form-group row">
            <label for="tidak_aktif" class="col-md-2 col-form-label">Jumlah Tidak AKtif<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="tidak_aktif" id="tidak_aktif" placeholder="Jumlah Tidak Aktif (Kelompok)">
            </div>
        </div>
        <div class="form-group row">
            <label for="berkelompok" class="col-md-2 col-form-label">Jumlah Berkelompok<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="berkelompok" id="berkelompok" placeholder="Jumlah Berkelompok (Orang)">
            </div>
        </div>
        <div class="form-group row">
            <label for="non_berkelompok" class="col-md-2 col-form-label">Jumlah Belum Berkelompok<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="non_berkelompok" id="non_berkelompok" placeholder="Jumlah Belum Berkelompok (Orang)">
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

        var jum_kelompok = document.getElementById("berkelompok");
            jum_kelompok.addEventListener("keyup", function(e) {
                jum_kelompok.value = formatRupiah(this.value);
        });

        var jum_non_kelompok = document.getElementById("non_berkelompok");
            jum_non_kelompok.addEventListener("keyup", function(e) {
                jum_non_kelompok.value = formatRupiah(this.value);
        });

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
                document.querySelector('.pub-token-response').value = token;
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