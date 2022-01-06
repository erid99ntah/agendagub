<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//untuk mengetahui bulan bulan
if ( ! function_exists('bulan')) {
  function bulan($bln) {
    switch ($bln) {
			case '01':
				return "Januari";
				break;
			case '02':
				return "Februari";
				break;
			case '03':
				return "Maret";
				break;
			case '04':
				return "April";
				break;
			case '05':
				return "Mei";
				break;
			case '06':
				return "Juni";
				break;
			case '07':
				return "Juli";
				break;
			case '08':
				return "Agustus";
				break;
			case '09':
				return "September";
				break;
			case '10':
				return "Oktober";
				break;
			case '11':
				return "November";
				break;
			case '12':
				return "Desember";
				break;
		}
  }
}

//untuk mengetahui bulan bulan
if ( ! function_exists('nama_bulan')) {
  function nama_bulan($bln) {
    switch ($bln) {
			case 'januari':
				return 1;
				break;
			case 'februari':
				return 2;
				break;
			case 'maret':
				return 3;
				break;
			case 'april':
				return 4;
				break;
			case 'mei':
				return 5;
				break;
			case 'juni':
				return 6;
				break;
			case 'juli':
				return 7;
				break;
			case 'agustus':
				return 8;
				break;
			case 'september':
				return 9;
				break;
			case '10':
				return "oktober";
				break;
			case 'november':
				return 11;
				break;
			case 'desember':
				return 12;
				break;
      default:
        return 0;
        break;
		}
  }
}

//untuk mengetahui bulan bulan
if ( ! function_exists('bulan_romawi')) {
  function bulan_romawi($bln) {
    switch ($bln) {
			case '1':
				return "I";
				break;
			case '2':
				return "II";
				break;
			case '3':
				return "III";
				break;
			case '4':
				return "IV";
				break;
			case '5':
				return "V";
				break;
			case '6':
				return "VI";
				break;
			case '7':
				return "VII";
				break;
			case '8':
				return "VIII";
				break;
			case '9':
				return "IX";
				break;
			case '10':
				return "X";
				break;
			case '11':
				return "XI";
				break;
			case '12':
				return "XII";
				break;
		}
  }
}

//untuk mengetahui hari
if ( ! function_exists('hari')) {
  function hari($tanggal) {
		$hari = date('D', strtotime($tanggal));
		switch($hari) {
			case 'Sun':
				return "Minggu";
				break;
			case 'Mon':
				return "Senin";
				break;
			case 'Tue':
				return "Selasa";
				break;
			case 'Wed':
				return "Rabu";
				break;
			case 'Thu':
				return "Kamis";
				break;
			case 'Fri':
				return "Jumat";
				break;
			case 'Sat':
				return "Sabtu";
				break;
			case 'Sunday':
				return "Minggu";
				break;
			case 'Monday':
				return "Senin";
				break;
			case 'Tuesday':
				return "Selasa";
				break;
			case 'Wednesday':
				return "Rabu";
				break;
			case 'Thursday':
				return "Kamis";
				break;
			case 'Friday':
				return "Jumat";
				break;
			case 'Saturday':
				return "Sabtu";
				break;
    }
	}
}

//format tanggal Y-m-d
if ( ! function_exists('tgl_indo')) {
  function tgl_indo($datenow) {
    $newdate = gmdate($datenow, time()+60*60*8);
    $arrDate = explode('-', $newdate);
    return $arrDate[2].' '.bulan($arrDate[1]).' '.$arrDate[0]; //hasil akhir
  }
}

//format tanggal Y-m-d H:i:s
if ( ! function_exists('tgl_indo_time')) {
  function tgl_indo_time($datenow) {
    $dateTime = explode(' ', $datenow);
		$newDate  = explode('-', $dateTime[0]);
	  $formatDate = $newDate[2].' '.bulan($newDate[1]).' '.$newDate[0].' '.$dateTime[1];
	  return $formatDate;
  }
}

//format tanggal timestamp
if( ! function_exists('tgl_indo_timestamp')) {
	function tgl_indo_timestamp($datenow) {
    $dateTime 	= explode(' ', $datenow);
    $newDate	  = explode('-', $dateTime[0]);
    $formatDate = $newDate[2].' '.bulan($newDate[1]).' '.$newDate[0].' | '.$dateTime[1]; //hasil akhir tanggal
    return $formatDate;
	}
}

//format tanggal login
if( ! function_exists('tgl_login')) {
	function tgl_login($datenow) {
    $dateTime 	= explode(' ', $datenow);
    $newDate	  = explode('-', $dateTime[0]);
	  $formatDate = hari($dateTime[0]).', '.$newDate[2].' '.bulan($newDate[1]).' '.$newDate[0].' '.$dateTime[1]; //hasil akhir tanggal
	  return $formatDate;
	}
}

//format tanggal tanpa jam
if( ! function_exists('tgl_surat')) {
	function tgl_surat($datenow) {
    $dateTime 	= explode(' ', $datenow);
    $newDate	  = explode('-', $dateTime[0]);
	  $formatDate = hari($dateTime[0]).', '.$newDate[2].' '.bulan($newDate[1]).' '.$newDate[0]; //hasil akhir tanggal
	  return $formatDate;
	}
}

//format tanggal tanpa jam
if( ! function_exists('urutkan_array')) {
	function urutkan_array($bilangan) {
		$arr 	= array();
		$di 	= explode(',', $bilangan);
    $ni 	= count($di);
    for ($i=0; $i < $ni; $i++) {
      if($di[$i] != "" && $di[$i] != 0)
        array_push($arr, $di[$i]);
    }
    $clear = array_unique($arr);
    sort($clear);
    return $clear;
	}
}

//format tanggal tanpa jam
if( ! function_exists('implode_array')) {
  function implode_array($glue, $arr) {
    for ($i=0; $i<count($arr); $i++) {
      if (@is_array($arr[$i]))
        $arr[$i] = implode_array ($glue, $arr[$i]);
    }
    return implode($glue, $arr);
  }
}

//conert tgl dari d/m/Y menjadi Y-m-d
if (!function_exists('date_convert')) {
  function date_convert($date) {
    $newdate = str_replace('/','-', $date);
    $newdate = date('Y-m-d', strtotime($newdate));
    return $newdate;
  }
}
