<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">Pemanfaatan Pangan Bulan <?= bulan($bulan)?></div>
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
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">No.</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Nama Kabupaten/Kota</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Kecamatan</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">BB Sangat Kurang</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="9%">BB Kurang</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="8%">BB Normal</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="8%">Risiko BB Lebih</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">BB Sangat Kurang + BB Kurang</th>
        <th rowspan="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Total BB/U</th>
        <th colspan="3" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="20%">Hasil</th>
    </tr>
    <tr style="text-align:center;">
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">Value</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">Bobot</th>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">Status</th>
    </tr>
    <?php $no = 1; 
        $total = 0;
        foreach($data_list as $row): 
        $total = $row->bb_sangat_kurang+$row->bb_kurang+$row->bb_normal+$row->risiko_bb_lebih;
        ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;">AGAM</td>
            <td style="border: 1px solid #000;"><?= $row->nama_kecamatan ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $row->bb_sangat_kurang ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $row->bb_kurang ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $row->bb_normal ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $row->risiko_bb_lebih ?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $row->bb_sangat_kurang + $row->bb_kurang?></td>
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= produksi($total)?></td>
        </tr>
    <?php $no++; endforeach ?>
</table>





