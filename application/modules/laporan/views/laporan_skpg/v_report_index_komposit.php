<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">Index Komposit Ketahanan Pangan Bulan</div>
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
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Nama Kabupaten/Kota</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="20%">Kecamatan</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">IK</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">IA</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">IP</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Skor Komposit Bulanan</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="15%">Keterangan Komposit Bulanan</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Index Komposit Bulanan (IKB)</th>
    </tr>
    <?php $no = 1; foreach($data_list[0] as $row): ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
        </tr>
    <?php $no++; endforeach ?>
</table>





