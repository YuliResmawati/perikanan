
<span class="badge badge-soft-info p-1"> KECAMATAN <strong><?=$nama_kecamatan[0]->nama_kecamatan?></strong></span>
<br>
<br>
<div class="form-group row mt-10 ">
    <label for="bulan" class="col-sm-2 col-form-label">Pilih Bulan</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="bulan" id="bulan">
            <?php $no = 1; foreach($bulan as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->bulan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10 ">
    <label for="komoditas" class="col-sm-2 col-form-label">Pilih Jenis</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="jenis" id="jenis">
            <option disabled>Pilih Jenis Ikan</option>
            <option value="<?= encrypt_url('1', $id_key) ?>" selected>Ikan Laut</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Ikan Tawar</option>
        </select>
    </div>
</div>
<div class="form-group row mt-10 ">
    <label for="komoditas" class="col-sm-2 col-form-label">Pilih Komoditas</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="komoditas" id="komoditas_select">
            <option selected disabled>Komoditas Tidak Tersedia</option>  
        </select>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-icon  btn-primary" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>
<div class="table-responsive mb-4 mt-4">
    <table id="table-panel-harga" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Tanggal</th>
                <th style="text-align: center; vertical-align: middle;">Harga</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-panel-harga';
        let id ='<?= encrypt_url($id, $id_key) ?>';

        url_get_data = "<?= base_url($uri_mod.'/AjaxGetPanel/list/') ?>" + id;

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_bulan = $('[name="bulan"]').val();
                data.filter_komoditas = $('[name="komoditas"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "tanggal", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "harga", searchable:false, orderable:false},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }
        oTable = intiate_datatables(datatables);

        
        $("#cari").click(function() {
            oTable.ajax.reload();
        });


        $('#jenis').change(function() {
            var id = $(this).val();
            var id_kec ='<?= encrypt_url($id, $id_key) ?>';

            $.ajax({
                url: "<?= base_url('bidang/daft_harga_ikan_budidaya/AjaxGetAvailable') ?>",
                method : "POST",
                data : {id: id, dkpp_c_token: csrf_value, id_kec: id_kec},
                async : true,
                dataType : 'json',
                success: function(data) {
                    if (data.status == true) {
                        if (data.data !== null) {
                            csrf_value = data.token;
                            var html = '<option value="" selected disabled>Pilih Komoditas</option>';
                            var index;

                            for (index = 0; index < data.data.length; index++) {
                                html += '<option value='+data.data[index].id+'>'+data.data[index].komoditas+'</option>';
                            }

                            $('#komoditas_select').html(html);

                        } else {
                            var html = '<option value="" selected disabled>Komoditas Tidak Tersedia</option>';
                            $('#komoditas_select').html(html);
                        }
                    } else {
                        var html = '<option value="" selected disabled>Komoditas Tidak Tersedia</option>';
                        $('#komoditas_select').html(html);
                    }
                },
                error:function() {
                    bootbox.alert({
                        title: "Error",
                        centerVertical: true,
                        message: '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
                    });
                }
            });
            return false;
        });

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

</script>