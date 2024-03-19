
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:14pt;font-weight: bold; line-height: 15px;">REKAPITULASI ARMADA, ALAT TANGKAP DAN ALAT BANTU PENAGKAPAN IKAN MILIK NELAYAN</div>
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

<?php 
    $arr_col_2 = [];
    foreach($data_list[1] as $row):
        $arr_col_2[] = $row;
    endforeach 
?>
<table  width="100%" border="1" >
    <tr>
        <td rowspan="3" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="5%">No</td>
        <td colspan="6" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="45%">PERAIRAN LAUT</td>
        <td colspan="6" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="50%">PERAIRAN PUD</td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Armada</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Alat Tangkap</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Alat Bantu Penangkapan</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="20%">Armada</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Alat Tangkap</td>
        <td colspan="2" style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="15%">Alat Bantu Penangkapan</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="9%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="6%">Jumlah</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="9%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="6%">Jumlah</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="9%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="6%">Jumlah</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="10%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="10%">Jumlah</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="9%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="6%">Jumlah</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="9%">Jenis</td>
        <td style="border: 1px solid #000; font-weight: bold;text-align:center;vertical-align: center; vertical-align: middle;" width="6%">Jumlah</td>
    </tr>
    <?php $i=0; $no = 1; foreach($data_list[0] as $row): ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_armada) ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->jumlah_a) ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_alat_tangkap) ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->jumlah_b) ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_alat_bantu) ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->jumlah_c) ?></td>
            <?php 
                if (!empty($arr_col_2[$i]->nama_armada)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->nama_armada)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->jumlah_a)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->jumlah_a)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->nama_alat_tangkap)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->nama_alat_tangkap)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->jumlah_b)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->jumlah_b)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->nama_alat_bantu)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->nama_alat_bantu)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>
            <?php 
                if (!empty($arr_col_2[$i]->jumlah_c)){ ?>
                <td><?= xss_echo($arr_col_2[$i]->jumlah_c)?></td>
            <?php } else {
            ?>
            <td></td>
            <?php } ?>

           
        </tr>
    <?php $i++; $no++; endforeach ?>
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










