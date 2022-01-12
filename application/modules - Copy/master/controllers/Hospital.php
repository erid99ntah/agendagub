<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yogi "solop" Kaputra
 */

class Hospital extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_hospital' => 'mrs', 'model_master' => 'mmas'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Master', '#');
		$this->breadcrumb->add('Fasilitas Layanan Kesehatan', '#');

		$this->session_info['page_name'] = "Data Fasyankes";
    $this->session_info['province']  = $this->mmas->getDataProvince();
    $this->template->build('form_hospital/vlist', $this->session_info);
	}

	public function listview()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$data = array();
			$session = $this->app_loader->current_account();
			if(isset($session)){
				$param = $this->input->post('param',TRUE);
		    $dataList = $this->mrs->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
	        $row = array();
	        $row[] = $no;
					$row[] = $dl['kode_fasyankes'];
					$row[] = $dl['fullname'];
					$row[] = provinsi($dl['id_province']);
					$row[] = regency($dl['id_regency']);
					$row[] = ($dl['flag'] == 1) ? 'RS Rujukan Pemerintah' : 'RS Daerah';
					$row[] = convert_status($dl['status']);
	        $row[] = '<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="'.$this->encryption->encrypt($dl['id_rs']).'" title="Edit data fasyankes"><i class="fa fa-pencil"></i> </button>
										<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="'.$this->encryption->encrypt($dl['id_rs']).'" title="Delete data fasyankes"><i class="fa fa-times"></i> </button>';
	        $data[] = $row;
				}

				$output = array(
	        "draw" => $this->input->post('draw'),
	        "recordsTotal" => $this->mrs->count_all(),
	        "recordsFiltered" => $this->mrs->count_filtered($param),
	        "data" => $data,
	      );
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}

	public function create()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if(!empty($session)) {
				if($this->mrs->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mrs->insertDataHospital();
					if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses input data <b>'.$data['nama'].'</b> dengan kode <b>'.$data['kode'].'</b> gagal, karena sudah ada fasilitas layanan kesehatan yang terdaftar dengan kode tersebut...'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data fasilitas layanan kesehatan <b>'.$data['nama'].'</b> dengan kode <b>'.$data['kode'].'</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input data fasilitas layanan kesehatan gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function details()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_rs  	= $this->input->post('token', TRUE);
			if(!empty($id_rs) AND !empty($session)) {
				$data = $this->mrs->getDataDetailHospital($this->encryption->decrypt($id_rs));
				$row = array();
				$row['kode'] 			= !empty($data) ? $data['kode_fasyankes'] : '';
				$row['fullname']	= !empty($data) ? $data['fullname'] : '';
				$row['shortname']	= !empty($data) ? $data['shortname'] : '';
				$row['province']	= !empty($data) ? $data['id_province'] : '';
				$row['regency']		= !empty($data) ? $data['id_regency'] : '';
				$row['district']	= !empty($data) ? $data['id_district'] : '';
				$row['village']		= !empty($data) ? $data['id_village'] : '';
				$row['address']		= !empty($data) ? $data['address'] : '';
				$row['phone']			= !empty($data) ? $data['phone'] : '';
				$row['tipe'] 			= !empty($data) ? $data['tipe_fasyankes'] : '';
				$row['flag']			= !empty($data) ? $data['flag'] : '';
				$row['status']		= !empty($data) ? $data['status'] : 1;
				$result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function update()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_rs 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($id_rs)) {
				if($this->mrs->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mrs->updateDataHospital();
					if($data['message'] == 'NODATA') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses update data layanan fasilitas kesehatan gagal, data yang akan diupdate tidak ditemukan. Mohon diperiksa kembali data yang akan diupdate...'), 'csrfHash' => $csrfHash);
					}	else if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses update data <b>'.$data['nama'].'</b> dengan kode <b>'.$data['kode'].'</b> gagal, karena sudah ada fasilitas layanan kesehatan yang terdaftar dengan kode tersebut...'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data fasilitas layanan kesehatan <b>'.$data['nama'].'</b> dengan kode <b>'.$data['kode'].'</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data fasilitas layanan kesehatan gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$id_rs 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($id_rs)) {
				$data = $this->mrs->deleteDataHospital();
				if($data['message'] == 'ERROR') {
					$result = array('status' => 0, 'message' => 'Proses delete data fasilitas layanan kesehatan gagal dikarenakan data tidak ditemukan...', 'csrfHash' => $csrfHash);
				}	else if($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data fasilitas layanan kesehatan <b>'.$data['nama'].'</b> dengan kode <b>'.$data['kode'].'</b> telah didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses delete data fasilitas layanan kesehatan gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function export_to_word()
	{
		require APPPATH . 'third_party/php_word/vendor/autoload.php';
		//get data
		$province	= escape($this->input->get('provinsi', TRUE));
		$regency	= escape($this->input->get('daerah', TRUE));
		$flag			= escape($this->input->get('type', TRUE));
		$status		= escape($this->input->get('status', TRUE));
		$dataHospital = $this->mrs->getDataListHospitalReport($province, $regency, $flag, $status);
		$note = ($regency != '') ? ' DI '.regency($regency).' PROVINSI '.provinsi($province) : (($province != '') ? ' DI PROVINSI '.provinsi($province) : '');
		//set template
		$template = 'repository/template/fasyankes_report.docx';
	  $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template);
	  $templateProcessor->setValue('title', 'DAFTAR FASILITAS LAYANAN KESEHATAN'.(($flag == 1) ? ' RUJUKAN PEMERINTAH' : '').$note);
    $no = 1;
		$templateProcessor->cloneRow('no', (count($dataHospital) > 0) ? count($dataHospital) : 1);
		if(count($dataHospital) > 0) {
			foreach ($dataHospital as $key => $dh) {
				$templateProcessor->setValue('no#'.$no, $no);
				$templateProcessor->setValue('kode#'.$no, $dh['kode_fasyankes']);
				$templateProcessor->setValue('nama#'.$no, $dh['fullname']);
				$templateProcessor->setValue('provinsi#'.$no, provinsi($dh['id_province']));
				$templateProcessor->setValue('daerah#'.$no, regency($dh['id_regency']));
				$templateProcessor->setValue('kecamatan#'.$no, district($dh['id_district']));
				$templateProcessor->setValue('kelurahan#'.$no, village($dh['id_village']));
				$templateProcessor->setValue('alamat#'.$no, $dh['address']);
				$templateProcessor->setValue('telp#'.$no, $dh['phone']);
	      $no++;
	    }
		} else {
			$templateProcessor->setValue('no#'.$no, $no);
			$templateProcessor->setValue('kode#'.$no, '');
			$templateProcessor->setValue('nama#'.$no, '');
			$templateProcessor->setValue('provinsi#'.$no, '');
			$templateProcessor->setValue('daerah#'.$no, '');
			$templateProcessor->setValue('kecamatan#'.$no, '');
			$templateProcessor->setValue('kelurahan#'.$no, '');
			$templateProcessor->setValue('alamat#'.$no, '');
			$templateProcessor->setValue('telp#'.$no, '');
		}
    $file = 'daftar_fasyankes_report.docx';
    $templateProcessor->saveAs($file);
    if(!$file)
      die('File not found');
    else {
      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=$file");
      header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
      header("Content-Transfer-Encoding: binary");
      readfile($file);
    }
    unlink($file);
	}

	public function export_to_excel()
	{
		require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$template  = 'repository/template/fasyankes_report.xls';
		$objPHPExcel = $objReader->load($template);
		//get data
		$province	= escape($this->input->get('provinsi', TRUE));
		$regency	= escape($this->input->get('daerah', TRUE));
		$flag			= escape($this->input->get('type', TRUE));
		$status		= escape($this->input->get('status', TRUE));
		$dataHospital = $this->mrs->getDataListHospitalReport($province, $regency, $flag, $status);
		$note = ($regency != '') ? ' DI '.regency($regency).' PROVINSI '.provinsi($province) : (($province != '') ? ' DI PROVINSI '.provinsi($province) : '');
		//set title
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DAFTAR FASILITAS LAYANAN KESEHATAN'.(($flag == 1) ? ' RUJUKAN PEMERINTAH' : '').$note);
		//set data hospital
		$noRow = 0;
		$baseRow = 6;
		if(count($dataHospital) > 0) {
			foreach ($dataHospital as $key => $dh) {
				$noRow++;
				$row = $baseRow + $noRow;
				$objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row,1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $noRow);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $dh['kode_fasyankes']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $dh['fullname']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, provinsi($dh['id_province']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, regency($dh['id_regency']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, district($dh['id_district']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, village($dh['id_village']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $dh['address']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, $dh['phone']);
			}
		} else {
			$row = $baseRow + 1;
			$objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row,1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, 1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, '');
		}
		$objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow,1);
		$file	= 'daftar_fasyankes_report.xlsx';
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=$file");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	public function export_to_pdf()
	{
		//get data
		$province	= escape($this->input->get('provinsi', TRUE));
		$regency	= escape($this->input->get('daerah', TRUE));
		$flag			= escape($this->input->get('type', TRUE));
		$status		= escape($this->input->get('status', TRUE));
		$dataHospital = $this->mrs->getDataListHospitalReport($province, $regency, $flag, $status);
		$note = ($regency != '') ? ' DI '.regency($regency).' PROVINSI '.provinsi($province) : (($province != '') ? ' DI PROVINSI '.provinsi($province) : '');
		$title = 'DAFTAR FASILITAS LAYANAN KESEHATAN'.(($flag == 1) ? ' RUJUKAN PEMERINTAH' : '').$note;
		//set pdf
		$pdf = new pdf();
		//set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Diskominfo Pemprov Sumatera Barat');
		$pdf->SetTitle('Daftar Fasilitas Layanan Kesehatan');
		$pdf->SetSubject('List Fasyankes');
		$pdf->SetKeywords('Fasyankes, Diskominfo, Sumbar');
		//remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		//set margins
		$pdf->SetMargins(5, 10, 5);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
		//set default font subsetting mode
		$pdf->setFontSubsetting(true);
		//Set font
		$pdf->SetAutoPageBreak(TRUE, 3);
		//Add a page
		$pdf->AddPage('L', 'F4');
		$pdf->SetFont('times', '', 11);
		$pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-indent: 0.3in;text-align: center;">'.$title.'</p>', 0, 0, 0, true, 'L', true);
		$pdf->ln(12);
		$html = '<table width="100%" border="1" cellspacing="0" cellpadding="3">
							<tr>
								<td style="width:3%;" align="center"><b>No.</b></td>
								<td style="width:9%;" align="center"><b>KODE FASYANKES</b></td>
								<td style="width:25%;" align="center"><b>NAMA FASYANKES</b></td>
								<td style="width:12%;" align="center"><b>PROVINSI</b></td>
								<td style="width:10%;" align="center"><b>KAB/KOTA</b></td>
								<td style="width:10%;" align="center"><b>KECAMATAN</b></td>
								<td style="width:10%;" align="center"><b>KELURAHAN</b></td>
								<td style="width:11%;" align="center"><b>ALAMAT</b></td>
								<td style="width:10%;" align="center"><b>TELP</b></td>
							</tr>';
		$no_urut = 1;
		if(count($dataHospital) > 0) {
			foreach ($dataHospital as $key => $dh) {
				$html .= '<tr>';
					$html .= '<td style="width:3%;text-align:center;">'.$no_urut.'.</td>';
					$html .= '<td style="width:9%;text-align:center;">'.$dh['kode_fasyankes'].'</td>';
					$html .= '<td style="width:25%;">'.$dh['fullname'].'</td>';
					$html .= '<td style="width:12%;">'.provinsi($dh['id_province']).'</td>';
					$html .= '<td style="width:10%;">'.regency($dh['id_regency']).'</td>';
					$html .= '<td style="width:10%;">'.district($dh['id_district']).'</td>';
					$html .= '<td style="width:10%;">'.village($dh['id_village']).'</td>';
					$html .= '<td style="width:11%;">'.$dh['address'].'</td>';
					$html .= '<td style="width:10%;">'.$dh['phone'].'</td>';
				$html .= '</tr>';
				$no_urut++;
			}
		} else {
			$html .= '<tr>';
				$html .= '<td style="width:3%;">1.</td>';
				$html .= '<td style="width:9%;">&nbsp;</td>';
				$html .= '<td style="width:25%;">&nbsp;</td>';
				$html .= '<td style="width:12%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
				$html .= '<td style="width:11%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		$pdf->writeHTMLCell(0, 0, 10, '', $html, 0, 0, 0, true, 'L', true);
		$pdf->lastPage();
		//---------------------------------------------------------
		//Close and output PDF document
		$pdf->Output('daftar_fasyankes_report.pdf','D');
		//---------------------------------------------------------
	}

	//get data kab/kota
  public function regency()
  {
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$province = $this->input->get('province', TRUE);
			if(!empty($province)AND !empty($session)) {
				$data = $this->mmas->getDataRegencyByProvince($province);
				if(count($data) > 0) {
					$row = array();
					foreach ($data as $key => $val) {
						$row['id'] 		= $val['id'];
						$row['text']	= ($val['status'] == 1) ? "KAB ".$val['name'] : $val['name'];
						$hasil[] = $row;
					}
					$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
				} else
					$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
  }

  //get data kecamatan
  public function district()
  {
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$regency = $this->input->get('regency', TRUE);
			if(!empty($regency)AND !empty($session)) {
				$data = $this->mmas->getDataDistrictByRegency($regency);
				if(count($data) > 0) {
					$row = array();
					foreach ($data as $key => $val) {
						$row['id'] 		= $val['id'];
						$row['text']	= $val['name'];
						$hasil[] = $row;
					}
					$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
				} else
					$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
  }

  //get data Kelurahan/desa/nagari
  public function village()
  {
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$district = $this->input->get('district', TRUE);
			if(!empty($district)AND !empty($session)) {
				$data = $this->mmas->getDataVillageByDistrict($district);
				if(count($data) > 0) {
					$row = array();
					foreach ($data as $key => $val) {
						$row['id'] 		= $val['id'];
						$row['text']	= $val['name'];
						$hasil[] = $row;
					}
					$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
				} else
					$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
  }

}

// This is the end of home clas
