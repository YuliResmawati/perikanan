<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="sw-token-response" name="sw-token-response">
        <div class="form-group row">
            <label for="nama_siswa" class="col-md-2 col-form-label">Nama Siswa <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nik" class="col-4 col-form-label">NIK <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nik" id="nik">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_kk" class="col-4 col-form-label">No Kartu Keluarga <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_kk" id="no_kk">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="nipd" class="col-4 col-form-label">NIPD</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nipd" id="nipd">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nisn" class="col-4 col-form-label">NISN</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nisn" id="nisn">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="jenis_kelamin" class="col-4 col-form-label">Jenis Kelamin <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="jenis_kelamin" id="jenis_kelamin">
                            <option selected disabled>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="agama" class="col-4 col-form-label">Agama <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="agama" id="agama">
                            <option selected disabled>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tempat_lahir" class="col-4 col-form-label">Tempat Lahir <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_lahir" class="col-4 col-form-label">Tanggal Lahir <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat (Provinsi, Kota, Kecamatan, Kelurahan) <?= label_required() ?></label>
            <div class="col-md-10">
                <div class="form-group mb-3">
                    <textarea class="form-control" name="nagari" id="nagari" rows="2" readonly></textarea>
                    <input class="form-control" type="hidden" name="nagari_id" id="nagari_id" readonly/>
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
                    <label for="jenis_tinggal" class="col-4 col-form-label">Tinggal bersama</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="jenis_tinggal" id="jenis_tinggal">
                    </div>                
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="transportasi" class="col-4 col-form-label">Transportasi</label>
                    <div class="col-8">
                        <select class="form-control select2" name="transportasi" id="transportasi">
                            <option selected disabled>Pilih Jenis Transportasi</option>
                            <option value="Mobil/bus antar jemput">Mobil/bus antar jemput</option>
                            <option value="Kereta api">Kereta api</option>
                            <option value="Angkutan umum/ bus/ pete-pete">Angkutan umum/ bus/ pete-pete</option>
                            <option value="Sepeda">Sepeda</option>
                            <option value="Kendaraan Pribadi">Kendaraan Pribadi</option>
                            <option value="Andong/bendi/sado/dokar/delman/becak">Andong/bendi/sado/dokar/delman/becak</option>
                            <option value="Mobil pribadi">Mobil pribadi</option>
                            <option value="Jalan kaki">Jalan kaki</option>
                            <option value="Sepeda Motor">Sepeda Motor</option>
                            <option value="Ojek">Ojek</option>
                            <option value="Naik Angkot">Naik Angkot</option>
                            <option value="Sepeda motor">Sepeda motor</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>                    
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_hp" class="col-4 col-form-label">Nomor Hp</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_hp" id="no_hp">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="email" class="col-4 col-form-label">Email</label>
                    <div class="col-8">
                        <input type="email" class="form-control" name="email" id="email">
                </div>
                </div>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="skhun" class="col-4 col-form-label">No. SKHUN</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="skhun" id="skhun">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_kps" class="col-4 col-form-label">No. KKS</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_kps" id="no_kps">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="no_peserta_un" class="col-4 col-form-label">No. Peserta UN</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_peserta_un" id="no_peserta_un">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_seri_ijazah" class="col-4 col-form-label">No. Seri Ijazah</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_seri_ijazah" id="no_seri_ijazah">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="no_kip" class="col-4 col-form-label">No. KIP</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_kip" id="no_kip">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_kks" class="col-4 col-form-label">No. KKS</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_kks" id="no_kks">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="no_akta_lahir" class="col-4 col-form-label">No. Akta Lahir</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_akta_lahir" id="no_akta_lahir">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_rekening" class="col-4 col-form-label">No. Rekening</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_rekening" id="no_rekening">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="bank" class="col-4 col-form-label">Nama Bank</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="bank" id="bank">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="atas_nama" class="col-4 col-form-label">Rekening Atas Nama</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="atas_nama" id="atas_nama">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="kelayakan_pip" class="col-4 col-form-label">Kelayakan PIP</label>
                    <div class="col-8">
                        <select class="form-control select2" name="kelayakan_pip" id="kelayakan_pip">
                            <option selected disabled>Pilih Ya atau Tidak</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>                    
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="alasan" class="col-4 col-form-label">Alasan Kelayakan</label>
                    <div class="col-8">
                        <textarea class="form-control" name="alasan" id="alasan" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="kebutuhan_khusus" class="col-4 col-form-label">Kebutuhan Khusus</label>
                    <div class="col-8">
                        <select class="form-control select2" name="kebutuhan_khusus" id="kebutuhan_khusus">
                            <option selected disabled>Pilih Ada atau Tidak Ada</option>
                            <option value="Ada">Ada</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                        </select>                    
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="anak_ke" class="col-4 col-form-label">Anak Ke</label>
                    <div class="col-8">
                        <input type="number" class="form-control" name="anak_ke" id="anak_ke">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="sekolah_lama_id" class="col-md-2 col-form-label">Nama Sekolah Sebelumnya</label>
            <div class="col-md-10">
                <select class="form-control select2" name="sekolah_lama_id" id="sekolah_lama_id">
                    <option selected disabled>Pilih Sekolah</option>
                    <?php 
                    foreach($sekolah as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
                    <?php $no++; endforeach; ?>
                </select>            
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
        $('#nik').mask('0000000000000000');
        $('#no_kk').mask('0000000000000000');
        $('#nipd').mask('000000000000000000');
        $('#nisn').mask('00000000000000000000');

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
            $('#nama_siswa').val(data.data.nama_siswa);
            $('#nik').val(data.data.nik);
            $('#no_kk').val(data.data.no_kk);
            $('#nipd').val(data.data.nipd);
            $('#nisn').val(data.data.nisn);
            $('select[name="jenis_kelamin"]').val(data.data.jenis_kelamin).change();
            $('select[name="agama"]').val(data.data.agama).change();
            $('#tempat_lahir').val(data.data.tempat_lahir);
            $('#tgl_lahir').val(data.data.tgl_lahir);
            $('#jenis_tinggal').val(data.data.jenis_tinggal);
            $('select[name="transportasi"]').val(data.data.transportasi).change();
            $('#no_hp').val(data.data.no_hp);
            $('#email').val(data.data.email);
            $('#skhun').val(data.data.skhun);
            $('#no_kps').val(data.data.no_kps);
            $('#no_peserta_un').val(data.data.no_peserta_un);
            $('#no_seri_ijazah').val(data.data.no_seri_ijazah);
            $('#no_kip').val(data.data.no_kip);
            $('#no_kks').val(data.data.no_kks);
            $('#no_akta_lahir').val(data.data.no_akta_lahir);
            $('#no_rekening').val(data.data.no_rekening);
            $('#bank').val(data.data.bank);
            $('#atas_nama').val(data.data.atas_nama);
            $('select[name="kelayakan_pip"]').val(data.data.kelayakan_pip).change();
            $('#alasan').val(data.data.alasan);
            $('select[name="kebutuhan_khusus"]').val(data.data.kebutuhan_khusus).change();
            $('#anak_ke').val(data.data.anak_ke);
            $('select[name="sekolah_lama_id"]').val(data.data.sekolah_lama_id).change();
            $('#alamat_lengkap').val(data.data.alamat_lengkap);
            $('#nagari').val(data.data.alamat);
            $('#nagari_id').val(data.data.nagari_id);

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
                document.querySelector('.sw-token-response').value = token;
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