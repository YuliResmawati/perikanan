<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="c-token-response" name="c-token-response">
        <div class="form-group row">
            <label for="kategori" class="col-md-2 col-form-label">Kategori Content <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="kategori" id="kategori">
                    <option selected disabled>Pilih Kategori</option>
                    <?php 
                    foreach($kategori as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_kategori ?></option>
                    <?php $no++; endforeach; ?>
                </select>            
            </div>
        </div>
        <div class="form-group row">
            <label for="judul" class="col-md-2 col-form-label">Judul Content <?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="judul" id="judul" rows="2"></textarea>
            </div>
        </div> 
        <div class="form-group row">
            <label for="isi_content" class="col-md-2 col-form-label">Isi Content <?= label_required() ?></label>
            <div class="col-md-10">
                <div id="isi_content" class="wel-custom-textarea"></div>
            </div>
        </div>
        <div class="form-group row" style ="display:none" id="image">
            <label for="image" class="col-md-2 col-form-label">Upload Gambar Content <?= label_required() ?> </label>
            <div class="col-md-10">
                <span class="text-muted font-12 mt-2">(Maksimal ukuran 1MB. Format yang didukung hanya : .jpg | .png | .jpeg | .jpg)</span><br>
                <input type="file" data-plugins="dropify" name="image" id="image" data-max-file-size="1M" accept="image/*" />
            </div>
        </div>
        <div class="form-group row" style ="display:none" id="file">
            <label for="file" class="col-md-2 col-form-label">Berkas <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="file" class="form-control" id="file" name="file" data-plugins="dropify">
                <p class="text-muted font-13 mt-2">Maksimal 1MB dengan rekomendasi. Format yang didukung: .pdf</p>
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

    $('#kategori').change(function() {
        let data = $('#kategori').select2('data');
        let result = data[0].text;

        if (result == "Pengumuman"){
            $('#file').show();
            $('#image').hide();
        } else {
            $('#file').hide();
            $('#image').show();
        }
    });


    $(document).ready(function() {
        let id ='<?= encrypt_url($id, $id_key) ?>';
        
        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
        }

        data = get_data_by_id(aOption);

        if (data != false) {
            $('#judul').val(data.data.judul_konten);
            $('#isi_content').summernote('code', data.data.isi_konten);
            // $('#tgl').val(data.data.tgl_konten);
            $('select[name="kategori"]').val(data.data.kategori_konten_id).change();

            if (data.data.berkas != undefined) {
                $("[name='image']").attr('data-default-file', data.data.berkas);
                reinit_dropify($("[name='image']"));
            }
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
                document.querySelector('.c-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        isi_content = $('#isi_content').summernote('code');
        formData = new FormData(this);
        formData.append('isi_content', isi_content);
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