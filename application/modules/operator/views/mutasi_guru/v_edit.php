<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?>
        <input type="hidden" class="mguru-token-response" name="mguru-token-response">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="guru_id" class="col-form-label">Pilih Guru  <?= label_required() ?></label>
                    <input class="form-control" type="text" name="nama_guru" id="nama_guru" readonly/>
                    <input class="form-control" type="text" name="guru_id" id="guru_id" readonly/>
                    <code class="text-primary">klik <a href="#data-guru" data-toggle="modal" class="cari_guru"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah nama guru.</code>
                </div>
            </div>
            <div class="form-row"  id="_sekarang">
                <div class="form-group col-md-12">
                    <label for="sekolah_awal" class="col-form-label">Sekolah Sekarang</label>
                    <input type="text" class="form-control" name="sekolah_awal" id="sekolah_awal" readonly>
                    <input type="hidden" class="form-control" name="sekolah_awal_id" id="sekolah_awal_id" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="sekolah_tujuan" class="col-form-label">Pilih Sekolah Tujuan  <?= label_required() ?></label>
                    <select class="form-control select2" name="sekolah_tujuan" id="sekolah_tujuan"></select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="link" class="col-form-label">Link Dokumen (GDrive)</label>
                    <input type="text" class="form-control" name="link" id="link"  placeholder="Link dokumen">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
                    </button>
                    <a href="<?= base_url($uri_mod) ?>" class="btn btn-danger waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Batal</a>
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<div class="modal fade" id="data-guru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Nama Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-guru" data-id="" class="form-data-guru"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Guru</label>
                    <select class="form-control select2" name="data_guru_id" id="data_guru_id"></select>
                </div>
            </div>
            <div class="modal-footer">
                <div id="spinner-status" class="spinner-border spinner-border-sm text-success mr-2" role="status"
                    style="display:none"></div>
                <button id="submit-btn" type="submit" class="btn btn-success waves-effect waves-light">
                    <i class="mdi mdi-cursor-default-click mr-1"></i> Pilih
                </button>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal"><i
                        class="mdi mdi-cancel mr-1"></i> Batal</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        ajax_get_guru = {
            element: $('#data_guru_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetGuru/') ?>",
            data: {
                silatpendidikan_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Guru',
        }
        ajax_get_sekolah = {
            element: $('#sekolah_tujuan'),
            type: 'post',
            url: "<?= base_url($uri_mod. '/AjaxGetSekolah/') ?>",
            data: {
                silatpendidikan_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Sekolah Tujuan',
        }
        
        init_ajax_select2_paging(ajax_get_guru);
        init_ajax_select2_paging(ajax_get_sekolah);

        let id ='<?= encrypt_url($id, $id_key) ?>';
            aOption = {
                url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
                data: {
                    silatpendidikan_c_token: csrf_value
                }
            }
            data = get_data_by_id(aOption);
            
            if (data != false) {
                $('#nama_guru').val(data.data.nama_guru);
                $('#guru_id').val(data.data.id);
                $('select[name="sekolah_tujuan"]').val(data.data.sekolah_tujuan).change();
                $('#link').val(data.data.link);
            }    
        
        
        $('#guru_id').change(function() {
            var id = $(this).val();
            // console.log(id);
            $.ajax({
                url: "<?= base_url($uri_mod. '/AjaxGetValueByGuru/') ?>",
                method : "POST",
                data : {id: id, silatpendidikan_c_token: csrf_value},
                async : true,
                dataType : 'json',
                success: function(data) {
                    if (data.status == true) {
                        $('#_sekarang').show();
                        csrf_value = data.token;
                        document.getElementById('sekolah_awal').value = data.data.nama_sekolah+' -- '+data.data.npsn;
                        document.getElementById('sekolah_awal_id').value = data.data.id;

                    } else {
                        $('#_sekarang').show();
                    }
                }
            });
            return false;
        });
    });  

    $(document).on("submit", ".form-data-guru", function (e) {
        e.preventDefault();
        let data = $('#data_guru').select2('data');

        console.log(data);
        $('#nama_guru').val(data[0].text);
        $('#guru_id').val(data[0].id);
        $('#data-guru').modal('hide'); 
    });

    $('#submit-btn').click(function(e) {
        e.preventDefault();
        $('#loading-process').show();
        $('#submit-btn').attr('disabled', true);
        $('#spinner-status').show();
        $('#icon-save').hide();
        $('#button-value').html("Loading...");
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
                document.querySelector('.mguru-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
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

        btn_save_form_with_file(option_save);
    });
</script>