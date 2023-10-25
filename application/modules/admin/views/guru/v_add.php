<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
        <input type="hidden" class="gr-token-response" name="gr-token-response">

        <?php
            if($this->logged_level !== "3"){ ?>
                <div class="form-group row">
                    <label for="sekolah_id" class="col-md-2 col-form-label">Nama Sekolah <?= label_required() ?></label>
                    <div class="col-md-10">
                        <select class="form-control select2" name="sekolah_id" id="sekolah_id">
                            <option selected disabled>Pilih Sekolah</option>
                            <?php 
                            foreach($sekolah as $row): ?>
                                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
                            <?php $no++; endforeach; ?>
                        </select>            
                    </div>
                </div>
        <?php } ?>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nama_guru" class="col-4 col-form-label">Nama Guru <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nama_guru" id="nama_guru">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nik" class="col-4 col-form-label">NIK <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nik" id="nik">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="gelar_depan" class="col-4 col-form-label">Gelar Depan</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="gelar_depan" id="gelar_depan">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="gelar_belakang" class="col-4 col-form-label">Gelar Belakang</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="gelar_belakang" id="gelar_belakang">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nip" class="col-4 col-form-label">NIP</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nip" id="nip">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="nuptk" class="col-4 col-form-label">NUPTK</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="nuptk" id="nuptk">
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
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="jenjang" class="col-4 col-form-label">Jenjang <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="jenjang" id="jenjang">
                            <option selected disabled>Pilih Jenjang</option>
                            <option value="PAUD">PAUD</option>
                            <option value="PNF">PNF</option>
                            <option value="SMP">SMP</option>
                            <option value="SD">SD</option>
                        </select>
                    </div>                
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="status_tugas" class="col-4 col-form-label">Status Tugas</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="status_tugas" id="status_tugas">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="sk_cpns" class="col-4 col-form-label">No. SK CPNS</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="sk_cpns" id="sk_cpns">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_sk_cpns" class="col-4 col-form-label">Tanggal SK CPNS</label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_sk_cpns" id="tgl_sk_cpns">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="sk_pengangkatan" class="col-4 col-form-label">No. SK Pengangkatan</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="sk_pengangkatan" id="sk_pengangkatan">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="tgl_sk_pengangkatan" class="col-4 col-form-label">Tanggal SK Pengangkatan</label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="tgl_sk_pengangkatan" id="tgl_sk_pengangkatan">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="jenis_ptk" class="col-4 col-form-label">Jenis PTK <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="jenis_ptk" id="jenis_ptk">
                            <option selected disabled>Pilih Jenis PTK</option>
                            <option value="Tenaga Administrasi Sekolah">Tenaga Administrasi Sekolah</option>
                            <option value="Guru BK">Guru BK</option>
                            <option value="Tukang Kebun">Tukang Kebun</option>
                            <option value="Tutor">Tutor</option>
                            <option value="Pesuruh/Office Boy">Pesuruh/Office Boy</option>
                            <option value="Pamong Belajar">Pamong Belajar</option>
                            <option value="Guru Pengganti">Guru Pengganti</option>
                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                            <option value="Guru Mapel">Guru Mapel</option>
                            <option value="Guru TIK">Guru TIK</option>
                            <option value="Guru Pendamping Khusus">Guru Pendamping Khusus</option>
                            <option value="Guru Kelas">Guru Kelas</option>
                            <option value="Tenaga Perpustakaan">Tenaga Perpustakaan</option>
                            <option value="Penjaga Sekolah">Penjaga Sekolah</option>
                            <option value="Petugas Keamanan">Petugas Keamanan</option>
                        </select>                    
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="pendidikan" class="col-4 col-form-label">Pendidikan Terakhir</label>
                    <div class="col-8">
                    <select class="form-control select2" name="pendidikan" id="pendidikan">
                            <option selected disabled>Pilih Jenis Pendidikan Terakhir</option>
                            <option value="SMP/Sederajat">SMP/Sederajat</option>
                            <option value="SMA/Sederajat">SMA/Sederajat</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>                     
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="bidang_studi_pendidikan" class="col-4 col-form-label">Bidang Studi Pendidikan</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="bidang_studi_pendidikan" id="bidang_studi_pendidikan">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="bidang_studi_sertifikasi" class="col-4 col-form-label">Bidang Sertifikasi</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="bidang_studi_sertifikasi" id="bidang_studi_sertifikasi">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="pangkat" class="col-4 col-form-label">Pangkat/Golongan <?= label_required() ?></label>
                    <div class="col-8">
                    <select class="form-control select2" name="pangkat" id="pangkat">
                            <option selected disabled>Pilih Pangkat/Golongan Terakhir</option>
                            <option value="I/a">I/a</option>
                            <option value="I/b">I/b</option>
                            <option value="I/c">I/c</option>
                            <option value="I/d">I/d</option>
                            <option value="II/a">II/a</option>
                            <option value="II/b">II/b</option>
                            <option value="II/c">II/c</option>
                            <option value="II/d">II/d</option>
                            <option value="III/a">III/a</option>
                            <option value="III/b">III/b</option>
                            <option value="III/c">III/c</option>
                            <option value="III/d">III/d</option>
                            <option value="IV/a">IV/a</option>
                            <option value="IV/b">IV/b</option>
                            <option value="IV/c">IV/c</option>
                            <option value="IV/d">IV/d</option>
                        </select>                     
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="kgb_terakhir" class="col-4 col-form-label">Terakhir KGB <?= label_required() ?></label>
                    <div class="col-8">
                        <input type="date" class="form-control" name="kgb_terakhir" id="kgb_terakhir">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="status_kepegawaian" class="col-4 col-form-label">Status Kepegawaian <?= label_required() ?></label>
                    <div class="col-8">
                        <select class="form-control select2" name="status_kepegawaian" id="status_kepegawaian">
                            <option selected disabled>Pilih Status Kepegawaian</option>
                            <option value="Tenaga Honor Sekolah">Tenaga Honor Sekolah</option>
                            <option value="PNS Depag">PNS Depag</option>
                            <option value="PNS Diperbantukan">PNS Diperbantukan</option>
                            <option value="Guru Honor Sekolah">Guru Honor Sekolah</option>
                            <option value="GTY/PTY">GTY/PTY</option>
                            <option value="PNS">PNS</option>
                            <option value="Honor Daerah TK.II Kab/Kota">Honor Daerah TK.II Kab/Kota</option>
                            <option value="PPPK">PPPK</option>
                        </select>                      
                </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row mb-3">
                    <label for="no_hp" class="col-4 col-form-label">Nomor Telp</label>
                    <div class="col-8">
                        <input type="text" class="form-control" name="no_hp" id="no_hp">
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
        $('#nuptk').mask('0000000000000000');
        $('#nip').mask('000000000000000000');
        $('#no_hp').mask('00000000000000000000');

        ajax_get_region = {
            element: $('#data_alamat_domisili'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetRegion') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Kecamatan atau Kelurahan',
        }

        init_ajax_select2_paging(ajax_get_region);

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
                document.querySelector('.gr-token-response').value = token;
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