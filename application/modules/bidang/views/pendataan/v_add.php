<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="pn-token-response" name="pn-token-response">
        <div class="form-group row mt-10 ">
            <label for="pelaku" class="col-sm-2 col-form-label">Pilih Pelaku Usaha </label>
            <div class="col-sm-10">
                <select class="form-control select2" name="pelaku" id="pelaku">
                </select>
            </div>
        </div>
        <div class="form-group row mt-10 ">
            <label for="type" class="col-sm-2 col-form-label">Pilih Bidang </label>
            <div class="col-sm-10">
                <select class="form-control select2" name="type" id="type">
                    <option selected disabled>Pilih Bidang</option>
                    <option value="<?= encrypt_url('1', $id_key) ?>">Pasca Panen</option>
                    <option value="<?= encrypt_url('2', $id_key) ?>">Budidaya</option>
                </select>
            </div>
        </div>

        <table id="table-pendataan" class="table table-striped w-100">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle;">#</th>
                    <th style="text-align: center; vertical-align: middle;">Kuesioner</th>
                    <th style="text-align: center; vertical-align: middle;">Opsi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
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
        ajax_get_pelaku = {
            element: $('#pelaku'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetPelaku') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Pelaku Usaha',
        }

        init_ajax_select2_paging(ajax_get_pelaku);

        $('#type').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "<?= base_url('app/AjaxGetValueByKusioner') ?>",
                method : "POST",
                data : {id: id, dkpp_c_token: csrf_value},
                async : true,
                dataType : 'json',
                success: function(data) {
                    if (data.status == true) {
                        if (data.data !== null) {
                            csrf_value = data.token;
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
                document.querySelector('.pn-token-response').value = token;
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