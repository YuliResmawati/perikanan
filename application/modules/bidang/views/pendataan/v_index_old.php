
<div class="form-group row mt-10 ">
    <label for="pelaku" class="col-sm-2 col-form-label">Pilih Pelaku Usaha </label>
    <div class="col-sm-10">
        <select class="form-control select2" name="pelaku" id="pelaku">
        </select>
    </div>
</div>
<div class="form-group row mt-10 ">
    <label for="type" class="col-sm-2 col-form-label">Pilih Bidang </label>
    <div class="col-sm-10">
        <select class="form-control select2" name="type" id="type">
            <option selected disabled>Pilih Bidang</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Pasca Panen</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Budidaya</option>
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
<div class="table-responsive mb-4 mt-4">
    <?= form_open($uri_mod.'/AjaxSave', 'id="formAjax" class="form"') ?> 
    <input type="hidden" class="pd-token-response" name="pd-token-response">
    <table id="table-pendataan" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Kuesioner</th>
                <th style="text-align: center; vertical-align: middle;">Opsi</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="row mt-3 mb-3 text-right">
        <div class="col-12">
            <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Simpan</span>
            </button>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-pendataan';
        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.dpkk_c_token = csrf_value;
                data.filter_bidang= $('[name="type"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "kusioner", searchable:false, orderable:false},
                {"data": "opsi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

        ajax_get_pelaku = {
            element: $('#pelaku'),
            type: 'post',
            url: "<?= base_url('app/AjaxGetPelaku') ?>",
            data: {
                dkpp_c_token: csrf_value
            },
            placeholder: 'Ketik Nama Pelaku Usaha',
        }

        
        init_ajax_select2_paging(ajax_get_pelaku);
        

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
                document.querySelector('.pd-token-response').value = token;
                $('#formAjax').submit()
            });
        });
    });

    $('#formAjax').submit(function(e) {
        e.preventDefault();
        const opdiRadio = $('input[name="inlineRadioOptions"]').val();
        const idOpdiRadio = $('input[name="idopsi"]').val();
        const opsiEntry = $('input[name="opsiEntry"]').val();
        console.log('ID : ' + idOpdiRadio);
        console.log('Jawaban : ' + opdiRadio);
        console.log('Jawaban : ' + opsiEntry);
        

        // option_save = {
        //     async: true,
        //     submit_btn: $('#submit-btn'),
        //     spinner: $('#spinner-status'),
        //     icon_save: $('#icon-save'),
        //     button_value: $('#button-value'),
        //     url: $(this).attr('action'),
        //     data: $(this).serialize(),
        //     redirect: "<?= base_url($uri_mod) ?>"
        // }

        // btn_save_form(option_save);
    });
</script>