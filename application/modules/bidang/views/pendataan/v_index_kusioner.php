
<div class="table-responsive mb-4 mt-4">
    <table id="table-kusioner" class="table mb-0 w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Komoditi</th>
                <th style="text-align: center; vertical-align: middle;">Uraian</th>
                <th style="text-align: center; vertical-align: middle;">Jawaban</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-kusioner';
        let id ='<?= encrypt_url($id, $id_key) ?>';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGetKusioner/') ?>"  + id;

        datatables = {
            table: $(table_name),
            options: {
                rowGroup: {
                    dataSrc : ["komoditas"]
                    },
                },
            groupColumn: [1],
            ordering: true,
            url: url_get_data,
            pageLength: 100,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            // rowGroup: [2];
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "komoditas"},
                {"data": "kusioner"},
                {"data": "opsi", searchable:false, orderable:false},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ],
            columnDefs: [
            { "width": "1%", "targets": 1 }
        ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
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


</script>