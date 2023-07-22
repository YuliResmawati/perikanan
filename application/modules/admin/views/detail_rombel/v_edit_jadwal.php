<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSaveJadwal/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="jd-token-response" name="jd-token-response">
        <input type="hidden" class="form-control" name="guru_id" id="guru_id">
        <input type="hidden" class="form-control" name="mapel_id" id="mapel_id">
        <input type="hidden" class="form-control" name="detail_rombel_id" id="detail_rombel_id">

        <div class="form-group row">
            <label for="nama_guru" class="col-md-2 col-form-label">Nama Guru</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_guru" id="nama_guru" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_mapel" class="col-md-2 col-form-label">Mata Pelajaran</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_mapel" id="nama_mapel" readonly>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="hari" class="col-4 col-form-label">Hari <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="hari" id="hari">
                            <option selected disabled>Pilih Hari</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>                     
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hari" class="col-4 col-form-label">Lama Pembelajaran (dalam hitungan menit) <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="number" class="form-control" name="lama_pembelajaran" id="lama_pembelajaran">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="jadwal_awal" class="col-4 col-form-label">Jadwal Awal <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="time" class="form-control" name="jadwal_awal" id="jadwal_awal">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jadwal_akhir" class="col-4 col-form-label">Jadwal Akhir <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="time" class="form-control" name="jadwal_akhir" id="jadwal_akhir">
                    </div>
                </div>
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
            url: "<?= base_url($uri_mod. '/AjaxGetJadwal/det/') ?>" + id,
        }

        data = get_data_by_id(aOption);
        if (data != false) {
            $('#guru_id').val(data.data.guru_id);
            $('#mapel_id').val(data.data.mapel_id);
            $('#detail_rombel_id').val(data.data.detail_rombel_id);
            $('#nama_guru').val(data.data.nama_guru);
            $('#nama_mapel').val(data.data.nama_mapel);
            $('#lama_pembelajaran').val(data.data.lama_pembelajaran);
            $('#jadwal_awal').val(data.data.jadwal_awal);
            $('#jadwal_akhir').val(data.data.jadwal_akhir);
            $('select[name="hari"]').val(data.data.hari).change();

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
                document.querySelector('.jd-token-response').value = token;
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
            redirect: "<?= base_url($uri_mod.'/index_jadwal/').encrypt_url($detail_rombel_id, $this->id_key) ?>"
        }

        btn_save_form_with_file(option_save);
    });
</script>