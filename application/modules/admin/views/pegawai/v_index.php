
<div class="table-responsive mb-4 mt-3">
    <table id="table-pegawai" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th>_Nip</th>
                <th>_Nama</th>
                <th>_NamaUnor</th>
                <th>_NamaJabatan</th>
                <th class="text-nowrap text-center">Nama Pegawai
                    <hr class="m-0">NIP
                </th>
                <th style="text-align: center; vertical-align: middle;">Jenis Kelamin</th>
                <th class="text-nowrap text-center">Unit Kerja
                    <hr class="m-0">Jabatan
                </th>
                <th style="text-align: center; vertical-align: middle;">Foto</th>
                <th style="text-align: center; vertical-align: middle;">Kedudukan Hukum</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

 <!--  Modal upload foto -->
 <div class="modal fade" id="<?= $modal_name ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"><?= $page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <?= form_open($uri_mod.'/AjaxSave', 'id="'.$form_name.'" data-id="" class="form-tambah"');?>
            <input class="form-control custom-form" type="hidden" name="pegawai_id" id="pegawai_id" />
            <input class="form-control custom-form" type="hidden" name="nip" id="nip" />
            <input class="form-control custom-form" type="hidden" name="data_id" id="data_id" />
            <input type="hidden" class="pr-token-response" name="pr-token-response">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label">Upload Foto Pegawai <?= label_required() ?> </label>
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
    table_name = '#table-pegawai';
    modal_name = "#<?= $modal_name ?>";
    form_name = "#<?= $form_name ?>";
    url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

    datatables = {
        table: $(table_name),
        ordering: true,
        url: url_get_data,
        data: function (data){
            data.dkpp_c_token = csrf_value;
        }, 
        columns: [
            {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
            {"data": "nip", "visible": false},
            {"data": "nama_pegawai","visible": false},
            {"data": "nama_unor","visible": false},
            {"data": "nama_jabatan","visible": false},
            {"data": "nama", searchable: false},
            {"data": "jenis", "sClass": "text-center"},
            {"data": "nama_unor", searchable: false},
            {"data": "lihat", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            {"data": "kedudukan_hukum", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},    
            {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
        ]
    }

    oTable = intiate_datatables(datatables);
});

$(document).on("click", ".button-create", function (e) {
    e.preventDefault();

    $(form_name).addClass('form-tambah');
    $('#title-modal').html('Tambah Foto Profil Pegawai');
    $('#pegawai_id').val($(this).attr('data-pegawai'));
    $('#nip').val($(this).attr('data-nip'));
});

$(document).on("click", ".button-edit", function (e) {
    e.preventDefault();
    aOption = {
        url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + $(this).data('id'),
        data: {
            pers_c_token : csrf_value
        }
    }

    data = get_data_by_id(aOption);

    if (data !=false ) {
        $(form_name).addClass('form-tambah');
        $('#title-modal').html('Edit Foto Profil Pegawai');
        $('#data_id').val($(this).attr('data-id'));
        $('#pegawai_id').val($(this).attr('data-pegawai'));
        $('#nip').val($(this).attr('data-nip'));
    }

    if (data.data.image != undefined) {
        $("[name='image']").attr('data-default-file', data.data.image);
        reinit_dropify($("[name='image']"));
    } 

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
            document.querySelector('.pr-token-response').value = token;
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
        $(this).attr('data-id', '');
    });

    $(modal_name + ' .form-group label.error').hide();
    $(modal_name + ' .form-control').removeClass('valid').removeClass('error');
});

</script>