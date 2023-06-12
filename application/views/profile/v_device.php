<div class="card">
    <div class="card-body">
        <div class="row">
            <h5 class="mb-3 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i> Perangkat Saya</h5>
            <div class="col-lg-12 col-xl-12">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0 w-100" id="table-devices">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Browser</th>
                                <th>Versi</th>
                                <th>Perangkat</th>
                                <th>Waktu Habis</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        table_name = '#table-devices';
        url_get_data = "<?= site_url('profile/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.page = "get_devices";
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "browser_agent", "sClass": "center-align text-nowrap"},
                {"data": "version_agent", "sClass": "center-align"},
                {"data": "platform_agent", "sClass": "center-align"},
                {"data": "cookie_expires", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "last_login", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
            ]
        }

        oTable = intiate_datatables(datatables);

        
    });

    $(document).on("click", ".cookie-action", function (e) {
        e.preventDefault();
        aOption = {
            title: "Hapus Data?",
            message: "Yakin ingin hapus data?",
            url: "<?= site_url('profile/AjaxGet') ?>",
            table: oTable,
            data: {
                page : "ajax_delete_cookie",
                cookie : $(this).attr('id')
            },
        };
        
        btn_confirm_action(aOption);
    })

</script>