
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:14pt;font-weight: bold; line-height: 15px;">REKAPITULASI JUMLAH PEMBUDIDAYA IKAN </div>
            <div style="font-size:12pt;font-weight: bold; ">KABUPATEN AGAM TAHUN <?= $tahun?> </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr style="height:2px; line-height: 1px">
            <hr style="height:0.5px; line-height: 1px">
        </td> 
    </tr>  
</table>
<br>
<br>

<table  width="100%" border="1" >
    <tr>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="5%">No</td>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="35%">KECAMATAN</td>
        <td colspan="3" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="60%">JUMLAH PEMBUDIDAYA (ORANG)</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">BERKELOMPOK</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">BELUM BERKELOMPOK</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">JUMLAH</td>
    </tr>
    <?php 
    $total_kelompok = 0;
    $total_tidak_kelompok = 0;
    $total = 0;
    $no = 1; foreach($data_list as $row): 
    $total_kelompok += $row->berkelompok;
    $total_tidak_kelompok += $row->belum_berkelompok;
    $total = $total_kelompok+$total_tidak_kelompok;
    ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_kecamatan) ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo(produksi($row->berkelompok)) ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo($row->belum_berkelompok) ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo($row->berkelompok+$row->belum_berkelompok) ?></td>
        </tr>
    <?php $no++; endforeach ?>
    <tr>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;">JUMLAH</td>
        <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo($total_kelompok) ?></td>
        <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo($total_tidak_kelompok) ?></td>
        <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= xss_echo($total) ?></td>
    </tr>
</table>

<br><br>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: right;">
        <td style="line-height:1.3" >
            <br/>
            <span size="8pt" style="font-size:11pt;">Lubuk Basung, ../.../...</span><br>
            <span size="8pt" style="font-size:11pt;">Kepala Bidang Perikanan Budidaya</span><br>
            <span size="8pt" style="font-size:11pt;">Dan Perikanan Tangkap</span>
        </td>
    </tr>
</table>
<br/>










