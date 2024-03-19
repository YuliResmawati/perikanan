
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:14pt;font-weight: bold; line-height: 15px;">REKAPITULASI PRODUKSI PEMBENIHAN IKAN </div>
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
        <td rowspan="3" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="5%">No</td>
        <td rowspan="3" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="35%">KOMODITI</td>
        <td colspan="5" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="60%">TRIWULAN I + TW II + TW III + TW IV</td>
    </tr>
    <tr>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="10%">RTP</td>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Luas Lahan(Ha)</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">Jumlah Induk(Ekor)</td>
        <td rowspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Produksi</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="10%">Jantan</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="10%">Betina</td>
    </tr>
    <?php $no = 1; 
        $jum_rtp[] = 0;
        $jum_luas_lahan[] = 0;
        $jum_jantan[] = 0;
        $jum_betina[] = 0;
        $jum_produksi[] = 0;
        
        foreach($data_list as $row): 
            $jum_rtp[] = $row->rtp;
            $jum_luas_lahan[] = $row->luas_lahan;
            $jum_jantan[] = $row->induk_jantan;
            $jum_betina[] = $row->induk_betina;
            $jum_produksi[] = $row->produksi;
    ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->komoditas) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($row->rtp)) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo($row->luas_lahan) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($row->induk_jantan)) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($row->induk_betina)) ?></td>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= xss_echo(produksi($row->produksi)) ?></td>
        </tr>
    <?php $no++; endforeach ?>
    
    <tr>
        <td colspan="2" style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;">JUMLAH</td>
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  produksi(array_sum($jum_rtp)) ?></td> 
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  array_sum($jum_luas_lahan) ?></td> 
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  produksi(array_sum($jum_jantan)) ?></td> 
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  produksi(array_sum($jum_betina)) ?></td> 
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  produksi(array_sum($jum_produksi)) ?></td> 
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










