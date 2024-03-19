
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">REKAPITULASI PRODUKSI PERIKANAN TANGKAP</div>
            <div style="font-size:10pt;font-weight: bold; ">KABUPATEN AGAM TAHUN <?= $tahun?> </div>
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
<?php 
    $arr_col_2 = [];
    $total_col2=0;
    foreach($data_list[1] as $row):
        $arr_col_2[] = $row;
        $total_col2 += $row->produksi;
    endforeach 
?>

<table  width="100%" border="1" >
    <tr>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="5%">No</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="45%">IKAN LAUT</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="50%">IKAN TAWAR</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">KOMODITI</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="25%">PRODUKSI(TON)</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="25%">KOMODITI</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="25%">PRODUKSI(TON)</td>
    </tr>
    <?php 
        $total=0;
        $i=0; $no = 1; foreach($data_list[0] as $row): 
        $total += $row->produksi;
    ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->komoditas) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($row->produksi)) ?></td>
            <?php 
                if (!empty($arr_col_2[$i]->komoditas)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->komoditas)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->produksi)){ ?>
                <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($arr_col_2[$i]->produksi))?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
        </tr>
    <?php $i++; $no++; endforeach
    ?>
    <tr>
        <td></td>
        <td style="border: 1px solid #000; font-weight: bold; vertical-align: middle;">Total</td>
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= produksi($total) ?></td>
        <td></td>
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= produksi($total_col2) ?></td>
        
    </tr>
</table>

<br><br>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: right;">
        <td style="line-height:1.3" >
            <br/>
            <span size="8pt" style="font-size:11pt;">Lubuk Basung, <?= indo_date($tanggal)?></span><br>
            <span size="8pt" style="font-size:11pt;">Kepala Bidang Perikanan Budidaya</span><br>
            <span size="8pt" style="font-size:11pt;">Dan Perikanan Tangkap</span>
        </td>
    </tr>
</table>
<br/>










