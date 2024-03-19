
<div class="form-group row" >
    <label for="kecamatan" class="col-md-2 col-form-label">Kecamatan <?= label_required() ?></label>
    <div class="col-md-10">
        <select class="form-control select2" name="kecamatan" id="kecamatan">
            <option value="" selected disabled>Pilih Kecamatan</option>
            <?php $no = 1; foreach($kecamatan as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->nama_kecamatan ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row" >
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

<div class="form-group row" >
    <label for="minggu" class="col-md-2 col-form-label">Minggu <?= label_required() ?></label>
    <div class="col-md-10">
        <select id="minggu" name="minggu" class="form-control select2" required>
            <option value="" selected disabled>Pilih Minggu</option>
            <option value=<?= encrypt_url('1', $id_key) ?>>1. Minggu 1</option>
            <option value=<?= encrypt_url('2', $id_key) ?>>2. Minggu 2</option>
            <option value=<?= encrypt_url('3', $id_key) ?>>3. Minggu 3</option>
            <option value=<?= encrypt_url('4', $id_key) ?>>4. Minggu 4</option>
            <option value=<?= encrypt_url('4', $id_key) ?>>4. Minggu 5</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="tahun" class="col-md-2 col-form-label">Tahun<?= label_required() ?></label>
    <div class="col-md-10">
        <select id="tahun" name="tahun" class="form-control select2" required>
            <option selected="selected" disabled>Pilih Tahun</option>
            <?php $no = 1; for($i=2024; $i <= date('Y')+1; $i++) {?>
                <option value="<?= encrypt_url($i, $id_key) ?>"><?= $no. ' - ' .$i ?></option>
            <?php $no++; } ?>
        </select>
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
	
    $(document).on("click", '#cetak', function(e) {
        e.preventDefault();

        let base_url = '<?= base_url($uri_mod) ?>';
        newWindow = window.open(base_url + '/report/' + $('#kecamatan').val() + '/' + $('#bulan').val() + '/' + $('#minggu').val() + '/' + $('#tahun').val(),
            "_blank");
        if (window.focus) {
            newWindow.focus()
        }

        return false;
    });

</script>