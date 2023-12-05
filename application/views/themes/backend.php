<!doctype html>
<html lang="en" translate="no">
<head> 
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-91315LTXRG"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-91315LTXRG');
    </script>  
    <meta charset="utf-8" />    
    <?php if(strlen($page_title) > 0) {$title = $page_title." | ".$site_name;}else{$title = $site_name;} ?>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php if(!empty($page_description) && isset($meta['description'])) $meta['description'] = $page_description; ?>
    <?php if(!empty($meta)) : ?>
    <?php foreach($meta as $name=>$content) : ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>"/>
    <?php endforeach;?>
    <?php endif;?>

    <?php if(empty($page_image)) $page_image = base_url('assets/frontend/images/onlylogo.png'); ?>

    <!-- Meta Facebook -->
    <meta property="og:title" content="<?= $title ?>"/>
    <meta property="og:description" content="<?= (!empty($meta['description']))? $meta['description'] : "" ?>"/>
    <meta property="og:site_name" content="<?= $site_name ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?= $page_image ?>"/>
    <meta property="og:image:alt" content="<?= $title ?>"/>
    <meta property="og:url" content="<?= current_url() ?>"/>
    <meta property='og:locale' content='id_ID'/>
    <meta property='og:locale:alternate' content='en_US'/>
    <meta property='og:locale:alternate' content='en_GB'/>

    <!-- Meta Twitter -->
    <meta name='twitter:card'content='summary'/>
    <meta name="twitter:title" content="<?= $title ?>"/>
    <meta name="twitter:image:alt" content="<?= $title ?>"/>
    <meta name="twitter:description" content="<?= (!empty($meta['description']))? $meta['description'] : "" ?>"/>
    <meta name="twitter:image" content="<?= $page_image ?>"/>
    <meta name="twitter:url" content="<?= current_url() ?>"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=  base_url('assets/frontend/images/onlylogo.png')?>">

    <!-- Plugins -->
    <link href="<?= $theme_path ?>/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $global_plugin_path ?>/datatable.RowGroup/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />  

    <!-- Load CSS in Controller -->
    <?php foreach ($css as $file) { ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
    <?php } ?>
        
    <!-- App css -->
    <link href="<?= $theme_path ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= $theme_path ?>/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="<?= $theme_path ?>/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="<?= $theme_path ?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />
    <link href="<?= $theme_path ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $global_custom_path ?>/css/preloader.init.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?= $global_custom_path ?>/css/custom.css?v=<?= filemtime('./assets/global/custom/css/custom.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $global_custom_path ?>/css/custom-form.css?v=<?= filemtime('./assets/global/custom/css/custom-form.css') ?>">

    <!-- JavaScript -->
    <script src="<?= $theme_path ?>/js/vendor.min.js"></script>
    <script src="<?= $global_custom_path ?>/js/preloader.init.js"></script>
    
    <script type="text/javascript">
        var uri_dasar = '<?= base_url() ?>';
        var uri_mod = '<?= base_url($uri_mod) ?>';
        var csrf_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_value = '<?php echo $this->security->get_csrf_hash(); ?>';
        var grecaptcha;
    </script>

    <style>
        .grecaptcha-badge{visibility: hidden}
    </style>

    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>

    </head>

    <body data-layout='{"sidebar": { "showuser": true}}'>
        <div class="preloader">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div id="loading-process"></div>

        <div id="wrapper">
            <?= $this->load->get_section('header') ?>
            <div class="left-side-menu">
                <div class="h-100" data-simplebar>
                    <div class="col-lg-12">
                        <div class="user-box text-center mt-2">
                            <?= generate_avatar($this->logged_avatar, $this->logged_display_name,'rounded-circle avatar-md img-thumbnail') ?>
                            <div class="media-body mt-2">
                                <h5 class="font-15 mt-1">
                                    <a href="<?= base_url('profile') ?>" class="text-reset"><?= xss_escape($this->logged_display_name) ?></a>
                                </h5>
                                <p class="mt-1 mb-0 font-14">
                                    <?= str_level($this->logged_level) ?>
                                </p>
                                <p class="mt-2 mb-2 font-13">
                                    <?php
                                    if($this->logged_level == '3'){
                                        $this->load->model(array('m_sekolah'));  
                                        $sekolah = $this->m_sekolah->find($this->logged_sekolah_id);
                                        echo xss_echo($sekolah->nama_sekolah);
                                    }else{
                                        echo "Dinas Ketahanan Pangan dan Perikanan";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2 mt-0 mr-4 ml-4">
                    <div id="sidebar-menu"> 
                        <ul id="side-menu">
                            <li class="menu-title">Menu</li>
                            <?= $sidebar_menu ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <?php echo $breadcrumbs ?>
                                    </div>
                                    <h4 class="page-title"><?= (!empty($page_title)) ? $page_title : '' ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?= (!empty($card)) ? '<div class="card"><div class="card-body">' : '' ?> 
                                    <?php if(!empty($add_button_link)) : ?>
                                        <a href="<?= $add_button_link ?>" class="btn btn-sm btn-blue waves-effect waves-light float-right" <?= (!empty($modal_name))?"data-toggle=\"modal\" data-target=\"#$modal_name\"":"" ?>><i class="mdi mdi-plus-circle"></i> Tambah</a>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($custom_button_element)) : ?>
                                        <?= $custom_button_element ?>
                                    <?php endif; ?>    
                                    <?php if(empty($header_title)) : ?>
                                        <h4 class="header-title"><?= (!empty($page_title)) ? $page_title : '' ?></h4>
                                        <p class="sub-header">
                                            <?= (!empty($page_description)) ? $page_description : '' ?>
                                        </p>
                                    <?php endif; ?>     
                                    <?= $output ?>
                                <?= (!empty($card)) ? '</div></div>' : "" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-10 text-center">
                                Copyright &copy; <?= date('Y') ?><a href="#" class="text-dark-50"> <?= $site_name ?></a>. All rights reserved. 
                            </div>
                            <div class="col-md-2">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);"><strong>v<?= $version ?></strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div class="rightbar-overlay"></div>

        <!-- Plugins js-->
        <script src="<?= $theme_path ?>/libs/flatpickr/flatpickr.min.js"></script>
        <script src="<?= $theme_path ?>/libs/selectize/js/standalone/selectize.min.js"></script>

        <!-- third party js -->
        <script src="<?= $theme_path ?>/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?= $theme_path ?>/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="<?= $theme_path ?>/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?= $theme_path ?>/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="<?= $theme_path ?>/libs/tippy.js/tippy.all.min.js"></script>
        <script src="<?= $theme_path ?>/js/app.min.js"></script>
        <script src="<?= $global_plugin_path ?>/datatable.RowGroup/dataTables.rowGroup.min.js"></script>
        <script src="<?= $global_custom_path ?>/js/initiate.datatables.js?v=<?= filemtime('./assets/global/custom/js/initiate.datatables.js') ?>"></script>
        <script src="<?= $global_plugin_path ?>/bootbox/bootbox.min.js"></script>
        <script src="<?= $global_plugin_path ?>/loaders/blockui.min.js"></script>
        <script src="<?= $global_plugin_path ?>/initial/initial.js"></script>
        <script src="<?= $global_custom_path ?>/js/mycustom.js?v=<?= filemtime('./assets/global/custom/js/mycustom.js') ?>"></script>
        <script src="<?= $global_custom_path ?>/js/perikanan.js?v=<?= filemtime('./assets/global/custom/js/perikanan.js') ?>"></script>
        <script src="<?= $global_custom_path ?>/js/myapp.back.js"></script>
        <script src="<?= $global_custom_path ?>/js/form-ajax-custom.js?v=<?= filemtime('./assets/global/custom/js/form-ajax-custom.js') ?>"></script>
        <script src="<?= $global_custom_path ?>/js/auto-csrf.min.js?v=2.0.4"></script>
        
        <?php foreach ($js as $file) { ?>
            <script src="<?php echo $file; ?>"> </script>
        <?php } ?>
    </body>
</html>








