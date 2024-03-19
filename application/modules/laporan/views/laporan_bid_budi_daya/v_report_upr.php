
<table style="line-height: 1.1">
    <tr style="text-align: center;vertical-align: middle;">
        <td width="20%">
            <img src="@<?= $base64_logo_instansi ?>" width="350%" alt="" style="line-height: 20px;">
        </td>
        <td style="vertical-align: middle;text-align:center;" width="80%">
            <div style="font-size:12pt;font-weight: bold; line-height: 20px;">REKAPITULASI JUMLAH UNIT PEMBENIHAN RAKYAT (UPR)</div>
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
<br>
<br>
<table style="border-collapse:collapse;font-size:10pt;">
    <tr style="text-align:center;">
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="5%">No.</th>
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="15%">KECAMATAN</th>
        <?php $colsp = []; foreach($data_list[1] as $row): 
            $colsp[] = 1;
        endforeach ?>
        <th colspan ="<?= array_sum($colsp); ?>" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="30%">JUMLAH UPR (UNIT)</th>
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">JUMLAH</th>
        <th colspan ="<?= array_sum($colsp); ?>" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="30%">LUAS LAHAN (Ha)</th>
        <th rowspan ="2" style="border: 1px solid #000; font-weight: bold; vertical-align: middle;" width="10%">JUMLAH</th>
    </tr>
    <tr style="text-align:center;">

    <?php foreach($data_list[1] as $row){ ?>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;"><?= xss_echo($row->komoditas) ?></th>
    <?php  } if(empty($data_list[1])){ ?>
        <th style="border: 1px solid #000; font-weight: bold; vertical-align: middle;"></th>
    <?php } ?>

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

    <?php  $no = 1; 
        $total_per_jum_upr[] = [];
        $total_jumlah_upr    = [];
        $total_per_jum_lahan[] = [];
        $total_luas_lahan = [];
        foreach($data_list[0] as $row): ?>
        <tr style="line-height:2">
            <td style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;"><?= $no ?></td>
            <td style="border: 1px solid #000;"><?= xss_echo($row->nama_kecamatan) ?></td>

            <?php $jum_upr_ar = []; foreach($data_list[1] as $rv): 
                $jum_upr = !empty($ar_nilai[$row->id.'_'.$rv->komoditas_id]->jumlah_upr)?$ar_nilai[$row->id.'_'.$rv->komoditas_id]->jumlah_upr:'0';
                $jum_upr_ar[] = $jum_upr;
                $total_per_jum_upr[$rv->komoditas_id][] = $jum_upr;
            ?>
                <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= $jum_upr ?></td> 
            <?php endforeach ?>
                <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= $total_jumlah_upr[] = array_sum($jum_upr_ar) ?></td>

            <?php $luas_lahan_ar = []; foreach($data_list[1] as $rv): 
            $luas_lahan = !empty($ar_nilai[$row->id.'_'.$rv->komoditas_id]->luas_lahan)?$ar_nilai[$row->id.'_'.$rv->komoditas_id]->luas_lahan:'0';
            $luas_lahan_ar[] = $luas_lahan;
            $total_per_jum_lahan[$rv->komoditas_id][] = $luas_lahan;
            ?>
                <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= $luas_lahan ?></td> 
            <?php endforeach ?>
                <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?= $total_luas_lahan[] = array_sum($luas_lahan_ar) ?></td>
        </tr>
    <?php $no++; endforeach ?>

        <tr>
        <td colspan="2" style="border: 1px solid #000;text-align:center;vertical-align: center; vertical-align: middle;">JUMLAH</td>
        <?php foreach($data_list[1] as $rv): ?>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  array_sum($total_per_jum_upr[$rv->komoditas_id]) ?></td> 
        <?php endforeach ?>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  array_sum($total_jumlah_upr) ?></td> 
        <?php foreach($data_list[1] as $rv): ?>
            <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  array_sum($total_per_jum_lahan[$rv->komoditas_id]) ?></td> 
        <?php endforeach ?>
        <td style="border: 1px solid #000;text-align:right;vertical-align: right; vertical-align: middle;"><?=  array_sum($total_luas_lahan) ?></td> 
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