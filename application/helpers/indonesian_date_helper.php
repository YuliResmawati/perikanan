<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('bulan'))
{
	function bulan($bln)
	{
		switch ($bln)
		{
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

if (!function_exists('indo_date'))
{
	function indo_date($tgl)
	{
		$tgl = date('Y-m-d', strtotime($tgl));
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}

if (!function_exists('format_indo')) {
	function format_indo($date , $day){
		if(!empty($date)){
			date_default_timezone_set('Asia/Jakarta');

			$Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			
			$tahun = substr($date,0,4);
			$bulan = substr($date,5,2);
			$tgl = substr($date,8,2);
			$waktu = substr($date,11,5);
			$hari = date("w",strtotime($date));

			if ($day == 'YES') {
				$result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
			} else {
				$result = $tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
			}
		}else{
			$result = '<h6><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-alarm-off"></i> Belum ada</span></h6>';
		}
  
	  return $result;
	}
}