<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSavePanel/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pnbk-token-response" name="pnbk-token-response">
        <input type="hidden" class="form-control" name="kec_id" id="kec_id">
        <div class="form-group row">
            <label for="komoditas" class="col-md-2 col-form-label">Komoditas</label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="komoditas_" id="komoditas_" readonly>
                <input class="form-control custom-form " type="hidden" name="komoditas" id="komoditas">
            </div>
        </div>
        <div class="form-group row">
            <label for="harga" class="col-md-2 col-form-label">Harga Konsumen <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="harga" id="rupiah" placeholder="Harga Konsumen">
            </div>
        </div>
        <div class="form-group row">
            <label for="satuan" class="col-md-2 col-form-label">Satuan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="satuan" id="satuan">
                    <option selected disable>Pilih Satuan</option>
                    <?php $no = 1; foreach($satuan as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->kamus_data ?></option>
                    <?php $no++; endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="tanggal" class="col-md-2 col-form-label">Tanggal <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="date" class="form-control flatpickr" name="tanggal" id="tanggal">
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

        $('.select2-selection').css('border-color','#d0d0d0');

        var rupiah = document.getElementById("rupiah");
            rupiah.addEventListener("keyup", function(e) {
                rupiah.value = formatRupiah(this.value, "Rp. ");
        });

        let id ='<?= encrypt_url($id, $id_key) ?>';

        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGetPanel/det/') ?>" + id,
        }

        data = get_data_by_id(aOption);
        if (data != false) {
            let harga = formatRupiah(data.data.harga, 'Rp.');

            // $('select[name="komoditas"]').val(data.data.komoditas_id).change();
            $('#komoditas_').val(data.data.komoditas);
            $('#komoditas').val(data.data.komoditas_id);
            $('select[name="satuan"]').val(data.data.satuan).change();
            $('#tanggal').val(data.data.tanggal);
            $('#kec_id').val(data.data.kecamatan_id);
            $('#rupiah').val(harga);
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
                document.querySelector('.pnbk-token-response').value = token;
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
            redirect: "<?= base_url($uri_mod.'/index_panel/').encrypt_url($kec_id, $this->id_key) ?>"
        }

        btn_save_form(option_save);
    });
</script>