<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= (!empty($status) && $status == true)? "Notifikasi" : "Error" ?></title>
        <title><?= (!empty($status) && $status == true)? "Notifikasi" : "Error" ?></title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="Jasa Print UV" name="author">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('assets/backend/images/favicon.ico') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/backend/images/favicon.ico') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/backend/images/favicon.ico') ?>">
        <!-- <link rel="manifest" href="<?= base_url('manifest') ?>/site.webmanifest"> -->
        <!-- <link rel="mask-icon" href="<?= base_url('public/images') ?>/favicon/safari-pinned-tab.svg" color="#5bbad5"> -->
        <meta name="apple-mobile-web-app-title" content="Jasa Print UV">
        <meta name="application-name" content="Jasa Print UV" />
        <meta name="msapplication-TileColor" content="#2b5797">
        <meta name="theme-color" content="#ffffff">

        <link href="<?= base_url('assets/backend') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
        <link href="<?= base_url('assets/backend') ?>/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
        <link href="<?= base_url('assets/backend') ?>/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
        <link href="<?= base_url('assets/backend') ?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />
        <link href="<?= base_url('assets/backend') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <!-- Vendor js -->
        <script src="<?= base_url('assets/backend') ?>/js/vendor.min.js"></script>
        <script src="<?= base_url('assets/backend') ?>/js/app.min.js"></script>
        
        <!-- bootbox code -->
        <script src="<?= base_url('assets/global/plugin/bootbox/bootbox.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugin/bootbox/bootbox.locales.min.js') ?>"></script>

        <?php
            if(!empty($error_login)){
                $link_ok =  base_url('auth');

                $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $array = array(
                    'link_reference' => $url
                );
            
                $this->session->set_userdata( $array );
            }else{
                if(!empty($redirect_link))
                {
                    $link_ok =  $redirect_link;
                }else{
                    if(!empty($_SERVER['HTTP_REFERER'])) {
                        $link_ok =  $_SERVER['HTTP_REFERER'];

                        if(!empty($_SESSION["error_page"])) {
                            if($this->session->userdata('simpeg_level') == 1){
                                $link_ok =  base_url('');
                            }else{
                                $link_ok =  base_url('dashboard');
                            }

                            unset($_SESSION["error_page"]);
                        }else{
                            $_SESSION["error_page"] = true;
                        }
                    }else{
                        if($this->session->userdata('simpeg_level') == 1){
                            $link_ok =  base_url('');
                        }else{
                            $link_ok =  base_url('dashboard');
                        }
                    }
                }
            }
        ?>

        <script>
            $(document).ready(function(e) {
                bootbox.alert({
                    size: "small",
                    title: '<?= (!empty($status) && $status == true)? "Notifikasi" : "Informasi" ?>',
                    message: "<?= $message ?>",
                    callback: function(){
                        window.location.replace("<?= $link_ok ?>");
                    }
                })
            });
        </script>
        
    </body>
</html>
<?php exit;?>h