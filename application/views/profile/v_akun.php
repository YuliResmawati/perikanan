<div class="tab-pane" id="account">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <h5 class="mb-3 text-uppercase"><i class="mdi mdi-security mr-1"></i> Akun Saya</h5>
                <div class="col-lg-12 col-xl-12">
                    <div class="alert alert-light bg-light text-dark border-0" role="alert">
                        <div class="text-justify">
                            Abaikan form <b>nama pengguna</b> jika tidak ingin merubah <b>nama pengguna</b> akun anda. Kosongkan form <b>kata sandi</b> jika tidak ingin merubah <b>kata sandi</b> akun anda.
                        </div>
                    </div>
                    <?= form_open($uri_mod.'/AjaxGet', 'id="formAjax" class="form mt-3"') ?>
                        <div class="main-container mt-4" id="main-container"> 
                            <div class="form-group row">
                                <label for="silatpendidikan_username" class="col-md-2 col-form-label">Nama Pengguna</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="silatpendidikan_username" id="silatpendidikan_username" value="<?= xss_echo(($this->logged_username !== NULL) ? $this->logged_username : '-') ?>">
                                    <input type="hidden" class="form-control" id="old_username" name="old_username" value="<?= xss_echo($this->logged_username) ?>">
                                    <code><i>*Tidak boleh ada <b>spasi</b> dalam pengisian nama pengguna.</i></code>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="old_password" class="col-md-2 col-form-label">Kata Sandi Lama</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" name="old_password" id="old_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-md-2 col-form-label">Kata Sandi Baru</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" name="new_password" id="new_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_new_password" class="col-md-2 col-form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                        <i class="mdi mdi-refresh mr-1" id="icon-button"></i><span id="button-value">Perbarui Data</span>
                                    </button>
                                    <a href="<?= base_url($uri_mod) ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
                                </div>
                            </div>
                        </div>       
                    <?= form_close(); ?>
                </div>
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
            icon_save: $('#icon-button'),
            button_value: $('#button-value'),
            button_text: 'Perbarui Data',
            url: $(this).attr('action'),
            data: $(this).serialize()+'&page='+'ajax_change_password',
            redirect: "<?= base_url('profile') ?>"
        }
        
        btn_save_form(option_save);
    });
</script>