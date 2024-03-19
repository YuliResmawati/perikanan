
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">PANEL HARGA KONSUMEN TAHUN <?= $tahun?></div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr style="height:2px; line-height: 1px">
            <hr style="height:0.5px; line-height: 1px">
        </td> 
    </tr>  
</table>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: left;">
        <td style="line-height:1.3">
            <br/>
            <span size="8pt" style="font-size:11pt;">KECAMATAN : <?= $kecamatan?></span> <br/>
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;font-size:10pt;">
    <tr style="text-align:center;">
        <th rowspan ="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">No.</th>
        <th rowspan ="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="20%">Komoditas</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="50%">Bulan <?=bulan($bulan)?></th>
        <th rowspan ="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="9%">Rata-Rata Minggu ini</th>
        <th rowspan ="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="9%">Rata-Rata Minggu lalu</th>
        <th rowspan ="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="8%">Naik / Turun</th>
    </tr>
    <tr style="text-align:center;">
        <th colspan ="5" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="50%">Minggu <?=$minggu?></th>
    </tr>
    <tr style="text-align:center;">
        <?php $no = 1; for($i=2024; $i <= date('Y')+1; $i++) {?>
            <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">tgl 1</th>
        <?php $no++; } ?>
    </tr>
</table>
<br><br>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: right;">
        <td style="line-height:1.3" >
            <br/>
            <span size="8pt" style="font-size:11pt;">Lubuk Basung, <?= indo_date($tanggal) ?> <?= per_minggu() ?></span><br>
            <span size="8pt" style="font-size:11pt;">Kepala Bidang Perikanan Budidaya</span><br>
            <span size="8pt" style="font-size:11pt;">Dan Perikanan Tangkap</span>
        </td>
    </tr>
</table>
<br/>