<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="sklh-token-response" name="sklh-token-response">
        
        <div class="form-group row">
            <label for="nama_sekolah" class="col-md-2 col-form-label">Nama Sekolah <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tipe_sekolah" class="col-4 col-form-label">Tingkatan Sekolah <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="tipe_sekolah" id="tipe_sekolah">
                            <option selected disabled>Pilih Tingkatan Sekolah</option>
                            <option value="TK">Taman Kanak-Kanak</option>
                            <option value="SD">Sekolah Dasar</option>
                            <option value="SMP">Sekolah Menengah Pertama</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="npsn" class="col-4 col-form-label">NPSN <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="npsn" id="npsn">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="status_sekolah" class="col-4 col-form-label">Status Sekolah <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="status_sekolah" id="status_sekolah">
                            <option selected disabled>Pilih Status Sekolah</option>
                            <option value="Swasta">Swasta</option>
                            <option value="Negeri">Negeri</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="status_kepemilikan" class="col-4 col-form-label">Status Kepemilikan <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="status_kepemilikan" id="status_kepemilikan">
                            <option selected disabled>Pilih Status Kepemilikan</option>
                            <option value="Pemerintah Daerah">Pemerintah Daerah</option>
                            <option value="Yayasan">Yayasan</option>
                            <option value="Swasta">Swasta</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="sk_pendirian" class="col-4 col-form-label">No. SK Pendirian</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="sk_pendirian" id="sk_pendirian">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_sk_pendirian" class="col-4 col-form-label">Tanggal SK Pendirian</label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_sk_pendirian" id="tgl_sk_pendirian">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="sk_izin" class="col-4 col-form-label">No. SK Izin</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="sk_izin" id="sk_izin">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_sk_izin" class="col-4 col-form-label">Tanggal SK Izin</label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_sk_izin" id="tgl_sk_izin">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="akreditasi" class="col-4 col-form-label">Akreditasi <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="akreditasi" id="akreditasi">
                            <option selected disabled>Pilih Akreditasi</option>
                            <option value="A">A - Unggul</option>
                            <option value="B">B - Baik</option>
                            <option value="C">C - Cukup Baik</option>
                            <option value="TT">TT - Tidak Terakreditasi</option>
                        </select>                    
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="kurikulum" class="col-4 col-form-label">Kurikulum</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="kurikulum" id="kurikulum">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat (Provinsi, Kota, Kecamatan, Kelurahan) <?= label_required() ?></label>
            <div class="col-md-10">
                <div class="form-group mb-3">
                    <textarea class="form-control" name="nagari" id="nagari" rows="2" readonly></textarea>
                    <input class="form-control" type="text" name="nagari_id" id="nagari_id" readonly/>
                    <code class="text-primary">klik <a href="#data-alamat-domisili" data-toggle="modal" class="cari-nagari"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah data alamat.</code>
                </div>           
            </div>
        </div>

        <div class="form-group row">
            <label for="alamat_lengkap" class="col-md-2 col-form-label">Detail Alamat (Penulisan Harus Sesuai EYD) <?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" rows="4"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="kode_pos" class="col-4 col-form-label">Kode Pos</label>
                    <div class="col-8">
                        <input class="form-control" type="text" name="kode_pos" id="kode_pos" data-toggle="input-mask" data-mask-format="00000"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_telp" class="col-4 col-form-label">No. Telp</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_telp" id="no_telp">
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group row">
            <label for="link_g_site" class="col-md-2 col-form-label">Link Google Site</label>
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

<!-- Alamat Domisili Search Modal -->
<div class="modal fade" id="data-alamat-domisili" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Alamat Domisili</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-alamat-domisili" data-id="" class="form-data-alamat-domisili"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Alamat Domisili</label>
                    <select class="form-control select2" name="data_alamat_domisili" id="data_alamat_domisili"></select>
                </div>
            </div>
            <div class="modal-footer">
                <div id="spinner-status" class="spinner-border spinner-border-sm text-success mr-2" role="status"
                    style="display:none"></div>
                <button id="submit-btn" type="submit" class="btn btn-success waves-effect waves-light">
                    <i class="mdi mdi-cursor-default-click mr-1"></i> Pilih
                </button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i
                        class="mdi mdi-cancel mr-1"></i> Batal</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!-- End Alamat Domisili Search Modal -->


<script type="text/javascript">
    $(document).ready(function() {
        $('#npsn').mask('00000000');
        $('#no_telp').mask('00000000000000000000');

        ajax_get_region = {
            element: $('#data_alamat_domisili'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetRegion') ?>",
            data: {
                silatpendidikan_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Kecamatan atau Kelurahan',
        }

        init_ajax_select2_paging(ajax_get_region);

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
            $('#sk_pendirian').val(data.data.sk_pendirian);
            $('#tgl_sk_pendirian').val(data.data.tgl_sk_pendirian);
            $('#sk_izin').val(data.data.sk_izin);
            $('#tgl_sk_izin').val(data.data.tgl_sk_izin);
            $('#kurikulum').val(data.data.kurikulum);
            $('#alamat_lengkap').val(data.data.alamat_lengkap);
            $('#kode_pos').val(data.data.kode_pos);
            $('#nagari').val(data.data.alamat);
            $('#nagari_id').val(data.data.nagari_id);
            $('select[name="tipe_sekolah"]').val(data.data.tipe_sekolah).change();
            $('select[name="status_sekolah"]').val(data.data.status_sekolah).change();
            $('select[name="status_kepemilikan"]').val(data.data.status_kepemilikan).change();
            $('select[name="akreditasi"]').val(data.data.akreditasi).change();
        }

    });

    $(document).on("submit", ".form-data-alamat-domisili", function (e) {
        e.preventDefault();
        let data = $('#data_alamat_domisili').select2('data');
        let nagari = data[0].text.split(",", 4);
        let result = nagari[3].split("Nagari");

        $('#nagari').val(data[0].text);
        $('#nagari_id').val(data[0].id);
        $('#data-alamat-domisili').modal('hide'); 
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