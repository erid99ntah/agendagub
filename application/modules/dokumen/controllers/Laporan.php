<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of laporan
 *
 * @author kominfo
 */

class Laporan extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_laporan' => 'mlap', 'master/model_master' => 'mmas'));
  }

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Master', '#');
		$this->breadcrumb->add('Cetak Agenda', '#');

		$this->session_info['page_name'] = "Data Agenda";
		$this->session_info['data_penerima'] = $this->mlap->getDataPenerimaNew();
		$this->template->build('form_laporan/vlist', $this->session_info);
	}

	public function export()
	{
		if($this->input->post('save', TRUE))
	      $this->export_data();
	    else
	      $this->index();
	}

	private function export_data()
	{
		$tanggal 	  = escape($this->input->post('tanggal', TRUE));
		$jenis_agenda = escape($this->input->post('jenis_agenda', TRUE));
		$jenis_dokumen = escape($this->input->post('jenis_dokumen', TRUE));
		$penerima = escape($this->input->post('penerima', TRUE));

		$cek = $this->mlap->cekAgenda($tanggal, $jenis_agenda, $penerima);

		if ($this->mlap->validasiDataValue()==FALSE) 
		{
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      	    $this->index();
		}
		elseif ($cek <=0) 
		{
			error_message('danger', 'Peringatan!', 'Data '.tgl_indo($tanggal).' kosong...');
      	    $this->index();
		}else{
			if ($jenis_dokumen=='pdf')
				$this->export_to_pdf($tanggal, $jenis_agenda, $penerima);
			else
				$this->export_to_word($tanggal, $jenis_agenda, $penerima);
		}


	}

	public function export_to_word($tanggal, $jenis_agenda, $penerima)
	{
		require APPPATH . 'third_party/php_word/vendor/autoload.php';
		//get data
		$dataAgenda = $this->mlap->getDataAgenda($tanggal, $jenis_agenda, $penerima);
		$nama = $this->mlap->getNamaUserByToken($penerima);

		//set template
		$template = 'repository/template/agenda_report.docx';
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template);
		$templateProcessor->setValue('title', 'Daftar Agenda '.$nama.' Tanggal : '.tgl_indo($tanggal).' ');
		$no = 1;
		$templateProcessor->cloneRow('no', (count($dataAgenda) > 0) ? count($dataAgenda) : 1);
		if(count($dataAgenda) > 0) {
			foreach ($dataAgenda as $key => $dh) {
				$templateProcessor->setValue('no#'.$no, $no);
				$templateProcessor->setValue('nama_agenda#'.$no, $dh['nama_agenda']);
				$templateProcessor->setValue('jam_mulai#'.$no, $dh['jam_mulai']);
				$templateProcessor->setValue('jam_selesai#'.$no, $dh['jam_selesai']);
				$templateProcessor->setValue('kegiatan#'.$no, $dh['kegiatan']);
				$templateProcessor->setValue('lokasi_kegiatan#'.$no, $dh['lokasi_kegiatan']);
				$templateProcessor->setValue('keterangan#'.$no, $dh['keterangan']);
				$no++;
			}
		} else {
			$templateProcessor->setValue('no#'.$no, $no);
			$templateProcessor->setValue('nama_agenda#'.$no, '');
			$templateProcessor->setValue('jam_mulai#'.$no, '');
			$templateProcessor->setValue('jam_selesai#'.$no, '');
			$templateProcessor->setValue('kegiatan#'.$no, '');
			$templateProcessor->setValue('lokasi_kegiatan#'.$no, '');
			$templateProcessor->setValue('keterangan#'.$no, '');
		}
		$file = 'daftar_agenda_'.$tanggal.'.docx';
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

	public function export_to_pdf($tanggal, $jenis_agenda, $penerima)
	{
		//get data

		$dataAgenda = $this->mlap->getDataAgenda($tanggal, $jenis_agenda, $penerima);
		$nama = $this->mlap->getNamaUserByToken($penerima);
		$title = 'Daftar Agenda '.$nama.' Tanggal : '.tgl_indo($tanggal).' ';
		//set pdf
		$pdf = new pdf();
		//set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Diskominfo Pemprov Sumatera Barat');
		$pdf->SetTitle('Daftar Agenda');
		$pdf->SetSubject('Daftar Agenda Pimpinan');
		$pdf->SetKeywords('Agenda, Diskominfo, Sumbar');
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
								<td style="width:5%;" align="center"><b>No.</b></td>
								<td style="width:20%;" align="center"><b>NAMA AGENDA</b></td>
								<td style="width:10%;" align="center"><b>JAM MULAI</b></td>
								<td style="width:10%;" align="center"><b>JAM SELESAI</b></td>
								<td style="width:20%;" align="center"><b>KEGIATAN</b></td>
								<td style="width:15%;" align="center"><b>LOKASI KEGIATAN</b></td>
								<td style="width:15%;" align="center"><b>KETERANGAN</b></td>
							</tr>';
		$no_urut = 1;
		if(count($dataAgenda) > 0) {
			foreach ($dataAgenda as $key => $dh) {
				$html .= '<tr>';
					$html .= '<td style="width:5%;text-align:center;">'.$no_urut.'.</td>';
					$html .= '<td style="width:20%;text-align:center;">'.$dh['nama_agenda'].'</td>';
					$html .= '<td style="width:10%;">'.$dh['jam_mulai'].'</td>';
					$html .= '<td style="width:10%;">'.$dh['jam_selesai'].'</td>';
					$html .= '<td style="width:20%;">'.$dh['kegiatan'].'</td>';
					$html .= '<td style="width:15%;">'.$dh['lokasi_kegiatan'].'</td>';
					$html .= '<td style="width:15%;">'.$dh['keterangan'].'</td>';
					
				$html .= '</tr>';
				$no_urut++;
			}
		} else {
			$html .= '<tr>';
				$html .= '<td style="width:5%;">1.</td>';
				$html .= '<td style="width:20%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
				$html .= '<td style="width:10%;">&nbsp;</td>';
				$html .= '<td style="width:20%;">&nbsp;</td>';
				$html .= '<td style="width:15%;">&nbsp;</td>';
				$html .= '<td style="width:15%;">&nbsp;</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		$pdf->writeHTMLCell(0, 0, 10, '', $html, 0, 0, 0, true, 'L', true);
		$pdf->lastPage();
		//---------------------------------------------------------
		//Close and output PDF document
		$pdf->Output('daftar_agenda_'.$tanggal.'.pdf','D');
		//---------------------------------------------------------
	}

	

}

// This is the end of home clas
