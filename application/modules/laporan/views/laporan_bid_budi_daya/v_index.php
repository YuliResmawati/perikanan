
<div class="form-group row">
    <label for="jenis_rekap" class="col-md-2 col-form-label">Jenis Rekapitulasi <?= label_required() ?></label>  
    <div class="col-md-10">
        <select id="jenis_rekap" name="jenis_rekap" class="form-control select2" required>
            <option value="" selected disabled>Pilih Rekapitulasi</option>
            <option value=<?= encrypt_url('1', $id_key) ?>>1. Produksi Perikanan Tangkap</option>
            <option value=<?= encrypt_url('2', $id_key) ?>>2. Registrasi Kelompok Nelayan</option>
            <option value=<?= encrypt_url('3', $id_key) ?>>3. Daftar Harga Ikan Hasil Tangkapan Nelayan</option>
            <option value=<?= encrypt_url('4', $id_key) ?>>4. Armada, Alat Tangkap dan Alat Bantu Penangkapan Ikan</option>
            <option value=<?= encrypt_url('5', $id_key) ?>>5. Daftar Harga IKan Budidaya Di Tingkat Produsen</option>
            <option value=<?= encrypt_url('6', $id_key) ?>>6. Produksi Budidaya Perikanan</option>
            <option value=<?= encrypt_url('7', $id_key) ?>>7. Jumlah Unit Pembenihan Rakyat (UPR)</option>
            <option value=<?= encrypt_url('8', $id_key) ?>>8. Produksi Pembenihan Ikan</option>
            <option value=<?= encrypt_url('9', $id_key) ?>>9. Jumlah Kelompok Pembudidaya Ikan</option>
            <option value=<?= encrypt_url('10', $id_key) ?>>10. Jumlah Pembudidaya Ikan</option>
        </select>
    </div>
</div>

<div class="form-group row" id="filter_">
    <label for="jenis_filter" class="col-md-2 col-form-label">Jenis Filter <?= label_required() ?></label>
    <div class="col-md-10">
        <select id="jenis_filter" name="jenis_filter" class="form-control select2" required>
            <option value="" selected disabled>Pilih Filter</option>
            <option value=<?= encrypt_url('1', $id_key) ?>>1. Bulan</option>
            <option value=<?= encrypt_url('2', $id_key) ?>>2. Triwulan</option>
            <option value=<?= encrypt_url('3', $id_key) ?>>3. Tahun</option>
        </select>
    </div>
</div>

<div class="form-group row" id="bulan_" style="display: none;">
    <label for="bulan" class="col-md-2 col-form-label">Bulan <?= label_required() ?></label>
    <div class="col-md-10">
        <select class="form-control select2" name="bulan" id="bulan">
            <option value="" selected disabled>Pilih Bulan</option>
            <?php $no = 1; foreach($bulan as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->bulan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row" id="triwulan_" style="display: none;">
    <label for="triwulan" class="col-md-2 col-form-label">Triwulan <?= label_required() ?></label>
    <div class="col-md-10">
        <select id="triwulan" name="triwulan" class="form-control select2" required>
            <option value="" selected disabled>Pilih Triwulan</option>
            <option value=<?= encrypt_url('1', $id_key) ?>>1. Triwulan 1</option>
            <option value=<?= encrypt_url('2', $id_key) ?>>2. Triwulan 2</option>
            <option value=<?= encrypt_url('3', $id_key) ?>>3. Triwulan 3</option>
            <option value=<?= encrypt_url('4', $id_key) ?>>4. Triwulan 4</option>
        </select>
    </div>
</div>

<div class="form-group row" id="tahun_" style="display: none;">
    <label for="tahun" class="col-md-2 col-form-label">Tahun</label>
    <div class="col-md-10">
        <select id="tahun" name="tahun" class="form-control select2" required>
            <option selected="selected" disabled>Pilih Tahun</option>
            <?php $no = 1; for($i=2024; $i <= date('Y')+1; $i++) {?>
                <option value="<?= encrypt_url($i, $id_key) ?>"><?= $no. ' - ' .$i ?></option>
            <?php $no++; } ?>
        </select>
    </div>
</div>
<div class="form-group row" id="hari_" style="display: none;">
    <label for="tanggal" class="col-md-2 col-form-label">Tanggal</label>
    <div class="col-md-10">
        <input type="text" class="form-control flatpickr" name="tanggal" id="tanggal">
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-sm-2"></div>
        <div class="col-sm-10 col-12">
            
            <button type="button" class="btn btn-danger" id="cetak">
                <i class="icon-printer"></i> Cetak</a>
            </button>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info' role='status'><span class='sr-only'></span></div>
    </div>
</div>

<div id="preview">

</div>

<script type="text/javascript">
	
    $(document).ready(function(e) {
        $( ".flatpickr" ).flatpickr({
            disableMobile : true
        });
    });
    $('#jenis_rekap').change(function() {
        let data = $('#jenis_rekap').val();

        if (data == 'UXZSVWowUUpRSjNFeFVjd005YVh6Zz09'){
            $('#filter_').hide();
            $('#bulan_').hide();
            $('#triwulan_').hide();
            $('#tahun_').hide();
            $('#hari_').hide();
            $("#jenis_filter").val('').trigger('change') ;
        } else if (data == 'QTNUMzhnbTZjRytZZXd1Vkc1dG1yUT09' || data == 'aTdBQ01WSUZtenJDeEhzalF6R0drZz09'){
            $('#filter_').hide();
            $('#bulan_').hide();
            $('#triwulan_').hide();
            $('#tahun_').show();
            $('#hari_').hide();
            $("#jenis_filter").val('').trigger('change') ;
        } else if (data == 'dTUxTHFPNC9mYUduSCt0K0hLckR0Zz09' || data == 'aW12YnJPKzMvV05nNWJUNU0rTFFHZz09'){
            $('#filter_').hide();
            $('#bulan_').hide();
            $('#triwulan_').hide();
            $('#tahun_').show();
            $('#hari_').hide();
            $("#jenis_filter").val('').trigger('change') ;
        } else if (data == 'QmNJcFdDOHhMa3Z6MG4wQmZmQmR1UT09'){
            $('#filter_').hide();
            $('#bulan_').show();
            $('#triwulan_').hide();
            $('#tahun_').show();
            $('#hari_').hide();
            $("#jenis_filter").val('').trigger('change') ;
        } else if (data == 'SWxkOHU4bjF6NFNjQXRCL0VlcUdWdz09' || data == 'ZWx1b0NvVUYyNitBSUN0RTcxUUU0QT09'){
            $('#filter_').hide();
            $('#bulan_').hide();
            $('#triwulan_').hide();
            $('#tahun_').hide();
            $('#hari_').show();
        } else {
            $('#filter_').show();
            $('#hari_').hide();
            $('#bulan_').hide();
            $('#triwulan_').hide();
            $('#tahun_').hide();
            $("#jenis_filter").val('').trigger('change') ;
        }

        // $('#option').val(result[1].toLowerCase());
    });

    $('#jenis_filter').change(function() {
        let data = $('#jenis_filter').select2('data');
        let result = data[0].text.split(" ");
        
        if (result[1].toLowerCase() == "bulan"){
            $('#bulan_').show();
            $('#triwulan_').hide();
            $('#tahun_').show();
        } else if (result[1].toLowerCase() == "triwulan"){
            $('#triwulan_').show();
            $('#bulan_').hide();
            $('#tahun_').show();
        } else {
            $('#tahun_').show();
            $('#triwulan_').hide();
            $('#bulan_').hide();
        }

        $('#option').val(result[1].toLowerCase());
    });

    $(document).on("click", '#cetak', function(e) {
        e.preventDefault();
        let base_url = '<?= base_url($uri_mod) ?>';
        var tanggal = $('#tanggal').val();

            $.ajax({
                type: "POST",
                url: base_url + '/list/',
                data: {
                    tanggal: tanggal,
                    link:1

                },
                success: function (response) {
                    newWindow = window.open(base_url + '/list/' + $('#jenis_rekap').val() + '/' + $('#jenis_filter').val() + '/' + $('#bulan').val() + '/' + $('#triwulan').val() + '/' + $('#tahun').val() + '/' + response,
                    "_blank");
                }
            });
    });

</script>