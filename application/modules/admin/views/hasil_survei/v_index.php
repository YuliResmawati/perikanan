<div class="form-group row mt-10">
    <label for="filter_awal" class="col-md-2 col-form-label">Tanggal Mulai</label>
    <div class="col-sm-10">
        <input type="date" class="form-control" name="filter_awal" id="filter_awal">
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_akhir" class="col-md-2 col-form-label">Tanggal Akhir</label>
    <div class="col-sm-10">
        <input type="date" class="form-control" name="filter_akhir" id="filter_akhir">
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
    <table id="table-hasil-survei" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Nama</th>
                <th style="text-align: center; vertical-align: middle;">Jenis Kelamin</th>
                <th style="text-align: center; vertical-align: middle;">Usia</th>
                <th style="text-align: center; vertical-align: middle;">Pendidikan</th>
                <th style="text-align: center; vertical-align: middle;">No Handphone</th>
                <th style="text-align: center; vertical-align: middle;">Rating</th>
                <th style="text-align: center; vertical-align: middle;">Saran</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-hasil-survei';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_awal = $('[name="filter_awal"]').val();
                data.filter_akhir = $('[name="filter_akhir"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "name", "sClass": "text-center align-middle"},
                {"data": "gender", "sClass": "text-center align-middle"},
                {"data": "age", "sClass": "text-center align-middle"},
                {"data": "education", "sClass": "text-center align-middle"},
                {"data": "phone_number", "sClass": "text-center text-nowrap align-middle"},
                {"data": "rate", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "suggestion",  "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

    });
</script>