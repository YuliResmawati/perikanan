<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-xl-12 mt-2">
                <div class="alert alert-light bg-light text-dark border-0" role="alert">
                    <div class="text-justify">
                        Silahkan kaitkan akun simpeg anda dengan <strong>Telegram</strong>. Dengan mengaitkan ke telegram, anda akan mendapatkan kemudahan dalam menggunakan aplikasi <strong>simpeg agam</strong>
                        yang berkaitan dengan sistem kepegawaian di dalam lingkungan kabupaten agam. Berikut langkah mengaitkan akun ke telegram :
                    </div><br>
                    <div><strong>1. </strong>Pastikan anda memiliki aplikasi telegram di handphone atau laptop. Jika belum ada <a href="https://desktop.telegram.org/" target="_blank"><strong>Download Disini</strong></a></div>
                    <div><strong>2. </strong>Klik tombol <strong>Kaitkan Telegram Sekarang</strong></div>
                    <div><strong>3. </strong>Anda akan diarahkan ke halaman chat bot simpeg agam pada aplikasi telegram, lalu pilih tombol <strong>Start</strong></div>
                    <div><strong>4. </strong>Harap untuk kembali ke halaman ini, lalu klik tombol <strong>Simpan Informasi Telegram</strong></div>
                </div>
                <?= form_open($uri_mod.'/v1/telegram_confirm', 'id="formAjax" class="form"') ?>
                    <div class="main-container mt-4" id="main-container"> 
                        <div class="form-group row">
                            <label for="otp" class="col-md-2 col-form-label">Kaitkan Telegram</label>
                            <div class="col-sm-auto">
                                <div class="btn-group">
                                    <a href="https://t.me/SimpegOfficialBot?start=<?= encrypt_url($this->logged_user_id, "telegram_bot_key", false) ?>" target="_blank" class="btn btn-blue chat-send btn-block"><i class="mdi mdi-telegram mr-1"></i> Kaitkan Telegram Sekarang</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-folder-information-outline mr-1" id="icon-save"></i><span id="button-value">Simpan Informasi Telegram</span>
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
    $('#formAjax').submit(function(e) {
        e.preventDefault();
        option_save = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            button_text: "Simpan Informasi Telegram",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            redirect: "<?= base_url('introduction') ?>"
        }

        btn_save_form(option_save);
    });
</script>