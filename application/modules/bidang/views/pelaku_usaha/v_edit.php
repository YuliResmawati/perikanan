<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="pl-token-response" name="pl-token-response">
        <div class="form-group row">
            <label for="kecamatan" class="col-md-2 col-form-label">Pilih Kecamatan <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" id="nama_kecamatan" name="nama_kecamatan" class="form-control" readonly>
                <input class="form-control" type="hidden" name="kecamatan" id="kecamatan" readonly/>
                <code class="text-primary">klik <a href="#data-kecamatan" data-toggle="modal" class="cari_kecamatan"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah kecamatan.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="pelaku" class="col-md-2 col-form-label">Nama Pelaku Usaha<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="pelaku" id="pelaku" placeholder="Nama Pelaku Usaha">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">Email<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="email" name="email" id="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="telp" class="col-md-2 col-form-label">No Telephone<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control" type="text" name="telp" id="telp" data-toggle="input-mask" data-mask-format="0000-0000-0000" placeholder="Contoh Penulisan 0813-XXXX-XXX" />
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 col-form-label">Alamat<?= label_required() ?></label>
            <div class="col-md-10">
                <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="jum" class="col-md-2 col-form-label">Jumlah Karyawan<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jum" id="jum" placeholder="Jumlah Karyawan">
            </div>
        </div>
        <div class="form-group row">
            <label for="skala" class="col-md-2 col-form-label">Skala Usaha <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="skala" id="skala">
                    <option selected disabled>Pilih Skala Usaha</option>
                    <option value="<?= encrypt_url('1', $id_key) ?>">Kecil</option>
                    <option value="<?= encrypt_url('2', $id_key) ?>">Menengah</option>
                    <option value="<?= encrypt_url('3', $id_key) ?>">Besar</option>
                </select>            
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


<!-- kecamatan Search Modal -->
<div class="modal fade" id="data-kecamatan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Kecamatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-kecamatan" data-id="" class="form-data-kecamatan"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Kecamatan</label>
                    <select class="form-control select2" name="kecamatan_id" id="kecamatan_id"></select>
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

    $(document).ready(function(e) {

        let id ='<?= encrypt_url($id, $id_key) ?>';
        
        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
            data: {
                dkpp_c_token: csrf_value
            }
        }

        data = get_data_by_id(aOption);
        if (data != false) {

            $('#nama_kecamatan').val(data.data.nama_kecamatan);
            $('#kecamatan').val(data.data.kecamatan_id);
            $('#pelaku').val(data.data.nama_pelaku);
            $('#email').val(data.data.email);
            $('#telp').val(data.data.telp);
            $('#alamat').val(data.data.alamat);
            $('#jum').val(data.data.jumlah_karyawan);
            $('select[name="skala"]').val(data.data.skala).change();
        }

        ajax_get_kecamatan = {
            element: $('#kecamatan_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetDistrict') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Kecamatan',
        }

        
        init_ajax_select2_paging(ajax_get_kecamatan);

    });

    $(document).on("submit", ".form-data-kecamatan", function (e) {
        e.preventDefault();
        let data = $('#kecamatan').select2('data');

        $('#nama_kecamatan').val(data[0].text);
        $('#kecamatan_id').val(data[0].id);
        $('#data-kecamatan').modal('hide'); 
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
                document.querySelector('.pl-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        option_save = {
            async: true,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            icon_save: $('#icon-save'),
            button_value: $('#button-value'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            redirect: "<?= base_url($uri_mod) ?>"
        }

        btn_save_form(option_save);
    });
</script>