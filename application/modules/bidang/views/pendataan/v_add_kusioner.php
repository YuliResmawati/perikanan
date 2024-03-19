
<?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
<input type="hidden" class="pd-token-response" name="pd-token-response">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h5 class="text-uc_words mt-0 mb-3 bg-light p-2">PETUGAS</h5>
                <div class="form-group row">
                    <label for="petugas" class="col-md-2 col-form-label">Nama Petugas<?= label_required() ?></label>
                    <div class="col-md-10">
                        <input class="form-control custom-form " type="text" name="petugas" id="petugas" placeholder="Nama Petugas">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="komoditas_id" class="col-md-2 col-form-label">Pilih Komoditi <?= label_required() ?></label>
                    <div class="col-md-10">
                        <select class="form-control select2" name="komoditas_id" id="komoditas_id"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card-box">
                <h5 class="text-uc_words bg-light p-2 mt-0 mb-3">KUESIONER</h5>
                <?php if (!empty($kusioner)): ?>
                    <?php $no=1; foreach ($kusioner as $row) : ?>
                        <div class="form-group row">
                            <label for="opsional" class="col-md-3 col-form-label"><?= $row->kusioner ?></label>
                            <input type="hidden"  name="kusioner[]" value="<?= encrypt_url($row->id, $id_key) ?>">
                            <?php if ($row->jenis_opsi =='0'){ ?>
                                <div class="col-md-9">
                                    <input class="form-control custom-form " type="text" name="opsi[]" id="opsional" placeholder="Jawaban Anda">
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-check-inline " style="padding-left: 13px">
                                    <input class="form-check-input" type="radio" name="opsi[]" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Sesuai</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="opsi[]" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                </div>
                            <?php }?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="form-group row">
                            <label for="pelaku" class="col-md-2 col-form-label">Tidak Ada Kuesioner<?= label_required() ?></label>
                        </div>
                <?php endif ?>
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                            <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                            <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                        </button>
                        <a href="<?= base_url($uri_mod) ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= form_close() ?>


<script type="text/javascript">

    $(document).ready(function(e) {

        ajax_get_komoditi = {
            element: $('#komoditas_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetKomoditiPSAT') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Komoditi',
        }

        
        init_ajax_select2_paging(ajax_get_komoditi);

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
                document.querySelector('.pd-token-response').value = token;
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
            redirect: "<?= base_url($uri_mod).encrypt_url($id, $this->id_key) ?>"
        }

        btn_save_form(option_save);
    });
</script>