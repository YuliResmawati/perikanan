<div class="alert alert-info border-0 mt-1 mb-3" role="alert">
    <div class="text-justify">
        Jika nama Komoditas tidak muncul, Silahkan hubungi admin <strong>Bidang Perikanan Budi Daya dan Perikanan Tangkap </strong>untuk menambahkan data
    </div><br>
</div>
<br>
<?php if ($this->logged_level != 3) { ?>
<div class="form-group row mt-10 ">
    <label for="jenis_ikan" class="col-sm-2 col-form-label">Pilih Jenis Ikan</label>
    <div class="col-sm-10">
        <select class="form-control select2" name="jenis_ikan" id="jenis_ikan">
            <option value="<?= encrypt_url('1', $id_key) ?>" selected>Ikan Laut</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Ikan Air Tawar</option>
        </select>
    </div>
</div>
<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-icon  btn-primary" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>
<?php } else {} ?>
<div class="table-responsive mb-4 mt-4">
    <table id="table-komoditas" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">komoditas</th>
                <th style="text-align: center; vertical-align: middle;">Jenis Komoditas</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

 <!--  Modal komoditas -->
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
            <input type="hidden" class="km-token-response" name="km-token-response">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-form-label">Nama Komoditas <?= label_required() ?></label>
                        </div>
                        <div class="col-lg-8">
                            <input class="form-control"  type="text" name="komoditas" id="komoditas">
                        </div>
                    </div>
                    <?php if ($this->logged_level != 3) { ?>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="col-form-label">Jenis Komoditas <?= label_required() ?></label>
                            </div>
                            <div class="col-lg-8">
                                <select class="form-control select2" name="jenis" id="jenis">
                                    <option selected disabled>Pilih Jenis Komoditas</option>
                                    <option value="<?= encrypt_url('1', $id_key) ?>">Ikan Laut</option>
                                    <option value="<?= encrypt_url('2', $id_key) ?>">Ikan Air Tawar</option>
                                </select>  
                            </div>
                        </div>
                    <?php }else {}?>
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
        table_name = '#table-komoditas';
        modal_name = "#<?= $modal_name ?>";
        form_name = "#<?= $form_name ?>";
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_jenis= $('[name="jenis_ikan"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "komoditas", searchable:false, orderable:false},
                {"data": "jenis", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
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
                $(form_name + " [name='komoditas']").val(data.data.komoditas);
                $('select[name="jenis"]').val(data.data.jenis).change();
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
                document.querySelector('.km-token-response').value = token;
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
            $("#jenis").val([]).trigger("change");
        });

        $(modal_name + ' .form-group label.error').hide();
        $(modal_name + ' .form-control').removeClass('valid').removeClass('error');
    });

   
</script>