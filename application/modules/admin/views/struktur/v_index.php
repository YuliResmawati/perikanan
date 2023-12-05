<div class="table-responsive mb-4 mt-4">
    <table id="table-struktur" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Lihat</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

 <!--  Modal Struktur -->
 <div class="modal fade" id="<?= $modal_name ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"><?= $page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <?= form_open($uri_mod.'/AjaxSave', 'id="'.$form_name.'" data-id="" class="form-tambah"');?>
            <input class="form-control custom-form" type="hidden" name="struktur_id" id="struktur_id" />
            <input type="hidden" class="st-token-response" name="st-token-response">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label">Upload Struktur <?= label_required() ?> </label>
                    <div class="col-md-10">
                        <span class="text-muted font-12 mt-2">(Maksimal ukuran 1MB. Format yang didukung hanya : .jpg | .png | .jpeg | .jpg)</span><br>
                        <input type="file" data-plugins="dropify" name="image" id="image" data-max-file-size="1M" accept="image/*" />
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-struktur';
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
                {"data": "struktur", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
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
            $('#struktur_id').val($(this).data('id'));

            aOption = {
                url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + $(this).data('id'),
                data: {
                    dpkk_c_token : csrf_value
                }
            }
            data = get_data_by_id(aOption);

            if (data.data.image != undefined) {
                $("[name='image']").attr('data-default-file', data.data.image);
                reinit_dropify($("[name='image']"));
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
                document.querySelector('.st-token-response').value = token;
                $('.form-tambah').submit();
            });
        });
    });

    $(document).on("submit", ".form-tambah", function (e) {
        e.preventDefault();

        formData = new FormData(this);
        option_save = {
            async: true,
            enctype: 'multipart/form-data',
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: $(this).attr('action'),
            data: formData,
            redirect: "<?= base_url($uri_mod) ?>"
        }

        aksi = btn_save_form_with_file(option_save);

        if (aksi == true) {
            $(modal_name).modal('hide'); 
        }     
    });

    $('.modal').on('hidden.bs.modal', function(){
        $('form').each(function() {
            $(this)[0].reset();
        });

        $(modal_name + ' .form-group label.error').hide();
        $(modal_name + ' .form-control').removeClass('valid').removeClass('error');
    });

</script>