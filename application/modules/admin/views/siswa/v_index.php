<?php
$form_name = "form-siswa";
$modal_name = "modal-siswa";

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
            <select id="filter_sekolah" name="filter_sekolah" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Sekolah</option>
                <?php foreach($sekolah as $row): ?>
                    <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
                <?php $no++; endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row mt-10">
        <label for="filter_rombel" class="col-md-2 col-form-label">Rombel</label>
        <div class="col-sm-10">
            <select id="filter_rombel" name="filter_rombel" class="form-control select2" required>
            <option value="ALL" selected>Pilihan Tidak Tersedia</option>
            </select>
        </div>
    </div>
<?php    }else{ ?>
    <div class="form-group row mt-10">
        <label for="filter_rombel" class="col-md-2 col-form-label">Rombel</label>
        <div class="col-sm-10">
            <select id="filter_rombel" name="filter_rombel" class="form-control select2" required>
            <option value="ALL" selected>Pilih Rombel</option>
            <?php foreach($rombel as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->tingkatan.$row->nama_rombel ?></option>
            <?php $no++; endforeach; ?>
            </select>
        </div>
    </div>
<?php } ?>

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
    <table id="table-siswa" class="table table-striped w-100">
        <thead>
            <tr>
            <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Nama Siswa</th>
                <th style="vertical-align: middle;">NIK</th>
                <th style="vertical-align: middle;">NISN</th>
                <th style="vertical-align: middle;">Alamat</th>
                <th style="vertical-align: middle;">Sekolah</th>
                <th style="vertical-align: middle;">Kelas</th>
                <th style="vertical-align: middle;">Data Siswa</th>
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
                    <div class="form-group row">
                        <label for="nama_siswa" class="col-md-2 col-form-label">Nama Siswa</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="nama_sekolah" class="col-4 col-form-label">Sekolah </label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="rombel" class="col-4 col-form-label">Rombel </label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="rombel" id="rombel" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="nik" class="col-4 col-form-label">NIK </label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="nik" id="nik" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_kk" class="col-4 col-form-label">No KK </label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_kk" id="no_kk" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nipd" class="col-4 col-form-label">NIPD</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="nipd" id="nipd" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="nisn" class="col-4 col-form-label">NISN</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="nisn" id="nisn" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="jenis_kelamin" class="col-4 col-form-label">Jenis Kelamin</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="agama" class="col-4 col-form-label">Agama</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="agama" id="agama" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-4 col-form-label">Tempat Lahir</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="tgl_lahir" class="col-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-8">
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-md-2 col-form-label">Alamat (Provinsi, Kota, Kecamatan, Kelurahan) </label>
                        <div class="col-md-10">
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="nagari" id="nagari" rows="2" readonly></textarea>
                            </div>           
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat_lengkap" class="col-md-2 col-form-label">Detail Alamat (Penulisan Harus Sesuai EYD)</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" rows="4" readonly></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="jenis_tinggal" class="col-4 col-form-label">Tinggal bersama</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="jenis_tinggal" id="jenis_tinggal" readonly>
                                </div>                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="transportasi" class="col-4 col-form-label">Transportasi</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="transportasi" id="transportasi" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_hp" class="col-4 col-form-label">Nomor Hp</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_hp" id="no_hp" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="email" class="col-4 col-form-label">Email</label>
                                <div class="col-8">
                                    <input type="email" class="form-control" name="email" id="email" readonly>
                            </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="skhun" class="col-4 col-form-label">No. SKHUN</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="skhun" id="skhun" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_kps" class="col-4 col-form-label">No. KKS</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_kps" id="no_kps" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_peserta_un" class="col-4 col-form-label">No. Peserta UN</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_peserta_un" id="no_peserta_un" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_seri_ijazah" class="col-4 col-form-label">No. Seri Ijazah</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_seri_ijazah" id="no_seri_ijazah" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_kip" class="col-4 col-form-label">No. KIP</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_kip" id="no_kip" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_kks" class="col-4 col-form-label">No. KKS</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_kks" id="no_kks" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="no_akta_lahir" class="col-4 col-form-label">No. Akta Lahir</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_akta_lahir" id="no_akta_lahir" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="no_rekening" class="col-4 col-form-label">No. Rekening</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="no_rekening" id="no_rekening" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bank" class="col-4 col-form-label">Nama Bank</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="bank" id="bank" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="atas_nama" class="col-4 col-form-label">Rekening Atas Nama</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="atas_nama" id="atas_nama" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kelayakan_pip" class="col-4 col-form-label">Kelayakan PIP</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="kelayakan_pip" id="kelayakan_pip" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="alasan" class="col-4 col-form-label">Alasan Kelayakan</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="alasan" id="alasan" rows="4" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kebutuhan_khusus" class="col-4 col-form-label">Kebutuhan Khusus</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="kebutuhan_khusus" id="kebutuhan_khusus" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row mb-3">
                                <label for="anak_ke" class="col-4 col-form-label">Anak Ke</label>
                                <div class="col-8">
                                    <input type="number" class="form-control" name="anak_ke" id="anak_ke" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sekolah_lama_nama" class="col-md-2 col-form-label">Nama Sekolah Sebelumnya</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="sekolah_lama_nama" id="sekolah_lama_nama" readonly>
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
        table_name = '#table-siswa';
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
                data.filter_rombel = $('[name="filter_rombel"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nama_siswa", "sClass": "text-nowrap"},
                {"data": "nik", "sClass": "text-nowrap"},
                {"data": "nisn", "sClass": "text-nowrap"},
                {"data": "alamat", searchable:false, orderable:false},
                {"data": "nama_sekolah"},
                {"data": "kelas", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "detail_siswa", searchable:false, orderable:false, "sClass": "text-nowrap"},
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
            }
            data = get_data_by_id(aOption);
            if(data!=false){
                $(form_name).addClass('form-edit');
                $(form_name).removeClass('form-tambah');
                $(form_name).attr('data-id', $(this).data('id'));
                $('#nama_siswa').val(data.data.nama_siswa);
                $('#nik').val(data.data.nik);
                $('#no_kk').val(data.data.no_kk);
                $('#nipd').val(data.data.nipd);
                $('#nisn').val(data.data.nisn);
                $('#jenis_kelamin').val(data.data.jenis_kelamin_view);
                $('#agama').val(data.data.agama);
                $('#tempat_lahir').val(data.data.tempat_lahir);
                $('#tgl_lahir').val(data.data.tgl_lahir);
                $('#jenis_tinggal').val(data.data.jenis_tinggal);
                $('#transportasi').val(data.data.transportasi);
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
                $('#kelayakan_pip').val(data.data.kelayakan_pip);
                $('#alasan').val(data.data.alasan);
                $('#kebutuhan_khusus').val(data.data.kebutuhan_khusus);
                $('#anak_ke').val(data.data.anak_ke);
                $('#sekolah_lama_nama').val(data.data.sekolah_lama_nama);
                $('#alamat_lengkap').val(data.data.alamat_lengkap);
                $('#nagari').val(data.data.alamat);
                $('#nagari_id').val(data.data.nagari_id);
                $('#nama_sekolah').val(data.data.nama_sekolah);
                $('#rombel').val(data.data.rombel);
            }
        });
    });

    $('#filter_tipe_sekolah').change(function() {
        var tipe_sekolah = $(this).val();
        $.ajax({
            url: "<?= base_url('app/AjaxGetSekolahByTipe') ?>",
            method : "POST",
            data : {tipe_sekolah: tipe_sekolah},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    csrf_value = data.token;
                    var html = '<option value="ALL" selected>Tampilkan Semua Sekolah</option>';

                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        html += '<option value='+data.data[index].id+'>'+data.data[index].nama_sekolah+'</option>';
                        no++;
                    }

                    $('#filter_sekolah').html(html);
                }else{
                    var html = '<option value="" selected disabled>Pilihan Tidak Tersedia</option>';
                    $('#filter_sekolah').html(html);
                } 
            }
        });
                return false;
    });

    $('#filter_sekolah').change(function() {
        var sekolah_id = $(this).val();
        $.ajax({
            url: "<?= base_url('app/AjaxGetRombelBySekolah') ?>",
            method : "POST",
            data : {sekolah_id: sekolah_id},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    csrf_value = data.token;
                    var html = '<option value="ALL" selected>Tampilkan Semua Rombel</option>';

                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        html += '<option value='+data.data[index].id+'>'+data.data[index].tingkatan+data.data[index].nama_rombel+'</option>';
                        no++;
                    }

                    $('#filter_rombel').html(html);
                }else{
                    var html = '<option value="" selected disabled>Pilihan Tidak Tersedia</option>';
                    $('#filter_rombel').html(html);
                } 
            }
        });
                return false;
    });

</script>