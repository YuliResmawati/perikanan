<div class="row">
    <div class="col-xl-3 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="font-13 text-muted text-uppercase">Menu</h6>
                <div class="list-group list-group-flush mt-2 font-15">
                    <a href="<?= base_url('introduction/konfirmasi_password') ?>" id="konfirmasi_password" class="tab-menu list-group-item list-group-item-action border-0 <?= ($page == 'konfirmasi_password' || $page == '') ? 'active' : '' ?>"><i class='mdi mdi-key font-16 mr-1'></i> Ubah Kata Sandi</a>
                    <a href="<?= base_url('introduction/konfirmasi_email') ?>" id="konfirmasi_email" class="tab-menu list-group-item list-group-item-action border-0 <?= ($page == 'konfirmasi_email') ? 'active' : '' ?>"><i class='mdi mdi-email font-16 mr-1'></i> Konfirmasi Email</a>
                    <a href="<?= base_url('introduction/konfirmasi_telegram') ?>" id="konfirmasi_telegram" class="tab-menu list-group-item list-group-item-action border-0 <?= ($page == 'konfirmasi_telegram') ? 'active' : '' ?>"><i class='mdi mdi-telegram font-16 mr-1'></i> Konfirmasi Telegram</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-8">
        <?= $introduction_page ?>
    </div>
</div>

