<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="450%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:16pt;font-weight: bold; line-height: 20px;">DINAS KELAUTAN DAN PERIKANAN PROVINSI SUMATERA BARAT</div>
            <div style="font-size:14pt;font-weight: bold; ">PAPAN DATA INFORMASI HARGA IKAN KABUPATEN AGAM</div>
            <div style="font-size:12pt;line-height: 20px;">Hari/Tanggal : <?= format_indo($date_now, 'YES')?> </div>
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
<table style="border-collapse:collapse;font-size:10pt;">
    <tr style="text-align:center;">
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">No.</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="25%">Jenis Ikan</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="30%">Kabupaten / Agam</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="25%">Harga Eceran</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="15%">Volume (Kg)</th>
    </tr>
    <?php $no = 1; foreach($data_list as $row): ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->komoditas) ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: middle; vertical-align: middle;">Kabupaten Agam</td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: middle; vertical-align: middle;"><?= xss_echo(rupiah($row->harga))?>/<?= xss_echo($row->nama_satuan)?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: middle; vertical-align: middle;"><?= xss_echo($row->volume) ?></td>
        </tr>
    <?php $no++; endforeach ?>
</table>
<br><br>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: right;">
        <td style="line-height:1.3">
            <br/>
            <span size="8pt" style="font-size:11pt;">Petugas Pasar</span>
        </td>
    </tr>
</table>
<br/>





