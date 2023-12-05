
<div class="table-responsive mb-4 mt-4">
    <table id="table-users" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="vertical-align: middle;">No. </th>
                <th style="vertical-align: middle;">Username</th>
                <th class="text-center">Nama Pegawai <hr class="m-0">NIP</th>                
                <th style="vertical-align: middle;">Status</th>
                <th style="vertical-align: middle;">Reset Password</th>
                <th style="vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-users';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "username"},
                {"data": "two_row", searchable:false, orderable:false},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-nowrap"},
                {"data": "reset_pass", searchable:false, orderable:false, "sClass": "text-nowrap"},
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
        });

        $(document).on("click", ".button-reset_pass", function (e) {
            e.preventDefault();
            aOption = {
                title: "Reset Password",
                message: "Yakin ingin mereset password akun ini ? Password baru : dkpp_pass",
                url: "<?= base_url($uri_mod.'/AjaxResetPass/')?>" + $(this).attr('data-id'),
                table: oTable,
            };
            
            btn_confirm_action(aOption);
        });

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