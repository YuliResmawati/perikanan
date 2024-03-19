<div class="row mt-4">
    <div class="col-12">
        <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="at-token-response" name="at-token-response">
        <div class="form-group row">
            <label for="type" class="col-md-2 col-form-label">Pilih Perairan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="type" id="type">
                    <option selected disable>Pilih Armada</option>
                    <option value="<?= encrypt_url('1', 'app') ?>">Perairan Laut</option>
                    <option value="<?= encrypt_url('2', 'app') ?>">Perairan PUD</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="armada" class="col-md-2 col-form-label">Pilih Armada <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" id="nama_armada" name="nama_armada" class="form-control" readonly>
                <input class="form-control" type="hidden" name="armada" id="armada" readonly/>
                <code class="text-primary">klik <a href="#data-armada" data-toggle="modal" class="cari_armada"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah armada.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_a" class="col-md-2 col-form-label">Jumlah Armada <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_a" id="jumlah_a" placeholder="Jumlah Armada">
            </div>
        </div>
        <div class="form-group row">
            <label for="alat_tangkap" class="col-md-2 col-form-label">Pilih Alat Tangkap</label>
            <div class="col-md-10">
                <input type="text" id="nama_alat_tangkap" name="nama_alat_tangkap" class="form-control" readonly>
                <input class="form-control" type="hidden" name="alat_tangkap" id="alat_tangkap" readonly/>
                <code class="text-primary">klik <a href="#data-alat_tangkap" data-toggle="modal" class="cari_alat_tangkap"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah alat tangkap.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_b" class="col-md-2 col-form-label">Jumlah Alat Tangkap</label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_b" id="jumlah_b" placeholder="Jumlah Alat Tangkap">
            </div>
        </div>
        <div class="form-group row">
            <label for="alat_bantu" class="col-md-2 col-form-label">Pilih Alat Bantu Penangkapan</label>
            <div class="col-md-10">
                <input type="text" id="nama_alat_bantu" name="nama_alat_bantu" class="form-control" readonly>
                <input class="form-control" type="hidden" name="alat_bantu" id="alat_bantu" readonly/>
                <code class="text-primary">klik <a href="#data-alat_bantu" data-toggle="modal" class="cari_alat_bantu"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah alat bantu.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="jumlah_c" class="col-md-2 col-form-label">Jumlah Alat Bantu Penangkapan</label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="number" name="jumlah_c" id="jumlah_c" placeholder="Jumlah Alat Bantu">
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

<div class="modal fade" id="data-armada" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Armada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-armada" data-id="" class="form-data-armada"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Armada</label>
                    <select class="form-control select2" name="armada_id" id="armada_id"></select>
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

<div class="modal fade" id="data-alat_tangkap" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Alat Tangkap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-alat_tangkap" data-id="" class="form-data-alat_tangkap"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Jenis</label>
                    <select class="form-control select2" name="alat_tangkap_id" id="alat_tangkap_id"></select>
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

<div class="modal fade" id="data-alat_bantu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Jenis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-alat_bantu" data-id="" class="form-data-alat_bantu"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Jenis</label>
                    <select class="form-control select2" name="alat_bantu_id" id="alat_bantu_id"></select>
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

        $('#type').on('change', function() {
            value_option = $('#type').val();

            init_autocomplete_armada(value_option);
            init_autocomplete_alat_tangkap(value_option);
            init_autocomplete_alat_bantu(value_option);
        });

        data = get_data_by_id(aOption);
        if (data != false) {

            $('select[name="type"]').val(data.data.type).change();
            $('#nama_armada').val(data.data.nama_armada);
            $('#armada').val(data.data.armada);
            $('#nama_alat_tangkap').val(data.data.nama_alat_tangkap);
            $('#alat_tangkap').val(data.data.alat_tangkap);
            $('#jumlah_a').val(data.data.jumlah_a);
            $('#jumlah_b').val(data.data.jumlah_b);
            $('#jumlah_c').val(data.data.jumlah_c);

        }
    });

    function init_autocomplete_armada(value_option) {
        let choise = 'armada';
        ajax_get_armada = {
            element: $('#armada_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Armada',
        }

        init_ajax_select2_paging(ajax_get_armada);
    }

    function init_autocomplete_alat_tangkap(value_option) {
        let choise = 'alat_tangkap';
        ajax_get_alat_tangkap = {
            element: $('#alat_tangkap_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Alat Tangkap',
        }

        init_ajax_select2_paging(ajax_get_alat_tangkap);
    }

    function init_autocomplete_alat_bantu(value_option) {
        let choise = 'alat_bantu';
        ajax_get_alat_bantu = {
            element: $('#alat_bantu_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetIndikator/') ?>" + choise + '/' +  value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Alat Bantu',
        }

        init_ajax_select2_paging(ajax_get_alat_bantu);
    }

    
    $(document).on("submit", ".form-data-armada", function (e) {
        e.preventDefault();
        let data = $('#armada_id').select2('data');

        $('#nama_armada').val(data[0].text);
        $('#armada').val(data[0].id)
        $('#data-armada').modal('hide'); 
    });

    $(document).on("submit", ".form-data-alat_tangkap", function (e) {
        e.preventDefault();
        let data = $('#alat_tangkap_id').select2('data');

        $('#nama_alat_tangkap').val(data[0].text);
        $('#alat_tangkap').val(data[0].id);
        $('#data-alat_tangkap').modal('hide'); 
    });

    $(document).on("submit", ".form-data-alat_bantu", function (e) {
        e.preventDefault();
        let data = $('#alat_bantu_id').select2('data');

        $('#nama_alat_bantu').val(data[0].text);
        $('#alat_bantu').val(data[0].id);
        $('#data-alat_bantu').modal('hide'); 
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
                document.querySelector('.at-token-response').value = token;
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