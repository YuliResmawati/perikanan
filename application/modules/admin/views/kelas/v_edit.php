<div class="row mt-4">
    <div class="col-12"> 
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="sklh-token-response" name="sklh-token-response">
        <div class="form-group row">
                <label for="tipe_sekolah" class="col-md-2 col-form-label">Tingkatan Sekolah <?= label_required() ?></label>
                <div class="col-md-10">
                    <select class="form-control select2" name="tipe_sekolah" id="tipe_sekolah">
                        <option selected disabled>Pilih Tingkatan Sekolah</option>
                        <?php foreach($tipe_sekolah as $row): ?>
                        <option value="<?= $row->tipe_sekolah ?>"><?= $row->tipe_sekolah ?></option>
                        <?php $no++; endforeach; ?>
                    </select>
                </div>
            </div>
        <div class="form-group row">
            <label for="npsn" class="col-md-2 col-form-label">NPSN (Nomor Pokok Sekolah Nasional) <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="npsn" id="npsn">
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_sekolah" class="col-md-2 col-form-label">Nama Sekolah <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah">
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat Lengkap</label>
            <div class="col-md-10">
                <textarea class="form-control" name="alamat" id="alamat" rows="4"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="no_telp" class="col-md-2 col-form-label">Nomor Telepon</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="no_telp" id="no_telp">
            </div>
        </div>
        <div class="form-group row">
            <label for="link_g_site" class="col-md-2 col-form-label">Link Google Site <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="link_g_site" id="link_g_site">
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
        $('#npsn').mask('00000000');
        let id ='<?= encrypt_url($id, $id_key) ?>';

        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
        }

        data = get_data_by_id(aOption);
        if (data != false) {
            $('#npsn').val(data.data.npsn);
            $('#nama_sekolah').val(data.data.nama_sekolah);
            $('#alamat').val(data.data.alamat);
            $('#no_telp').val(data.data.no_telp);
            $('#link_g_site').val(data.data.link_g_site);
            $('select[name="tipe_sekolah"]').val(data.data.tipe_sekolah).change();
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
                document.querySelector('.sklh-token-response').value = token;
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