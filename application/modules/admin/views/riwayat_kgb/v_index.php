<?php if($this->logged_level !== "3"){ ?>
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
                    <option value="ALL" selected>Pilihan Tidak Tersedia</option>
                </select>
            </div>
        </div>

<?php    }
?>
        <div class="form-group row mt-10">
            <label for="filter_guru" class="col-md-2 col-form-label">Guru</label>
            <div class="col-sm-10">
                <select id="filter_guru" name="filter_guru" class="form-control select2" required>
                <?php if($this->logged_level !== "3"){ ?>
                    <option value="ALL" selected>Pilihan Tidak Tersedia</option>
                <?php } else{ ?>
                    <option value="ALL" selected>Tampilkan Semua Guru</option>
                    <?php foreach($guru as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_guru.' - '.$row->nip ?></option>
                    <?php endforeach; 
                } ?>
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

<div class="table-responsive mb-4 mt-3">
    <table id="table-riwayat-kgb" class="table table-striped w-100">
    <thead>
            <tr>
                <th style="vertical-align: middle;">#</th> 
                <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th>_Npsn</th>
                <th>_NamaSekolah</th>
                <th class="text-nowrap text-center">Nama Sekolah
                    <hr class="m-0">NPSN
                </th>
                <th style="vertical-align: middle;">Jenis Kelamin</th>             
                <th style="vertical-align: middle;">Bidang Studi</th>             
                <th style="vertical-align: middle;">Tanggal KGB</th>
                <th style="vertical-align: middle;">File</th>
                <th style="vertical-align: middle;">Status</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script type="text/javascript">

$(document).ready(function() {
    table_name = '#table-riwayat-kgb';
    url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

    datatables = {
        table: $(table_name),
        ordering: true,
        url: url_get_data,
        data: function (data){
            data.silatpendidikan_c_token = csrf_value;
            data.filter_tipe_sekolah = $('[name="filter_tipe_sekolah"]').val();
            data.filter_sekolah = $('[name="filter_sekolah"]').val();
            data.filter_guru = $('[name="filter_guru"]').val();
        }, 
        columns: [
            {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nip", "visible": false},
                {"data": "nama_guru","visible": false},
                {"data": "nama", searchable: false},
                {"data": "npsn", "visible": false},
                {"data": "nama_sekolah","visible": false},
                {"data": "sekolah", searchable: false},
                {"data": "jk", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "bidang_studi_pendidikan", searchable:false, orderable:false},
                {"data": "tanggal", searchable:false, orderable:false},
                {"data": "berkas", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status_", searchable:false, orderable:false, "sClass": "text-nowrap"},
        ]
    }

    oTable = intiate_datatables(datatables);

    $("#cari").click(function() {
        oTable.ajax.reload();
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
            url: "<?= base_url('app/AjaxGetGuruBySekolah') ?>",
            method : "POST",
            data : {sekolah_id: sekolah_id},
            async : true,
            dataType : 'json',
            success: function(data) {
                if (data.status == true) {
                    csrf_value = data.token;
                    var html = '<option value="ALL" selected>Tampilkan Semua Guru</option>';

                    var index;
                    var no  = 1;

                    for (index = 0; index < data.data.length; index++) {
                        html += '<option value='+data.data[index].id+'>'+data.data[index].nama_guru+' - '+data.data[index].nip+'</option>';
                        no++;
                    }

                    $('#filter_guru').html(html);
                }else{
                    var html = '<option value="" selected disabled>Pilihan Tidak Tersedia</option>';
                    $('#filter_guru').html(html);
                } 
            }
        });
        return false;
    });


</script>