<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="usr-token-response" name="usr-token-response">
        <div class="form-group row">
            <label for="display_name" class="col-md-2 col-form-label">Nama Lengkap <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="display_name" id="display_name">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">Email <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <div class="form-group row">
            <label for="tipe_sekolah" class="col-md-2 col-form-label">Tingkatan Sekolah <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="tipe_sekolah" id="tipe_sekolah">
                    <option selected disabled>Pilih Tingkatan Sekolah</option>
                    <option value="TK">Taman Kanak-Kanak</option>
                    <option value="SD">Sekolah Dasar</option>
                    <option value="SMP">Sekolah Menengah Pertama</option>
                </select>
            </div>
        </div>
        <div class="form-group row" id="_sekolah">
            <label for="sekolah_id" class="col-md-2 col-form-label">Sekolah <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="sekolah_id" id="sekolah_id">
                <option selected disabled>Pilih Tingkatan Terlebih Dahulu</option>  
                </select>
            </div>
        </div>
        <div class="form-group row" id="_username">
            <label for="username" class="col-md-2 col-form-label">Username <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="username" id="username" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-2 col-form-label">Password <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="password" id="password" disabled placeholder="silatpendidikan_pass">
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
    $('#tipe_sekolah').change(function() {
        var tipe_sekolah = $(this).val();
        $('#username'). val('');
        $.ajax({
            url: "<?= base_url($uri_mod. '/AjaxGetSekolahByTipe/') ?>",
            method : "POST",
            data : {tipe_sekolah: tipe_sekolah},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    $('#_sekolah').show();
                    csrf_value = data.token;
                    var html = '<option value="" selected disabled>Pilih Sekolah</option>';
                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        html += '<option value='+data.data[index].id+'>'+data.data[index].nama_sekolah+'</option>';
                        no++;
                    }

                    $('#sekolah_id').html(html);
                }else{
                    $('#_sekolah').show();
                    var html = '<option value="" selected disabled>Sekolah Tidak Tersedia</option>';
                    $('#sekolah_id').html(html);
                } 
            }
        });
            return false;
    });

    $('#sekolah_id').change(function() {
        var id = $(this).val();
        var username = document.getElementById('username');
        display_name = ($(display_name).val().replace(/\s+/g, "")).toLowerCase();
        $.ajax({
            url: "<?= base_url($uri_mod. '/AjaxGetSekolahById/') ?>",
            method : "POST",
            data : {id: id},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    $('#_username').show();
                    csrf_value = data.token;
                    nama_sekolah = (data.data.nama_sekolah.replace(/\s+/g, "")).toLowerCase()+"_";
                    if(nama_sekolah === '' || display_name === ''){
                        $('#username').css({'color':'red'});
                        username.value = "Generate username gagal, silahkan refresh halaman ini !";
                    }else{
                        username.value = nama_sekolah.concat(display_name);
                    }
                }else{
                    $('#_username').show();
                    username.value = "Generate username gagal";
                } 
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
                document.querySelector('.usr-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        formData = new FormData(this);
        option_save = {
            async: true,
            enctype: 'multipart/form-data',
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: $(this).attr('action'),
            data: formData,
            redirect: "<?= base_url($uri_mod) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>