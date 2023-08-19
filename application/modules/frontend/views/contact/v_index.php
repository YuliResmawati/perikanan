<div class="section page-banner-section bg-color-1">
    <img class="shape-1" src="<?= $theme_path ?>/images/shape/shape-5.png" alt="shape">
    <img class="shape-2" src="<?= $theme_path ?>/images/shape/shape-6.png" alt="shape">
    <img class="shape-3" src="<?= $theme_path ?>/images/shape/shape-7.png" alt="shape">
    <img class="shape-4" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <img class="shape-5" src="<?= $theme_path ?>/images/shape/shape-21.png" alt="shape">
    <div class="container">
        <div class="page-banner-content">
            <h2 class="title">Kontak Kami</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                <li class="breadcrumb-item active">Kontak</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-info-wrapper">
                    <div class="row gx-0">
                        <div class="col-md-4">
                            <div class="single-contact-info">
                                <div class="info-icon">
                                    <i class="flaticon-phone-call"></i>
                                </div>
                                <div class="info-content">
                                    <h5 class="title">Telepon & WhatsApp</h5>
                                    <p><a href="tel:<?= (!empty($website_data[0]->phone_number)) ? xss_escape($website_data[0]->phone_number) : '-' ?>"><?= (!empty($website_data[0]->phone_number)) ? xss_escape($website_data[0]->phone_number) : '-' ?></a></p>
                                    <p class="text-muted">atau</p>
                                    <p><a href="https://api.whatsapp.com/send/?phone=<?= xss_echo((!empty($website_data))? $website_data[0]->whatsapp_number : '') ?>&text=Halo admin silat pendidikan ...." target="_blank"><?= (!empty($website_data[0]->whatsapp_number)) ? xss_escape($website_data[0]->whatsapp_number) : '-' ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-contact-info">
                                <div class="info-icon">
                                    <i class="flaticon-mail"></i>
                                </div>
                                <div class="info-content">
                                    <h5 class="title">Email</h5>
                                    <p><a href="mailto:<?= (!empty($website_data[0]->email)) ? xss_escape($website_data[0]->email) : '-' ?>"><?= (!empty($website_data[0]->email)) ? xss_escape($website_data[0]->email) : '-' ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="single-contact-info">
                                <div class="info-icon">
                                    <i class="flaticon-placeholder"></i>
                                </div>
                                <div class="info-content">
                                    <h5 class="title">Lokasi</h5>
                                    <p><?= (!empty($website_data[0]->address)) ? xss_escape($website_data[0]->address) : '-' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section contact-map-area">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7979.519676808786!2d100.36611358956633!3d-0.310221920028243!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd538ea5943d5df%3A0xf6401ef798810023!2sKantor%20Dinas%20Pendidikan%20Dan%20Kebudayaan%20Kota%20Bukittinggi!5e0!3m2!1sid!2sid!4v1692266923337!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>