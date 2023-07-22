<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="ct-token-response" name="ct-token-response">
        <div class="form-group row">
            <label for="guru_id" class="col-md-2 col-form-label">Nama Guru <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="tahun_ajaran_id" id="tahun_ajaran_id">
                <input type="text" class="form-control" name="guru_id" id="guru_id">
                <input type="text" class="form-control" name="nama_guru" id="nama_guru">
            </div>
        </div>
        <div class="form-group row">
            <label for="lama_cuti" class="col-md-2 col-form-label">Lama Cuti (Hari Kerja) <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="lama_cuti" id="lama_cuti">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tgl_awal" class="col-4 col-form-label">Tanggal Awal <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_awal" id="tgl_awal">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_akhir" class="col-4 col-form-label">Tanggal Akhir <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="files" class="col-md-2 col-form-label">File <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="file" data-plugins="dropify" name="berkas" id="berkas" data-max-file-size="1M" />
                <code>*Maksimal 1MB. Format yang didukung: .pdf</code> 
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-center">
                <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                    <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                    <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                </button>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
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
            $('#tahun_ajaran_id').val(data.data.tahun_ajaran_id);
            $('#guru_id').val(data.data.guru_id);
            $('#nama_guru').val(data.data.nama_guru);
            $('#lama_cuti').val(data.data.lama_cuti);
            $('#tgl_awal').val(data.data.tgl_awal);
            $('#tgl_akhir').val(data.data.tgl_akhir);

            if (data.data.files != undefined) {
                $("[name='berkas']").attr('data-default-file', data.data.files);
                reinit_dropify($("[name='berkas']"));
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
                document.querySelector('.ct-token-response').value = token;
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