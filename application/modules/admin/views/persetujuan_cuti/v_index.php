<?php
$form_name = "form-tolak";
$modal_name = "modal-tolak";
?>
<div class="form-group row mt-10">
    <label for="filter_sekolah" class="col-md-2 col-form-label">Sekolah</label>
    <div class="col-sm-10">
        <select id="filter_sekolah" name="filter_sekolah" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Sekolah</option>
            <?php foreach($sekolah as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= $row->nama_sekolah ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row mt-10">
    <label for="filter_guru" class="col-md-2 col-form-label">Guru</label>
    <div class="col-sm-10">
        <select id="filter_guru" name="filter_guru" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Guru</option>
            <?php foreach($guru as $row): ?>
                <option value="<?= encrypt_url($row->id, $id_key) ?>"><?= name_degree($row->gelar_depan,$row->nama_guru,$row->gelar_belakang) ?></option>
            <?php $no++; endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row mt-10">
    <label for="filter_status" class="col-md-2 col-form-label">Status Permohonan</label>
    <div class="col-sm-10">
        <select id="filter_status" name="filter_status" class="form-control select2" required>
            <option value="ALL" selected>Tampilkan Semua Status Permohonan</option>
            <option value="<?= encrypt_url('0', $id_key) ?>">Menunggu Persetujuan</option>
            <option value="<?= encrypt_url('1', $id_key) ?>">Permohonan Disetujui</option>
            <option value="<?= encrypt_url('2', $id_key) ?>">Permohonan Diterima</option>
            <option value="<?= encrypt_url('3', $id_key) ?>">Permohonan Dibatalkan</option>
        </select>
    </div>
</div>


<div class="form-group row mb-0">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10 col-12">
        <span class="btn btn-blue" id="cari"><i class="icon-magnifier"></i>
            Cari</span>
        <div style="display: none" id="spinner" class='spinner-border spinner-border-sm text-info'
            role='status'><span class='sr-only'></span></div>
    </div>
</div>

<div class="table-responsive mb-4 mt-4">
    <table id="table-permohonan_cuti" class="table table-striped w-100">
        <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Sekolah</th>
                <th style="text-align: center; vertical-align: middle;">Guru</th>
                <th style="text-align: center; vertical-align: middle;">Tahun Ajaran</th>
                <th style="text-align: center; vertical-align: middle;">Lama Cuti</th>
                <th style="text-align: center; vertical-align: middle;">File</th>
                <th style="text-align: center; vertical-align: middle;">Status</th>
                <th style="text-align: center; vertical-align: middle;">Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- sample modal content -->
<div id="<?= $modal_name ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= $page_title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <?= form_open($uri_mod.'/AjaxTolak', 'id="'.$form_name.'" data-id="" class="form-tolak"');?>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alasan" class="control-label">Alasan Penolakan</label>
                                <textarea class="form-control" name="alasan" id="alasan" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit-btn" class="btn btn-success waves-effect waves-light m-1">
                        <span class="spinner-border spinner-border-sm mr-1" id="spinner-status" role="status" aria-hidden="true" style="display:none"></span>
                        <i class="mdi mdi-content-save mr-1" id="icon-save"></i><span id="button-value">Tolak</span>
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Batal</button>
                </div>
            <?= form_close(); ?>

        </div>
    </div>
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        table_name = '#table-permohonan_cuti';
        modal_name = "#<?= $modal_name ?>";
        form_name = "#<?= $form_name ?>";

        url_get_data = "<?= base_url($uri_mod.'/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.filter_sekolah = $('[name="filter_sekolah"]').val();
                data.filter_guru = $('[name="filter_guru"]').val();
                data.filter_status = $('[name="filter_status"]').val();
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center align-middle"},
                {"data": "nama_sekolah", "sClass": "text-center align-middle"},
                {"data": "nama_guru", "sClass": "text-center align-middle"},
                {"data": "tahun_ajaran", "sClass": "text-center align-middle"},
                {"data": "lama_cuti", "sClass": "text-center align-middle"},
                {"data": "files", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "status", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap align-middle"},
            ]
        }

        oTable = intiate_datatables(datatables);

        $("#cari").click(function() {
            oTable.ajax.reload();
        });

        $(document).on("click", ".button-terima", function (e) {
            e.preventDefault();
            aOption = {
                title: "Setujui Pengajuan?",
                message: "Yakin ingin menyetujui?",
                url: "<?= base_url($uri_mod.'/AjaxTerima/')?>" + $(this).attr('data-id'),
                table: oTable,
            };
            
            btn_confirm_action(aOption);
        });

        $(document).on("click", ".button-tolak", function (e) {
            e.preventDefault();
            aOption = {
                url: "<?= base_url($uri_mod. '/AjaxGet/') ?>" + $(this).attr('data-id'),
            }
            data = get_data_by_id(aOption);
            if(data!=false){
                $(form_name).addClass('form-tolak');
                $(form_name).attr('data-id', $(this).data('id'));
            }
        });

        $(document).on("submit", ".form-tolak", function (e) {
            e.preventDefault();
            aOption = {
            async: false,
            submit_btn: $('#submit-btn'),
            spinner: $('#spinner-status'),
            url: "<?= base_url($uri_mod. '/AjaxTolak/')?>" + $(this).attr('data-id'),
            table: oTable,
            data: $(this).serialize()
            };

            aksi = btn_save_form(aOption);
            if(aksi == true){
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

    
    });
</script>