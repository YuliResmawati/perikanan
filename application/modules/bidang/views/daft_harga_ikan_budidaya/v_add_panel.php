<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSavePanel', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pnbk-token-response" name="pnbk-token-response">
        <input type="hidden" class="form-control" name="kec_id" id="kec_id" value="<?= encrypt_url($id, $id_key) ?>" readonly>
        <div class="form-group row">
            <label for="jenis" class="col-md-2 col-form-label">Pilih Jenis Ikan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="jenis" id="jenis">
                    <option selected disabled>Pilih Jenis Ikan</option>
                    <option value="<?= encrypt_url('1', 'app') ?>">Ikan Laut</option>
                    <option value="<?= encrypt_url('2', 'app') ?>">Ikan Tawar</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="komoditas" class="col-md-2 col-form-label">Pilih Komoditas <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="komoditas" id="komoditas_select">
                    <option selected disabled>Komoditas Tidak Tersedia</option>  
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="harga" class="col-md-2 col-form-label">Harga <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="harga" id="rupiah" placeholder="Harga">
            </div>
        </div>
        <div class="form-group row">
            <label for="satuan" class="col-md-2 col-form-label">Satuan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="satuan" id="satuan">
                    <option selected disabled>Pilih Satuan</option>
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
    });

    $('#jenis').change(function() {
        var id = $(this).val();

        $.ajax({
            url: "<?= base_url('app/AjaxGetValueByJenis') ?>",
            method : "POST",
            data : {id: id, dkpp_c_token: csrf_value},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    if (data.data !== null) {
                        csrf_value = data.token;
                        var html = '<option value="" selected disabled>Pilih Komoditas</option>';
                        var index;

                        for (index = 0; index < data.data.length; index++) {
                            html += '<option value='+data.data[index].id+'>'+data.data[index].komoditas+'</option>';
                        }

                        $('#komoditas_select').html(html);

                    } else {
                        var html = '<option value="" selected disabled>Komoditas Tidak Tersedia</option>';
                        $('#komoditas_select').html(html);
                    }
                } else {
                    var html = '<option value="" selected disabled>Komoditas Tidak Tersedia</option>';
                    $('#komoditas_select').html(html);
                }
            },
            error:function() {
                bootbox.alert({
                    title: "Error",
                    centerVertical: true,
                    message: '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
                });
            }
        });
        return false;
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
            redirect: "<?= base_url($uri_mod.'/index_panel/').encrypt_url($id, $this->id_key) ?>"
        }

        btn_save_form(option_save);
    });
</script>