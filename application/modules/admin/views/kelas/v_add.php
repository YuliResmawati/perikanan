<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="kls-token-response" name="kls-token-response">
        <div class="form-group row">
            <label for="tipe_sekolah" class="col-md-2 col-form-label">Tingkatan Sekolah <?= label_required() ?></label>
            <div class="col-md-10"> 
                <select class="form-control select2" name="tipe_sekolah" id="tipe_sekolah">
                    <option value="ALL" selected>Tampilkan Semua Tingkatan</option>
                    <?php foreach($tipe_sekolah as $row): ?>
                        <option value="<?= $row->tipe_sekolah ?>"><?= $row->tipe_sekolah ?></option>
                    <?php $no++; endforeach; ?>
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
        <div class="form-group row" id="_tingkat">
            <label for="tingkat" class="col-md-2 col-form-label">Tingkatan Kelas <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="tingkat" id="tingkat">
                <option selected disabled>Pilih Tingkatan Terlebih Dahulu</option>  
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_kelas" class="col-md-2 col-form-label">Nama Kelas <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_kelas" id="nama_kelas">
            </div>
        </div>
        <!-- //guru_id -->
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
        $.ajax({
            url: "<?= base_url($uri_mod. '/AjaxGetSekolahByTipe/') ?>",
            method : "POST",
            data : {tipe_sekolah: tipe_sekolah},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    $('#_sekolah').show();
                    $('#_tingkat').show();
                    csrf_value = data.token;
                    var html = '<option value="" selected disabled>Pilih Sekolah</option>';
                    var isi = '<option value="" selected disabled>Pilih Tingkat Kelas</option>';
                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        html += '<option value='+data.data[index].id+'>'+data.data[index].nama_sekolah+'</option>';
                        no++;
                    }

                    $('#sekolah_id').html(html);

                    if(tipe_sekolah == 'TK'){
                        isi += '<option value="TKA">Taman Kanak-Kanak A</option>';
                        isi += '<option value="TKB">Taman Kanak-Kanak B</option>';
                    }else if(tipe_sekolah == 'SD'){
                        for (index = 1; index <= 6; index++) {
                            isi += '<option value='+index+'>'+'Kelas '+index+'</option>';
                        }
                    }else{
                        for (index = 7; index <= 9; index++) {
                            isi += '<option value='+index+'>'+'Kelas '+index+'</option>';
                        }
                    }
                    $('#tingkat').html(isi);
                }else{
                    $('#_sekolah').show();
                    var html = '<option value="" selected disabled>Pilihan Tidak Tersedia</option>';
                    $('#sekolah_id').html(html);
                    $('#tingkat').html(html);
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
                document.querySelector('.kls-token-response').value = token;
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