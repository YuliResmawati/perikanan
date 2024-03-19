<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSave/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="pp-token-response" name="pp-token-response">
        <div class="form-group row">
            <label for="kecamatan" class="col-md-2 col-form-label">Pilih Kecamatan <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" id="nama_kecamatan" name="nama_kecamatan" class="form-control" readonly>
                <input class="form-control" type="hidden" name="kecamatan" id="kecamatan" readonly/>
                <code class="text-primary">klik <a href="#data-kecamatan" data-toggle="modal" class="cari_kecamatan"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah kecamatan.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="sangat_kurang" class="col-md-2 col-form-label">BB Sangat Kurang<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="sangat_kurang" id="sangat_kurang" placeholder="Jumlah BB Sangat Kurang">
            </div>
        </div>
        <div class="form-group row">
            <label for="kurang" class="col-md-2 col-form-label">BB Kurang<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="kurang" id="kurang" placeholder="Jumlah BB Kurang">
            </div>
        </div>
        <div class="form-group row">
            <label for="normal" class="col-md-2 col-form-label">BB Normal<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="normal" id="normal" placeholder="Jumlah BB Normal">
            </div>
        </div>
        <div class="form-group row">
            <label for="lebih" class="col-md-2 col-form-label">Risiko BB Lebih<?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="lebih" id="lebih" placeholder="Jumlah Risiko BB Lebih">
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

        var sangat_kurang = document.getElementById("sangat_kurang");
        sangat_kurang.addEventListener("keyup", function(e) {
            sangat_kurang.value = formatRupiah(this.value);
        });

        var kurang = document.getElementById("kurang");
        kurang.addEventListener("keyup", function(e) {
            kurang.value = formatRupiah(this.value);
        });

        var normal = document.getElementById("normal");
        normal.addEventListener("keyup", function(e) {
            normal.value = formatRupiah(this.value);
        });

        var lebih = document.getElementById("lebih");
        lebih.addEventListener("keyup", function(e) {
            lebih.value = formatRupiah(this.value);
        });

        let id ='<?= encrypt_url($id, $id_key) ?>';
        
        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
            data: {
                dkpp_c_token: csrf_value
            }
        }

        data = get_data_by_id(aOption);
        if (data != false) {

            let sangat_kurang = formatRupiah(data.data.bb_sangat_kurang);
            let kurang = formatRupiah(data.data.bb_kurang);
            let normal = formatRupiah(data.data.bb_normal);
            let lebih = formatRupiah(data.data.risiko_bb_lebih);

            $('#nama_kecamatan').val(data.data.nama_kecamatan);
            $('#kecamatan').val(data.data.kecamatan_id);
            $('#sangat_kurang').val(sangat_kurang);
            $('#kurang').val(kurang);
            $('#normal').val(normal);
            $('#lebih').val(lebih);

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
                document.querySelector('.pp-token-response').value = token;
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