<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?>
        <input type="hidden" class="msiswa-token-response" name="msiswa-token-response">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="siswa_id" class="col-form-label">Pilih Siswa  <?= label_required() ?></label>
                    <select class="form-control select2" name="siswa_id" id="siswa_id"></select>
                </div>
            </div>
            <div id="_sekarang" style="display:none">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nisn" class="col-form-label">NISN</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="sekolah_awal" class="col-form-label">Sekolah Sekarang</label>
                        <input type="text" class="form-control" name="sekolah_awal" id="sekolah_awal" readonly>
                        <input type="hidden" class="form-control" name="sekolah_awal_id" id="sekolah_awal_id" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_rombel" class="col-form-label">Kelas</label>
                        <input type="text" class="form-control" name="nama_rombel" id="nama_rombel" readonly>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sekolah_tujuan" class="col-form-label">Pilih Sekolah Tujuan  <?= label_required() ?></label>
                    <select class="form-control select2" name="sekolah_tujuan" id="sekolah_tujuan"></select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12" id="_sekolah_rombel">
                    <label for="rombel_id" class="col-form-label">Nama Rombel <?= label_required() ?></label>
                    <select class="form-control select2" name="rombel_id" id="rombel_select">
                        <option selected disabled>Rombel Tidak Tersedia</option>  
                    </select>
                </div>
            </div>
            <!-- <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="link" class="col-form-label">Link Dokumen (GDrive)</label>
                    <input type="text" class="form-control" name="link" id="link"  placeholder="Link dokumen">
                </div>
            </div> -->
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

        ajax_get_siswa= {
            element: $('#siswa_id'),
            type: 'post',
            url: "<?= base_url($uri_mod. '/AjaxGetSiswa/') ?>",
            data: {
                silatpendidikan_c_token: csrf_value
            },
            placeholder: 'Ketik Nama siswa',
        }

        init_ajax_select2_paging(ajax_get_siswa);

        ajax_get_sekolah = {
            element: $('#sekolah_tujuan'),
            type: 'post',
            url: "<?= base_url($uri_mod. '/AjaxGetSekolah/') ?>",
            data: {
                silatpendidikan_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Sekolah Tujuan',
        }

        init_ajax_select2_paging(ajax_get_sekolah);

        $('#siswa_id').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "<?= base_url($uri_mod. '/AjaxGetValueBySiswa/') ?>",
                method : "POST",
                data : {id: id, silatpendidikan_c_token: csrf_value},
                async : true,
                dataType : 'json',
                success: function(data) {
                    if (data.status == true) {
                        $('#_sekarang').show();
                        csrf_value = data.token;
                        document.getElementById('nisn').value = data.data.nisn;
                        document.getElementById('jenis_kelamin').value = data.data.jenis_kelamin;
                        document.getElementById('sekolah_awal').value = data.data.nama_sekolah+' -- '+data.data.npsn;
                        document.getElementById('nama_rombel').value = data.data.nama_rombel;
                        document.getElementById('sekolah_awal_id').value = data.data.detail_rombel_awal_id;

                    } else {
                        $('#_sekarang').hide();
                    }
                }
            });
            return false;
        });

        $('#sekolah_tujuan').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "<?= base_url($uri_mod. '/AjaxGetValueBySekolah/') ?>",
                method : "POST",
                data : {id: id, silatpendidikan_c_token: csrf_value},
                async : true,
                dataType : 'json',
                success: function(data) {
                    if (data.status == true) {
                        $('#_sekolah_rombel').show();
                        csrf_value = data.token;
                        var html = '<option value="" selected disabled>Pilih Rombel</option>';
                        var index;
                        var no  = 1;

                        for (index = 0; index < data.data.length; index++) {
                            html += '<option value='+data.data[index].id+'>'+no+' - '+data.data[index].nama_rombel+'</option>';
                            no++;
                        }

                        $('#rombel_select').html(html);
                    } 
                }
            });
            return false;
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
                document.querySelector('.msiswa-token-response').value = token;
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