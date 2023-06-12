<header class="header-area header-2">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/global') ?>/images/new_simpeg_header.png" alt="logo simpeg" width="80px" height="30px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#saasboxNav" aria-controls="saasboxNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-grid"></i>
            </button>
            <div class="collapse navbar-collapse" id="saasboxNav">
                <ul class="navbar-nav navbar-nav-scroll">
                    <li>
                        <a href="<?= base_url('home') ?>">Home</a>
                    </li>
                    <li>
                        <a href="#">Panduan Penggunaan</a>
                    </li>
                    <li>
                        <a href="#">FAQ</a>
                    </li>
                    <li>
                        <a href="#">Kontak Kami</a>
                    </li>
                </ul>
                <a class="btn btn-warning btn-sm ms-auto mb-3 mb-lg-0" href="<?= base_url('auth') ?>"><?= strtoupper('Masuk Ke Silat Pendidikan') ?></a>
            </div>
        </div>
    </nav>
</header>