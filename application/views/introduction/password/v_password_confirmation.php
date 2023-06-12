<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-xl-12 mt-2">
                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                    <div class="text-justify">
                        Kami mendeteksi anda masih menggunakan <b>kata sandi</b> bawaan simpeg. Demi keamanan akun anda, silahkan ubah kata sandi anda dengan mengikuti langkah-langkah berikut :
                    </div><br>
                    <div><strong>1. </strong>Inputkan kata sandi lama anda kedalam form <strong>kata sandi lama</strong></div>
                    <div><strong>2. </strong>Inputkan kata sandi baru untuk akun simpeg anda kedalam form <strong>kata sandi baru</strong> dan <strong>konfirmasi kata sandi baru</strong>. Pastikan kata sandi yang anda input memiliki panjang minimal <strong>8 karakter</strong></div>
                    <div><strong>3. </strong>Pastikan <strong>kata sandi baru</strong> anda harus sama dengan <strong>konfirmasi kata sandi baru</strong></div>
                    <div><strong>4. </strong>Setelah form sudah terisi semua, klik tombol <strong>Ubah Kata Sandi</strong></div>
                </div>
                <?= form_open($uri_mod.'/v1/password_confirm', 'id="formAjax" class="form"') ?>
                    <div class="main-container mt-4" id="main-container"> 
                        <div class="form-group row">
                            <label for="old_password" class="col-md-2 col-form-label">Kata Sandi Lama <?= label_required() ?></label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="old_password" id="old_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-md-2 col-form-label">Kata Sandi Baru <?= label_required() ?></label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="new_password" id="new_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_new_password" class="col-md-2 col-form-label">Konfirmasi Kata Sandi Baru <?= label_required() ?></label>
                            <div class="col-md-10">
                                <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <span id="reset-btn" class="btn btn-light waves-effect waves-light m-1">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status-reset" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-refresh mr-1" id="icon-reset"></i><span id="button-value-reset">Bersihkan Data</span>
                                </span>
                                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-lock-reset mr-1" id="icon-save"></i><span id="button-value">Ubah Kata Sandi</span>
                                </button>
                            </div>
                        </div>
                    </div>       
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#reset-btn').click(function() {
        $('#old_password').val('');
        $('#new_password').val('');
        $('#confirm_new_password').val('');
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        option_save = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            button_text: "Ubah Kata Sandi",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            redirect: "<?= base_url('introduction/konfirmasi_email') ?>"
        }

        btn_save_form(option_save);
    });
</script>