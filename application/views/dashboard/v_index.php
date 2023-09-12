<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card-box">
            <div class="row">
                <div class="col-6">
                    <div class="feature-icon">
                        <img src="<?= base_url('assets/frontend') ?>/images/school.png" alt="sekolah">
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <?php 
                            if($this->logged_level == "3"){ ?>
                                <h3 class="text-dark my-1"><span data-plugin="counterup"><?= $count_rombel ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Jumlah Rombel</p>
                            <?php }else{ ?>
                                <h3 class="text-dark my-1"><span data-plugin="counterup"><?= $count_sekolah ?></span></h3>
                                <p class="text-muted mb-1 text-truncate">Jumlah Sekolah</p>
                            <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h6 class="text-uppercase"> <span class="float-right"></span></h6>
                <div class="progress mb-2 progress-sm">
                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>            

            </div>
        </div> <!-- end card-box-->
    </div> 
    <div class="col-md-6 col-xl-4">
        <div class="card-box">
            <div class="row">
                <div class="col-6">
                    <div class="feature-icon">
                        <img src="<?= base_url('assets/frontend') ?>/images/teacher.png" alt="guru">
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup"><?= $count_guru ?></span></h3>
                        <p class="text-muted mb-1 text-truncate">Jumlah Guru</p>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h6 class="text-uppercase"> <span class="float-right"></span></h6>
                <div class="progress mb-2 progress-sm">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>            
            </div>
        </div> <!-- end card-box-->
    </div> 
    <div class="col-md-6 col-xl-4">
        <div class="card-box">
            <div class="row">
                <div class="col-6">
                    <div class="feature-icon">
                        <img src="<?= base_url('assets/frontend') ?>/images/student.png" alt="siswa">
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="text-dark my-1"><span data-plugin="counterup"><?= $count_siswa ?></span></h3>
                        <p class="text-muted mb-1 text-truncate">Jumlah Siswa</p>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h6 class="text-uppercase"> <span class="float-right"></span></h6>
                <div class="progress mb-2 progress-sm">
                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>            
            </div>
        </div> <!-- end card-box-->
    </div> 
</div> 
<div class="card">
    <div class="card-body">
        <div class="row">
            <h5 class="mb-3 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i> Perangkat Saya</h5>
            <div class="col-lg-12 col-xl-12">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0 w-100" id="table-devices">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Browser</th>
                                <th>Versi</th>
                                <th>Perangkat</th>
                                <th>Waktu Habis</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        table_name = '#table-devices';
        url_get_data = "<?= site_url('profile/AjaxGet') ?>";

        datatables = {
            table: $(table_name),
            ordering: true,
            url: url_get_data,
            data: function (data){
                data.page = "get_devices";
            }, 
            columns: [
                {"data": "id", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "browser_agent", "sClass": "center-align text-nowrap"},
                {"data": "version_agent", "sClass": "center-align"},
                {"data": "platform_agent", "sClass": "center-align"},
                {"data": "cookie_expires", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "last_login", searchable:false, orderable:false, "sClass": "text-center"},
                {"data": "aksi", searchable:false, orderable:false, "sClass": "text-center text-nowrap"},
            ]
        }

        oTable = intiate_datatables(datatables);

        
    });

    $(document).on("click", ".cookie-action", function (e) {
        e.preventDefault();
        aOption = {
            title: "Hapus Data?",
            message: "Yakin ingin hapus data?",
            url: "<?= site_url('profile/AjaxGet') ?>",
            table: oTable,
            data: {
                page : "ajax_delete_cookie",
                cookie : $(this).attr('id')
            },
        };
        
        btn_confirm_action(aOption);
    })

</script>