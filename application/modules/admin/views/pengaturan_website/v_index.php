<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?>
            <input type="hidden" class="pw-token-response" name="pw-token-response">
            <div class="form-group row">
                <label for="name_site" class="col-md-2 col-form-label">Nama Website <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="name_site" id="name_site" value="<?= xss_echo((!empty($website_data))? $website_data[0]->name_site : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="about" class="col-md-2 col-form-label">Tentang <?= label_required() ?></label>
                <div class="col-md-10">
                    <textarea class="form-control" name="about" id="about" rows="4"><?= xss_echo((!empty($website_data))? $website_data[0]->about : "") ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="visi" class="col-md-2 col-form-label">Visi <?= label_required() ?></label>
                <div class="col-md-10">
                    <div id="visi" class="wel-custom-textarea"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="misi" class="col-md-2 col-form-label">Misi <?= label_required() ?></label>
                <div class="col-md-10">
                    <div id="misi" class="wel-custom-textarea"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="profile" class="col-md-2 col-form-label">Profile DPKK <?= label_required() ?></label>
                <div class="col-md-10">
                    <div id="profile" class="wel-custom-textarea"></div>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-2 col-form-label">Email <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="email" id="email" value="<?= xss_echo((!empty($website_data))? $website_data[0]->email : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-md-2 col-form-label">Alamat <?= label_required() ?></label>
                <div class="col-md-10">
                    <textarea class="form-control" name="address" id="address" rows="4"><?= xss_echo((!empty($website_data))? $website_data[0]->address : "") ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone_number" class="col-md-2 col-form-label">No Telepon <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?= xss_echo((!empty($website_data))? $website_data[0]->phone_number : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="whatsapp_number" class="col-md-2 col-form-label">No WhatsApp <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" value="<?= xss_echo((!empty($website_data))? $website_data[0]->whatsapp_number : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_facebook" class="col-md-2 col-form-label">Facebook <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="link_facebook" id="link_facebook" value="<?= xss_echo((!empty($website_data))? $website_data[0]->link_facebook : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_twitter" class="col-md-2 col-form-label">Twitter <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="link_twitter" id="link_twitter" value="<?= xss_echo((!empty($website_data))? $website_data[0]->link_twitter : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_instagram" class="col-md-2 col-form-label">Instagram <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="link_instagram" id="link_instagram" value="<?= xss_echo((!empty($website_data))? $website_data[0]->link_instagram : "") ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="link_youtube" class="col-md-2 col-form-label">Youtube <?= label_required() ?></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="link_youtube" id="link_youtube" value="<?= xss_echo((!empty($website_data))? $website_data[0]->link_youtube : "") ?>">
                </div>
            </div>
            <input type="hidden" class="form-control" id="id" name="id" value="<?= (!empty($website_data))? encrypt_url($website_data[0]->id, $id_key)  : "" ?>">
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
        let visi = '<?= xss_escape((!empty($website_data[0]->visi)) ? $website_data[0]->visi : "") ?>';
        let misi = '<?= xss_escape((!empty($website_data[0]->misi)) ? $website_data[0]->misi : "") ?>';
        let profile = '<?= xss_escape((!empty($website_data[0]->profile)) ? $website_data[0]->profile : "") ?>';

        $('#visi').summernote('code', visi);
        $('#misi').summernote('code', misi);
        $('#profile').summernote('code', profile);
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
                document.querySelector('.pw-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        visi_content = $('#visi').summernote('code');
        misi_content = $('#misi').summernote('code');
        profile_content = $('#profile').summernote('code');
        formData = new FormData(this);
        formData.append('visi_content', visi_content);
        formData.append('misi_content', misi_content);
        formData.append('profile_content', profile_content);
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