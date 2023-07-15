<?php
    if($this->logged_level !== "3"){ ?>
        <div class="form-group row mt-10">
            <label for="filter_tipe_sekolah" class="col-md-2 col-form-label">Tingkatan Sekolah</label>
            <div class="col-sm-10">
                <select id="filter_tipe_sekolah" name="filter_tipe_sekolah" class="form-control select2" data-search="false" required>
                    <option value="ALL" selected>Tampilkan Semua Tingkatan</option>
                    <?php foreach($tipe_sekolah as $row): ?>
                        <option value="<?= $row->tipe_sekolah ?>"><?= $row->tipe_sekolah ?></option>
                    <?php $no++; endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row mt-10">
            <label for="filter_sekolah" class="col-md-2 col-form-label">Sekolah</label>
            <div class="col-sm-10">
                <select id="filter_sekolah" name="filter_sekolah" class="form-control select2" data-search="false" required>
                <option value="ALL" selected>Tampilkan Semua Sekolah</option>
                    <?php foreach($sekolah as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
                    <?php $no++; endforeach; ?>
                </select>
            </div>
        </div>
<?php    }
?>
<div class="form-group row mt-10">
    <label for="filter_ptk" class="col-md-2 col-form-label">Jenis PTK</label>
    <div class="col-sm-10">
        <select id="filter_ptk" name="filter_ptk" class="form-control select2" data-search="false" required>
        <option value="ALL" selected>Tampilkan Semua Jenis</option>
            <?php foreach($jenis_ptk as $row): ?>
                <option value="<?= $row->jenis_ptk ?>"><?= $row->jenis_ptk ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_status_kepegawaian" class="col-md-2 col-form-label">Status Kepegawaian</label>
    <div class="col-sm-10">
        <select id="filter_status_kepegawaian" name="filter_status_kepegawaian" class="form-control select2" data-search="false" required>
        <option value="ALL" selected>Tampilkan Semua Status</option>
            <?php foreach($status_kepegawaian as $row): ?>
                <option value="<?= $row->status_kepegawaian ?>"><?= $row->status_kepegawaian ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row mt-10">
    <label for="filter_tahun_kgb" class="col-md-2 col-form-label">Terakhir KGB</label>
    <div class="col-sm-10">
        <select id="filter_tahun_kgb" name="filter_tahun_kgb" class="form-control select2" data-search="false" required>
            <option value="ALL" selected>Tampilkan Semua</option>
            <?php 
                $sekarang = date('Y');
                for($i=2018;$i<=$sekarang;$i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
            <?php $no++; endfor; ?>
        </select>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-blue" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>

<div class="table-responsive mb-4 mt-4">
    <table id="table-guru" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Sekolah</th>
                <th style="vertical-align: middle;">Nama Guru</th>
                <th style="vertical-align: middle;">NIK</th>
                <th style="vertical-align: middle;">NIP</th>
                <th style="vertical-align: middle;">NUPTK</th>
                <th class="text-center">Pangkat</th>                
                <th class="text-center">No. Hp</th>                
                <th class="text-center">Jenis PTK</th>                 
                <th class="text-center">Data Guru</th>                 
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- sample modal content -->

<div id="<?= $modal_name ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <?= form_open($uri_mod.'/AjaxSave', 'id="'.$form_name.'" data-id="" class="form-tambah"');?>
                <div class="modal-body p-4">
                <?php
                    if($this->logged_level !== "3"){ ?>
                        <div class="form-group row">
                            <label for="sekolah_id" class="col-md-2 col-form-label">Nama Sekolah <?= label_required() ?></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="sekolah_id" id="sekolah_id">
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
                                <input type="text" class="form-control" name="nik" id="nik" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="nip" class="col-4 col-form-label">NIP</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="nip" id="nip" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="nuptk" class="col-4 col-form-label">NUPTK</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="nuptk" id="nuptk" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-4 col-form-label">Jenis Kelamin <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="agama" class="col-4 col-form-label">Agama <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="agama" id="agama" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-4 col-form-label">Tempat Lahir <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="tgl_lahir" class="col-4 col-form-label">Tanggal Lahir <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="jenjang" class="col-4 col-form-label">Jenjang <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="jenjang" id="jenjang" readonly>
                            </div>                
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="status_tugas" class="col-4 col-form-label">Status Tugas</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="status_tugas" id="status_tugas" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="sk_cpns" class="col-4 col-form-label">No. SK CPNS</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="sk_cpns" id="sk_cpns" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="tgl_sk_cpns" class="col-4 col-form-label">Tanggal SK CPNS</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="tgl_sk_cpns" id="tgl_sk_cpns" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="sk_pengangkatan" class="col-4 col-form-label">No. SK Pengangkatan</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="sk_pengangkatan" id="sk_pengangkatan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="tgl_sk_pengangkatan" class="col-4 col-form-label">Tanggal SK Pengangkatan</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="tgl_sk_pengangkatan" id="tgl_sk_pengangkatan" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="jenis_ptk" class="col-4 col-form-label">Jenis PTK <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="jenis_ptk" id="jenis_ptk" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="pendidikan" class="col-4 col-form-label">Pendidikan Terakhir</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="pendidikan" id="pendidikan" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="bidang_studi_pendidikan" class="col-4 col-form-label">Bidang Studi Pendidikan</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="bidang_studi_pendidikan" id="bidang_studi_pendidikan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="bidang_studi_sertifikasi" class="col-4 col-form-label">Bidang Sertifikasi</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="bidang_studi_sertifikasi" id="bidang_studi_sertifikasi" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="pangkat" class="col-4 col-form-label">Pangkat/Golongan <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="pangkat" id="pangkat" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="kgb_terakhir" class="col-4 col-form-label">Tahun Terakhir KGB <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="kgb_terakhir" id="kgb_terakhir" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="status_kepegawaian" class="col-4 col-form-label">Status Kepegawaian <?= label_required() ?></label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="status_kepegawaian" id="status_kepegawaian" readonly>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row mb-3">
                            <label for="no_hp" class="col-4 col-form-label">Nomor Telp</label>
                            <div class="col-8">
                                <input type="text" class="form-control" name="no_hp" id="no_hp" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-md-2 col-form-label">Alamat (Provinsi, Kota, Kecamatan, Kelurahan) <?= label_required() ?></label>
                    <div class="col-md-10">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="nagari" id="nagari" readonly>
                        </div>           
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat_lengkap" class="col-md-2 col-form-label">Detail Alamat (Penulisan Harus Sesuai EYD) <?= label_required() ?></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="alamat_lengkap" id="alamat_lengkap" readonly>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                </div>
                <?= form_close(); ?>
        </div>
    </div>
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-guru';
        modal_name = "#<?= $modal_name ?>";
        form_name = "#<?= $form_name ?>";

        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_tipe_sekolah = $('[name="filter_tipe_sekolah"]').val();
                data.filter_sekolah = $('[name="filter_sekolah"]').val();
                data.filter_ptk = $('[name="filter_ptk"]').val();
                data.filter_status_kepegawaian = $('[name="filter_status_kepegawaian"]').val();
                data.filter_tahun_kgb = $('[name="filter_tahun_kgb"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nama_sekolah", "sClass": "text-nowrap"},
                {"data": "nama_guru", "sClass": "text-nowrap"},
                {"data": "nik", "sClass": "text-nowrap"},
                {"data": "nip", "sClass": "text-nowrap"},
                {"data": "nuptk", "sClass": "text-nowrap"},
                {"data": "pangkat", "sClass": "text-nowrap"},
                {"data": "no_hp", "sClass": "text-nowrap"},
                {"data": "jenis_ptk"},
                {"data": "detail_guru"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

        $(document).on("click", ".button-hapus", function (e) {
            e.preventDefault();
            aOption = {
                title: "Hapus Data?",
                message: "Yakin ingin hapus data?",
                url: "<?= base_url($uri_mod.'/AjaxDel/')?>" + $(this).attr('data-id'),
                table: oTable,
            };
            
            btn_confirm_action(aOption);
        })

        $(document).on("click", ".button-status", function (e) {
            e.preventDefault();
            aOption = {
                title: "Ubah status?",
                message: "Yakin ingin ubah status data?",
                url: "<?= base_url($uri_mod.'/AjaxActive/')?>" + $(this).attr('data-id'),
                table: oTable,
            };

            btn_confirm_action(aOption);
        });

        $(document).on("click", ".button-view", function (e) {
            e.preventDefault();
            aOption = {
                url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + $(this).data('id'),
                data: {
                    simpeg_c_token : csrf_value
                }
            }
            data = get_data_by_id(aOption);
            if(data!=false){
                console.log(data);
                $(form_name).addClass('form-edit');
                $(form_name).removeClass('form-tambah');
                $(form_name).attr('data-id', $(this).data('id'));
                $('#nama_guru').val(data.data.nama_guru);
                $('#nik').val(data.data.nik);
                $('#nip').val(data.data.nip);
                $('#nuptk').val(data.data.nuptk);
                $('#jenis_kelamin').val(data.data.jenis_kelamin);
                $('#agama').val(data.data.agama);
                $('#nuptk').val(data.data.nuptk);
                $('#nuptk').val(data.data.nuptk);
                $('#tempat_lahir').val(data.data.tempat_lahir);
                $('#tgl_lahir').val(data.data.tgl_lahir);
                $('#status_tugas').val(data.data.status_tugas);
                $('#jenjang').val(data.data.jenjang);
                $('#no_hp').val(data.data.no_hp);
                $('#sk_cpns').val(data.data.sk_cpns);
                $('#tgl_sk_cpns').val(data.data.tgl_sk_cpns);
                $('#sk_pengangkatan').val(data.data.sk_pengangkatan);
                $('#tgl_sk_pengangkatan').val(data.data.tgl_sk_pengangkatan);
                $('#jenis_ptk').val(data.data.jenis_ptk);
                $('#pendidikan').val(data.data.pendidikan);
                $('#bidang_studi_pendidikan').val(data.data.bidang_studi_pendidikan);
                $('#bidang_studi_sertifikasi').val(data.data.bidang_studi_sertifikasi);
                $('#status_kepegawaian').val(data.data.status_kepegawaian);
                $('#pangkat').val(data.data.pangkat);
                $('#alamat_lengkap').val(data.data.alamat_lengkap);
                $('#nagari').val(data.data.alamat);
                $('#kgb_terakhir').val(data.data.kgb_terakhir);

            }
        });


        

    });
</script>