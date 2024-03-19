
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">DAFTAR HARGA IKAN BUDIDAYA DI TINGKAT PRODUSEN</div>
            <div style="font-size:10pt;font-weight: bold; ">KABUPATEN AGAM</div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr style="height:2px; line-height: 1px">
            <hr style="height:0.5px; line-height: 1px">
        </td> 
    </tr>  
</table>
<table style="line-height: 1;margin-top:20px;" cellpadding="10">
    <tr style="text-align: left;">
        <td style="line-height:1.3">
            <br/>
            <span size="8pt" style="font-size:11pt;">Hari/Tanggal : <?= format_indo($tanggal, 'YES')?><b></b></span> <br/>
        </td>
    </tr>
</table>
<table style="border-collapse:collapse;font-size:10pt;">
    <tr style="text-align:center;">
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">No.</th>
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="25%">KECAMATAN</th>
        <?php $colsp = []; foreach($data_list[1] as $row): 
            $colsp[] = 1;
        endforeach ?>
        <th colspan ="<?= array_sum($colsp); ?>" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="70%">HARGA PER Kg (Rp)</th>
    </tr>
    <tr style="text-align:center;">

    <?php foreach($data_list[1] as $row){ ?>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;"><?= xss_echo($row->komoditas) ?></th>
    <?php  } if(empty($data_list[1])){ ?>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;"></th>
    <?php } ?>

    </tr>

    <?php
    $ar_nilai = [];
    foreach($data_list[2] as $row): 
        $ar_nilai[$row->kecamatan_id.'_'.$row->komoditas_id] =  $row;
    endforeach ?>

    <?php  $no = 1; foreach($data_list[0] as $row): ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_kecamatan) ?></td>

            <?php foreach($data_list[1] as $rv): 
                $cek_harga = !empty($ar_nilai[$row->id.'_'.$rv->komoditas_id]->harga)?$ar_nilai[$row->id.'_'.$rv->komoditas_id]->harga:'';
                $cek_harga_[$rv->komoditas][] = $cek_harga;
            ?>

            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  rupiah($cek_harga) ?></td>
            <?php endforeach ?>
        </tr>
    <?php $no++; endforeach ?>
    
        <tr>
            <td colspan="2" style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;">JUMLAH</td>
            <?php foreach($data_list[1] as $rv): ?>
                
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= rupiah((!empty($cek_harga_[$rv->komoditas]))?array_sum($cek_harga_[$rv->komoditas]):0) ?></td>
            <?php endforeach ?>
        </tr>
</table>
<br><br>
<table style="line-height: 1;margin-top:25px;" cellpadding="10">
    <tr style="text-align: right;">
        <td style="line-height:1.3" >
            <br/>
            <span size="8pt" style="font-size:11pt;">Lubuk Basung, <?= indo_date($tanggal) ?></span><br>
            <span size="8pt" style="font-size:11pt;">Kepala Bidang Perikanan Budidaya</span><br>
            <span size="8pt" style="font-size:11pt;">Dan Perikanan Tangkap</span>
        </td>
    </tr>
</table>
<br/>