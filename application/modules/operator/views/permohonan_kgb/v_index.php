<div class="table-responsive mb-4 mt-4">
    <table id="table-permohonan_kgb" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">#</th> <th>_Nip</th>
                <th>_Nama</th>
                <th class="text-nowrap text-center">Nama Guru
                    <hr class="m-0">NIP
                </th>
                <th style="vertical-align: middle;">Jenis Kelamin</th>             
                <th style="vertical-align: middle;">Bidang Studi</th>             
                <th style="vertical-align: middle;">KGB Terakhir</th>
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Berkas</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-permohonan_kgb';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_bulan = $('[name="filter_bulan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "nip", "visible": false},
                {"data": "nama_guru","visible": false},
                {"data": "nama", searchable: false},
                {"data": "jk", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "bidang_studi_pendidikan", searchable:false, orderable:false},
                {"data": "tanggal", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "berkas", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-nowrap"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });


        $(document).on("click", ".button-batal", function (e) {
            e.preventDefault();
            aOption = {
                title: "Batalkan Pengajuan?",
                message: "Yakin ingin membatalkan?",
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
    });
</script>