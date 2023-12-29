<div class="table-responsive mb-4 mt-4">
    <table id="table-kategori-ikm" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Kategori IKM</th>
                <th style="text-align: center; vertical-align: middle;">Nilai</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

 <!--  Modal kategori -->
<div class="modal fade" id="<?= $modal_name ?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3"><?= $page_title?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open($uri_mod.'/AjaxSave', 'id="'.$form_name.'" data-id="" class="form-tambah"');?>
            <input class="form-control custom-form" type="hidden" name="data-id" id="data-id" />
            <input type="hidden" class="kt-token-response" name="kt-token-response">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Nama Kategori <?= label_required() ?></label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control"  type="text" name="kategori" id="kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Poin <?= label_required() ?></label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control"  type="number" name="poin" id="poin">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Batal</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-kategori-ikm';
        modal_name = "#<?= $modal_name ?>";
        form_name = "#<?= $form_name ?>";
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_kategori", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "nilai", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);

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

        
        $(document).on("click", ".button-edit", function (e) {
            e.preventDefault();
            $('#data-id').val($(this).data('id'));

            aOption = {
                url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + $(this).data('id'),
                data: {
                    dpkk_c_token : csrf_value
                }
            }
            data = get_data_by_id(aOption);

            if(data!=false){
                $(form_name).attr('data-id', $(this).data('id'));
                $(form_name + " [name='kategori']").val(data.data.nama_kategori);
                $(form_name + " [name='poin']").val(data.data.nilai);
            }
        });
    });

    $('#submit-btn').click(function(e) {
        e.preventDefault();

        $('#loading-process').show();
        $('#submit-btn').attr('disabled', true);
        $('#spinner-status').show();
        $('#icon-button').hide();
        $('#button-value').html("Loading...");

        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.kt-token-response').value = token;
                $('.form-tambah').submit();
            });
        });
    });

    $(document).on("submit", ".form-tambah", function (e) {
        e.preventDefault();

        aOption = {
            async: false,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: "<?= base_url($uri_mod. '/AjaxSave')?>",
            table: oTable,
            data: $(this).serialize()
        };

        aksi = btn_save_form(aOption);

        if (aksi == true) {
            $(modal_name).modal('hide'); 
        }     
    });

    $('.modal').on('hidden.bs.modal', function(){
        $('form').each(function() {
            $(this)[0].reset();
            $(this).attr('data-id', '');
        });

        $(modal_name + ' .form-group label.error').hide();
        $(modal_name + ' .form-control').removeClass('valid').removeClass('error');
    });

</script>