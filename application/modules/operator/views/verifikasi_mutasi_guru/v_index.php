<div class="table-responsive mb-4 mt-3">
    <table id="table-mutasi_guru" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th style="text-align: center; vertical-align: middle;">Sekolah Asal</th>
                <th class="text-nowrap text-center">Usulan mutasi
                    <hr class="m-0">Sekolah Tujuan
                </th>
                <th style="text-align: center; vertical-align: middle;">Link</th>
                <th style="text-align: center; vertical-align: middle;">Status Usulan</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">

$(document).ready(function() {
    table_name = '#table-mutasi_guru';
    url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

    datatables = {
        table: $(table_name),
        ordering: true,
        url: url_get_data,
        data: function (data){
            data.silatpendidikan_c_token = csrf_value;
        }, 
        columns: [
            {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
            {"data": "nip", "visible": false},
            {"data": "nama_guru","visible": false},
            {"data": "nama", searchable: false},
            {"data": "sekolah_awal", "sClass": "text-center",searchable: false},
            {"data": "sekolah_tujuan", "sClass": "text-center",searchable: false},
            {"data": "link", searchable: false},
            {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
            {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
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
            data: {
                silatpendidikan_c_token : csrf_value
            },
        };
        btn_confirm_action(aOption);
    })

    $(document).on("click", ".button-verif", function (e) {
        e.preventDefault();
        aOption = {
            title: "Verifikasi Data ini?",
            message: "Yakin ingin menerima usulan mutasi ini?",
            url: "<?= base_url($uri_mod.'/AjaxTerima/')?>" + $(this).attr('data-id'),
            table: oTable,
            data: {
                silatpendidikan_c_token: csrf_value
            },
        };

        btn_confirm_action(aOption);
    });

    $(document).on("click", ".button-ditolak", function (e) {
        e.preventDefault();
        aOption = {
            title: "Verifikasi Data ini?",
            message: "Yakin ingin menolak usulan mutasi ini?",
            url: "<?= base_url($uri_mod.'/AjaxTolak/')?>" + $(this).attr('data-id'),
            table: oTable,
            data: {
                silatpendidikan_c_token: csrf_value
            },
        };

        btn_confirm_action(aOption);
    });

});

</script>