<?php
if(empty($paper_size)) {
    $paper_size = 'A4';
}

$pdf = new Pdf_Polos('P', 'mm', $paper_size, true, 'UTF-8', false);
$pdf->AddFont('helvetica');
$pdf->SetTitle($page_title);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(15);
$pdf->setFooterMargin(15);
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetAuthor('simpeg');
$pdf->SetDisplayMode('real', 'default');
$tagvs = ['div' => [['h' => 0, 'n' => 0], ['h' => 0, 'n' => 0]], 'ul' => [['h' => 0, 'n' => 0], ['h' => 0, 'n' => 0]]];
$pdf->setHtmlVSpace($tagvs);
$pdf->setListIndentWidth(5);
if (!empty($reports)) {
    foreach ($reports as $row) {
        $content = "
        <style>
            table {text-align: justify;}
            table.bordered {border-collapse: collapse;}
            table.bordered td {border: 0.1em solid #000;font-family: 'helvetica'}
            table.bordered th {border: 0.1em solid #000;font-weight: bold;font-family: 'helvetica'}
            label {font-weight: bold}
        </style>
        ";

        $content .= $row['c'];
        $pdf->AddPage($row['o'], $paper_size);
        $pdf->writeHTML($content, true, false, true, false, '');
    }
}


$pdfString = $pdf->Output(date('Y_m_d') . "-" . str_replace(" ", "_", $page_title), 'S');
$pdfBase64 = base64_encode($pdfString);

?>

<html>

<head>

    <?= (!empty($tag_refresh)) ? $tag_refresh : '' ?>

    <?php if (strlen($page_title) > 0) {
        $title = $page_title . " | " . $site_name;
    } else {
        $title = $site_name;
    } ?>
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php if(!empty($page_description) && isset($meta['description'])) $meta['description'] = $page_description; ?>
    <?php if(!empty($meta)) : ?>
    <?php foreach($meta as $name=>$content) : ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>"/>
    <?php endforeach;?>
    <?php endif;?>

    <?php if(empty($page_image)) $page_image = base_url('assets/backend/images/favicon.ico'); ?>

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
    <link rel="shortcut icon" href="<?= $theme_path ?>/images/favicon.ico">

    <!-- Plugins -->
    <link href="<?= $theme_path ?>/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $theme_path ?>/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $global_plugin_path ?>/datatable.RowGroup/rowGroup.dataTables.min.css" rel="stylesheet" type="text/css" />  

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
</head>

<body style="margin:0!important;overflow-y: auto;">
    <div class="text-right" style="background:rgb(50, 54, 57);">
        <i class="text-white" style="font-size: 9px;">halaman ini dimuat dalam waktu <strong><?= $benchmark ?></strong></i>
        <a class="btn btn-md btn-blue m-2" href="data:application/pdf;base64,<?php echo $pdfBase64 ?>"
            download="<?php echo date('Y_m_d') . "-" . str_replace(" ", "_", $page_title) ?>.pdf">Unduh</a>
        <?= (!empty($custom_button)) ? $custom_button : ""; ?>
    </div>
    <iframe id="pdfcontainer" data-view="1" style="width:100%; min-height:calc(100vh - 52px)"
        src="<?= base_url('assets/global/plugin/pdf/viewer.html') ?>"
        data-source="data:application/pdf;name=document.pdf;base64,<?php echo $pdfBase64 ?>" title="webviewer"
        frameborder="0"></iframe>
    <?= $this->load->get_section('sidebar_print'); ?>


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
</body>

</html>