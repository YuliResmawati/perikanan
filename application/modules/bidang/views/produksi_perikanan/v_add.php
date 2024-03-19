<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pi-token-response" name="pi-token-response">
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
                <select id="filter_komoditas" class="selectpicker" data-actions-box="true"  multiple data-selected-text-format="count > 4" data-style="btn-light" 
                    title="Pilih Komoditas" data-live-search="true" name="filter_komoditas[]">
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="produksi" class="col-md-2 col-form-label">Jumlah Produksi <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="produksi" id="produksi" placeholder="Jumlah Produksi">
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

         var rupiah = document.getElementById("produksi");
            rupiah.addEventListener("keyup", function(e) {
                rupiah.value = formatRupiah(this.value);
        });

        $('.select2-selection').css('border-color','#d0d0d0');

        $('select.select2').each(function(el) {
            let spinner = "<span class=\"select2-spinner spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\" style=\"display:none;\"></span>";
            let element = $(this).next(".select2-container").find(".select2-selection .select2-selection__arrow");
            element.append(spinner);
        });

        $('#jenis').change(function() {
            jenis_id = $(this).val();
            spinner = $(this).next(".select2-container").find(".select2-selection .select2-selection__arrow .select2-spinner");
            arrow = $(this).next(".select2-container").find(".select2-selection .select2-selection__arrow b[role='presentation']");

            jenis_select_change(jenis_id, spinner, arrow);
        });

        function jenis_select_change(jenis_id,  spinner, arrow) {
            var id = jenis_id;

            $.ajax({
                url: "<?= base_url('app/AjaxGetValueByJenis/') ?>",
                method : "POST",
                data : {id: id, dkpp_c_token: csrf_value},
                async : true,
                dataType : 'json',
                beforeSend:function(){
                    spinner.show();
                    arrow.hide();
                },
                success: function(data) {
                    if (data.status == true) {
                        csrf_value = data.token;
                        var index;

                        for (index = 0; index < data.data.length; index++) {
                            html += '<option value='+data.data[index].id+'>'+data.data[index].komoditas+'</option>';
                        }
                        
                        $('#filter_komoditas').html(html);
                    } else {
                        var html = '<option value="" selected disabled>Komoditas Tidak Tersedia</option>';
                        $('#filter_komoditas').html(html);
                    }
                    
                    $('.selectpicker').selectpicker('refresh');
                    spinner.hide();
                    arrow.show();
                },
                error:function() {
                    bootbox.alert({
                        title: "Error",
                        centerVertical: true,
                        message: '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
                    });
                    
                    $('#pegawai').hide();
                    spinner.hide();
                    arrow.show();
                }
            });

            return false;
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
                document.querySelector('.pi-token-response').value = token;
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