<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="wl-token-response" name="wl-token-response">
        <?php
            if($this->logged_level !== "3"){ ?>
                <div class="form-group row">
                    <label for="sekolah_id" class="col-md-2 col-form-label">Nama Sekolah <?= label_required() ?></label>
                    <div class="col-md-10">
                        <select class="form-control select2" name="sekolah_id" id="sekolah_id">
                            <option selected disabled>Pilih Sekolah</option>
                            <?php 
                            foreach($sekolah as $row): ?>
                                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
                            <?php $no++; endforeach; ?>
                        </select>            
                    </div>
                </div>
        <?php } ?>

        <div class="form-group row">
            <label for="rombel_id" class="col-md-2 col-form-label">Nama Rombel <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="rombel_id" id="rombel_id">
                    <option selected disabled>Pilih Rombel</option>
                    <?php 
                    foreach($rombel as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->tingkatan."-".$row->nama_rombel ?></option>
                    <?php $no++; endforeach; ?>
                </select>            
            </div>
        </div>

        <div class="form-group row">
            <label for="walas_id" class="col-md-2 col-form-label">Nama Wali Kelas <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="walas_id" id="walas_id">
                    <option selected disabled>Pilih Wali Kelas</option>
                    <?php 
                    foreach($guru as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= name_degree($row->gelar_depan,$row->nama_guru,$row->gelar_belakang) ?></option>
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
    
    $(document).ready(function() {
        let id ='<?= encrypt_url($id, $id_key) ?>';

        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
        }

        data = get_data_by_id(aOption);
        if (data != false) {
            $('select[name="sekolah_id"]').val(data.data.sekolah_id).change();
            $('select[name="rombel_id"]').val(data.data.rombel_id).change();
            $('select[name="walas_id"]').val(data.data.walas_id).change();
        }

    });

    $('#sekolah_id').change(function() {
        var sekolah_id = $(this).val();
        $.ajax({
            url: "<?= base_url($uri_mod. '/AjaxGetGuruBySekolah/') ?>",
            method : "POST",
            data : {sekolah_id: sekolah_id},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    csrf_value = data.token;
                    var html = '<option value="" selected disabled>Pilih Wali Kelas</option>';
                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        if($('#walas_id').val() == data.data[index].id) {
                            html += '<option value='+data.data[index].id+' selected >'+data.data[index].nama_guru+'</option>';
                        }else{
                            html += '<option value='+data.data[index].id+'>'+data.data[index].nama_guru+'</option>';
                        }
                        no++;
                    }

                    $('#walas_id').html(html);
                }else{
                    var html = '<option value="" selected disabled>Pilihan Tidak Tersedia</option>';
                    $('#walas_id').html(html);
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
                document.querySelector('.wl-token-response').value = token;
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