<input type="hidden" class="nip-token-response" name="nip-token-response">
<div class="row">
    <div class="col-lg-6">
        <?= form_open($uri_mod.'/AjaxReset', 'id="formAjax" class="form"') ?> 
            <div class="card-box">
                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Reset Akun</h5>
                <div id="search">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nip_search" class="col-form-label">NIP <?= label_required() ?></label>
                                <input type="text" class="form-control" name="nip_search" id="nip_search" data-toggle="input-mask" data-mask-format="000000000000000000">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span id="search-btn" class="btn btn-blue waves-effect waves-light float-left mb-2">
                                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-search" role="status" aria-hidden="true" style="display:none"></span>
                                    <i class="mdi mdi-search-web mr-1" id="icon-search"></i><span id="button-search">Cari</span>
                                </span>
                                <span id="reset-btn" class="btn btn-warning waves-effect waves-light float-left mb-2 ml-2">
                                    <i class="mdi mdi-refresh mr-1" id="icon-reset"></i><span id="button-reset">Bersihkan</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="preview" style="display: none;">
                    <div class="form-group mb-3">
                        <label for="nama_pegawai">Nama Pegawai</span></label>
                        <input type="text" id="nama_pegawai" name="nama_pegawai" class="form-control text-muted" readonly>
                        <input type="hidden" id="user_id" name="user_id" class="form-control text-muted" readonly>
                        <input type="hidden" class="reset-token-response" name="reset-token-response">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama_unor">Nama Unit Organisasi</span></label>
                        <input type="text" id="nama_unor" name="nama_unor" class="form-control text-muted" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="jabatan">Jabatan</span></label>
                        <input type="text" id="jabatan" name="jabatan" class="form-control text-muted" readonly>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                                <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                                <i class="mdi mdi-lock-reset mr-1" id="icon-save"></i><span id="button-value">Reset Akun</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
    <div class="col-lg-6">
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Log Reset Akun</h5>
            <div class="table-responsive mb-4 mt-3">
                <table id="table-reset" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">#</th>
                            <th style="text-align: center; vertical-align: middle;">Tanggal Reset</th>
                            <th style="text-align: center; vertical-align: middle;">NIP</th>
                            <th style="text-align: center; vertical-align: middle;">Nama Pegawai</th>
                            <th style="text-align: center; vertical-align: middle;">Penanggung Jawab Reset Akun</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div> 
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-reset';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.simpeg_c_token = csrf_value;
            }, 
            columns: [
                {"data": "id", searchable: false, orderable: false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "tanggal_reset", searchable: false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "nip", searchable: true, orderable: true, "sClass": "text-center text-nowrap align-middle"},
                {"data": "nama_pegawai", searchable: true, orderable: true, "sClass": "text-center text-nowrap align-middle"},
                {"data": "penanggung_jawab", searchable: true, orderable: true, "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);
    });

    $(document).on("click", "#search-btn", function (e) {
        e.preventDefault();
        $('#loading-process').show();
        $('#search-btn').attr('disabled', true);
        $('#spinner-search').show();
        $('#icon-search').hide();
        $('#button-search').html('Loading...');
        $('#preview').hide();

        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.nip-token-response').value = token;
                if ($('#nip_search').val() == '' || $('#nip_search').val() == undefined) {
                    bootbox.alert({
                        title: "Error",
                        centerVertical: true,
                        message: '<span class="text-danger"><i class="mdi mdi-alert"></i> <i>Isi NIP terlebih dahulu</i></span>',
                    });

                    $('#search-btn').attr('disabled', false);
                    $('#spinner-search').hide();
                    $('#icon-search').show();
                    $('#button-search').html('Cari');
                    $('#main-container').hide();
                    $('#action').hide();
                    $('#loading-process').hide();
                } else {
                    $.ajax({
                        url: "<?= site_url($uri_mod.'/AjaxGetNip/') ?>" + $('#nip_search').val() + '/' + $('.nip-token-response').val(),
                        type: "POST",
                        async: true,
                        data: {simpeg_c_token: csrf_value, nip_token_response: $('#nip-token-response').val()},
                        dataType: "json",
                        error:function() {
                            bootbox.alert({
                                title: "Error",
                                centerVertical: true,
                                message: '<span class="text-danger"><i class="mdi mdi-alert"></i> <i>Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</i></span>',
                            });

                            $('#search-btn').attr('disabled', false);
                            $('#spinner-search').hide();
                            $('#icon-search').show();
                            $('#button-search').html('Cari');
                            $('#main-container').hide();
                            $('#action').hide();
                            $('#loading-process').hide();
                        },

                        beforeSend:function(){
                            $('#loading-process').show();
                            $('#search-btn').attr('disabled', true);
                            $('#spinner-search').show();
                            $('#icon-search').hide();
                            $('#button-search').html('Loading...');
                            $('#preview').hide();
                        },

                        success: function(data) {
                            if (data.status !== undefined && data.status == true) {
                                if (data.data !== null) {
                                    $('#preview').show();
                                    $('#nip_search').prop('readonly', true);
                                    $('#nama_pegawai').val(data.data.nama_pegawai)  
                                    $('#nama_unor').val(data.data.nama_unor);
                                    $('#jabatan').val(data.data.nama_jabatan);
                                    $('#user_id').val(data.data.user_id);
                                } else {
                                    bootbox.alert({
                                        title: "Error",
                                        centerVertical: true,
                                        message: '<span class="text-danger"><i class="mdi mdi-alert"></i> <i>Data tidak ditemukan.</i></span>',
                                    });
                                }
                            } else {
                                bootbox.alert({
                                    title: "Error",
                                    centerVertical: true,
                                    message: '<span class="text-danger"><i class="mdi mdi-alert"></i> <i>Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</i></span>',
                                }); 
                            }

                            $('#search-btn').attr('disabled', false);
                            $('#spinner-search').hide();
                            $('#icon-search').show();
                            $('#button-search').html('Cari');
                            $('#loading-process').hide();
                        }
                    });
                }
            });
        });
    });

    $(document).on("click", "#reset-btn", function (e) {
        e.preventDefault();
        $('form').each(function() {     
            $(this)[0].reset();
            $('#nip_search').removeAttr("readonly");
            $('#preview').hide();
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
                document.querySelector('.reset-token-response').value = token;
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
            button_text: 'Reset Akun',
            url: $(this).attr('action'),
            data: formData,
            redirect: "<?= base_url($uri_mod) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>