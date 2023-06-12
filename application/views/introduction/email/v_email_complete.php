<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <i class="h1 mdi mdi-email-check-outline text-success"></i>
                    <h3 class="mb-3">Berhasil Verifikasi Email</h3>
                    <p class="text-muted"> 
                        Selamat, alamat email anda "<strong><?= (!empty($pegawai->email)) ? $pegawai->email : '' ?></strong>" telah berhasil terverifikasi oleh sistem <strong>simpeg</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>