<div class="row mt-4">
    <div class="col-12">
    <?= form_open($uri_mod.'/AjaxSaveEdit/'.encrypt_url($id, $id_key), 'id="formAjax" class="form"') ?>
        <input type="hidden" class="pie-token-response" name="pie-token-response">
        <div class="form-group row">
            <label for="jenis" class="col-md-2 col-form-label">Pilih Jenis Ikan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="jenis" id="jenis">
                    <option selected disable>Pilih Jenis Ikan</option>
                    <option value="<?= encrypt_url('1', "app") ?>">Ikan Laut</option>
                    <option value="<?= encrypt_url('2', "app") ?>">Ikan Tawar</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="komoditas" class="col-md-2 col-form-label">Pilih Komoditas <?= label_required() ?></label>
            <div class="col-md-10">
                <input type="text" id="nama_komoditas" name="nama_komoditas" class="form-control" readonly>
                <input class="form-control" type="hidden" name="komoditas" id="komoditas" readonly/>
                <code class="text-primary">klik <a href="#data-komoditas" data-toggle="modal" class="cari_komoditas"><span class="badge bg-primary text-white"><b>disini</b></span></a> untuk merubah komoditas.</code> 
            </div>
        </div>
        <div class="form-group row">
            <label for="produksi" class="col-md-2 col-form-label">Jumlah Produksi <?= label_required() ?></label>
            <div class="col-md-10">
                <input class="form-control custom-form " type="text" name="produksi" id="produksi" placeholder="Jumlah Produksi">
            </div>
        </div>
        <div class="form-group row">
            <label for="satuan" class="col-md-2 col-form-label">Satuan <?= label_required() ?></label>
            <div class="col-md-10">
                <select class="form-control select2" name="satuan" id="satuan">
                    <option selected disable>Pilih Satuan</option>
                    <?php $no = 1; foreach($satuan as $row): ?>
                        <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $no. ' - ' .$row->kamus_data ?></option>
                    <?php $no++; endforeach; ?>
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


<!-- Komoditas Search Modal -->
<div class="modal fade" id="data-komoditas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Cari Komoditas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('', 'id="form-data-komoditas" data-id="" class="form-data-komoditas"');?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-control-label">Pilih Komoditas</label>
                    <select class="form-control select2" name="komoditas_id" id="komoditas_id"></select>
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
<!-- End Komoditas Search Modal -->


<script type="text/javascript">

    $(document).ready(function(e) {
        $( ".flatpickr" ).flatpickr({
            disableMobile : true
        });

        var rupiah = document.getElementById("produksi");
            rupiah.addEventListener("keyup", function(e) {
                rupiah.value = formatRupiah(this.value);
        });

        let id ='<?= encrypt_url($id, $id_key) ?>';
        
        aOption = {
            url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + id,
            data: {
                dkpp_c_token: csrf_value
            }
        }

        $('#jenis').on('change', function() {
            value_option = $('#jenis').val();
            init_autocomplete_komoditas(value_option);
        });


        data = get_data_by_id(aOption);
        if (data != false) {
            let produksi = formatRupiah(data.data.produksi);

            $('select[name="satuan"]').val(data.data.satuan).change();
            $('#produksi').val(produksi);
            $('select[name="jenis"]').val(data.data.jenis).change();
            $('#nama_komoditas').val(data.data.komoditas);
            $('#komoditas').val(data.data.komoditas_id);

        }
    });

    function init_autocomplete_komoditas(value_option) {
        ajax_get_region = {
            element: $('#komoditas_id'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetKomoditas/') ?>" + value_option,
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Komoditas',
        }

        init_ajax_select2_paging(ajax_get_region);
    }

    $(document).on("submit", ".form-data-komoditas", function (e) {
        e.preventDefault();
        let data = $('#komoditas_id').select2('data');

        $('#nama_komoditas').val(data[0].text);
        $('#komoditas').val(data[0].id);
        $('#data-komoditas').modal('hide'); 
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
                document.querySelector('.pie-token-response').value = token;
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